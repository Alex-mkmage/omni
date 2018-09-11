<?php

class Ey_Applications_Model_Resource_Tag extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ey_applications/tag', 'entity_id');
    }
}