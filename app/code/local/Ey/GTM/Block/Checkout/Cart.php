<?php

class Ey_GTM_Block_Checkout_Cart extends Mage_Core_Block_Template
{
    /**
     * @return array
     */
    public function getAddedItem()
    {
        if($productData = Mage::getSingleton('core/session')->getLastAddedItem()){
            Mage::getSingleton('core/session')->unsLastAddedItem();
            return $productData;
        }
        return array();
    }

    /**
     * @return array
     */
    public function getRemovedItem()
    {
        if($productData = Mage::getSingleton('core/session')->getLastRemovedItem()){
            Mage::getSingleton('core/session')->unsLastRemovedItem();
            return $productData;
        }
        return array();
    }
}