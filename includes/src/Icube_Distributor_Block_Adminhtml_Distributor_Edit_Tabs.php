<?php
 
class Icube_Distributor_Block_Adminhtml_Distributor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('distributor_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('distributor')->__('Distributor'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('distributor')->__('Distributor Information'),
            'title'     => Mage::helper('distributor')->__('Distributor Information'),
            'content'   => $this->getLayout()->createBlock('distributor/adminhtml_distributor_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
    
}