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
		$query = "SELECT ya.year FROM muusa_camper c, muusa_yearattending ya WHERE c.id=ya.camperid AND c.email='$email' ORDER BY ya.year DESC";
		$db->setQuery($query);
		return $db->loadResultArray();
	}
}