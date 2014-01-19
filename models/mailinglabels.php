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
class muusla_toolsModelmailinglabels extends JModel
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
   
   function getAllAddresses() {
      $db =& JFactory::getDBO();
      $query = "SELECT IF(COUNT(f.id)>1, CONCAT('The ', f.name, ' Family'), CONCAT( c.firstname,  ' ', c.lastname)) familyname, f.address1, f.address2, f.city, f.statecd, f.zipcd FROM muusa_family f, muusa_camper c WHERE f.id=c.familyid GROUP BY f.id ORDER BY f.name";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
   
   function getRegAddresses() {
      $db =& JFactory::getDBO();
      $query = "SELECT IF(COUNT(tf.id)>1, CONCAT('The ', tf.name, ' Family'), CONCAT( tc.firstname,  ' ', tc.lastname)) familyname, tf.address1, tf.address2, tf.city, tf.statecd, tf.zipcd FROM muusa_thisyear_family tf, muusa_thisyear_camper tc WHERE tf.id=tc.familyid GROUP BY tf.id ORDER BY tf.name";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
   
   function getLastAddresses($x) {
      $db =& JFactory::getDBO();
      $query = "SELECT IF(COUNT(f.id)>1, CONCAT('The ', f.name, ' Family'), CONCAT( c.firstname,  ' ', c.lastname)) familyname, f.address1, f.address2, f.city, f.statecd, f.zipcd FROM muusa_family f, muusa_camper c, muusa_yearattending ya, muusa_year y WHERE f.id=c.familyid AND c.id=ya.camperid AND ya.year>=y.year-$x AND y.is_current=1 GROUP BY f.id ORDER BY f.name";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
   
   function getCamperAddress($id) {
      $db =& JFactory::getDBO();
      $query = "SELECT IF(COUNT(f.id)>1, CONCAT('The ', f.name, ' Family'), CONCAT( c.firstname,  ' ', c.lastname)) familyname, f.address1, f.address2, f.city, f.statecd, f.zipcd FROM muusa_family f, muusa_camper c WHERE f.id=c.familyid AND f.id=(SELECT cp.familyid FROM muusa_camper cp WHERE cp.id=$id) GROUP BY f.id";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
}