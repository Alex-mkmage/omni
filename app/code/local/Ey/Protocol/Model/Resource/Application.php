<?php

class Ey_Protocol_Model_Resource_Application extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ey_protocol/application', 'entity_id');
    }
}