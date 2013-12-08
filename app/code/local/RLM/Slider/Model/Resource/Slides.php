<?php
class RLM_Slider_Model_Resource_Slides
    extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('rlm_slider/slides', 'slide_id');
    }
}