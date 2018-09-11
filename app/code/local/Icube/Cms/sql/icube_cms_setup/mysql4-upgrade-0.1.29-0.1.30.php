<?php

/*
 * Description:
 * - Remove unused static blocks and pages
 */

$installer = $this;
$installer->startSetup();

try {
    // Remove CMS Blocks
    Mage::getModel('cms/block')->load('home-choose-product-type', 'identifier')->delete();
    Mage::getModel('cms/block')->load('home-help-me-shoose', 'identifier')->delete();
    Mage::getModel('cms/block')->load('home-choose-sample-type', 'identifier')->delete();
    Mage::getModel('cms/block')->load('footer-dynamics', 'identifier')->delete();
    Mage::getModel('cms/block')->load('technical-support', 'identifier')->delete();
    Mage::getModel('cms/block')->load('videos', 'identifier')->delete();
    Mage::getModel('cms/block')->load('application', 'identifier')->delete();
    Mage::getModel('cms/block')->load('training', 'identifier')->delete();
    Mage::getModel('cms/block')->load('image-downloads', 'identifier')->delete();
    Mage::getModel('cms/block')->load('warranty-registration', 'identifier')->delete();
    Mage::getModel('cms/block')->load('distributor', 'identifier')->delete();
    Mage::getModel('cms/block')->load('featured-life-science', 'identifier')->delete();
    Mage::getModel('cms/block')->load('featured-pharmaceutical', 'identifier')->delete();
    Mage::getModel('cms/block')->load('featured-food', 'identifier')->delete();
    Mage::getModel('cms/block')->load('featured-forensic', 'identifier')->delete();
    Mage::getModel('cms/block')->load('parmaceutica_life_science', 'identifier')->delete();
    Mage::getModel('cms/block')->load('home-carusel', 'identifier')->delete();
    Mage::getModel('cms/block')->load('industries-block', 'identifier')->delete();

    // Remove CMS Pages
    Mage::getModel('cms/page')->load('application-note', 'identifier')->delete();
    Mage::getModel('cms/page')->load('distributor-application', 'identifier')->delete();
    Mage::getModel('cms/page')->load('distributor-brochures', 'identifier')->delete();
    Mage::getModel('cms/page')->load('distributor-manuals', 'identifier')->delete();
    Mage::getModel('cms/page')->load('distributor-posters', 'identifier')->delete();
    Mage::getModel('cms/page')->load('distributor-training', 'identifier')->delete();
    Mage::getModel('cms/page')->load('food', 'identifier')->delete();
    Mage::getModel('cms/page')->load('forensic', 'identifier')->delete();
    Mage::getModel('cms/page')->load('life-science', 'identifier')->delete();
    Mage::getModel('cms/page')->load('life-science-prodio', 'identifier')->delete();
    Mage::getModel('cms/page')->load('newsletter', 'identifier')->delete();
    Mage::getModel('cms/page')->load('pharmaceutical', 'identifier')->delete();
    Mage::getModel('cms/page')->load('pharmaceutical-dmpk', 'identifier')->delete();
    Mage::getModel('cms/page')->load('pricing-requeat', 'identifier')->delete();
    Mage::getModel('cms/page')->load('product-compliance-center', 'identifier')->delete();
    Mage::getModel('cms/page')->load('publications', 'identifier')->delete();
    Mage::getModel('cms/page')->load('side_bar', 'identifier')->delete();
    Mage::getModel('cms/page')->load('upport-library', 'identifier')->delete();
    Mage::getModel('cms/page')->load('trade-in-program', 'identifier')->delete();
    Mage::getModel('cms/page')->load('videos', 'identifier')->delete();
} catch (Exception $e) {
    throw new Exception('REMOVING CMS PAGES & BLOCKS FAILS. ' . $e->getMessage());
}

$installer->endSetup();
