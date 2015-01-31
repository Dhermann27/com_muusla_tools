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
class muusla_toolsViewtroutrooms extends JViewLegacy
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

      header("Content-Disposition: attachment; filename=troutrooms.csv;");

      header("Content-Transfer-Encoding: binary");

      echo "Building,Room Number,Name,Gender,Address,Age\n";
      foreach ($campers as $camper) {
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->Building)) . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->Room_Number)) . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->Name)) . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->sexcd)) . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->Address)) . ",";
         echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->Age)) . ",";
         echo "\n";
      }
      exit(0);
   }
}
?>
