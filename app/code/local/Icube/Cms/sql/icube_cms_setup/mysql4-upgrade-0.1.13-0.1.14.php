<?php
/*
 * Description:
 * - disable cms block news_events
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('home-carusel', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('home-carusel', 'identifier');
$content =<<<EOF
<!--OWL Carousel-->
<div id="owl-demo" class="owl-carousel owl-theme">
<div class="item"><img alt="Bead Mill Homogenizers" src="{{skin_url='images/sample_banner_1.jpg'}}" /></div>
<div class="item"><img alt="Handheld Homogenizers" src="{{skin_url='images/sample_banner_1.jpg'}}" /></div>
<div class="item"><img alt="Ultrasonic Homogenizers" src="{{skin_url='images/sample_banner_1.jpg'}}" /></div>
</div>
EOF;

$staticBlock = array(
    'title' => 'Home Carusel Block',
    'identifier' => 'home-carusel',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('home-carusel');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}



} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}

$installer->endSetup();
