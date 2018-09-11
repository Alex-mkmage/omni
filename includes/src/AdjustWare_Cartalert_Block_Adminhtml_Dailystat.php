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
class AdjustWare_Cartalert_Block_Adminhtml_Dailystat extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();        
        $this->_controller = 'adminhtml_dailystat';
        $this->_blockGroup = 'adjcartalert';
        $this->_headerText = Mage::helper('adjcartalert')->__('Daily Statistic');
        $this->_removeButton('add'); 
    }  
  
}