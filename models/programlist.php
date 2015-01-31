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
class muusla_toolsModelprogramlist extends JModelItem
{
   function getPrograms() {
      $db = JFactory::getDBO();
      $query = "SELECT p.id, p.name FROM muusa_program p, muusa_year y WHERE p.name!='Adult' AND p.start_year<=y.year AND p.end_year>=y.year AND y.is_current=1 ORDER BY p.name";
      $db->setQuery($query);
      return $db->loadAssocList("id");
   }

   function getCampers() {
      $db = JFactory::getDBO();
      $query = "SELECT tc.firstname, tc.lastname, tc.programid, tc.programname, tc.age, tc.grade, CONCAT(tcp.firstname , ' ', tcp.lastname) pfullname, tcp.email pemail, (SELECT n.phonenbr FROM muusa_phonenumber n WHERE tcp.id=n.camperid AND n.phonetypeid=1001 LIMIT 1) pphonenbr, tcp.roomnbr proomnbr FROM muusa_thisyear_camper tc LEFT JOIN muusa_thisyear_camper tcp ON tcp.id=(SELECT tcq.id FROM muusa_thisyear_camper tcq LEFT JOIN muusa_phonenumber n ON tcq.id=n.camperid AND n.phonetypeid=1001 WHERE tc.familyid=tcq.familyid AND tc.id!=tcq.id AND tcq.age>17 ORDER BY IF(n.phonenbr IS NULL,1,0), tcq.birthdate LIMIT 1) WHERE (tc.sponsor='' OR tc.sponsor IS NULL) AND tc.programname!='Adult'  UNION ALL SELECT tc.firstname, tc.lastname, tc.programid, tc.programname, tc.age, tc.grade, CONCAT(tcp.firstname , ' ', tcp.lastname) pfullname, tcp.email pemail, (SELECT n.phonenbr FROM muusa_phonenumber n WHERE tcp.id=n.camperid AND n.phonetypeid=1001 LIMIT 1) pphonenbr, tcp.roomnbr proomnbr FROM muusa_thisyear_camper tc LEFT JOIN muusa_thisyear_camper tcp ON tcp.id=(SELECT tcq.id FROM muusa_thisyear_camper tcq LEFT JOIN muusa_phonenumber n ON tcq.id=n.camperid AND n.phonetypeid=1001 WHERE tc.sponsor LIKE CONCAT('%', tcq.firstname, '%') AND tc.sponsor LIKE CONCAT('%', tcq.lastname, '%') LIMIT 1) WHERE tc.sponsor!='' AND tc.programname!='Adult' ORDER BY lastname, firstname";
      $db->setQuery($query);
      return $db->loadObjectList();
   }

}