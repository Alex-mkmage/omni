<?php
$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('ey_applications/application'),
    'type',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'default'     => '',
        'comment'   => 'Type of the document'
    )
);

$this->getConnection()->addColumn(
    $this->getTable('ey_applications/application'),
    'website',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'default'     => '',
        'comment'   => 'Website URL'
    )
);

$this->getConnection()->addColumn(
    $this->getTable('ey_applications/application'),
    'year',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => true,
        'length'    => 10,
        'comment'   => 'Year'
    )
);

$this->endSetup();