<?php
class RLM_Slider_Adminhtml_SliderController
    extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()->_addBreadcrumb(
            Mage::helper('rlm_slider')->__('Slides'),
            Mage::helper('rlm_slider')->__('Slides')
        );
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('RLM'))->_title($this->__('Slides'));

        $this->_initAction()
            ->_setActiveMenu('rlm_slider')
            ->_addBreadcrumb(
            Mage::helper('rlm_slider')->__('Slides'),
            Mage::helper('rlm_slider')->__('Slides')
        )
        ->_addContent($this->getLayout()->createBlock(
            'rlm_slider/adminhtml_slides'
        ))
        ->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('rlm_slider/slides')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('slide_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('rlm_slider');
            $this->_title($this->__('Edit'))
                ->_title($this->__('Slide'))
                ->_title($this->__('RLM Slider'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('rlm_slider/adminhtml_slides_edit'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('rlm_slider')->__('Slide does not exists')
            );
            $this->_redirect('*/*/');
        }
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('rlm_slider/slides');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            try {
                if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    $uploader = new Varien_File_Uploader('image');
                    $newName = strtotime(date('Y-m-d h:m:s')) . base64_encode($_FILES['image']['name']);
                    $_FILES['image']['name'] = $newName;
                    $model->setImage($newName);

                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . '/rlm_slider/' ;
                    $uploader->save($path, $newName );
                }

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('rlm_slider')->__('Slide was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('rlm_slider')->__('Unable to find slide to save.'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('rlm_slider/slides');

                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('rlm_slider')->__('Slide was successfully deleted')
                );
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $slides = $this->getRequest()->getParam('slide');
        if (!is_array($slides)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('rlm_slider')->__('Please select slide(s)')
            );
        } else {
            try {
                foreach ($slides as $slide) {
                    $model = Mage::getModel('rlm_slider/slides')->load($slide);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('rlm_slider')->__(
                        'Total of %d slide(s) were successfully deleted', count($slides)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'index':
                return Mage::getSingleton('admin/session')->isAllowed('rlm_slider/slides');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('rlm_slider');
                break;
        }
    }
}