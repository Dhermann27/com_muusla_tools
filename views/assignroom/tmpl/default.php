<?php defined('_JEXEC') or die('Restricted access'); ?>
<link type="text/css"
   href="<?php echo JURI::root(true);?>/components/com_muusla_application/css/application.css"
   rel="stylesheet" />
<link type="text/css"
   href="<?php echo JURI::root(true);?>/components/com_muusla_application/css/jquery-ui-1.10.0.custom.min.css"
   rel="stylesheet" />
<script
   src="<?php echo JURI::root(true);?>/components/com_muusla_application/js/jquery-1.9.1.min.js"></script>
<script
   src="<?php echo JURI::root(true);?>/components/com_muusla_application/js/jquery-ui-1.10.0.custom.min.js"></script>
<script
   src="<?php echo JURI::root(true);?>/components/com_muusla_tools/js/assignroom.js"></script>
<div id="ja-content">
   <form
      action="http://<? echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>"
      method="post">
      <?php if($this->editcamper) {
         echo "<input type='hidden' name='editcamper' value='$this->editcamper' />\n";
         //echo "<div style='float: right;'><button id='forwardRoom'>Do not Save<br />Proceed to Room Selection</button></div>\n";
         echo "<div><button id='backDetails'>Return<br />to Camper Details</button></div>\n";
      }?>
      <div id="muusaApp">
         <div class="componentheading">Assign Room<br />
         <i>To unassign, drag them to the right side and set the drop to "No Room Assigned"</i></div>
         <h5>Unassigned Campers</h5>
         <table>
            <tr valign="top">
               <td>
                  <ul
                     class="connected connectedRoomlist roomlist-no left">
                     <?php 
                     if(count($this->campers[0]) > 0) {
                        foreach($this->campers[0] as $camper) {
                           echo "                  <li value='$camper->fiscalyearid' title='$camper->tooltip' class='ui-state-default'>($camper->sexcd) $camper->firstname $camper->lastname ($camper->programname)</li>\n";
                        }
                     }
                     ?>
                  </ul>
               </td>
               <td><?php
               $roomid = 0;
               include 'blocks/rooms.php';
               foreach($this->campers as $roomid => $campers) {
                  if($roomid != 0) {
                     include 'blocks/rooms.php';
                  }
               }
               ?>
               </td>
            </tr>
         </table>
         <div class="padtop clearboth" align="right">
            <button id="submitRooms">Assign Room</button>
         </div>
      </div>
      <span class="article_separator">&nbsp;</span>
   </form>
</div>
