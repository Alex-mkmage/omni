<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn(
        $this->getTable('webforms'),
        'customer_result_permissions_serialized',
        'TEXT'
    )
;

$installer->endSetup();