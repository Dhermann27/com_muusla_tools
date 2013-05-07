<?php
/**
 * @package		muusla_tools
 * @license		GNU/GPL, see LICENSE.php
 */

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the muusla_tools Component
 *
 * @package		muusla_tools
 */
class muusla_toolsViewassignroom extends JView
{
   function display($tpl = null) {
      $model =& $this->getModel();
      $user =& JFactory::getUser();
      $editcamper = JRequest::getVar($this->getSafe("editcamper"));
      $admin = $editcamper && (in_array("8", $user->groups) || in_array("10", $user->groups));
      if($admin && preg_match('/^\d+$/', $editcamper)) {
         foreach(JRequest::get() as $key=>$value) {
            if(preg_match('/^fiscalyear-roomid-(\d+)$/', $key, $objects)) {
               $obj = new stdClass;
               $obj->fiscalyearid = $this->getSafe($objects[1]);
               $obj->modified_by = $user->username;
               $obj->modified_at = date("Y-m-d H:i:s");
               $obj->roomid = $this->getSafe($value);
               $model->assignRoom($obj);
            }
         }
         $this->assignRef('editcamper', $editcamper);
         $campers = $model->getCampers($editcamper);
         $fiscalyearids = array();
         $camperids = array();
         foreach($campers as $camper) {
            array_push($fiscalyearids, $camper->fiscalyearid);
            array_push($camperids, $camper->camperid);
         }
         $fiscalyearids = implode(",", $fiscalyearids);
         $camperids = implode(",", $camperids);
         $roomtypes = $model->getRoomtypes($fiscalyearids);
         $roommates = $model->getRoommates($fiscalyearids);
         $prevrooms = $model->getPreviousRooms($camperids);
         $rooms = array();
         foreach($campers as $camper) {
            $tooltip = "";
            if(count($roomtypes) > 0 ) {
               $types = "";
               foreach($roomtypes as $type) {
                  if($camper->fiscalyearid == $type->fiscalyearid)
                     $types .= "$type->name<br />\n";
               }
               if($types != "") {
                  $tooltip .= "<u>Desired Room Types</u><br />\n" . $types;
               }
            }
            if(count($roommates) > 0 ) {
               $mates = "";
               foreach($roommates as $mate) {
                  if($camper->fiscalyearid == $mate->fiscalyearid)
                     $mates .= "$mate->name<br />\n";
               }
               if($mates != "") {
                  $tooltip .= "<u>Desired Roommates</u><br />\n" . $mates;
               }
            }
            if(count($prevrooms) > 0 ) {
               $prooms = "";
               foreach($prevrooms as $room) {
                  if($camper->camperid == $room->camperid)
                     $prooms .= "$room->fiscalyear: $room->name $room->roomnbr<br />\n";
               }
               if($prooms != "") {
                  $tooltip .= "<u>Previous Rooms</u><br />\n" . $prooms;
               }
            }
            $camper->tooltip = $tooltip;
            if($rooms[$camper->roomid] != null) {
               array_push($rooms[$camper->roomid], $camper);
            } else {
               $rooms[$camper->roomid] = array($camper);
            }
         }
         $this->assignRef('campers', $rooms);
         $this->assignRef('buildings', $model->getRooms());
      }

      parent::display($tpl);
   }

   function getSafe($obj)
   {
      return htmlspecialchars(trim($obj), ENT_QUOTES);
   }

}
?>
