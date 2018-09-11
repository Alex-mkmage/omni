<?php

class Ey_Protocol_Block_Adminhtml_Application_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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
                'legend' => $this->__('Application Details')
            )
        );

        $fieldset->addType('image', 'Ey_Protocol_Block_Adminhtml_Application_Helper_Image');

        /** @var Ey_Protocol_Model_Application $appSingleton */
        $appSingleton = Mage::getSingleton('ey_protocol/application');
        /** @var Ey_Protocol_Model_Sampletype $typeSingleton */
        $typeSingleton = Mage::getSingleton('ey_protocol/sampletype');
        /** @var Ey_Protocol_Model_Product $productSingleton */
        $productSingleton = Mage::getSingleton('ey_protocol/product');
        /** @var Ey_Protocol_Model_Tag $tagSingleton */
        $tagSingleton = Mage::getSingleton('ey_protocol/tag');
        /** @var Mage_Cms_Model_Wysiwyg_Config $wysiwygConfig */
        $wysiwygConfig = Mage::getModel('cms/wysiwyg_config');
        $this->_addFieldsToFieldset($fieldset, array(
            'name' => array(
                'label' => $this->__('Name'),
                'input' => 'text',
                'required' => true,
            ),
            'is_featured' => array(
                'label' => $this->__('Is Featured?'),
                'input' => 'select',
                'options' => array('1' => 'Yes', '0' => 'No'),
                'required' => true
            )
        ));

        if($app = $this->_getApplication()){
            if($app->getImageName() != ''){
                $this->_addFieldsToFieldset($fieldset, array(
                    'image_name' => array(
                        'label' => $this->__('Image'),
                        'input' => 'image',
                        'required' => false,
                        'note' => 'Image must not be larger than 2MB. Allow \'jpg\',\'jpeg\',\'gif\',\'png\'.'
                    )
                ));
            } else{
                $this->_addFieldsToFieldset($fieldset, array(
                    'image_name' => array(
                        'label' => $this->__('Image'),
                        'input' => 'image',
                        'class' => 'required-entry input-file required-file',
                        'required' => true,
                        'note' => 'Image must not be larger than 2MB. Allow \'jpg\',\'jpeg\',\'gif\',\'png\'.'
                    )
                ));
            }
        }


        $this->_addFieldsToFieldset($fieldset, array(
            'sort_order' => array(
                'label' => $this->__('Sort Order'),
                'input' => 'text',
                'required' => true,
                'value' => 0
            ),
            'created_at' => array(
                'label' => $this->__('Created At'),
                'input' => 'date',
                'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'required' => true,
            ),
            'procedure' => array(
                'label' => $this->__('Procedure'),
                'input' => 'editor',
                'required' => false,
                'wysiwyg' => true,
                'style' => "height:260px;width:960px;",
                'config'    => $wysiwygConfig->getConfig()
            )
        ));

        $user = Mage::getSingleton('admin/session');
        if($user->getUser()->getEmail() == Mage::helper('ey_protocol/email')->getEmail()){
        //if(true){
            $this->_addFieldsToFieldset($fieldset, array(
                'visibility' => array(
                    'label' => $this->__('Visibility'),
                    'input' => 'select',
                    'required' => true,
                    'options' => $appSingleton->getAvailableVisibilies(),
                )
            ));
        } else{
            $this->_addFieldsToFieldset($fieldset, array(
                'visibility' => array(
                    'label' => $this->__('Visibility'),
                    'input' => 'select',
                    'required' => true,
                    'class' => 'disabled',
                    'disabled' => true,
                    'options' => $appSingleton->getAvailableVisibilies()
                )
            ));
        }


        $this->_addFieldsToFieldset($fieldset, array(
            $typeSingleton->getEventId() => array(
                'label' => $this->__('Sample Type'),
                'input' => 'select',
                'required' => true,
                'options' => $typeSingleton->getSampleTypes(),
            ),
            $productSingleton->getEventId() => array(
                'label' => $this->__('Products Used'),
                'comment' => 'Product SKUs, separated by a comma.',
                'input' => 'text',
                'required' => false,
                'class' => 'tagItSku'
            ),
            $tagSingleton->getEventId() => array(
                'label' => $this->__('Tags'),
                'comment' => 'Separated by a comma.',
                'input' => 'text',
                'required' => false,
                'class' => 'tagIt'
            ),
            'sample_amount' => array(
                'label' => $this->__('Sample amount'),
                'input' => 'text',
                'required' => false
            ),
            'type' => array(
                'label' => $this->__('Type of the document'),
                'input' => 'text',
                'required' => false
            ),
            'year' => array(
                'label' => $this->__('Year'),
                'input' => 'text',
                'required' => false
            ),
            'website' => array(
                'label' => $this->__('Website'),
                'input' => 'text',
                'required' => false
            ),
            'analyte' => array(
                'label' => $this->__('Analyte'),
                'input' => 'editor',
                'required' => false,
                'wysiwyg' => true,
                'style' => "height:260px;width:960px;",
                'config'    => $wysiwygConfig->getConfig()
            )
        ));

        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap('is_featured', 'is_featured')
            ->addFieldMap('image_name', 'image_name')
            ->addFieldDependence(
                'image_name',
                'is_featured',
                '1'
            )
        );

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
            ->getPost('applicationData'));

        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                if($_data['input'] == 'image' && is_array($requestValue)){
                    $_data = array_merge($_data, $requestValue);
                } else{
                    $_data['value'] = $requestValue;
                }
            }

            $_data['name'] = "applicationData[$name]";

            $_data['title'] = $_data['label'];

            if (!array_key_exists('value', $_data)) {
                /** @var Ey_Protocol_Model_Product $productSingleton */
                $productSingleton = Mage::getSingleton('ey_protocol/product');
                /** @var Ey_Protocol_Model_Tag $tagSingleton */
                $tagSingleton = Mage::getSingleton('ey_protocol/tag');
                /** @var Ey_Protocol_Model_Sampletype $typeSingleton */
                $typeSingleton = Mage::getSingleton('ey_protocol/sampletype');

                if($_data['input'] == 'multiselect') {
                    $value = Mage::helper('core')->jsonDecode($this->_getApplication()->getData($name));
                    $_data['value'] = $value;
                } elseif($name == $typeSingleton->getEventId()) {
                    $_data['value'] = $this->_getSampleType();
                } elseif($name == $productSingleton->getEventId()) {
                    $_data['value'] = implode(',', $this->_getProductUsed());
                } elseif($name == $tagSingleton->getEventId()) {
                    $_data['value'] = implode(',', $this->_getTags());
                } else {
                    $_data['value'] = $this->_getApplication()->getData($name);
                }
            }

            $fieldset->addField($name, $_data['input'], $_data);
        }

        return $this;
    }

    protected function _getApplication()
    {
        if (!$this->hasData('application')) {
            $app = Mage::registry('current_application');

            if (!$app instanceof Ey_Protocol_Model_Application) {
                $app = Mage::getModel(
                    'ey_protocol/application'
                );
            }

            $this->setData('application', $app);
        }

        return $this->getData('application');
    }

    protected function _getSampleType()
    {
        $appId = $this->_getApplication()->getId();
        $types = Mage::getModel('ey_protocol/type')
            ->getCollection()
            ->addFieldToFilter('application_id', $appId);
        $toArray = array();
        if($types->getSize()){
            foreach ($types as $type){
                $toArray[] = $type->getSampletypeId();
            }
        }

        return $toArray;
    }

    protected function _getProductUsed()
    {
        $appId = $this->_getApplication()->getId();
        $tags = Mage::getModel('ey_protocol/product')
            ->getCollection()
            ->addFieldToFilter('application_id', $appId);
        $toArray = array();
        if($tags->getSize()){
            foreach ($tags as $tag){
                $toArray[] = $tag->getSku();
            }
        }

        return $toArray;
    }

    protected function _getTags()
    {
        $appId = $this->_getApplication()->getId();
        $tags = Mage::getModel('ey_protocol/tag')
            ->getCollection()
            ->addFieldToFilter('application_id', $appId);
        $toArray = array();
        if($tags->getSize()){
            foreach ($tags as $tag){
                $toArray[] = $tag->getName();
            }
        }

        return $toArray;
    }

}