<?php

class Ey_Core_Block_Checkout_Cart_Recentlyviewd extends Mage_Core_Block_Template
{
    /**
     * @var array
     */
    protected $_productIds;

    /**
     * Internal constructor, that is called from real constructor
     *
     */
    protected function _construct()
    {
        parent::_construct();

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
            $this->_productIds = $productIds;
        }
    }

    public function getItems()
    {
        if(count($this->_productIds) > 0) {
            $products = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('entity_id', array('in', $this->_productIds))
                ->addAttributeToSelect('*');

            return $products;
        }

        return false;
    }

}