<?php
/*
 * Description:
 * - update text to Home Page for SEO purpose position
 */

$installer = $this;
$installer->startSetup();

$cmsBlock = Mage::getModel('cms/block')->load('news_events', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('news_events', 'identifier');
$content =<<<EOF
{{block type="core/template" template="news/centernews.phtml"}}
EOF;

$staticBlock = array(
    'title' => 'News & Events',
    'identifier' => 'news_events',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('news_events');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsPage = Mage::getModel('cms/page')->load('news', 'identifier');

$pageContent =<<<EOF
<div>{{block type="core/template" template="news/centernews.phtml"}}</div>
EOF;

if(!$cmsPage->getId()){
    $cmsPage->setTitle('Newsroom');
}

$cmsPage->setStores(array(0))
    ->setIdentifier('news')
    ->setContentHeading('Newsroom')
    ->setContent($pageContent)
    ->setIsActive(1)
    ->setRootTemplate('2columns_right')
    ->save();

$installer->endSetup();
