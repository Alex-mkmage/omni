<?php

class Ey_Applications_Model_Api_File extends Ey_Applications_Model_Api
{
    /**
     * @var array
     */
    protected $_files;

    public function _construct()
    {
        parent::_construct();
        $this->_files = $this->_getSession('current_app_files')?$this->_getSession('current_app_files'):array();
    }

    /**
     * @param string $documentId
     * @return array
     */
    public function getFiles($documentId)
    {
        if(array_key_exists($documentId, $this->_files)){
            return $this->_files[$documentId];
        }
        $curl = new Varien_Http_Adapter_Curl;
        $headers = array(
            'Authorization: Bearer ' . $this->_getAccessToken()
        );
        $requestUrl = "https://api.mendeley.com/files?document_id={$documentId}";
        $curl->write(Zend_Http_Client::GET, $requestUrl, '1.1', $headers);
        $data = $curl->read();
        $data = $this->extractData($data);
        $data = Mage::helper('core')->jsonDecode($data);
        if(is_array($data) && count($data) > 0){
            $this->_files[$documentId] = $data;
            $this->_setSession('current_app_files', $this->_files);
            return $data;
        }
        $curl->close();

        return array();
    }

    /**
     * @param null $folderId
     * @return array|mixed
     */
    public function getAllFiles()
    {
        return $this->_files;
    }

    /**
     * @param $id
     * @return string
     */
    public function getFileLink($id)
    {
        $curl = new Varien_Http_Adapter_Curl;
        $headers = array(
            'Authorization: Bearer ' . $this->_getAccessToken()
        );
        $requestUrl = "https://api.mendeley.com/files/{$id}";
        $curl->write(Zend_Http_Client::GET, $requestUrl, '1.1', $headers);
        $data = $curl->read();
        $data = $this->extractData($data, "\r\n", 2);
        $data = $this->extractData($data, "Location:");
        $curl->close();

        return $data;
    }
}