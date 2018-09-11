<?php

class Ey_GTM_Block_Product_List_RecentlyViewed_ProductClick extends Ey_GTM_Block_Product_List_RecentlyViewed
{
    /**
     * @return string
     */
    public function getJsonConfig()
    {
        $productData = array();
        $products = $this->getLoadedProductCollection();

        if($products && $products->getSize()){
            $i = 1;
            foreach ($products as $product){
                $productData[$product->getSku()] = array(
                    'name' => $product->getName(),
                    'sku' => $product->getSku(),
                    'url' => $product->getProductUrl(),
                    'price' => $product->getFinalPrice(),
                    'position' => $i++
                );
            }
        }

        return Mage::helper('core')->jsonEncode($productData);
    }
}