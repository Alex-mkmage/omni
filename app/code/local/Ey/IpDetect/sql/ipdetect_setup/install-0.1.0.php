<?php
 
$installer = $this;

$installer->startSetup();

$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('ipdetect/ipdetect')};
	CREATE TABLE {$this->getTable('ipdetect/ipdetect')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `visitor_id` int(11) NOT NULL,
	  `visitor_data` text NOT NULL default '',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
 
$installer->endSetup();