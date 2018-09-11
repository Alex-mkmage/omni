<?php

class Ey_Protocol_Block_Adminhtml_Application extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();
        
        $this->_blockGroup = 'ey_protocol';
        $this->_controller = 'adminhtml_application';
        $this->_headerText = Mage::helper('ey_protocol')->__('Applications');
    }
    public function __construct()
    {
        parent::__construct();

    }
    public function getCreateUrl()
    {
        return $this->getUrl(
            'adminhtml/papplication/edit'
        );
    }
}