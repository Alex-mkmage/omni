<?php

class VladimirPopov_WebForms_Block_Adminhtml_Webforms_Edit_Tab_Gdpr
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

        $fieldset = $form->addFieldset('webforms_gdpr', array(
            'legend' => Mage::helper('webforms')->__('GDPR Settings')
        ));

        $fieldset->addField('delete_submissions', 'select', array(
            'label' => Mage::helper('webforms')->__('Do not store submissions'),
            'title' => Mage::helper('webforms')->__('Do not store submissions'),
            'name' => 'delete_submissions',
            'required' => false,
            'global' => true,
            'note' => Mage::helper('webforms')->__('Do not store submissions in the database. Just email them'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $options = Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray();
        $options = array_merge(array(array('label' => Mage::helper('webforms')->__('Default'), 'value' => '-1')), $options);
        $fieldset->addField('purge_enable', 'select', array(
            'label' => Mage::helper('webforms')->__('Purge data periodically (cron job)'),
            'title' => Mage::helper('webforms')->__('Purge data periodically (cron job)'),
            'name' => 'purge_enable',
            'required' => false,
            'global' => true,
            'note' => Mage::helper('webforms')->__('Automatically delete submissions.<br><b>Requires Magento cron to be configured!</b><br><span style="color: red; font-weight: bold">Warning! Please be careful with this setting. The deleted data is not recoverable!</span>'),
            'values' => $options,
        ));

        $fieldset->addField('purge_period', 'text', array(
            'label' => Mage::helper('webforms')->__('Purge period (days)'),
            'title' => Mage::helper('webforms')->__('Purge period (days)'),
            'name' => 'purge_period',
            'required' => false,
            'global' => true,
            'note' => Mage::helper('webforms')->__('Delete records older than specified period.<br>Overwritten with the default configuration value if it is enabled!'),
        ));


        $fieldset = $form->addFieldset('webforms_gdpr_agreement', array(
            'legend' => Mage::helper('webforms')->__('GDPR Agreement')
        ));

        $fieldset->addField('show_gdpr_agreement_text', 'select', array(
            'label' => Mage::helper('webforms')->__('Show GDPR agreement text'),
            'title' => Mage::helper('webforms')->__('Show GDPR agreement text'),
            'name' => 'show_gdpr_agreement_text',
            'required' => false,
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $editor_type = 'textarea';
        $style= '';
        $config = '';
        if((float)substr(Mage::getVersion(),0,3) > 1.3 && substr(Mage::getVersion(),0,5)!= '1.4.0' || Mage::helper('webforms')->getMageEdition() == 'EE'){

            $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
                array('tab_id' => $this->getTabId())
            );

            $wysiwygConfig["files_browser_window_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index');
            $wysiwygConfig["directives_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');
            $wysiwygConfig["directives_url_quoted"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');
            $wysiwygConfig["widget_window_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index');

            $plugins = $wysiwygConfig->getPlugins();
            for($i=0;$i<count($plugins); $i++){
                if($plugins[$i]["name"] == "magentovariable"){
                    $plugins[$i]["options"]["url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin');
                    $plugins[$i]["options"]["onclick"]["subject"] = 'MagentovariablePlugin.loadChooser(\''.Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin').'\', \'{{html_id}}\');';
                }
            }
            $wysiwygConfig->setPlugins($plugins);

            $editor_type='editor';
            $style = 'height:20em; width:50em;';
            $config = $wysiwygConfig;
        }

        $fieldset->addField('gdpr_agreement_text', $editor_type, array(
            'label' => Mage::helper('webforms')->__('GDPR agreement text'),
            'title' => Mage::helper('webforms')->__('GDPR agreement text'),
            'name' => 'gdpr_agreement_text',
            'style' => $style,
            'note' => Mage::helper('webforms')->__('This text will be placed before submit button.<br>You can inform the customer if you are collecting his personal information and why'),
            'wysiwyg' => true,
            'config' => $config,
        ));

        $fieldset->addField('show_gdpr_agreement_checkbox', 'select', array(
            'label' => Mage::helper('webforms')->__('Show GDPR agreement checkbox'),
            'title' => Mage::helper('webforms')->__('Show GDPR agreement checkbox'),
            'name' => 'show_gdpr_agreement_checkbox',
            'required' => false,
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $fieldset->addField('gdpr_agreement_checkbox_required', 'select', array(
            'label' => Mage::helper('webforms')->__('Required'),
            'title' => Mage::helper('webforms')->__('Required'),
            'name' => 'gdpr_agreement_checkbox_required',
            'required' => false,
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $fieldset->addField('gdpr_agreement_checkbox_do_not_store', 'select', array(
            'label' => Mage::helper('webforms')->__('Don\'t store submission in the database if not checked'),
            'name' => 'gdpr_agreement_checkbox_do_not_store',
            'required' => false,
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $fieldset->addField('gdpr_agreement_checkbox_label', 'text', array(
            'label' => Mage::helper('webforms')->__('GDPR agreement checkbox label'),
            'title' => Mage::helper('webforms')->__('GDPR agreement checkbox label'),
            'name' => 'gdpr_agreement_checkbox_label',
        ));

        $fieldset->addField('gdpr_agreement_checkbox_error_text', 'textarea', array(
            'label' => Mage::helper('webforms')->__('GDPR agreement error text'),
            'title' => Mage::helper('webforms')->__('GDPR agreement error text'),
            'note' => Mage::helper('webforms')->__('This error will be displayed if the checkbox is required'),
            'name' => 'gdpr_agreement_checkbox_error_text',
        ));

        if (!Mage::registry('webforms_data')->getId()) {
            Mage::registry('webforms_data')->setData('purge_enable', '-1');
        }

        if (Mage::getSingleton('adminhtml/session')->getWebFormsData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getWebFormsData());
            Mage::getSingleton('adminhtml/session')->setWebFormsData(null);
        } elseif (Mage::registry('webforms_data')) {
            $form->setValues(Mage::registry('webforms_data')->getData());
        }

        return parent::_prepareForm();
    }
}