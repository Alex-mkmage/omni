<?php

class Ey_Applications_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getFilePath()
    {
        return Mage::getStoreConfig('ey_applications/file/file_location', Mage::app()->getStore());
    }

    public function getSeoPageTitle()
    {
        return Mage::getStoreConfig('ey_applications/seo/page_title', Mage::app()->getStore());
    }

    public function getSeoMetaKeywords()
    {
        return Mage::getStoreConfig('ey_applications/seo/meta_keyword', Mage::app()->getStore());
    }

    public function getSeoMetaDescription()
    {
        return Mage::getStoreConfig('ey_applications/seo/meta_description', Mage::app()->getStore());
    }

    public function getDownloadLimit()
    {
        return Mage::getStoreConfig('ey_applications/file/download_limit', Mage::app()->getStore());
    }

    public function getDownloadNotifyEmail()
    {
        return Mage::getStoreConfig('ey_applications/email/download_email', Mage::app()->getStore());
    }

    public function getDownloadNotifyEmailTemplate()
    {
        return Mage::getStoreConfig('ey_applications/email/download_template', Mage::app()->getStore());
    }

    public function isNotifyDownloadEmail()
    {
        return Mage::getStoreConfig('ey_applications/email/download_activate', Mage::app()->getStore());
    }

    /**
     * @return array
     */
    public function getExcludedSearchWords()
    {
        $words = Mage::getStoreConfig('ey_applications/application/excluded_search_word', Mage::app()->getStore());
        $words = explode(',', $words);
        foreach ($words as $key => $word){
            $words[$key] = strtolower(trim($word));
        }
        return $words;
    }
}