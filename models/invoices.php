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
class muusla_toolsModelinvoices extends JModel
{
	function getAllCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.camperid, mc.firstname, mc.lastname, mc.city, mc.statecd FROM muusa_campers_v mc WHERE mc.hohid=0 ORDER BY lastname, firstname, statecd, city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getCampers($camper) {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.camperid camperid, mc.firstname firstname, mc.lastname lastname, mf.address1 address1, mf.address2 address2, mc.city city, mc.statecd statecd, mf.zipcd zipcd, mf.email email, mb.name buildingname, mr.roomnbr roomnbr, DATE_FORMAT(mf.birthdate, '%m/%d/%Y') age, mh.name churchname FROM (muusa_campers_v mc, muusa_campers mf, muusa_buildings mb, muusa_rooms mr) LEFT JOIN muusa_churches mh ON mf.churchid=mh.churchid WHERE mc.camperid=mf.camperid AND mc.roomid=mr.roomid AND mr.buildingid=mb.buildingid AND mc.hohid=0";
		if($camper && $camper > 0) {
			$query .= " AND mc.camperid=$camper";
		}
		$query .= " ORDER BY mc.lastname, mc.firstname, mc.statecd, mc.city";
		$db->setQuery($query);
		return $db->loadAssocList("camperid");
	}

	function getChildren() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.hohid hohid, mc.firstname firstname, mc.lastname lastname, mf.email email, mb.name buildingname, mr.roomnbr roomnbr, DATE_FORMAT(mf.birthdate, '%m/%d/%Y') age FROM muusa_campers_v mc, muusa_campers mf, muusa_buildings mb, muusa_rooms mr WHERE mc.camperid=mf.camperid AND mc.roomid=mr.roomid AND mr.buildingid=mb.buildingid AND mc.hohid!=0 ORDER BY mc.hohid, mc.birthdate";
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
		$query = "SELECT ma.eventid eventid, mc.camperid camperid, mc.hohid hohid, CONCAT(mc.firstname, ', ', mc.lastname) fullname, ma.choicenbr choicenbr, CONCAT(IF(me.su,'S',''),IF(me.m,'M',''),IF(me.t,'Tu',''),IF(me.w,'W',''),IF(me.th,'Th',''),IF(me.f,'F',''),IF(me.sa,'S','')) dispdays, DATE_FORMAT(starttime, '%l:%i %p') timename, me.name workshopname FROM muusa_attendees ma, muusa_campers mc, muusa_fiscalyear mf, muusa_events me, muusa_currentyear my, muusa_times mt WHERE ma.camperid=mc.camperid AND mc.camperid=mf.camperid AND ma.eventid=me.eventid AND mf.fiscalyear=my.year AND me.timeid=mt.timeid ORDER BY ma.is_leader DESC, mf.postmark, ma.choicenbr";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}