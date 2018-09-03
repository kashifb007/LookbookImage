<?php
class Lindybop_LookbookImage_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getLookbookImageUrl($image) {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $image;
    }


public function getAllCategoriesArray($optionList = false)
    {
        $categoriesArray = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('url_path')
            ->addAttributeToSort('path', 'asc')
            ->addFieldToFilter('is_active', array('eq'=>'1'))
            ->load()
            ->toArray();

        if (!$optionList) {
            return $categoriesArray;
        }

        foreach ($categoriesArray as $categoryId => $category) {
            if (isset($category['name'])) {
                $categories[] = array(
                    'value' => $category['entity_id'],
                    'label' => Mage::helper('lookbookImage')->__($category['name'])." - (".$category['entity_id'].")"
                );
            }
        }

        return $categories;
    }

    public function getLookbooks($store_id, $category_id) {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $query = 'SELECT * FROM lindybop_lookbook WHERE category_id = '.$category_id.' order by sort_order ASC;';
        $results = $readConnection->fetchAll($query);

         $counter = 0;
         #$sqlresults = array();
        foreach($results as $sqlresult)
        {            
            $store_ids = array();
            $store_ids = explode(",", $sqlresult['store_id']);
            if (!in_array($store_id, $store_ids) && ($sqlresult['store_id']!='0')) 
            {
               unset($results[$counter]);
            }
            unset($store_ids);
            #$sqlresults[] = $sqlresult;
            $counter++;
        }

        return $results;
    }

}