<?php

class Ey_Applications_Block_Adminhtml_Application extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();
        
        $this->_blockGroup = 'ey_applications';
        $this->_controller = 'adminhtml_application';
        $this->_headerText = Mage::helper('ey_applications')->__('Applications');
    }
    public function __construct()
    {
        parent::__construct();

    }
    public function getCreateUrl()
    {
        return $this->getUrl(
            'adminhtml/application/edit'
        );
    }
}