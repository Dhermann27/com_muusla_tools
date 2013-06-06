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
class muusla_toolsModelletters extends JModel
{

	function getCampers($where) {
		$db =& JFactory::getDBO();
		$query = "SELECT familyid, familyname, address1, address2, city, statecd, zipcd FROM muusa_family_v $where ORDER BY familyname, statecd, city";
		$db->setQuery($query);
		return $db->loadAssocList("familyid");
	}

	function getChildren() {
		$db =& JFactory::getDBO();
		$query = "SELECT familyid, firstname, lastname, email, buildingname, roomnbr, programname FROM muusa_campers_v mv ORDER BY familyid, STR_TO_DATE(birthdate, '%m/%d/%Y')";
		$db->setQuery($query);
		return $db->loadObjectList();
	}


	function getRoommates() {
		$db =& JFactory::getDBO();
		$query = "SELECT mv.familyid, CONCAT(mr.firstname, ' ', mr.lastname) fullname FROM muusa_campers_v mv, muusa_campers_v mr, muusa_rooms mo WHERE mv.roomid!=0 AND mr.roomid!=0 AND mv.camperid!=mr.camperid AND mv.familyid!=mr.familyid AND mv.roomid=mr.roomid AND mv.roomid=mo.roomid AND mo.buildingid IN (1000,1001,1002,1003) GROUP BY fullname ORDER BY mv.roomid";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getCharges() {
		$db =& JFactory::getDBO();
		$query = "SELECT familyid, FORMAT(amount,2) amount, chargetypeid, chargetypename, memo FROM muusa_charges_v mv ORDER BY timestamp, chargetypeid";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getCredits() {
		$db =& JFactory::getDBO();
		$query = "SELECT familyid, positionname memo, registration_amount, housing_amount FROM muusa_credits_v";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getScholarships() {
		$db =& JFactory::getDBO();
		$query = "SELECT familyid, name memo, registration_amount, housing_amount FROM muusa_scholarships_v";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getVolunteers() {
		$db =& JFactory::getDBO();
		$query = "SELECT familyid, CONCAT(firstname, ' ', lastname) fullname, name positionname FROM muusa_volunteers_v";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getWorkshops() {
		$db =& JFactory::getDBO();
		$query = "SELECT me.eventid eventid, CONCAT(me.su, me.m, me.t, me.w, me.th, me.f, me.sa) days, me.capacity capacity, mt.starttime starttime FROM muusa_events me, muusa_buildings mb, muusa_rooms mr, muusa_times mt WHERE me.roomid=mr.roomid AND mr.buildingid=mb.buildingid AND me.timeid=mt.timeid ORDER by mt.starttime, me.name";
		$db->setQuery($query);
		return $db->loadAssocList("eventid");
	}

	function getAttendees() {
		$db =& JFactory::getDBO();
		$query = "SELECT ma.eventid, mc.familyid, mc.camperid, CONCAT(mc.firstname, ', ', mc.lastname) fullname, ma.choicenbr choicenbr, CONCAT(IF(me.su,'S',''),IF(me.m,'M',''),IF(me.t,'Tu',''),IF(me.w,'W',''),IF(me.th,'Th',''),IF(me.f,'F',''),IF(me.sa,'S','')) dispdays, mt.name timename, me.name workshopname FROM muusa_attendees ma, muusa_campers mc, muusa_fiscalyear mf, muusa_events me, muusa_currentyear my, muusa_times mt WHERE ma.fiscalyearid=mf.fiscalyearid AND mc.camperid=mf.camperid AND ma.eventid=me.eventid AND mf.fiscalyear=my.year AND me.timeid=mt.timeid ORDER BY ma.is_leader DESC, mf.postmark, ma.choicenbr";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}