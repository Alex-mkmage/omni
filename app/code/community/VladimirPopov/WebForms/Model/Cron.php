<?php

class VladimirPopov_WebForms_Model_Cron extends Mage_Core_Model_Abstract
{
    public function purgeData()
    {
        $purge_enabled = Mage::getStoreConfig('webforms/gdpr/purge_enable');

        $forms = Mage::getModel('webforms/webforms')->getCollection();
        foreach ($forms as $form) {
            if (
                $form->getData('purge_enable') == 1
                || ($form->getData('purge_enable') == -1 && $purge_enabled)
            ) {
                if ($form->getData('purge_enable') == -1)
                    $purge_period = intval(Mage::getStoreConfig('webforms/gdpr/purge_period'));
                else
                    $purge_period = intval($form->getData('purge_period'));

                if ($purge_period > 0) {
                    $date = date('Y-m-d', strtotime('-' . $purge_period . ' day'));

                    $collection = Mage::getModel('webforms/results')->getCollection()
                        ->addFilter('webform_id', $form->getId())
                        ->addFieldToFilter('created_time', array('lt' => $date));
                    foreach ($collection as $result) {
                        $result->delete();
                    }
                }
            }
        }
    }
}