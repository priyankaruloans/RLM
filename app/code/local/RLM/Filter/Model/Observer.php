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

    /**
     * If request is made to customer/account/index action, user is being redirected to edit page.
     */
    public function redirectToSettings()
    {
        Mage::app()->getResponse()->setRedirect(Mage::getUrl('customer/account/edit'));
        Mage::app()->getResponse()->sendResponse();
        exit;
    }
}