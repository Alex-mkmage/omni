<?php

class VladimirPopov_WebForms_Block_Adminhtml_Webforms_Edit_Tab_Access
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $renderer = $this->getLayout()->createBlock('webforms/adminhtml_element_field');
        $form->setFieldsetElementRenderer($renderer);
        $form->setFieldNameSuffix('form');
        $form->setDataObject(Mage::registry('webforms_data'));

        $this->setForm($form);

        $fieldset = $form->addFieldset('customer_access', array(
            'legend' => Mage::helper('webforms')->__('Customer Access')
        ));

        $access_enable = $fieldset->addField('access_enable', 'select', array(
            'name' => 'access_enable',
            'label' => Mage::helper('webforms')->__('Limit customer access'),
            'note' => Mage::helper('webforms')->__('Limit access to the form for certain customer groups'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $access_groups = $fieldset->addField('access_groups', 'multiselect', array
        (
            'label' => Mage::helper('webforms')->__('Allowed customer groups'),
            'title' => Mage::helper('webforms')->__('Allowed customer groups'),
            'name' => 'access_groups',
            'required' => false,
            'note' => Mage::helper('webforms')->__('Allow form access for selected customer groups only'),
            'values' => $this->getGroupOptions(),
        ));

        $fieldset = $form->addFieldset('customer_dashboard', array(
            'legend' => Mage::helper('webforms')->__('Customer Dashboard')
        ));

        $dashboard_enable = $fieldset->addField('dashboard_enable', 'select', array(
            'name' => 'dashboard_enable',
            'label' => Mage::helper('webforms')->__('Add form to customer dashboard'),
            'note' => Mage::helper('webforms')->__('Add link to the form and submission results to customer dashboard menu'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $dashboard_groups = $fieldset->addField('dashboard_groups', 'multiselect', array
        (
            'label' => Mage::helper('webforms')->__('Customer groups'),
            'title' => Mage::helper('webforms')->__('Customer groups'),
            'name' => 'dashboard_groups',
            'required' => false,
            'note' => Mage::helper('webforms')->__('Add form to dashboard for selected customer groups only'),
            'values' => $this->getGroupOptions(),
        ));

        $customer_result_permissions = $fieldset->addField('customer_result_permissions', 'multiselect', array(
            'name' => 'customer_result_permissions',
            'label' => Mage::helper('webforms')->__('Result permissions'),
            'note' => Mage::helper('webforms')->__('Permissions identify which actions customer can perform with results in the dashboard area'),
            'values' => Mage::getModel('webforms/result_permissions')->toOptionArray(),
        ));

        $fieldset = $form->addFieldset('file_access', array(
            'legend' => Mage::helper('webforms')->__('File Access')
        ));

        $frontend_download = $fieldset->addField('frontend_download', 'select', array(
            'name' => 'frontend_download',
            'label' => Mage::helper('webforms')->__('Allow frontend file downloads'),
            'note' => Mage::helper('webforms')->__('Adds file links to admin notification emails. Useful when you can not attach large files to email but need to be able to download them directly from the email program. Its recommended to turn it off for sensitive data.'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        if (Mage::getSingleton('adminhtml/session')->getWebFormsData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getWebFormsData());
            Mage::getSingleton('adminhtml/session')->setWebFormsData(null);
        } elseif (Mage::registry('webforms_data')) {
            $form->setValues(Mage::registry('webforms_data')->getData());
        }

        return parent::_prepareForm();
    }

    public function getGroupOptions()
    {
        $options = array();
        $collection = Mage::getModel('customer/group')->getCollection();

        foreach ($collection as $group) {
            if ($group->getCustomerGroupId())
                $options[] = array('value' => $group->getCustomerGroupId(), 'label' => $group->getCustomerGroupCode());
        }

        return $options;
    }
}