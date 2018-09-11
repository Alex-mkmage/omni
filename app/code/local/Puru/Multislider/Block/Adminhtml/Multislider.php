<?php
class Puru_Multislider_Block_Adminhtml_Multislider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_multislider';
    $this->_blockGroup = 'multislider';
    $this->_headerText = Mage::helper('multislider')->__('Multislider Manager');
    $this->_addButtonLabel = Mage::helper('multislider')->__('Add Banner');
    parent::__construct();
  }
}

