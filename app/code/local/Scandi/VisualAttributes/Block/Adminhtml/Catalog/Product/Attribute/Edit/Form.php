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
class Scandi_VisualAttributes_Block_Adminhtml_Catalog_Product_Attribute_Edit_Form
    extends Mage_Adminhtml_Block_Catalog_Product_Attribute_Edit_Form
{
    /**
     * Add enctype so we can upload images
     *
     * @return Scandi_VisualAttributes_Block_Adminhtml_Catalog_Product_Attribute_Edit_Form
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();
        $this->setForm($this->getForm()->setData('enctype', 'multipart/form-data'));
        return $this;
    }
}