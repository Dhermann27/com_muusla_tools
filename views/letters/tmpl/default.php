<?php defined('_JEXEC') or die('Restricted access'); 
if(count($this->letters) > 0) {
   $burt = false;
   $meyer = false;
   $cratty = false;?>
<html>
<head>
<style type="text/stylesheet">
   html, body { bgcolor: white; font-family: opensans; padding: 1em; }
   h1, h2, h3, h4, h5, h6, caption { font-family: griffy; }
   div, p, li, td { color: black; font-size: 10pt; line-height: 1; }
   hr { padding-top: 1em; }
</style>
</head>
<body>
   <?php
   foreach($this->letters as $letter) {?>
   <div align="center">
      <img src="/images/muusa/muusa_logo_maiandra.png" alt="MUUSA Logo" />
      <h3>
         <?php echo $this->year;?>
         Confirmation Letter
      </h3>
      <strong> As of <?php echo date("l, F j, Y");?>
      </strong>
   </div>
   <p>&nbsp;</p>
   <div style="margin-left: 1in;">
      <?php echo count($letter->children) > 1 ? "The $letter->name Family" : $letter->children[0]->firstname . " " . $letter->children[0]->lastname;?>
      <br />
      <?php echo $letter->address1;?>
      <?php echo $letter->address2 != "" ? "<br />" . $letter->address2 : "";?>
      <br />
      <?php echo "$letter->city, $letter->statecd $letter->zipcd";?>
   </div>
   <table style="width: 98%;">
      <caption>Camper List</caption>
      <thead>
         <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
            <th>Current Lodging</th>
            <th>Program</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($letter->children as $child) {?>
         <tr>
            <td><?php echo $child->firstname;?>
            </td>
            <td><?php echo $child->lastname;?>
            </td>
            <td><?php echo $child->email;?>
            </td>
            <td><?php echo $child->roomnbr ? "$child->buildingname $child->roomnbr" : "&nbsp;";?>
            </td>
            <td><?php echo $child->programname;?>
            </td>
         </tr>
         <?php $burt = $burt || $child->programid == 1003;
         $meyer = $meyer || $child->programid == 1001;
         $cratty = $cratty || $child->programid == 1002 || $child->programid == 1007;
   }?>
      </tbody>
   </table>
   <?php if(count($letter->roommates) > 0) {?>
   <h5>Roommates</h5>
   <div>
      <?php foreach($letter->roommates as $roommate) {
         echo "$roommate->fullname ($roommate->buildingname $roommate->roomnbr)<br />\n";
      }?>
   </div>
   <?php }?>
   <hr />
   <?php if(count($this->workshops) > 0) {
      $signups = array();
      foreach($this->workshops as $id => $workshop) {
         if(count($workshop["attendees"]) > 0){
            foreach($workshop["attendees"] as $attendee) {
               if($attendee->familyid == $letter->id) {
                  array_push($signups, "<td>$attendee->firstname</td>\n<td>$attendee->lastname</td>\n<td>" . htmlspecialchars($workshop["workshopname"]) . "</td>\n<td>" . $workshop["timename"] . "</td>\n<td>" . $workshop["dispdays"] . "</td>\n<td>Enrolled</td>\n");
               }
            }
         }
         if(count($workshop["waitlist"]) > 0){
            foreach($workshop["waitlist"] as $attendee) {
               if($attendee->familyid == $letter->id) {
                  array_push($signups, "<td>$attendee->firstname</td>\n<td>$attendee->lastname</td>\n<td>" . htmlspecialchars($workshop["workshopname"]) . "</td>\n<td>" . $workshop["timename"] . "</td>\n<td>" . $workshop["dispdays"] . "</td>\n<td><i>Waiting List</i></td>\n");
               }
            }
         }
      }
      if(count($signups) > 0) {?>
   <table style="width: 98%;">
      <caption>Workshop Signups</caption>
      <thead>
         <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Workshop Name</th>
            <th>Timeslot</th>
            <th>Days</th>
            <th>Status</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($signups as $signup) {?>
         <tr>
            <?php echo $signup;?>
         </tr>
         <?php }?>
      </tbody>
      <tfoot>
         <tr>
            <td colspan="6" align="center"><i>These workshop slots are
                  not guaranteed. Priority is always given to those who
                  have paid their registration fees earliest, not in
                  order of the date that the signup occurred.</i></td>
         </tr>
      </tfoot>
   </table>
   <hr />
   <?php }
   }
   $total = 0.0;?>
   <table style="width: 98%;">
      <caption>Charges and Payments</caption>
      <thead>
         <tr>
            <th>Charge Type</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Memo</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($letter->charges as $charge) {
            $total += (float)preg_replace("/,/", "",  $charge->amount);?>
         <tr>
            <td><?php echo $charge->chargetypename;?>
            </td>
            <td align="right">$<?php echo $charge->amount;?>
            </td>
            <td align="center"><?php echo $charge->timestamp;?>
            </td>
            <td><?php echo $charge->memo;?>
            </td>
         </tr>
         <?php }?>
      </tbody>
      <tfoot>
         <tr align="right">
            <td><strong>Total Amount Due:</strong>
            </td>
            <td>$<?php echo number_format($total, 2, '.', '');?>
            </td>
         </tr>
         <tr align="center">
            <td colspan="4"><i>Please pay your total camp costs before
                  camp if at all possible: mail your check by June 15 or
                  pay by PayPal by June 22. After that you will need to
                  pay by credit card or check upon arrival; we cannot
                  accept PayPal payments after June 25.</i>
            </td>
         </tr>
      </tfoot>
   </table>
   <hr />
   <?php if(count($letter->volunteers) > 0) {?>
   <table style="width: 98%;">
      <caption>Volunteer Positions</caption>
      <thead>
         <tr>
            <th>Position</th>
            <th>First Name</th>
            <th>Last Name</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($letter->volunteers as $volunteer) {?>
         <tr>
            <td><?php echo $volunteer->volunteerpositionname;?>
            </td>
            <td><?php echo $volunteer->firstname;?>
            </td>
            <td><?php echo $volunteer->lastname;?>
            </td>
         </tr>
         <?php }?>
      </tbody>
   </table>
   <hr />
   <?php }
   if($burt) {?>
   <div style='page-break-after: always; font-size: 1pt;'></div>
   <?php include 'letters/burtletter.php';
   foreach($letter->children as $child) {
      if($child->programid == 1003) {?>
   <div style='page-break-after: always; font-size: 1pt;'></div>
   <?php 
   include 'letters/burtform.php';
      }
   }
   }
   if($meyer) {?>
   <div style='page-break-after: always; font-size: 1pt;'></div>
   <?php include 'letters/meyerletter.php';
   foreach($letter->children as $child) {
      if($child->programid == 1001) {?>
   <div style='page-break-after: always; font-size: 1pt;'></div>
   <?php 
   include 'letters/meyerform.php';
      }
   }
   }
   if($cratty) {?>
   <div style='page-break-after: always; font-size: 1pt;'></div>
   <?php include 'letters/crattyletter.php'; 
   foreach($letter->children as $child) {
      if($child->programid == 1002 || $child->programid == 1007) {?>
   <div style='page-break-after: always; font-size: 1pt;'></div>
   <?php 
   include 'letters/crattyform.php';
      }
   }
   }
   }?>
</body>
</html>
<?php 
} else {?>
<link type="text/css"
   href="<?php echo JURI::root(true);?>
/components/com_muusla_application/css/application.css"
   rel="stylesheet" />
<script type="text/javascript">
   jQuery(document).ready(function ($) {
		$("#myLetters").on('change', function() {
			if(this.value == "camper") {
				bindEvents(jQuery, jQuery("div#camper").show());
			} else {
				jQuery("div#camper").hide();
			}
			
		});
	    $("#muusaApp .save").button().click(function (event) {
	    	$("#muusaApp").submit();
	        event.preventDefault();
	        return false;
	    });
	    camperlist = [ <?php
	        $campers = array();
	        foreach($this->campers as $camper) {
	            array_push($campers, "{ label: '$camper->firstname $camper->lastname ($camper->city, $camper->statecd)', ident: '$camper->familyid'}\n");
	        }
	        echo implode(",\n", $campers); ?>
	    ];
	});
</script>
<div id="ja-content">
   <div class="componentheading">Confirmation Letters</div>
   <table class="blog">
      <tr>
         <td valign="top">
            <div>
               <div class="contentpaneopen">
                  <h2 class="contentheading">Download Confirmation
                     Letters</h2>
               </div>
               <div class='article-content'>
                  <form id="muusaApp" method="post"
                     action="<?php echo JURI::root(true);?>/index.php/admin/tools/index.php?option=com_muusla_tools&view=letters&format=pdf&tmpl=component">
                     <h3>Choose which labels to print:</h3>
                     <select id="myLetters" name="letters"
                        class="ui-corner-all">
                        <option value="0">Choose an option</option>
                        <option value="all">
                           <?php echo $this->year;?>
                           Registered Households
                        </option>
                        <option value="camper">Specific Household</option>
                     </select>
                     <div id="camper" style="display: none;">
                        Camper name <input type="text"
                           class="inputtext camperlist ui-corner-all" /><input
                           type="hidden" name="camperid"
                           class="camperlist-value" />
                     </div>
                     <button class="save">Download Letters</button>
                     <p>
                        <i>This function is slow. Please be patient.</i>
                     </p>
                  </form>
               </div>
               <span class="article_separator">&nbsp;</span>
            </div>
         </td>
      </tr>
   </table>
</div>
<?php }?>