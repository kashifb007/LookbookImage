<?php
class Lindybop_LookbookImage_Model_Lookbook extends Mage_Core_Model_Abstract
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public function __construct() {
        $this->_init('lookbookImage/lookbook');
    }

    public function getAvailableStatuses()
    {
        $statuses = new Varien_Object(array(
            self::STATUS_ENABLED => Mage::helper('lookbookImage')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('lookbookImage')->__('Disabled'),
        ));

        return $statuses->getData();
    }

    public function getImageFields() {
        return array(
            'main_image',
        );
    }

    protected function _beforeSave() {
        if(!$this->getId()) {
            $this->setCreatedAt(time());
        }
        $this->setUpdatedAt(time());
    }
}