<?php
class Lindybop_LookbookImage_Model_Mysql4_Lookbook_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct() {
        $this->_init('lookbookImage/lookbook');
    }

    public function addActiveFilter() {
        $this->addFieldToFilter('is_active',Lindybop_LookbookImage_Model_Lookbook::STATUS_ENABLED);
        $this->addDateFilter();
        return $this;
    }

    public function addSortOrder($dir = 'asc') {
        $this->addOrder('sort_order',$dir);
        return $this;
    }

    public function addStoreFilter($storeId = null) {
        if(!$storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        $this->addFieldToFilter('store_id',array(
            array('eq' => $storeId),
            array('eq' => Mage_Core_Model_App::ADMIN_STORE_ID)
        ));
        return $this;
    }
}