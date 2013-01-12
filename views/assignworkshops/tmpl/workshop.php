<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="ja-content">
<div class="componentheading">MUUSA 2009 Registation Form</div>
<form
	action="index.php?option=com_muusla_tools&task=detail&view=assignworkshops&Itemid=91"
	method="post">
<table class="blog" cellpadding="0" cellspacing="0">
<?php
echo "      <tr>\n";
echo "         <td valign='top'>\n";
echo "            <div class='contentpaneopen'>\n";
echo "               <h2 class='contentheading'>Workshop Selections</h2>\n";
echo "            </div>\n";
echo "            <div class='article-content'>\n";
echo "            <input type='hidden' name='hohid' value='$this->camperid' />\n";
echo "            <table width='100%'>\n";
foreach($this->campers as $camper) {
   echo "               <tr>\n";
   echo "                  <td align='right'>&nbsp;</td>\n";
   echo "                  <td><b>$camper->fullname</b></td>\n";
   echo "               </tr>\n";
   if($camper->workshop != "0") {
      echo "               <tr>\n";
      echo "                  <td align='right'>&nbsp;</td>\n";
      echo "                  <td><i>$camper->workshop</i></td>\n";
      echo "               </tr>\n";
   } else {
      for($i=1; $i<4; $i++) {
         echo "               <tr>\n";
         echo "                  <td align='right'>Morning Workshop Choice #$i: </td>\n";
         echo "                  <td><select name='campermorning-$camper->camperid-$i'>\n";
         echo "                     <option value='0'>No Workshop</option>\n";
         foreach($this->morning as $workshop) {
            $selected = "";
            foreach($camper->choices as $choice) {
               if($workshop->eventid == $choice->eventid && $i == $choice->choicenbr) {
                  $selected = " selected";
               }
            }
            echo "                     <option value='$workshop->eventid'$selected>$workshop->name</option>\n";
         }
         echo "                  </td>\n";
         echo "               </tr>\n";
      }
      for($i=1; $i<4; $i++) {
         echo "               <tr>\n";
         echo "                  <td align='right'>Early Afternoon Workshop Choice #$i: </td>\n";
         echo "                  <td><select name='camperearlyafternoon-$camper->camperid-$i'>\n";
         echo "                     <option value='0'>No Workshop</option>\n";
         foreach($this->earlyafternoon as $workshop) {
            $selected = "";
            foreach($camper->choices as $choice) {
               if($workshop->eventid == $choice->eventid && $i == $choice->choicenbr) {
                  $selected = " selected";
               }
            }
            echo "                     <option value='$workshop->eventid'$selected>$workshop->name</option>\n";
         }
         echo "                  </td>\n";
         echo "               </tr>\n";
      }
      for($i=1; $i<4; $i++) {
         echo "               <tr>\n";
         echo "                  <td align='right'>Late Afternoon Workshop Choice #$i: </td>\n";
         echo "                  <td><select name='camperlateafternoon-$camper->camperid-$i'>\n";
         echo "                     <option value='0'>No Workshop</option>\n";
         foreach($this->lateafternoon as $workshop) {
            $selected = "";
            foreach($camper->choices as $choice) {
               if($workshop->eventid == $choice->eventid && $i == $choice->choicenbr) {
                  $selected = " selected";
               }
            }
            echo "                     <option value='$workshop->eventid'$selected>$workshop->name</option>\n";
         }
         echo "                  </td>\n";
         echo "               </tr>\n";
      }
   }
}
echo "            </table>\n";
echo "            </div>\n";
echo "            <span class='article_separator'>&nbsp;</span>\n";
echo "            </div>\n";
echo "            <p align='center'><input type='submit' value='Save' class='Button' /></form></p>\n";
echo "            <span class='article_separator'>&nbsp;</span>\n";
echo "         </td>\n";
echo "      </tr>\n";
?>
</table>

</div>
