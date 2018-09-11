<?php
$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('ey_applications/application'),
    'image_name',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'default'     => '',
        'comment'   => 'Image'
    )
);

$this->endSetup();