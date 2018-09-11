<?php

class Ey_Protocol_Helper_Email extends Mage_Core_Helper_Abstract
{
    /**
     * @var string
     */
    protected $_email = 'jatwood@omni-inc.com';
    //protected $_email = 'kornchaia@eystudios.com';

    public function isEmailEnabled()
    {
        return Mage::getStoreConfig('ey_protocol/email/activate', Mage::app()->getStore());
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    public function send($emailTemplateVariables)
    {
        if($this->isEmailEnabled()){
            $emailTemplate = Mage::getModel('core/email_template')->loadDefault('new_application_notification');

            $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
            $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

            $mail = Mage::getModel('core/email')
                //->setToName($senderName)
                ->setToEmail($this->getEmail())
                ->setBody($processedTemplate)
                ->setSubject('Omni - New Protocol Application Alert')
                //->setFromEmail($senderEmail)
                //->setFromName($senderName)
                ->setType('text');
            try{
                //Confimation E-Mail Send
                //$mail->send();

                mail($this->getEmail(), 'Omni - New Protocol Application Alert', $processedTemplate);
                return true;
            }
            catch(Exception $error)
            {
                Mage::getSingleton('core/session')->addError($error->getMessage());
                return false;
            }
        }
    }
}