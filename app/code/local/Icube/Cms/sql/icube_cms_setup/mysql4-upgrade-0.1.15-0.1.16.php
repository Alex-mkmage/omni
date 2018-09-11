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
<div class="banner"><!--OWL Carousel-->
<div id="owl-demo" class="owl-carousel owl-theme">
<div class="item">{{block type="cms/block" block_id="banner-1"}}</div>
<div class="item">{{block type="cms/block" block_id="banner-2"}}</div>
<div class="item">{{block type="cms/block" block_id="banner-3"}}</div>
</div>
</div>
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

$cmsBlock = Mage::getModel('cms/block')->load('banner-1', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('banner-1', 'identifier');
$content =<<<EOF
<img alt="Bead Mill Homogenizers" src="{{skin_url='images/sample_banner_1.jpg'}}" />
EOF;

$staticBlock = array(
    'title' => 'Banner Carousel 1',
    'identifier' => 'banner-1',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('banner-1');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('banner-2', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('banner-2', 'identifier');
$content =<<<EOF
<img alt="Bead Mill Homogenizers" src="{{skin_url='images/sample_banner_1.jpg'}}" />
EOF;

$staticBlock = array(
    'title' => 'Banner Carousel 2',
    'identifier' => 'banner-2',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('banner-2');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('banner-3', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('banner-3', 'identifier');
$content =<<<EOF
<img alt="Bead Mill Homogenizers" src="{{skin_url='images/sample_banner_1.jpg'}}" />
EOF;

$staticBlock = array(
    'title' => 'Banner Carousel 3',
    'identifier' => 'banner-3',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('banner-3');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}

$installer->endSetup();
