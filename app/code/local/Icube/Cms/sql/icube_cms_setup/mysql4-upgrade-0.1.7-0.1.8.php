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
<nav class="featured-list">
<div class="container">
<ul>
<li class="featured icon-a sample"><a class="active" href="#bead-mill"><span>Bead Mill Homogenizers</span></a></li>
<li class="featured icon-b product"><a href="#rotor-strator"><span>Rotor-Strator Homogenizers</span></a></li>
<li class="featured icon-c help"><a href="#automation"><span>Automation Homogenizers</span></a></li>
<li class="featured icon-c help"><a href="#ultrasonic"><span>Ultrasonic Homogenizers</span></a></li>
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
<div class="featured-product-wrapper">
<div id="bead-mill" class="featured-product bead-mill">
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
<div id="rotor-strator" class="featured-product rotor-strator">
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
<div id="automation" class="featured-product automation">
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
<div id="ultrasonic" class="featured-product ultrasonic">
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
</div>
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

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}



$installer->endSetup();
