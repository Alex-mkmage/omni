<?php

class Ey_Protocol_Block_Application_List extends Ey_Protocol_Block_Application
{
    /**
     * @var array
     */
    protected $_searchCriteria;

    /**
     * @var array
     */
    protected $_productCollection;

    /**
     * @var int
     */
    protected $_collectionCount;

    public function _construct()
    {
        parent::_construct();
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    /**
     * @throws Exception
     */
    protected function _prepareData()
    {
        if($getData = $this->getRequest()->getParam('filter')){
            if(!array_key_exists('page', $getData)){
                $getData['page'] = 1;
            }
            if(isset($getData['sampletype_id'])){
                $getData['sampletype_id'] = array_filter($getData['sampletype_id'], function($value) { return $value !==
                ''; });
                if(count($getData['sampletype_id']) == 0){
                    unset($getData['sampletype_id']);
                }
            }
            if(isset($getData['product_id'])){
                $getData['product_id'] = array_filter($getData['product_id'], function($value) { return $value !==
                ''; });
                if(count($getData['product_id']) == 0){
                    unset($getData['product_id']);
                }
            }
            if(array_key_exists('name', $getData)){
                /** Check if name surrounded by double quotes */
                if(preg_match('/^(["\']).*\1$/m', $getData['name']) == 0) {
                    $nameArray = explode(' ', $getData['name']);
                    $getData['name_array'] = array('%' . $getData['name'] . '%');
                    $excludedWords = Mage::helper('ey_protocol')->getExcludedSearchWords();
                    foreach ($nameArray as $name) {
                        if(array_search($name, $excludedWords) === false){
                            $getData['name_array'][] = '%' . $name . '%';
                        }
                    }
                }
                $getData['name'] = '%' . trim($getData['name'], '"') . '%';
            }
            $this->setSearchCriteria($getData);
            $this->_prepareProductCollection();
        }
    }

    /**
     * @return array|null
     */
    public function getSearchCriteria()
    {
        return $this->_searchCriteria;
    }

    /**
     * @param array $filter
     */
    protected function setSearchCriteria($filter)
    {
        $this->_searchCriteria = $filter;
        Mage::getSingleton('customer/session')->setProtocolSearchCriteria($filter);
    }

    /**
     * @return array
     */
    public function getApplicationList()
    {
        $itemArray = array();
        $itemSkus = array();
        /** @var Ey_Protocol_Model_Resource_Application_Collection $items */
        $items = Mage::getModel('ey_protocol/application')
            ->getCollection()
            ->addFieldToFilter('visibility', array('in' => array(1, 2)));

        $items->getSelect()
            ->joinLeft(array(
                'ey_protocol_product' => 'ey_protocol_product'),
                'main_table.entity_id = ey_protocol_product.application_id',
                array(
                    'sku' => 'sku',
                    'document_id' => 'application_id',
                    'product_id' => 'product_id'
                )
            )->joinLeft(array(
                'ey_protocol_type' => 'ey_protocol_type'),
                'main_table.entity_id = ey_protocol_type.application_id',
                array('sampletype_id')
            )->group('main_table.entity_id');

        if($searchCriteria = $this->getSearchCriteria()){
            if(array_key_exists('name', $searchCriteria)){
                if($searchCriteria['scope'] == 'tag'){
                    $applicationIdByTags = Mage::getModel('ey_protocol/tag')
                        ->getCollection()
                        ->addFieldToFilter('name', array('like' => $searchCriteria['name']));
                    $applicationIdByTagsArray = array();
                    if($applicationIdByTags->getSize()){
                        foreach ($applicationIdByTags as $applicationIdByTag){
                            $applicationIdByTagsArray[] = $applicationIdByTag->getApplicationId();
                        }
                    }

                    $items->addFieldToFilter('main_table.entity_id', array('in' => $applicationIdByTagsArray));
                } else{
                    if(array_key_exists('name_array', $searchCriteria)){
                        $filter = array();
                        $filterLabel = array();
                        /** Build up addFieldToFilter */
                        foreach ($searchCriteria['name_array'] as $name){
                            $filterLabel[] = 'main_table.name';
                            $filterLabel[] = 'main_table.analyte';
                            $filter[] = array('like' => $name);
                            $filter[] = array('like' => $name);
                        }
                        $items->addFieldToFilter($filterLabel, $filter);
                    } else{
                        $items->addFieldToFilter(
                            array('main_table.name', 'main_table.analyte'),
                            array(
                                array('like'=>$searchCriteria['name']),
                                array('like'=>$searchCriteria['name'])
                            )
                        );
                    }
                }
            }
            if(array_key_exists('list_all', $searchCriteria)){
                if($searchCriteria['list_all'] == '0'){
                    $items->getSelect()
                        ->joinLeft(array(
                            'ey_protocol_sampletype' => 'ey_protocol_sampletype'),
                            'ey_protocol_type.sampletype_id = ey_protocol_sampletype.entity_id',
                            array(
                                'sampletype_name' => 'name'
                            )
                        );
                    $items->setOrder('sampletype_name', 'ASC');
                }
            } else{
                if(array_key_exists('sampletype_id', $searchCriteria)){
                    $items->addFieldToFilter('sample_type', array('in' =>
                        $searchCriteria['sampletype_id']));
                }
                if(array_key_exists('product_id', $searchCriteria)){
                    $items->addFieldToFilter('sku', array('in' => $searchCriteria['product_id']));
                }
            }

            if(array_key_exists('page', $searchCriteria)){
                if(array_key_exists('total_count', $searchCriteria)){
                    $this->_collectionCount = $searchCriteria['total_count'];
                } else{
                    $clone = clone $items;
                    $this->_collectionCount = $clone->count();
                }
                $page = ($searchCriteria['page'] * 9) - 9;
                $items->getSelect()->limit(9, $page);
                $items->setOrder('main_table.name', 'ASC');
            }

            if(array_key_exists('list_all', $searchCriteria) && $searchCriteria['list_all'] == '1'){
                $itemArrayAlt = array();
                $products = $this->getProductCollection();
                $count = 0;
                foreach($items as $item) {
                    $itemSkus[] = $item->getId();
                    $itemArray[] = array(
                        'application_id' => $item->getApplicationId(),
                        'id' => $item->getId(),
                        'visibility' => $item->getVisibility(),
                        'url' => $item->getUrl(),
                        'name' => $item->getName(),
                        'files' => $item->getFiles(),
                        'sample_type' => $item->getSampleType()->getName(),
                        'tags' => $item->getTags(),
                        'created' => $item->getCreatedAt(),
                        'analyte' => $item->getAnalyte(),
                        'image' => $item->getImage(),
                        'procedure' => $item->getProcedure()
                    );
                }
                ksort($itemArrayAlt, SORT_STRING);
                $itemArray = array_merge($itemArrayAlt, $itemArray);
            }
        }
        if(count($itemArray) <= 0){
            foreach($items as $item) {
                $itemSkus[] = $item->getId();
                $itemArray[$item->getId()] = array(
                    'application_id' => $item->getApplicationId(),
                    'id' => $item->getId(),
                    'visibility' => $item->getVisibility(),
                    'url' => $item->getUrl(),
                    'name' => $item->getName(),
                    'files' => $item->getFiles(),
                    'sample_type' => $item->getSampleType()->getName(),
                    'tags' => $item->getTags(),
                    'created' => $item->getCreatedAt(),
                    'analyte' => $item->getAnalyte(),
                    'image' => $item->getImage(),
                    'procedure' => $item->getProcedure()
                );
            }
        }
        if(count($itemSkus) > 0){
            $products = $this->getProductCollection();
            $selectedSkus = Mage::getModel('ey_protocol/product')
                ->getCollection()
                ->addFieldToFilter('application_id', array('in' => $itemSkus));

            foreach ($selectedSkus as $sku){
                if(isset($products[$sku->getSku()])) {
                    $itemArray[$sku->getApplicationId()]['sku'] = $sku->getSku();
                    $itemArray[$sku->getApplicationId()]['products'][] = array(
                        'product_id' => $products[$sku->getSku()]['id'],
                        'product_url' => $products[$sku->getSku()]['url'],
                        'product_name' => $products[$sku->getSku()]['name']
                    );
                }
            }

        }

        return $itemArray;
    }

    public function getFileCollection()
    {

    }

    public function getCollectionCount()
    {
        return $this->_collectionCount;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getRequestFormKey()
    {
        return $this->getRequest()->getParam('formkey');
    }
    
}
