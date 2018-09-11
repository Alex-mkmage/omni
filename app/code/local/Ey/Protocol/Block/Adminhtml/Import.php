<?php

class Ey_Protocol_Block_Adminhtml_Import extends Mage_Adminhtml_Block_Template
{
    /**
     * Path to template file in theme.
     *
     * @var string
     */
    protected $_template = 'ey/protocol/import.phtml';

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return Mage::helper("adminhtml")->getUrl('*/*/post');
    }


}