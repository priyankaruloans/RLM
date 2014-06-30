<?php
class RLM_Slider_Block_Adminhtml_Slides_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('rlm_slidesGrid');
    }

    public function _prepareCollection()
    {
        $collection = Mage::getModel('rlm_slider/slides')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('slide_id', array(
            'header'   => Mage::helper('rlm_slider')->__('ID'),
            'index'    => 'slide_id',
            'width'    => '200px'
        ));

        $this->addColumn('title', array(
            'header'   => Mage::helper('rlm_slider')->__('Title'),
            'index'    => 'title',
            'width'    => '500px'
        ));

        $this->addColumn('image', array(
            'header'   => Mage::helper('rlm_slider')->__('Image'),
            'index'    => 'image',
            'width'    => '500px',
            'sortable' => false,
            'filter'   => false,
            'renderer' => 'RLM_Slider_Block_Adminhtml_Slides_Renderer_Image'
        ));

        $this->addColumn('video_url', array(
            'header'   => Mage::helper('rlm_slider')->__('Video Url'),
            'index'    => 'video_url',
            'width'    => '500px',
        ));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('slide_id');
        $this->getMassactionBlock()->setFormFieldName('slide');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('rlm_slider')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('rlm_slider')->__('Are you sure?')
        ));
        return $this;
    }
}