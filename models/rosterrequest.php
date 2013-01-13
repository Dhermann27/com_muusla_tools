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
class muusla_toolsModelrosterrequest extends JModel
{
	function getYears($email) {
		$db =& JFactory::getDBO();
		$query = "SELECT mf.fiscalyear FROM muusa_campers mc, muusa_fiscalyear mf WHERE mc.camperid=mf.camperid AND mc.email='$email' ORDER BY mf.fiscalyear DESC";
		$db->setQuery($query);
		return $db->loadResultArray();
	}
}