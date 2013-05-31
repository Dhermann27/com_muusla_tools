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
		$query = "SELECT mv.hohid hohid, mv.firstname firstname, mv.lastname lastname, mc.email email, mb.name buildingname, mr.roomnbr roomnbr, mp.name programname FROM (muusa_campers_v mv, muusa_campers mc, muusa_programs mp) LEFT JOIN (muusa_buildings mb, muusa_rooms mr) ON mv.roomid=mr.roomid AND mr.buildingid=mb.buildingid WHERE mv.camperid=mc.camperid AND mc.programid=mp.programid AND mv.hohid!=0 ORDER BY mv.hohid, mc.birthdate";
		$db->setQuery($query);
		return $db->loadObjectList();
	}


	function getRoommates() {
		$db =& JFactory::getDBO();
		$query = "SELECT mv.camperid, mv.hohid, mv.roomid, CONCAT(mr.firstname, ' ', mr.lastname) fullname FROM muusa_campers_v mv, muusa_campers_v mr, muusa_rooms mo WHERE mv.roomid!=0 AND mr.roomid!=0 AND mv.camperid!=mr.camperid AND mv.hohid!=mr.camperid AND mv.camperid!=mr.hohid AND mr.camperid!=mv.hohid AND (mv.hohid!=mr.hohid OR mv.hohid=0) AND mv.roomid=mr.roomid AND mv.roomid=mo.roomid AND mo.buildingid IN (1000,1001,1002,1003) GROUP BY fullname ORDER BY mv.roomid";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getCharges() {
		$db =& JFactory::getDBO();
		$query = "SELECT mv.familyid familyid, mv.camperid camperid, FORMAT(mv.amount,2) amount, mv.chargetypeid chargetypeid, mt.name chargetypename, mv.memo memo FROM muusa_charges_v mv, muusa_chargetypes mt WHERE mv.chargetypeid=mt.chargetypeid ORDER BY mv.timestamp, mv.chargetypeid";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getCredits() {
		$db =& JFactory::getDBO();
		$query = "SELECT camperid, hohid, name memo, registration_amount, housing_amount FROM muusa_credits_v";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getVolunteers() {
		$db =& JFactory::getDBO();
		$query = "SELECT camperid, hohid, CONCAT(firstname, ' ', lastname) fullname, name positionname FROM muusa_volunteers_v";
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
		$query = "SELECT ma.eventid eventid, mc.camperid camperid, mc.hohid hohid, CONCAT(mc.firstname, ', ', mc.lastname) fullname, ma.choicenbr choicenbr, CONCAT(IF(me.su,'S',''),IF(me.m,'M',''),IF(me.t,'Tu',''),IF(me.w,'W',''),IF(me.th,'Th',''),IF(me.f,'F',''),IF(me.sa,'S','')) dispdays, mt.name timename, me.name workshopname FROM muusa_attendees ma, muusa_campers mc, muusa_fiscalyear mf, muusa_events me, muusa_currentyear my, muusa_times mt WHERE ma.camperid=mc.camperid AND mc.camperid=mf.camperid AND ma.eventid=me.eventid AND mf.fiscalyear=my.year AND me.timeid=mt.timeid ORDER BY ma.is_leader DESC, mf.postmark, ma.choicenbr";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}