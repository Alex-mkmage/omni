<?php

class Ey_Core_Block_Category_List extends Mage_Core_Block_Template
{
    /**
     * @return bool|Mage_Core_Model_Abstract
     */
    public function getCategory()
    {
        if(!$id = $this->getCategoryId()){
            return false;
        }
        return Mage::getModel('catalog/category')->load($id);
    }
}