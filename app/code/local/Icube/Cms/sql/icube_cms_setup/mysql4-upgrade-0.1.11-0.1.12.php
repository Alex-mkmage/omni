<?php
/*
 * Description:
 * - disable cms block news_events
 */

$installer = $this;
$installer->startSetup();

$cmsBlock = Mage::getModel('cms/block')->load('news_events', 'identifier');
if($cmsBlock->getId()) {
    $cmsBlock->setIsActive(0)
        ->save();
}

$installer->endSetup();
