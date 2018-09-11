<?php

class Ey_Protocol_Block_Adminhtml_Sampletype_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'ey_protocol';
        $this->_controller = 'adminhtml_sampletype';

        $this->_mode = 'edit';

        $newOrEdit = $this->getRequest()->getParam('id')
            ? $this->__('Edit')
            : $this->__('New');
        $this->_headerText =  $newOrEdit . ' ' . $this->__('Sample type');
    }

}