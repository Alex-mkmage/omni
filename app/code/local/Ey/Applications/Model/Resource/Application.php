<?php

class Ey_Applications_Model_Resource_Application extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ey_applications/application', 'entity_id');
    }
}