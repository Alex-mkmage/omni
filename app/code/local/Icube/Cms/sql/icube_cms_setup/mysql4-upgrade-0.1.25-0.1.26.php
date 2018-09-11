<?php
/*
 * Description:
 * - Update Get Help/Support block
 * - update header menu
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('header-menu', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('header-menu', 'identifier');
$content =<<<EOF
<div id="main-nav">
<div class="container">
<ul>
<li class="active mark">
<div class="drop-wrapper"><a href="javascript:void(0)">Products</a> {{block type="core/template" category_id="3" name="category-products" template="additional/subcategories.phtml"}}</div>
</li>
<li class="mark">
<div class="drop-wrapper"><a href="javascript:void(0)">Industries</a> {{block type="core/template" category_id="464" name="category-products" template="additional/subcategories.phtml"}}</div>
</li>
<li>
<div class="drop-wrapper"><a href="http://www.omni-inc.com/applications/" target="_blank">Applications</a></div>
</li>
<li class="mark support">
<div class="drop-wrapper"><a href="javascript:void(0)">Support</a>
<div class="drop">
<div class="products-section">
<ul class="megamenu">
<li><a class="box" href="{{store_url='warranty-registration'}}">Warranty Registration</a></li>
<li><a class="box" href="http://www.omni-inc.com/distributors/login.php" target="_blank">Distributor Login</a></li>
</ul>
</div>
</div>
</div>
</li>
<li class="mark corporate">
<div class="drop-wrapper"><a href="{{store_url='about-us'}}">Corporate</a>
<div class="drop">
<div class="products-section">
<ul class="megamenu">
<li><a class="box" href="{{store_url='about-us'}}">About Us</a></li>
<li><a class="box" href="{{store_url='our-history'}}">Our History</a></li>
<li><a class="box" href="{{store_url='distributor-locator'}}">Distributor Locator</a></li>
<li><a class="box" href="{{store_url='news'}}">Newsroom</a></li>
<li><a class="box" href="{{store_url='careers'}}">Careers</a></li>
<li><a class="box" href="{{store_url='contacts'}}">Contact Us</a></li>
</ul>
</div>
</div>
</div>
</li>
</ul>
</div>
</div>
EOF;

$staticBlock = array(
    'title' => 'Header Menu',
    'identifier' => 'header-menu',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('header-menu');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}



} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}
$installer->endSetup();
