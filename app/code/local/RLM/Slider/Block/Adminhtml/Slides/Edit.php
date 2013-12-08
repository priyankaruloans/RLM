<?php
class RLM_Slider_Block_Adminhtml_Slides_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'slidesId';
        $this->_blockGroup = 'rlm_slider';
        $this->_controller = 'adminhtml_slides';

        $this->_updateButton('save', 'label', Mage::helper('rlm_slider')->__('Save Slide'));
        $this->_updateButton('delete', 'label', Mage::helper('rlm_slider')->__('Delete Slide'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('slide_data') && Mage::registry('slide_data')->getId()) {
            return Mage::helper('rlm_slider')->__("Edit Item '%s'", $this->escapeHtml(Mage::registry('slide_data')->getTitle()));
        } else {
            return Mage::helper('rlm_slider')->__('Add Slide');
        }
    }
}