<?php

class Ey_Protocol_Block_Adminhtml_Application_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl(
                'adminhtml/papplication/edit',
                array(
                    '_current' => true,
                    'continue' => 0,
                )
            ),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $app = Mage::registry('current_application');

        if ($app->getId()) {
            $form->addField('entity_id', 'hidden', array(
                'name' => 'application_id',
            ));
            $form->setValues($app->getData());
        }

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}