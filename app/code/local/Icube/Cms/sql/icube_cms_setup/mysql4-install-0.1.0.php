<?php

$installer = $this;
$installer->startSetup();


$cmsPage = Mage::getModel('cms/page')->load('news', 'identifier');

$pageContent =<<<EOF
<div>{{block type="core/template" template="<code>app/design/frontend/</code>default/default/template/news/centernews.phtml"}}</div>
EOF;

if(!$cmsPage->getId()){
    $cmsPage->setTitle('Newsroom');
}

$cmsPage->setStores(array(0))
    ->setIdentifier('news')
    ->setContentHeading('Newsroom')
    ->setContent($pageContent)
    ->setIsActive(1)
    ->setRootTemplate('2columns_right')
    ->save();


$cmsBlock = Mage::getModel('cms/block')->load('header-menu', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('header-menu', 'identifier');
$content =<<<EOF
<div id="main-nav">
<div class="container">
<ul>
<li class="active mark">
<div class="drop-wrapper"><a href="#">Products</a> {{block type="core/template" category_id="3" name="category-products" template="additional/subcategories.phtml"}}</div>
</li>
<li class="mark">
<div class="drop-wrapper"><a href="#">Industries</a> {{block type="cms/block" block_id="industries-block"}}</div>
</li>
<li>
<div class="drop-wrapper"><a href="http://www.omni-inc.com/applications/" target="_blank">Application DB</a></div>
</li>
<li>
<div class="drop-wrapper"><a href="#">Support</a>
<div class="drop">
<ul>
<li><a href="{{store_url='warranty-registration'}}">Warranty Registration</a></li>
<li><a href="http://www.omni-inc.com/distributors/login.php">Distributor Login</a></li>
</ul>
</div>
</div>
</li>
<li>
<div class="drop-wrapper"><a href="{{store_url='about-us'}}">Corporate</a>
<div class="drop">
<ul>
<li><a href="{{store_url='about-us'}}">About Us</a></li>
<li><a href="{{store_url='our-history'}}">Our History</a></li>
<li><a href="{{store_url='distributor-locator'}}">Distributor Locator</a></li>
<li><a href="{{store_url='news'}}">Newsroom</a></li>
<li><a href="{{store_url='careers'}}">Careers</a></li>
<li><a href="{{store_url='contacts'}}">Contact Us</a></li>
</ul>
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


$installer->endSetup();