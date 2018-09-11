<?php
/**
 * Author : Ebizmarts <info@ebizmarts.com>
 * Date   : 9/9/13
 * Time   : 2:11 PM
 * File   : SageMethod.php
 * Module : Ebizmarts_SagePaymentsPro
 */
class Ebizmarts_SagePaymentsPro_Model_SageMethod
{
    protected function _getApi()
    {
        return Mage::getModel('ebizmarts_sagepaymentspro/api_sage');
    }
    public function removeCard($token) {
        $data = array();
        $storeId = Mage::app()->getStore()->getStoreId();
        $m_id = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_M_ID,$storeId);
        $m_key = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_MKEY,$storeId);
        $url = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_TOKEN_URL,$storeId);

        $data['M_ID'] = $m_id;
        $data['M_KEY'] = $m_key;
        $data['GUID'] = $token;
        $client = new SoapClient($url);
        $res = $client->DELETE_DATA($data);
        if($res->DELETE_DATAResult == 1) {
            $rc = 'OK';
        }
        else {
            $rc = "NOTOK";
        }
        return array('Status' => $rc);
    }

    public function registerCard($post)
    {
        $data = array();
        $data['CARDNUMBER']= $post['CardNumber'];
        $data['EXPIRATION_DATE']= sprintf('%02d%02d', $post['ExpiryMonth'], substr($post['ExpiryYear'], strlen($post['ExpiryYear']) - 2));
        $api = $this->_getApi();
        $token = $api->obtainToken($data);
        return $token;
    }
    public function addToken(Varien_Object $payment,$persist=true)
    {
        $data = array();
        if($payment->getCcNumber()){
            $data['CARDNUMBER']= $payment->getCcNumber();
            $data['EXPIRATION_DATE']= sprintf('%02d%02d', $payment->getCcExpMonth(), substr($payment->getCcExpYear(), strlen($payment->getCcExpYear()) - 2));
        }
        $api = $this->_getApi();
        $token = $api->obtainToken($data);
        if($persist) {
            $this->_persistToken($token,$payment);
        }
        return $token->getGuid();
    }
    protected function _persistToken(Varien_Object $tokenData, Varien_Object $payment)
    {
        $tokenCard = Mage::getModel('ebizmarts_sagepaymentspro/tokencard');
        $storeId = $payment->getStoreId();
        $cards = Mage::getModel('ebizmarts_sagepaymentspro/Config')->getCcTypesSagePayments();

        $tokenCard->setCustomerId($payment->getOrder()->getCustomerId())
            ->setToken($tokenData->getGuid())
            ->setStatus($tokenData->getResult())
            ->setCardType($cards[$payment->getCcType()])
            ->setLastFour(substr($payment->getCcNumber(),-4))
            ->setExpiryDate(sprintf('%02d%02d', $payment->getCcExpMonth(), substr($payment->getCcExpYear(), strlen($payment->getCcExpYear()) - 2)))
            ->setStatusDetail($tokenData->getResult())
            ->setVendor(Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_M_ID,$storeId))
            ->setIsDefault(false)
            ->setVisitorSessionId();
        $tokenCard->save();
        return $this;
    }
    public function postRequestWithToken($payment,$amount,$token)
    {
        $data = $this->_buildRequestWithToken($payment,$amount,$token);
        $api = $this->_getApi();
        $result = $api->postRequestSevd($data);
        return $result;
    }
    protected function _buildRequestForToken($payment,$token)
    {
        $order = $payment->getOrder();
        $billing = $order->getBillingAddress();
        $data = array();
        $storeId = $payment->getStoreId();
        $m_id = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_M_ID,$storeId);
        $m_key = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_MKEY,$storeId);
        $appId          = Mage::getModel('ebizmarts_sagepaymentspro/config')->getAppId();
        $lanId = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_LANID,$storeId);
        $xml  = "<?xml version='1.0' encoding='utf-16'?>";
        $xml .= "<Request_v1 xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema'>";
        $xml .= "<Application><ApplicationID>$appId</ApplicationID><LanguageID>$lanId</LanguageID></Application>";
        $xml .= "<Payments>";

        $xml .= "<PaymentType>";
        $xml .= "<Merchant><MerchantID>$m_id</MerchantID><MerchantKey>$m_key</MerchantKey></Merchant>";
        $xml .= "<TransactionBase><TransactionID>".$order->getIncrementId()."</TransactionID><TransactionType>$payment->getOperationType()</TransactionType><Reference1>INV# 451777675</Reference1><Amount>".$order->getData('grand_total')."</Amount></TransactionBase>";
        $xml .= "<Customer>";
        $xml .= "<Name><FirstName>".$billing->getData('firstname')."</FirstName><LastName>".$billing->getData('lastname')."</LastName></Name>";
        $xml .= "<Address>
                    <AddressLine1>".$billing->getStreet(1)."</AddressLine1>
                    <AddressLine2></AddressLine2>
                    <City>".$billing->getCity()."</City>
                    <State>".$billing->getRegion()."</State>
                    <ZipCode>".$billing->getPostcode()."</ZipCode>
                    <Country>".$billing->getCountry()."</Country>
                    <EmailAddress>".$order->getData('customer_email')."</EmailAddress>
                    <Telephone></Telephone>
                    <Fax></Fax>
                </Address>";
        $xml .= "</Customer>";
        if($token) {
            $xml .= "<VaultStorage><Service>RETRIEVE</Service><GUID>$token</GUID></VaultStorage>";
        }
        $xml .= "</PaymentType>";
        $xml .= "</Payments>";
        $xml .= "</Request_v1>";
        return urlencode($xml);
    }
    public function postRequestWithoutToken($payment)
    {
        $data= $this->_buildRequestWithoutToken($payment);
        $api = $this->_getApi();
        $result = $api->postRequest($data, $payment->getOperationType());
        return $result;
    }
    protected function _buildRequestWithoutToken($payment)
    {
        $order = $payment->getOrder();
        $data = array();
        $storeId = $payment->getStoreId();
        $m_id = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_M_ID,$storeId);
        $m_key = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_MKEY,$storeId);
        $data['M_ID'] = $m_id;
        $data['M_KEY'] = $m_key;


        if (!empty($order)) {
            $billing = $order->getBillingAddress();
            if (!empty($billing)) {
                $data['C_NAME'] = $payment->getCcOwner(); //$billing->getData('firstname') . ' ' . $billing->getData('lastname');
                $data['C_ADDRESS'] = $billing->getStreet(1);
                $data['C_CITY'] = $billing->getCity();
                $data['C_STATE'] = $billing->getRegion();
                $data['C_ZIP'] = $billing->getPostcode();
                $data['C_COUNTRY'] = $billing->getCountry();
                if (!preg_match("/^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/",
                    $order->getData('customer_email'))) {
                    $data['C_EMAIL']= "";
                } else {
                    $data['C_EMAIL']= $order->getData('customer_email');
                }
            }

            $shipping = $order->getShippingAddress();
            if (!empty($shipping)) {
                $data['C_SHIPPING_NAME'] = $shipping->getData('firstname') . ' ' . $shipping->getData('lastname');
                $data['C_SHIPPING_ADDRESS'] = $shipping->getStreet(1);
                $data['C_SHIPPING_CITY'] = $shipping->getCity();
                $data['C_SHIPPING_STATE'] = $shipping->getRegion();
                $data['C_SHIPPING_ZIP'] = $shipping->getPostcode();
                $data['C_SHIPPING_COUNTRY'] = $shipping->getCountry();
                $data['C_TELEPHONE'] = $shipping->getTelephone();

            } else {
                #If the cart only has virtual products, I need to put an shipping address to Sage Pay.
                #Then the billing address will be the shipping address to
                $data['C_SHIPPING_NAME']= $billing->getFirstName() . ' ' . $billing->getLastName();
                $data['C_SHIPPING_NAME']= $billing->getStreet(1);
                $data['C_SHIPPING_CITY']= $billing->getCity();
                $data['C_SHIPPING_STATE']= $billing->getRegion();
                $data['C_SHIPPING_ZIP']= $billing->getPostcode();
                $data['C_SHIPPING_COUNTRY']= $billing->getCountry();
            }
        }

        if($payment->getCcNumber()){
            $data['C_CARDNUMBER']= $payment->getCcNumber();
            $data['C_EXP']= sprintf('%02d%02d', $payment->getCcExpMonth(), substr($payment->getCcExpYear(), strlen($payment->getCcExpYear()) - 2));
        }
        $data['T_AMT']= $order->getData('grand_total');
        $data['T_SHIPPING'] = '';
        $data['T_TAX'] = '';
        $data['T_ORDERNUM'] = $order->getIncrementId();
        $data['C_CVV'] = $payment->getCcCid();
        return $data;
    }
    public function postReference($payment,$amount)
    {
        $transaction = Mage::getModel('ebizmarts_sagepaymentspro/transaction')->loadByOrderId($payment->getOrder()->getId(),$payment->getOrder()->getStoreId());
        if($transaction->getTransactionId()) {
            $data   = $this->_buildReferenceRequest($payment,$amount,$transaction);
            $api    = $this->_getApi();
            $result = $api->reference($transaction,$payment,$amount,$payment->getOperationType());
        }
        else {
            $data   = $this->_buildReferenceRequestOld($payment,$amount,$transaction->getReference());
            $api    = $this->_getApi();
            $result = $api->postRequest($data,$payment->getOperationType());
        }
//        $data = $this->_buildAuthoriseRequest($payment,$amount);
//        $api = $this->_getApi();
//        $result = $api->postRequest($data, $payment->getOperationType());
        return $result;
    }
    protected function _buildReferenceRequestOld($payment,$amount,$reference)
    {
        $data = array();
        $storeId = $payment->getStoreId();
        $m_id = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_M_ID,$storeId);
        $m_key = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_MKEY,$storeId);

        $data['M_ID'] = $m_id;
        $data['M_KEY'] = $m_key;
        $data['T_AMT'] = $amount;
        $data['T_REFERENCE'] = $reference;
        return $data;

    }
    protected function _buildAuthoriseRequest(Varien_Object $payment, $amount)
    {

        $data = array();
        $storeId = $payment->getStoreId();
        $m_id = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_M_ID,$storeId);
        $m_key = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_MKEY,$storeId);

        $data['M_ID'] = $m_id;
        $data['M_KEY'] = $m_key;
        $data['T_AMT'] = $amount;
        $data['T_REFERENCE'] = $payment->getLastTransId();
        return $data;
    }
    protected  function _buildRequestWithToken(Varien_Object $payment, $amount,$token)
    {
        $order = $payment->getOrder();
        $billing = $order->getBillingAddress();

        $country        = $billing->getCountryId();
        $userEmail      = $billing->getEmail();
        $userFirstName  = $billing->getFirstname();
        $userLastName   = $billing->getLastname();
        $state          = $billing->getRegion();
        $city           = $billing->getCity();
        $street1        = $billing->getStreet(1);
        $street2        = $billing->getStreet(2);
        $zipCode        = $billing->getPostcode();
        $ordernum       = $order->getIncrementId();
        $trnId          = substr($ordernum . '-' . date('Y-m-d-H-i-s'), 0, 40);
        $operation      = $payment->getOperationType();

        $storeId = $payment->getStoreId();
        $m_id = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_M_ID,$storeId);
        $m_key = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_MKEY,$storeId);
        $appId          = Mage::getModel('ebizmarts_sagepaymentspro/config')->getAppId();
        $lanId = Mage::getStoreConfig(Ebizmarts_SagePaymentsPro_Model_Config::CONFIG_LANID,$storeId);


        $xml = "<?xml version='1.0' encoding='utf-16'?>
<Request_v1 xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema'>
<Application>
<ApplicationID>$appId</ApplicationID>
<LanguageID>$lanId</LanguageID>
</Application>
<Payments>
<PaymentType>
<Merchant>
<MerchantID>$m_id</MerchantID>
<MerchantKey>$m_key</MerchantKey>
</Merchant>
<TransactionBase>
<TransactionID>$trnId</TransactionID>
<TransactionType>$operation</TransactionType>
<Reference1>$ordernum</Reference1>
<Amount>$amount</Amount>
</TransactionBase>
<Customer>
<Name>
<FirstName>$userFirstName</FirstName>
<MI> </MI>
<LastName>$userLastName</LastName>
</Name>
<Address>
<AddressLine1>$street1</AddressLine1>
<AddressLine2>$street2</AddressLine2>
<City>$city</City>
<State>$state</State>
<ZipCode>$zipCode</ZipCode>
<Country>$country</Country>
<EmailAddress>$userEmail</EmailAddress>
<Telephone></Telephone>
<Fax></Fax>
</Address>
</Customer>
<VaultStorage><GUID>$token</GUID><Service>RETRIEVE</Service></VaultStorage>
</PaymentType>
</Payments>
</Request_v1>";
        return $xml;

    }
}