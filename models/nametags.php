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
class muusla_toolsModelnametags extends JModel
{
	function getAllCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT mc.camperid, mc.firstname, mc.lastname, mc.city, mc.statecd FROM muusa_campers_v mc ORDER BY lastname, firstname, statecd, city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function getCampers($camper) {
		$db =& JFactory::getDBO();
		$query = "SELECT IF(mc.hohid=0,mc.camperid,mc.hohid) orderid, IF(mc.hohid=0,CONCAT(mc.lastname,mc.firstname),(SELECT CONCAT(mo.lastname,mo.firstname) FROM muusa_campers_v mo WHERE mo.camperid=mc.hohid)) orderme, CONCAT(mc.firstname, ' ', mc.lastname) fullname, mc.city city, mc.statecd statecd, mh.name churchname, (SELECT mp.name FROM muusa_credits_v mp WHERE md.camperid=mp.camperid AND mp.name NOT LIKE '%Scholarship%' ORDER BY mp.housing_amount DESC LIMIT 1) positionname, IF((SELECT COUNT(*) FROM muusa_fiscalyear mf, muusa_currentyear my WHERE mc.camperid=mf.camperid AND mf.fiscalyear>=(my.year-999))=1, 'New Camper', IF((SELECT COUNT(*) FROM muusa_fiscalyear mf WHERE mc.camperid=mf.camperid AND mf.fiscalyear>=2009)=1, 'New to Trout Lodge', '')) new FROM (muusa_campers_v mc, muusa_campers md) LEFT JOIN muusa_churches mh ON md.churchid=mh.churchid WHERE mc.camperid=md.camperid ";
		if($camper && $camper > 0) {
			$query .= " AND mc.camperid=$camper";
		}
		$query .= " GROUP BY mc.camperid ORDER BY orderme, mc.birthdate";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}