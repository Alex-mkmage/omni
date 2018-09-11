<?php

class Ey_Applications_Model_Api_Document extends Ey_Applications_Model_Api_File
{
    /**
     * @var array
     */
    protected $_documents;

    public function _construct()
    {
        parent::_construct();
        $this->_documents = $this->_getSession('current_app_documents')?$this->_getSession('current_app_documents'):array();
    }

    /**
     * @return array
     */
    public function getDocumentListWithInFolder($folderId)
    {
        if(array_key_exists($folderId, $this->_documents)){
            return $this->_documents[$folderId];
        }
        $curl = new Varien_Http_Adapter_Curl;
        $headers = array(
            'Authorization: Bearer ' . $this->_getAccessToken()
        );
        $requestUrl = "https://api.mendeley.com/folders/{$folderId}/documents?limit=500";
        $curl->write(Zend_Http_Client::GET, $requestUrl, '1.1', $headers);
        $data = $curl->read();
        $data = $this->extractData($data);
        $data = Mage::helper('core')->jsonDecode($data);
        if(is_array($data) && count($data) > 0){
            $this->_documents[$folderId] = $data;
            $this->_setSession('current_app_documents', $this->_documents);
            return $data;
        }
        $curl->close();

        return array();
    }

    /**
     * @param null $folderId
     * @return array|mixed
     */
    public function getDocuments($folderId = null)
    {
        return $folderId?$this->_documents[$folderId]:$this->_documents;
    }

    /**
     * @param string $id
     * @return array
     */
    public function getDocument($id)
    {
        $curl = new Varien_Http_Adapter_Curl;
        $headers = array(
            'Authorization: Bearer ' . $this->_getAccessToken()
        );
        $requestUrl = "https://api.mendeley.com/documents/{$id}?view=all";
        $curl->write(Zend_Http_Client::GET, $requestUrl, '1.1', $headers);
        $data = $curl->read();
        $data = $this->extractData($data);
        $data = Mage::helper('core')->jsonDecode($data);
        if(is_array($data) && count($data) > 0){
            return $data;
        }
        $curl->close();

        return array();
    }
}