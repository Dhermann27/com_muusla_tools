<?php
/**
 * @package		muusla_database
 * @license		GNU/GPL, see LICENSE.php
 */

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the muusla_database campers Component
 *
 * @package		muusla_database
 */
class muusla_toolsViewregister extends JView
{
	function display($tpl = null) {
		$model =& $this->getModel();
		$this->assignRef('campers', $model->getAllCampers());

		parent::display($tpl);
	}

	function editcamper($tpl = null) {
		$model =& $this->getModel();
		$camper = $model->getCamper(JRequest::getSafe("editcamper"));
		$camper->phonenbrs = $model->getPhonenumbers($camper->camperid);
		$this->assignRef('camper', $camper);
		$this->assignRef('family', $model->getFamily($camper->camperid));
		$this->assignRef('buildings', $model->getBuildings());
		$this->assignRef('positions', $model->getPositions());
		$this->assignRef('foodoptions', $model->getFoodoptions());
		$this->assignRef('churches', $model->getChurches());
		$workshops = array();
		foreach($model->getWorkshops() as $workshop) {
			if($workshop->days == 'MTuWThF') {
				$workshop->days = '5 days';
			}
			if($workshops[$workshop->timename] == null) {
				$workshops[$workshop->timename] = array($workshop);
			} else {
				array_push($workshops[$workshop->timename], $workshop);
			}
		}
		$this->assignRef('workshops', $workshops);

		parent::display($tpl);
	}

	function save($tpl = null) {
		$model =& $this->getModel();
		$user =& JFactory::getUser();
		$calls[][] = array();
		foreach(JRequest::get() as $key=>$value) {
			if(preg_match('/^(\w+)-(\w+)-(\d+)$/', $key, $objects)) {
				if($objects[1] == "selected") {
					$events[$objects[3]][$objects[2]]->shops = is_array($value) ? $value : array($value);
				} else if($objects[1] == "leader") {
					$events[$objects[3]][$objects[2]]->leader = true;
				} else if(!is_array($value)) {
					if($calls[$objects[1]][$objects[3]] == null) {
						$obj = new stdClass;
						if($objects[3] < 1000) {
							$obj->created_by = $user->username;
							$obj->created_at = date("Y-m-d H:i:s");
						} else {
							$obj->modified_by = $user->username;
							$obj->modified_at = date("Y-m-d H:i:s");
						}
						$calls[$objects[1]][$objects[3]] = $obj;
					}
					$calls[$objects[1]][$objects[3]]->$objects[2] = $this->getSafe($value);
				} else {
					$obj = new stdClass;
					$obj->created_by = $user->username;
					$obj->created_at = date("Y-m-d H:i:s");
					$calls[$objects[1]][$objects[3]]->$objects[2] = $value;
				}
			}
		}
		foreach($calls["campers"] as $id => $camper) {
			$camper->camperid = $id;
			$model->upsertCamper($camper);
		}
		foreach($calls[fiscalyear] as $id => $obj) {
			$obj->postmark = JRequest::getSafe("fiscalyear-postmark-0");
			$model->upsertFiscalyear($id, $obj);
		}
		$model->calculateCharges(JRequest::getSafe("fiscalyear-camperid-0"));
		if(count($events) > 0) {
			foreach($events as $camperid => $event) {
				$model->upsertAttendees($camperid, $event);
			}
		}
		if(count($calls[volunteers]) > 0) {
			foreach($calls[volunteers] as $id => $obj) {
				$model->upsertVolunteers($id, $obj);
			}
		}
		if(count($calls[charges]) > 0) {
			foreach($calls[charges] as $id => $obj) {
				if($obj->amount != 0) {
					if($obj->amount > 0) $obj->amount *= -1;
					$obj->timestamp = JRequest::getSafe("fiscalyear-postmark-0");
					$model->insertCharge($obj);
				}
			}
		}

		$this->assignRef('hohid', JRequest::getSafe("hohid"));
		parent::display($tpl);
	}

	function getSafe($obj)
	{
		return htmlspecialchars(trim($obj), ENT_QUOTES);
	}
}
?>
