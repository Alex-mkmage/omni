<?php
$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('ey_protocol/file'),
    'file_path',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'default'     => '',
        'comment'   => 'File Path'
    )
);

$this->endSetup();