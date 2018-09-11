<?php

class Icube_OrderNotifier_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ACTIVE = 'sales/icube_orderNotifier/active';
    const XML_PATH_NOTIFY_EMAILS = 'sales/icube_orderNotifier/notify_emails';
    const XML_PATH_EMAIL_TEMPLATE = 'sales/icube_orderNotifier/email_template';

    public function isModuleEnabled($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_ACTIVE, $store);
    }

    public function getNotifyEmails($store = null)
    {
        $entries = Mage::getStoreConfig(self::XML_PATH_NOTIFY_EMAILS, $store);
        $emails = array();

        if (!empty($entries)) {
            $entries = explode(PHP_EOL, $entries);

            if (is_array($entries)) {
                foreach ($entries as $entry) {
                    $_entry = trim($entry);
                    $_name = trim(substr($_entry, 0, strpos($_entry, '<')));
                    $_email = trim(substr($_entry, strpos($_entry, '<')+1, -1));

                    if (!empty($_name) && !empty($_email)) {
                        $emails[] = array('name'=>$_name, 'email'=>$_email);
                    }
                }
            }
        }

        return $emails;
    }

    public function getEmailTemplate($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $store);
    }

    /**
     * @param $identType ('general' or 'sales' or 'support' or 'custom1' or 'custom2')
     * @param $option ('name' or 'email')
     * @return string
     */
    public function getStoreEmailAddressSenderOption($identType, $option)
    {
        if (!$generalContactName = Mage::getSingleton('core/config_data')->getCollection()->getItemByColumnValue('path', 'trans_email/ident_'.$identType.'/'.$option)) {
            $conf = Mage::getSingleton('core/config')->init()->getXpath('/config/default/trans_email/ident_'.$identType.'/'.$option);
            $generalContactName = array_shift($conf);
        } else {
            $generalContactName = $generalContactName->getValue();
        }

        return (string)$generalContactName;
    }
}
