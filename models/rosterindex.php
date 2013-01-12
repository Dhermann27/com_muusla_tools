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
		$query = "SELECT CONCAT(mc.lastname, ', ', mc.firstname) campername, CONCAT(mh.lastname, ', ', mh.firstname) hohname FROM muusa_campers_v mc, muusa_campers md, muusa_campers_v mh WHERE mc.hohid=mh.camperid AND mc.camperid=md.camperid AND mc.hohid!=0 AND mc.lastname!=mh.lastname AND md.is_show_all=1 ORDER BY campername, mc.birthdate";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}