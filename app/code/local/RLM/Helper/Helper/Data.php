<?php
class RLM_Helper_Helper_Data
    extends Mage_Core_Helper_Abstract
{
    public function getLoginLogoutLink()
    {
        $data = array();

        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $data['url'] = Mage::getUrl('customer/account/logout');
            $data['title'] = $this->__('Log Out');
            $data['class'] = 'logout';
        } else {
            $data['url'] = Mage::getUrl('customer/account/login');
            $data['title'] = $this->__('Log In');
            $data['class'] = 'login';
        }

        return $data;
    }

    public function getSettingsUrl()
    {
        return Mage::getUrl('customer/account');
    }

    public function getCartItemsCount()
    {
        return Mage::helper('checkout/cart')->getItemsCount();
    }

    public function getCartUrl()
    {
        return Mage::getUrl('checkout/cart');
    }
}