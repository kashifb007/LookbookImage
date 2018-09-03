<?php
class Lindybop_LookbookImage_Block_Adminhtml_Lookbook extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_lookbook';
        $this->_blockGroup = 'lookbookImage';
        $this->_addButtonLabel = $this->__('Add New Lookbook Image');
        $this->_headerText =  $this->__('Look Books');
        parent::__construct();
    }
}