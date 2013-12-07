<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->setConfigData('design/package/name', 'rlm');
$installer->setConfigData('design/theme/locale', 'default');
$installer->setConfigData('design/theme/template', 'default');
$installer->setConfigData('design/theme/skin', 'default');
$installer->setConfigData('design/theme/layout', 'default');
$installer->setConfigData('design/theme/default', 'default');

Mage::getModel('cms/page')->load('home', 'identifier')
    ->setIdentifier('home')
    ->setRootTemplate('one_column')
    ->save();

$installer->endSetup();