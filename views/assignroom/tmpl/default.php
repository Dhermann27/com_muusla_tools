<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="ja-content">
<div class="componentheading">Assign Room</div>
<form
	action="index.php?option=com_muusla_tools&task=save&view=assignroom&Itemid=90"
	method="post">
<script>
   var previous;
   function showData(obj) {
	   if(previous != null) {
		   previous.style.display = 'none';
	   }
	   previous = document.getElementById("data" + obj.options[obj.selectedIndex].value);
	   previous.style.display = 'block';
   }
</script>
<table class="blog" cellpadding="0" cellspacing="0">
<?php
echo "      <tr>\n";
echo "         <td valign='top'>\n";
echo "            <div>\n";
echo "            <div class='contentpaneopen'>\n";
echo "               <h2 class='contentheading'>Assign Room to Household</h2>\n";
echo "               <h3><i>Ignores children in the Meyer and Burt Programs</i></h3>\n";
echo "            </div>\n";
echo "            <div class='article-content'>\n";
echo "               <select name='hohid' onchange='showData(this);'>\n";
echo "                  <option value='0' selected>Select a Camper</option>\n";
foreach ($this->campers as $camper) {
	echo "                  <option value='$camper->camperid'>$camper->lastname, $camper->firstname ($camper->city, $camper->statecd)</option>\n";
}
echo "               </select><br /><br />\n";
echo "               <select name='hohroom'>\n";
echo "                  <option value='0' selected>Unassigned</option>\n";
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
		echo "                     <option value='$room->roomid'$style>$room->roomnbr ($room->current / $room->capacity) $ishandicap</option>\n";
	}
	echo "                  </optgroup>\n";
}
echo "               </select><br /><br />\n";
$prev = 0;
foreach($this->data as $data) {
	if($prev != $data->camperid) {
		if($prev != 0) {
			echo "               </p>\n";
		}
		echo "               <p id='data$data->camperid' style='display: none;'><b>$data->firstname $data->lastname</b><br />\n";
		if($data->mp1name != "") {
			echo "                  Room Preference #1: $data->mp1name<br />\n";
		}
		if($data->mp2name != "") {
			echo "                  Room Preference #2: $data->mp2name<br />\n";
		}
		if($data->mp3name != "") {
			echo "                  Room Preference #3: $data->mp3name<br />\n";
		}
	}
	echo "                  $data->fiscalyear Room: $data->room<br />\n";
	$prev = $data->camperid;
}
echo "               </p>\n";
echo "            <span class='article_separator'>&nbsp;</span>\n";
echo "            </div>\n";
echo "            <input type='submit' value='Save' class='Button' /></form>\n";
echo "         </td>\n";
echo "      </tr>\n";
?>
</table>

</div>
