<?php

class Ey_Applications_Helper_Email extends Mage_Core_Helper_Abstract
{
    /**
     * @var string
     */
    protected $_email = 'jatwood@omni-inc.com';
    //protected $_email = 'yulianto@icube.us';
    //protected $_email = 'kornchaia@eystudios.com';

    /**
     * @var string
     */
    protected $_secondary_email = 'sgarrett@omni-inc.com';

    public function isEmailEnabled()
    {
        return Mage::getStoreConfig('ey_applications/email/activate', Mage::app()->getStore());
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getSecondaryEmail()
    {
        return $this->_secondary_email;
    }

    /**
     * @return array
     */
    public function getEmails()
    {
        $emails = array($this->_email, $this->getSecondaryEmail());
        return $emails;
    }

    /**
     * @param $emailTemplateVariables
     * @return bool
     */
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
                ->setSubject('Omni - New Application Alert')
                //->setFromEmail($senderEmail)
                //->setFromName($senderName)
                ->setType('text');
            try{
                //Confimation E-Mail Send
                //$mail->send();

                mail($this->getEmail(), 'Omni - New Application Alert', $processedTemplate);
                mail($this->getSecondaryEmail(), 'Omni - New Application Alert', $processedTemplate);
                return true;
            }
            catch(Exception $error)
            {
                Mage::getSingleton('core/session')->addError($error->getMessage());
                return false;
            }
        }

        return false;
    }
}
