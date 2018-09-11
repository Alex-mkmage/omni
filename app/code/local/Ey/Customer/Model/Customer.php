<?php

class Ey_Customer_Model_Customer extends Mage_Customer_Model_Customer
{
    const XML_PATH_APP_EMAIL_TEMPLATE = 'customer/application/email_template';

    const XML_PATH_APP_NOTIFY_EMAIL_TEMPLATE = 'customer/application/notify_email_template';

    const XML_PATH_APP_NOTIFY_EMAIL_SEND_TO = 'customer/application/send_to';

    /**
     * Send email with new account related information
     *
     * @param string $type
     * @param string $backUrl
     * @param string $storeId
     * @throws Mage_Core_Exception
     * @return Mage_Customer_Model_Customer
     */
    public function sendNewAccountEmail($type = 'registered', $backUrl = '', $storeId = '0')
    {
        $types = array(
            'registered'   => self::XML_PATH_REGISTER_EMAIL_TEMPLATE,
            'confirmed'    => self::XML_PATH_CONFIRMED_EMAIL_TEMPLATE,
            'confirmation' => self::XML_PATH_CONFIRM_EMAIL_TEMPLATE,
            'application' => self::XML_PATH_APP_EMAIL_TEMPLATE
        );
        if (!isset($types[$type])) {
            Mage::throwException(Mage::helper('customer')->__('Wrong transactional account email type'));
        }

        if (!$storeId) {
            $storeId = $this->_getWebsiteStoreId($this->getSendemailStoreId());
        }

        $this->_sendEmailTemplate($types[$type], self::XML_PATH_REGISTER_EMAIL_IDENTITY,
            array('customer' => $this, 'back_url' => $backUrl), $storeId);

        return $this;
    }

    /**
     * @param string $type
     * @param string $backUrl
     * @param string $storeId
     * @return Mage_Customer_Model_Customer
     */
    public function applicationAccountCreationNotify($backUrl = '', $storeId = '0')
    {
        $type = self::XML_PATH_APP_NOTIFY_EMAIL_TEMPLATE;
        if (!$storeId) {
            $storeId = $this->_getWebsiteStoreId($this->getSendemailStoreId());
        }

        $this->_sendAppNotifyEmail($type, self::XML_PATH_REGISTER_EMAIL_IDENTITY,
            self::XML_PATH_APP_NOTIFY_EMAIL_SEND_TO,
            array('customer' => $this, 'back_url' => $backUrl), $storeId);

        return $this;
    }

    /**
     * @param $template
     * @param $sender
     * @param array $templateParams
     * @param null $storeId
     * @return Mage_Customer_Model_Customer
     */
    protected function _sendAppNotifyEmail($template, $sender, $sendto, $templateParams = array(), $storeId = null)
    {
        /** @var $mailer Mage_Core_Model_Email_Template_Mailer */
        $mailer = Mage::getModel('core/email_template_mailer');
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo(Mage::getStoreConfig($sendto, $storeId), 'Admin');
        $mailer->addEmailInfo($emailInfo);

        // Set all required params and send emails
        $mailer->setSender(Mage::getStoreConfig($sender, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId(Mage::getStoreConfig($template, $storeId));
        $mailer->setTemplateParams($templateParams);
        $mailer->send();
        return $this;
    }
}