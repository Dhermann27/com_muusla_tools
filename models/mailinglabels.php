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
		$query = "SELECT mv.firstname firstname, mv.lastname lastname, mc.address1 address1, mc.address2 address2, mv.city city, mv.statecd statecd, mc.zipcd zipcd FROM muusa_campers_v mv, muusa_campers mc WHERE mv.camperid=mc.camperid AND mv.hohid=0 ORDER BY mc.lastname, mc.firstname, mc.statecd, mc.city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}