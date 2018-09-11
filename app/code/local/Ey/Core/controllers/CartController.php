<?php

class Ey_Core_CartController extends Mage_Core_Controller_Front_Action
{
    public function updateQtyAction()
    {
        $qty = $this->getRequest()->getParam('qty');
        $productId = $this->getRequest()->getParam('product');

        try {
            $cart = Mage::getSingleton('checkout/cart');
            $items = $cart->getItems();

            foreach ($items as $item) {
                if ($productId == $item->getId()) {
                    $item->setQty($qty);
                    $cart->save();
                }
            }

            $quote = Mage::getSingleton('checkout/cart')->getQuote();
            $newQuote = array(
                'success' => true,
                'subtotal' => Mage::helper('core')->currency($quote->getSubtotal(), true, false),
                'grand_total' => Mage::helper('core')->currency($quote->getGrandTotal(), true, false),
                'subtotal_with_discount' => Mage::helper('core')->currency($quote->getSubtotalWithDiscount(), true, false),
                'tax' => Mage::helper('core')->currency($quote->getShippingAddress()->getData('tax_amount'), true,
                    false),
                'item_count' => $quote->getItemsCount()
            );
        } catch(Exception $e){
            $newQuote = array(
                'success' => false,
                'message' => 'Error!'
            );
            $this->getResponse()->setBody(
                Mage::helper('core')->jsonEncode($newQuote)
            );
        }

        $this->getResponse()->setBody(
            Mage::helper('core')->jsonEncode($newQuote)
        );
    }
}