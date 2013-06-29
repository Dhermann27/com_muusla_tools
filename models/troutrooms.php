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
		$query = " SELECT mb.name Building, mr.roomnbr Room_Number, CONCAT(mc.firstname, ' ', mc.lastname) Name, mc.sexcd, CONCAT(mfv.address1, ', ', IF(mfv.address2<>'',CONCAT(mfv.address2, ', '),''), mfv.city, ', ', mfv.statecd, ' ', mfv.zipcd) Address, mc.age Age FROM muusa_campers_v mc, muusa_family_v mfv, muusa_buildings mb, muusa_rooms mr WHERE mc.familyid=mfv.familyid AND mc.roomid=mr.roomid AND mr.buildingid=mb.buildingid ORDER BY mb.buildingid, mr.roomnbr, STR_TO_DATE(mc.birthdate, '%m/%d/%Y')";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}