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
class muusla_toolsViewprogramlist extends JViewLegacy
{
   function display($tpl = null) {
      $document = JFactory::getDocument();
      $document->setName('MUUSA Program List');
      $document->setProperties(array("orientation"=>"landscape"));

      $model = $this->getModel();
      $programs = $model->getPrograms();
      $campers = $model->getCampers();
      foreach($campers as $camper) {
         if($programs[$camper->programid]["campers"] == null) {
            $programs[$camper->programid]["campers"] = array($camper);
         } else {
            array_push($programs[$camper->programid]["campers"], $camper);
         }
      }
      $this->assignRef('programs', $programs);
      parent::display($tpl);
   }
}
?>
