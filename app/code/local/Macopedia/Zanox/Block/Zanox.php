<?php
/**
 * Created by PhpStorm.
 * User: jidziak
 * Date: 04.03.16
 * Time: 10:53
 */

class Macopedia_Zanox_Block_Zanox extends Mage_Core_Block_Template
{
    /**
     * Check is module enabled
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::getStoreConfigFlag('macopedia_zanox/zanox_tags/enable')) {
            return '';
        }
        $html = $this->renderView();
        return $html;
    }
}