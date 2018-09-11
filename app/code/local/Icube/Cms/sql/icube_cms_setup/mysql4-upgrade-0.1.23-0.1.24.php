<?php
/*
 * Description:
 * - Update Get Help/Support block
 * - update header menu
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('accessories_replacement_parts', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('accessories_replacement_parts', 'identifier');
$content =<<<EOF
<p>Accessories Replacement Parts<br/>
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
</p>
EOF;

$staticBlock = array(
    'title' => 'Accessories Replacement Parts',
    'identifier' => 'accessories_replacement_parts',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('accessories_replacement_parts');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}
$installer->endSetup();
