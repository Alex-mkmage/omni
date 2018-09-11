<?php

class Ey_Protocol_Block_Application_Document_Upsell extends Mage_Catalog_Block_Product_List_Related
{
    /**
     * @var Ey_Protocol_Model_Application
     */
    protected $_document;

    public function _construct()
    {
        parent::_construct();
    }

    protected function _prepareData()
    {
        if(!$document = Mage::registry('current_document')){
            if($id = $this->getRequest()->getParam('id')){
                $document = Mage::getModel('ey_protocol/application')->load($id);
                Mage::register('current_document', $document);
                $this->_document = $document;
            }
        }

        $this->_itemCollection = $document->getLoadedProducts();

        if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')) {
            Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($this->_itemCollection,
                Mage::getSingleton('checkout/session')->getQuoteId()
            );
            $this->_addProductAttributesAndPrices($this->_itemCollection);
        }
//        Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_itemCollection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($this->_itemCollection);

        $this->_itemCollection->load();

        foreach ($this->_itemCollection as $product) {
            $product->setDoNotUseCategoryId(true);
        }

        return $this;
    }

    /**
     * @return Ey_Protocol_Model_Application
     */
    public function getDocument()
    {
        return  $this->_document;
    }
}