<?php

class VladimirPopov_WebForms_Block_Customer_Account_Result_Edit
    extends Mage_Core_Block_Template
{
    /** @return VladimirPopov_WebForms_Model_Results */
    public function getResult()
    {
        if (Mage::registry('result'))
            return Mage::registry('result');
    }

    public function getMessages()
    {
        $result = $this->getResult();
        if($result->getId()) {
            $collection = Mage::getModel('webforms/message')->getCollection()
                ->addFilter('result_id', $result->getId());
            $collection->getSelect()->order('created_time desc');
            return $collection;
        }
    }
}