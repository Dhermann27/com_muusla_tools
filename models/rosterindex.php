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
class muusla_toolsModelrosterindex extends JModel
{
	function getCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT lastname, firstname, familyname FROM muusa_campers_v WHERE familyname NOT LIKE CONCAT(lastname, '%') ORDER BY lastname, firstname";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}