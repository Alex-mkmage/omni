<?php

set_time_limit(0);
ob_implicit_flush(true);

require_once('app/Mage.php');
umask(0);
Mage::app();
Mage::app()->setCurrentStore(1);

$collection = Mage::getModel('storelocator/stores')->getCollection();

foreach ($collection as $item) {
	echo '<pre>';
	print_r($item->getData());
	echo '</pre>';
}


?>