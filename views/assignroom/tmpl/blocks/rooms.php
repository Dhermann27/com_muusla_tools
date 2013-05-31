<?php defined('_JEXEC') or die('Restricted access');
/**
 * rooms.php
 * XHTML Block containing the editable charge block
 *
 * @param   object  $roomid   The database roomid to match
 * @param   object  $campers  The database campers objects in this room
 *
 */
?>
<div class="room">
   <select class="roomlist ui-corner-top" style="font-size: 1.5em;">
      <option value="0">No Room Assigned</option>
      <?php 
      foreach ($this->buildings as $building) {
         echo "                  <optgroup label='$building->buildingname'>\n";
         foreach($building->rooms as $room) {
            if($room->is_handicap == "1") {
               $ishandicap = " (Handicapped)";
            } else {
               $ishandicap = "";
            }
            if($room->current == "0") {
               $style = "";
            } else {
               $style = " style='background-color:IndianRed'";
            }
            if(count($campers) > 0 && $roomid == $room->roomid) {
               $selected = " selected='selected'";
            } else {
               $selected = "";
            }
            echo "                     <option value='$room->roomid'$style$selected>$room->roomnbr ($room->current / $room->capacity) $ishandicap</option>\n";
         }
         echo "                  </optgroup>\n";
      }?>
   </select>
   <ul class="connected connectedRoomlist roomlist-yes">
      <?php 
      if(count($campers) > 0) {
         foreach($campers as $camper) {
            echo "                  <li value='$camper->fiscalyearid' title='$camper->tooltip' class='muusatip ui-state-default'>($camper->sexcd) $camper->firstname $camper->lastname ($camper->programname)</li>\n";
         }
      }?>
   </ul>
</div>
