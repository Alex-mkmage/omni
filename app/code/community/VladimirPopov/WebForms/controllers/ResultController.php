<?php

/**
 * @author         Vladimir Popov
 * @copyright      Copyright (c) 2017 Vladimir Popov
 */
class VladimirPopov_WebForms_ResultController
    extends Mage_Core_Controller_Front_Action
{
    /** @var VladimirPopov_WebForms_Model_Results */
    protected $_result;

    public function _init()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            Mage::getSingleton('customer/session')->addError($this->__('Please login to view the form.'));
            Mage::getSingleton('customer/session')->authenticate($this);
        }

        $resultId = Mage::app()->getRequest()->getParam('id');
        $result = Mage::getModel('webforms/results')->load($resultId);
        $result->addFieldArray();

        $access = new Varien_Object();
        $access->setAllowed(false);
        if ($result->getCustomerId() == Mage::getSingleton('customer/session')->getId())
            $access->setAllowed(true);

        Mage::dispatchEvent('webforms_controller_result_access', array('access' => $access, 'result' => $result));

        if (!$access->getAllowed()) {
            Mage::getSingleton('core/session')->addError($this->__('Access denied.'));
            $this->_redirect('customer/account');
        }

        $groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        $webform = Mage::getModel('webforms/webforms')->setStoreId($result->getStoreId())->load($result->getWebformId());
        if (!$webform->getIsActive() || !$webform->getDashboardEnable() || !in_array($groupId, $webform->getDashboardGroups())) $this->_redirect('customer/account');
        Mage::register('result', $result);
        $this->_result = $result;
    }

    public function editAction()
    {
        $this->_init();
        $webform = $this->_result->getWebform();
        if (!in_array('edit', $webform->getCustomerResultPermissions())) $this->_redirect('webforms/customer/account', array('webform_id' => $webform->getId()));

        $this->loadLayout();
        $this->getLayout()->getBlock('webforms_customer_account_form_edit')
            ->setData('webform_id', $webform->getId())
            ->setResult($this->_result);
        $this->getLayout()->getBlock('head')->setTitle(Mage::registry('result')->getEmailSubject());

        $this->renderLayout();
    }

    public function printAction()
    {
        $this->_init();
        $webform = $this->_result->getWebform();
        if (!in_array('print', $webform->getCustomerResultPermissions())) $this->_redirect('webforms/customer/account', array('webform_id' => $webform->getId()));

        if (@class_exists('mPDF')) {
            $mpdf = @new mPDF('utf-8', 'A4');
            @$mpdf->WriteHTML($this->_result->toPrintableHtml());

            $this->_prepareDownloadResponse($this->_result->getPdfFilename(), @$mpdf->Output('', 'S'), 'application/pdf');
        } else {
            Mage::getSingleton('core/session')->addError($this->__('Printing is disabled.'));
            $this->_redirect('webforms/customer/account', array('webform_id' => $webform->getId()));
        }

        $this->renderLayout();
    }

    public function pdfAction()
    {
        $hash = $this->getRequest()->getParam('hash');
        if($hash) {
            $resultId = Mage::getSingleton('core/session')->getData($hash);
            $result = Mage::getModel('webforms/results')->load($resultId);
            if($result->getId()) {
                if (@class_exists('mPDF')) {
                    $mpdf = @new mPDF('utf-8', 'A4');
                    @$mpdf->WriteHTML($result->toPrintableHtml());

                    $this->_prepareDownloadResponse($result->getPdfFilename(), @$mpdf->Output('', 'S'), 'application/pdf');
                } else {
                    Mage::getSingleton('core/session')->addError($this->__('Printing is disabled.'));
                }
            }
        }

        $this->renderLayout();
    }

    public function deleteAction()
    {
        $this->_init();
        $webform = $this->_result->getWebform();
        if (!in_array('delete', $webform->getCustomerResultPermissions())) $this->_redirect('customer/account');

        $this->_result->delete();
        Mage::getSingleton('core/session')->addSuccess($this->__('The record has been deleted.'));
        $this->_redirect('webforms/customer/account', array('webform_id' => $webform->getId()));

    }
}
