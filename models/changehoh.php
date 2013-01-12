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
class muusla_toolsModelchangehoh extends JModel
{
	function getCampers() {
		$db =& JFactory::getDBO();
		$query = "SELECT camperid, firstname, lastname, city, statecd FROM muusa_campers WHERE hohid!=0 ORDER BY lastname, firstname, statecd, city";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function changeHeadofHousehold($id) {
		$db =& JFactory::getDBO();
		$query = "SELECT hohid FROM muusa_campers WHERE camperid=" . $id;
		$db->setQuery($query);
		$hohid = $db->loadResult();
		if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
		}

		$user =& JFactory::getUser();
		$query = "UPDATE muusa_charges mc, muusa_chargetypes mt SET mc.camperid=$id, mc.modified_by='$user->username', mc.modified_at=CURRENT_TIMESTAMP WHERE mc.chargetypeid=mt.chargetypeid AND mc.camperid=$hohid AND mt.ishohcharge=1";
		$db->setQuery($query);
		$db->query();
		if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
		}

		$query = "UPDATE muusa_campers SET hohid=$id, modified_by='$user->username', modified_at=CURRENT_TIMESTAMP WHERE hohid=$hohid OR camperid=" . $hohid;
		$db->setQuery($query);
		$db->query();
		if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
		}

		$query = "UPDATE muusa_campers SET hohid=0, modified_by='$user->username', modified_at=CURRENT_TIMESTAMP WHERE camperid=" . $id;
		$db->setQuery($query);
		$db->query();
		if($db->getErrorNum()) {
			JError::raiseError(500, $db->stderr());
		}
	}
}