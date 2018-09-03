<?php
class Lindybop_LookbookImage_Block_Category_Lookbook extends Mage_Core_Block_Template
{
    public function getLookbooks() {
        return Mage::getModel('lookbookImage/lookbook')->getCollection()
                                ->addSortOrder()
                                ->addActiveFilter()
                                ->addStoreFilter();
    }
}