<?php

class Icube_OrderNotifier_Model_Observer extends Mage_Core_Helper_Abstract
{
    public function sendNotificationEmailToAdmin($observer)
    {
        $order = $observer->getEvent()->getOrder();
        $storeId = $order->getStoreId();

        $helper = Mage::helper('icube_orderNotifier');

        if (!$helper->isModuleEnabled($storeId)) {
            return;
        }

        try {
            $templateId = $helper->getEmailTemplate($storeId);

            $mailer = Mage::getModel('core/email_template_mailer');

            foreach ($helper->getNotifyEmails() as $entry) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($entry['email'], $entry['name']);
                $mailer->addEmailInfo($emailInfo);
            }

            $mailer->setSender(array(
                'name' => $helper->getStoreEmailAddressSenderOption('general', 'name'),
                'email' => $helper->getStoreEmailAddressSenderOption('general', 'email'),
            ));

            $mailer->setStoreId($storeId);
            $mailer->setTemplateId($templateId);
            $mailer->setTemplateParams(array(
                'order' => $order,
            ));

            $mailer->send();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}
