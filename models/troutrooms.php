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
class muusla_toolsModeltroutrooms extends JModelItem
{
   function getCampers() {
      $db = JFactory::getDBO();
      $query = "SELECT b.name Building, r.roomnbr Room_Number, CONCAT(tc.firstname, ' ', tc.lastname) Name, tc.sexcd, CONCAT(tf.address1, ', ', IF(tf.address2<>'',CONCAT(tf.address2, ', '),''), tf.city, ', ', tf.statecd, ' ', tf.zipcd) Address, tc.age Age FROM muusa_thisyear_camper tc, muusa_thisyear_family tf, muusa_building b, muusa_room r WHERE tc.familyid=tf.id AND tc.roomid=r.id AND r.buildingid=b.id ORDER BY b.id, r.roomnbr, tc.birthdate";
      $db->setQuery($query);
      return $db->loadObjectList();
   }
}