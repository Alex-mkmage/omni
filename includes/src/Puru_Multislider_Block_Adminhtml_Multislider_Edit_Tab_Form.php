<?php

class Puru_Multislider_Block_Adminhtml_Multislider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('multislider_form', array('legend'=>Mage::helper('multislider')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('multislider')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('multislider')->__('Banner image'),
          'required'  => false,
          'name'      => 'filename',
	  ));
	  
	  $fieldset->addField('thumbnail', 'file', array(
		  'label'     => Mage::helper('multislider')->__('thumbnail image'),
		  'required'  => false,
		  'name'      => 'thumbnail',
		  ));
		  
		  
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('multislider')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('multislider')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('multislider')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('multislider')->__('Content'),
          'title'     => Mage::helper('multislider')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getMultisliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMultisliderData());
          Mage::getSingleton('adminhtml/session')->setMultisliderData(null);
      } elseif ( Mage::registry('multislider_data') ) {
          $form->setValues(Mage::registry('multislider_data')->getData());
      }
      return parent::_prepareForm();
  }
}
