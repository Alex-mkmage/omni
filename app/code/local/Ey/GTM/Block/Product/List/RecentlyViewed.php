<?php

class Ey_GTM_Block_Product_List_RecentlyViewed extends Mage_Core_Block_Template
{
    /**
     * @var Mage_Catalog_Model_Resource_Product_Collection
     */
    protected $_collection;

    /**
     * @return bool|Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getLoadedProductCollection()
    {
        if(!$this->_collection){
            $session = Mage::getSingleton('customer/session');
            $productIds = $session->getRecentlyViewed();
            if(count($productIds) > 0){
                $cart = Mage::getSingleton('checkout/cart');
                $items = $cart->getItems();

                foreach ($items as $item) {
                    foreach ($productIds as $key => $productId) {
                        if ($productId == $item->getProductId()) {
                            unset($productIds[$key]);
                        }
                    }
                }

                if(count($productIds) > 0) {
                    $products = Mage::getModel('catalog/product')->getCollection()
                        ->addAttributeToFilter('entity_id', array('in', $productIds))
                        ->addAttributeToSelect('*');

                    return $products;
                }
            }

            return false;
        }

        return $this->_collection;
    }
}