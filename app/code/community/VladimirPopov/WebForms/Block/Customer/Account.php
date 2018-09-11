<?php
class VladimirPopov_WebForms_Block_Customer_Account
    extends Mage_Core_Block_Template
{
    public function getPermission($permission)
    {
        $webform = Mage::registry('webform');
        return in_array($permission, $webform->getData('customer_result_permissions'));
    }
}