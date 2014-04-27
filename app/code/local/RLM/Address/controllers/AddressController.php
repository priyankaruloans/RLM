<?php
require Mage::getModuleDir('controllers', 'Mage_Customer') . DS . 'AddressController.php';

class RLM_Address_AddressController extends Mage_Customer_AddressController
{
    public function indexAction()
    {
        if (count($this->_getSession()->getCustomer()->getAddresses())) {
            $addresses = $this->_getSession()->getCustomer()->getAddresses();
            $address = reset($addresses);
            $this->getResponse()->setRedirect(Mage::getUrl('*/*/edit', array('id' => $address->getId())));
        } else {
            $this->getResponse()->setRedirect(Mage::getUrl('*/*/new'));
        }
    }
}