<?php
$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('icube_distributor'),
    'store_locator_id',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => false,
        'comment'   => 'Store Locator ID'
    )
);

$this->endSetup();