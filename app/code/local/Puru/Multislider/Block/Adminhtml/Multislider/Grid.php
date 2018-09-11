<?php

class Puru_Multislider_Block_Adminhtml_Multislider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('multisliderGrid');
      $this->setDefaultSort('multislider_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('multislider/multislider')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('multislider_id', array(
          'header'    => Mage::helper('multislider')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'multislider_id',
      ));
	  
	  
	  $this->addColumn('filename', array(
            'header' => Mage::helper('multislider')->__('banner Image'),
            'align' => 'center',
            'index' => 'filename',
            'type' => 'banner',
            'escape' => true,
            'sortable' => false,
            'width' => '150px',
        ));

$this->addColumn('thumbnail', array(
            'header' => Mage::helper('multislider')->__('thumbnail Image'),
            'align' => 'center',
            'index' => 'thumbnail',
            'type' => 'banner',
            'escape' => true,
            'sortable' => false,
            'width' => '150px',
        ));
	  
	  
	  

      $this->addColumn('title', array(
          'header'    => Mage::helper('multislider')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	  
      $this->addColumn('content', array(
			'header'    => Mage::helper('multislider')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  

      $this->addColumn('status', array(
          'header'    => Mage::helper('multislider')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('multislider')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('multislider')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('multislider')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('multislider')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('multislider_id');
        $this->getMassactionBlock()->setFormFieldName('multislider');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('multislider')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('multislider')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('multislider/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('multislider')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('multislider')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}

