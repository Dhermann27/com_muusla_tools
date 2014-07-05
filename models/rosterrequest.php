<?php
/**
 * muusla_tools Model for muusla_tools Component
 *
 * @package    muusla_tools
 * @subpackage Components
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * muusla_tools Model
 *
 * @package    muusla_tools
 * @subpackage Components
 */
class muusla_toolsModelrosterrequest extends JModel
{
   function getYears($email) {
      $db =& JFactory::getDBO();
      $query = "SELECT y.year, y.roster_docnum, ya.id FROM muusa_year y LEFT JOIN (muusa_camper c, muusa_yearattending ya) ON y.year=ya.year AND c.id=ya.camperid AND c.email='$email' WHERE y.year>2008 ORDER BY y.year DESC";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
}