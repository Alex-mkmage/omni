<?php

class Ey_Protocol_Block_Adminhtml_File_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                'adminhtml/pfile/edit',
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
                'legend' => $this->__('File Details')
            )
        );

        $this->_addFieldsToFieldset($fieldset, array(
            'file_id' => array(
                'label' => $this->__('File Id'),
                'input' => 'hidden',
                'required' => false,
            ),
            'name' => array(
                'label' => $this->__('File Name'),
                'input' => 'text',
                'required' => true,
            ),
            'file_path' => array(
                'label' => $this->__('File Upload'),
                'input' => 'file'
            ),
            'created_at' => array(
                'label' => $this->__('Created At'),
                'input' => 'hidden',
                'required' => false,
            ),
            'mime_type' => array(
                'label' => $this->__('Mime Type'),
                'input' => 'hidden',
                'required' => false,
            ),
            'file_hash' => array(
                'label' => $this->__('File Hash'),
                'input' => 'hidden',
                'required' => false,
            ),
            'file_size' => array(
                'label' => $this->__('File Size'),
                'input' => 'hidden',
                'required' => false,
            ),
            'uploaded_link' => array(
                'label' => $this->__('File Link'),
                'input' => 'text',
                'class' => 'disabled',
                'required' => false,
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

        $fileLink = '';
        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                $_data['value'] = $requestValue;
            }

            $_data['name'] = "fileData[$name]";

            $_data['title'] = $_data['label'];

            if (!array_key_exists('value', $_data)) {
                if($_data['input'] == 'multiselect') {
                    $value = Mage::helper('core')->jsonDecode($this->_getFile()->getData($name));
                    $_data['value'] = $value;
                } else{
                    $_data['value'] = $this->_getFile()->getData($name);
                }
            }
            if($_data['input'] == 'file'){
                $fileLink = $this->_getFile()->getData($name);
            }
            if($name == 'uploaded_link'){
                if($fileLink != ''){
                    $_data['value'] = $fileLink;
                } else{
                    $_data['input'] = 'hidden';
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
    protected function _getFile()
    {
        if (!$this->hasData('file')) {
            $type = Mage::registry('current_file');

            if (!$type instanceof Ey_Protocol_Model_File) {
                $type = Mage::getModel(
                    'ey_protocol/file'
                );
            }

            $this->setData('file', $type);
        }

        return $this->getData('file');
    }

}