<?php


// No direct access to this file
defined('_JEXEC') or die;

// Get an instance of the controller prefixed by muusla_application
$controller = JControllerLegacy::getInstance('muusla_tools');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

?>