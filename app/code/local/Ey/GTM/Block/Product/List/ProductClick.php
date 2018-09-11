<?php

class Ey_GTM_Block_Product_List_ProductClick extends Mage_Catalog_Block_Product_List
{
    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLoadedProductCollection()
    {
        return $this->_getProductCollection();
    }

    /**
     * @return Mage_Catalog_Model_Category
     */
    public function getCategory()
    {
        $layer = $this->getLayer();
        return $layer->getCurrentCategory();
    }

    /**
     * @return string
     */
    public function getJsonConfig()
    {
        $productData = array();
        $products = $this->getLoadedProductCollection();

        if($products->getSize()){
            $i = 1;
            foreach ($products as $product){
                $productData[$product->getSku()] = array(
                    'name' => $product->getName(),
                    'sku' => $product->getSku(),
                    'url' => $product->getProductUrl(),
                    'price' => $product->getFinalPrice(),
                    'category' => $this->getCategory()->getId()?$this->getCategory()->getName():'',
                    'position' => $i++
                );
            }
        }

        return Mage::helper('core')->jsonEncode($productData);
    }
}