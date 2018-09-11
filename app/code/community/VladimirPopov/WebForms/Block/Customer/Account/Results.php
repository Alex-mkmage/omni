<?php

class VladimirPopov_WebForms_Block_Customer_Account_Results
    extends Mage_Core_Block_Template
{
    protected $_resultsCollection;

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if ($toolbar = Mage::app()->getLayout()->createBlock('page/html_pager')) {
            $toolbar->setCollection($this->getCollection());
            $this->setChild('toolbar', $toolbar);
        }

        return $this;
    }

    public function setCollection(VladimirPopov_WebForms_Model_Mysql4_Results_Collection $collection)
    {
        $this->_resultsCollection = $collection;
        return $this;
    }

    public function getCollection()
    {
        Mage::dispatchEvent('webforms_block_customer_account_results_get_collection_before', array('block' => $this));

        if (null === $this->_resultsCollection) {
            $webform = Mage::registry('webform');
            $this->_resultsCollection = Mage::getModel('webforms/results')->getCollection()
                ->addFilter('webform_id', $webform->getId())
                ->addFilter('customer_id', Mage::getSingleton('customer/session')->getCustomerId())
                ->setLoadValues(true);
            $this->_resultsCollection->getSelect()->order('created_time desc');
        }

        return $this->_resultsCollection;
    }

    public function getUrlResultView(VladimirPopov_WebForms_Model_Results $result)
    {
        return Mage::getUrl('webforms/customer/result', array('id' => $result->getId()));
    }

    public function getUrlResultEdit(VladimirPopov_WebForms_Model_Results $result)
    {
        return Mage::getUrl('webforms/result/edit', array('id' => $result->getId()));
    }

    public function getUrlResultDelete(VladimirPopov_WebForms_Model_Results $result)
    {
        return Mage::getUrl('webforms/result/delete', array('id' => $result->getId()));
    }

    public function getUrlResultPrint(VladimirPopov_WebForms_Model_Results $result)
    {
        return Mage::getUrl('webforms/result/print', array('id' => $result->getId()));
    }

    public function getRepliedStatus(VladimirPopov_WebForms_Model_Results $result)
    {
        $messages = Mage::getModel('webforms/message')->getCollection()->addFilter('result_id', $result->getId())->count();
        if ($messages) return $this->__('Yes');
        return $this->__('No');
    }

    public function getApproveStatus(VladimirPopov_WebForms_Model_Results $result)
    {
        $statuses = $result->getApprovalStatuses();
        foreach ($statuses as $id => $text)
            if ($result->getApproved() == $id)
                return $text;

    }

    public function getPermission($permission)
    {
        $webform = Mage::registry('webform');
        return in_array($permission, $webform->getData('customer_result_permissions'));
    }

}