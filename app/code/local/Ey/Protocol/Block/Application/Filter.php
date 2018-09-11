<?php

class Ey_Protocol_Block_Application_Filter extends Ey_Protocol_Block_Application
{
    public function getSampleTypes()
    {
        return Mage::getModel('ey_protocol/sampletype')
            ->getCollection()
            ->setOrder('name', 'ASC');
    }
}