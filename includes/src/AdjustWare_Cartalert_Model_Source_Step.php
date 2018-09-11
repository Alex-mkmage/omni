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
class AdjustWare_Cartalert_Model_Source_Step extends Varien_Object
{
    public function toOptionArray()
    {
        $options = array(
            0 => array(
                'value' => '',
                'label' => '-'
            )
        );

        foreach (array('first','second','third') as $step)
            $options[] = array(
                'value'=> $step,
                'label' => Mage::helper('adjcartalert')->__(ucfirst($step). ' Email Template')
            );
        
        return $options;
    }
}