<?php
class RLM_Slider_Model_Slides
    extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('rlm_slider/slides');
    }
}