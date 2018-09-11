<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/extension_searchsphinx
 * @version   2.3.34
 * @copyright Copyright (C) 2018 Mirasvit (https://mirasvit.com/)
 */



/**
 * @category Mirasvit
 */
class Mirasvit_SearchSphinx_Model_System_Config_Source_MatchMode
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'and',
                'label' => Mage::helper('searchsphinx')->__('AND matching (word1 & word2 & word3...)'),
            ),
            array(
                'value' => 'or',
                'label' => Mage::helper('searchsphinx')->__('OR matching (word1 | word2 | word3...)'),
            ),
        );
    }
}
