<?php

class VladimirPopov_WebForms_Block_Gdpr extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('webforms/scripts/gdpr.phtml');

        /** @var VladimirPopov_WebForms_Model_Webforms $_webform */
        $_webform = $this->getWebform();

        $this->setData('show_agreement_text', $_webform->getData('show_gdpr_agreement_text'));
        $this->setData('agreement_text', Mage::helper('cms')->getPageTemplateProcessor()->filter($_webform->getData('gdpr_agreement_text')));
        $this->setData('show_checkbox', $_webform->getData('show_gdpr_agreement_checkbox'));
        $this->setData('checkbox_required', $_webform->getData('gdpr_agreement_checkbox_required'));
        $this->setData('checkbox_label', $_webform->getData('gdpr_agreement_checkbox_label'));
        $this->setData('error_text', $_webform->getData('gdpr_agreement_checkbox_error_text'));
    }
}