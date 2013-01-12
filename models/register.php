<?php
/**
 * muusla_database Model for muusla_database Component
 *
 * @package    muusla_database
 * @subpackage Components
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * muusla_database Model
 *
 * @package    muusla_database
 * @subpackage Components
 */
class muusla_toolsModelregister extends JModel
{

	function getAllCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.camperid, mc.hohid, mc.firstname, mc.lastname, mc.city, mc.statecd FROM muusa_campers mc WHERE mc.hohid=0 AND (SELECT COUNT(*) FROM muusa_campers_v mv WHERE mc.camperid=mv.camperid)=0 ORDER BY lastname, firstname, statecd, city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getCamper($camperid) {
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$query = "SELECT mc.camperid, mc.hohid, mc.firstname, mc.lastname, mc.sexcd, mc.address1, mc.address2, mc.city, mc.statecd, mc.zipcd, mc.country, ";
		$query .= "mc.email, DATE_FORMAT(mc.birthdate, '%m/%d/%Y') birthdate, muusa_age_f(DATE_FORMAT(mc.birthdate, '%m/%d/%Y')) age, mc.gradeoffset, ";
		$query .= "mc.roomprefid1, mc.roomprefid2, mc.roomprefid3, mc.matepref1, mc.matepref2, mc.matepref3, mc.sponsor, IF(mc.is_handicap, ' checked', '') is_handicap, IF(mc.is_ymca,' checked', '') is_ymca, IF(mc.is_ecomm,' checked', '') is_ecomm, ";
		$query .= "mc.foodoptionid, mc.churchid, mc.programid, mp.name programname FROM muusa_campers mc, muusa_programs mp WHERE mc.programid=mp.programid AND mc.camperid=$camperid";
		$db->setQuery($query);
		$camper = $db->loadObject();
		return $camper;
	}

	function getFamily($camperid) {
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$query = "SELECT camperid, hohid, CONCAT(firstname, ' ', lastname) fullname, mc.programid, DATE_FORMAT(mc.birthdate, '%m/%d/%Y') birthdate, mc.gradeoffset, muusa_age_f(DATE_FORMAT(mc.birthdate, '%m/%d/%Y')) age, mp.name programname FROM muusa_campers mc, muusa_programs mp WHERE mc.programid=mp.programid AND (mc.camperid=$camperid OR mc.hohid=$camperid) ORDER BY mc.hohid, mc.birthdate";
		$db->setQuery($query);
		$campers = $db->loadObjectList();
		foreach($campers as $camper) {
			if($camper->programname == "Adult" || preg_match("/^Young Adult/", $camper->programname) != 0) {
				$camper->workshop = "0";
			} else {
				$camper->workshop = "Automatically enrolled in " . $camper->programname . " programming.";
			}
		}
		return $campers;
	}

	function getPhonenumbers($id) {
		$db =& JFactory::getDBO();
		if($id != 0) {
			$query = "SELECT mt.name, CONCAT(left(mp.phonenbr,3) , '-' , mid(mp.phonenbr,4,3) , '-', right(mp.phonenbr,4)) phonenbr FROM muusa_phonenumbers mp, muusa_phonetypes mt WHERE mp.phonetypeid=mt.phonetypeid AND camperid=$id ORDER BY phonenbrid";
			$db->setQuery($query);
			return $db->loadObjectList();
		} else {
			return array();
		}
	}

