<?php
/* @var $installer RLM_Setup_Model_Resource_Setup */
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

$installer->setConfigData('design/header/logo_src', 'images/logo.png');

//Create Menu
$menu = Mage::getModel('scandi_menumanager/menu')->load('main_menu')
    ->setIdentifier('main_menu')
    ->setTitle('Main homepage menu')
    ->setStores(array(0))
    ->setType('horizontal')
    ->setCssClass('main-top-menu')
    ->setIsActive('1')
    ->save();

//Add Menu Items
Mage::getModel('scandi_menumanager/item')->load('guys')
    ->setIdentifier('guys')
    ->setMenuId($menu->getId())
    ->setParentId('0')
    ->setTitle('Guys')
    ->setUrl('guys.html')
    ->setType('same_window')
    ->setCssClass('guys')
    ->setPosition('0')
    ->setIsActive(1)
    ->save();

Mage::getModel('scandi_menumanager/item')->load('girls')
    ->setIdentifier('girls')
    ->setMenuId($menu->getId())
    ->setParentId('0')
    ->setTitle('Girls')
    ->setUrl('girls.html')
    ->setType('same_window')
    ->setCssClass('girls')
    ->setPosition('0')
    ->setIsActive(1)
    ->save();

Mage::getModel('scandi_menumanager/item')->load('wood')
    ->setIdentifier('wood')
    ->setMenuId($menu->getId())
    ->setParentId('0')
    ->setTitle('Wood')
    ->setUrl('wood.html')
    ->setType('same_window')
    ->setCssClass('wood')
    ->setPosition('10')
    ->setIsActive(1)
    ->save();

Mage::getModel('scandi_menumanager/item')->load('blog')
    ->setIdentifier('blog')
    ->setMenuId($menu->getId())
    ->setParentId('0')
    ->setTitle('Blog')
    ->setUrl('blog')
    ->setType('same_window')
    ->setCssClass('blog')
    ->setPosition('20')
    ->setIsActive(1)
    ->save();

$content = <<<EOF
{{block type="rlm_slider/slides"}}
EOF;

Mage::getModel('cms/page')->load('home', 'identifier')
    ->setIdentifier('home')
    ->setContent($content)
    ->save();

$installer->endSetup();