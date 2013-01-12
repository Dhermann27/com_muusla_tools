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
class muusla_toolsModelprogramlist extends JModel
{
	function getCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT mv.camperid, mv.lastname, mv.firstname, mv.age, mv.gradeoffset, mv.programname programname, CONCAT(mt.firstname, ' ', mt.lastname) fullname, mt.email, (SELECT phonenbr FROM muusa_phonenumbers mcs WHERE mcs.phonetypeid=1001 AND (mcs.camperid=mt.camperid OR mcs.camperid=mt.hohid) ORDER BY mt.hohid, mt.birthdate LIMIT 0,1) phonenbr, mt.roomnbr room FROM muusa_campers_v mv LEFT JOIN muusa_campers_v mt ON mv.hohid=mt.camperid WHERE mv.programname!='Adult' ORDER BY mv.programname, mv.lastname, mv.firstname";
		$db->setQuery($query);
		return $db->loadAssocList("camperid");
	}

	function getSponsors() {
		$db =& JFactory::getDBO();
		$query = "SELECT mv.camperid, CONCAT(mp.firstname, ' ', mp.lastname) fullname, (SELECT phonenbr FROM muusa_phonenumbers mcs WHERE mcs.phonetypeid=1001 AND mcs.camperid=mp.camperid ORDER BY mp.hohid, mp.birthdate LIMIT 0,1) phonenbr, mp.email, mp.roomnbr room FROM (muusa_campers_v mv, muusa_campers mc, muusa_campers_v mp) WHERE mv.camperid=mc.camperid AND mc.sponsor IS NOT NULL AND mc.sponsor LIKE CONCAT('%', mp.lastname, '%') AND mc.sponsor LIKE CONCAT('%', mp.firstname, '%')";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}