<?php
/*
 * Description:
 * - disable cms block news_events
 */

$installer = $this;
$installer->startSetup();

try {
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
<a class="link-download" href="#">Download brochure link</a></div>
</div>
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
<a class="link-download" href="#">Download brochure link</a></div>
</div>
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
<a class="link-download" href="#">Download brochure link</a></div>
</div>
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
<a class="link-download" href="#">Download brochure link</a></div>
</div>
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

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}

$installer->endSetup();
