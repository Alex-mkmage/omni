<?php

class Ey_Contact_Block_Adminhtml_Contact_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('contact_grid');
        $this->setDefaultSort('send_at');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare grid massaction actions
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('contact_id');
        $this->getMassactionBlock()->setFormFieldName('contact_id');

        $this->getMassactionBlock()->addItem('mass_action_delete', array(
            'label'    => Mage::helper('ey_contact')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete', array('' => '')),
            'selected' => true,
            'confirm' => Mage::helper('ey_contact')->__('Are you sure?')
        ));

        return $this;
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel(
            'ey_contact/contact_collection'
        );
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return '#';
    }

    protected function _prepareColumns()
    {
        $this->addColumn('send_at', array(
            'header' => $this->_getHelper()->__('Timestamp'),
            'type' => 'text',
            'index' => 'send_at',
        ));
        $this->addColumn('category', array(
            'header' => $this->_getHelper()->__('Category'),
            'type' => 'text',
            'index' => 'category',
        ));
        $this->addColumn('name', array(
            'header' => $this->_getHelper()->__('Name'),
            'type' => 'text',
            'index' => 'name',
        ));
        $this->addColumn('email', array(
            'header' => $this->_getHelper()->__('Email'),
            'type' => 'text',
            'index' => 'email',
        ));
        $this->addColumn('phone', array(
            'header' => $this->_getHelper()->__('Telephone'),
            'type' => 'text',
            'index' => 'phone',
        ));
        $this->addColumn('company', array(
            'header' => $this->_getHelper()->__('Company'),
            'type' => 'text',
            'index' => 'company',
        ));
        $this->addColumn('service_requested', array(
            'header' => $this->_getHelper()->__('Service'),
            'type' => 'text',
            'index' => 'service_requested',
        ));
        $this->addColumn('find', array(
            'header' => $this->_getHelper()->__('Find'),
            'type' => 'text',
            'index' => 'find',
        ));

        return parent::_prepareColumns();
    }

    protected function _getHelper()
    {
        return Mage::helper('ey_contact');
    }


}