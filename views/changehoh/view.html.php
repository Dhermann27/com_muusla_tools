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
class muusla_toolsViewchangehoh extends JView
{
   function display($tpl = null) {
      $model =& $this->getModel();
      $this->assignRef('campers', $model->getCampers());

      parent::display($tpl);
   }
    
   function save($tpl = null) {
      $model =& $this->getModel();
      if(JRequest::getSafe("changehoh") != "0") {
         $model->changeHeadofHousehold(JRequest::getSafe("changehoh"));
      }
       
      $this->assignRef('campers', $model->getCampers());

      parent::display($tpl);
   }

}
?>
