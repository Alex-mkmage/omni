<?php
/*
 * Description:
 * - disable cms block news_events
 */

$installer = $this;
$installer->startSetup();

try {

$cmsPage = Mage::getModel('cms/page')->load('home', 'identifier');

$pageContent =<<<EOF
<div class="banner">{{block type="cms/block" block_id="home-carusel"}}</div>
<nav class="featured-list">
<div class="container">
<ul>
<li class="featured icon-a sample"><a class="active" href="#bead-mill"><span>{{block type="cms/block" block_id="bead-mill-menu"}}</span></a></li>
<li class="featured icon-b product"><a href="#rotor-strator"><span>{{block type="cms/block" block_id="rotor-strator-menu"}}</span></a></li>
<li class="featured icon-c help"><a href="#automation"><span>{{block type="cms/block" block_id="automation-menu"}}</span></a></li>
<li class="featured icon-c help"><a href="#ultrasonic"><span>{{block type="cms/block" block_id="ultrasonic-menu"}}</span></a></li>
</ul>
</div>
</nav>
<div class="container">{{block type="cms/block" block_id="home-content"}}</div>
EOF;

if(!$cmsPage->getId()){
    $cmsPage->setTitle('Home page');
}

$cmsPage->setStores(array(0))
    ->setIdentifier('home')
    ->setContentHeading('Home page')
    ->setContent($pageContent)
    ->setIsActive(1)
    ->setRootTemplate('one_column')
    ->save();

$cmsBlock = Mage::getModel('cms/block')->load('bead-mill-menu', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('bead-mill-menu', 'identifier');
$content =<<<EOF
Bead Mill Homogenizers
EOF;

$staticBlock = array(
    'title' => 'Bead Mill Menu',
    'identifier' => 'bead-mill-menu',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('bead-mill-menu');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('rotor-strator-menu', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('rotor-strator-menu', 'identifier');
$content =<<<EOF
<p>Rotor-Strator Homogenizers</p>
EOF;

$staticBlock = array(
    'title' => 'Rotor-Strator Menu',
    'identifier' => 'rotor-strator-menu',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('rotor-strator-menu');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('automation-menu', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('automation-menu', 'identifier');
$content =<<<EOF
<p>Automation Homogenizers</p>
EOF;

$staticBlock = array(
    'title' => 'Automation Menu',
    'identifier' => 'automation-menu',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('automation-menu');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('ultrasonic-menu', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('ultrasonic-menu', 'identifier');
$content =<<<EOF
<p>Ultrasonic Homogenizers</p>
EOF;

$staticBlock = array(
    'title' => 'Ultrasonic Menu',
    'identifier' => 'ultrasonic-menu',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('ultrasonic-menu');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}

$installer->endSetup();
