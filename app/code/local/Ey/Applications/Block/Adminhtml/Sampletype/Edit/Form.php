<?php

class Ey_Applications_Block_Adminhtml_Sampletype_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                'adminhtml/sampletype/edit',
                array(
                    '_current' => true,
                    'continue' => 0,
                )
            ),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('Sample Type Details')
            )
        );

        $this->_addFieldsToFieldset($fieldset, array(
            'name' => array(
                'label' => $this->__('Name'),
                'input' => 'text',
                'required' => true,
            )
        ));

        return $this;
    }

    /**
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     * @param $fields
     * @return $this
     * @throws Exception
     */
    protected function _addFieldsToFieldset(Varien_Data_Form_Element_Fieldset $fieldset, $fields)
    {
        $requestData = new Varien_Object($this->getRequest()
            ->getPost('sampletypeData'));

        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                $_data['value'] = $requestValue;
            }

            $_data['name'] = "sampletypeData[$name]";

            $_data['title'] = $_data['label'];

            if (!array_key_exists('value', $_data)) {
                if($_data['input'] == 'multiselect') {
                    $value = Mage::helper('core')->jsonDecode($this->_getApplication()->getData($name));
                    $_data['value'] = $value;
                } else{
                    $_data['value'] = $this->_getApplication()->getData($name);
                }
            }

            $fieldset->addField($name, $_data['input'], $_data);
        }

        return $this;
    }

    /**
     * Retrieve the existing brand for pre-populating the form fields.
     * For a new brand entry this will return an empty Brand object.
     *
     * @return mixed
     */
    protected function _getApplication()
    {
        if (!$this->hasData('sampletype')) {
            $type = Mage::registry('current_sample_type');

            if (!$type instanceof Ey_Applications_Model_Sampletype) {
                $type = Mage::getModel(
                    'ey_applications/sampletype'
                );
            }

            $this->setData('sampletype', $type);
        }

        return $this->getData('sampletype');
    }

}