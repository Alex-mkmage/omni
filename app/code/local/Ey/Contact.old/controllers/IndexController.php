<?php

class Ey_Contact_IndexController extends Mage_Core_Controller_Front_Action
{

    const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'contacts/email/email_template';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';

    const XML_PATH_SENDER_NOTIFICATION_ENABLED        = 'contacts/sender_notification/enabled';
    const XML_PATH_SENDER_NOTIFICATION_EMAIL_TEMPLATE = 'icube_contacts/sender_notification/email_template';

    public function preDispatch()
    {
        parent::preDispatch();

        if( !Mage::getStoreConfigFlag(self::XML_PATH_ENABLED) ) {
            $this->norouteAction();
        }
    }

    public function postAction(){
        $post = $this->getRequest()->getPost();

        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }

                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {
                    throw new Exception();
                }

                $contacts = Mage::getModel('ey_contact/contact')
                    ->getCollection()
                    ->addFieldToFilter('email', $post['email']);

                if($contacts->getSize()){
                    foreach ($contacts as $contact){
                        $contact->setName($post['name'])
                            ->setPhone($post['telephone'])
                            ->setServiceRequested($post['service-requested'])
                            ->setCompany($post['company-institute'])
                            ->setComment($post['comment'])
                            ->updateSendDate()
                            ->save();
                    }
                } else{
                    Mage::getModel('ey_contact/contact')->setName($post['name'])
                        ->setEmail($post['email'])
                        ->setPhone($post['telephone'])
                        ->setServiceRequested($post['service-requested'])
                        ->setCompany($post['company-institute'])
                        ->setComment($post['comment'])
                        ->updateSendDate()
                        ->save();
                }

                // Send notification to store support
                //
                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                    //fetch email template from Adminend > System > Configuration > General > Contact > email template
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                        null,
                        array('data' => $postObject),
                        Mage::app()->getStore()->getStoreId()
                    );

                if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }

                //send notification to customer
                //fetch sender data from Adminend > System > Configuration > Store Email Addresses > General Contact
                $from_email = Mage::getStoreConfig('trans_email/ident_support/email');
                $from_name = Mage::getStoreConfig('trans_email/ident_support/name');

                $sender = array('name'  => $from_name,
                    'email' => $from_email);

                $mailTemplate2 = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate2->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($sender['email'])
                    ->sendTransactional(
                        'custom_template',      //load template description on config.xml
                        $sender,
                        $post['email'],
                        $post['name'],
                        array('data' => $postObject),
                        Mage::app()->getStore()->getStoreId()
                    );

                $translate->setTranslateInline(true);

                // Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));

                $data['err'] = false;
                $data['msg'] = 'Thank you for your submission, Omni will be sure to contact you in within a 48 hour period.';
                // echo json_encode($data);

            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                $data['err'] = true;
                $data['msg'] = 'Unable to submit your request. Please, try again later';
            }

            echo json_encode($data);

        } else {
            $data['err'] = true;
            $data['msg'] = 'Unable to submit your request. Please, try again later';
            echo json_encode($data);
        }


    }

}
