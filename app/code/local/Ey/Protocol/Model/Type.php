<?php

class Ey_Protocol_Model_Type extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'type';

    protected function _construct()
    {
        $this->_init('ey_protocol/type');
    }
}