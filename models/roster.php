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
class muusla_toolsModelroster extends JModel
{
	function getCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.camperid, mc.firstname, mc.lastname, IF(mc.is_show_address=1,CONCAT(mc.address1, '|', mc.address2, '|', mc.city, '|', mc.statecd, '|', mc.zipcd),'||||') address, IF(mc.is_show_email=1,mc.email,'') email, IF(is_show_birthday=1,DATE_FORMAT(mc.birthdate, '%m/%d'),'') birthdate, mh.name churchname FROM (muusa_campers mc, muusa_campers_v mf) LEFT JOIN muusa_churches mh ON mc.churchid=mh.churchid WHERE mc.camperid=mf.camperid AND mc.hohid=0 AND mc.is_show_all=1 ORDER BY mc.lastname, mc.firstname, mc.statecd, mc.city";
		$db->setQuery($query);
		return $db->loadAssocList("camperid");
	}

	function getChildren() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.hohid, mc.camperid camperid, 0 phones, mc.firstname, mc.lastname, IF(mc.is_show_email=1,mc.email,'') email, IF(is_show_birthday=1,DATE_FORMAT(mc.birthdate, '%m/%d'),'') birthdate FROM muusa_campers mc, muusa_campers_v mf WHERE mc.camperid=mf.camperid AND mc.hohid!=0 AND mc.is_show_all=1 ORDER BY mc.hohid, mc.birthdate";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getPhones() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.camperid camperid, mp.name, mn.phonenbr FROM muusa_campers mc, muusa_campers_v mv, muusa_phonenumbers mn, muusa_phonetypes mp WHERE mc.camperid=mv.camperid AND mc.is_show_phone=1 AND mc.camperid=mn.camperid AND mn.phonetypeid=mp.phonetypeid ORDER BY mc.camperid";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}