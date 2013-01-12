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
class muusla_toolsViewworkshops extends JView
{
	function display($tpl = null) {
		parent::display($tpl);
	}

	function detail($tpl = null) {
		$model =& $this->getModel();
		$workshops= $model->getWorkshops();
                $found[][] = array();
                foreach($model->getAttendees() as $attendee) {
                        if($this->noConflict($found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid], $workshops[$attendee->eventid]["days"])) {
                                if($workshops[$attendee->eventid]["attendees"] == null) {
                                        $workshops[$attendee->eventid]["attendees"] = array($attendee);
                                        $found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid] = $this->orDays($found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid], $workshops[$attendee->eventid]["days"]);
                                } elseif ($workshops[$attendee->eventid]["capacity"] == 0 || count($workshops[$attendee->eventid]["attendees"]) < $workshops[$attendee->eventid]["capacity"]) {
                                        array_push($workshops[$attendee->eventid]["attendees"], $attendee);
                                        $found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid] = $this->orDays($found[$workshops[$attendee->eventid]["starttime"]][$attendee->camperid], $workshops[$attendee->eventid]["days"]);
                                } elseif($workshops[$attendee->eventid]["waitlist"] == null) {
                                        $workshops[$attendee->eventid]["waitlist"] = array($attendee);
                                } else {
                                        array_push($workshops[$attendee->eventid]["waitlist"], $attendee);
                                }
                        }
                }

		header("Pragma: public");
		header("Expires: 0"); // set expiration time
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		header("Content-Disposition: attachment; filename=workshopsdata.csv;");

		header("Content-Transfer-Encoding: binary");

		echo "Eventname,Eventtime,Eventstart,Eventplace,Attendeename,Waitlist\n";

		$event = 0;
		foreach ($workshops as $eventid => $workshop) {
			if($event != $eventid) {
				for($i=0; $i<$count; $i++) {
					echo $prevname . ",,,,__________________________,\n";
				}
				if($workshop["capacity"] > 0 && $workshop["capacity"] != 999) {
					$count = $workshop["capacity"];
				} else {
					$count = 39;
				}
				$event = $eventid;
			}
			if(count($workshop['attendees']) > 0) {
				foreach($workshop['attendees'] as $attendee) {
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", ucwords(strtolower(preg_replace("/^\w\d\d /", "", $workshop["workshopname"]))))) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $workshop["timename"])) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $workshop["starttime"])) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $workshop["roomname"])) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $attendee->fullname)) . ",";
					if($attendee->is_leader == 1) {
						echo "lead";
					}
					echo "\n";
					$count--;
				}
			}
			if(count($workshop['waitlist']) > 0){
				foreach($workshop['waitlist'] as $attendee) {
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", ucwords(strtolower(substr($workshop["workshopname"], 4))))) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $workshop["timename"])) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $workshop["starttime"])) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $workshop["roomname"])) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $attendee->fullname)) . ",wait\n";
				}
			}
			$prevname = ucwords(strtolower(preg_replace("/^\w\d\d /", "", $workshop["workshopname"])));
		}
		exit(0);
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
