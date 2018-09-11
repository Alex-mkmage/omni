<?php
class VladimirPopov_WebForms_Model_Result_Permissions
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'add', 'label'=>Mage::helper('webforms')->__('Add')),
            array('value' => 'view', 'label'=>Mage::helper('webforms')->__('View')),
            array('value' => 'edit', 'label'=>Mage::helper('webforms')->__('Edit')),
            array('value' => 'delete', 'label'=>Mage::helper('webforms')->__('Delete')),
            array('value' => 'print', 'label'=>Mage::helper('webforms')->__('Print')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'add' => Mage::helper('webforms')->__('Add'),
            'view' => Mage::helper('webforms')->__('View'),
            'edit' => Mage::helper('webforms')->__('Edit'),
            'delete' => Mage::helper('webforms')->__('Delete'),
            'print' => Mage::helper('webforms')->__('Print'),
        );
    }

}
