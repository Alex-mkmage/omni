<?php 

class Puru_Multislider_Model_System_Config_Navigation 
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Next Pre navigation')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Play and Pause Navigation')),
            array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('Default'))
            


        );
    }
}