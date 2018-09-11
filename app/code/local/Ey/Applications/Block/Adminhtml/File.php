<?php

class Ey_Applications_Block_Adminhtml_File extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'ey_applications';

        $this->_controller = 'adminhtml_file';

        $this->_headerText = Mage::helper('ey_applications')->__('File');
    }

    public function getCreateUrl()
    {
        return $this->getUrl(
            'adminhtml/file/edit'
        );
    }
}