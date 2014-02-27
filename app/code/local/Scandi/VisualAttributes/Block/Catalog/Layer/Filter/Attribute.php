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
class Scandi_VisualAttributes_Block_Catalog_Layer_Filter_Attribute extends Mage_Catalog_Block_Layer_Filter_Attribute
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('scandi/visualattributes/catalog/layer/filter.phtml');
    }

    /**
     * @param Mage_Catalog_Model_Layer_Filter_Item $option
     * @return string | bool
     */
    public function getItemImage($option)
    {
        return Mage::helper('scandi_visualattributes')->getOptionImageUrl(
            $this->getAttributeModel(),
            $option->getImage()
        );
    }

    /**
     * Get image width specified for attribute
     *
     * @return string | bool
     */
    public function getImageWidth()
    {
        if ($width = $this->getAttributeModel()->getImageWidthLayer()) {
            return $width;
        }
        return false;
    }

    /**
     * Get image height specified for attribute
     *
     * @return string | bool
     */
    public function getImageHeight()
    {
        if ($height = $this->getAttributeModel()->getImageHeightLayer()) {
            return $height;
        }
        return false;
    }
}