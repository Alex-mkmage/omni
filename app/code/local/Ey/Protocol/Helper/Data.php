<?php

class Ey_Protocol_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getFilePath()
    {
        return Mage::getStoreConfig('ey_protocol/file/file_location', Mage::app()->getStore());
    }

    public function getSeoPageTitle()
    {
        return Mage::getStoreConfig('ey_protocol/seo/page_title', Mage::app()->getStore());
    }

    public function getSeoMetaKeywords()
    {
        return Mage::getStoreConfig('ey_protocol/seo/meta_keyword', Mage::app()->getStore());
    }

    public function getSeoMetaDescription()
    {
        return Mage::getStoreConfig('ey_protocol/seo/meta_description', Mage::app()->getStore());
    }

    public function getDownloadLimit()
    {
        return Mage::getStoreConfig('ey_protocol/file/download_limit', Mage::app()->getStore());
    }

    public function getDownloadNotifyEmail()
    {
        return Mage::getStoreConfig('ey_protocol/email/download_email', Mage::app()->getStore());
    }

    public function getDownloadNotifyEmailTemplate()
    {
        return Mage::getStoreConfig('ey_protocol/email/download_template', Mage::app()->getStore());
    }

    public function isNotifyDownloadEmail()
    {
        return Mage::getStoreConfig('ey_protocol/email/download_activate', Mage::app()->getStore());
    }

    /**
     * @return array
     */
    public function getExcludedSearchWords()
    {
        $words = Mage::getStoreConfig('ey_protocol/application/excluded_search_word', Mage::app()->getStore());
        $words = explode(',', $words);
        foreach ($words as $key => $word){
            $words[$key] = strtolower(trim($word));
        }
        return $words;
    }

    /**
     * @param $file
     * @return array|bool
     */
    public function getCsvData($file){
        $csvObject = new Varien_File_Csv();
        try {
            $data = $csvObject->getData($file);
            $headers = $data[0];
            unset($data[0]);
            foreach ($data as $row_i => $row){
                foreach ($headers as $column_i => $header){
                    $data[$row_i][$header] = $row[$column_i];
                    unset($data[$row_i][$column_i]);
                }
            }
            return $data;
        } catch (Exception $e) {
            Mage::log('Csv: ' . $file . ' - getCsvData() error - '. $e->getMessage(), Zend_Log::ERR, 'exception.log', true);
            return false;
        }

    }
}