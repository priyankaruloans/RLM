<?php
class RLM_Slider_Block_Adminhtml_Slides_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        $general = $form->addFieldset('slide_form', array('legend'=>Mage::helper('rlm_slider')->__('Slide Information')));
        $general->addField('title', 'text', array(
            'label'     => Mage::helper('rlm_slider')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title'
        ));

        $general->addField('video_url', 'text', array(
            'label'     => Mage::helper('rlm_slider')->__('Video Embed Code'),
            'required'  => false,
            'name'      => 'video_url'
        ));

        $general->addField('image', 'image', array(
            'label'     => Mage::helper('rlm_slider')->__('Image'),
            'required'  => false,
            'name'      => 'image'
        ));

        if (Mage::getSingleton('adminhtml/session')->getSlideData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSlideData());
            Mage::getSingleton('adminhtml/session')->getSlideData(null);
        } elseif (Mage::registry('slide_data')) {
            $formData = Mage::registry('slide_data');
            $form->setValues($formData);
        }
        return parent::_prepareForm();
    }
}