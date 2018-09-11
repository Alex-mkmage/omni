<?php
class Icube_Distributor_Block_Adminhtml_Distributor_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{
				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "distributor";
				$this->_controller = "adminhtml_distributor";

				$this->_formScripts[] = "
							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("distributor_data") && Mage::registry("distributor_data")->getId() ){
				    return Mage::helper("distributor")->__($this->htmlEscape(Mage::registry("distributor_data")->getTitle()));

				} 
				else{

				     return Mage::helper("distributor")->__("Add Item");

				}
		}
}