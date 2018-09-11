<?php

class Ey_Protocol_Model_Product extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'product';
    public $eventId = 'product_used';

    protected function _construct()
    {
        $this->_init('ey_protocol/product');
    }

    public function getEventId()
    {
        return $this->eventId;
    }
}