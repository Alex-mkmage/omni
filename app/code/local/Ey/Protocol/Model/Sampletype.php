<?php

class Ey_Protocol_Model_Sampletype extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'sampletype';
    public $eventId = 'sample_type';

    protected function _construct()
    {
        $this->_init('ey_protocol/sampletype');
    }

    public function getSampleTypes()
    {
        $collection = $this->getCollection()
            ->setOrder('name', 'ASC');
        $toArray = array();

        if($collection->getSize()){
            foreach($collection as $type){
                $toArray[$type->getId()] = $type->getName();
            }
        }

        return $toArray;
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    protected function _beforeDelete()
    {
        parent::_beforeDelete();

        $typeId = $this->getId();
        $types = Mage::getModel('ey_protocol/type')
            ->getCollection()
            ->addFieldToFilter('sampletype_id', array('eq' => $typeId));

        foreach ($types as $type){
            Mage::getModel('ey_protocol/type')->load($type->getId())->delete();
        }
    }
}