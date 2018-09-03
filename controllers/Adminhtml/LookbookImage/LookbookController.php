<?php
class Lindybop_LookbookImage_Adminhtml_LookbookImage_LookbookController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction() {
        $this->_title($this->__('Lindybop'))->_title($this->__('Look Books'));
        $this->loadLayout()->_setActiveMenu('system/lindybop');
        $this->renderLayout();
    }

    public function editAction() {
        $helper = Mage::helper('lookbookImage');
        if($id = $this->getRequest()->getParam('id')) {
            $lookbook = $this->_initLookbook($id);
            if($lookbook) {
                $this->_title($lookbook->getTitle());
            } else {
                Mage::getSingleton('adminhtml/session')->addError(
                    $helper->__('This lookbook no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        } else{
            $this->_title($helper->__('New Look Book'));
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {        
        if($data = $this->getRequest()->getPost()) {

            if(isset($data['store_id'])) {
                if( in_array('0', $data['store_id']) ){
                    $data['store_id'] = '0';
                } else {
                    $data['store_id'] = implode(",", $data['store_id']);
                }
            }

            $helper = Mage::helper('lookbookImage');
            if(isset($data['entity_id']) && $data['entity_id']) {
                $lookbook = $this->_initLookbook($data['entity_id']);
            } else {
                $lookbook = Mage::getModel('lookbookImage/lookbook');
            }
            if(!isset($data['entity_id']) || !$data['entity_id'] || ($lookbook && $lookbook->getId())) {
                $lookbook->setData($data);
                try {
                    $fileLocation = 'lookbooks';
                    foreach($lookbook->getImageFields() as $_imageField) {
                        if($_FILES[$_imageField]['name']) {
                            $result = $this->_uploadImage($_imageField,$fileLocation);
                            $lookbook->setData($_imageField, $fileLocation . $result['file']);
                        } elseif(isset($data[$_imageField]['delete'])) {
                            $lookbook->setData($_imageField,'');
                        } elseif(isset($data[$_imageField]['value'])) {
                            $lookbook->setData($_imageField, $data[$_imageField]['value']);
                        } else {
                            $lookbook->setData($_imageField, '');
                        }
                    }
                    $lookbook->save();
                    Mage::getSingleton('adminhtml/session')->addSuccess(
                        $helper->__('The lookbook has been saved.')
                    );
                    Mage::getSingleton('adminhtml/session')->setFormData(false);

                    if ($this->getRequest()->getParam('back')) {
                        $this->_redirect('*/*/edit', array('id' => $lookbook->getId()));
                        return;
                    }
                } catch (Exception $e) {
                    var_dump($e); die;
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    Mage::getSingleton('adminhtml/session')->setFormData($data);
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('entity_id')));
                    return;
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(
                    $helper->__('This lookbook no longer exists.')
                );
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($id = $this->getRequest()->getParam('id')) {
            $helper = Mage::helper('lookbookImage');
            if($lookbook = $this->_initLookbook($id)) {
                try {
                    $lookbook->delete();
                    Mage::getSingleton('adminhtml/session')->addSuccess(
                        $helper->__('The lookbook has been deleted.')
                    );
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    $this->_redirect('*/*/edit', array('entity_id' => $lookbook->getId()));
                    return;
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(
                    $helper->__('Unable to find lookbook to delete.')
                );
            }

        }
        $this->_redirect('*/*/');
    }

    public function enableAction() {
        if($ids = $this->getRequest()->getParam('lookbook_ids')) {
            $count = 0;
            foreach($ids as $_lookbookId) {
                $lookbook = Mage::getModel('lookbookImage/lookbook')->load($_lookbookId);
                if($lookbook && $lookbook->getId()) {
                    $lookbook->setIsActive(true)->save();
                    $count++;
                }
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('lookbookImage')->__('%s lookbooks have been updated',$count)
            );
        }
        $this->_redirect('*/*/');
    }

    public function disableAction() {
        if($ids = $this->getRequest()->getParam('lookbook_ids')) {

            $count = 0;
            foreach($ids as $_lookbookId) {
                $lookbook = Mage::getModel('lookbookImage/lookbook')->load($_lookbookId);
                if($lookbook && $lookbook->getId()) {
                    $lookbook->setIsActive(false)->save();
                    $count++;
                }
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('lookbookImage')->__('%s lookbooks have been updated',$count)
            );
        }
        $this->_redirect('*/*/');
    }

    protected function _initLookbook($id) {
        $lookbook = Mage::getModel('lookbookImage/lookbook')->load($id);
        if($lookbook && $lookbook->getId()) {
            Mage::register('current_lookbook',$lookbook);
            return $lookbook;
        }
        return false;
    }

    protected function _uploadImage($fileId,$fileLocation) {
        $uploader = new Mage_Core_Model_File_Uploader($fileId);
        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(true);
        $result = $uploader->save(
            Mage::getBaseDir('media') .DS . $fileLocation
        );
        return $result;
    }
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('lindybop/lookbookImage');
    }
}