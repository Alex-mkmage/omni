<?php

class Icube_Distributor_Block_Adminhtml_Distributor_Upload_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/doUpload'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('distributor')->__('File')));
        $fieldset->addField('upload_file', 'file', array(
            'name'     =>Mage::helper('distributor')->__('upload_file'),
            'label'    => Mage::helper('distributor')->__('Select File'),
            'title'    => Mage::helper('distributor')->__('Select File'),
            'required' => true
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}