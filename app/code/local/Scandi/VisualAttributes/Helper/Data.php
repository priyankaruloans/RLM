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
class Scandi_VisualAttributes_Helper_Data extends Mage_Core_Helper_Abstract
{
    const IMAGE_FIELD_NAME_PREFIX = 'option_image_';

    /**
     * Get directory in which images will be stored for this attribute
     *
     * @param Mage_Catalog_Model_Resource_Eav_Attribute $attribute
     * @return string
     */
    public function getAttributeMediaDirectory($attribute, $addSystemRootPath = false)
    {
        if (!($attribute instanceof Mage_Catalog_Model_Resource_Eav_Attribute)) {
            $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attribute);
        }

        $mediaPath = 'catalog' . DS . 'attributes' . DS  . $attribute->getAttributeCode() . DS;
        if ($addSystemRootPath) {
            return Mage::getBaseDir('media') . DS . $mediaPath;
        }
        return $mediaPath;
    }

    /**
     * Get url where all option images are stored
     *
     * @return string
     */
    public function getAttributesDirectoryUrl()
    {
        return Mage::getBaseUrl('media') . 'catalog/attributes/';
    }

    /**
     * Get options image url
     *
     * @param Mage_Catalog_Model_Resource_Eav_Attribute $attribute
     * @param Varien_Object $option
     * @return string | bool
     */
    public function getOptionImageUrl($attribute, $fileName)
    {
        if ($fileName) {
            return $this->getAttributesDirectoryUrl() . $attribute->getAttributeCode() . '/' . $fileName;
        }
        return false;
    }

    /**
     * @param string $attributeCode
     * @param Mage_Catalog_Model_Product $_product
     * @return array | string
     */
    public function getAttributeImage($attributeCode, $_product)
    {
        if ($attribute = $_product->getResource()->getAttribute($attributeCode)) {

            $data = $_product->getData($attributeCode);
            $options = $attribute->getSource()->getAllOptions();

            if ($attribute->getFrontend()->getInputType() == 'multiselect') {
                $values = explode(',', $data);
                $imageFileNames = array();
                foreach ($options as $option) {
                    if (in_array($option['value'], $values) && isset($option['image'])) {
                        $imageFileNames[] = $this->getOptionImageUrl($attribute, $option['image']);
                    }
                }
                return $imageFileNames;
            } else if ($attribute->getFrontend()->getInputType() == 'select') {
                foreach ($options as $option) {
                    if ($option['value'] == $data && isset($option['image'])) {
                        return $this->getOptionImageUrl($attribute, $option['image']);
                    }
                }
            }
        }
        return '';
    }
}