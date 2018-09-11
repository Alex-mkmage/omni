<?php

class Ey_GTM_Block_Product_List_Impression extends Mage_Catalog_Block_Product_List
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
}