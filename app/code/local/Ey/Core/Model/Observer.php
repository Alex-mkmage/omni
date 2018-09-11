<?php

class Ey_Core_Model_Observer
{
    /**
     * Customer Login
     *
     * @param Varien_Event_Observer $observer
     */
    public function customerLogin($observer)
    {
        $customer = Mage::getModel('customer/customer')->load($observer->getCustomer()->getId());
        $billing = $customer->getPrimaryBillingAddress();
        $shipping = $customer->getPrimaryShippingAddress();

        if($billing && $shipping){
            if($billing->getCountryId == $shipping->getCountryId){
                $countryId = $shipping->getCountryId();
            } elseif($shipping->getCountryId && $shipping->getCountryId != ''){
                $countryId = $shipping->getCountryId();
            } else{
                $countryId = $billing->getCountryId();
            }
            if($countryId){
                $distributors = $this->_setCountry($countryId);
                $this->_setDistributer($distributors);
                $this->_saveCookie();
            }
        }
    }

    protected function _setCountry($countryCode)
    {
        $countryName = Mage::getModel('directory/country')->loadByCode($countryCode)->getName();
        $distributor = Mage:: getModel('distributor/distributor')->getDistributorList($countryCode);

        $data = array();
        foreach ($distributor as $value) {
            $data[] = $value->getData();
        }

        $country = array(
            'code'          => $countryCode,
            'name'          => $countryName,
            'distibutors'   => $data
        );

        $session = Mage::getSingleton('core/session');
        $session->setData('current_country', $country);

        return $data;
    }

    protected function _setDistributer(array $distributor)
    {
        $session = Mage::getSingleton('core/session');
        $session->setData('current_distributer', $distributor[0]);
    }

    protected function _saveCookie(){

        $session = Mage::getSingleton('core/session');

        $period = 2592000;

        Mage::getSingleton('core/cookie')->set('current_country',
            serialize($session->getData('current_country')),
            $period,
            '/'
        );

        Mage::getSingleton('core/cookie')->set('current_distributer',
            serialize($session->getData('current_distributer')),
            $period,
            '/'
        );
    }

    /**
     * Customer Save After
     *
     * @param Varien_Event_Observer $observer
     */
    public function afterCustomerSave($observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        if (!$customer || !$customer instanceof Ophirah_Qquoteadv_Model_Customer_Customer || !$customer->getId()){
            return $this;
        }

        $customerParams = Mage::app()->getRequest()->getParam('customer');

        if($customerParams){
            $dataShipping = array(
                'firstname'  => $customerParams['firstname'],
                'lastname'   => $customerParams['lastname'],
                'street'     => array($customerParams['shipping_address']),
                'city'       => $customerParams['shipping_city'],
                'region'     => $customerParams['shipping_region'],
                'region_id'  => $customerParams['shipping_region_id'],
                'postcode'   => $customerParams['shipping_postcode'],
                'country_id' => $customerParams['shipping_country_id'],
                'telephone'  => $customerParams['telephone'],
            );

            $customerAddress = Mage::getModel('customer/address');

            if ($defaultShippingId = $customer->getDefaultShipping()){
                $customerAddress->load($defaultShippingId);
            } else {
                $customerAddress
                    ->setCustomerId($customer->getId())
                    ->setIsDefaultShipping('1')
                    ->setSaveInAddressBook('1')
                ;

                $customer->addAddress($customerAddress);
            }

            try {
                $customerAddress
                    ->addData($dataShipping)
                    ->save()
                ;
            } catch(Exception $e){
                Mage::log('Address Save Error::' . $e->getMessage());
            }

        }

        return $this;

    }

    /**
     * Catalog Product
     *
     * @param Varien_Event_Observer $observer
     */
    public function catalogProductView($observer)
    {
        $product = $observer->getProduct();
        $session 	= Mage::getSingleton('customer/session');
        $products = $session->getRecentlyViewed() ? $session->getRecentlyViewed() : array();
        $products[] = $product->getId();
        $session->setData('recently_viewed', array_unique($products));
    }
}