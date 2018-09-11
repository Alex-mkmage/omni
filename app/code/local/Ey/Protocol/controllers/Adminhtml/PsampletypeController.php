<?php


class Ey_Protocol_Adminhtml_PsampletypeController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $block = $this->getLayout()
            ->createBlock('ey_protocol/adminhtml_sampletype');

        $this->loadLayout()
            ->_addContent($block)
            ->renderLayout();
    }

    public function editAction()
    {
        $application = Mage::getModel('ey_protocol/sampletype');
        if ($applicationId = $this->getRequest()->getParam('id', false)) {
            $application->load($applicationId);

            if ($application->getId() < 1) {
                $this->_getSession()->addError(
                    $this->__('This sample type no longer exists.')
                );
                return $this->_redirect(
                    'adminhtml/psampletype/index'
                );
            }
        }

        if ($postData = $this->getRequest()->getPost('sampletypeData')) {
            /**
             * Convert array to string
             */
            foreach($postData as $id => $data){
                if(is_array($data)){
                    $json = Mage::helper('core')->jsonEncode($data);
                    $postData[$id] = $json;
                }
            }
            try {
                $application->addData($postData);
                $application->save();

                $this->_getSession()->addSuccess(
                    $this->__('The sample type has been saved.')
                );

                return $this->_redirect(
                    'adminhtml/psampletype/index'
                );
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
        }

        Mage::register('current_sample_type', $application);

        $editBlock = $this->getLayout()->createBlock(
            'ey_protocol/adminhtml_sampletype_edit'
        );

        $this->loadLayout()
            ->_addContent($editBlock)
            ->renderLayout();
    }

    public function deleteAction()
    {
        $article = Mage::getModel('ey_protocol/sampletype');

        if ($articleId = $this->getRequest()->getParam('id', false)) {
            $article->load($articleId);
        }

        if ($article->getId() < 1) {
            $this->_getSession()->addError(
                $this->__('This sample type no longer exists.')
            );
            return $this->_redirect(
                'adminhtml/psampletype/index'
            );
        }

        try {
            $article->delete();

            $this->_getSession()->addSuccess(
                $this->__('The sample type has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'adminhtml/psampletype/index'
        );
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
                    ->isAllowed('ey_protocol/sampletype');
                break;
        }

        return $isAllowed;
    }
}