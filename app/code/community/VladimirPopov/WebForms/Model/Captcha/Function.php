<?php
class VladimirPopov_WebForms_Model_Captcha_Function
{
    public function toOptionArray(){
        $options = array(
            array('value' => 'curl' , 'label' => Mage::helper('webforms')->__('cURL')),
            array('value' => 'file_get_contents' , 'label' => Mage::helper('webforms')->__('file_get_contents')),
        );
        return $options;
    }
}