<?php


class Ey_Protocol_Adminhtml_PfileController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $block = $this->getLayout()
            ->createBlock('ey_protocol/adminhtml_file');

        $this->loadLayout()
            ->_addContent($block)
            ->renderLayout();
    }

    public function editAction()
    {
        $application = Mage::getModel('ey_protocol/file');
        if ($applicationId = $this->getRequest()->getParam('id', false)) {
            $application->load($applicationId);

            if ($application->getId() < 1) {
                $this->_getSession()->addError(
                    $this->__('This file no longer exists.')
                );
                return $this->_redirect(
                    'adminhtml/pfile/index'
                );
            }
        }

        if ($postData = $this->getRequest()->getPost('fileData')) {
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
                    $media_path  = Mage::getBaseDir('media')  . DS . 'pdf' . DS;

                    // Upload the image
                    $uploadResult = $uploader->save($media_path, $_FILES['fileData']['name']['file_path']);

                    $postData['file_path'] = Mage::getBaseUrl('media') . 'pdf' . DS . $uploadResult['file'];
                    $postData['mime_type'] = $uploadResult['type'];
                    $postData['file_size'] = $uploadResult['size'];
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

                return $this->_redirect(
                    'adminhtml/pfile/index'
                );
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
        }

        Mage::register('current_file', $application);

        $editBlock = $this->getLayout()->createBlock(
            'ey_protocol/adminhtml_file_edit'
        );

        $this->loadLayout()
            ->_addContent($editBlock)
            ->renderLayout();
    }

    public function deleteAction()
    {
        $article = Mage::getModel('ey_protocol/file');

        if ($articleId = $this->getRequest()->getParam('id', false)) {
            $article->load($articleId);
        }

        if ($article->getId() < 1) {
            $this->_getSession()->addError(
                $this->__('This file no longer exists.')
            );
            return $this->_redirect(
                'adminhtml/pfile/index'
            );
        }

        try {
            $article->delete();

            $this->_getSession()->addSuccess(
                $this->__('The file has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'adminhtml/pfile/index'
        );
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

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
                    ->isAllowed('ey_protocol/file');
                break;
        }

        return $isAllowed;
    }
}