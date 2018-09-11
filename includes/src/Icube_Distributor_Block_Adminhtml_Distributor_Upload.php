<?php

class Icube_Distributor_Block_Adminhtml_Distributor_Upload extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();

        $this->removeButton('back')
            ->removeButton('reset')
            ->_updateButton('save', 'label', $this->__('Upload'))
            ->_updateButton('save', 'id', 'upload_button')
            ->_updateButton('save', 'onclick', 'editForm.submit();');
    }

    protected function _construct()
    {
        parent::_construct();

        $this->_objectId   = 'id';
        $this->_blockGroup = 'distributor';
        $this->_controller = 'adminhtml_distributor';
        $this->_mode = 'upload';
    }
    
    public function getHeaderText()
    {
        return Mage::helper('distributor')->__('Distributor Upload');
    }
    
    protected function _prepareLayout()
    {
        if ($this->_blockGroup && $this->_controller && $this->_mode) {
            $this->setChild('form', $this->getLayout()->createBlock($this->_blockGroup . '/' . $this->_controller . '_' . $this->_mode . '_form'));
        }
        return parent::_prepareLayout();
    }

}