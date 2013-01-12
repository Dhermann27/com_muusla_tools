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
class muusla_toolsViewrosterrequest extends JView
{
	function display($tpl = null) {
		$model =& $this->getModel();
		$user =& JFactory::getUser();
		$this->assign('years', $model->getYears($user->email));
		foreach($model->getGroups($user->email) as $group) {
			if(!in_array("$user->id", explode(",", $group->groups_members))) {
				$model->updateId($group->groups_id, $user->id);
			}
		}
		parent::display($tpl);
	}
}
?>
