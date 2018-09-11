<?php
$this->startSetup();

$table = new Varien_Db_Ddl_Table();
$table->setName($this->getTable('ey_protocol/file'));
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
    'created_at',
    Varien_Db_Ddl_Table::TYPE_DATETIME,
    null,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'updated_at',
    Varien_Db_Ddl_Table::TYPE_DATETIME,
    null,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'name',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'mime_type',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'file_hash',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'file_size',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'file_id',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => false,
    )
);

$table2 = new Varien_Db_Ddl_Table();
$table2->setName($this->getTable('ey_protocol/fileapp'));
$table2->addColumn(
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
$table2->addColumn(
    'file_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    10,
    array(
        'nullable'=> true
    )
);
$table2->addColumn(
    'application_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    10,
    array(
        'nullable'=> true
    )
);
$table2->addColumn(
    'order',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    100,
    array(
        'nullable'=> true
    )
);

$table->setOption('type', 'InnoDB');
$table->setOption('charset', 'utf8');
$table2->setOption('type', 'InnoDB');
$table2->setOption('charset', 'utf8');

$this->getConnection()->createTable($table);
$this->getConnection()->createTable($table2);

$this->endSetup();