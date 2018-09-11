<?php

class Puru_Multislider_Model_Mysql4_Multislider extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the multislider_id refers to the key field in your database table.
        $this->_init('multislider/multislider', 'multislider_id');
    }
}