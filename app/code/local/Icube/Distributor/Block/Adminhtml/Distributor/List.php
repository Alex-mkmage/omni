<?php
class Icube_Distributor_Block_Adminhtml_Distributor_List extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'distributor';
        $this->_controller = 'adminhtml_distributor_list';
        $this->_headerText = Mage::helper('distributor')->__('Distributor List');
	 	$this->_addButtonLabel = Mage::helper("distributor")->__("Add Distributor");
        parent::__construct();
    }
}