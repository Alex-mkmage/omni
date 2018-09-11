<?php

class Ey_Report_Adminhtml_ReportController extends Mage_Adminhtml_Controller_Report_Abstract
{
    public function shippingAction()
    {
        $this->_title($this->__('Reports'))->_title($this->__('Products'))->_title($this->__('Shipping'));

        $this->_initAction()
            ->_setActiveMenu('report/products/shipping')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Products Shipping Report'), Mage::helper('adminhtml')->__('Products Shipping Report'));

        $gridBlock = $this->getLayout()->getBlock('adminhtml_shipping.grid');
        $filterFormBlock = $this->getLayout()->getBlock('grid.filter.form');

        $this->_initReportAction(array(
            $gridBlock,
            $filterFormBlock
        ));

        $this->renderLayout();
    }

    /**
     * Export shipping report grid to CSV format
     */
    public function exportShippingCsvAction()
    {
        $fileName   = 'products_shipping.csv';
        $grid       = $this->getLayout()->createBlock('ey_report/adminhtml_shipping_grid');
        $this->_initReportAction($grid);
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     * Report action init operations
     *
     * @param array|Varien_Object $blocks
     * @return Mage_Adminhtml_Controller_Report_Abstract
     */
    public function _initReportAction($blocks)
    {
        if (!is_array($blocks)) {
            $blocks = array($blocks);
        }

        $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));
        $params = new Varien_Object();

        foreach ($requestData as $key => $value) {
            if (!empty($value)) {
                $params->setData($key, $value);
            }
        }

        foreach ($blocks as $block) {
            if ($block) {
                $block->setFilterData($params);
            }
        }

        return $this;
    }
}
