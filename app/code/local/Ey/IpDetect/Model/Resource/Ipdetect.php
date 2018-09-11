<?php
 
class Ey_IpDetect_Model_Resource_Ipdetect extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct() {
    
        $this->_init('ipdetect/ipdetect', 'id');
        
    }
        
}