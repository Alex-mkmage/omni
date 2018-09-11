<?php

class Ey_Applications_Block_Adminhtml_Application_Edit_Tab_Files extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct() {
        parent::__construct();
        $this->setId('filegrid');
        $this->setDefaultSort('entity_id');
        $this->setSaveParametersInSession(false);
        $this->setUseAjax(true);
        if ($id = $this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(array('in_file' => 1));
        }
    }

    protected function _addColumnFilterToCollection($column) {
        if ($column->getId() == 'in_file') {
            $bannerIds = $this->_getSelectedItem();

            if (empty($bannerIds)) {
                $bannerIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $bannerIds));
            } else {
                if ($bannerIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $bannerIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('ey_applications/file')->getCollection();

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('in_file', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'in_file',
            'align' => 'center',
            'field_name' => 'in_file[]',
            'index' => 'entity_id',
            'values' => $this->_getSelectedItem(),
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('ey_applications')->__('Name'),
            'index' => 'name'
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl() {
        return $this->getData('grid_url') ? $this->getData('grid_url') : $this->getUrl('*/*/filegrid', array('_current' => true, 'id' => $this->getRequest()->getParam('id')));
    }

    public function getRowUrl($row) {
        return '';
    }

    public function getSelectedItem() {

        $tm_id = $this->getRequest()->getParam('id');
        if (!isset($tm_id)) {
            return array();
        }
        $collection = Mage::getModel('ey_applications/fileapp')->getCollection()
            ->addFieldToFilter('application_id', $tm_id);

        $fileIds = array();
        foreach ($collection as $obj) {
            $fileIds[$obj->getFileId()] = array('order' => $obj->getOrderBanner());
        }
        return $fileIds;
    }

    protected function _getSelectedItem()
    {
        $products = $this->getRequest()->getParam('file');
        if (!is_array($products)) {
            $products = array_keys($this->getSelectedItem());
        }
        return $products;
    }
}