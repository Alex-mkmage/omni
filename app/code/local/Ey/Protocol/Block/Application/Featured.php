<?php

class Ey_Protocol_Block_Application_Featured extends Ey_Protocol_Block_Application
{
    /**
     * @var array
     */
    protected $_productCollection;

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    /**
     * @throws Exception
     */
    protected function _prepareData()
    {
        $this->_prepareProductCollection();
    }

    /**
     * @return Ey_Protocol_Model_Application
     */
    protected function _getCollection()
    {
        if(!$collection = Mage::registry('current_featured_applications')){
            $collection = Mage::getModel('ey_protocol/application')
                ->getCollection()
                ->addFieldToFilter('is_featured', array('eq' => '1'))
                ->addFieldToFilter('visibility', array('in' => array(1, 2)))
                ->setOrder('sort_order', 'ASC')
                ->setOrder('name', 'ASC');

            if($limit = $this->getLimit()){
                $collection->getSelect()->limit($limit);
            }

            Mage::register('current_featured_applications', $collection);
        }
        return $collection;
    }

    /**
     * @return bool
     */
    public function isFeaturedExist()
    {
        $collection = $this->_getCollection();
        if($collection && $collection->getSize()){
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getApplicationList()
    {
        if(!$this->isFeaturedExist()){
            return array();
        }
        $collection = $this->_getCollection();
        $itemSkus = array();
        $itemArray = array();
        foreach($collection as $item) {
            $itemSkus[] = $item->getId();
            $itemArray[$item->getId()] = array(
                'application_id' => $item->getApplicationId(),
                'id' => $item->getId(),
                'visibility' => $item->getVisibility(),
                'url' => $item->getUrl(),
                'name' => $item->getName(),
                'files' => $item->getFiles(),
                'sample_type' => $item->getSampleType()->getName(),
                'tags' => $item->getTags(),
                'created' => $item->getCreatedAt(),
                'analyte' => $item->getAnalyte(),
                'image' => $item->getImage(),
                'procedure' => $item->getProcedure()
            );
        }

        $selectedSkus = Mage::getModel('ey_protocol/product')
            ->getCollection()
            ->addFieldToFilter('application_id', array('in' => $itemSkus));
        $products = $this->getProductCollection();

        foreach ($selectedSkus as $sku){
            if(isset($products[$sku->getSku()])) {
                $itemArray[$sku->getApplicationId()]['sku'] = $sku->getSku();
                $itemArray[$sku->getApplicationId()]['products'][] = array(
                    'product_id' => $products[$sku->getSku()]['id'],
                    'product_url' => $products[$sku->getSku()]['url'],
                    'product_name' => $products[$sku->getSku()]['name']
                );
            }
        }

        return $itemArray;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getRequestFormKey()
    {
        return $this->getRequest()->getParam('formkey');
    }
}