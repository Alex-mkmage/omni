<?php

class Ey_Contact_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function saveContact($observer)
    {
        try{
            /** @var Ophirah_Qquoteadv_Model_Qqadvcustomer $quoteCustomer */
            $quoteCustomer = $observer->getEvent()->getData('0');
            $contacts = Mage::getModel('ey_contact/contact')
                ->getCollection()
                ->addFieldToFilter('email', $quoteCustomer->getEmail())
                ->addFieldToFilter('category', 'quote-request');

            if($contacts->getSize()){
                foreach ($contacts as $contact){
                    $contact->setName($quoteCustomer->getFirstname().' '.$quoteCustomer->getLastname())
                        ->setPhone($quoteCustomer->getTelephone())
                        ->setServiceRequested($quoteCustomer->getIncrementId())
                        ->setCompany($quoteCustomer->getCompany())
                        ->setComment($quoteCustomer->getClientRequest())
                        ->setCategory('quote-request')
                        ->updateSendDate()
                        ->save();
                }
            } else{
                Mage::getModel('ey_contact/contact')->setName($quoteCustomer->getFirstname().' '.$quoteCustomer->getLastname())
                    ->setEmail($quoteCustomer->getEmail())
                    ->setPhone($quoteCustomer->getTelephone())
                    ->setServiceRequested($quoteCustomer->getIncrementId())
                    ->setCompany($quoteCustomer->getCompany())
                    ->setComment($quoteCustomer->getClientRequest())
                    ->setCategory('quote-request')
                    ->updateSendDate()
                    ->save();
            }
        } catch(\Exception $e){
            Mage::log($e->getMessage(), null, 'ey_contact_qquoteadv_error.log', true);
        }
    }
}