	function getBuildings() {
		$db =& JFactory::getDBO();
		$query = "SELECT buildingid, name FROM muusa_buildings ORDER BY name";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getPositions() {
		$db =& JFactory::getDBO();
		$query = "SELECT positionid, name FROM muusa_positions ORDER BY name";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getFoodoptions() {
		$db =& JFactory::getDBO();
		$query = "SELECT foodoptionid, name FROM muusa_foodoptions ORDER BY foodoptionid";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getChurches() {
		$db =& JFactory::getDBO();
		$query = "SELECT churchid, name, city, statecd FROM muusa_churches ORDER BY statecd, city, name";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getWorkshops() {
		$db =& JFactory::getDBO();
		$query = "SELECT mt.name timename, mt.timeid, CONCAT(IF(me.su,'S',''),IF(me.m,'M',''),IF(me.t,'Tu',''),IF(me.w,'W',''),IF(me.th,'Th',''),IF(me.f,'F',''),IF(me.sa,'S','')) days, me.eventid eventid, me.name shopname FROM muusa_events me, muusa_times mt WHERE me.timeid=mt.timeid AND mt.length > 0 ORDER BY mt.starttime, me.name";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function upsertVolunteers($id, $obj) {
		$db =& JFactory::getDBO();
		
		if($obj->positionid != 0 && count($obj->positionid) > 0) {
			$query = "INSERT INTO muusa_volunteers (camperid, positionid, fiscalyear, created_by, created_at) ";
			$query .= "SELECT $id, positionid, (SELECT year FROM muusa_currentyear), '$obj->created_by', '$obj->created_at' FROM muusa_positions ";
			$query .= "WHERE positionid NOT IN (SELECT positionid FROM muusa_positions_v WHERE camperid=$id) ";
			$query .= "AND positionid IN (" . implode(",", $obj->positionid) . ")";
			$db->setQuery($query);
			$db->query();
			if($db->getErrorNum()) {
				JError::raiseError(500, $db->stderr());
			}
		}
	}

	function upsertAttendees($camperid, $events) {
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$query = "DELETE FROM muusa_attendees WHERE camperid=$camperid AND is_leader=0";
		$db->setQuery($query);
		$db->query();
		if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
		}

		foreach($events as $event) {
			for($i=0; $i<count($event->shops); $i++) {
				if($event->shops[$i] != "LEAD") {
					$obj = new stdClass;
					$obj->eventid = $event->shops[$i];
					$obj->camperid = $camperid;
					$obj->choicenbr = $i+1;
					$obj->is_leader = $event->leader;
					$obj->created_by = $user->username;
					$obj->created_at = date("Y-m-d H:i:s");
					$db->insertObject("muusa_attendees", $obj);
					if($db->getErrorNum()) {
						JError::raiseError(500, $db->stderr());
					}
				}
			}
		}
	}

	function calculateCharges($camperid) {
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$query = "SELECT mc.camperid, mc.firstname, mc.lastname, mc.hohid, DATE_FORMAT(mc.birthdate, '%m/%d/%Y') birthdate, muusa_age_f(DATE_FORMAT(mc.birthdate, '%m/%d/%Y')) age, mc.gradeoffset, IFNULL(mv.roomid,0) roomid FROM muusa_campers mc LEFT JOIN muusa_campers_v mv ON mc.camperid=mv.camperid WHERE mc.camperid=$camperid";
		$db->setQuery($query);
		$camper = $db->loadObject();
		if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
		}

		if($camper->camperid != 0 && $camper->hohid == 0) {
			$query = "DELETE FROM muusa_charges WHERE fiscalyear=(SELECT year FROM muusa_currentyear) AND camperid IN (SELECT camperid FROM muusa_campers_v WHERE camperid=$camper->camperid OR hohid=$camper->camperid) AND chargetypeid IN (1003, 1004, 1011)"; // 1012
			$db->setQuery($query);
			$db->query();
			if($db->getErrorNum()) {
				JError::raiseError(500, $db->stderr());
			}

			$obj = new stdClass;
			$obj->camperid = $camper->camperid;
			$obj->amount = "&&muusa_programs_fee_f('$camper->birthdate', $camper->gradeoffset)";
			$obj->memo = $camper->firstname . " " . $camper->lastname;
			$obj->chargetypeid = "&&(SELECT chargetypeid FROM muusa_chargetypes WHERE name LIKE 'Registration%')";
			$obj->timestamp = date("Y-m-d");
			$obj->fiscalyear = "&&(SELECT year FROM muusa_currentyear)";
			$obj->created_by = $user->username;
			$obj->created_at = date("Y-m-d H:i:s");
			$db->insertObject("muusa_charges", $obj);
			if($db->getErrorNum()) {
				JError::raiseError(500, $db->stderr());
			}
			$housingdepo = 50;

			$query = "SELECT camperid, firstname, lastname, birthdate, age, gradeoffset FROM muusa_campers_v WHERE hohid=$camper->camperid";
			$db->setQuery($query);
			$children = $db->loadObjectList();
			if($db->getErrorNum()) {
				JError::raiseError(500, $db->stderr());
			}

			foreach($children as $child) {
				$obj = new stdClass;
				$obj->camperid = $child->camperid;
				$obj->amount = "&&muusa_programs_fee_f('$child->birthdate', $child->gradeoffset)";
				$obj->memo = $child->firstname . " " . $child->lastname;
				$obj->chargetypeid = "&&(SELECT chargetypeid FROM muusa_chargetypes WHERE name LIKE 'Registration%')";
				$obj->timestamp = date("Y-m-d");
				$obj->fiscalyear = "&&(SELECT year FROM muusa_currentyear)";
				$obj->created_by = $user->username;
				$obj->created_at = date("Y-m-d H:i:s");
				$db->insertObject("muusa_charges", $obj);
				if($db->getErrorNum()) {
					JError::raiseError(500, $db->stderr());
				}
				if($child->age > 16 || ($child->age+$child->gradeoffset) > 6) {
					$housingdepo += 50;
				}
			}

			if($camper->roomid == 0) {
				$obj = new stdClass;
				$obj->camperid = $camper->camperid;
				$obj->amount = $housingdepo;
				$obj->memo = "Housing Deposit";
				$obj->chargetypeid = "&&(SELECT chargetypeid FROM muusa_chargetypes WHERE name LIKE 'Housing Depo%')";
				$obj->timestamp = date("Y-m-d");
				$obj->fiscalyear = "&&(SELECT year FROM muusa_currentyear)";
				$obj->created_by = $user->username;
				$obj->created_at = date("Y-m-d H:i:s");
				$db->insertObject("muusa_charges", $obj);
				if($db->getErrorNum()) {
					JError::raiseError(500, $db->stderr());
				}
			}
		}
		return $camper;
	}

	function upsertCamper($obj) {
		$db =& JFactory::getDBO();
		$obj->gradeoffset = "&&$obj->grade-muusa_age_f('$obj->birthdate')";
		$obj->programid = "&&muusa_programs_id_f('$obj->birthdate', ($obj->grade-muusa_age_f('$obj->birthdate')))";
		$obj->birthdate = "&&STR_TO_DATE('$obj->birthdate', '%m/%d/%Y')";
		unset($obj->grade);
		if($obj->camperid < 1000) {
			unset($obj->camperid);
			$db->insertObject("muusa_campers", $obj, "camperid");
		} else {
			$db->updateObject("muusa_campers", $obj, "camperid");
		}
		return $obj->camperid;
	}

	function upsertFiscalyear($id, $obj) {
		$db =& JFactory::getDBO();
		$obj->fiscalyear = "&&(SELECT year FROM muusa_currentyear)";
		$obj->postmark = ($obj->postmark) ? "&&STR_TO_DATE('$obj->postmark', '%m/%d/%Y')" : "&&CURRENT_DATE";
		if($id < 1000) {
			$db->insertObject("muusa_fiscalyear", $obj, "fiscalyearid");
		} else {
			$obj->fiscalyearid = $id;
			$db->updateObject("muusa_fiscalyear", $obj, "fiscalyearid");
		}
	}

	function insertCharge($obj) {
		$db =& JFactory::getDBO();
		$obj->fiscalyear = "&&(SELECT year FROM muusa_currentyear)";
		$obj->timestamp =  ($obj->timestamp) ? "&&STR_TO_DATE('$obj->timestamp', '%m/%d/%Y')" : date("Y-m-d");
		$db->insertObject("muusa_charges", $obj);
		if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
		}
	}
}