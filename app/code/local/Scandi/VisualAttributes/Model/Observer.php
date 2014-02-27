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
class Scandi_VisualAttributes_Model_Observer
{
    /**
     * Add option image tab to attribute edit screen
     *
     * @param Varien_Event_Observer $observer
     */
    public function addImagesTab(Varien_Event_Observer $observer)
    {
        if ($observer->getBlock() instanceof Mage_Adminhtml_Block_Catalog_Product_Attribute_Edit_Tabs) {

            if (in_array(Mage::registry('entity_attribute')->getFrontendInput(), array('select', 'multiselect'))) {

                $tab = $observer->getBlock()->getLayout()
                    ->createBlock('scandi_visualattributes/catalog_product_attribute_edit_tab_images');

                $observer->getBlock()->addTabAfter('option_images', array(
                    'label' => Mage::helper('scandi_visualattributes')->__('Option Images'),
                    'title' => Mage::helper('scandi_visualattributes')->__('Option Images'),
                    'content' => $tab->toHtml(),
                    ), 'labels');
            }
        }
    }

    /**
     * Move uploaded images or delete selected
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function processImages(Varien_Event_Observer $observer)
    {
        $request = $observer->getControllerAction()->getRequest();
        $attributeId = $request->getParam('attribute_id');
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        /* @var Scandi_VisualAttributes_Helper_Data $helper */
        $helper = Mage::helper('scandi_visualattributes');

        if (!$attribute->getId()) {
            return;
        }

        $options = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setAttributeFilter($attribute->getId())
            ->load();

        /* Upload new files */
        foreach ($_FILES as $fieldId => $imageData) {

            try {
                if ($imageData['name']) {

                    /**
                     * Varien uploader doesn't support multiple image upload so we have to create new one for
                     * each image
                     */
                    $uploader = new Varien_File_Uploader($fieldId);
                    $uploader->setAllowedExtensions(array('png', 'jpg', 'gif'));
                    $uploadDir = $helper->getAttributeMediaDirectory($attribute->getId(), true);

                    if ($uploader->save($uploadDir, $imageData['name'])) {

                        $optionId = str_replace($helper::IMAGE_FIELD_NAME_PREFIX, '', $fieldId);
                        $options->getItemById($optionId)->setImage($imageData['name'])->save();
                    }
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    $helper->__('Problem uploading file %s - %s', $imageData['name'], $e->getMessage())
                );
            }
        }

        $ioObject = new Varien_Io_File();

        /* Check if we need to delete any files */
        foreach ($request->getParams() as $paramKey => $paramData) {

            $optionId = str_replace($helper::IMAGE_FIELD_NAME_PREFIX, '', $paramKey);
            if ($optionId == $paramKey) {
                continue;
            }

            if (isset($paramData['delete'])) {

                $image = $options->getItemById($optionId)->getImage();
                $options->getItemById($optionId)->setImage(null)->save();

                /* Delete file only if not used by other options */
                $imageFileUses = Mage::getResourceModel('eav/entity_attribute_option_collection')->
                    addFieldToFilter('image', $image)->count();
                if (!$imageFileUses) {
                    $ioObject->rm($helper->getAttributeMediaDirectory($attribute, true) . $image);
                }
            }
        }
    }
}