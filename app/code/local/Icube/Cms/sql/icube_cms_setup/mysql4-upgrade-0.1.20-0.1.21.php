<?php

/*
 * Description:
 * - update header menu
 * - update industries menu block
 * - create industry subcategory static block
 */

$installer = $this;
$installer->startSetup();

try {
/*Genomics Page*/
$cmsBlock = Mage::getModel('cms/block')->load('genomics', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('genomics', 'identifier');
$content =<<<EOF
<h5><span style="font-size: medium;"><strong><img alt="" src="{{media url="wysiwyg/proteomicsimg.png"}}" /></strong></span></h5>
<p><span style="font-size: medium;"><strong>Title goes here</strong></span></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p>&nbsp;</p>
EOF;

$staticBlock = array(
    'title' => 'Genomics Page',
    'identifier' => 'genomics',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('genomics');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

/*Bioanalysis/DMPK*/
$cmsBlock = Mage::getModel('cms/block')->load('bioanalysis_dmpk', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('bioanalysis_dmpk', 'identifier');
$content =<<<EOF
<h5><span style="font-size: medium;"><strong><img alt="" src="{{media url="wysiwyg/proteomicsimg.png"}}" /></strong></span></h5>
<p><span style="font-size: medium;"><strong>Title goes here</strong></span></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p>&nbsp;</p>
EOF;

$staticBlock = array(
    'title' => 'Bioanalysis/DMPK Page',
    'identifier' => 'bioanalysis_dmpk',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('bioanalysis_dmpk');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

/*Method Development*/
$cmsBlock = Mage::getModel('cms/block')->load('method_development', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('method_development', 'identifier');
$content =<<<EOF
<h5><span style="font-size: medium;"><strong><img alt="" src="{{media url="wysiwyg/proteomicsimg.png"}}" /></strong></span></h5>
<p><span style="font-size: medium;"><strong>Title goes here</strong></span></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p>&nbsp;</p>
EOF;

$staticBlock = array(
    'title' => 'Method Development Page',
    'identifier' => 'method_development',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('method_development');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

/*Pesticides in Food*/
$cmsBlock = Mage::getModel('cms/block')->load('pesticides_food', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('pesticides_food', 'identifier');
$content =<<<EOF
<h5><span style="font-size: medium;"><strong><img alt="" src="{{media url="wysiwyg/proteomicsimg.png"}}" /></strong></span></h5>
<p><span style="font-size: medium;"><strong>Title goes here</strong></span></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p>&nbsp;</p>
EOF;

$staticBlock = array(
    'title' => 'Pesticides in Food Page',
    'identifier' => 'pesticides_food',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('pesticides_food');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

/*Food Safety/Quality*/
$cmsBlock = Mage::getModel('cms/block')->load('food_safety_quality', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('food_safety_quality', 'identifier');
$content =<<<EOF
<h5><span style="font-size: medium;"><strong><img alt="" src="{{media url="wysiwyg/proteomicsimg.png"}}" /></strong></span></h5>
<p><span style="font-size: medium;"><strong>Title goes here</strong></span></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p>&nbsp;</p>
EOF;

$staticBlock = array(
    'title' => 'Food Safety/Quality Page',
    'identifier' => 'food_safety_quality',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('food_safety_quality');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

/*Forensic Toxicology*/
$cmsBlock = Mage::getModel('cms/block')->load('forensic_toxicology', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('forensic_toxicology', 'identifier');
$content =<<<EOF
<h5><span style="font-size: medium;"><strong><img alt="" src="{{media url="wysiwyg/proteomicsimg.png"}}" /></strong></span></h5>
<p><span style="font-size: medium;"><strong>Title goes here</strong></span></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p>&nbsp;</p>
EOF;

$staticBlock = array(
    'title' => 'Forensic Toxicology Page',
    'identifier' => 'forensic_toxicology',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('forensic_toxicology');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

/*Soil*/
$cmsBlock = Mage::getModel('cms/block')->load('soil', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('soil', 'identifier');
$content =<<<EOF
<h5><span style="font-size: medium;"><strong><img alt="" src="{{media url="wysiwyg/proteomicsimg.png"}}" /></strong></span></h5>
<p><span style="font-size: medium;"><strong>Title goes here</strong></span></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p>&nbsp;</p>
EOF;

$staticBlock = array(
    'title' => 'Soil Page',
    'identifier' => 'soil',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('soil');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

/*Waste Water*/
$cmsBlock = Mage::getModel('cms/block')->load('waste_water', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('waste_water', 'identifier');
$content =<<<EOF
<h5><span style="font-size: medium;"><strong><img alt="" src="{{media url="wysiwyg/proteomicsimg.png"}}" /></strong></span></h5>
<p><span style="font-size: medium;"><strong>Title goes here</strong></span></p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p>&nbsp;</p>
EOF;

$staticBlock = array(
    'title' => 'Waste Water Page',
    'identifier' => 'waste_water',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('waste_water');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}


/*header menu*/
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
<div class="drop-wrapper"><a href="#">Industries</a> {{block type="core/template" category_id="464" name="category-products" template="additional/subcategories.phtml"}}</div>
</li>
<li>
<div class="drop-wrapper"><a href="http://www.omni-inc.com/applications/" target="_blank">Application DB</a></div>
</li>
<li class="mark support">
<div class="drop-wrapper"><a href="{{store_url='about-us'}}">Support</a>
<div class="drop">
<div class="products-section">
<ul class="megamenu">
<li><a class="box" href="{{store_url='warranty-registration'}}">Warranty Registration</a></li>
<li><a class="box" href="http://www.omni-inc.com/distributors/login.php">Distributor Login</a></li>
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
