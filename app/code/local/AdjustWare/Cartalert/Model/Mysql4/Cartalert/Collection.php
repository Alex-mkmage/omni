<?php
/**
 * Abandoned Carts Alerts Pro
 *
 * @category:    AdjustWare
 * @package:     AdjustWare_Cartalert
 * @version      3.2.0
 * @license:     lS7LIyyj14X5nIS0MyZ5siQGl4tQRYJTdpcEGhT1vl
 * @copyright:   Copyright (c) 2014 AITOC, Inc. (http://www.aitoc.com)
 */
/**
 * Cartalert module observer
 *
 * @author Adjustware
 */
class AdjustWare_Cartalert_Model_Mysql4_Cartalert_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('adjcartalert/cartalert');
    }
    
    public function addReadyForSendingFilter()
    {
        $this->getSelect()->where('sheduled_at < ?',now());
            //->where('status = ?', 'pending');
        return $this;
    } 
}