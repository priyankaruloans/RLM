<?php
/**
 * Scandiweb - creating a better future
 *
 * Scandi_VisualAttributes
 *
 * @category    Scandi
 * @package     Scandi_VisualAttributes
 * @author      Scandiweb.com <info@scandiweb.com>
 * @copyright   Copyright (c) 2013 Scandiweb.com (http://www.scandiweb.com)
 * @license     http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

/* @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

$attributeColumnInfo = array(
    array(
        'name' => 'use_images',
        'type' => 'bool',
        'default' => 'false',
        'comment' => 'Whether display images in product view'
    ),
    array(
        'name' => 'image_width',
        'type' => 'int(3)',
        'default' => '0',
        'comment' => 'Image width in product view'
    ),
    array(
        'name' => 'image_height',
        'type' => 'int(3)',
        'default' => '0',
        'comment' => 'Image height in product view'
    ),
    array(
        'name' => 'use_images_layer',
        'type' => 'bool',
        'default' => 'false',
        'comment' => 'Whether display images in product layered navigation'
    ),
    array(
        'name' => 'image_width_layer',
        'type' => 'int(3)',
        'default' => '0',
        'comment' => 'Image width for layered navigation'
    ),
    array(
        'name' => 'image_height_layer',
        'type' => 'int(3)',
        'default' => '0',
        'comment' => 'Image height for layered navigation'
    )
);

/* Add columns to catalog attribute table  */
foreach ($attributeColumnInfo as $info) {
    $installer->getConnection()->query("
        ALTER TABLE {$this->getTable('catalog/eav_attribute')} ADD COLUMN {$info['name']} {$info['type']}
        DEFAULT {$info['default']} COMMENT '{$info['comment']}';
    ");
}

/* Add column where image file name for each option will be stored */
$installer->getConnection()->query("
    ALTER TABLE {$this->getTable('eav/attribute_option')} ADD COLUMN image varchar(256)
    COMMENT 'Image file name';
");

$installer->endSetup();