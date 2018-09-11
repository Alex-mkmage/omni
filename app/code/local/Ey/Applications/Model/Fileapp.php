<?php

class Ey_Applications_Model_Fileapp extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'fileapp';
    public $eventId = 'fileapp';

    protected function _construct()
    {
        $this->_init('ey_applications/fileapp');
    }

    public function getEventId()
    {
        return $this->eventId;
    }
}