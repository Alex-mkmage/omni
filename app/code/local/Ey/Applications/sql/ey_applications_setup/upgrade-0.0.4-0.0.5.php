<?php
$this->startSetup();

$table = new Varien_Db_Ddl_Table();
$table->setName($this->getTable('ey_applications/customer'));
$table->addColumn(
    'entity_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    10,
    array(
        'auto_increment' => true,
        'unsigned' => true,
        'nullable'=> false,
        'primary' => true
    )
);
$table->addColumn(
    'timestamps',
    Varien_Db_Ddl_Table::TYPE_DATETIME,
    null,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'application_id',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'customer_id',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable'=> true
    )
);
$table->addColumn(
    'download',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    null,
    array(
        'nullable'=> true
    )
);

$table->setOption('type', 'InnoDB');
$table->setOption('charset', 'utf8');

$this->getConnection()->createTable($table);

$this->endSetup();
