<?php

/*
 * Description:
 * - update header menu
 * - update industries menu block
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('footer-menu', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('footer-menu', 'identifier');
$content =<<<EOF
<div class="footer-nav">
<ul>
<li class="first title">Our Products</li>
<li><a href="#">Rotor Stator Homogenizers</a></li>
<li><a href="#">Ultrasonic Homogenizers</a></li>
<li><a href="#">Bead Mill Homogenizers</a></li>
<li><a href="#">Automation Homogenizers</a></li>
<li><a href="#">Manual Homogenizers</a></li>
<li class="last"><a href="#">Accesories</a></li>
</ul>
<ul>
<li class="first title">Ordering</li>
<li><a href="#">Invoice History</a></li>
<li><a href="#">Quote History</a></li>
<li class="last"><a href="#">My Omni</a></li>
</ul>
<ul>
<li class="first title">Support</li>
<li><a href="#">Waranty Registration</a></li>
<li class="last"><a href="#">Distributor Login</a></li>
</ul>
<ul>
<li class="first title">Corporate</li>
<li><a href="{{store_url='about-us'}}">About Omni-Inc</a></li>
<li><a href="#">Our History</a></li>
<li><a href="{{store_url='distributor-locator'}}">Distributor Locator</a></li>
<li><a href="{{store_url='news'}}">Newsroom</a></li>
<li><a href="#">Careers</a></li>
<li class="last"><a href="{{store_url='contacts'}}">Contact Us</a></li>
</ul>
</div>
<div class="footer-bottom-menu">
<ul>
<li class="first"><a href="{{store_url='privacy-policy'}}">Privacy</a></li>
<li><a href="{{store_url='terms-of-use'}}">Terms of Use</a></li>
<li><a href="{{store_url='trademarks'}}">Trademarks</a></li>
<li><a href="{{store_url='catalog/seo_sitemap/category/'}}">Sitemap</a></li>
<li class="last"><a href="{{store_url='careers'}}">Careers</a></li>
</ul>
<div class="social-media"><a class="social facebook" href="#">&nbsp;</a> <a class="social twitter" href="#">&nbsp;</a> <a class="social linked" href="#">&nbsp;</a></div>
<div class="clear">&nbsp;</div>
</div>
EOF;

$staticBlock = array(
    'title' => 'Footer Menu',
    'identifier' => 'footer-menu',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('footer-menu');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}



$installer->endSetup();
