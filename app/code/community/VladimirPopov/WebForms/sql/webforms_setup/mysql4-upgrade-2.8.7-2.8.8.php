<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn(
        $this->getTable('webforms'),
        'show_gdpr_agreement_text',
        'INT(1)'
    );

$installer->getConnection()->addColumn(
    $this->getTable('webforms'),
    'gdpr_agreement_text',
    'TEXT'
);

$installer->getConnection()->addColumn(
    $this->getTable('webforms'),
    'show_gdpr_agreement_checkbox',
    'INT(1)'
);

$installer->getConnection()->addColumn(
    $this->getTable('webforms'),
    'gdpr_agreement_checkbox_required',
    'INT(1)'
);

$installer->getConnection()->addColumn(
    $this->getTable('webforms'),
    'gdpr_agreement_checkbox_do_not_store',
    'INT(1)'
);

$installer->getConnection()->addColumn(
    $this->getTable('webforms'),
    'gdpr_agreement_checkbox_label',
    'TEXT'
);

$installer->getConnection()->addColumn(
    $this->getTable('webforms'),
    'gdpr_agreement_checkbox_error_text',
    'TEXT'
);

$installer->endSetup();