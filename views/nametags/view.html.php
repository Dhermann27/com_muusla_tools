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
class muusla_toolsViewnametags extends JView
{
	function display($tpl = null) {
		$model =& $this->getModel();
		$this->assignRef('campers', $model->getAllCampers());
		
		parent::display($tpl);
	}

	function detail($tpl = null) {
		$model =& $this->getModel();

		header("Pragma: public");
		header("Expires: 0"); // set expiration time
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		header("Content-Disposition: attachment; filename=nametagdata.csv;");

		header("Content-Transfer-Encoding: binary");

		echo "Name,City,State,Church,Position,New\n";

		foreach ($model->getCampers(JRequest::getSafe("camper")) as $camper) {
			if($camper->fullname == "") {
				continue;
			}
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->fullname)) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->city)) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->statecd)) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->churchname)) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->positionname)) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper->new)) . "\n";
		}
		exit(0);
	}
}
?>
