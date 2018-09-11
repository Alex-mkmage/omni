<?php

class Ey_Report_Block_Adminhtml_Filter extends Mage_Adminhtml_Block_Report_Filter_Form
{
    /**
     * Add fieldset with general report fields
     *
     * @return Mage_Adminhtml_Block_Report_Filter_Form
     */
    protected function _prepareForm()
    {
        $actionUrl = $this->getUrl('*/*/shipping');
        $form = new Varien_Data_Form(
            array('id' => 'filter_form', 'action' => $actionUrl, 'method' => 'get')
        );
        $htmlIdPrefix = 'products_report_';
        $form->setHtmlIdPrefix($htmlIdPrefix);
        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('reports')->__('Filter')));

        $fieldset->addField('box_type', 'select', array(
            'name' => 'box_type',
            'options' => array(
                'singleboxes_id'   => Mage::helper('ey_report')->__('Single Box'),
                'shipboxes_id' => Mage::helper('ey_report')->__('Multiple Shipping Box'),
                'flatboxes_id'  => Mage::helper('ey_report')->__('USPS Flat Shipping Box')
            ),
            'label' => Mage::helper('reports')->__('Box Type'),
            'title' => Mage::helper('reports')->__('Box Type')
        ));

        $fieldset->addField('id_from', 'text', array(
            'name'      => 'id_from',
            'label'     => Mage::helper('ey_report')->__('Box ID From'),
            'title'     => Mage::helper('ey_report')->__('Box ID From')
        ));

        $fieldset->addField('id_to', 'text', array(
            'name'      => 'id_to',
            'label'     => Mage::helper('ey_report')->__('Box ID To'),
            'title'     => Mage::helper('ey_report')->__('Box ID To')
        ));

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('ey_report')->__('Box Title'),
        ));

        $fieldset->addField('sku', 'text', array(
            'name'      => 'sku',
            'label'     => Mage::helper('ey_report')->__('Product SKU'),
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return $this;
    }
}
