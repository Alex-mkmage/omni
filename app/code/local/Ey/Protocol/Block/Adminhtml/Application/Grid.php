<?php

class Ey_Protocol_Block_Adminhtml_Application_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('application_grid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel(
            'ey_protocol/application_collection'
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
        return $this->getUrl(
            'adminhtml/papplication/edit',
            array(
                'id' => $row->getId()
            )
        );
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => $this->_getHelper()->__('Entity Id'),
            'type' => 'text',
            'index' => 'entity_id',
        ));

        $this->addColumn('application_id', array(
            'header' => $this->_getHelper()->__('Document Id'),
            'type' => 'text',
            'index' => 'application_id',
        ));

        $this->addColumn('created_at', array(
            'header' => $this->_getHelper()->__('Created'),
            'type' => 'datetime',
            'index' => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header' => $this->_getHelper()->__('Updated'),
            'type' => 'datetime',
            'index' => 'updated_at',
        ));

        $this->addColumn('name', array(
            'header' => $this->_getHelper()->__('Name'),
            'type' => 'text',
            'index' => 'name',
        ));

        /** @var Ey_Protocol_Model_Application $appSingleton */
        $appSingleton = Mage::getSingleton('ey_protocol/application');
        /** @var Ey_Protocol_Model_Sampletype $typeSingleton */
        $typeSingleton = Mage::getSingleton('ey_protocol/sampletype');
        $this->addColumn('is_featured', array(
            'header' => $this->_getHelper()->__('Featured'),
            'type' => 'options',
            'index' => 'is_featured',
            'options' => array('1' => 'Yes', '0' => 'No')
        ));
        $this->addColumn('visibility', array(
            'header' => $this->_getHelper()->__('Visibility'),
            'type' => 'options',
            'index' => 'visibility',
            'options' => $appSingleton->getAvailableVisibilies()
        ));

        $this->addColumn('sample_type', array(
            'header' => $this->_getHelper()->__('Sample Type'),
            'type' => 'options',
            'index' => 'sample_type',
            'options' => $typeSingleton->getSampleTypes()
        ));

        $this->addColumn('action', array(
            'header' => $this->_getHelper()->__('Action'),
            'width' => '50px',
            'type' => 'action',
            'actions' => array(
                array(
                    'caption' => $this->_getHelper()->__('Edit'),
                    'url' => array(
                        'base' => 'adminhtml'
                            . '/papplication/edit',
                    ),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'entity_id',
        ));

        return parent::_prepareColumns();
    }

    protected function _getHelper()
    {
        return Mage::helper('ey_protocol');
    }


}