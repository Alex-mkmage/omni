<?php
$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('ey_contact/contact'),
    'find',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'default'     => '',
        'comment'   => 'How does the customer find us?'
    )
);

$this->getConnection()->addColumn(
    $this->getTable('ey_contact/contact'),
    'category',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'default'     => '',
        'comment'   => 'Contact or Quote or etc.'
    )
);

$this->endSetup();