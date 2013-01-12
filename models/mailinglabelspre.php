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
class muusla_toolsModelmailinglabelspre extends JModel
{
	function getCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.firstname firstname, mc.lastname lastname, mc.address1 address1, mc.address2 address2, mc.city city, mc.statecd statecd, mc.zipcd zipcd FROM muusa_campers mc, muusa_charges mr, muusa_currentyear my WHERE mc.camperid=mr.camperid AND mr.fiscalyear=my.year AND mc.hohid=0 AND mr.chargetypeid IN (1001,1016) GROUP BY mc.camperid ORDER BY mc.lastname, mc.firstname, mc.statecd, mc.city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}