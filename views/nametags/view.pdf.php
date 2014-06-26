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
class muusla_toolsViewnametags extends JView
{
   function display($tpl = null) {
      $document = JFactory::getDocument();
      $document->setName('MUUSA Nametags');

      $model =& $this->getModel();
      $labels = $this->getSafe(JRequest::getVar("labels"));
      if($labels == "all") {
         $this->assignRef('labels', $model->getAllAddresses());
      } else if($labels == "camper") {
         $this->assignRef('labels', $model->getCamperAddress($this->getSafe(JRequest::getVar("camperid"))));
      } else {
         echo "No Labels to Print!";
      }

      parent::display($tpl);
   }

   function getSafe($obj)
   {
      return htmlspecialchars(trim($obj), ENT_QUOTES);
   }

}
?>
