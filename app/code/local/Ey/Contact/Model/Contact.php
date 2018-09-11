<?php

class Ey_Contact_Model_Contact extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'ey_contact';

    public $eventId = 'ey_contact';

    protected $_filePath;

    protected function _construct()
    {
        $this->_init('ey_contact/contact');
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();

        return $this;
    }

    public function updateSendDate()
    {
        $timestamp = Mage::getModel('core/date')->date('m/d/Y H:i:s');
        $this->setSendAt($timestamp);
        return $this;
    }
}