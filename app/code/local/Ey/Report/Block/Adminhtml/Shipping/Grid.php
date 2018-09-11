<?php

class Ey_Report_Block_Adminhtml_Shipping_Grid extends Mage_Adminhtml_Block_Report_Grid_Abstract
{
    protected $_defaultBoxType = 'singleboxes_id';

    protected $_allowedAttributes = array(
        'singleboxes_id', 'shipboxes_id', 'flatboxes_id', 'title', 'sku'
    );

    public function __construct()
    {
        parent::__construct();
        $this->setCountTotals(true);
    }

    protected function _getBoxType()
    {
        $filterData = $this->getFilterData();
        return $filterData->getData('box_type') ? $filterData->getData('box_type') : $this->_defaultBoxType;
    }

    public function getResourceCollectionName()
    {
        switch ($this->_getBoxType()){
            case 'singleboxes_id':
                return 'shipusa/singleboxes_collection';
                break;
            case 'shipboxes_id':
                return 'shipusa/shipboxes_collection';
                break;
            case 'flatboxes_id':
                return 'shipusa/flatboxes_collection';
                break;
            default:
                return 'shipusa/singleboxes_collection';
        }
    }

    public function getCollection()
    {
        if (is_null($this->_collection)) {
            $this->_prepareCollection();
        }
        return $this->_collection;
    }

    protected function _prepareCollection()
    {
        $filterData = $this->getFilterData();

        $resourceCollection = Mage::getResourceModel($this->getResourceCollectionName());

        $weight = Mage::getModel('catalog/product')->getResource()->getAttribute('weight');
        $resourceCollection->getSelect()->join(
            'catalog_product_entity',
            'main_table.sku = catalog_product_entity.sku',
            array('entity_id', 'type_id', 'product_sku' => 'sku')
        )->join(
            'catalog_product_entity_decimal',
            'catalog_product_entity.entity_id = catalog_product_entity_decimal.entity_id',
            array('weight' => 'value', 'attribute_id', 'store_id')
        )->where(
            'catalog_product_entity_decimal.attribute_id = '.
            $weight->getAttributeId().
            ' AND catalog_product_entity_decimal.store_id = 0'
        );

        if($this->_getBoxType() == 'singleboxes_id'){
            $resourceCollection->getSelect()->join(
                'boxmenu',
                'main_table.box_id = boxmenu.boxmenu_id',
                array('title', 'packing_weight', 'volume')
            );
        }

        if ($filterData->getData('id_from') != null) {
            $resourceCollection->addFieldToFilter(
                $this->_getBoxType(),
                    array('gt' => $filterData->getData('id_from'))
                );
        }
        if ($filterData->getData('id_to') != null) {
            $resourceCollection->addFieldToFilter(
                $this->_getBoxType(),
                array('lt' => $filterData->getData('id_to'))
            );
        }
        $this->_addCustomFilter($resourceCollection, $filterData);

        if ($this->_isExport) {
            $this->setCollection($resourceCollection);
            return $this;
        }

        if ($this->getCountSubTotals()) {
            $this->getSubTotals();
        }

        $this->getCountTotals();

        $this->setCollection($resourceCollection);

        return $this;
    }

    /**
     * Adds custom filter to resource collection
     * Can be overridden in child classes if custom filter needed
     *
     * @param Mage_Reports_Model_Resource_Report_Collection_Abstract $collection
     * @param Varien_Object $filterData
     * @return Mage_Adminhtml_Block_Report_Grid_Abstract
     */
    protected function _addCustomFilter($collection, $filterData)
    {
        $data = $filterData->getData();
        foreach ($data as $field => $value){
            if(!in_array($field, $this->_allowedAttributes)) continue;
            if($field == 'sku') $field = 'main_table.' . $field;
            $collection->addFieldToFilter($field, array('like' => '%'.$value.'%'));
        }

        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn($this->_getBoxType(), array(
            'header'        => Mage::helper('ey_report')->__('Box ID'),
            'index'         => $this->_getBoxType(),
            'width'         => 100,
            'sortable'      => true,
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('ey_report')->__('Product SKU'),
            'index'     => 'sku',
            'type'      => 'string',
            'sortable'  => false
        ));

        if($this->_getBoxType() == 'singleboxes_id') {
            $this->addColumn('title', array(
                'header' => Mage::helper('ey_report')->__('Box Title'),
                'index' => 'title',
                'type' => 'string',
                'sortable' => false
            ));
        }

        $this->addColumn('weight', array(
            'header'        => Mage::helper('ey_report')->__('Weight'),
            'type'          => 'string',
            'index'         => 'weight',
            'sortable'      => false,
        ));

        $this->addColumn('length', array(
            'header'        => Mage::helper('ey_report')->__('Length'),
            'type'          => 'string',
            'index'         => 'length',
            'sortable'      => false,
        ));

        $this->addColumn('width', array(
            'header'    => Mage::helper('ey_report')->__('Width'),
            'index'     => 'width',
            'type'      => 'string',
            'sortable'  => false
        ));

        $this->addColumn('height', array(
            'header'    => Mage::helper('ey_report')->__('Height'),
            'index'     => 'height',
            'type'      => 'string',
            'sortable'  => false
        ));

        $this->addColumn('max_box', array(
            'header'    => Mage::helper('ey_report')->__('Max Qty allowed'),
            'index'     => 'max_box',
            'type'      => 'string',
            'sortable'  => false
        ));

        $this->addColumn('min_qty', array(
            'header'    => Mage::helper('ey_report')->__('Min Qty Box Valid from'),
            'index'     => 'min_qty',
            'type'      => 'string',
            'sortable'  => false
        ));

        $this->addColumn('max_qty', array(
            'header'    => Mage::helper('ey_report')->__('Max Qty Box Valid upto'),
            'index'     => 'max_qty',
            'type'      => 'string',
            'sortable'  => false
        ));

        if($this->_getBoxType() == 'singleboxes_id') {
            $this->addColumn('volume', array(
                'header' => Mage::helper('ey_report')->__('Volume'),
                'index' => 'volume',
                'type' => 'string',
                'sortable' => false
            ));
        }


        $this->addExportType('*/*/exportShippingCsv', Mage::helper('adminhtml')->__('CSV'));

        return parent::_prepareColumns();
    }

    public function getCountTotals()
    {
        if (!$this->getTotals()) {
            $filterData = $this->getFilterData();
            $totalsCollection = Mage::getResourceModel($this->getResourceCollectionName());

            if (count($totalsCollection->getItems()) < 1 || !$filterData->getData('from')) {
                $this->setTotals(new Varien_Object());
            } else {
                foreach ($totalsCollection->getItems() as $item) {
                    $this->setTotals($item);
                    break;
                }
            }
        }
        return $this->_countTotals;
    }

    public function getSubTotals()
    {
        $filterData = $this->getFilterData();
        $subTotalsCollection = Mage::getResourceModel($this->getResourceCollectionName());

        if ($filterData->getData('id_from') != null) {
            $subTotalsCollection->addFieldToFilter(
                $this->_defaultBoxType,
                array('gt' => $filterData->getData('id_from'))
            );
        }
        if ($filterData->getData('id_to') != null) {
            $subTotalsCollection->addFieldToFilter(
                $this->_defaultBoxType,
                array('lt' => $filterData->getData('id_to'))
            );
        }

        $this->_addCustomFilter($subTotalsCollection, $filterData);

        $this->setSubTotals($subTotalsCollection->getItems());
        return $this->_subtotals;
    }
}
