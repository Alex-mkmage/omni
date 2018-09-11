<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn(
        $this->getTable('webforms'),
        'delete_submissions',
        'INT(1)'
    );
$installer->getConnection()->addColumn(
    $this->getTable('webforms'),
    'purge_enable',
    'INT(1)'
);
$installer->getConnection()->addColumn(
    $this->getTable('webforms'),
    'purge_period',
    'INT(10)'
);
$installer->getConnection()->addColumn(
    $this->getTable('webforms/fields'),
    'hide_label',
    'INT(1)'
);

$installer->endSetup();