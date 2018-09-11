<?php

class Ey_GTM_Block_Product_List_Related extends Mage_Catalog_Block_Product_List_Related
{
    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLoadedProductCollection()
    {
        return $this->getItems();
    }
}