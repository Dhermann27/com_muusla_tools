<?php
/**
 * @package		muusla_tools
 * @license		GNU/GPL, see LICENSE.php
 */

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the muusla_tools Component
 *
 * @package		muusla_tools
 */
class muusla_toolsViewletters extends JView
{
   function display($tpl = null) {
      parent::display($tpl);
   }

   function detail($tpl = null) {
      $model =& $this->getModel();
      $campers = $model->getCampers($this->getSafe("camper"));
      foreach($model->getChildren() as $child) {
         if($campers[$child->familyid]["children"] == null) {
            $campers[$child->familyid]["children"] = array($child);
         } else {
            array_push($campers[$child->familyid]["children"], $child);
         }
      }
      foreach($model->getRoommates() as $roommate) {
         if($campers[$roommate->familyid]["roommate"] == null) {
            $campers[$roommate->familyid]["roommate"] = array($roommate);
         } else {
            array_push($campers[$roommate->familyid]["roommate"], $roommate);
         }
      }
      foreach($model->getCharges() as $charge) {
         if($campers[$charge->familyid]["charges"] == null) {
            $campers[$charge->familyid]["charges"] = array($charge);
            $campers[$charge->familyid]["totallater"] = (float)preg_replace("/,/", "",  $charge->amount);
            if($charge->chargetypeid != 1000 && $charge->chargetypeid != 1011) {
               $campers[$charge->familyid]["totalnow"] = (float)preg_replace("/,/", "",  $charge->amount);
            } else {
               $campers[$charge->familyid]["totalnow"] = 0;
            }
         } else {
            array_push($campers[$charge->familyid]["charges"], $charge);
            $campers[$charge->familyid]["totallater"] += (float)preg_replace("/,/", "",  $charge->amount);
            if($charge->chargetypeid != 1000 && $charge->chargetypeid != 1011) {
               $campers[$charge->familyid]["totalnow"] += (float)preg_replace("/,/", "",  $charge->amount);
            }
         }
      }
      foreach($model->getCredits() as $credit) {
         $campers[$credit->familyid]["totalnow"] -= (float)preg_replace("/,/", "",  $credit->registration_amount);
         $credit->amount = number_format(-($credit->housing_amount + $credit->registration_amount), 2, ".", "");
         array_push($campers[$credit->familyid]["charges"], $credit);
         $campers[$credit->familyid]["totallater"] += (float)$credit->amount;
      }
      foreach($model->getScholarships() as $credit) {
         $campers[$credit->familyid]["totalnow"] -= (float)preg_replace("/,/", "",  $credit->registration_amount);
         $credit->amount = number_format(-($credit->housing_amount + $credit->registration_amount), 2, ".", "");
         array_push($campers[$credit->familyid]["charges"], $credit);
         $campers[$credit->familyid]["totallater"] += (float)$credit->amount;
      }
      foreach($model->getVolunteers() as $volunteer) {
         if($campers[$volunteer->familyid]["volunteers"] == null) {
            $campers[$volunteer->familyid]["volunteers"] = array($volunteer);
         } else {
            array_push($campers[$volunteer->familyid]["volunteers"], $volunteer);
         }
      }
      $workshops = $model->getWorkshops();
      $found[][] = array();
      foreach($model->getAttendees() as $attendee) {
         if($this->noConflict($found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid], $workshops[$attendee->eventid]["days"])) {
            if($workshops[$attendee->eventid]["attendees"] == null) {
               $workshops[$attendee->eventid]["attendees"] = array($attendee);
               $found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid] = $this->orDays($found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid], $workshops[$attendee->eventid]["days"]);
               if($campers[$attendee->familyid]["attendees"] == null) {
                  $campers[$attendee->familyid]["attendees"] = array($attendee);
               } else {
                  array_push($campers[$attendee->familyid]["attendees"], $attendee);
               }
            } elseif ($workshops[$attendee->eventid]["capacity"] == 0 || count($workshops[$attendee->eventid]["attendees"]) < $workshops[$attendee->eventid]["capacity"]) {
               array_push($workshops[$attendee->eventid]["attendees"], $attendee);
               $found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid] = $this->orDays($found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid], $workshops[$attendee->eventid]["days"]);
               if($campers[$attendee->familyid]["attendees"] == null) {
                  $campers[$attendee->familyid]["attendees"] = array($attendee);
               } else {
                  array_push($campers[$attendee->familyid]["attendees"], $attendee);
               }
            } elseif($campers[$attendee->familyid]["attendees"] == null) {
               $attendee->waitlist = "Waiting List";
               $campers[$attendee->familyid]["attendees"] = array($attendee);
            } else {
               $attendee->waitlist = "Waiting List";
               array_push($campers[$attendee->familyid]["attendees"], $attendee);
            }
         }
      }

      header("Pragma: public");
      header("Expires: 0"); // set expiration time
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");

      header("Content-Disposition: attachment; filename=confirmationletterdata.csv;");

      header("Content-Transfer-Encoding: binary");
      echo "Familyname,Address1,Address2,City,State,Zip";
      for($i=1; $i<7; $i++) {
         echo ",Childfirstname$i,Childlastname$i,Childemail$i,Childbuilding$i,Childroom$i,Childprogram$i";
      }
      for($i=1; $i<4; $i++) {
         echo ",Roommate$i";
      }
      for($i=1; $i<30; $i++) {
         echo ",Chargename$i,Chargeamount$i,Chargememo$i";
      }
      echo ",totalnow,totallater";
      for($i=1; $i<10; $i++) {
         echo ",Volunteername$i,Volunteerposition$i";
      }
      for($i=1; $i<12; $i++) {
         echo ",Workshopperson$i,Workshopname$i,Workshoptime$i,Workshopwaitinglist$i";
      }
      echo "\n";

      foreach ($campers as $familyid=>$camper) {
         if($camper["familyname"] == "") {
            continue;
         } else {
            $familyname = preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["familyname"]));
            if(count($camper["children"]) > 1) {
               $familyname = "The " . $familyname . " Family";
            }
         }
         echo $familyname . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["address1"])) . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["address2"])) . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["city"])) . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["statecd"])) . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["zipcd"]));
         for($i=1; $i<7; $i++) {
            if(count($camper["children"]) > 0) {
               $child = array_shift($camper["children"]);
               echo "," . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->firstname)) . ",";
               echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->lastname)) . ",";
               echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->email)) . ",";
               echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->buildingname)) . ",";
               echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->roomnbr)) . ",";
               echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->programname));
            } else {
               echo ",,,,,,";
            }
         }
         for($i=1; $i<4; $i++) {
            if(count($camper["roommate"]) > 0) {
               $roommate = array_shift($camper["roommate"]);
               echo ",";
               if($i == 1) {
                  echo "Current (non-family) roommates: ";
               }
               echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $roommate->fullname));
            } else {
               echo ",";
            }
         }
         for($i=1; $i<30; $i++) {
            if(count($camper["charges"]) > 0) {
               $charge = array_shift($camper["charges"]);
               if(strpos($charge->memo, "S8") === false) {
                  echo "," . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $charge->chargetypename)) . ",";
               } else {
                  echo ",Commuter Fees,";
               }
               echo "$" . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $charge->amount)) . ",";
               echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $charge->memo));
            } else {
               echo ",,,";
            }
         }
         echo "," . number_format(min(max(0,$camper["totalnow"]), $camper["totallater"]), 2, ".", "");
         echo "," . number_format($camper["totallater"], 2, ".", "");
         for($i=1; $i<10; $i++) {
            if(count($camper["volunteers"]) > 0) {
               $volunteer = array_shift($camper["volunteers"]);
               echo "," . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $volunteer->fullname));
               echo "," . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $volunteer->positionname));
            } else {
               echo ",,";
            }
         }
         for($i=1; $i<12; $i++) {
            if(count($camper["attendees"]) > 0) {
               $attendee = array_shift($camper["attendees"]);
               echo "," . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $attendee->fullname));
               echo "," . preg_replace("/^[A-Z]\d\d /", "", preg_replace("/&#039;/", "'", preg_replace("/,/", "", $attendee->workshopname)));
               echo "," . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $attendee->timename)) . " ($attendee->dispdays)";
               echo "," . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $attendee->waitlist));
            } else {
               echo ",,,,";
            }
         }
         echo "\n";
      }
      exit(0);
   }

   function getSafe($obj)
   {
      return htmlspecialchars(trim($obj), ENT_QUOTES);
   }

   function noConflict($a, $b) {
      for($i=0; $i<7; $i++) {
         if($a[$i] == "1" && $b[$i] == "1") return false;
      }
      return true;
   }

   function orDays($a, $b) {
      $ret = "";
      for($i=0; $i<7; $i++) {
         $ret .= ($a[$i] == "1" || $b[$i] == "1") ? "1" : "0";
      }
      return $ret;
   }
}
?>
