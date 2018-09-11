<?php

/*
 * Description:
 * - update header menu
 * - update industries menu block
 */

$installer = $this;
$installer->startSetup();

try {
$cmsPage = Mage::getModel('cms/page')->load('home', 'identifier');

$pageContent =<<<EOF
<div class="banner">{{block type="cms/block" block_id="home-carusel"}}</div>
<nav class="choose-list">
<div class="container">
<ul>
<li class="sample"><a class="active" href="#tab1">Bead Meal Homogenizers</a></li>
<li class="product"><a href="#tab2">Handheld Homogenizers</a></li>
<li class="help"><a href="#tab3">Ultrasonic Homogenizers</a></li>
</ul>
</div>
</nav>
<div class="container">
<div id="tab1" class="tab-content">{{block type="cms/block" block_id="home-choose-sample-type"}}</div>
<div id="tab2" class="tab-content">{{block type="cms/block" block_id="home-choose-product-type"}}</div>
<div id="tab3" class="tab-content">{{block type="cms/block" block_id="home-help-me-shoose"}}</div>
</div>
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
    
$cmsBlock = Mage::getModel('cms/block')->load('home-carusel', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('home-carusel', 'identifier');
$content =<<<EOF
<div class="gallery g1">
<div id="bg" class="slides">
<section class="slide active"><img alt="Image description" src="{{skin_url='images/sample_banner_1.jpg'}}" height="500" width="1020" />
<div class="container">
<div class="text-holder">
<h1>&ldquo;The Homogenizer Company&rdquo;</h1>
<p>We design and produce the broadest range of lab homogenizer technology of any manufacturer in order to provide a choice of the best possible solutions for your specific sample processing needs.</p>
</div>
</div>
</section>
<section class="slide"><img alt="Image description" src="{{skin_url='images/sample_banner_1.jpg'}}" height="500" width="1020" />
<div class="container">
<div class="text-holder">
<h1>&ldquo;The Homogenizer Company&rdquo; 2</h1>
<p>We design and produce the broadest range of lab homogenizer technology of any manufacturer in order to provide a choice of the best possible solutions for your specific sample processing needs.</p>
</div>
</div>
</section>
<section class="slide"><img alt="Image description" src="{{skin_url='images/sample_banner_1.jpg'}}" height="500" width="1020" />
<div class="container">
<div class="text-holder">
<h1>&ldquo;The Homogenizer Company&rdquo; 3</h1>
<p>We design and produce the broadest range of lab homogenizer technology of any manufacturer in order to provide a choice of the best possible solutions for your specific sample processing needs.</p>
</div>
</div>
</section>
</div>
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
