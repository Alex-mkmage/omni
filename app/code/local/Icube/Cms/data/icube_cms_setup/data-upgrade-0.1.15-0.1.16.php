<?php

$installer = $this;
$installer->startSetup();

try {

$cmsBlock = Mage::getModel('cms/block')->load('news_events', 'identifier');
$content =<<<EOF
{{block type="core/template" template="wordpress/latest_post.phtml"}}
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

} catch (Exception $e) {
    throw new Exception('SET BASE STORE NAME FAILED. ' . $e->getMessage());
}

$installer->endSetup();