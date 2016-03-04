<?php
/**
 * Created by PhpStorm.
 * User: jidziak
 * Date: 04.03.16
 * Time: 10:53
 */

class Macopedia_Zanox_Model_Observer
{
    public function registerPartner(Varien_Event_Observer $observer) {
        if (Mage::app()->getRequest()->getParam('zanpid')) {
            Mage::getSingleton('core/session')->setZanoxId(Mage::app()->getRequest()->getParam('zanpid'));
        }
    }
}
