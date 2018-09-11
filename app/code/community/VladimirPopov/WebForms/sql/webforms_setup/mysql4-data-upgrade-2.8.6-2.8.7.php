<?php
/**
 * @author         Vladimir Popov
 * @copyright      Copyright (c) 2017 Vladimir Popov
 */
/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$connection = $installer->getConnection();

$webforms = Mage::getModel('webforms/webforms')->getCollection();

foreach ($webforms as $webform){
    $webform->setData('purge_enable','-1');
    $webform->save();
}