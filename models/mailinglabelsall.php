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
		$query = "SELECT mc.firstname firstname, mc.lastname lastname, mc.address1 address1, mc.address2 address2, mc.city city, mc.statecd statecd, mc.zipcd zipcd, IFNULL(CONCAT('Website username: ',j.username),'') username FROM (muusa_campers mc, muusa_fiscalyear mf, muusa_currentyear my) LEFT JOIN jos_users j ON mc.email=j.email WHERE mc.camperid=mf.camperid AND mf.fiscalyear>=(my.year-3) AND mc.hohid=0 GROUP BY mc.camperid ORDER BY mc.lastname, mc.firstname, mc.statecd, mc.city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}