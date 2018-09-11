<?php
/*
 * Description:
 * - disable cms block news_events
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('get_help', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('get_help', 'identifier');
$content =<<<EOF
<div class="sidebar-section get-help">
<h2>Get Help</h2>
<p>Call us at&nbsp; (800) 776.4431</p>
<p><a href="{{store_url='contacts'}}">Email a Quick Question</a></p>
<p>Find Distributors</p>
<p>Get Product Support</p>
</div>
EOF;

$staticBlock = array(
    'title' => 'get_help',
    'identifier' => 'get_help',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('get_help');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('constant_contact', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('constant_contact', 'identifier');
$content =<<<EOF
<div class="sidebar-news">{{block type="newsletter/subscribe" template="newsletter/subscribe.phtml"}}</div>
EOF;

$staticBlock = array(
    'title' => 'constant_contact',
    'identifier' => 'constant_contact',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('constant_contact');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}

$installer->endSetup();
