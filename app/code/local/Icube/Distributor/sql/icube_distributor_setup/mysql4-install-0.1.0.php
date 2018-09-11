<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
DROP TABLE IF EXISTS `{$this->getTable('icube_distributor')}`;
CREATE TABLE `{$this->getTable('icube_distributor')}` (
	`id` int not null auto_increment,
	`title` varchar(100),
	`active` smallint(1),
	`phone` varchar(50),
	`country_code` varchar(4),
	`region` varchar(100), 
	`street` text,	
	`city` varchar(100),
	`postal_code` varchar(50),
	`desc` varchar(100),
	`latitude` varchar(50),
	`longitude` varchar(50),
	`stores` smallint(2),
	`website`varchar(100),
	`icon` varchar(100),
	`image` varchar(200),
	`position` smallint(2),
	primary key(id)		
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 