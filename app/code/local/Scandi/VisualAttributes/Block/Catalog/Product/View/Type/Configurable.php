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
class Scandi_VisualAttributes_Block_Catalog_Product_View_Type_Configurable extends
    Mage_Catalog_Block_Product_View_Type_Configurable
{
    /**
     * Add attribute display and option image configuration
     *
     * @return array
     */
    protected function _getAdditionalConfig()
    {
        $allowedAttributes = $this->getAllowAttributes();

        /* Get options for used attributes */
        $options = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setAttributeFilter(array('in' => $allowedAttributes->getColumnValues('attribute_id')))
            ->addFieldToFilter('image', array('notnull' => true));

        $data = array();

        /* Add each options image file name to config */
        foreach ($options as $option) {
            $data['imageConfig']['optionImage'][$option['option_id']] = $option['image'];
        }

        /* Add url where images are stored */
        $data['imageConfig']['attributeImageMediaUrl'] = Mage::helper('scandi_visualattributes')
            ->getAttributesDirectoryUrl();

        /* Add used JS templates */
        foreach ($this->getChild('js.templates')->getSortedChildren() as $name) {
            $data['imageConfig'][$name] = $this->getLayout()->getBlock($name)->toHtml();
        }

        foreach ($allowedAttributes as $attribute) {
            $productAttr = $attribute->getProductAttribute();
            $displayConfig = array();
            $displayConfig['useImages'] = $productAttr->getUseImages();
            $displayConfig['width'] = $productAttr->getImageWidth();
            $displayConfig['height'] = $productAttr->getImageHeight();
            $data['imageConfig']['displayConfig'][$productAttr->getAttributeId()] = $displayConfig;
        }

        return $data;
    }
}