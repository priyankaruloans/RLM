<?php
class RLM_Filter_Model_Observer
{
    /**
     * Doesn't allows user to access specific urls.
     */
    public function sendToNoRoute()
    {
        Mage::app()->getResponse()->setRedirect(Mage::getUrl('/'));
        Mage::app()->getResponse()->sendResponse();
        exit;
    }
}