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
   function getCampers() {
      $db =& JFactory::getDBO();
      $query = "SELECT c.id, c.firstname, c.lastname, f.city, f.statecd FROM muusa_camper c, muusa_family f WHERE c.familyid=f.id ORDER BY f.name, c.birthdate";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
   
   function getYear() {
      $db =& JFactory::getDBO();
      $query = "SELECT year FROM muusa_year WHERE is_current=1";
      $db->setQuery($query);
      return $db->loadResult();
   }
   
   function getNametag($where) {
      $db =& JFactory::getDBO();
      $query = "SELECT tc.firstname, tc.lastname, tc.city, tc.statecd, tc.churchname, tsp.staffpositionname FROM muusa_thisyear_camper tc LEFT JOIN muusa_thisyear_staff tsp ON tc.id=tsp.camperid GROUP BY tc.id ORDER BY tc.familyname, tc.familyid, tc.birthdate DESC";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
}