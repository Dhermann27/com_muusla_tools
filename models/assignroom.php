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
class muusla_toolsModelassignroom extends JModel
{
   function getCampers($familyid) {
      $db =& JFactory::getDBO();
      $query = "SELECT tc.yearattendingid, tc.id, tc.sexcd, tc.firstname, tc.lastname, tc.programname, tc.roomid, muusa_isprereg(tc.id, (SELECT year FROM muusa_year WHERE is_current=1)) prereg FROM muusa_thisyear_camper tc WHERE familyid=$familyid ORDER BY STR_TO_DATE(tc.birthdate, '%m/%d/%Y')";
      $db->setQuery($query);
      return $db->loadObjectList();
   }

   function getRoommates($yearattendingids) {
      $db =& JFactory::getDBO();
      $query = "SELECT yearattendingid, name FROM muusa_roommatepreference WHERE yearattendingid IN ($yearattendingids) ORDER BY choicenbr";
      $db->setQuery($query);
      return $db->loadObjectList();
   }

   function getPreviousRooms($camperids) {
      $db =& JFactory::getDBO();
      $query = "SELECT ya.camperid, ya.year, b.name, r.roomnbr FROM muusa_yearattending ya, muusa_room r, muusa_building b, muusa_year y WHERE ya.roomid=r.id AND r.buildingid=b.id AND ya.year!=y.year AND y.is_current AND ya.roomid!=0 AND ya.camperid IN ($camperids) ORDER BY ya.year DESC";
      $db->setQuery($query);
      return $db->loadObjectList();
   }

   function getRooms() {
      $db =& JFactory::getDBO();
      $query = "SELECT r.id, b.id buildingid, b.name buildingname, r.roomnbr, r.capacity, r.is_handicap, (SELECT COUNT(*) FROM muusa_yearattending ya, muusa_year y WHERE ya.roomid=r.id AND ya.year=y.year AND y.is_current=1) current FROM muusa_building b LEFT OUTER JOIN muusa_room r ON r.buildingid=b.id WHERE r.is_workshop=0 ORDER BY b.id, r.roomnbr";
      $db->setQuery($query);
      $results = $db->loadObjectList();
      $buildings = array();
      $counter = -1;
      foreach($results as $result) {
         if($counter == -1 || $buildings[$counter]->id != $result->buildingid) {
            $building = new stdClass;
            $building->id = $result->buildingid;
            $building->name = $result->buildingname;
            $building->rooms = array();
            $buildings[++$counter] = $building;
         }
         if($result->id) {
            $room = new stdClass;
            $room->id = $result->id;
            $room->roomnbr = $result->roomnbr;
            $room->current = $result->current;
            $room->capacity = $result->capacity;
            $room->is_handicap = $result->is_handicap;
            $buildings[$counter]->rooms[] = $room;
         }
      }
      return $buildings;
   }

   function assignRoom($obj) {
      $db =& JFactory::getDBO();
      $db->updateObject("muusa_yearattending", $obj, "id");
   }
}