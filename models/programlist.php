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
		$query = "SELECT mc.camperid, mc.firstname, mc.lastname, mc.programname, mc.age, mc.grade, CONCAT(mp.firstname , ' ', mp.lastname) fullname, mp.email, mr.phonenbr, mp.roomnbr room FROM muusa_campers_v mc LEFT JOIN muusa_campers_v mp ON mp.camperid=(SELECT mt.camperid FROM muusa_campers_v mt LEFT JOIN muusa_phonenumbers mr ON mt.camperid=mr.camperid AND mr.phonetypeid=1001 WHERE mc.familyid=mt.familyid AND mc.camperid!=mt.camperid AND mt.age>17 ORDER BY IF(mr.phonenbr IS NULL,1,0), STR_TO_DATE(mt.birthdate, '%m/%d/%Y') LIMIT 1) LEFT JOIN muusa_phonenumbers mr ON mp.camperid=mr.camperid AND mr.phonetypeid=1001 WHERE mc.programname!='Adult' ORDER BY mc.programname, mc.lastname, mc.firstname";
		$db->setQuery($query);
		return $db->loadAssocList("camperid");
	}

	function getSponsors() {
		$db =& JFactory::getDBO();
		$query = "SELECT mv.camperid, CONCAT(mp.firstname, ' ', mp.lastname) fullname, (SELECT phonenbr FROM muusa_phonenumbers mcs WHERE mcs.phonetypeid=1001 AND mcs.camperid=mp.camperid) phonenbr, mp.email, mp.roomnbr room FROM (muusa_campers_v mv, muusa_campers_v mp) WHERE mv.sponsor IS NOT NULL AND mv.sponsor LIKE CONCAT('%', mp.lastname, '%') AND mv.sponsor LIKE CONCAT('%', mp.firstname, '%')";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}