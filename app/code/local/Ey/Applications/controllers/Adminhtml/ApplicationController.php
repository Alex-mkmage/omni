<?php


class Ey_Applications_Adminhtml_ApplicationController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $block = $this->getLayout()
            ->createBlock('ey_applications/adminhtml_application');

        $this->loadLayout()
            ->_addContent($block)
            ->renderLayout();
    }

    public function editAction()
    {
        $application = Mage::getModel('ey_applications/application');
        if ($applicationId = $this->getRequest()->getParam('id', false)) {
            $application->load($applicationId);

            if (!$application->getId()) {
                $this->_getSession()->addError(
                    $this->__('This application no longer exists.')
                );
                return $this->_redirect(
                    'adminhtml/application/index'
                );
            } elseif($application->getIsSent() == 0){
                $sent = Mage::helper('ey_applications/email')->send(
                    array(
                        'name' => $application->getName(),
                        'id' => $application->getApplicationId(),
                        'created_at' => $application->getCreatedAt()
                    )
                );

                if($sent){
                    $application->setIsSent(1);
                    $application->save();
                }
            }
        }

        if ($postData = $this->getRequest()->getPost('fileData')) {
            $this->_saveFile();
        }

        if ($postData = $this->getRequest()->getPost('applicationData')) {
            /**
             * Convert array to string
             */
            foreach($postData as $id => $data){
                if($id == 'image_name'){
                    if(isset($data['delete']) && $data['delete'] == 1){
                        $postData[$id] = '';
                        $media_path  = Mage::getBaseDir('media') . '/application/' . DS;
                        unlink($media_path . $data['value']);
                    } else{
                        $postData[$id] = $data['value'];
                    }
                } elseif(is_array($data)){
                    $json = Mage::helper('core')->jsonEncode($data);
                    $postData[$id] = $json;
                } 
            }
            try {
                if($selectedFiles = $this->getRequest()->getPost('in_file', null)){
                    $postData['in_file'] = $selectedFiles;
                }

                if(isset($_FILES['applicationData']['name']['image_name']) &&
                    $_FILES['applicationData']['name']['image_name'] != '') {
                    try {
                        $uploader = new Varien_File_Uploader(
                            array(
                                'name' => $_FILES['applicationData']['name']['image_name'],
                                'type' => $_FILES['applicationData']['type']['image_name'],
                                'tmp_name' => $_FILES['applicationData']['tmp_name']['image_name'],
                                'error' => $_FILES['applicationData']['error']['image_name'],
                                'size' => $_FILES['applicationData']['size']['image_name']
                            )
                        );

                        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        // Set media as the upload dir
                        $media_path  = Mage::getBaseDir('media') . '/application/' . DS;

                        // Upload the image
                        $result = $uploader->save($media_path, $_FILES['applicationData']['name']['image_name']);

                        $postData['image_name'] = $result['file'];
                    }
                    catch (Exception $e) {
                        Mage::logException($e);
                        $this->_getSession()->addError($e->getMessage());
                    }
                }

                $application->addData($postData);

                if(!$application->getIsSent()){
                    $application->setIsSent(0);
                }

                $application->save();

                $this->_getSession()->addSuccess(
                    $this->__('The application has been saved.')
                );

                return $this->_redirect(
                    'adminhtml/application/edit',
                    array('id' => $application->getId())
                );
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
        }

        Mage::register('current_application', $application);

        $applicationEditBlock = $this->getLayout()->createBlock(
            'ey_applications/adminhtml_application_edit'
        );

        $this->loadLayout()
            ->_addContent($applicationEditBlock)
            ->renderLayout();

        return $this;
    }

    public function _saveFile()
    {
        $postData = $this->getRequest()->getPost('fileData');
        $application = Mage::getModel('ey_applications/file');
        if ($applicationId = $this->getRequest()->getParam('id', false)) {
            $application->load($applicationId);
        }

        if (isset($postData['name']) && $postData['name'] != '') {
            /**
             * Convert array to string
             */
            foreach($postData as $id => $data){
                if(is_array($data)){
                    $json = Mage::helper('core')->jsonEncode($data);
                    $postData[$id] = $json;
                }
            }

            if(isset($_FILES['fileData']['name']['file_path']) && $_FILES['fileData']['name']['file_path'] != '') {
                try {
                    $uploader = new Varien_File_Uploader(
                        array(
                            'name' => $_FILES['fileData']['name']['file_path'],
                            'type' => $_FILES['fileData']['type']['file_path'],
                            'tmp_name' => $_FILES['fileData']['tmp_name']['file_path'],
                            'error' => $_FILES['fileData']['error']['file_path'],
                            'size' => $_FILES['fileData']['size']['file_path']
                        )
                    );

                    $uploader->setAllowedExtensions(array('pdf'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);

                    // Set media as the upload dir
                    $media_path  = Mage::getBaseDir('media') . DS . 'pdf' . DS;

                    // Upload the image
                    $uploadResult = $uploader->save($media_path, $_FILES['fileData']['name']['file_path']);

                    $postData['file_path'] = Mage::getBaseUrl('media') . 'pdf' . DS . $uploadResult['file'];
                }
                catch (Exception $e) {
                    Mage::logException($e);
                    $this->_getSession()->addError($e->getMessage());
                }
            }

            try {
                $application->addData($postData);
                $application->save();

                $this->_getSession()->addSuccess(
                    $this->__('The file has been saved.')
                );
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
        }
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function deleteAction()
    {
        $article = Mage::getModel('ey_applications/application');

        if ($articleId = $this->getRequest()->getParam('id', false)) {
            $article->load($articleId);
        }

        if ($article->getId() < 1) {
            $this->_getSession()->addError(
                $this->__('This application no longer exists.')
            );
            return $this->_redirect(
                'adminhtml/application/index'
            );
        }

        try {
            $article->delete();

            $this->_getSession()->addSuccess(
                $this->__('The application has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'adminhtml/application/index'
        );
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'edit':
            case 'delete':
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('ey_applications/application');
                break;
        }

        return $isAllowed;
    }

    /**
     * Echo json
     */
    public function productsAction()
    {
        if($term = $this->getRequest()->getParam('term')){
            $products = $this->_getProductList($term);
            $this->getResponse()->setBody($products);
        }
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * File Grid
     */
    public function fileAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('application_edit_tab_files')
            ->setSelectedItem($this->getRequest()->getPost('files'));
        $this->renderLayout();
    }

    /**
     * File Grid
     */
    public function filegridAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('application_edit_tab_files')
            ->setSelectedItem($this->getRequest()->getPost('files', null));
        $this->renderLayout();
    }

    /**
     * @param string $term
     * @return string
     */
    protected function _getProductList($term)
    {
        $storeId = Mage::app()->getStore()->getId();
        $cache = Mage::app()->getCache();
        $key = 'application-product-sku-' . $term . $storeId;

        if(!$products = $cache->load($key)){
            $productSkus = array();
            $products = Mage::getModel('catalog/product')
                ->getCollection()
                ->addFieldToFilter('sku', array('like' => $term.'%'))
                ->addAttributeToSort('sku', 'ASC');

            if($products->getSize()){
                foreach($products as $product){
                    $productSkus[] = array(
                        'id' => $product->getId(),
                        'label' => $product->getSku(),
                        'value' => $product->getSku()
                    );
                }

                $serializeReports = serialize($productSkus);
                $cache->save(urlencode($serializeReports), $key, array("application_sku_cache"), 60*60*24);

                return Mage::helper('core')->jsonEncode($productSkus);
            } else{
                return '';
            }
        }

        return Mage::helper('core')->jsonEncode(unserialize(urldecode($products)));
    }
}