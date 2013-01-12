<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="ja-content">
<div class="componentheading">Confirmation Letters</div>
<table class="blog" cellpadding="0" cellspacing="0">
	<tr>
		<td valign='top'>
		<div>
		<div class='contentpaneopen'>
		<h2 class='contentheading'>Downloading Confirmation Letters Data...</h2>
		</div>
		<div class='article-content'><i>Please wait a moment for the download
		to begin.</i>
		<p>After downloading the Confirmation Letters Data file, click <a
			href="http://www.muusa.org/index.php?option=com_docman&task=doc_download&gid=14">here</a>
		to download the Confirmation Letter template.</p>
		<h3>Using Microsoft Word 2007</h3>
		<ol>
			<li>Open confirmationletter.docx.</li>
			<li>Choose Mailings -> Select Recipients -> Use Existing List.</li>
			<li>Find and pick confirmationletterdata.csv.</li>
			<li>Leave the default encoding choice and click OK.</li>
			<li>Click Finish &amp; Merge -> Edit Individual Document.</li>
			<li>Choose All and click OK.</li>
		</ol>
		<h3>Using Microsoft Word 2003</h3>
		<ol>
			<li>Click "Yes" to the error message.</li>
			<li>Choose Tools -> Letters and Mailings -> Mail Merge.</li>
			<li>Choose "Letters" and click "Next".</li>
			<li>Choose "Use the current document" and click "Next".</li>
			<li>Choose "Use an existing list", click "Browse", and find
			confirmationletterdata.csv.</li>
			<li>Click "OK" to leave it as the default encoding, and "OK" again to
			run all the records.</li>
			<li>Click "Next" until you reach Step 6. Click "Edit individual
			letters" to make any changes (choose "All" and click "OK), or "Print"
			to print as they appear.</li>

		</ol>
		<p>&nbsp;</p>
		<p><b>Individual Camper Letter:</b>
		<?php
		echo "               <select id='camper'>\n";
		echo "                  <option value='0' selected>Select a Camper</option>\n";
		foreach ($this->campers as $camper) {
			echo "                  <option value='$camper->camperid'>$camper->lastname, $camper->firstname ($camper->city, $camper->statecd)</option>\n";
		}
		echo "               </select>\n";
		echo "               <input type='button' value='Submit' onclick=\"location.href='index.php?option=com_muusla_tools&task=detail&view=letters&camper=' + document.getElementById('camper').options[document.getElementById('camper').selectedIndex].value;\" />\n";
		?></div>
		<span class='article_separator'>&nbsp;</span></div>
		</td>
	</tr>
</table>
<script type='text/javascript' language='JavaScript'>
   setTimeout("location.href='index.php?option=com_muusla_tools&task=detail&view=letters';", 3000);
</script></div>
