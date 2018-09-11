<?php 

class Puru_Multislider_Model_System_Config_Showcontent 
{
    public function toOptionArray()
    {
        return array(
		array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Images')),
    	array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Content'))
			


        );
    }
}
