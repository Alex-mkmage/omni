<?php
/*
 * Description:
 * - Update Get Help/Support block
 * - update header menu
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('careers', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('careers', 'identifier');
$content =<<<EOF
<h4><img alt="" src="{{media url="wysiwyg/Careers-page.jpg"}}" /></h4>
<h4>&nbsp;</h4>
<h4><strong>Join Our Team!</strong></h4>
<p style="text-align: left;"><span style="font-family: terminal, monaco; font-size: medium;">Omni International offers a wide variety of positions for all types of hard working people.&nbsp; Whether you're in school, have just graduated, or have been in the workforce for many years; Omni has many opportunities to bolster your professional development.</span></p>
<p style="text-align: left;"><span style="font-family: terminal, monaco; font-size: medium;">Because we're committed to constant improvement and innovation, we design and manufacture all of our products right here in Georgia.&nbsp; Customer satisfaction is our top priority and we're dedicated to providing a wide variety of high quality homogenizer products to support any customer need.</span></p>
<p style="text-align: left;"><span style="font-family: terminal, monaco; font-size: medium;">Omni is as committed to our employees as we are our customers.&nbsp; If you're a driven, like minded individual and think you have what it takes to join the Omni team, we're interested in hearing from you.&nbsp;</span></p>
EOF;

$staticBlock = array(
    'title' => 'Careers',
    'identifier' => 'careers',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('careers');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}



} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}
$installer->endSetup();
