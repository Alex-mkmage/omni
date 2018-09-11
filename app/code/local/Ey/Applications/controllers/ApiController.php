<?php

class Ey_Applications_ApiController extends Mage_Core_Controller_Front_Action
{
    const MENDELEY_TOKEN_URL = "https://api.mendeley.com/oauth/token";

    public function indexAction()
    {
        /** @var Ey_Applications_Model_Api_Folder $api */
        $api = Mage::getSingleton('ey_applications/api_folder');
        $mainFolderId = Mage::helper('ey_applications/api')->getFolderId();
        $api->setMainFolderId($mainFolderId);
        if($folders = $api->getFolders()){
            $documents = array();
            if(is_array($folders)){
                foreach ($folders as $folder){
                    if(count($folder) > 0){
                        $documentsWithInFolder = $api->getDocumentListWithInFolder($folder);
                        $documents[$folder] = $documentsWithInFolder;
                    } else{
                        $documentsWithInFolder = $api->getDocumentListWithInFolder($mainFolderId);
                        $documents[$mainFolderId] = $documentsWithInFolder;
                    }
                }
            } else{
                $documentsWithInFolder = $api->getDocumentListWithInFolder($folders);
                $documents[$folders] = $documentsWithInFolder;
            }

        }

        return '';
    }

    public function documentAction()
    {
        /** @var Ey_Applications_Model_Api_Document $model */
        $model = Mage::getSingleton('ey_applications/api_document');

        $session = Mage::getSingleton('customer/session')->getData('current_app_documents');
        $apps = Mage::getModel('ey_applications/application')->getCollection();
        foreach ($session as $folder_id => $folder){
            foreach ($folder as $document){
                if(!is_array($document)){
                    continue;
                }
                try{
                    $doc = $model->getDocument($document['id']);
                    foreach($apps as $app){
                        if(
                            $app->getApplicationId() == $doc['id'] &&
                            isset($doc['websites'][0]) &&
                            $doc['websites'][0] != ''
                        ){
                            $app->setWebsite($doc['websites'][0])->save();
                            echo $app->getApplicationId().'\n';
                        }
                    }
                    /*
                    $app = Mage::getModel('ey_applications/application')
                        ->setName($doc['title'])
                        ->setDescription($doc['title'])
                        ->setType($doc['type'])
                        ->setYear($doc['year'])
                        ->setApplicationId($document['id'])
                        ->setFolderId($folder_id)
                        ->setVisibility(2)
                        ->setSortOrder(0)
                        ->setSampleType(2);
                    if(array_key_exists('websites', $doc)){
                        $url = isset($doc['websites'][0])?$doc['websites'][0]:'';
                        $app->setWebsite($url);
                    }
                    if(array_key_exists('tags', $doc)){
                        $tags = implode(',', $doc['tags']);
                        $app->setTag($tags);
                    }
                    if(array_key_exists('authors', $doc)){
                        $authors = array();
                        foreach ($doc['authors'] as $author){
                            $author = implode(' ', $author);
                            $authors[] = $author;
                        }
                        $authors = implode(', ', $authors);
                        $app->setAuthor($authors);
                    }
                    $app->save();
                    */
                } catch (Exception $e) {
                    Mage::logException($e);
                    var_dump($e->getMessage());
                    exit();
                }
            }
        }
    }

    public function removeAction()
    {
        $items = Mage::getModel('ey_applications/application')
            ->getCollection()
            ->addFieldToFilter('entity_id', array('gt'=>0));
        foreach ($items as $item){
            $item->delete();
        }
    }

    public function fileAction()
    {
        /** @var Ey_Applications_Model_Api_Document $model */
        $model = Mage::getSingleton('ey_applications/api_file');
        $session = Mage::getSingleton('customer/session')->getData('current_app_documents');
        foreach ($session as $folder){
            foreach ($folder as $document){
                if(!is_array($document)){
                    continue;
                }
                $files = $model->getFiles($document['id']);
                foreach ($files as $file){
                    try{
                        /*
                        Mage::getModel('ey_applications/file')
                            ->setName($file['file_name'])
                            ->setFileId($file['id'])
                            ->setMimeType($file['mime_type'])
                            ->setFileHash($file['filehash'])
                            ->setFileSize($file['size'])
                            ->save();
                        $path = $model->getFileLink($file['id']);
                        $this->_downloadFile($path, $file['file_name']);
                        */
                    } catch (Exception $e) {
                        Mage::logException($e);
                        var_dump($e->getMessage());
                        exit();
                    }
                }
            }
        }
    }

    public function filerelationAction()
    {
        $session = Mage::getSingleton('customer/session')->getData('current_app_files');
        $documentIds = array();
        $fileIds = array();
        foreach ($session as $documentId => $file){
            if(!is_array($file)){
                continue;
            }
            $documentIds[] = $documentId;
            foreach ($file as $item){
                $fileIds[] = $item['id'];
            }
        }
        $documents = Mage::getModel('ey_applications/application')
            ->getCollection()
            ->addFieldToFilter('application_id', array('in' => $documentIds));
        $toArray = array();
        foreach ($documents as $document){
            $toArray[$document->getApplicationId()] = $document->getId();
        }
        $files = Mage::getModel('ey_applications/file')
            ->getCollection()
            ->addFieldToFilter('file_id', array('in' => $fileIds));
        $toArray2 = array();
        foreach ($files as $file){
            $toArray2[$file->getFileId()] = $file->getId();
        }
        foreach ($session as $documentId => $file){
            if(!is_array($file)){
                continue;
            }
            foreach ($file as $item){
                try{
                    $appid = array_key_exists($documentId, $toArray)?$toArray[$documentId]:'';
                    $fileid = array_key_exists($item['id'], $toArray2)?$toArray2[$item['id']]:'';
                    Mage::getModel('ey_applications/fileapp')
                        ->setApplicationId($appid)
                        ->setFileId($fileid)
                        ->save();
                } catch (Exception $e) {
                    Mage::logException($e);
                    var_dump($e->getMessage());
                    exit();
                }
            }
        }
    }

    protected function _downloadFile($url, $name)
    {
        $path = '/vagrant/webroot/media/pdf/'.$name;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        file_put_contents($path, $data);
    }
    
}