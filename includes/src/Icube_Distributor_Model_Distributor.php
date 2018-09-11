<?php
class Icube_Distributor_Model_Distributor extends Mage_Core_Model_Abstract
{
    protected function _construct()		
    {		
        $this->_init('distributor/distributor');		
    }
		
    public function getDistributorList($param)		
    {		
		
        $collection = Mage::getResourceModel('distributor/distributor_collection');		
        $collection->addFieldToFilter('country_code', $param);		
        $collection->load();		
		
         return $collection;		
    }  

   public function getAll()		
    {		
		
        $collection = Mage::getResourceModel('distributor/distributor_collection');		
        $collection->load();	

         return $collection;		
    }  
   
    public function getDistributorData($id)		
    {		
		
        $collection = Mage::getResourceModel('distributor/distributor_collection');		
        $collection->addFieldToFilter('id', $id);		
        $collection->load();		
		
         return $collection;		
    }  
}
	 