<?php defined('_JEXEC') or die('Restricted access'); ?>
<link type="text/css"
   href="<?php echo JURI::root(true);?>/components/com_muusla_application/css/application.css"
   rel="stylesheet" />
<script
   src="<?php echo JURI::root(true);?>/components/com_muusla_tools/js/assignroom.js"></script>
<div id="ja-content">
   <form method="post">
      <?php if($this->editcamper) {
         echo "<input type='hidden' id='editcamper' name='editcamper' value='$this->editcamper' />\n";
         echo "<div style='float: right;'><button id='toRegister'>Do not Save<br />Proceed to Registration Form</button></div>\n";
         echo "<div><button id='toSelection'>Return<br />to Camper Selection</button></div>\n";
      }?>
      <div id="muusaApp">
         <div class="componentheading">
            Assign Room<br /> <i>To unassign, drag them to the right
               side and set the drop to "No Room Assigned"</i>
         </div>
         <h5>Unassigned Campers</h5>
         <table>
            <tr valign="top">
               <td>
                  <ul
                     class="connected connectedRoomlist roomlist-no left">
                     <?php 
                     if(count($this->campers[0]) > 0) {
                        foreach($this->campers[0] as $camper) {
                           echo "                  <li value='$camper->yearattendingid' ";
                           if($camper->tooltip != "") {
                              echo "title='$camper->tooltip' ";
                           }
                           echo "class='muusatip ui-state-default'>($camper->sexcd) $camper->firstname $camper->lastname ($camper->programname)</li>\n";
                        }
                     }
                     ?>
                  </ul>
               </td>
               <td><?php
               $roomid = 0;
               include 'blocks/rooms.php';
               if(count($this->campers) > 0) {
                  foreach($this->campers as $roomid => $campers) {
                     if($roomid != 0) {
                        include 'blocks/rooms.php';
                     }
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
