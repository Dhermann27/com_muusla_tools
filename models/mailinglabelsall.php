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
class muusla_toolsModelmailinglabelsall extends JModel
{
	function getCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT IF(COUNT(DISTINCT mc.camperid)=1, CONCAT(mc.firstname, ' ', mc.lastname), CONCAT('The ', mm.familyname, ' Family')) family, mm.address1, mm.address2, mm.city city, mm.statecd, mm.zipcd FROM muusa_family mm, muusa_campers mc, muusa_fiscalyear mf, muusa_currentyear my WHERE mm.familyid=mc.familyid AND mc.camperid=mf.camperid AND mf.fiscalyear>=(my.year-3) GROUP BY mm.familyid ORDER BY mm.familyname, mm.statecd, mm.city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}