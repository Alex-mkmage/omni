<?php

class Ey_Applications_Block_Application extends Mage_Core_Block_Template
{
    /**
     * @var array
     */
    protected $_productShortNames;

    public function getAction()
    {
        return $this->getBaseUrl() . 'application/application/list';
    }

    public function getFormKey()
    {
        return Mage::getSingleton('core/session')->getFormKey();
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $head = $this->getLayout()->getBlock('head');
        if ($head) {
            if ($document = Mage::registry('current_document')) {
                $head->setData('title', $document->getName());
                $head->setDescription($document->getDescription());
            } else {
                $head->setData('title', $this->helper('ey_applications')->getSeoPageTitle());
                $head->setDescription($this->helper('ey_applications')->getSeoMetaDescription());
            }
            $head->setKeywords($this->helper('ey_applications')->getSeoMetaKeywords());
        }
        $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
        if ($breadcrumbs) {
            $breadcrumbs->addCrumb('home', array(
                    'label' => $this->helper('ey_applications')->__('Home'),
                    'title' => $this->helper('ey_applications')->__('Home Page'),
                    'link' => Mage::getBaseUrl())
            );
            $breadcrumbs->addCrumb('list', array(
                    'label' => $this->helper('ey_applications')->__('Applications'),
                    'title' => $this->helper('ey_applications')->__('Applications'),
                    'link' => Mage::getBaseUrl() . 'application/application/index')
            );
            if ($document = Mage::registry('current_document')) {
                $breadcrumbs->addCrumb('document', array(
                        'label' => $document->getName(),
                        'title' => $document->getName(),
                        'link' => $document->getUrl())
                );
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @param $productSkus
     * @return bool
     */
    protected function _prepareProductCollection()
    {
        if ($serializedCollection = $this->_getCachedProductCollection()) {
            $this->_productCollection = unserialize(urldecode($serializedCollection));
        } else {
            $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect('name');
            if ($collection->getSize()) {
                foreach ($collection as $product) {
                    $this->_productCollection[$product->getSku()] = array(
                        'name' => $product->getName(),
                        'id' => $product->getId(),
                        'url' => $product->getProductUrl()
                    );
                }
            }
        }

        $this->_setCachedProductCollection($this->_productCollection);

        return true;
    }

    /**
     * @return false|string
     */
    protected function _getCachedProductCollection()
    {
        $storeId = Mage::app()->getStore()->getId();
        $cache = Mage::app()->getCache();
        $key = 'application-product-collection-' . $storeId;

        if ($products = $cache->load($key)) {
            return $products;
        }

        return false;
    }

    /**
     * @param array $products
     * @return bool
     */
    protected function _setCachedProductCollection($products)
    {
        $storeId = Mage::app()->getStore()->getId();
        $cache = Mage::app()->getCache();
        $key = 'application-product-collection-' . $storeId;

        $serializeReports = serialize($products);
        $cache->save(urlencode($serializeReports), $key, array("application_product_collection_cache"), 60 * 60 * 24);

        return false;
    }

    /**
     * @return array
     */
    public function getProductCollection()
    {
        return $this->_productCollection;
    }

    /**
     * @param $path
     * @return string
     */
    public function getDownloadLink($file)
    {
        return Mage::getBaseUrl() . 'application/application/download?file=' . $file->getDownloadPath()
        . '&id=' . $file->getId();
    }

    /**
     * @return array
     */
    public function getInitSearchCriteria()
    {
        return Mage::getSingleton('customer/session')->getSearchCriteria();
    }

    /**
     * @return array
     */
    public function getSearchCriteriaLabels()
    {
        $searchCriteria = $this->getInitSearchCriteria();

        if (isset($searchCriteria['sampletype_id'])) {
            $types = $this->getSampleTypes();
            $searchTypes = $searchCriteria['sampletype_id'];
            foreach ($searchTypes as $key => $type) {
                $searchCriteria['sampletype_id'][$key] = $types[$type];
            }
        }
        if (isset($searchCriteria['product_id'])) {
            $productShortNames = $this->getProductShortNames();
            $products = $searchCriteria['product_id'];
            foreach ($products as $key => $product) {
                if(isset($productShortNames[$product])){
                    $searchCriteria['product_id'][$key] = $productShortNames[$product];
                }
            }
        }

        return $searchCriteria;
    }

    /**
     * @return array
     */
    protected function getSampleTypes()
    {
        if (!$typeArray = Mage::getSingleton('customer/session')->getSampleTypes()) {
            $types = Mage::getModel('ey_applications/sampletype')
                ->getCollection()
                ->load();

            foreach ($types as $type) {
                $typeArray[$type->getId()] = $type->getName();
            }

            Mage::getSingleton('customer/session')->setSampleTypes($typeArray);
        }

        return $typeArray;
    }

    /**
     * @param array $names
     */
    public function setProductShortNames($names)
    {
        Mage::register('app_product_short_names', $names);
    }

    /**
     * @return array
     */
    public function getProductShortNames()
    {
        if(!$this->_productShortNames){
            $this->_productShortNames = Mage::registry('app_product_short_names');
        }

        return $this->_productShortNames;
    }
}