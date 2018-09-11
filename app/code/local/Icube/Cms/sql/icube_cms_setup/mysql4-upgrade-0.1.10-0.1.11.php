<?php

/*
 * Description:
 * - update header menu
 * - update industries menu block
 */

$installer = $this;
$installer->startSetup();

try {
$cmsBlock = Mage::getModel('cms/block')->load('header-chat', 'identifier')->delete();
$cmsBlock = Mage::getModel('cms/block')->load('header-chat', 'identifier');
$content =<<<EOF
<div class="contacts-box"><a class="btn-chat" onclick="javascript:window.open('http://server.iad.liveperson.net/hc/25366500/?cmd=file&amp;file=visitorWantsToChat&amp;site=25366500&amp;imageUrl=http://server.iad.liveperson.net/hcp/Gallery/ChatButton-Gallery/English/General/1a&amp;referrer='+escape(document.location),'chat25366500','width=472,height=320,resizable=yes');return false;" href="http://server.iad.liveperson.net/hc/25366500/?cmd=file&amp;file=visitorWantsToChat&amp;site=25366500&amp;byhref=1&amp;imageUrl=http://server.iad.liveperson.net/hcp/Gallery/ChatButton-Gallery/English/General/1a" target="chat25366500">Chat with a Tech Specialist</a>
<div class="phone"><em>&nbsp;</em></div>
</div>
EOF;

$staticBlock = array(
    'title' => 'Header Chat & Contact Block',
    'identifier' => 'header-chat',
    'content' => $content,
    'is_active' => 1,
    'stores' => array(0)
);

$staticBlockModel = Mage::getModel('cms/block')->load('header-chat');

if($id = $staticBlockModel->getBlockId()){
    $staticBlockModel->setData($staticBlock)->setBlockId($id)->save();
}else{
    $staticBlockModel->setData($staticBlock)->save();
}


} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}



$installer->endSetup();
