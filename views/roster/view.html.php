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
class muusla_toolsViewroster extends JView
{
	function display($tpl = null) {
		parent::display($tpl);
	}

	function detail($tpl = null) {
		$model =& $this->getModel();
		$campers = $model->getCampers();
		$phones = $model->getPhones();
		foreach($phones as $phone) {
			if($campers[$phone->camperid] != null) {
				if($campers[$phone->camperid]["phones"] == null) {
					$campers[$phone->camperid]["phones"] = array($phone);
				} else {
					array_push($campers[$phone->camperid]["phones"], $phone);
				}
			}
		}
		foreach($model->getChildren() as $child) {
			foreach($phones as $phone) {
				if($child->camperid == $phone->camperid && $phone->name != "Home") {
					if($child->phones == "0") {
						$child->phones = array($phone);
					}
				}
			}
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

		header("Content-Disposition: attachment; filename=rosterdata.csv;");

		header("Content-Transfer-Encoding: binary");

		echo "Firstname,Lastname,Address1,Address2,City,State,Zip,Email,Nbrtype1,Phone1,Nbrtype2,Phone2,Nbrtype3,Phone3,Birthday,Church";
		for($i=1; $i<7; $i++) {
			echo ",Childfirstname$i,Childlastname$i,Childemail$i,Childnbrtype$i,Childphone$i,Childbirthday$i";
		}
		echo "\n";

		foreach ($campers as $camperid=>$camper) {
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["firstname"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["lastname"])) . ",";
			$address = explode("|", $camper["address"]);
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $address[0])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $address[1])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $address[2])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $address[3])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $address[4])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["email"])) . ",";
			for($i=1; $i<4; $i++) {
				if(count($camper["phones"]) > 0) {
					$phone = array_shift($camper["phones"]);
					echo $phone->name . ",";
					echo $this->phonenbr(preg_replace("/&#039;/", "'", preg_replace("/,/", "", $phone->phonenbr))) . ",";
				} else {
					echo ",,";
				}
			}
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["birthdate"])) . ",";
			echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $camper["churchname"]));
			for($i=1; $i<7; $i++) {
				if(count($camper["children"]) > 0) {
					$child = array_shift($camper["children"]);
					echo "," . preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->firstname)) . ",";
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->lastname)) . ",";
					if($child->email != "") {
						echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->email)) . ",";
					} else {
						echo "---,";
					}
					if($child->phones != "0" && count($child->phones) > 0) {
						$phone = array_shift($child->phones);
						echo $phone->name . ",";
						echo $this->phonenbr(preg_replace("/&#039;/", "'", preg_replace("/,/", "", $phone->phonenbr))) . ",";
					} else {
						echo ",,";
					}
					echo preg_replace("/&#039;/", "'", preg_replace("/,/", "", $child->birthdate));
				} else {
					echo ",,,,,,";
				}
			}
			echo "\n";
		}
		exit(0);
	}

	function phonenbr($nbr) {
		return substr($nbr, 0, 3) . "-" . substr($nbr, 3, 3) . "-" . substr($nbr, 6);
	}
}
?>
