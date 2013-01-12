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
class muusla_toolsViewprogramlist extends JView
{
	function display($tpl = null) {
		parent::display($tpl);
	}

	function detail($tpl = null) {
		$model =& $this->getModel();
		$campers = $model->getCampers();
		foreach($model->getSponsors() as $sponsor) {
			$campers[$sponsor->camperid]["fullname"] = $sponsor->fullname;
			$campers[$sponsor->camperid]["phonenbr"] = $sponsor->phonenbr;
			$campers[$sponsor->camperid]["room"] = $sponsor->room;
		}

		header("Pragma: public");
		header("Expires: 0"); // set expiration time
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		header("Content-Disposition: attachment; filename=programlistdata.csv;");

		header("Content-Transfer-Encoding: binary");

		echo "Firstname,Lastname,Age,Grade,Programname,Parentname,Parentemail,Parentnbr,Parentroom\n";

		foreach ($campers as $camperid=>$camper) {
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["firstname"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["lastname"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["age"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", ($camper["age"] + $camper["gradeoffset"]))) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", ($camper["programname"]))) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["fullname"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["email"])) . ",";
			echo $this->phonenbr(preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["phonenbr"]))) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["room"])) . "\n";
		}
		exit(0);
	}

	function phonenbr($nbr) {
		return substr($nbr, 0, 3) . "-" . substr($nbr, 3, 3) . "-" . substr($nbr, 6);
	}
}
?>
