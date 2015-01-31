<?php
/**
 * @package		muusla_tools
 * @license		GNU/GPL, see LICENSE.php
 */

jimport('joomla.application.component.controller');

/**
 * muusla_tools Component Controller
 *
 * @package		muusla_tools
 */
class muusla_toolsController extends JControllerLegacy
{
   function save()
   {
      $this->muuslaControl('default', 'save');
   }

   function detail()
   {
      $this->muuslaControl('workshop', 'detail');
   }

   function editcamper()
   {
      $this->muuslaControl('editcamper', 'editcamper');
   }

   function payment()
   {
      $this->muuslaControl('payment', 'payment');
   }

}
?>
