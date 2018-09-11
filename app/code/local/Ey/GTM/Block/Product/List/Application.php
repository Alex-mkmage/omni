<?php

class Ey_GTM_Block_Product_List_Application extends Ey_Applications_Block_Application_Document_Upsell
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