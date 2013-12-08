<?php
class RLM_Slider_Block_Slides
    extends Mage_Core_Block_Template
{
    protected $_slides;

    public function __construct()
    {
        $this->setTemplate('rlm/slider/slides.phtml');
    }

    public function getSlides()
    {
        if (is_null($this->_slides)) {
            $this->_slides = Mage::getModel('rlm_slider/slides')->getCollection();
        }

        return $this->_slides;
    }

    public function getSlideUrl(Varien_Object $slide)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . '/rlm_slider/' . $slide->getImage();
    }
}