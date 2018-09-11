<?php
$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('ey_applications/application'),
    'is_sent',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => false,
        'length'    => 10,
        'default'     => 1,
        'comment'   => 'Is Sent'
    )
);

$this->endSetup();