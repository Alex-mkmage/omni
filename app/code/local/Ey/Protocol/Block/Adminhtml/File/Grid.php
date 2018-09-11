<?php

class Ey_Protocol_Block_Adminhtml_File_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('file_grid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel(
            'ey_protocol/file_collection'
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
            'adminhtml/pfile/edit',
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
        $this->addColumn('created_at', array(
            'header' => $this->_getHelper()->__('Created'),
            'type' => 'datetime',
            'index' => 'created_at',
        ));
        $this->addColumn('name', array(
            'header' => $this->_getHelper()->__('File Name'),
            'type' => 'text',
            'index' => 'name',
        ));
        $this->addColumn('file_id', array(
            'header' => $this->_getHelper()->__('File Id'),
            'type' => 'text',
            'index' => 'file_id',
        ));
        $this->addColumn('mime_type', array(
            'header' => $this->_getHelper()->__('Mime Type'),
            'type' => 'text',
            'index' => 'mime_type',
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
                            . '/pfile/edit',
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