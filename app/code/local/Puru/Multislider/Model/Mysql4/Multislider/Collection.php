<?php

class Puru_Multislider_Model_Mysql4_Multislider_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('multislider/multislider');
    }
}