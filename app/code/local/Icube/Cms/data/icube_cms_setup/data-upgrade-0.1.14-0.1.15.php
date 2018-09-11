<?php
$setup = Mage::getResourceModel('catalog/setup','catalog_setup');
$setup->removeAttribute('catalog_product','allowed_to_ordermode');
$setup->removeAttribute('catalog_product','hide_price');