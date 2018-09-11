<?php

class Ey_Distributor_Block_Adminhtml_Distributor_Edit_Tabs extends Icube_Distributor_Block_Adminhtml_Distributor_Edit_Tabs
{
    protected function _beforeToHtml()
    {
        $this->_prepareStoreLocator();

        $this->addTab('form_section', array(
            'label'     => Mage::helper('distributor')->__('Distributor Information'),
            'title'     => Mage::helper('distributor')->__('Distributor Information'),
            'content'   => $this->getLayout()->createBlock('distributor/adminhtml_distributor_edit_tab_form')->toHtml(),
        ));

        $this->addTab('distributor_storelocator_store_edit_tab_main', array(
            'label'     => Mage::helper('distributor')->__('Store Information'),
            'title'     => Mage::helper('distributor')->__('Store Information'),
            'content'   => $this->getLayout()->createBlock('ey_distributor/adminhtml_distributor_edit_tab_main')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }


    public function _prepareStoreLocator()
    {
        $distributor = Mage::registry("distributor_data");
        $storeId = $distributor->getStoreLocatorId();
        /* @var $model IWD_StoreLocator_Model_Stores */
        $model = Mage::getModel('storelocator/stores')->load($storeId);

        if($model->getId()){
            $distributor->setLatitude($model->getLatitude())
                ->setLongitude($model->getLongitude());
            Mage::unregister('distributor_data');
            Mage::register("distributor_data", $distributor);
        }

        Mage::register('storelocator_store', $model);
    }

}