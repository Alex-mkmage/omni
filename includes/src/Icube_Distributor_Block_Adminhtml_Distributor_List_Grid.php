<?php

class Icube_Distributor_Block_Adminhtml_Distributor_List_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();

				$this->setId("icube_list_grid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("ASC");
		        $this->setSaveParametersInSession(true);
		        // $this->setUseAjax(true);
        }

		protected function _prepareCollection()
		{
//				$collection = Mage::getResourceModel($this->_getCollectionClass());
				$collection = Mage::getModel("distributor/distributor")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}


		protected function _prepareColumns()
		{
			// $helper = Mage::helper('distributor');
				$this->addColumn("id", array(
				"header" => Mage::helper("distributor")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("title", array(
				"header" => Mage::helper("distributor")->__("Title"),
				"index" => "title",
				));
						$this->addColumn('active', array(
						'header' => Mage::helper('distributor')->__('Active'),
						'index' => 'active',
						'type' => 'options',
						'options'=>Icube_Distributor_Block_Adminhtml_Distributor_List_Grid::getOptionArray3(),				
						));
						
				$this->addColumn("phone", array(
				"header" => Mage::helper("distributor")->__("Phone"),
				"index" => "phone",
				));
				$this->addColumn("country_code", array(
				"header" => Mage::helper("distributor")->__("Country Code"),
				"index" => "country_code",
				));
				$this->addColumn("region", array(
				"header" => Mage::helper("distributor")->__("Region"),
				"index" => "region",
				));

				$this->addColumn("website", array(
				"header" => Mage::helper("distributor")->__("Website"),
				"index" => "website",
				));

				$this->addColumn('action',
				array(
				          'header' => Mage::helper('distributor')->__('Action'),
				          'width' => '100',
				          'type' => 'action',
				          'getter' => 'getId',
				          'actions' => array(
				                 array(
				                      'caption' => Mage::helper('distributor')->__('View'),
				                      'url' => array('base'=> '*/*/edit'),
				                      'field' => 'id'
				                    )),
				          'filter' => false,
				          'sortable' => false,
				          'index' => 'stores',
				          'is_system' => true,
				));


				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_distributor', array(
					 'label'=> Mage::helper('distributor')->__('Remove distributor'),
					 'url'  => $this->getUrl('*/distributor/massRemove'),
					 'confirm' => Mage::helper('distributor')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray3()
		{
            $data_array=array(); 
			$data_array[0]='disable';
			$data_array[1]='active';
            return($data_array);
		}
		static public function getValueArray3()
		{
            $data_array=array();
			foreach(Icube_Distributor_Block_Adminhtml_Distributor_Grid::getOptionArray3() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}

}