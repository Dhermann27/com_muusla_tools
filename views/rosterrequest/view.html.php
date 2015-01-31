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
class muusla_toolsViewrosterrequest extends JViewLegacy
{
   function display($tpl = null) {
      $model = $this->getModel();
      $user = JFactory::getUser();
      $this->assign('years', $model->getYears($user->email));
      parent::display($tpl);
   }
}
?>
