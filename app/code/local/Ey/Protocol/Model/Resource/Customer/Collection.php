<?php
class Ey_Protocol_Model_Resource_Customer_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();

        $this->_init(
            'ey_protocol/customer',
            'ey_protocol/customer'
        );
    }
}