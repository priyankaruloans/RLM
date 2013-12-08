<?php
class RLM_Slider_Block_Adminhtml_Slides
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'rlm_slider';
        $this->_controller = 'adminhtml_slides';
        $this->_headerText = Mage::helper('rlm_slider')->__('RLM Slider Slides');
        parent::__construct();

        $this->_updateButton('add', 'Add new slide');
    }
}