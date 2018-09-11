<?php

class Ey_Applications_Model_Tag extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'tag';
    public $eventId = 'tag';

    const DEFAULT_PRIORITY = 0;

    protected function _construct()
    {
        $this->_init('ey_applications/tag');
    }

    public function getDefaultPriority()
    {
        return self::DEFAULT_PRIORITY;
    }

    public function getEventId()
    {
        return $this->eventId;
    }
}