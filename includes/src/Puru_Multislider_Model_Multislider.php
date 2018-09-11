<?php

class Puru_Multislider_Model_Multislider extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('multislider/multislider');
    }
}