<?php

class Ey_Protocol_Model_Application extends Mage_Core_Model_Abstract
{
    const VISIBILITY_HIDDEN = '0';
    const VISIBILITY_DIRECTORY = '1';
    const VISIBILITY_RESTRICT = '2';
    
    const BOOLEAN_NO = '0';
    const BOOLEAN_YES = '1';

    protected $_eventPrefix = 'application';
    public $eventId = 'application_id';

    /**
     * Article's URL
     * @var null
     */
    protected $_url = null;

    protected function _construct()
    {
        $this->_init('ey_protocol/application');
    }

    public function getAvailableVisibilies()
    {
        return array(
            self::VISIBILITY_HIDDEN => Mage::helper('ey_protocol')->__('Hidden'),
            self::VISIBILITY_DIRECTORY => Mage::helper('ey_protocol')->__('Visible in Directory'),
            self::VISIBILITY_RESTRICT => Mage::helper('ey_protocol')->__('Restrict')
        );
    }

    public function getVisibilityByName($name)
    {
        $visibilities = array(
            'hidden' => self::VISIBILITY_HIDDEN,
            'visible' => self::VISIBILITY_DIRECTORY,
            'restrict' => self::VISIBILITY_RESTRICT
        );

        return $visibilities[$name];
    }

    public function getBoolean()
    {
        return array(
            self::BOOLEAN_NO => Mage::helper('ey_protocol')->__('No'),
            self::BOOLEAN_YES => Mage::helper('ey_protocol')->__('Yes'),
        );
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();

        $this->_updateTimestamps();

        return $this;
    }

    protected function _afterSave()
    {
        parent::_afterSave();

        $postData = $this->getData();
        $postData[$this->eventId] = $this->getId();
        $this->_saveSampleType($postData);
        $this->_saveProductUsed($postData);
        $this->_saveTag($postData);
        $this->_saveFile($postData);

        return $this;
    }

