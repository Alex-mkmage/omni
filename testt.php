<?php

ini_set('display_errors',1);

echo '<pre>';

require_once 'app/Mage.php';
umask(0);
Mage::app();

$pCol = Mage::getModel('catalog/product')->getCollection();
$pCol->addAttributeToSelect('arqspin_id');

foreach ($pCol as $p) {
	if (strlen($p->getData('arqspin_id'))) {
		echo $p->getSku() . ' ' . $p->getData('arqspin_id') . PHP_EOL;
	}
}