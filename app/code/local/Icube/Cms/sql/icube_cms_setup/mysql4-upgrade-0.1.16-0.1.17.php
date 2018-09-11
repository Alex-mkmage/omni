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
<li class="featured icon-d help"><a href="#ultrasonic"><span>{{block type="cms/block" block_id="ultrasonic-menu"}}</span></a></li>
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

$cmsBlock = Mage::getModel('cms/block')->load('home-content', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('home-content', 'identifier');
$content =<<<EOF
<div class="featured-product-wrapper">{{block type="cms/block" block_id="beadmill_content"}} {{block type="cms/block" block_id="rotorstrator_content"}} {{block type="cms/block" block_id="automation_content"}} {{block type="cms/block" block_id="ultrasonic_content}}</div>
EOF;

$staticBlock = array(
    'title' => 'Home Content',
    'identifier' => 'home-content',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('home-content');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('beadmill_content', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('beadmill_content', 'identifier');
$content =<<<EOF
<div id="bead-mill" class="featured-product bead-mill">{{block type="cms/block" block_id="beadmill_background"}}
<div class="left">
<div class="featured-title"><span>Bead Mill Homogenizers</span> <a href="#">See all products</a></div>
</div>
<div class="right">
<div class="featured-desc">
<h3>Featured Product</h3>
<p class="product-name">Bead Raptor 24</p>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
<p>Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.</p>
<a class="link-download" href="#">Download brochure link</a></div>
</div>
<div class="clear">&nbsp;</div>
</div>
EOF;

$staticBlock = array(
    'title' => 'Bead Mill Content',
    'identifier' => 'beadmill_content',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('beadmill_content');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('rotorstrator_content', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('rotorstrator_content', 'identifier');
$content =<<<EOF
<div id="rotor-strator" class="featured-product rotor-strator">{{block type="cms/block" block_id="rotorstrator_background"}}
<div class="left">
<div class="featured-title"><span>Rotor Stator Homogenizers</span> <a href="#">See all products</a></div>
</div>
<div class="right">
<div class="featured-desc">
<h3>Featured Product</h3>
<p class="product-name">Bead Raptor 24</p>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
<p>Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.</p>
<a class="link-download" href="#">Download brochure link</a></div>
</div>
<div class="clear">&nbsp;</div>
</div>
EOF;

$staticBlock = array(
    'title' => 'Rotor Strator Content',
    'identifier' => 'rotorstrator_content',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('rotorstrator_content');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('automation_content', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('automation_content', 'identifier');
$content =<<<EOF
<div id="automation" class="featured-product automation">{{block type="cms/block" block_id="automation_background"}}
<div class="left">
<div class="featured-title"><span>Automation Homogenizers</span> <a href="#">See all products</a></div>
</div>
<div class="right">
<div class="featured-desc">
<h3>Featured Product</h3>
<p class="product-name">Bead Raptor 24</p>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
<p>Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.</p>
<a class="link-download" href="#">Download brochure link</a></div>
</div>
<div class="clear">&nbsp;</div>
</div>
EOF;

$staticBlock = array(
    'title' => 'Automation Content',
    'identifier' => 'automation_content',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('automation_content');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('ultrasonic_content', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('ultrasonic_content', 'identifier');
$content =<<<EOF
<div id="ultrasonic" class="featured-product ultrasonic">{{block type="cms/block" block_id="ultrasonic_background"}}
<div class="left">
<div class="featured-title"><span>Ultrasonic Homogenizers</span> <a href="#">See all products</a></div>
</div>
<div class="right">
<div class="featured-desc">
<h3>Featured Product</h3>
<p class="product-name">Bead Raptor 24</p>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
<p>Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.</p>
<a class="link-download" href="#">Download brochure link</a></div>
</div>
<div class="clear">&nbsp;</div>
</div>
EOF;

$staticBlock = array(
    'title' => 'Ultrasonic Content',
    'identifier' => 'ultrasonic_content',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('ultrasonic_content');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('beadmill_background', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('beadmill_background', 'identifier');
$content =<<<EOF
<p><img alt="" src="{{skin_url='images/bg-bread.jpg'}}" /></p>
EOF;

$staticBlock = array(
    'title' => 'Bead Mill Background',
    'identifier' => 'beadmill_background',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('beadmill_background');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('rotorstrator_background', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('rotorstrator_background', 'identifier');
$content =<<<EOF
<p><img alt="" src="{{skin_url="images/bg-rotor.jpg"}}" /></p>
EOF;

$staticBlock = array(
    'title' => 'Rotor Strator Background',
    'identifier' => 'rotorstrator_background',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('rotorstrator_background');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('automation_background', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('automation_background', 'identifier');
$content =<<<EOF
<p><img alt="" src="{{skin_url="images/bg-automation.jpg"}}" /></p>
EOF;

$staticBlock = array(
    'title' => 'Automation Background',
    'identifier' => 'automation_background',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('automation_background');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('ultrasonic_background', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('ultrasonic_background', 'identifier');
$content =<<<EOF
<p><img alt="" src="{{skin_url="images/bg-ultrasonic.jpg"}}" /></p>
EOF;

$staticBlock = array(
    'title' => 'Ultrasonic Background',
    'identifier' => 'ultrasonic_background',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('ultrasonic_background');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}

$installer->endSetup();
