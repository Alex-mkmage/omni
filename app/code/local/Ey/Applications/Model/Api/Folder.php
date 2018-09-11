<?php

class Ey_Applications_Model_Api_Folder extends Ey_Applications_Model_Api_Document
{
    /**
     * @var array
     */
    protected $_folders;

    public function _construct()
    {
        parent::_construct();
        $this->_folders = $this->_getSession('current_app_folders')?$this->_getSession('current_app_folders'):array();
    }

    /**
     * @return array
     */
    public function getFolders($parentId = null)
    {
        $parentId = $parentId ? $parentId : $this->_folderId;
        if(array_key_exists($parentId, $this->_folders)){
            $this->_folders[$parentId];
        }
        $curl = new Varien_Http_Adapter_Curl;
        $headers = array(
            'Authorization: Bearer ' . $this->_getAccessToken()
        );
        $curl->write(Zend_Http_Client::GET, "https://api.mendeley.com/folders?limit=500", '1.1', $headers);
        $data = $curl->read();
        $data = $this->extractData($data);
        $data = Mage::helper('core')->jsonDecode($data);
        if(is_array($data) && count($data) > 0){
            $this->_folders[$parentId] = array();
            foreach ($data as $folder){
                if(
                    (isset($folder['id']) && $folder['id'] == $parentId) ||
                    (isset( $folder['parent_id']) && $folder['parent_id'] == $parentId)
                ){
                    $this->_folders[$parentId][] = $folder['id'];
                }
            }
            if(count($this->_folders[$parentId]) > 0){
                $this->_setSession('current_app_folders', $this->_folders);
            }
        }
        $curl->close();

        return $parentId?$this->_folders[$parentId]:$this->_folders;
    }

    /**
     * @return array
     */
    public function getAllFolders()
    {
        return $this->_folders;
    }
}