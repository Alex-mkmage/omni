<?php

class Ey_Customer_Model_Observer
{
    /**
     * Customer Logout
     *
     * @param Varien_Event_Observer $observer
     */
    public function logoutRedirect($observer)
    {
        $lastUrl = Mage::getSingleton('core/session')->getLastUrl();
        if(strpos($lastUrl, 'application/application/logger/?application') !== false){
            $lastUrl .= '&redirect=true';
        }
        Mage::app()->getResponse()->setRedirect($lastUrl);
    }
}