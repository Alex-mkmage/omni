<?php

/*
 * Description:
 * - update header menu
 * - update industries menu block
 */

$installer = $this;
$installer->startSetup();

try {
$cmsPage = Mage::getModel('cms/page')->load('newsletter', 'identifier');

$pageContent =<<<EOF
{{block type="newsletter/subscribe" template="newsletter/subscribe.phtml"}}
EOF;

if(!$cmsPage->getId()){
    $cmsPage->setTitle('Newsletter');
}

$cmsPage->setStores(array(0))
    ->setIdentifier('newsletter')
    ->setContentHeading('Newsletter')
    ->setContent($pageContent)
    ->setIsActive(1)
    ->setRootTemplate('2columns_right')
    ->save();

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}



$installer->endSetup();
