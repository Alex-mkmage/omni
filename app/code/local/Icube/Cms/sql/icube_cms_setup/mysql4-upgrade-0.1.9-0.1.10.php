<?php
/*
 * Description:
 * - disable CMS page - news
 */

$installer = $this;
$installer->startSetup();

$cmsPage = Mage::getModel('cms/page')->load('news', 'identifier');

$cmsPage->setIsActive(0)
    ->save();

$installer->endSetup();
