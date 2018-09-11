<?php

class Ey_Core_Block_Product_List extends Mage_Catalog_Block_Product_Abstract
{
    /**
     * Product Collection
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_productCollection;

    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getProductCollection()
    {
        $productIds = $this->getProductIds();
        $productIds = explode(',', $productIds);
        if (is_array($productIds) && count($productIds) > 0) {
            $this->_productCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('entity_id', array('in' => $productIds));
        }

        return $this->_productCollection;
    }

    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLoadedProductCollection()
    {
        return $this->_getProductCollection();
    }
}