<?php
/**
 * Author : Ebizmarts <info@ebizmarts.com>
 * Date   : 8/29/13
 * Time   : 6:33 PM
 * File   : SagePaymentsPro.php
 * Module : Ebizmarts_SagePaymentsPro
 */
class Ebizmarts_SagePaymentsPro_Block_Payment_Info_SagePaymentsPro extends Mage_Payment_Block_Info_Cc
{
    protected $_collection = null;

    protected function _construct()
    {
        parent::_construct();
//        $this->setTemplate('ebizmarts/sagepaymentspro/payment/info/sagepaymentspro.phtml');
    }
    public function getSpecificInformation()
    {
        $info_orig = parent::getSpecificInformation();
        if($this->getInfo()->getCcType()=='Virtual Check') {
            $info_orig['Credit Card Type'] = 'Virtual Check';
            switch($this->getInfo()->getCcLast4()) {
                case 'PPD':
                    $info_orig['Check Type'] = 'Prearranged Payment and Deposit Entry';
                    break;
                case 'CCD' :
                    $info_orig['Check Type'] = 'Cash Concentration or Disbursement';
                    break;
            }
            unset($info_orig['Credit Card Number']);
        }
        $this->_collection = Mage::getModel('ebizmarts_sagepaymentspro/transaction')->getCollection();
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();

        if($this->getInfo()->getOrder()&&Mage::app()->getStore()->isAdmin()) {
            $orderId = $this->getInfo()->getOrder()->getId();
        }
        else {
            return $info_orig;
        }
        $this->_collection->addFieldToFilter('order_id', $orderId);

        $info=array();
        foreach($this->_collection as $transaction) {
            $info['Type'] = ucfirst($transaction->getType());
            $info['Cvv Indicator'] = Mage::helper('ebizmarts_sagepaymentspro')->getCvvDescription($transaction->getCvvIndicator());
            $info['AVS'] = Mage::helper('ebizmarts_sagepaymentspro')->getAvsDescription($transaction->getAvs());
            $info['Date'] = $transaction->getTransactionDate();
            $info['Risk Indicator'] = mage::helper('ebizmarts_sagepaymentspro')->getRiskDescription($transaction->getRiskIndicator());
            $info['Post Code Result'] = $transaction->getPostCodeResult();
            $info['Reference'] = $transaction->getReference();
            break;
        }
        return array_merge($info_orig,$info);
    }
    public function getRefunds() {
        $collection = new Varien_Data_Collection();
        foreach($this->_collection as $refund) {
            if($refund->getType() == 'refund') {
                $collection->addItem($refund);
            }
        }
        return $collection;
    }
    public function getAuthorizations() {
        $collection = new Varien_Data_Collection();
        foreach($this->_collection as $refund) {
            if($refund->getType() == 'release') {
                $collection->addItem($refund);
            }
        }
        return $collection;

    }
    public function getChildHtml($name = '',$useCache=true,$sorted=false)
    {
        return $this->setTemplate('ebizmarts/sagepaymentspro/payment/info/sagepaymentspro.phtml')->toHtml();
    }
}