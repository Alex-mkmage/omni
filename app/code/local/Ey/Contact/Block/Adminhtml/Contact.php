<?php

class Ey_Contact_Block_Adminhtml_Contact extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'ey_contact';
        $this->_controller = 'adminhtml_contact';
        $this->_headerText = Mage::helper('ey_contact')->__('Contact');
    }

    public function __construct()
    {
        parent::__construct();

        $this->removeButton('add');

    }
}