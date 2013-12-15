<?php
/* @var $installer RLM_Setup_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$files = array('image1.png', 'image2.png');
$installer->copyMediaFiles($files, 'rlm', 'default', 'rlm_slider');

Mage::getModel('rlm_slider/slides')->setTitle('Slide 1')
    ->setImage('image1.png')
    ->save();

Mage::getModel('rlm_slider/slides')->setTitle('Slide 2')
    ->setImage('image2.png')
    ->save();

$installer->endSetup();