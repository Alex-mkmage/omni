<?php 

class Puru_Multislider_Model_System_Config_Capeffect 
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'rotate', 'label'=>Mage::helper('adminhtml')->__('Rotate')),
            array('value' => 'fade', 'label'=>Mage::helper('adminhtml')->__('fade'))
            


        );
    }
}
