<?php

class Ey_Applications_Model_Api extends Mage_Core_Model_Abstract
{
    const MENDELEY_TOKEN_URL = "https://api.mendeley.com/oauth/token";

    /**
     * @var string
     */
    protected $_folderId;

    /**
     * @param string $id
     */
    public function setMainFolderId($id)
    {
        $this->_folderId = $id;
    }

    /**
     * @return string
     */
    public function getMainFolderId()
    {
        return $this->_folderId;
    }

    /**
     * @param string $name
     * @param array $value
     * @param string $type
     */
    protected function _setSession($name, $value, $type = 'customer/session')
    {
        Mage::getSingleton($type)->setData($name, $value);
    }

    /**
     * @param string $name
     * @param string $type
     * @return array
     */
    protected function _getSession($name , $type = 'customer/session')
    {
        return Mage::getSingleton($type)->getData($name);
    }

    /**
     * Refresh Token
     *
     * @return string
     */
    protected function _getAccessToken()
    {
        /** @var Ey_Applications_Helper_Api $helper */
        $helper = Mage::helper('ey_applications/api');

        $curl = new Varien_Http_Adapter_Curl;
        $appId = $helper->getAppId();
        $appSecret = $helper->getAppSecret();
        $headers = array(
            'Authorization: Basic ' . base64_encode($appId.':'.$appSecret),
            'grant_type: refresh_token'
        );
        $body = 'grant_type=refresh_token&refresh_token='.$helper->getRefreshToken();
        $curl->write(Zend_Http_Client::POST, self::MENDELEY_TOKEN_URL, '1.1', $headers, $body);
        $data = $curl->read();
        if ($data === false) {
            return false;
        }
        $data = $this->extractData($data);
        $data = Mage::helper('core')->jsonDecode($data);
        $curl->close();

        if(array_key_exists('access_token', $data)){
            return $data['access_token'];
        }
        return '';
    }

    /**
     * @param $json
     * @param string $divider
     * @param int $position
     * @return array|null|string
     */
    public function extractData($json, $divider = "\r\n\r\n", $position = 1)
    {
        $data = explode($divider, $json);
        $data = array_key_exists($position, $data) ? trim($data[$position]):null;

        return $data;
    }
}