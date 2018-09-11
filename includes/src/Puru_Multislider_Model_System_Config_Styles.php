<?php 

class Puru_Multislider_Model_System_Config_Styles 
{
    public function toOptionArray()
    {
        return array(
            array('value' => 9, 'label'=>Mage::helper('adminhtml')->__('Right to Left Slider')),
			array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Simple Fade')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Curtain Top Left')),
            array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('Curtain Top Right')),
            array('value' => 4, 'label'=>Mage::helper('adminhtml')->__('Curtain Bottom Left')),
	    	array('value' => 5, 'label'=>Mage::helper('adminhtml')->__('Curtain Bottom Right')),
            array('value' => 6, 'label'=>Mage::helper('adminhtml')->__('Curtain Slice Left')),
            array('value' => 7, 'label'=>Mage::helper('adminhtml')->__('Blind Curtain Top Left')),
            array('value' => 8, 'label'=>Mage::helper('adminhtml')->__('Curtain Slice Right')),
			array('value' => 10, 'label'=>Mage::helper('adminhtml')->__('Left to Right Slider')),
            array('value' => 11, 'label'=>Mage::helper('adminhtml')->__('Bottom to Top Slider')),
            array('value' => 12, 'label'=>Mage::helper('adminhtml')->__('Blind Curtain Slice Bottom')),
            array('value' => 13, 'label'=>Mage::helper('adminhtml')->__('Blind Curtain Slice Top')),
			array('value' => 14, 'label'=>Mage::helper('adminhtml')->__('Stampede')),
	    	array('value' => 15, 'label'=>Mage::helper('adminhtml')->__('Mosaic')),
            array('value' => 16, 'label'=>Mage::helper('adminhtml')->__('Mosaic Reverse')),
            array('value' => 17, 'label'=>Mage::helper('adminhtml')->__('Mosaic Spiral'))


        );
    }
}