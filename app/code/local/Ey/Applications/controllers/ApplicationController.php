<?php

class Ey_Applications_ApplicationController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->renderLayout();
    }

    public function documentAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->renderLayout();
    }

    public function listAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->renderLayout();
    }

    public function productsAction()
    {
        if($term = $this->getRequest()->getParam('term')){
            $products = $this->_getProductList($term);
            $this->getResponse()->setBody($products);
        }
    }

    public function loggerAction()
    {
        $applicationId = $this->getRequest()->getParam('application');
        if($this->getRequest()->getParam('redirect')){
            $this->_redirect('application/application/document', array('id' => $applicationId));
        }

        $response = array();
        $flag = false;
        if(Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $log = Mage::getModel('ey_applications/customer')
                ->getCollection()
                ->addFieldToFilter('customer_id', array('eq' => $customer->getId()))
                ->addFieldToFilter('application_id', array('eq' => $applicationId));
            if($log->getSize()){
                foreach ($log as $item){
                    $date = date('Y-m-d', strtotime($item->getTimestamps()));
                    $today = new DateTime();
                    $today = $today->format('Y-m-d');
                    $downloadTimes = $item->getDownload();
                    if($date == $today){
                        $item->setTimestamps(now());
                        $item->setDownload(++$downloadTimes);
                        $item->save();
                        $flag = true;
                        break;
                    }
                }
            }
            if(!$flag) {
                Mage::getModel('ey_applications/customer')
                    ->setTimestamps(now())
                    ->setApplicationId($applicationId)
                    ->setCustomerId($customer->getId())
                    ->setDownload(1)
                    ->save();
            }
            $response['success'] = true;
        } else{
            $response['success'] = false;
            $response['error'] = true;
            $response['message'] = 'Please log in.';
        }
        $this->getResponse()->setBody(
            Mage::helper('core')->jsonEncode($response)
        );
    }

    /**
     * @param string $term
     * @return string
     */
    protected function _getProductList($term)
    {
        $storeId = Mage::app()->getStore()->getId();
        $cache = Mage::app()->getCache();
        $key = 'application-product-name-' . $term . $storeId;

        if(!$products = $cache->load($key)){
            $productSkus = array();
            $products = Mage::getModel('catalog/product')
                ->getCollection()
                ->addFieldToFilter('name', array('like' => '%'.$term.'%'))
                ->addAttributeToSort('name', 'ASC');

            if($products->getSize()){
                foreach($products as $product){
                    $productSkus[] = array(
                        'id' => $product->getId(),
                        'label' => $product->getName(),
                        'value' => $product->getSku()
                    );
                }

                $serializeReports = serialize($productSkus);
                $cache->save(urlencode($serializeReports), $key, array("application_name_cache"), 60*60*24);

                return Mage::helper('core')->jsonEncode($productSkus);
            } else{
                return '';
            }
        }

        return Mage::helper('core')->jsonEncode(unserialize(urldecode($products)));
    }

    public function downloadAction()
    {
        $data = $this->getRequest()->getParams();
        $filepath = isset($data['file'])?$data['file']:'';

        if (!is_file ( $filepath ) || !is_readable ( $filepath ) || !isset($data['id'])) {
            $this->_redirectReferer();
        }

        $this->getResponse ()
            ->setHttpResponseCode ( 200 )
            ->setHeader ( 'Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true )
            ->setHeader ( 'Pragma', 'public', true )
            ->setHeader ( 'Content-type', 'application/force-download' )
            ->setHeader ( 'Content-Length', filesize($filepath) )
            ->setHeader ('Content-Disposition', 'attachment' . '; filename=' . basename($filepath) );
        $this->getResponse ()->clearBody ();
        $this->getResponse ()->sendHeaders ();
        readfile ( $filepath );

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        Mage::dispatchEvent('application_download_after', array(
                'customer' => $customer,
                'id' => $data['id']
            )
        );

        $this->_redirectReferer();
    }

    public function loginAction()
    {
        if($customer = $this->getRequest()->getParam('customer_data')){
            $this->_saveCustomer($customer);
        }
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
            $message = 'Thank you for logging in.';
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
                    $customer->applicationAccountCreationNotify(
                        '',
                        Mage::app()->getStore()->getId()
                    );
                    $customer->sendNewAccountEmail(
                        'application',
                        '',
                        Mage::app()->getStore()->getId()
                    );
                    $message = 'Thank you for registering with us.';
                }
            }
            $session = Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
            $session->login($data['email'], $data['password']);
            Mage::getSingleton('customer/session')->addSuccess(
                $this->__($message)
            );
        }
        catch (Exception $e) {
            Mage::getSingleton('customer/session')->addSuccess(
                $this->__($e->getMessage())
            );
        }
        $this->_redirectReferer();
    }
}