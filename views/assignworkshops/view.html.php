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
class muusla_toolsViewassignworkshops extends JView
{
   function display($tpl = null) {
      $model =& $this->getModel();
      $this->assignRef('campers', $model->getCampers());

      parent::display($tpl);
   }

   function detail($tpl = null) {
      $model =& $this->getModel();
      foreach(JRequest::get() as $key=>$value) {
         if(preg_match('/^campermorning-(\d*)-(\d*)/', $key, $matches)) {
            $model->upsertAttendees($matches[1], $matches[2]);
         }
      }
      if(JRequest::getSafe("hohid") != "0") {
         $this->assignRef('camperid', JRequest::getSafe("hohid"));
         $family = $model->getFamily(JRequest::getSafe("hohid"));
         foreach($family as $fam) {
            if($fam->programname == "Adult" || preg_match("/^Young Adult/", $fam->programname) != 0) {
               $fam->workshop = "0";
               $fam->choices = $model->getChoices($fam->camperid);
            } else {
               $fam->workshop = "Automatically enrolled in " . $fam->programname . " programming.";
            }
         }
         $this->assignRef('campers', $family);
      }
      $this->assignRef('morning', $model->getWorkshops('09:50:00'));
      $this->assignRef('earlyafternoon', $model->getWorkshops('13:35:00'));
      $this->assignRef('lateafternoon', $model->getWorkshops('15:45:00'));

      parent::display($tpl);
   }

}
?>
