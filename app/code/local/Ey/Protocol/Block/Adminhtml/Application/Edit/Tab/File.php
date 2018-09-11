<?php

class Ey_Protocol_Block_Adminhtml_Application_Edit_Tab_File extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('File Details')
            )
        );

        $this->_addFieldsToFieldset($fieldset, array(
            'name' => array(
                'label' => $this->__('File Name'),
                'input' => 'text',
                'required' => false,
            ),
            'file_path' => array(
                'label' => $this->__('File Upload'),
                'input' => 'file'
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
            ->getPost('fileData'));

        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                if($_data['input'] == 'image' && is_array($requestValue)){
                    $_data = array_merge($_data, $requestValue);
                } else{
                    $_data['value'] = $requestValue;
                }
            }

            $_data['name'] = "fileData[$name]";

            $_data['title'] = $_data['label'];

            $fieldset->addField($name, $_data['input'], $_data);
        }

        return $this;
    }

}