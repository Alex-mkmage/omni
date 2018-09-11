<?php

/**
 * Class Ey_Applications_Model_Observer
 */
class Ey_Applications_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function afterFileDownloaded($observer)
    {
        if(Mage::helper('ey_applications')->isNotifyDownloadEmail()){
            $customer = $observer->getEvent()->getCustomer();
            $fileId = $observer->getEvent()->getId();
            $file = Mage::getModel('ey_applications/file')->load($fileId);

            $emailTemplate = Mage::getModel('core/email_template')->load(
                Mage::helper('ey_applications')->getDownloadNotifyEmailTemplate()
            );
            $processedTemplate = $emailTemplate->getProcessedTemplate(
                array(
                    'customer_name' => $customer->getName(),
                    'email' => $customer->getEmail(),
                    'file_id' => $fileId,
                    'file_name' => $file->getName()
                )
            );
            try{
                mail(
                    Mage::helper('ey_applications')->getDownloadNotifyEmail(),
                    'Omni Application Database - Downloaded File',
                    $processedTemplate
                );
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
