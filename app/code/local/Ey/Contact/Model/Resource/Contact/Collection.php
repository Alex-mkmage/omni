<?php
class Ey_Contact_Model_Resource_Contact_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();

        $this->_init(
            'ey_contact/contact',
            'ey_contact/contact'
        );
    }
}