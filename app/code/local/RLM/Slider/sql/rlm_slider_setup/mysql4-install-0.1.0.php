<?php
$installer = $this;

$installer->startSetup();
$installer->run("
    DROP TABLE IF EXISTS `{$installer->getTable('rlm_slider/slides')}`;
    CREATE TABLE `{$installer->getTable('rlm_slider/slides')}` (
      `slide_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `title` VARCHAR(255) NOT NULL,
      `image` VARCHAR(255) NOT NULL,
      `video_url` VARCHAR(255) NOT NULL,
      PRIMARY KEY (`slide_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();