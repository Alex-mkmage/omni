<?php
class Ey_Distributor_Block_Adminhtml_Distributor_Edit_Tab_Main extends IWD_StoreLocator_Block_Adminhtml_List_Edit_Tab_Main implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {

        Mage::getModel('storelocator/image')->clearCache();

        /* @var $model IWD_StoreLocator_Model_Stores */
        $model = Mage::registry('storelocator_store');


        $isElementDisabled = false;

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('storelocator')->__('Store Information')));

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', array(
                'name' => 'entity_id',
            ));
        }


        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('cms')->__('Store View'),
                'title' => Mage::helper('cms')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return $this;
    }


}
