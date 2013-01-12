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
class muusla_toolsModelassignworkshops extends JModel
{
   function getCampers() {
      $db =& JFactory::getDBO();
      $query = "SELECT camperid, firstname, lastname, city, statecd FROM muusa_campers WHERE hohid=0 ORDER BY lastname, firstname, statecd, city";
      $db->setQuery($query);
      return $db->loadObjectList();
   }

   function getFamily($id) {
      $db =& JFactory::getDBO();
      $query = "SELECT mc.camperid, CONCAT(mc.firstname, ' ', mc.lastname) fullname, mp.name programname FROM muusa_campers mc, muusa_programs mp WHERE mc.programid=mp.programid AND (camperid=$id OR hohid=$id) ORDER BY hohid, birthdate";
      $db->setQuery($query);
      return $db->loadObjectList();
   }

   function getChoices($id) {
      $db =& JFactory::getDBO();
      $query = "SELECT eventid, choicenbr FROM muusa_attendees WHERE camperid=" . $id;
      $db->setQuery($query);
      return $db->loadObjectList();
   }

   function getWorkshops($starttime) {
      $db =& JFactory::getDBO();
      $query = "SELECT me.eventid, me.name FROM muusa_events me, muusa_times mt WHERE me.timeid=mt.timeid AND me.is_required=0 AND me.is_mealtime=0 AND starttime='" . $starttime . "' ORDER BY me.name";
      $db->setQuery($query);
      return $db->loadObjectList();
   }

   function upsertAttendees($camperid, $choicenbr) {
      $db =& JFactory::getDBO();
      $query = "DELETE FROM muusa_attendees WHERE camperid=" . $camperid . " AND choicenbr=" . $choicenbr . " AND eventid NOT IN (SELECT eventid FROM muusa_events WHERE is_required=1 OR is_mealtime=1)";
      $db->setQuery($query);
      $db->query();
      if($db->getErrorNum()) {
         JError::raiseError(500, $db->stderr());
      }

      if(JRequest::getSafe("campermorning-$camperid-$choicenbr") != "0") {
         $obj = new stdClass;
         $obj->eventid = JRequest::getSafe("campermorning-$camperid-$choicenbr");
         $obj->camperid = $camperid;
         $obj->choicenbr = $choicenbr;
         $obj->is_leader = 0;
         $db->insertObject("muusa_attendees", $obj);
         if($db->getErrorNum()) {
            JError::raiseError(500, $db->stderr());
         }
      }

      if(JRequest::getSafe("camperearlyafternoon-$camperid-$choicenbr") != "0") {
         $obj = new stdClass;
         $obj->eventid = JRequest::getSafe("camperearlyafternoon-$camperid-$choicenbr");
         $obj->camperid = $camperid;
         $obj->choicenbr = $choicenbr;
         $obj->is_leader = 0;
         $db->insertObject("muusa_attendees", $obj);
         if($db->getErrorNum()) {
            JError::raiseError(500, $db->stderr());
         }
      }

      if(JRequest::getSafe("camperlateafternoon-$camperid-$choicenbr") != "0") {
         $obj = new stdClass;
         $obj->eventid = JRequest::getSafe("camperlateafternoon-$camperid-$choicenbr");
         $obj->camperid = $camperid;
         $obj->choicenbr = $choicenbr;
         $obj->is_leader = 0;
         $db->insertObject("muusa_attendees", $obj);
         if($db->getErrorNum()) {
            JError::raiseError(500, $db->stderr());
         }
      }
   }
}