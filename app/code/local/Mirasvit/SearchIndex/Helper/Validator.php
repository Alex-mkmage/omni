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


class Mirasvit_SearchIndex_Helper_Validator extends Mirasvit_MstCore_Helper_Validator_Abstract
{
    /**
     * {@inheritdoc}
     */
    public function testConflictExtensions()
    {
        $result = self::SUCCESS;
        $title = 'Search Index: Conflicts with another extensions';
        $description = array();
        $troubleshootLink = "https://docs.mirasvit.com/doc/extension_searchsphinx/current/troubleshooting";

        if (Mage::helper('mstcore')->isModuleInstalled('Sonassi_FastSearchIndex')) {
            $result = self::FAILED;
            $description[] = "Sonassi_FastSearchIndex is installed. Please disable this extension";
        }

        if (Mage::helper('mstcore')->isModuleInstalled('Activo_CatalogSearch')) {
            $result = self::FAILED;
            $description[] = "Activo_CatalogSearch is installed. Please disable this extension";
        }

        if (Mage::helper('mstcore')->isModuleInstalled('Activo_CatalogSearch')) {
            $result = self::FAILED;
            $description[] = "Activo_CatalogSearch is installed. Please disable this extension";
        }

        if (Mage::helper('mstcore')->isModuleInstalled('MageWorx_CustomOptions')) {
            $result = self::FAILED;
            $description[] = "MageWorx_CustomOptions is installed.
            Please disable this extension or make changes in /MageWorx/CustomOptions/Model/Observer 
            to prevent changes in search logic";
        }

        if (Mage::helper('mstcore')->isModuleInstalled('Simtech_Searchanise')) {
            if ($this->validateRewrite('catalogsearch_resource/fulltext_collection',
                'Mirasvit_SearchIndex_Model_Catalogsearch_Resource_Fulltext_Collection') !== true
            ) {
                $result = self::FAILED;
                $description[] = "Simtech_Searchanise is installed. Please disable this extension or solve conflict "
                    . "between collection models as described in our <a href='$troubleshootLink'>manual</a>.";
            }
        }

        if (Mage::helper('mstcore')->isModuleInstalled('Netzarbeiter_GroupsCatalog2')) {
            if ($this->validateRewrite('catalogsearch_resource/fulltext_collection',
                'Mirasvit_SearchIndex_Model_Catalogsearch_Resource_Fulltext_Collection') !== true
            ) {
                $result = self::FAILED;
                $description[] = "Netzarbeiter_GroupsCatalog2 is installed."
                    . " Please disable this extension and remove its attributes"
                    . " (with prefix 'groupscatalog2_') or solve conflict between collection models as described"
                    . " in our <a href='$troubleshootLink'>manual</a> (preferred).";
            }
        }

        if (Mage::helper('mstcore')->isModuleInstalled('Sns_Quicksearch')) {
            $result = self::FAILED;
            $description[] = "Sns_Quicksearch is installed. Please disable this extension";
        }

        if (Mage::helper('mstcore')->isModuleInstalled('Amasty_Xsearch')) {
            $result = self::FAILED;
            $description[] = "Amasty_Xsearch is installed. Please disable this extension";
        }

        if (Mage::helper('mstcore')->isModuleInstalled('TM_AjaxSearch')) {
            $result = self::FAILED;
            $description[] = "TM_AjaxSearch is installed. Please disable this extension";
        }
        if (Mage::helper('mstcore')->isModuleInstalled('Php4u_CatalogSearch')) {
            $result = self::FAILED;
            $description[] = "Php4u_CatalogSearch is installed. Please disable this extension";
        }
        if (Mage::helper('mstcore')->isModuleInstalled('Php4u_BlastLuceneSearch')) {
            $result = self::FAILED;
            $description[] = "Php4u_BlastLuceneSearch is installed. Please disable this extension";
        }
        if (Mage::helper('mstcore')->isModuleInstalled('Enterprise_CatalogSearch') || 
            Mage::helper('mstcore')->isModuleInstalled('Enterprise_Search')) {
            $result = self::FAILED;
            $description[] = "You`re using Magento Enterprise."
                . " Enterprise_Search and Enterprise_CatalogSearch affect our module`s collection."
                . " Please disable these modules to solve the conflict ";
        }

        return array($result, $title, $description);
    }

    /**
     * {@inheritdoc}
     */
    public function testFulltextCollectionRewrite()
    {
        $result = self::SUCCESS;
        $title = 'Search Index: Check Rewrites';
        $description = array();

        $validateRewrite = $this->validateRewrite(
            'catalogsearch_resource/fulltext_collection',
            'Mirasvit_SearchIndex_Model_Catalogsearch_Resource_Fulltext_Collection'
        );

        if ($validateRewrite !== true) {
            $result = self::FAILED;
            $description = $validateRewrite;
        }

        return array($result, $title, $description);
    }
    
    /**
     * {@inheritdoc}
     */
    public function validateRewrite($class, $classNameB)
    {
        $object = Mage::getModel($class);
        if ($object instanceof $classNameB) {
            return true;
        } else {
            return "$class must be $classNameB, current rewrite is " . get_class($object);
        }
    }
}
