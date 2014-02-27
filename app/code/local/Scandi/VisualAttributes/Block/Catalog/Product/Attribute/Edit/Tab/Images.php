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
class Scandi_VisualAttributes_Block_Catalog_Product_Attribute_Edit_Tab_Images extends
    Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Create fieldset and add image inputs
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        /* @var Scandi_VisualAttributes_Helper_Data $helper */
        $helper = Mage::helper('scandi_visualattributes');
        $form = new Varien_Data_Form();
        $form->setUseContainer(false);

        $displayOptions = $form->addFieldset(
            'image_display_options', array('legend' => $helper->__('Display Options'))
        );

        $displayOptions->addField('use_images', 'select', array(
            'name' => 'use_images',
            'label' => $helper->__('Use images in product view'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
            'value' => $this->getAttribute()->getData('use_images')
        ));

        $displayOptions->addField('image_width', 'text', array(
            'name' => 'image_width',
            'label' => $helper->__('Image width'),
            'value' => $this->getAttribute()->getData('image_width')
        ));

        $displayOptions->addField('image_height', 'text', array(
            'name' => 'image_height',
            'label' => $helper->__('Image height'),
            'value' => $this->getAttribute()->getData('image_height')
        ));

        $displayOptions->addField('use_images_layer', 'select', array(
            'name' => 'use_images_layer',
            'label' => $helper->__('Use images in layered navigation'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
            'value' => $this->getAttribute()->getData('use_images_layer')
        ));

        $displayOptions->addField('image_width_layer', 'text', array(
            'name' => 'image_width_layer',
            'label' => $helper->__('Layered navigation image width'),
            'value' => $this->getAttribute()->getData('image_width_layer')
        ));

        $displayOptions->addField('image_height_layer', 'text', array(
            'name' => 'image_height_layer',
            'label' => $helper->__('Layered navigation image height'),
            'value' => $this->getAttribute()->getData('image_height_layer')
        ));

        $optionImages = $form->addFieldset(
            'option_images', array('legend' => $helper->__('Manage Option Images'))
        );

        foreach ($this->getAttributeOptions() as $option) {

            $optionImages->addField($helper::IMAGE_FIELD_NAME_PREFIX . $option->getOptionId(), 'image', array(
                'name' => $helper::IMAGE_FIELD_NAME_PREFIX . $option->getOptionId(),
                'label' => $option->getStoreDefaultValue(),
                'value' => $helper->getOptionImageUrl($this->getAttribute(), $option->getImage())
            ));
        }

        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Get options for attribute
     *
     * @return Mage_Eav_Model_Resource_Entity_Attribute_Option_Collection
     */
    public function getAttributeOptions()
    {
        $values = $this->getData('attribute_options');
        if (is_null($values)) {
            $values = Mage::getResourceModel('eav/entity_attribute_option_collection')
                ->setAttributeFilter($this->getAttribute()->getId())
                ->setStoreFilter()
                ->load();

            $this->setData('attribute_options', $values);
        }
        return $values;
    }

    /**
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     */
    public function getAttribute()
    {
        return Mage::registry('entity_attribute');
    }
}