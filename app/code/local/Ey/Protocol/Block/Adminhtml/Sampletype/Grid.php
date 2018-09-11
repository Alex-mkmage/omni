<?php

class Ey_Protocol_Block_Adminhtml_Sampletype_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sample_type_grid');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel(
            'ey_protocol/sampletype_collection'
        );
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl(
            'adminhtml/psampletype/edit',
            array(
                'id' => $row->getId()
            )
        );
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => $this->_getHelper()->__('ID'),
            'type' => 'number',
            'index' => 'entity_id',
        ));
        $this->addColumn('name', array(
            'header' => $this->_getHelper()->__('Name'),
            'type' => 'text',
            'index' => 'name',
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
                            . '/psampletype/edit',
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