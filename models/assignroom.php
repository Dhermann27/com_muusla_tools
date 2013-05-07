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
      $query = "SELECT fiscalyearid, camperid, sexcd, firstname, lastname, programname, roomid FROM muusa_campers_v WHERE familyid=$familyid ORDER BY STR_TO_DATE(birthdate, '%m/%d/%Y')";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
   
   function getRoomtypes($fiscalids) {
      $db =& JFactory::getDBO();
      $query = "SELECT mrp.fiscalyearid, mb.name name FROM muusa_roomtype_preferences mrp, muusa_buildings mb WHERE mrp.buildingid=mb.buildingid AND mrp.fiscalyearid IN ($fiscalids) ORDER BY mrp.choicenbr";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
   
   function getRoommates($fiscalids) {
      $db =& JFactory::getDBO();
      $query = "SELECT fiscalyearid, name FROM muusa_roommate_preferences WHERE fiscalyearid IN ($fiscalids) ORDER BY choicenbr";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
   
   function getPreviousRooms($camperids) {
      $db =& JFactory::getDBO();
      $query = "SELECT mf.camperid, mf.fiscalyear, mb.name name, mr.roomnbr FROM muusa_fiscalyear mf, muusa_rooms mr, muusa_buildings mb, muusa_currentyear my WHERE mf.roomid=mr.roomid AND mr.buildingid=mb.buildingid AND mf.fiscalyear!=my.year AND mf.roomid!=0 AND mf.camperid IN ($camperids) ORDER BY mf.fiscalyear DESC";
      $db->setQuery($query);
      return $db->loadObjectList();
   }

   function getRooms() {
      $db =& JFactory::getDBO();
      $query = "SELECT mr.roomid roomid, mb.buildingid buildingid, mb.name buildingname, mr.roomnbr roomnbr, mr.capacity capacity, mr.is_handicap is_handicap, (SELECT COUNT(*) FROM muusa_fiscalyear mf, muusa_currentyear my WHERE mf.roomid=mr.roomid AND mf.fiscalyear=my.year) current FROM muusa_buildings mb LEFT OUTER JOIN muusa_rooms mr ON mr.buildingid=mb.buildingid WHERE mr.is_workshop=0 ORDER BY mb.buildingid, mr.roomnbr";
      $db->setQuery($query);
      $results = $db->loadObjectList();
      $buildings = array();
      $counter = -1;
      foreach($results as $result) {
         if($counter == -1 || $buildings[$counter]->buildingid != $result->buildingid) {
            $building = new stdClass;
            $building->buildingid = $result->buildingid;
            $building->buildingname = $result->buildingname;
            $building->rooms = array();
            $buildings[++$counter] = $building;
         }
         if($result->roomid) {
            $room = new stdClass;
            $room->roomid = $result->roomid;
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
      $db->updateObject("muusa_fiscalyear", $obj, "fiscalyearid");
   }
}