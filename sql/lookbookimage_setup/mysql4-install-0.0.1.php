<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('lookbookImage/lookbook'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Lookbook Title')
    ->addColumn('main_image', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
    ), 'Main Image')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => true,
    ), 'Image Description')
    ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => true,
    ), 'Soft Order')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
        'nullable'  => false,
    ), 'Store ID')    
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
    ), 'Category ID')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
    ), 'Is Lookbook Active')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Lookbook Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Lookbook Updated At');

$installer->getConnection()->createTable($table);

$installer->endSetup();