    /**
     * @param string $type
     * @param string $id
     */
    protected function _deleteItem($type, $id)
    {
        try{
            Mage::getModel($type)->load($id)->delete();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * @param array $data
     */
    protected function _saveSampleType($data)
    {
        /** @var Ey_Protocol_Model_Sampletype $typeSingleton */
        $typeSingleton = Mage::getSingleton('ey_protocol/sampletype');
        $typeId = $typeSingleton->getEventId();
        /** @var Ey_Protocol_Model_Application $appSingleton */
        $appSingleton = Mage::getSingleton('ey_protocol/application');
        $appEventId = $appSingleton->getEventId();
        if(array_key_exists($typeId, $data)){
            $sampleType = $data[$typeId];
            if($sampleType != ''){
                try{
                    $currentSampleTypes = Mage::getModel('ey_protocol/type')
                        ->getCollection()
                        ->addFieldToFilter('application_id', array('eq' => $data[$appEventId]));
                    if($currentSampleTypes->getSize()){
                        foreach ($currentSampleTypes as $currentSampleType){
                            $currentSampleType->setSampletypeId($sampleType)
                                ->save();
                        }
                    } else{
                        Mage::getModel('ey_protocol/type')
                            ->setSampletypeId($sampleType)
                            ->setApplicationId($data[$appEventId])
                            ->save();
                    }
                } catch (Exception $e) {
                    Mage::logException($e);
                }
            }
        }
    }

    /**
     * @param array $data
     */
    protected function _saveProductUsed($data)
    {
        /** @var Ey_Protocol_Model_Product $productSingleton */
        $productSingleton = Mage::getSingleton('ey_protocol/product');
        $productId = $productSingleton->getEventId();
        /** @var Ey_Protocol_Model_Application $appSingleton */
        $appSingleton = Mage::getSingleton('ey_protocol/application');
        $appEventId = $appSingleton->getEventId();
        if(array_key_exists($productId, $data)){
            $productSkus = explode(',', $data[$productId]);
            if(is_array($productSkus) && count($productSkus) > 0){
                $products = Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToFilter('sku', array('in' => $productSkus));
                $productIds = array();
                if($products->getSize()){
                    foreach ($products as $product){
                        $productIds[$product->getSku()] = $product->getId();
                    }
                }
                if(count($productIds) > 0){
                    $currentProducts = Mage::getModel('ey_protocol/product')
                        ->getCollection()
                        ->addFieldToFilter('application_id', array('eq' => $data[$appEventId]));
                    if($currentProducts->getSize()){
                        $count = 0;
                        foreach ($currentProducts as $sku => $currentProduct){
                            if(!array_key_exists($currentProduct->getSku(), $productIds)){
                                $this->_deleteItem('ey_protocol/product', $currentProduct->getId());
                            } else{
                                unset($productIds[$currentProduct->getSku()]);
                                $currentProduct->setSku($currentProduct->getSku())->save();
                            }
                            $count++;
                        }
                    }
                    if(count($productIds) > 0){
                        foreach ($productIds as $sku => $productId){
                            try{
                                Mage::getModel('ey_protocol/product')
                                    ->setProductId($productId)
                                    ->setSku($sku)
                                    ->setApplicationId($data[$appEventId])
                                    ->save();
                            } catch (Exception $e) {
                                Mage::logException($e);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param array $data
     */
    protected function _saveTag($data)
    {
        /** @var Ey_Protocol_Model_Tag $tagSingleton */
        $tagSingleton = Mage::getSingleton('ey_protocol/tag');
        $tagId = $tagSingleton->getEventId();
        /** @var Ey_Protocol_Model_Application $appSingleton */
        $appSingleton = Mage::getSingleton('ey_protocol/application');
        $appEventId = $appSingleton->getEventId();
        if(array_key_exists($tagId, $data) && count($data[$tagId]) > 0){
            $tags = explode(',', $data[$tagId]);
            if(is_array($tags) && count($tags) > 0){
                $currentTags = Mage::getModel('ey_protocol/tag')
                    ->getCollection()
                    ->addFieldToFilter('application_id', array('eq' => $data[$appEventId]));
                if($currentTags->getSize()){
                    $count = 0;
                    foreach ($currentTags as $currentTag){
                        if(!array_key_exists($currentTag->getName(), $tags)){
                            $this->_deleteItem('ey_protocol/tag', $currentTag->getId());
                        } else{
                            unset($tags[$count]);
                        }
                        $count++;
                    }
                }
                if(count($tags) > 0) {
                    foreach ($tags as $tag) {
                        try {
                            if (trim($tag) != '') {
                                Mage::getModel('ey_protocol/tag')
                                    ->setName($tag)
                                    ->setPriority($tagSingleton->getDefaultPriority())
                                    ->setApplicationId($data[$appEventId])
                                    ->save();
                            }
                        } catch (Exception $e) {
                            Mage::logException($e);
                        }
                    }
                }
            }
        }
    }

    protected function _saveFile($data)
    {
        if(array_key_exists('in_file', $data)){
            $selectedFiles = $data['in_file'];
            $files =  Mage::getModel('ey_protocol/fileapp')
                ->getCollection()
                ->addFieldToFilter('application_id', array('eq' => $data['entity_id']));
            if($files->getSize()){
                if(is_array($selectedFiles)){
                    foreach ($files as $file){
                        $key = array_search($file->getId(), $selectedFiles);
                        if($key === false){
                            $file->delete();
                        } else{
                            unset($selectedFiles[$key]);
                        }
                    }
                } else{
                    foreach ($files as $file){
                        $file->delete();
                    }
                }
            }
            if(is_array($selectedFiles) && count($selectedFiles) > 0){
                foreach ($selectedFiles as $selectedFile){
                    try{
                        Mage::getModel('ey_protocol/fileapp')
                            ->setFileId($selectedFile)
                            ->setApplicationId($data['entity_id'])
                            ->setOrder(0)
                            ->save();
                    } catch (Exception $e) {
                        Mage::logException($e);
                    }
                }
            }
        }
    }

    protected function _beforeDelete()
    {
        parent::_beforeDelete();

        $appId = $this->getId();
        $types = Mage::getModel('ey_protocol/type')
            ->getCollection()
            ->addFieldToFilter('application_id', array('eq' => $appId));
        $products = Mage::getModel('ey_protocol/product')
            ->getCollection()
            ->addFieldToFilter('application_id', array('eq' => $appId));
        $tags = Mage::getModel('ey_protocol/tag')
            ->getCollection()
            ->addFieldToFilter('application_id', array('eq' => $appId));
        $fileapps = Mage::getModel('ey_protocol/fileapp')
            ->getCollection()
            ->addFieldToFilter('application_id', array('eq' => $appId));

        if($types->getSize()){
            foreach ($types as $type){
                $this->_deleteItem('ey_protocol/type', $type->getId());
            }
        }
        if($products->getSize()){
            foreach ($products as $product){
                $this->_deleteItem('ey_protocol/product', $product->getId());
            }
        }
        if($tags->getSize()){
            foreach ($tags as $tag){
                $this->_deleteItem('ey_protocol/tag', $tag->getId());
            }
        }
        if($fileapps->getSize()){
            foreach ($fileapps as $fileapp){
                $this->_deleteItem('ey_protocol/fileapp', $fileapp->getId());
            }
        }
    }

    protected function _updateTimestamps()
    {
        $timestamp = now();

        $this->setUpdatedAt($timestamp);

        if ($this->isObjectNew()) {
            $this->setCreatedAt($timestamp);
        }

        return $this;
    }

    protected function _getUrl($application)
    {
        if($this->_url == null){
            $this->_url = Mage::getBaseUrl() . 'protocol/application/document/id/' . $this->getId();
        }
        return $this->_url;
    }

    public function getUrl()
    {
        return $this->_getUrl($this);
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @return Ey_Protocol_Model_Resource_Product_Collection
     */
    public function getProducts()
    {
        $products = Mage::getModel('ey_protocol/product')
            ->getCollection()
            ->addFieldToFilter('application_id', array('eq' => $this->getId()));

        return $products;
    }

    /**
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getLoadedProducts()
    {
        $productIds = array();
        $collection = $this->getProducts();

        if($collection->getSize()){
            foreach ($collection as $item){
                $productIds[] = $item->getProductId();
            }
        }

        return Mage::getModel('catalog/product')
            ->getCollection()
            ->addFieldToFilter('entity_id', array('in' => $productIds));
    }

    /**
     * @return Ey_Protocol_Model_Sampletype
     */
    public function getSampleType()
    {
        $type = Mage::getModel('ey_protocol/type')
            ->getCollection()
            ->addFieldToFilter('application_id', array('eq' => $this->getId()))
            ->getFirstItem();

        $type = Mage::getModel('ey_protocol/sampletype')->load($type->getSampletypeId());

        return $type;
    }

    /**
     * @return Ey_Protocol_Model_Resource_Tag_Collection
     */
    public function getTags()
    {
        $tags = Mage::getModel('ey_protocol/tag')
            ->getCollection()
            ->addFieldToFilter('application_id', array('eq' => $this->getId()));

        return $tags;
    }

    /**
     * @return Ey_Protocol_Model_Resource_File_Collection
     */
    public function getFiles()
    {
        $fileIds = Mage::getModel('ey_protocol/fileapp')
            ->getCollection()
            ->addFieldToFilter('application_id', array('eq' => $this->getId()));
        $fileArrayIds = array();
        foreach ($fileIds as $fileId){
            $fileArrayIds[] = $fileId->getFileId();
        }

        $files = Mage::getModel('ey_protocol/file')
            ->getCollection()
            ->addFieldToFilter('entity_id', array('in' => $fileArrayIds));

        return $files;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        if($this->getImageName()){
            return Mage::getBaseUrl('media') . '/protocol/' . DS . $this->getImageName();
        }

        return false;
    }
}