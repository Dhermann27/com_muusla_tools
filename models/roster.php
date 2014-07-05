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
		$query = "SELECT id, name, address1,  address2, city, statecd, zipcd FROM muusa_thisyear_family ORDER BY name, statecd, city";
		$db->setQuery($query);
		return $db->loadAssocList("id");
	}

	function getChildren() {
		$db =& JFactory::getDBO();
		$query = "SELECT familyid, id, 0 phones, firstname, lastname, email, LEFT(birthday, 5) birthdate FROM muusa_thisyear_camper ORDER BY birthdate";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getPhones() {
		$db =& JFactory::getDBO();
		$query = "SELECT tc.id, nt.name, n.phonenbr FROM (muusa_thisyear_camper tc, muusa_phonenumber n, muusa_phonetype nt) WHERE tc.id=n.camperid AND n.phonetypeid=nt.id GROUP BY tc.familyid, n.phonenbr ORDER BY tc.id";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}