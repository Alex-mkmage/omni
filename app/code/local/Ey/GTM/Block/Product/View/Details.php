<?php

class Ey_GTM_Block_Product_View_Details extends Mage_Catalog_Block_Product_View
{
    /**
     * @return string
     */
    public function getCategoryName()
    {
        if($category = Mage::registry('current_category')){
            return $category->getName();
        }
        return '';
    }
}