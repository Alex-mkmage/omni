<?php

class Ey_Applications_Helper_Api extends Mage_Core_Helper_Abstract
{
    public function getRefreshToken()
    {
        return Mage::getStoreConfig('ey_applications/api/refresh_token', Mage::app()->getStore());
    }

    public function getAppId()
    {
        return Mage::getStoreConfig('ey_applications/api/app_id', Mage::app()->getStore());
    }

    public function getAppSecret()
    {
        return Mage::getStoreConfig('ey_applications/api/app_secret', Mage::app()->getStore());
    }

    public function getFolderId()
    {
        return Mage::getStoreConfig('ey_applications/mendeley/folder_id', Mage::app()->getStore());
    }
}