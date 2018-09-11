<?php
/* @var $installer MageWorx_Downloads_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->modifyColumn(
    $installer->getTable('downloads/files'),
    'category_id',
    "text default ''"
);

$installer->getConnection()->addColumn(
    $installer->getTable('downloads/files'),
    'category_text',
    "text default ''"
);

$installer->endSetup();