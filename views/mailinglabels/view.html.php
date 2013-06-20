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
class muusla_toolsViewmailinglabels extends JView
{
	function display($tpl = null) {
		parent::display($tpl);
	}

	function detail($tpl = null) {
		$model =& $this->getModel();
		$campers = $model->getCampers();
		
		header("Pragma: public");
		header("Expires: 0"); // set expiration time
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		header("Content-Disposition: attachment; filename=mailinglabelsdata.csv;");

		header("Content-Transfer-Encoding: binary");

		echo "Family,Address1,Address2,City,State,Zip\n";

		foreach ($campers as $camper) {
		   if($camper->familyname == "") {
		      continue;
		   } else {
		      $familyname = preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->familyname));
		      if($camper->count > 1) {
		         $familyname = "The " . $familyname . " Family";
		      }
		   }
			echo $familyname . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->address1)) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->address2)) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->city)) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->statecd)) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->zipcd)) . "\n";
		}
		exit(0);
	}
}
?>
