<?php

class Puru_Multislider_Block_Adminhtml_Multislider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'multislider';
        $this->_controller = 'adminhtml_multislider';
        
        $this->_updateButton('save', 'label', Mage::helper('multislider')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('multislider')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('multislider_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'multislider_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'multislider_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('multislider_data') && Mage::registry('multislider_data')->getId() ) {
            return Mage::helper('multislider')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('multislider_data')->getTitle()));
        } else {
            return Mage::helper('multislider')->__('Add Item');
        }
    }
}
