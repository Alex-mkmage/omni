<?php

class Puru_Multislider_Block_Adminhtml_Multislider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('multislider_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('multislider')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('multislider')->__('Item Information'),
          'title'     => Mage::helper('multislider')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('multislider/adminhtml_multislider_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}