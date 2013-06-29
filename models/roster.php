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
		$query = "SELECT familyid, familyname, address1,  address2, city, statecd, zipcd FROM muusa_campers_v ORDER BY familyname, statecd, city";
		$db->setQuery($query);
		return $db->loadAssocList("familyid");
	}

	function getChildren() {
		$db =& JFactory::getDBO();
		$query = "SELECT familyid, camperid, 0 phones, firstname, lastname, email, SUBSTR(birthdate, 0, 4) FROM muusa_campers_v ORDER BY STR_TO_DATE(birthdate, '%m/%d/%Y')";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getPhones() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.camperid, mp.name, mn.phonenbr FROM muusa_campers_v mc, muusa_phonenumbers mn, muusa_phonetypes mp WHERE mc.camperid=mn.camperid AND mn.phonetypeid=mp.phonetypeid ORDER BY mc.camperid";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}