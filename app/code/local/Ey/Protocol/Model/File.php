<?php

class Ey_Protocol_Model_File extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'file';
    public $eventId = 'file';
    protected $_filePath;

    protected function _construct()
    {
        $this->_init('ey_protocol/file');

        $this->_filePath = Mage::getBaseDir('base') . Mage::helper('ey_protocol')->getFilePath();
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

        $this->setUpdatedAt($timestamp);

        if ($this->isObjectNew()) {
            $this->setCreatedAt($timestamp);
        }

        return $this;
    }

    protected function _beforeDelete()
    {
        parent::_beforeDelete();

        $fileId = $this->getId();
        $fileapps = Mage::getModel('ey_protocol/fileapp')
            ->getCollection()
            ->addFieldToFilter('file_id', array('eq' => $fileId));

        foreach ($fileapps as $fileapp){
            Mage::getModel('ey_protocol/fileapp')->load($fileapp->getId())->delete();
        }
    }

    public function getDownloadLink()
    {
        if($this->getFilePath()){
            return str_replace(" ","_", $this->getFilePath());
        }

        return Mage::getBaseUrl('media') . 'pdf' . DS .str_replace(" ","_",$this->getName());
    }

    public function getDownloadPath()
    {
        if($this->getFilePath()){
            $filePath = str_replace(
                Mage::getBaseUrl('media') . 'pdf' . DS,
                Mage::getBaseDir().Mage::helper('ey_protocol')->getFilePath(),
                $this->getFilePath()
            );
            $filePath = str_replace(" ","_", $filePath);
            return $filePath;
        }

        return Mage::getBaseDir().Mage::helper('ey_protocol')->getFilePath().str_replace(" ","_",$this->getName());
    }
}