<?php

class Ey_Applications_Model_Resource_File extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ey_applications/file', 'entity_id');
    }
}