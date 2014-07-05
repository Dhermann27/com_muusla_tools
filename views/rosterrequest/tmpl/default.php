<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="ja-content">
   <div class="componentheading">Roster Request</div>
   <table class="blog">
      <tr>
         <td valign='top'>
            <div>
               <div class='contentpaneopen'>
                  <h2 class='contentheading'>Available MUUSA Rosters</h2>
               </div>
               <div class='article-content'>
                  <p>We only divulge the list of campers and their
                     personal information to attendees. If you do not
                     see a link for a year in which you attended, please
                     contact the webmaster by clicking "Contact Us"
                     above.</p>
                  <?php foreach($this->years as $year) {
                     if($year->id > 0) {
                        echo "<p><a href='index.php/component/docman/doc_download/$year->roster_docnum'><img src='" . JURI::root(true) . "/images/muusa/$year->year.png' alt='Download $year->year Roster' /></a><br />$year->year</p>\n";
                     }
                  }?>
               </div>
               <span class='article_separator'>&nbsp;</span>
            </div>
         </td>
      </tr>
   </table>
</div>
