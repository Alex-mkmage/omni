<?php

class Ey_Report_Block_Adminhtml_Shipping extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'ey_report';
        $this->_controller = 'adminhtml_shipping';
        $this->_headerText = Mage::helper('sales')->__('Products Shipping Report');
        parent::__construct();
        $this->setTemplate('report/grid/container.phtml');
        $this->_removeButton('add');
        $this->addButton('filter_form_submit', array(
            'label'     => Mage::helper('reports')->__('Show Report'),
            'onclick'   => 'filterFormSubmit()'
        ));
    }

    public function getFilterUrl()
    {
        $this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/shipping', array('_current' => true));
    }
}
