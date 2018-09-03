<?php
class Lindybop_LookbookImage_Block_Adminhtml_Lookbook_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_lookbook';
        $this->_blockGroup = 'lookbookImage';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('lookbookImage')->__('Save Lookbook'));
        $this->_updateButton('delete', 'label', Mage::helper('lookbookImage')->__('Delete Lookbook'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('current_lookbook') && Mage::registry('current_lookbook')->getId()) {
            return Mage::helper('lookbookImage')->__("Edit Lookbook Image '%s'", $this->escapeHtml(Mage::registry('current_lookbook')->getTitle()));
        }
        else {
            return Mage::helper('lookbookImage')->__('New Lookbook Image');
        }
    }
}