<?php
class Scandi_Cms_Block_Block
    extends Mage_Cms_Block_Block
{
    /**
     * Prepare Content HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        $blockId     = $this->getBlockId();
        $blockHtmlId = $this->getBlockHtmlId();
        $class       = $this->getBlockClass();

        $html = '';
        if ($blockId) {
            $block = Mage::getModel('cms/block')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($blockId);
            if ($block->getIsActive()) {
                /* @var $helper Mage_Cms_Helper_Data */
                $helper = Mage::helper('cms');
                $processor = $helper->getBlockTemplateProcessor();
                $html = '<div id="' . $blockHtmlId .'" class="' . $class . '">'
                    . $processor->filter($block->getContent())
                    . '</div>';
            }
        }
        return $html;
    }
}