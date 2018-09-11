<?php

$installer = $this;
$installer->startSetup();

try {

$cmsPage = Mage::getModel('cms/page')->load('home', 'identifier')->delete();
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
		{{revslider alias="home-slider"}}
		<ul>
			<li class="featured icon-a sample"><a class="active" href="{{config path='web/secure/base_url'}}bead-mill-cell-lysing.html">{{block type="cms/block" block_id="bead-mill-menu"}}</a></li>
			<li class="featured icon-b product"><a href="{{config path='web/secure/base_url'}}high-shear-lab-homogenizers.html">{{block type="cms/block" block_id="rotor-strator-menu"}}</a></li>
			<li class="featured icon-c help"><a href="{{config path='web/secure/base_url'}}multi-sample-lab-homogenizers.html">{{block type="cms/block" block_id="automation-menu"}}</a></li>
			<li class="featured icon-d help"><a href="{{config path='web/secure/base_url'}}ultrasonic-cell-disruptors.html">{{block type="cms/block" block_id="ultrasonic-menu"}}</a></li>
		</ul>
	</div>
</nav>
<div class="container">
	<div class="featured-title-bar">
		<h2>Featured</h2>
	</div>
	{{block type="cms/block" block_id="home-content"}}</div>
EOF;

$layoutUpdateXml = <<<EOT
<!--<reference name="content">
<block type="catalog/product_new" name="home.catalog.product.new" alias="product_new" template="catalog/product/new.phtml" after="cms_page"><action method="addPriceBlockType"><type>bundle</type><block>bundle/catalog_product_price</block><template>bundle/catalog/product/price.phtml</template></action></block>
<block type="reports/product_viewed" name="home.reports.product.viewed" alias="product_viewed" template="reports/home_product_viewed.phtml" after="product_new"><action method="addPriceBlockType"><type>bundle</type><block>bundle/catalog_product_price</block><template>bundle/catalog/product/price.phtml</template></action></block>
<block type="reports/product_compared" name="home.reports.product.compared" template="reports/home_product_compared.phtml" after="product_viewed"><action method="addPriceBlockType"><type>bundle</type><block>bundle/catalog_product_price</block><template>bundle/catalog/product/price.phtml</template></action></block>
</reference><reference name="right">
<action method="unsetChild"><alias>right.reports.product.viewed</alias></action>
<action method="unsetChild"><alias>right.reports.product.compared</alias></action>
</reference>-->
EOT;

if(!$cmsPage->getId()){
    $cmsPage->setTitle('Home Page');
}

$cmsPage->setStores(array(0))
    ->setIdentifier('home')
    ->setContentHeading('Home Page')
    ->setContent($pageContent)
    ->setIsActive(1)
    ->setRootTemplate('one_column')
    ->save();

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}

$installer->endSetup();