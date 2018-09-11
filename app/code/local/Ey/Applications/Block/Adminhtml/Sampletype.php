<?php

class Ey_Applications_Block_Adminhtml_Sampletype extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'ey_applications';

        $this->_controller = 'adminhtml_sampletype';

        $this->_headerText = Mage::helper('ey_applications')->__('Sample Types');
    }

    public function getCreateUrl()
    {
        return $this->getUrl(
            'adminhtml/sampletype/edit'
        );
    }
}