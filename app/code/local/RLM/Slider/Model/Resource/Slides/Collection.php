<?php
class RLM_Slider_Model_Resource_Slides_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('rlm_slider/slides');
    }
}