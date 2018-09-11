<?php

class Ey_Distributor_Adminhtml_MdistributorController extends Mage_Adminhtml_Controller_Action
{
    public function saveAction()
    {
        $post_data=$this->getRequest()->getPost();

        if ($post_data) {
            //Save IWD Store
            $this->_saveIwdStore($post_data);

            Mage::log($post_data);
            //die();

            $id = $this->getRequest()->getParam("id");

            if(isset($post_data['icon']['delete']) && $post_data['icon']['delete']==1){
                unlink(Mage::getBaseDir('media').DS.$post_data['icon']['value']);
                $post_data['icon'] = '';

            }elseif(isset($_FILES['icon']['name'])){
                copy(
                    Mage::getBaseDir('media').'/iwd/storelocator/'.$post_data['icon'],
                    Mage::getBaseDir('media').DS.'Distributor'.DS.$id.DS.$post_data['icon']
                );
                $post_data['icon'] = 'Distributor'.DS.$id.DS.$post_data['icon'];
            }

            if(isset($post_data['image']['delete']) && $post_data['image']['delete']==1){
                unlink(Mage::getBaseDir('media').DS.$post_data['image']['value']);
                $post_data['image'] = '';

            }elseif(isset($_FILES['image']['name'])){
                copy(
                    Mage::getBaseDir('media').'/iwd/storelocator/'.$post_data['image'],
                    Mage::getBaseDir('media').DS.'Distributor'.DS.$id.DS.$post_data['image']
                );
                $post_data['image'] = 'Distributor'.DS.$id.DS.$post_data['image'];
            }

            try {
                $model = Mage::getModel("distributor/distributor")
                    ->addData($post_data)
                    ->setId($id)
                    ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Distributor was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setDistributorData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/distributor/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/distributor/");
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setDistributorData($this->getRequest()->getPost());
                $this->_redirect("*/distributor/edit", array("id" => $id));
                return;
            }

        }
        $this->_redirect("*/distributor/");
    }

    /**
     * @param array $data
     */
    protected function _saveIwdStore(&$data){
        // check if data sent
        if ($data) {
            $data = $this->_filterPostData($data);
            //init model and set data
            $model = Mage::getModel('storelocator/stores');

            $id = $this->getRequest()->getParam('store_locator_id')?
                $this->getRequest()->getParam('store_locator_id'):$this->getRequest()->getParam('entity_id');
            if ($id) {
                $model->load($id);
            }

            //ICON
            if(isset($data['icon']['delete']) && $data['icon']['delete'] == 1){
                unset($data['icon']['delete']);
                $data['icon'] = '';
            }

            if(isset($data['icon']['value'])){
                $data['icon'] = $data['icon']['value'];
            }

            //IMAGE
            if(isset($data['image']['delete']) && $data['image']['delete'] == 1){
                unset($data['image']['delete']);
                $data['image'] = '';
            }

            if(isset($data['image']['value'])){
                $data['image'] = $data['image']['value'];
            }

            //update stores
            //icon
            if(isset($_FILES['icon']['name']) and (file_exists($_FILES['icon']['tmp_name']))){
                try
                {
                    $path = Mage::getBaseDir('media') . DS . 'iwd/storelocator/';
                    $uploader = new Varien_File_Uploader('icon');

                    $uploader->setAllowedExtensions(array('jpg','png','gif','jpeg'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    $destFile = $path . $_FILES['icon']['name'];
                    $filename = $uploader->getNewFileName($destFile);
                    $result  = $uploader->save($path, $filename);

                    $data['icon'] = 'iwd/storelocator/' . $result['file'];
                    $iconPath = $result['file'];
                }
                catch(Exception $e)
                {
                    unset($data['icon']);
                    $this->_getSession()->addError($e->getMessage());
                    $this->_getSession()->setFormData($data);
                    $this->_redirect('*/*/edit', array('page_id' => $this->getRequest()->getParam('entity_id')));
                }
            }

            //image
            if(isset($_FILES['image']['name']) and (file_exists($_FILES['image']['tmp_name']))){
                try
                {
                    $path = Mage::getBaseDir('media') . DS . 'iwd/storelocator/';
                    $uploader = new Varien_File_Uploader('image');

                    $uploader->setAllowedExtensions(array('jpg','png','gif','jpeg'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    $destFile = $path . $_FILES['image']['name'];
                    $filename = $uploader->getNewFileName($destFile);
                    $result  = $uploader->save($path, $filename);

                    $data['image'] = 'iwd/storelocator/' . $result['file'];
                    $imagePath = $result['file'];
                }
                catch(Exception $e)
                {
                    unset($data['image']);
                    $this->_getSession()->addError($e->getMessage());
                    $this->_getSession()->setFormData($data);
                    $this->_redirect('*/*/edit', array('page_id' => $this->getRequest()->getParam('entity_id')));
                }
            }

            // try to save it
            try {

                /*$stores = $data['stores'];
                unset($data['stores']);*/

                $website = $data['website'];
                if (!preg_match('/http/i', $website)){
                    $data['website'] = 'http://' . $website;
                }

                $data['country_id'] = $data['country_code'];
                $data['is_active'] = $data['active'];

                $model->setData($data);
                // save the data
                $model->save();

                $data['store_locator_id'] = $model->getId();
                if(isset($iconPath)){
                    $data['icon'] = $iconPath;
                } if(isset($imagePath)){
                    $data['image'] = $imagePath;
                }

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('storelocator')->__('The store has been saved.'));

                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                //update stores
                // $this->_updateStores($stores, $model->getId());

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/distributor/edit', array('store_id' => $model->getId(), '_current'=>true));
                    return;
                }

                // go to grid
                $this->_redirect('*/distributor/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }catch (Exception $e) {
                $this->_getSession()->addException($e, Mage::helper('storelocator')->__('An error occurred while saving the store information.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/distributor/edit', array('page_id' => $this->getRequest()->getParam('entity_id')));
            return;
        }
        $this->_redirect('*/distributor/');
    }

    /**
     * @param $data
     * @return array
     */
    protected function _filterPostData($data){
        $data = $this->_filterDates($data, array('custom_theme_from', 'custom_theme_to'));
        return $data;
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('ey_distributor');
    }
}
