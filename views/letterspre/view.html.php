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
class muusla_toolsViewletterspre extends JView
{
	function display($tpl = null) {
		parent::display($tpl);
	}

	function detail($tpl = null) {
		$model =& $this->getModel();
		$campers = $model->getCampers();
		foreach($model->getChildren() as $child) {
			if($campers[$child->hohid]["children"] == null) {
				$campers[$child->hohid]["children"] = array($child);
			} else {
				array_push($campers[$child->hohid]["children"], $child);
			} 
		}

		header("Pragma: public");
		header("Expires: 0"); // set expiration time
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		header("Content-Disposition: attachment; filename=confirmationletterpredata.csv;");

		header("Content-Transfer-Encoding: binary");

		echo "Firstname,Lastname,Address1,Address2,City,State,Zip,Email,Amount,Memo";
		for($i=1; $i<7; $i++) {
			echo ",Childfirstname$i,Childlastname$i";
		}
		echo "\n";

		foreach ($campers as $camper) {
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["firstname"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["lastname"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["address1"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["address2"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["city"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["statecd"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["zipcd"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["email"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["amount"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["memo"]));
			for($i=1; $i<7; $i++) {
				if(count($camper["children"]) > 0) {
					$child = array_shift($camper["children"]);
					echo "," . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->firstname)) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->lastname));
				} else {
					echo ",,";
				}
			}
			echo "\n";
		}
		exit(0);
	}
}
?>
