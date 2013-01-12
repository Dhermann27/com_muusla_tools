<?php
/**
 * muusla_tools Model for muusla_tools Component
 *
 * @package    muusla_tools
 * @subpackage Components
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * muusla_tools Model
 *
 * @package    muusla_tools
 * @subpackage Components
 */
class muusla_toolsModelassignroom extends JModel
{
	function getCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT camperid, firstname, lastname, city, statecd FROM muusa_campers_v WHERE hohid=0 ORDER BY lastname, firstname, statecd, city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	function getData() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.camperid, mc.firstname, mc.lastname, mf.fiscalyear, mp1.name mp1name, mp2.name mp2name, mp3.name mp3name, IFNULL(CONCAT(mb.name, ' ', mr.roomnbr), 'Unassigned') room FROM (muusa_campers_v mv, muusa_campers mc, muusa_fiscalyear mf) LEFT JOIN (muusa_rooms mr, muusa_buildings mb) ON mf.roomid=mr.roomid AND mr.buildingid=mb.buildingid LEFT JOIN muusa_buildings mp1 ON mc.roomprefid1=mp1.buildingid LEFT JOIN muusa_buildings mp2 ON mc.roomprefid2=mp2.buildingid LEFT JOIN muusa_buildings mp3 ON mc.roomprefid3=mp3.buildingid WHERE mv.camperid=mc.camperid AND mc.camperid=mf.camperid AND mv.hohid=0 ORDER BY mv.lastname, mv.firstname, mv.statecd, mv.city, mf.fiscalyear DESC";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getRooms() {
		$db =& JFactory::getDBO();
		$query = "SELECT mr.roomid roomid, mb.buildingid buildingid, mb.name buildingname, mr.roomnbr roomnbr, mr.capacity capacity, mr.is_handicap is_handicap, (SELECT COUNT(*) FROM muusa_fiscalyear mf, muusa_currentyear my WHERE mf.roomid = mr.roomid AND mf.fiscalyear=my.year) current FROM muusa_buildings mb LEFT OUTER JOIN muusa_rooms mr ON mr.buildingid=mb.buildingid WHERE mr.is_workshop=0 ORDER BY mb.buildingid, mr.roomnbr";
		$db->setQuery($query);
		$results = $db->loadObjectList();
		$buildings = array();
		$counter = -1;
		foreach($results as $result) {
			if($counter == -1 || $buildings[$counter]->buildingid != $result->buildingid) {
				$building = new stdClass;
				$building->buildingid = $result->buildingid;
				$building->buildingname = $result->buildingname;
				$building->rooms = array();
				$buildings[++$counter] = $building;
			}
			if($result->roomid) {
				$room = new stdClass;
				$room->roomid = $result->roomid;
				$room->roomnbr = $result->roomnbr;
				$room->current = $result->current;
				$room->capacity = $result->capacity;
				$room->is_handicap = $result->is_handicap;
				$buildings[$counter]->rooms[] = $room;
			}
		}
		return $buildings;
	}

	function getPrograms() {
		$db =& JFactory::getDBO();
		$query = "SELECT programid, name FROM muusa_programs WHERE name LIKE 'Meyer%' OR name LIKE 'Burt%'";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function assignRoom($id) {
		$db =& JFactory::getDBO();
		$query = "SELECT DISTINCT(mf.roomid) FROM muusa_campers mc, muusa_fiscalyear mf, muusa_programs mp, muusa_currentyear my WHERE mc.camperid=mf.camperid AND mc.programid=mp.programid AND (mc.camperid=$id OR mc.hohid=$id) AND mf.fiscalyear=my.year AND mp.name NOT LIKE 'Meyer%' AND mp.name NOT LIKE 'Burt%'";
		$db->setQuery($query);
		$oldroom = $db->loadResult();
		if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
		}

		$user =& JFactory::getUser();
		$query = "UPDATE muusa_campers mc, muusa_programs mp, muusa_fiscalyear mf, muusa_currentyear my SET mf.roomid=" . JRequest::getSafe("hohroom");
		$query .= ", mf.modified_by='$user->username', mf.modified_at=CURRENT_TIMESTAMP WHERE mc.programid=mp.programid AND mc.camperid=mf.camperid AND mf.fiscalyear=my.year AND mp.name NOT LIKE 'Meyer%' AND mp.name NOT LIKE 'Burt%'";
		$query .= " AND (mc.camperid=$id OR mc.hohid=$id)";
		$db->setQuery($query);
		$db->query();
		if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
		}

		if($oldroom != 0) {
			$this->updateHousing($oldroom);
		}
		if(JRequest::getSafe("hohroom") != 0) {
			$this->updateHousing(JRequest::getSafe("hohroom"));
		} else {
			$query = "DELETE FROM muusa_charges WHERE camperid IN (SELECT mc.camperid FROM muusa_campers mc, muusa_programs mp WHERE (camperid=$id OR hohid=$id) AND mc.programid=mp.programid AND mp.name NOT LIKE 'Meyer%' AND mp.name NOT LIKE 'Burt%') AND chargetypeid IN (1000,1011)";
			$db->setQuery($query);
			$db->query();
			if($db->getErrorNum()) {
				JError::raiseError(500, $db->stderr());
			}
		}
	}

	function assignProgram($id) {

		// UNTESTED
		/*$db =& JFactory::getDBO();
			$user =& JFactory::getUser();

			if(count(JRequest::getVar("programroom")) == 0 || in_array("0", JRequest::getVar("programroom"))) {
			$query = "UPDATE muusa_campers mc, muusa_programs mp, muusa_fiscalyear mf SET mf.roomid=0";
			$query .= ", modified_by='$user->username', modified_at=CURRENT_TIMESTAMP WHERE mc.programid=mp.programid AND mc.camperid=mf.camperid AND mc.sexcd='" . JRequest::getSafe("sexcd") . "' AND mf.fiscalyear=2009 AND mp.programid=" . $id;
			$db->setQuery($query);
			$db->query();
			if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
			}
			} else {
			$query = "SELECT mc.camperid FROM muusa_campers mc, muusa_fiscalyear mf WHERE mc.camperid=mf.camperid  AND mc.sexcd='" . JRequest::getSafe("sexcd") . "' AND mf.fiscalyear=2009 AND mc.programid=" . $id;
			$db->setQuery($query);
			$kids = $db->loadResultArray();
			if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
			}

			$query = "SELECT roomid, capacity FROM muusa_rooms WHERE roomid IN (" . implode(",", JRequest::getVar("programroom")) . ")";
			$db->setQuery($query);
			$rooms = $db->loadObjectList();
			if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
			}

			$total = 0;
			foreach($rooms as $room) {
			$total += $room->capacity;
			}

			$totalkids = count($kids);
			$roomsleft = count($rooms);
			foreach($rooms as $room) {
			if(count($kids)> 0) {
			$limit = floor($room->capacity / $total * $totalkids);
			if(count($kids) % $roomsleft != 0) {
			$limit++;
			}
			$limit = min($limit, $room->capacity);

			$kidsplice = implode(",", array_splice($kids, 0, $limit));

			$query = "UPDATE muusa_campers mc, muusa_fiscalyear mf SET mf.roomid=" . $room->roomid;
			$query .= ", modified_by='$user->username', modified_at=CURRENT_TIMESTAMP WHERE mc.camperid=mf.camperid AND mc.camperid IN ($kidsplice)";
			$db->setQuery($query);
			$db->query();
			if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
			}

			$query = "SELECT mc.camperid, IFNULL(mr.chargeid,0) chargeid FROM muusa_campers mc LEFT JOIN muusa_charges mr ON mc.camperid=mr.camperid AND mr.chargetypeid=(SELECT chargetypeid FROM muusa_chargetypes WHERE name LIKE 'Housing Fee%') AND mr.fiscalyear=2009 WHERE mc.camperid INSELECT mc.camperid, IFNULL(mr.chargeid,0) chargeid FROM muusa_campers mc LEFT JOIN muusa_charges mr ON mc.camperid=mr.camperid AND mr.chargetypeid=(SELECT chargetypeid FROM muusa_chargetypes WHERE name LIKE 'Housing Fee%') AND mr.fiscalyear=2009 WHERE mc.camperid IN ($kidsplice)";
			$db->setQuery($query);
			$charges = $db->loadObjectList();

			foreach ($charges as $charge) {
			if($charge->chargeid != "0") {
			$query = "UPDATE muusa_charges SET ";
			$query .= "amount=(SELECT mr.amount FROM muusa_rates mr, muusa_fiscalyear mf, muusa_campers mc, muusa_rooms mm, muusa_buildings mb WHERE mf.roomid=mm.roomid AND mm.buildingid=mb.buildingid AND mr.buildingid=mb.buildingid AND mf.camperid=mc.camperid AND mr.programid=mc.programid AND (mr.occupancy_adult = (SELECT COUNT(*) FROM muusa_fiscalyear mfy, muusa_campers mcs WHERE mfy.roomid=mf.roomid AND mfy.camperid=mcs.camperid AND DATE_FORMAT(FROM_DAYS(DATEDIFF('2009-07-12',mcs.birthdate)), '%Y')>=18) OR (mr.occupancy_adult=999 AND (SELECT COUNT(*) FROM muusa_fiscalyear mfy, muusa_campers mcs WHERE mfy.roomid=mf.roomid AND mfy.camperid=mcs.camperid AND DATE_FORMAT(FROM_DAYS(DATEDIFF('2009-07-12',mcs.birthdate)), '%Y')>=18)>0)) AND (mr.occupancy_children=(SELECT COUNT(*) FROM muusa_fiscalyear mfy, muusa_campers mcs WHERE mfy.roomid=mf.roomid AND mfy.camperid=mcs.camperid AND DATE_FORMAT(FROM_DAYS(DATEDIFF('2009-07-12',mcs.birthdate)), '%Y')<18) OR (mr.occupancy_children=999 AND (SELECT COUNT(*) FROM muusa_fiscalyear mfy, muusa_campers mcs WHERE mfy.roomid=mf.roomid AND mfy.camperid=mcs.camperid AND DATE_FORMAT(FROM_DAYS(DATEDIFF('2009-07-12',mcs.birthdate)), '%Y')<18)>0)) AND mf.camperid=$charge->camperid), ";
			$query .= "memo=(SELECT mb.name FROM muusa_buildings mb, muusa_rooms mr WHERE mb.buildingid=mr.buildingid AND mr.roomid=$room->roomid), timestamp=CURRENT_TIMESTAMP ";
			$query .= ", modified_by='$user->username', modified_at=CURRENT_TIMESTAMP WHERE chargeid=$chargeid->chargeid";
			} else {
			$user =& JFactory::getUser();
			$query = "INSERT INTO muusa_charges (camperid, amount, memo, chargetypeid, timestamp, fiscalyear, created_by, created_at) VALUES ($charge->camperid, ";
			$query .= "(SELECT mr.amount FROM muusa_rates mr, muusa_fiscalyear mf, muusa_campers mc, muusa_rooms mm, muusa_buildings mb WHERE mf.roomid=mm.roomid AND mm.buildingid=mb.buildingid AND mr.buildingid=mb.buildingid AND mf.camperid=mc.camperid AND mr.programid=mc.programid AND (mr.occupancy_adult = (SELECT COUNT(*) FROM muusa_fiscalyear mfy, muusa_campers mcs WHERE mfy.roomid=mf.roomid AND mfy.camperid=mcs.camperid AND DATE_FORMAT(FROM_DAYS(DATEDIFF('2009-07-12',mcs.birthdate)), '%Y')>=18) OR (mr.occupancy_adult=999 AND (SELECT COUNT(*) FROM muusa_fiscalyear mfy, muusa_campers mcs WHERE mfy.roomid=mf.roomid AND mfy.camperid=mcs.camperid AND DATE_FORMAT(FROM_DAYS(DATEDIFF('2009-07-12',mcs.birthdate)), '%Y')>=18)>0)) AND (mr.occupancy_children=(SELECT COUNT(*) FROM muusa_fiscalyear mfy, muusa_campers mcs WHERE mfy.roomid=mf.roomid AND mfy.camperid=mcs.camperid AND DATE_FORMAT(FROM_DAYS(DATEDIFF('2009-07-12',mcs.birthdate)), '%Y')<18) OR (mr.occupancy_children=999 AND (SELECT COUNT(*) FROM muusa_fiscalyear mfy, muusa_campers mcs WHERE mfy.roomid=mf.roomid AND mfy.camperid=mcs.camperid AND DATE_FORMAT(FROM_DAYS(DATEDIFF('2009-07-12',mcs.birthdate)), '%Y')<18)>0)) AND mf.camperid=$charge->camperid), ";
			$query .= "(SELECT mb.name FROM muusa_buildings mb, muusa_rooms mr WHERE mb.buildingid=mr.buildingid AND mr.roomid=$room->roomid), ";
			$query .= "(SELECT chargetypeid FROM muusa_chargetypes WHERE name LIKE 'Housing Fee%'), CURRENT_TIMESTAMP, 2009, '$user->username', CURRENT_TIMESTAMP)";
			}
			$db->setQuery($query);
			$db->query();
			if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
			}
			}

			$roomsleft--;
			}
			}
			}*/
	}

	function updateHousing($roomid) {
		$db =& JFactory::getDBO();
		$query = "SELECT camperid FROM muusa_campers_v WHERE age>4 AND roomid=$roomid";
		$db->setQuery($query);
		$roommates = $db->loadResultArray();

		foreach($roommates as $camperid) {
			$query = "SELECT chargeid FROM muusa_charges_v WHERE camperid=$camperid AND chargetypeid=(SELECT chargetypeid FROM muusa_chargetypes WHERE name LIKE 'Housing Fee%')";
			$db->setQuery($query);
			$chargeid = $db->loadResult();
			$user =& JFactory::getUser();

			if($chargeid != "") {
				$query = "UPDATE muusa_charges SET ";
				$query .= "amount=muusa_rates_f($camperid), ";
				$query .= "memo=(SELECT mb.name FROM muusa_buildings mb, muusa_rooms mr WHERE mb.buildingid=mr.buildingid AND mr.roomid=$roomid), timestamp='" . date("Y-m-d");
				$query .= "', modified_by='$user->username', modified_at=CURRENT_TIMESTAMP WHERE chargeid=$chargeid";
			} else {
				$query = "INSERT INTO muusa_charges (camperid, amount, memo, chargetypeid, timestamp, fiscalyear, created_by, created_at) VALUES ($camperid, ";
				$query .= "muusa_rates_f($camperid), ";
				$query .= "(SELECT mb.name FROM muusa_buildings mb, muusa_rooms mr WHERE mb.buildingid=mr.buildingid AND mr.roomid=$roomid), ";
				$query .= "(SELECT chargetypeid FROM muusa_chargetypes WHERE name LIKE 'Housing Fee%'), '" . date("Y-m-d") . "', (SELECT year FROM muusa_currentyear), '$user->username', CURRENT_TIMESTAMP)";
			}
			$db->setQuery($query);
			$db->query();
			if($db->getErrorNum()) {
				JError::raiseError(500, $db->stderr());
			}

			$query = "DELETE FROM muusa_charges WHERE camperid=$camperid AND fiscalyear=(SELECT year FROM muusa_currentyear) AND chargetypeid=1004";
			$db->setQuery($query);
			$db->query();
			if($db->getErrorNum()) {
				JError::raiseError(500, $db->stderr());
			}
		}

	}
}