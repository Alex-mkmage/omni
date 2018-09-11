<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Admin
 * @copyright   Copyright (c) 2015 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$installer->getConnection()->insertMultiple(
	$installer->getTable('admin/permission_block'),
	array(
		array('block_name' => 'cms/block', 'is_allowed' => 1),
		array('block_name' => 'core/text_list', 'is_allowed' => 1),
		array('block_name' => 'core/messages', 'is_allowed' => 1),
		array('block_name' => 'catalog/product_list', 'is_allowed' => 1),
		array('block_name' => 'catalog/navigation', 'is_allowed' => 1),
		array('block_name' => 'default/template', 'is_allowed' => 1),
		array('block_name' => 'downloads/link', 'is_allowed' => 1),
		array('block_name' => 'newsletter/subscribe', 'is_allowed' => 1),
		array('block_name' => 'page/html', 'is_allowed' => 1),
		array('block_name' => 'page/html_head', 'is_allowed' => 1),
		array('block_name' => 'page/html_header', 'is_allowed' => 1),
		array('block_name' => 'page/html_footer', 'is_allowed' => 1),
		array('block_name' => 'page/html_wrapper', 'is_allowed' => 1),
		array('block_name' => 'page/html_breadcrumbs', 'is_allowed' => 1),
		array('block_name' => 'page/template_links', 'is_allowed' => 1),
		array('block_name' => 'page/switch', 'is_allowed' => 1),
	)
);
$installer->endSetup();