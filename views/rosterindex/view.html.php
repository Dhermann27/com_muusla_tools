<?php
/**
 * @package		muusla_tools
 * @license		GNU/GPL, see LICENSE.php
 */

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the muusla_tools Component
 *
 * @package		muusla_tools
 */
class muusla_toolsViewrosterindex extends JViewLegacy
{
   function display($tpl = null) {
      parent::display($tpl);
   }

   function detail($tpl = null) {
      $model = $this->getModel();
      $campers = $model->getCampers();

      header("Pragma: public");
      header("Expires: 0"); // set expiration time
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");

      header("Content-Disposition: attachment; filename=rosterindexdata.csv;");

      header("Content-Transfer-Encoding: binary");

      echo "Lastname,Firstname,Familyname\n";

      foreach ($campers as $camper) {
         echo preg_replace("/&#039;/", "'", $camper->lastname) . ",";
         echo preg_replace("/&#039;/", "'", $camper->firstname) . ",";
         echo preg_replace("/&#039;/", "'", $camper->familyname) . "\n";
      }
      exit(0);
   }
}
?>
