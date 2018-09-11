<?php
 
class Icube_Distributor_Block_Adminhtml_Distributor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
        protected function _prepareForm()
        {

                $form = new Varien_Data_Form();
                $this->setForm($form);

                Mage::log(Mage::registry("distributor_data"));

                $fieldset = $form->addFieldset("distributor_form", 
                    array("legend"=>Mage::helper('distributor')->__("Item information")));


                $fieldset->addField("id", "text", array(
                "label" => Mage::helper('distributor')->__("Id"),                 
                "class" => "required-entry",
                "required" => true,
                "name" => "id",
                "disabled" => true
                ));

                $fieldset->addField("active", "select", array(
                "label" => Mage::helper("distributor")->__("Active"),                 
                "class" => "required-entry",
                "required" => true,
                "name" => "active",
                "values" => array('0'=>'Disable', '1'=>'Active')
                ));

            
                $fieldset->addField("title", "text", array(
                "label" => Mage::helper('distributor')->__("Title"),                  
                "class" => "required-entry",
                "required" => true,
                "name" => "title",
                ));

                $fieldset->addField("phone", "text", array(
                "label" => Mage::helper('distributor')->__("Phone"),
                "name" => "phone",
                "required" => true,
                "value" => '0000000'
                ));
            
                $fieldset->addField("country_code", "select", array(
                "label" => Mage::helper('distributor')->__("Country Code"),
                "name" => "country_code",
                "values" => Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
                "required" => true,
                ));
            
                $fieldset->addField("region", "text", array(
                "label" => Mage::helper('distributor')->__("Region"),
                "name" => "region",
                "required" => true,
                ));
            
                $fieldset->addField("street", "textarea", array(
                "label" => Mage::helper('distributor')->__("Address"),
                "name" => "street",
                "required" => true,
                ));

                $fieldset->addField("city", "textarea", array(
                "label" => Mage::helper('distributor')->__("City"),
                "name" => "city",
                "required" => true,
                ));

                $fieldset->addField("postal_code", "text", array(
                "label" => Mage::helper("distributor")->__("Postal Code"),                    
                "class" => "required-entry",
                "required" => true,
                "name" => "postal_code",
                "value" => '0000'                
                ));

                $fieldset->addField("desc", "textarea", array(
                "label" => Mage::helper('distributor')->__("Description"),
                "name" => "desc",
                ));
            
                $fieldset->addField("website", "text", array(
                "label" => Mage::helper('distributor')->__("Website"),
                "name" => "website",
                ));

                $fieldset->addField("latitude", "text", array(
                "label" => Mage::helper('distributor')->__("Latitude"),
                "name" => "latitude",
                ));
                $fieldset->addField("longitude", "text", array(
                "label" => Mage::helper('distributor')->__("Longitude"),
                "name" => "longitude",
                ));

                $fieldset->addField("icon", "image", array(
                "label" => Mage::helper("distributor")->__("Icon"),
                "name" => "icon",
                "value" => "Upload"
                ));

                $fieldset->addField("image", "image", array(
                "label" => Mage::helper("distributor")->__("Image"),
                "name" => "image",
                "value" => "Upload"
                ));            

           
                $fieldset->addField("position", "text", array(
                "label" => Mage::helper("distributor")->__("Position"),
                "name" => "position",
                ));


                if (Mage::getSingleton("adminhtml/session")->getDistributorData())
                {
                    $form->setValues(Mage::getSingleton("adminhtml/session")->getDistributorData());
                    Mage::getSingleton("adminhtml/session")->setDistributorData(null);
                } 
                elseif(Mage::registry("distributor_data")) {
                    $form->setValues(Mage::registry("distributor_data")->getData());
                }
                return parent::_prepareForm();
        }
}