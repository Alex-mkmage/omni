<?php 

require_once 'app/Mage.php';
umask(0);
Mage::app();
echo "test";
phpinfo();


?>