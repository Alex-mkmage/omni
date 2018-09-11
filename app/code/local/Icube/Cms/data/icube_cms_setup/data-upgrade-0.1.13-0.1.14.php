<?php
$setup = Mage::getResourceModel('catalog/setup','catalog_setup');
$setup->removeAttribute('catalog_product','quotemode_conditions');