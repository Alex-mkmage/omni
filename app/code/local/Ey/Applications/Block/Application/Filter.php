<?php

class Ey_Applications_Block_Application_Filter extends Ey_Applications_Block_Application
{
    public function getSampleTypes()
    {
        return Mage::getModel('ey_applications/sampletype')
            ->getCollection()
            ->setOrder('name', 'ASC');
    }
}