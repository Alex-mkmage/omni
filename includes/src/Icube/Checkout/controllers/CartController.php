<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shopping cart controller modified by Icube
 */
class Icube_Checkout_CartController extends Mage_Core_Controller_Front_Action
{
    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * Get current active quote instance
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
        return $this->_getCart()->getQuote();
    }    

    /**
     * Set back redirect url to response
     *
     * @return Mage_Checkout_CartController
     * @throws Mage_Exception
     */
    protected function _goBack()
    {
        $returnUrl = $this->getRequest()->getParam('return_url');
        if ($returnUrl) {

            if (!$this->_isUrlInternal($returnUrl)) {
                throw new Mage_Exception('External urls redirect to "' . $returnUrl . '" denied!');
            }

            $this->_getSession()->getMessages(true);
            $this->getResponse()->setRedirect($returnUrl);
        } elseif (!Mage::getStoreConfig('checkout/cart/redirect_to_cart')
            && !$this->getRequest()->getParam('in_cart')
            && $backUrl = $this->_getRefererUrl()
        ) {
            $this->getResponse()->setRedirect($backUrl);
        } else {
            if (($this->getRequest()->getActionName() == 'add') && !$this->getRequest()->getParam('in_cart')) {
                $this->_getSession()->setContinueShoppingUrl($this->_getRefererUrl());
            }
            $this->_redirect('checkout/cart');
        }
        return $this;
    }


    /**
     * Initialize shipping information via ajax
     */
    public function estimatePostAjaxAction()
    {
        $country    = (string) $this->getRequest()->getParam('country_id');
        $postcode   = (string) $this->getRequest()->getParam('estimate_postcode');
        $city       = (string) $this->getRequest()->getParam('estimate_city');
        $regionId   = (string) $this->getRequest()->getParam('region_id');
        $region     = (string) $this->getRequest()->getParam('region');

        $this->_getQuote()->getShippingAddress()
        ->setCountryId($country)
        ->setCity($city)
        ->setPostcode($postcode)
        ->setRegionId($regionId)
        ->setRegion($region)
        ->setCollectShippingRates(true);
        $this->_getQuote()->save();

        $response = array();
        $response['shipping']=$this->estimateajax();
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }

    protected function estimateajax()
    {
        $layout=$this->getLayout();
        
        $layout->getMessagesBlock()->setMessages(Mage::getSingleton('checkout/session')->getMessages(true),Mage::getSingleton('catalog/session')->getMessages(true)); 
        $block = $this->getLayout()->createBlock('checkout/cart_shipping')->setTemplate( 'checkout/cart/shipping.phtml');

        $rates = $this->_getQuote()->getShippingAddress()->collectShippingRates()
                         ->getGroupedAllShippingRates();

        $block->setShippingMethod = $rates;

        return $block->toHtml();
    }


    public function estimateUpdatePostAction()
    {
        $code = (string) $this->getRequest()->getParam('estimate_method');
        if (!empty($code)) {
            $this->_getQuote()->getShippingAddress()->setShippingMethod($code)/*->collectTotals()*/->save();
        }
        $this->_goBack();
    }
    /**
     * Estimate update action Ajax
     *
     */
    public function estimateUpdateAjaxAction()
    {
        $code = (string) $this->getRequest()->getParam('estimate_method');
        if (!empty($code)) {
            $this->_getQuote()->getShippingAddress()->setShippingMethod($code)->save();
            $this->_getQuote()->collectTotals();
        }

        $response = array();
        $response['total'] = $this->totalUpdate();
        Mage::getSingleton('checkout/session')->setCartWasUpdated(true);

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }

    protected function totalUpdate()
    {
        $layout=$this->getLayout();
        $layout->getMessagesBlock()->setMessages(Mage::getSingleton('checkout/session')->getMessages(true),Mage::getSingleton('catalog/session')->getMessages(true)); 
                
        $block = $layout->createBlock('checkout/cart_totals')->setTemplate( 'checkout/cart/totals.phtml');

        return $block->toHtml();
    }

}