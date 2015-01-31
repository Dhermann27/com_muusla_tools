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
class muusla_toolsModelworkshops extends JModelItem
{
   function getWorkshops() {
      $db = JFactory::getDBO();
      $query = "SELECT me.eventid eventid, CONCAT(me.su, me.m, me.t, me.w, me.th, me.f, me.sa) days, CONCAT(IF(me.su,'S',''),IF(me.m,'M',''),IF(me.t,'Tu',''),IF(me.w,'W',''),IF(me.th,'Th',''),IF(me.f,'F',''),IF(me.sa,'S','')) dispdays, CONCAT(mb.name, ' ', mr.roomnbr) roomname, mt.name timename, me.name workshopname, me.capacity capacity, mt.starttime starttime FROM muusa_events me, muusa_buildings mb, muusa_rooms mr, muusa_times mt WHERE me.roomid=mr.roomid AND mr.buildingid=mb.buildingid AND me.timeid=mt.timeid ORDER by mt.starttime, me.name";
      $db->setQuery($query);
      return $db->loadAssocList("eventid");
   }

   function getAttendees() {
      $db = JFactory::getDBO();
      $query = "SELECT ma.eventid eventid, mc.camperid camperid, CONCAT(mc.lastname, ', ', mc.firstname) fullname, ma.choicenbr choicenbr, ma.is_leader is_leader, mc.email email FROM muusa_attendees ma, muusa_campers mc, muusa_fiscalyear mf, muusa_events me, muusa_currentyear my WHERE ma.fiscalyearid=mf.fiscalyearid AND mc.camperid=mf.camperid AND ma.eventid=me.eventid AND mf.fiscalyear=my.year ORDER BY ma.is_leader DESC, mf.postmark, ma.choicenbr";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
}
