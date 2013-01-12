<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="ja-content">
<div class="componentheading">Register Household</div>
</div>
<form
	action="index.php?option=com_muusla_tools&task=editcamper&view=register&Itemid=131"
	method="post">
<table class="blog" cellpadding="0" cellspacing="0">
<?php
if($this->hohid) {
	echo "<script type='text/javascript'>location.href = '/index.php?option=com_muusla_database&task=save&view=camperdetails&Itemid=71&editcamper=$this->hohid';</script>\n";
}
echo "      <tr>\n";
echo "         <td valign='top'>\n";
echo "            <div>\n";
echo "            <div class='contentpaneopen'>\n";
echo "               <h2 class='contentheading'>Select Primary Camper</h2>\n";
echo "            </div>\n";
echo "            <div class='article-content'>\n";
echo "               <select name='editcamper'>\n";
foreach ($this->campers as $camper) {
	echo "                  <option value='$camper->camperid'>$camper->lastname, $camper->firstname ($camper->city, $camper->statecd)</option>\n";
}
echo "               </select>\n";
echo "            </div>\n";
echo "            <p><input type='submit' value='Continue' class='Button' /></p></form>\n";
echo "            </div>\n";
echo "            <span class='article_separator'>&nbsp;</span>\n";
echo "         </td>\n";
echo "      </tr>\n";
?>
</table>
</form>
</div>
