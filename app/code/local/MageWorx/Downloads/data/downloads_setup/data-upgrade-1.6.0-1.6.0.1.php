<?php
//set category_text in existing files
$files = Mage::getModel('downloads/files')->getCollection();
foreach($files as $file) {
    $filesCatIds = explode(',',$file->getCategoryId());
    $filesCatText = Mage::helper('downloads')->getFileCategoriesText($filesCatIds);
    $file->setCategoryText($filesCatText)
        ->save();
}