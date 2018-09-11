<?php

class Ey_Protocol_Model_Resource_Sampletype extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ey_protocol/sampletype', 'entity_id');
    }
}