<?php
 
$installer = $this;

$installer->startSetup();

$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('ipdetect/quoteextend')};
	CREATE TABLE {$this->getTable('ipdetect/quoteextend')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `quote_id` int(11) NOT NULL,
	  `distributor_id` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
 
$installer->endSetup();