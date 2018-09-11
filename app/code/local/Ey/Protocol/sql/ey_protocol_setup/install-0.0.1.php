<?php
$this->startSetup();

$table = new Varien_Db_Ddl_Table();
$table->setName($this->getTable('ey_protocol/application'));
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
    'application_id',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable'=> true
    )
);
$table->addColumn(
    'folder_id',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable'=> true
    )
);
$table->addColumn(
    'procedure',
    Varien_Db_Ddl_Table::TYPE_TEXT,
    null,
    array(
        'nullable' => true,
    )
);
$table->addColumn(
    'visibility',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    10,
    array(
        'nullable' => false,
    )
);
$table->addColumn(
    'sort_order',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    null,
    array(
        'nullable' => true,
    )
);
$table->addColumn(
    'file_id',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => true,
    )
);
$table->addColumn(
    'video',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => true,
    )
);
$table->addColumn(
    'sample_amount',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => true,
    )
);
$table->addColumn(
    'analyte',
    Varien_Db_Ddl_Table::TYPE_TEXT,
    null,
    array(
        'nullable' => true,
    )
);
$table->addColumn(
    'sample_type',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => true,
    )
);

$table2 = new Varien_Db_Ddl_Table();
$table2->setName($this->getTable('ey_protocol/product'));
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
    'product_id',
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
    'sku',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => true,
    )
);

$table3 = new Varien_Db_Ddl_Table();
$table3->setName($this->getTable('ey_protocol/tag'));
$table3->addColumn(
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
$table3->addColumn(
    'name',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => false,
    )
);
$table3->addColumn(
    'priority',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    100,
    array(
        'nullable'=> true
    )
);
$table3->addColumn(
    'application_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    10,
    array(
        'nullable'=> true
    )
);

$table4 = new Varien_Db_Ddl_Table();
$table4->setName($this->getTable('ey_protocol/sampletype'));
$table4->addColumn(
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
$table4->addColumn(
    'name',
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable' => false,
    )
);

$table5 = new Varien_Db_Ddl_Table();
$table5->setName($this->getTable('ey_protocol/type'));
$table5->addColumn(
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
$table5->addColumn(
    'sampletype_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    10,
    array(
        'nullable'=> true
    )
);
$table5->addColumn(
    'application_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    10,
    array(
        'nullable'=> true
    )
);

$table->setOption('type', 'InnoDB');
$table->setOption('charset', 'utf8');
$table2->setOption('type', 'InnoDB');
$table2->setOption('charset', 'utf8');
$table3->setOption('type', 'InnoDB');
$table3->setOption('charset', 'utf8');
$table4->setOption('type', 'InnoDB');
$table4->setOption('charset', 'utf8');
$table5->setOption('type', 'InnoDB');
$table5->setOption('charset', 'utf8');

$this->getConnection()->createTable($table);
$this->getConnection()->createTable($table2);
$this->getConnection()->createTable($table3);
$this->getConnection()->createTable($table4);
$this->getConnection()->createTable($table5);

$this->endSetup();
