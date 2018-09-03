<?php
class Lindybop_LookbookImage_Block_Adminhtml_Lookbook_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('lookbook_image_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {

        $collection = Mage::getModel('lookbookImage/lookbook')->getResourceCollection();

        foreach ($collection as $view) {
            if ( $view->getStoreId() && $view->getStoreId() != 0 ) {
                $view->setStoreId(explode(',',$view->getStoreId()));
            } else {
                $view->setStoreId(array('0'));
            }
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('lookbookImage');
        $this->addColumn('entity_id', array(
            'header'    => $helper->__('ID'),
            'align'     => 'left',
            'index'     => 'entity_id',
            'type'      => 'number'
        ));

        $this->addColumn('title', array(
            'header'    => $helper->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));

        $this->addColumn('store_id', array(
                'header'    => $helper->__('Store View'),
                'index'     => 'store_id',
                'type'      => 'store',
                'store_all'     => true,
                'store_view'=> true,
                'filter_condition_callback'  => array($this, '_filterStoreCondition'),
            ));        

        $this->addColumn('is_active', array(
            'header'    => $helper->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => Mage::getSingleton('lookbookImage/lookbook')->getAvailableStatuses()
        ));

        $this->addColumn('created_at', array(
            'header'    => $helper->__('Date Created'),
            'index'     => 'created_at',
            'type'      => 'datetime',
        ));

        $this->addColumn('updated_at', array(
            'header'    => $helper->__('Last Modified'),
            'index'     => 'updated_at',
            'type'      => 'datetime',
        ));

        $this->addColumn('sort_order', array(
            'header'    => $helper->__('Sort Order'),
            'index'     => 'sort_order',
            'filter'    => false
        ));

        $this->addColumn('category_id', array(
            'header'    => $helper->__('Category'),
            'index'     => 'category_id',
            'filter'    => false
        ));

        $this->addColumn('action',
            array(
                'header'    => 'Edit',
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => 'Edit',
                        'url'     => array(
                            'base'=>'*/*/edit',
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
            ));

        // $this->addColumn('store_id', array(
        // 'header' => 'Store View',
        // 'index' => 'store_id',
        // 'type' => 'store',
        // 'store_all' => true,
        // 'store_view' => true,
        // 'sortable' => true,
        // 'filter_condition_callback' => array($this, '_filterStoreCondition'),
        //  ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('lookbook_ids');

        $this->getMassactionBlock()->addItem('enable_lookbooks', array(
            'label'=> Mage::helper('lookbookImage')->__('Enable'),
            'url'  => $this->getUrl('*/*/enable'),
        ));

        $this->getMassactionBlock()->addItem('disable_lookbooks', array(
            'label'=> Mage::helper('lookbookImage')->__('Disable'),
            'url'  => $this->getUrl('*/*/disable'),
        ));

        return $this;
    }


    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        //$value = explode(",", $value);
        $this->getCollection()->addStoreFilter($value);
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}