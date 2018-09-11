<?php
class Ey_Applications_Model_Resource_Fileapp_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();

        $this->_init(
            'ey_applications/fileapp',
            'ey_applications/fileapp'
        );
    }
}