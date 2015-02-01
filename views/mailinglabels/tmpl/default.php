<?php defined('_JEXEC') or die('Restricted access'); 
if(count($this->labels) > 0) { ?>
<html>
<head>
<style type="text/stylesheet">
   html { width: 8.5in; margin-top: 0in; margin-bottom: 0in; }
   table { margin-top: .5in; }
   td.label { width: 2.325in; height: .99in; padding: 0in .2in; float: left; text-align: left; overflow: hidden; outline: 0px solid; color: black;}
   </style>
</head>
<body style="margin-left: -.35in; margin-right: -.35in;">
   <div style='page-break-before: always; font-size: 1pt;'></div>
   <?php
   foreach($this->labels as $counter => $label) {
      if($counter % 30 == 0) echo "<table>\n";
      if($counter % 3 == 0) echo "<tr>\n";
      echo "<td class='label' style='font-family:arial,sans-serif; font-size:10pt;'>$label->familyname<br />$label->address1";
      if($label->address2) echo ", $label->address2";
      echo "<br />$label->city, $label->statecd $label->zipcd</td>\n";
      if($counter > 0 && ($counter + 1) % 3 == 0) echo "</tr>\n";
      if($counter > 0 && ($counter + 1) % 30 == 0)
      {
         echo "</table>\n";
         echo "<div style='page-break-after:always;font-size:1pt;'></div>\n";
      }
   }
   if(($counter + 1) % 3 != 0)
   {
      while(($counter++ + 1) % 3 != 0)
      {
         echo "<td class='label' style='font-family:arial,sans-serif; font-size:10pt;'>&nbsp;</td>\n";
      }
      echo "</tr>\n";
   }
   if(($counter + 1) % 30 != 0) echo "</table>\n";
   ?>
</body>
</html>
<?php 
} else {?>
<link type="text/css"
   href="<?php echo JURI::root(true);?>/components/com_muusla_application/css/application.css"
   rel="stylesheet" />
<script type="text/javascript">
   jQuery(document).ready(function ($) {
		$(".spinner").spinner();
		$("#myLabels").on('change', function() {
			if(this.value == "last") {
				jQuery("div#lastX").show();
			} else {
				jQuery("div#lastX").hide();
			}
			if(this.value == "camper") {
				bindEvents(jQuery, jQuery("div#camper").show());
			} else {
				jQuery("div#camper").hide();
			}
			
		});
	    $("#muusaApp .save").click(function (event) {
	    	$("#muusaApp").submit();
	        event.preventDefault();
	        return false;
	    });
	    camperlist = [ <?php
	        $campers = array();
	        foreach($this->campers as $camper) {
	            array_push($campers, "{ label: '$camper->firstname $camper->lastname ($camper->city, $camper->statecd)', ident: '$camper->id'}\n");
	        }
	        echo implode(",\n", $campers); ?>
	    ];
	});
</script>
<style>
input.spinner {
	width: 2em;
	text-align: center;
}
</style>
<div id="ja-content">
   <div class="componentheading">Mailing Labels</div>
   <table class="blog">
      <tr>
         <td valign="top">
            <div>
               <div class="contentpaneopen">
                  <h2 class="contentheading">Download Mailing Labels</h2>
               </div>
               <div class='article-content'>
                  <form id="muusaApp" method="post"
                     action="<?php echo JURI::root(true);?>/index.php/admin/tools/index.php?option=com_muusla_tools&view=mailinglabels&format=pdf&tmpl=component">
                     <h3>Choose which labels to print:</h3>
                     <select id="myLabels" name="labels"
                        class="ui-corner-all">
                        <option value="0">Choose an option</option>
                        <option value="reg">
                           <?php echo $this->year;?>
                           Registered Households
                        </option>
                        <option value="all">All Households</option>
                        <option value="last">Recently Attended
                           Households</option>
                        <option value="camper">Specific Household</option>
                     </select>
                     <div id="lastX" style="display: none;">
                        Attended in the last <input name="lastX"
                           value="1" class="spinner" /> years
                     </div>
                     <div id="camper" style="display: none;">
                        Camper name <input type="text"
                           class="inputtext camperlist ui-corner-all" /><input
                           type="hidden" name="camperid"
                           class="camperlist-value" />
                     </div>
                     <button class="save">Download Labels</button>
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