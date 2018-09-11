<?php

class Ey_Applications_Model_Customer extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'customer';
    public $eventId = 'customer';
    protected $_filePath;

    protected function _construct()
    {
        $this->_init('ey_applications/customer');
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();

        $this->_updateTimestamps();

        return $this;
    }

    protected function _updateTimestamps()
    {
        $timestamp = now();
        $this->setTimestamps($timestamp);
        return $this;
    }
}