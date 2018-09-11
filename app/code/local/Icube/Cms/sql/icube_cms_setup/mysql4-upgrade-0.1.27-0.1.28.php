<?php
/*
 * Description:
 * - contact info sidebar
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('contact_info', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('contact_info', 'identifier');
$content =<<<EOF
<div class="sidebar-section contact-info">
<h2>Corporate Office</h2>
<p><strong>Address:</strong> 935-C Cobb Place Blvd. NW Kennesaw, GA 30144 United States</p>
<p><strong>Phone:</strong> 770-421-0058</p>
<p><strong>Email:</strong> sales@omni-inc.com</p>
<p><strong>Fax:</strong> 770-421-0206</p>
<p><strong>Toll Free:</strong> 1-800-776-4431</p>
</div>
EOF;

$staticBlock = array(
    'title' => 'Contact Info',
    'identifier' => 'contact_info',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('contact_info');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}

$installer->endSetup();
