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
      $model =& $this->getModel();
      $this->assignRef('campers', $model->getCampers());
      $this->assignRef('year', $model->getYear());
      parent::display($tpl);
   }
}
?>
