<?php
class Icube_Distributor_Model_Mysql4_Distributor extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("distributor/distributor", "id");
    }

    public function cleanBunches()
	 {
	        return $this->_getWriteAdapter()->delete($this->getMainTable());
	 }    
}