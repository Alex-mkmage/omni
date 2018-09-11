<?php
/*
 * Description:
 * - Update Get Help/Support block
 * - update header menu
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('omni_tip_disposables', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('omni_tip_disposables', 'identifier');
$content =<<<EOF
<p>
Omni Disposables Homogenizer Probes and Homogenization Containers were designed for researchers who are concerned about cross-contamination in critical laboratory samples. Plastic homogenizer tips and vessel will efficiently process as well traditional metal rotor-stator and blade assemblies so there is no sacrificing of performance.
</p>
EOF;

$staticBlock = array(
    'title' => 'Omni Tip Disposables',
    'identifier' => 'omni_tip_disposables',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('omni_tip_disposables');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('rotor_stator', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('rotor_stator', 'identifier');
$content =<<<EOF
<p>
High shear laboratory homogenizers are designed to process tough samples quickly and efficiently without compromising the sample. Faster homogenization times mean less chance of heat degradation to the sample. These homogenizer motors are available in hand held or stand mounted configurations with high speeds of up to 75,000 rpm. Homogenizers are a standard piece of equipment for any lab.<br/>Not sure which configuration will work best for your application? Contact our technical support team and we will help find the best homogenizer for your research.
</p>
EOF;

$staticBlock = array(
    'title' => 'Rotor Stator',
    'identifier' => 'rotor_stator',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('rotor_stator');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('dounce_glass_tissue_homogenizer', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('dounce_glass_tissue_homogenizer', 'identifier');
$content =<<<EOF
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
</p>
EOF;

$staticBlock = array(
    'title' => 'Dounce Glass Tissue Homogenizer',
    'identifier' => 'dounce_glass_tissue_homogenizer',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('dounce_glass_tissue_homogenizer');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('tenbroeck_glass_tissue_homogenizer', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('tenbroeck_glass_tissue_homogenizer', 'identifier');
$content =<<<EOF
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
</p>
EOF;

$staticBlock = array(
    'title' => 'Tenbroeck Glass Tissue Homogenizer',
    'identifier' => 'tenbroeck_glass_tissue_homogenizer',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('tenbroeck_glass_tissue_homogenizer');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('potter_elvehjem_tissue_homogenizer', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('potter_elvehjem_tissue_homogenizer', 'identifier');
$content =<<<EOF
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
</p>
EOF;

$staticBlock = array(
    'title' => 'Potter-Elvehjem Tissue Homogenizer',
    'identifier' => 'potter_elvehjem_tissue_homogenizer',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('potter_elvehjem_tissue_homogenizer');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

$cmsBlock = Mage::getModel('cms/block')->load('bioMasher_single_use_homogenizer', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('bioMasher_single_use_homogenizer', 'identifier');
$content =<<<EOF
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
</p>
EOF;

$staticBlock = array(
    'title' => 'BioMasher Single-Use Homogenizer',
    'identifier' => 'bioMasher_single_use_homogenizer',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('bioMasher_single_use_homogenizer');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}
$installer->endSetup();
