<?php

class Ey_Protocol_Block_Application_Document extends Ey_Protocol_Block_Application
{
    /**
     * @var Ey_Protocol_Model_Application
     */
    protected $_document;

    /**
     * @var int
     */
    public $maxDownloadTimes;

    public function _construct()
    {
        parent::_construct();
        $this->maxDownloadTimes = $this->helper('ey_protocol')->getDownloadLimit();
    }

    protected function _prepareLayout()
    {
        if($customer = $this->getRequest()->getParam('customer_data')){
            $message = $this->_saveCustomer($customer);
            if($message !== true){
                $this->setCustomerRegistered(true);
                $this->setCustomerRegisteredText($message);
            }
        }
        if(!$document = Mage::registry('current_document')){
            if($id = $this->getRequest()->getParam('id')){
                $document = Mage::getModel('ey_protocol/application')->load($id);
                Mage::register('current_document', $document);
                $this->_document = $document;
            }
        }
        Mage::dispatchEvent('protocol_render_before', array(
                'application' => $document
            )
        );
        $this->_prepareProductCollection();

        return parent::_prepareLayout();
    }

    /**
     * @param $data
     * @return bool|string
     * @throws Mage_Core_Exception
     */
    protected function _saveCustomer($data)
    {
        $websiteId = Mage::app()->getWebsite()->getId();
        $store = Mage::app()->getStore();

        $customer = Mage::getModel("customer/customer");
        $customer->website_id = $websiteId;
        $customer->setStore($store);

        try{
            $customer->loadByEmail($data['email']);
            if(!isset($data['login'])){
                if(!$customer->getId()){
                    $customer->setWebsiteId($websiteId)
                        ->setStore($store)
                        ->setFirstname($data['first_name'])
                        ->setLastname($data['last_name'])
                        ->setEmail($data['email'])
                        ->setTelephone($data['phone'])
                        ->setCompany($data['company'])
                        ->setPassword($data['password']);
                    $customer->save();
                    $customer->sendNewAccountEmail(
                        'registered',
                        '',
                        Mage::app()->getStore()->getId()
                    );
                }
            }
            $session = Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
            $session->login($data['email'], $data['password']);
            $this->_getSession()->addSuccess(
                $this->__('Thank you for registering with %s.', Mage::app()->getStore()->getFrontendName())
            );
        }
        catch (Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Retrieve customer session model object
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }


    /**
     * @param $email
     * @throws Exception
     * @throws Mage_Core_Exception
     */
    protected function _resetPassowrd($customer)
    {
        try {
            $newResetPasswordLinkToken =  Mage::helper('customer')->generateResetPasswordLinkToken();
            $customer->changeResetPasswordLinkToken($newResetPasswordLinkToken);
            $customer->sendPasswordResetConfirmationEmail();

            $this->setCustomerRegistered(true);
            $this->setCustomerRegisteredText('Please check your email address to reset your password.');
        }catch(Exception $e){
            throw $e;
        }

        return true;
    }

    /**
     * @return Ey_Protocol_Model_Application
     */
    public function getDocument()
    {
        return  $this->_document;
    }

    /**
     * @return Ey_Protocol_Model_Resource_Product_Collection
     */
    public function getRecommendedProducts()
    {
        if($document = $this->getDocument()){
            $products = Mage::getModel('ey_protocol/product')
                ->getCollection()
                ->addFieldToFilter('application_id', array('eq' => $document->getId()));

            return $products;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getCustomerLogUrl()
    {
        return Mage::getBaseUrl().'protocol/application/logger';
    }

    /**
     * @return bool
     */
    public function isAllowToDownload()
    {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $applicationId = $this->getDocument()->getId();
        $log = Mage::getModel('ey_protocol/customer')
            ->getCollection()
            ->addFieldToFilter('customer_id', array('eq' => $customer->getId()))
            ->addFieldToFilter('application_id', array('eq' => $applicationId))
            ->addFieldToFilter('timestamps', array('gt' => date("Y-m-d H:i:s", strtotime('-1 day'))));

        if($log->getSize()){
            foreach ($log as $item){
                $downloadTimes = $item->getDownload();
                if($this->maxDownloadTimes && $downloadTimes > $this->maxDownloadTimes){
                    return false;
                }
            }
        }

        return true;
    }
}