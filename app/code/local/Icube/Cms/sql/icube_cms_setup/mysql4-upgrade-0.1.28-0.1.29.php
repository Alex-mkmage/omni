<?php
/*
 * Description:
 * - Contact header
 * - Remove pages and static blocks that are not relevant anymore
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('contact_header', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('contact_header', 'identifier');
$content =<<<EOF
<p>
<img src="{{skin url="images/banner-contacts.png"}}" />
</p>
<p>
<strong>Do you have a question that isn't answered on our site? Use the form below or the information on the right to get in touch with us.</strong>
</p>
EOF;

$staticBlock = array(
    'title' => 'Contact Header',
    'identifier' => 'contact_header',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('contact_header');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}

$installer->endSetup();
