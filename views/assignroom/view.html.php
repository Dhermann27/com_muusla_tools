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
class muusla_toolsViewassignroom extends JView
{
   function display($tpl = null) {
      $model =& $this->getModel();
      $this->assignRef('campers', $model->getCampers());
      $this->assignRef('data', $model->getData());
      $this->assignRef('buildings', $model->getRooms());
      $this->assignRef('programs', $model->getPrograms());

      parent::display($tpl);
   }
    
   function save($tpl = null) {
      $model =& $this->getModel();
      if(JRequest::getSafe("hohid") != "0") {
         $model->assignRoom(JRequest::getSafe("hohid"));
      }
      if(JRequest::getSafe("programid") != "0") {
         $model->assignProgram(JRequest::getSafe("programid"));
      }
       
      $this->assignRef('campers', $model->getCampers());
      $this->assignRef('data', $model->getData());
      $this->assignRef('buildings', $model->getRooms());
      $this->assignRef('programs', $model->getPrograms());

      parent::display($tpl);
   }

}
?>
