<?php
$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('ey_applications/application'),
    'is_featured',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => false,
        'length'    => 10,
        'comment'   => 'Is Featured'
    )
);

$this->endSetup();