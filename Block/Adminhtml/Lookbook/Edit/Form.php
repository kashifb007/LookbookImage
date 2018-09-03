<?php
class Lindybop_LookbookImage_Block_Adminhtml_Lookbook_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        if(Mage::registry('current_lookbook')) {
            $model = Mage::registry('current_lookbook');
        } else {
            $model = Mage::getModel('lookbookImage/lookbook');
        }

        $helper = mage::helper('lookbookImage');
        $fieldset = $form->addFieldset('branch_form', array(
            'legend' => $helper->__('Look Book Configuration')
        ));

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', array(
                'name' => 'entity_id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'label'     => $helper->__('Title'),
            'required'  => true,
            'name'      => 'title',
        ));

        $fieldset->addField('main_image', 'image', array(
            'label'     => $helper->__('Lookbook Image'),
            'required'  => true,
            'name'      => 'main_image',
        ));

        $fieldset->addField('description', 'textarea', array(
            'label'     => $helper->__('Description'),
            'required'  => true,
            'name'      => 'description',
        ));        
       
        $field = $fieldset->addField('store_id', 'multiselect', array(
            'name'      => 'store_id',
            'label'     => $helper->__('Store View'),
            'title'     => $helper->__('Store View'),
            'required'  => true,
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
        ));
        $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
        $field->setRenderer($renderer);              

         $fieldset->addField('category_id', 'select', array(
            'name' => 'category_id',
            'label' => Mage::helper('lookbookImage')->__('Category'),
            'title' => Mage::helper('lookbookImage')->__('Category'),
            'required' => true,
            'values' => Mage::helper('lookbookImage')->getAllCategoriesArray(true)
        ));

        $fieldset->addField('sort_order', 'text', array(
            'label'     => $helper->__('Sort Order'),
            'name'      => 'sort_order',
            'class'     => 'validate-number'
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => $helper->__('Status'),
            'name'      => 'is_active',
            'class'     => 'required-entry',
            'required'  => true,
            'options'   => array(
                Lindybop_LookbookImage_Model_Lookbook::STATUS_ENABLED => $helper->__('Enabled'),
                Lindybop_LookbookImage_Model_Lookbook::STATUS_DISABLED => $helper->__('Disabled'),
            ),
        ));


        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}