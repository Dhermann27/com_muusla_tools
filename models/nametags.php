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
   function getCampers($where) {
      $db =& JFactory::getDBO();
      $query = "SELECT CONCAT(mc.firstname, ' ', mc.lastname) fullname, mc.city, mc.statecd, mc.churchname, mp.positionname, IF(COUNT(mf.fiscalyearid)=1, 'New Camper',IF(COUNT(CASE WHEN mf.fiscalyear>2007 THEN 1 ELSE NULL END)=1, 'New to Trout Lodge','')) new FROM (muusa_campers_v mc, muusa_fiscalyear mf) LEFT JOIN muusa_credits_v mp ON mc.camperid=mp.camperid WHERE mc.camperid=mf.camperid $where GROUP BY mc.camperid ORDER BY mc.familyname, mc.familyid, STR_TO_DATE('%m/%d/%Y', mc.birthdate) DESC";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
}