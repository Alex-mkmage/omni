<?php

class Ey_Contact_Model_Resource_Contact extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ey_contact/contact', 'id');
    }
}