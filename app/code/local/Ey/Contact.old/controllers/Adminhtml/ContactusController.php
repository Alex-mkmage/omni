<?php


class Ey_Contact_Adminhtml_ContactusController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $block = $this->getLayout()
            ->createBlock('ey_contact/adminhtml_contact');

        $this->loadLayout()
            ->_addContent($block)
            ->renderLayout();
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function deleteAction()
    {
        $model = Mage::getModel('ey_contact/contact');

        if ($id = $this->getRequest()->getParam('id', false)) {
            $model->load($id);
        }

        if ($model->getId() < 1) {
            $this->_getSession()->addError(
                $this->__('This contact no longer exists.')
            );
            return $this->_redirect(
                'adminhtml/contactus/index'
            );
        }

        try {
            $model->delete();

            $this->_getSession()->addSuccess(
                $this->__('The contact has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'adminhtml/contactus/index'
        );
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'delete':
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('ey_contact/contact');
                break;
        }

        return $isAllowed;
    }

    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('contact_id');
        if(!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ey_contact')->__('Please select contacts.'));
        } else {
            try {
                $model = Mage::getModel('ey_contact/contact');
                foreach ($ids as $id) {
                    $model->load($id)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('ey_contact')->__(
                        'Total of %d record(s) were deleted.', count($ids)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}