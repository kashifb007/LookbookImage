<?php
class Lindybop_LookbookImage_Model_Mysql4_Lookbook extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct() {

        $this->_init('lookbookImage/lookbook', 'entity_id');

    }
}