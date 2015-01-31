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
class muusla_toolsViewinvoices extends JViewLegacy
{
   function display($tpl = null) {
      $document = JFactory::getDocument();
      $document->setName('MUUSA Invoices');

      $model = $this->getModel();
      $user = JFactory::getUser();
      $this->assignRef('year', $model->getYear());
      $letters = $this->getSafe(JRequest::getVar("letters"));
      if($letters != "" && (in_array("8", $user->groups) || in_array("10", $user->groups))) {
         if($letters == "all") {
            $this->assignRef('letters', $model->getLetters("ORDER BY name, statecd, city"));
         } else if($letters == "last") {
            $this->assignRef('letters', $model->getLetters("ORDER BY name, statecd, city LIMIT " . $this->getSafe(JRequest::getVar("lastX")) . ", 9"));
         } else if($letters == "camper") {
            $this->assignRef('letters', $model->getLetters("WHERE id=" . $this->getSafe(JRequest::getVar("camperid"))));
         } else {
            echo "No Letters to Print!";
         }
      } else {
         $this->assignRef('letters', $model->getLetters("WHERE id=(SELECT familyid FROM muusa_camper WHERE email='$user->email')"));
      }
      $workshops = $model->getWorkshops();
      $found[][] = array();
      foreach($model->getAttendees() as $attendee) {
         if($this->noConflict($found[$workshops[$attendee->workshopid]["starttime"]][$attendee->id], $workshops[$attendee->workshopid]["days"])) {
            if($workshops[$attendee->workshopid]["attendees"] == null) {
               $workshops[$attendee->workshopid]["attendees"] = array($attendee);
               $found[$workshops[$attendee->workshopid]["starttime"]][$attendee->id] = $this->orDays($found[$workshops[$attendee->workshopid]["starttime"]][$attendee->id], $workshops[$attendee->workshopid]["days"]);
            } elseif ($workshops[$attendee->workshopid]["capacity"] == 0 || count($workshops[$attendee->workshopid]["attendees"]) < $workshops[$attendee->workshopid]["capacity"]) {
               array_push($workshops[$attendee->workshopid]["attendees"], $attendee);
               $found[$workshops[$attendee->workshopid]["starttime"]][$attendee->id] = $this->orDays($found[$workshops[$attendee->workshopid]["starttime"]][$attendee->id], $workshops[$attendee->workshopid]["days"]);
            } elseif($workshops[$attendee->workshopid]["waitlist"] == null) {
               $workshops[$attendee->workshopid]["waitlist"] = array($attendee);
            } else {
               array_push($workshops[$attendee->workshopid]["waitlist"], $attendee);
            }
         }
      }
      $this->assignRef('workshops', $workshops);
      parent::display($tpl);
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
