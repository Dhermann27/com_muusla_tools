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
class muusla_toolsModeltroutrooms extends JModel
{
	function getCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT mb.name Building, mr.roomnbr Room_Number, CONCAT(mc.firstname, ' ', mc.lastname) Name, mc.sexcd, CONCAT(mc.address1, ', ', IF(mc.address2<>'',CONCAT(mc.address2, ', '),''), mc.city, ', ', mc.statecd, ' ', mc.zipcd) Address, mf.age Age FROM muusa_campers mc, muusa_campers_v mf, muusa_buildings mb, muusa_rooms mr WHERE mc.camperid=mf.camperid AND mf.roomid=mr.roomid AND mr.buildingid=mb.buildingid ORDER BY mb.buildingid, mr.roomnbr, mc.birthdate";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}