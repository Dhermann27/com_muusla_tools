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
class muusla_toolsModelinvoices extends JModel
{
   // Imported from All Workshops Report
   function getWorkshops() {
      $db =& JFactory::getDBO();
      $query = "SELECT w.id, CONCAT(w.su, w.m, w.t, w.w, w.th, w.f, w.sa) days, CONCAT(IF(w.su,'S',''),IF(w.m,'M',''),IF(w.t,'Tu',''),IF(w.w,'W',''),IF(w.th,'Th',''),IF(w.f,'F',''),IF(w.sa,'S','')) dispdays, r.roomnbr roomname, t.id timeslotid, t.name timename, w.name workshopname, w.capacity, t.starttime FROM (muusa_workshop w, muusa_timeslot t) LEFT JOIN muusa_room r ON w.roomid=r.id WHERE w.timeslotid=t.id ORDER by t.starttime, w.name";
      $db->setQuery($query);
      return $db->loadAssocList("id");
   }

   function getAttendees() {
      $db =& JFactory::getDBO();
      $query = "SELECT yw.workshopid, c.familyid, c.id, c.firstname, c.lastname, yw.choicenbr, yw.is_leader FROM muusa_yearattending__workshop yw, muusa_yearattending ya, muusa_camper c, muusa_year y WHERE yw.yearattendingid=ya.id AND ya.camperid=c.id AND ya.year=y.year AND y.is_current=1 ORDER BY yw.is_leader DESC, IFNULL(ya.paydate, NOW()), yw.choicenbr";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
   // End Import

   function getCampers() {
      $db =& JFactory::getDBO();
      $query = "SELECT tc.familyid, tc.firstname, tc.lastname, tf.city, tf.statecd FROM muusa_thisyear_camper tc, muusa_thisyear_family tf WHERE tc.familyid=tf.id ORDER BY tf.name, tc.birthdate";
      $db->setQuery($query);
      return $db->loadObjectList();
   }

   function getCount() {
      $db =& JFactory::getDBO();
      $query = "SELECT COUNT(*) FROM muusa_thisyear_family";
      $db->setQuery($query);
      return $db->loadResult();
   }

   function getYear() {
      $db =& JFactory::getDBO();
      $query = "SELECT year FROM muusa_year WHERE is_current=1";
      $db->setQuery($query);
      return $db->loadResult();
   }

   function getLetters($where) {
      $db =& JFactory::getDBO();
      $query = "SELECT id, name, address1, address2, city, statecd, zipcd FROM muusa_thisyear_family $where";
      $db->setQuery($query);
      $families = $db->loadObjectList();
      foreach($families as $family) {
         $query = "SELECT firstname, lastname, email, buildingname, roomnbr, programid, programname, age, birthday, grade FROM muusa_thisyear_camper WHERE familyid=$family->id";
         $db->setQuery($query);
         $family->children = $db->loadObjectList();

         $query = "SELECT CONCAT(tp.firstname, ' ', tp.lastname) fullname, tp.buildingname, tp.roomnbr FROM muusa_thisyear_camper tc, muusa_thisyear_camper tp WHERE tc.buildingid IN (1000,1001,1002,1003) AND tc.familyid=$family->id AND tp.familyid!=tc.familyid AND tc.roomid=tp.roomid AND tp.roomid!=0 GROUP BY fullname ORDER BY tc.roomid";
         $db->setQuery($query);
         $family->roommates = $db->loadObjectList();

         $query = "SELECT chargetypename, FORMAT(amount,2) amount, DATE_FORMAT(timestamp, '%m/%d/%Y') timestamp, memo FROM muusa_thisyear_charge WHERE familyid=$family->id";
         $db->setQuery($query);
         $family->charges = $db->loadObjectList();

         $query = "SELECT firstname, lastname, volunteerpositionname FROM muusa_thisyear_volunteer WHERE familyid=$family->id";
         $db->setQuery($query);
         $family->volunteers = $db->loadObjectList();
      }
      return $families;
   }
}