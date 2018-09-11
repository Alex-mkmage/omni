<?php

class Ey_Applications_Block_Adminhtml_Application_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('app_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Manage Application'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('app_edit_general', array(
            'label'     => $this->__('General Information'),
            'title'     => $this->__('General Information'),
            'content'   => $this->getLayout()
                ->createBlock('ey_applications/adminhtml_application_edit_tab_form')
                ->toHtml()
        ));

        $this->addTab('app_edit_file', array(
            'label'     => $this->__('Add New File'),
            'title'     => $this->__('Add New File'),
            'content'   => $this->getLayout()
                ->createBlock('ey_applications/adminhtml_application_edit_tab_file')
                ->toHtml()
        ));

        $this->addTab('app_edit_files', array(
            'label'     => $this->__('Files'),
            'title'     => $this->__('Files'),
            'url'   => $this->getUrl('*/*/file', array('_current' => true, 'id' => $this->getRequest()->getParam('id'))),
            'class' => 'ajax'
        ));

        return parent::_beforeToHtml();
    }
}