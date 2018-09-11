<?php

class Ey_Core_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getCartPromos()
    {
        return Mage::getStoreConfig('ey_core/cart/promos', Mage::app()->getStore());
    }

    public function getCartReturn()
    {
        return Mage::getStoreConfig('ey_core/cart/return', Mage::app()->getStore());
    }
}