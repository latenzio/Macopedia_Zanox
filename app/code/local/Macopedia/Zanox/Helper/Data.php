<?php
/**
 * Created by PhpStorm.
 * User: jidziak
 * Date: 04.03.16
 * Time: 10:53
 */

class Macopedia_Zanox_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $lastRealOrderId;
    protected $lastOrder;

    /**
     * @param $type
     * @return mixed
     */
    public function getConfigCode($type)
    {
        return Mage::getStoreConfig('macopedia_zanox/zanox_tags/' . $type .'_code');
    }

    /**
     * @return string
     */
    public function getLocaleCode()
    {
        return strtolower(substr(Mage::getStoreConfig('general/locale/code', Mage::app()->getStore()->getId()), 0, 2));
    }

    public function getStore()
    {
        return Mage::app()->getStore();
    }

    public function setLastOrderData()
    {
        $this->lastRealOrderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
        $this->lastOrder = Mage::getModel('sales/order')->loadByIncrementId($this->lastRealOrderId);
    }

    public function getLastOrderInfo()
    {
        if(!$this->lastRealOrderId) {
            $this->setLastOrderData();
        }

        return array(
            'order_id' => $this->lastOrder->getId(),
            'real_order_id'=> $this->lastOrder->getIncrementId(),
            'customer_id' => $this->lastOrder->getIncrementId(),
            'grand_total' => number_format($this->lastOrder->getGrandTotal(), 2, '.', ''),
            'currency_code' => $this->getStore()->getCurrentCurrencyCode(),
            'country_code' => $this->getLocaleCode()
        );
    }

    public function getLastOrderItemsInfo()
    {
        if(!$this->lastRealOrderId) {
            $this->setLastOrderData();
        }

        return $this->getItemsInfo($this->lastOrder->getAllVisibleItems());
    }

    public function getQuoteItemsInfo()
    {
        $quote = Mage::getModel('checkout/cart')->getQuote();
        return $this->getItemsInfo($quote->getAllVisibleItems());
    }

    public function getItemsInfo($items)
    {
        $currencyCode = $this->getStore()->getCurrentCurrencyCode();
        $itemsInfo = array();
        foreach ($items as $item) {
            array_push($itemsInfo, array(
                'id' => $item->getProduct()->getId(),
                'amount' => number_format($this->getStore()->convertPrice($item->getProduct()->getPrice()), 2, '.', ''),
                'currency_code' => $currencyCode,
                'qty' => $item->getQty()
            ));
        }
        return $itemsInfo;
    }
}