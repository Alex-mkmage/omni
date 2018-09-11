<?php

class Ey_Applications_Block_Adminhtml_File_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'ey_applications';
        $this->_controller = 'adminhtml_file';

        $this->_mode = 'edit';

        $newOrEdit = $this->getRequest()->getParam('id')
            ? $this->__('Edit')
            : $this->__('New');
        $this->_headerText =  $newOrEdit . ' ' . $this->__('File');
    }

}