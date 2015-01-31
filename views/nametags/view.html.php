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
class muusla_toolsViewnametags extends JViewLegacy
{
   function display($tpl = null) {
      $model = $this->getModel();
      $this->assignRef('campers', $model->getCampers());
      $this->assignRef('year', $model->getYear());
      parent::display($tpl);
   }

   function getSafe($obj)
   {
      return htmlspecialchars(trim($obj), ENT_QUOTES);
   }
}
?>
