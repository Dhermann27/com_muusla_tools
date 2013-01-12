<?php defined('_JEXEC') or die('Restricted access'); ?>
<script
	type='text/javascript' language='Javascript'
	src='components/com_muusla_application/js/application.js'></script>
<script type='text/javascript' language='Javascript'>
function switchCamper(i) {
	var obj = document.getElementById("camper" + i);
	obj.style.display = obj.style.display == "" ? "none" : "";
}
</script>
<div id="ja-content">
<div class="componentheading">Register Household</div>
<form name="application" action="index.php?option=com_muusla_tools&task=save&view=register&Itemid=131" method="post">
<table class="blog" cellpadding="0" cellspacing="0">
<?php
if($this->camper) {
	$camper = $this->camper;
}
echo "      <tr>\n";
echo "         <td valign='top'>\n";
echo "            <div>\n";
echo "            <div class='contentpaneopen'>\n";
echo "               <h2 class='contentheading'>$camper->firstname $camper->lastname\n";
echo "               (<a href='index.php?option=com_muusla_database&task=save&view=campers&Itemid=71&editcamper=$camper->camperid'>Edit</a>)</h2>\n";
echo "               $camper->address1<br />\n";
if($camper->address2 != "") {
	echo "               $camper->address2<br />\n";
}
echo "               $camper->city, $camper->statecd $camper->zipcd $camper->country<br />\n";
echo "               $camper->email<br />\n";
foreach($this->camper->phonenbrs as $phonenumber) {
	echo "               $phonenumber->name) $phonenumber->phonenbr<br />\n";
}
echo "            </div>\n";
echo "            <div class='article-content'>\n";
echo "            <table>\n";
if($camper->birthdate) {
	$grade = $camper->age + $camper->gradeoffset;
}
if(!$camper->birthdate || $camper->hohid == "0" || $camper->age > 17) {
	echo "               <tr>\n";
	echo "                  <td colspan='2' align='right'>Birthdate (MM/DD/YYYY): </td>\n";
	echo "                  <td><input type='text' name='campers-birthdate-$camper->camperid' value='$camper->birthdate' size='20' maxlength='10' /></td>\n";
	echo "                  <td colspan='2'>Grade Entering in Fall 2012: \n";
	echo "                     <select name='campers-grade-$camper->camperid'>\n";
	echo "                        <option value='0'>Not Applicable</option>\n";
	echo "                        <option value='0'>Kindergarten or Earlier</option>\n";
	for($i=1; $i<13; $i++) {
		if($grade == $i) {
			$selected = " selected";
		} else {
			$selected = "";
		}
		echo "                        <option value='$i'$selected>$i</option>\n";
	}
	echo "                     </select>\n";
	echo "                  </td>";
	echo "               </tr>\n";
} else {
	echo "               <tr>\n";
	echo "                  <td colspan='2' align='right'>Birthdate: </td>\n";
	echo "                  <td>$camper->birthdate\n";
	echo "                     <input type='hidden' name='campers-birthdate-$camper->camperid' value='$camper->birthdate' /></td>\n";
	echo "                  <td colspan='2'>Grade Entering in Fall 2012: \n";
	echo "                     <input type='hidden' name='campers-grade-$camper->camperid' value='$camper->grade' />\n";
	echo "                     <select name='dummy' disabled>\n";
	echo "                        <option value='0'>Kindergarten or Earlier</option>\n";
	for($i=1; $i<13; $i++) {
		if($grade == $i) {
			$selected = " selected";
		} else {
			$selected = "";
		}
		echo "                        <option value='$i'$selected>$i</option>\n";
	}
	echo "                     </select>\n";
	echo "                  </td>";
	echo "               </tr>\n";
}
if(!$camper->birthdate || $camper->hohid == "0") {
	for($i=1; $i<4; $i++) {
		eval("\$roompref = \$camper->roomprefid$i;");
		echo "               <tr>\n";
		echo "                  <td colspan='2' align='right'>Room Preference #$i:</td>\n";
		echo "                  <td colspan='3'><select name='campers-roomprefid$i-$camper->camperid'>\n";
		echo "                     <option value='0'>No Preference</option>\n";
		foreach ($this->buildings as $building) {
			if($building->buildingid == $roompref) {
				$selected = " selected";
			} else {
				$selected = "";
			}
			echo "                        <option value='$building->buildingid'$selected>$building->name</option>\n";
		}
		echo "                  </select></td>\n";
		echo "               </tr>\n";
	}
	for($i=1; $i<4; $i++) {
		eval("\$matepref = \$camper->matepref$i;");
		echo "               <tr>\n";
		echo "                  <td colspan='2' align='right'>Roommate Preference #$i: </td>\n";
		echo "                  <td colspan='3'><input type='text' name='campers-matepref$i-$camper->camperid' size='50' maxlength='50' value='$matepref' /></td>\n";
		echo "               </tr>\n";
	}
}
echo "               <tr>\n";
echo "                  <td colspan='2' align='right'><input type='checkbox' name='campers-is_ymca-$camper->camperid' value='1'$camper->is_ymca/> YMCA</td>\n";
echo "                  <td colspan='3'>Applying for scholarship</td>\n";
echo "               </tr>\n";
echo "               <tr>\n";
echo "                  <td colspan='2' align='right'>Food Option: </td>\n";
echo "                  <td colspan='3'><select name='campers-foodoptionid-$camper->camperid'>\n";
foreach ($this->foodoptions as $foodoption) {
	if($foodoption->foodoptionid == $camper->foodoptionid) {
		$selected = " selected";
	} else {
		$selected = "";
	}
	echo "                  <option value='$foodoption->foodoptionid'$selected>$foodoption->name</option>\n";
}
echo "                  </select></td>\n";
echo "               </tr>\n";
if(!$camper->birthdate || $camper->hohid == "0") {
	echo "               <tr>\n";
	echo "                  <td colspan='2' align='right'>Sponsor:</td>\n";
	echo "                  <td colspan='3'><input type='text' value='$camper->sponsor' name='campers-sponsor-$camper->camperid' size='40' maxlength='50' />\n";
	echo "               </tr>\n";
	echo "               <tr>\n";
	echo "                  <td colspan='2' align='right'>Church Affiliation: </td>\n";
	echo "                  <td colspan='3'><select name='campers-churchid-$camper->camperid'>\n";
	echo "                     <option value='0'>No Affiliation</option>\n;";
	foreach ($this->churches as $church) {
		if($church->churchid == $camper->churchid) {
			$selected = " selected";
		} else {
			$selected = "";
		}
		echo "                  <option value='$church->churchid'$selected>$church->statecd - $church->city: $church->name</option>\n";
	}
	echo "                  </select></td>\n";
	echo "               </tr>\n";
} else {
	echo "               <input type='hidden' name='campers-churchid-$camper->camperid' value='$camper->churchid' />\n";
}
echo "               <tr>\n";
echo "                  <td colspan='2' valign='top' align='right'>Positions Held: </td>\n";
echo "                  <td colspan='3'><input type='hidden' name='volunteers-positionid-$camper->camperid' value='0' />\n";
echo "                     <select name='volunteers-positionid-$camper->camperid[]' size='5' multiple>\n";
$vol = "";
foreach($this->positions as $position) {
	echo "                        <option value='$position->positionid'>" . preg_replace('/^\(/', '(V', $position->name) . "</option>\n";
}
echo "                     </select> <br />Hold CTRL to select multiple positions.</td>\n";
echo "                </tr>\n";
echo "                <tr><td colspan='5'><hr /><h4>Registration</h4></td></tr>\n";
echo "                <tr>\n";
echo "                  <td colspan='2' align='right'>Postmark (MM/DD/YYYY):</td>\n";
echo "                  <td colspan='3'><input type='text' name='fiscalyear-postmark-0' size='10' />\n";
echo "                     <input type='hidden' name='fiscalyear-camperid-0' value='$camper->camperid' /></td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan='2' align='right'>Included Check:</td>\n";
echo "                  <td>\$<input type='text' name='charges-amount-0' value='0.00' size='5' /></td>\n";
echo "                  <td colspan='2'>Memo: <input type='text' name='charges-memo-0' size='20' />\n";
echo "                     <input type='hidden' name='charges-chargetypeid-0' value='1006' />\n";
echo "                     <input type='hidden' name='charges-camperid-0' value='$camper->camperid' /></td>\n";
echo "                </tr>\n";
$count = 1;
foreach($this->family as $child) {
	if($child->hohid != 0) {
		echo "               <tr>\n";
		echo "                  <td colspan='2' align='right'><b>$child->fullname</b></td>\n";
		echo "                  <td colspan='3'>(<a href='index.php?option=com_muusla_database&task=save&view=campers&Itemid=71&editcamper=$camper->camperid'>Edit</a>)\n";
		echo "                     <input type='checkbox' name='fiscalyear-camperid-" . $count++ . "' value='$child->camperid' onclick='switchCamper($child->camperid);' /> Check If Attending</td>\n";
		echo "               </tr>\n";
		if($child->birthdate) {
			$grade = $child->age + $child->gradeoffset;
		}
		echo "               <tr>\n";
		echo "                  <td colspan='2' align='right'>Birthdate (MM/DD/YYYY): </td>\n";
		echo "                  <td><input type='text' name='campers-birthdate-$child->camperid' value='$child->birthdate' size='20' maxlength='10' /></td>\n";
		echo "                  <td colspan='2'>Grade Entering in Fall 2012: \n";
		echo "                     <select name='campers-grade-$child->camperid'>\n";
		echo "                        <option value='0'>Not Applicable</option>\n";
		echo "                        <option value='0'>Kindergarten or Earlier</option>\n";
		for($i=1; $i<13; $i++) {
			if($grade == $i) {
				$selected = " selected";
			} else {
				$selected = "";
			}
			echo "                        <option value='$i'$selected>$i</option>\n";
		}
		echo "                     </select>\n";
		echo "                  </td>";
		echo "               </tr>\n";
		echo "               <tr>\n";
		echo "                  <td colspan='2' valign='top' align='right'>Positions Held: </td>\n";
		echo "                  <td colspan='3'><input type='hidden' name='volunteers-positionid-$child->camperid' value='0' />\n";
		echo "                     <select name='volunteers-positionid-$child->camperid[]' size='5' multiple>\n";
		$vol = "";
		foreach($this->positions as $position) {
			echo "                        <option value='$position->positionid'>" . preg_replace('/^\(/', '(V', $position->name) . "</option>\n";
		}
		echo "                     </select> <br />Hold CTRL to select multiple positions.</td>\n";
		echo "                </tr>\n";
	}
}
echo "            </table>\n";
echo "            <hr />\n";
echo "            <table width='100%'>\n";
echo "               <tr>\n";
echo "                  <td colspan='4'><h4>Workshop Preference</h4></td>\n";
echo "               </tr>\n";
foreach($this->family as $depend) {
	if($depend->hohid == 0) {
		echo "               <tbody>\n";
	} else {
		echo "               <tbody id='camper$depend->camperid' style='display: none;'>\n";
	}
	echo "               <tr>\n";
	echo "                  <td colspan='4'><h4>$depend->fullname</h4>\n";
	echo "                  <input type='hidden' name='selected-0-$depend->camperid' value='LEAD' /></td>\n";
	echo "               </tr>\n";
	if($depend->workshop) {
		echo "               <tr>\n";
		echo "                  <td colspan='4'><i>$depend->workshop</i></td>\n";
		echo "               </tr>\n";
	} else {
		$count = 1;
		foreach($this->workshops as $timename => $shops) {
			$available = "";
			$selected = array();
			echo "               <tr>\n";
			echo "                  <td colspan='4'>$timename</td>\n";
			echo "               </tr>\n";
			echo "               <tr>\n";
			echo "                  <td width='40%'><select name='available-$count-$depend->camperid[]' multiple='multiple' size='" . max(min(count($shops),5),2) . "' style='width: 100%;'>\n";
			foreach($shops as $shop) {
				echo "                     <option value='$shop->eventid'>$shop->shopname ($shop->days)</option>\n";
			}
			echo "                     </select></td>\n";
			echo "                  <td width='10%'><input type='button' value='Add >>' onclick='listbox_moveto(\"$count-$depend->camperid\")' ondblclick='listbox_moveto(\"$count-$depend->camperid\")' style='width: 100%; font-size: x-small;' /><br />\n";
			echo "                     <input type='button' value='<< Remove' onclick='listbox_movefrom(\"$count-$depend->camperid\")' ondblclick='listbox_movefrom(\"$count-$depend->camperid\")' style='width: 100%; font-size: x-small;' /></td>\n";
			echo "                  <td width='40%'><select name='selected-$count-$depend->camperid[]' multiple='multiple' size='" . max(min(count($shops),5),2) . "' style='width: 100%;'>\n";
			echo "                     </select>\n";
			echo "                     <input type='checkbox' name='leader-$count-$depend->camperid' value='1'$leader/> Leader of selected workshops?</td>\n";
			echo "                  <td width='10%'><input type='button' value='Move Up' onclick='listbox_up(\"$count-$depend->camperid\")' style='width: 100%; font-size: x-small;' /><br />\n";
			echo "                     <input type='button' value='Move Down' onclick='listbox_down(\"" . $count++ . "-$depend->camperid\")' style='width: 100%; font-size: x-small;' /></td>\n";
			echo "               </tr>\n";
		}
	}
	echo "               <tr>\n";
	echo "                  <td colspan='4'><input type='checkbox' name='selected-997-$depend->camperid' value='1028'$checked/>\n";
	echo "                  St. Louis City Museum, Saturday June 30th 2:00 PM - Midnight ($6).</td>\n";
	echo "               </tr>\n";
	echo "               <tr>\n";
	echo "                  <td colspan='2'><input type='checkbox' name='selected-998-$depend->camperid' value='1029'$checked/>\n";
	echo "                  River Float Trip, Tuesday 9:50 AM - 5:00 PM ($35).</td>\n";
	echo "                  <td colspan='2'><input type='checkbox' name='selected-999-$depend->camperid' value='1030'$checked/>\n";
	echo "                  Onondaga Cave State Park, Wednesday 1:00 PM - 5:00 PM ($25).</td>\n";
	echo "               </tr>\n";
	echo "               <tr>\n";
	echo "                  <td colspan='4'><hr /></td>\n";
	echo "               </tr>\n";
	echo "               </tbody>\n";
}
echo "            </table>\n";
echo "            <input type='hidden' name='hohid' value='$camper->camperid' />\n";
echo "            </div>\n";
echo "            <span class='article_separator'>&nbsp;</span>\n";
echo "            </div>\n";
echo "            <p align='center'><input type='button' value='Save' class='Button' onclick='selectSubmit()' /></form></p>\n";
echo "            <span class='article_separator'>&nbsp;</span>\n";
echo "         </td>\n";
echo "      </tr>\n";
?>
</table>

</div>
