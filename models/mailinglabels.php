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
class muusla_toolsModelmailinglabels extends JModel
{
	function getCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT mv.familyname, mv.address1, mv.address2, mv.city, mv.statecd, mv.zipcd, (SELECT COUNT(*) FROM muusa_campers_v mc WHERE mv.familyid=mc.familyid) count FROM muusa_family_v mv ORDER BY mv.familyname, mv.statecd, mv.city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}