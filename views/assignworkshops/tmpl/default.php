<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="ja-content">
<div class="componentheading">Assign Workshops</div>
<form
	action="index.php?option=com_muusla_tools&task=detail&view=assignworkshops&Itemid=91"
	method="post">
<table class="blog" cellpadding="0" cellspacing="0">
<?php
echo "      <tr>\n";
echo "         <td valign='top'>\n";
echo "            <div>\n";
echo "            <div class='contentpaneopen'>\n";
echo "               <h2 class='contentheading'>Assign Workshops</h2>\n";
echo "            </div>\n";
echo "            <div class='article-content'>\n";
echo "               <select name='hohid'>\n";
echo "                  <option value='0' selected>Select a Primary Camper</option>\n";
foreach ($this->campers as $camper) {
   echo "                  <option value='$camper->camperid'>$camper->lastname, $camper->firstname ($camper->city, $camper->statecd)</option>\n";
}
echo "               </select><br /><br />\n";echo "            </div>\n";
echo "            <span class='article_separator'>&nbsp;</span>\n";
echo "            </div>\n";
echo "            <input type='submit' value='Edit' class='Button' /></form>\n";
echo "         </td>\n";
echo "      </tr>\n";
?>
</table>

</div>
