<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="ja-content">
	<div class="componentheading">Roster Request</div>
	<table class="blog" cellpadding="0" cellspacing="0">
		<tr>
			<td valign='top'>
				<div>
					<div class='contentpaneopen'>
						<h2 class='contentheading'>Available MUUSA Rosters</h2>
					</div>
					<div class='article-content'>
						<p>We only divulge the list of campers and their personal
							information to attendees. If you do not see a link for a year in
							which you attended, please contact the webmaster by clicking
							"Contact Us" above.</p>
						<table>
							<tr align="center">
								<td><?php
								if(in_array("2012", $this->years)) {
									echo "<a href='index.php/component/docman/doc_download/4'><img src='../images/muusa/2012.png' alt='Download 2012 Roster' /></a><br />2012\n";
								}?>
								</td>
								<td><?php
								if(in_array("2011", $this->years)) {
									echo "<a href='index.php/component/docman/doc_download/3'><img src='../images/muusa/2011.png' alt='Download 2011 Roster' /></a><br />2011\n";
								}?>
								</td>
							</tr>
							<tr align="center">
								<td><?php
								if(in_array("2010", $this->years)) {
									echo "<a href='index.php/component/docman/doc_download/2'><img src='../images/muusa/2010.png' alt='Download 2010 Roster' /></a><br />2010\n";
								}?>
								</td>
								<td><?php
								if(in_array("2009", $this->years)) {
									echo "<a href='index.php/component/docman/doc_download/1'><img src='../images/muusa/2009.png' alt='Download 2009 Roster' /></a><br />2009\n";
								}?></td>
							</tr>
						</table>
					</div>
					<span class='article_separator'>&nbsp;</span>
				</div>
			</td>
		</tr>
	</table>
</div>
