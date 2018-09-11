<?php

/**
 * Class Ey_GTM_Model_Observer
 */
class Ey_GTM_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function afterAddToCart($observer)
    {
        if($quoteItem = $observer->getEvent()->getQuoteItem()){
            $options = $quoteItem->getProduct()->getTypeInstance(true)->getOrderOptions($quoteItem->getProduct());
            $orderOptions = array();
            if(isset($options['attributes_info'])){
                foreach ($options['attributes_info'] as $option){
                    $orderOptions[] = $option['value'];
                }
            }
            if(isset($options['options'])){
                foreach ($options['options'] as $option){
                    $orderOptions[] = $option['print_value'];
                }
            }
            Mage::getSingleton('core/session')->setLastAddedItem(
                array(
                    'name' => $quoteItem->getName(),
                    'sku' => $quoteItem->getSku(),
                    'price' => $quoteItem->getProduct()->getFinalPrice(),
                    'quantity' => $quoteItem->getQty(),
                    'variant' => implode(', ', $orderOptions)
                )
            );
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function afterRemoveItemFromCart($observer)
    {
        if($quoteItem = $observer->getEvent()->getQuoteItem()){
            $options = $quoteItem->getProduct()->getTypeInstance(true)->getOrderOptions($quoteItem->getProduct());
            $orderOptions = array();
            if(isset($options['attributes_info'])){
                foreach ($options['attributes_info'] as $option){
                    $orderOptions[] = $option['value'];
                }
            }
            if(isset($options['options'])){
                foreach ($options['options'] as $option){
                    $orderOptions[] = $option['print_value'];
                }
            }
            Mage::getSingleton('core/session')->setLastRemovedItem(
                array(
                    'name' => $quoteItem->getName(),
                    'sku' => $quoteItem->getSku(),
                    'price' => $quoteItem->getProduct()->getFinalPrice(),
                    'quantity' => $quoteItem->getQty(),
                    'variant' => implode(', ', $orderOptions)
                )
            );
        }
    }


}
