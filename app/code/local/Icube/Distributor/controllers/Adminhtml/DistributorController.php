<?php

class Icube_Distributor_Adminhtml_DistributorController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->_title($this->__('Distributor'))
					->loadLayout()
					->_setActiveMenu('distributor');

				return $this;
		}


	   public function indexAction()
	    {
	        $this->_title($this->__('Distributor'))->_title($this->__('Distributor List'));
	        $this->loadLayout();
	        $this->_setActiveMenu('distributor/list');
	        $this->renderLayout();
	    }


		public function gridAction() 
		{
			    $this->_title($this->__("Distributor List"));

				$this->_initAction();
				$this->getResponse()->setBody(
					$this->getLayout()->createBlock('distributor/adminhtml_distributor_list_grid')->toHtml());
				$this->renderLayout();
		}

		public function uploadAction() 
		{
			    // $this->_title($this->__("Distributor"));
			    $this->_title($this->__("Upload Distributor"));

				$this->_initAction();
				$this->renderLayout();
		}


		public function editAction()
		{			    

			$this->_title($this->__("Distributor"));
		    $this->_title($this->__("View Item"));
			
			$id = $this->getRequest()->getParam("id");
			$model = Mage::getModel("distributor/distributor")->load($id);


			if ($model->getId()) {
				Mage::register("distributor_data", $model);
				$this->loadLayout();
				
				$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
				$this->_addContent(
						$this->getLayout()
							->createBlock("distributor/adminhtml_distributor_edit"))
					 ->_addLeft(
					 		$this->getLayout()
					 				->createBlock("distributor/adminhtml_distributor_edit_tabs"));
				
				$this->renderLayout();
			} 
			else {
				Mage::getSingleton("adminhtml/session")->addError(Mage::helper("distributor")->__("Item does not exist."));
				$this->_redirect("*/*/");
			}
		}


		public function upload_file($file,$id){
			if(!empty($_FILES[$file]['name'])){
				$result = '';
				$saveTo = Mage::getBaseDir('media').DS.'Distributor'.DS.$id;

				try{
					$uploader = new Varien_File_Uploader($file);
					$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$result = $uploader->save($saveTo);

					if($result==false){
						Mage::throwExeption($this->__('Imaage Upload Failed'));
					}
	                $result['fieldname'] = $file;
	                $result['url'] = 'Distributor'.DS.$id.DS.$result['name'] ;

	                return $result;

				}catch(Exception $e){
					throw new Exception($this->__("Image Upload Failed: Make sure PHP can write to: ". $saveTo) ,0, $e);					
				}
			}
		}

		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();

				if ($post_data) {

					Mage::log($post_data);
					//die();

					$id = $this->getRequest()->getParam("id");

					if(isset($post_data['icon']['delete']) && $post_data['icon']['delete']==1){
						unlink(Mage::getBaseDir('media').DS.$post_data['icon']['value']);
						$post_data['icon'] = '';

					}elseif(isset($_FILES['icon']['name'])){
						$result = $this->upload_file('icon',$id);
						
						if($result){
							$post_data['icon'] = $result['url'];
							Mage::log($result);
						}
					}

					if(isset($post_data['image']['delete']) && $post_data['image']['delete']==1){
						unlink(Mage::getBaseDir('media').DS.$post_data['image']['value']);
						$post_data['image'] = '';

					}elseif(isset($_FILES['image']['name'])){
						$result = $this->upload_file('image',$id);
						
						if($result){
							$post_data['image'] = $result['url'];
							Mage::log($result);
						}
					}

					try {
						$model = Mage::getModel("distributor/distributor")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Distributor was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setDistributorData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setDistributorData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}


		public function newAction()
		{

			$this->_title($this->__("Distributor"));
			$this->_title($this->__("Distributor"));
			$this->_title($this->__("New Item"));

	        $id   = $this->getRequest()->getParam("id");
			$model  = Mage::getModel("distributor/distributor")->load($id);

			$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register("distributor_data", $model);

			$this->loadLayout();
			$this->_setActiveMenu("distributor/distributor");

			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Distributor Manager"), Mage::helper("adminhtml")->__("Distributor Manager"));
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Distributor Description"), Mage::helper("adminhtml")->__("Distributor Description"));


			$this->_addContent($this->getLayout()->createBlock("distributor/adminhtml_distributor_edit"))->_addLeft($this->getLayout()->createBlock("distributor/adminhtml_distributor_edit_tabs"));

			$this->renderLayout();
		}

		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("distributor/distributor")->load($this->getRequest()->getParam("id"));

						$id = $model->getData('store_locator_id')?
			                $model->getData('store_locator_id'):$model->getId();
			            if ($id) {
			                $iwdModel = Mage::getModel('storelocator/stores')->load($id);
			                $iwdModel->delete();
			            }

						$model->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
					$model = Mage::getModel("distributor/distributor")->load($id);

					$id = $model->getData('store_locator_id')?
					    $model->getData('store_locator_id'):$model->getId();
					if ($id) {
					    $iwdModel = Mage::getModel('storelocator/stores')->load($id);
					    $iwdModel->delete();
					}

					$model->delete();
				}

				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			

	    public function doUploadAction()
	    {
	    	$data = $this->getRequest()->getPost();
	    	if ($data) 
	    	{
	    		try{
	    			/* Upload CSV file to local folder var/icube */
		    		$upload = Mage::getModel('distributor/upload');
	                $uploadResult = $upload->uploadFile();

	                if($uploadResult){
	                	/* Get Data from CSV file*/	
	                	$delimiter = new SplFileObject($uploadResult);
	                	$delimiter = $delimiter->getCsvControl();
		                $csv = new Varien_File_Csv();
	                	$csv->setLineLength(1000);
	                	$csv->setDelimiter($delimiter[0]);
	                	$csv->setEnclosure($delimiter[1]);
						$file = $csv->getData($uploadResult);
						/* Clear all Data on table icube_product_compliance */
						Mage::getResourceSingleton('distributor/distributor')->cleanBunches();
						$model = Mage::getModel('distributor/distributor');

						for($i=1; $i<count($file); $i++)
						{
							$value['title'] 		= $file[$i][0];
							$value['active'] 		= $file[$i][1];
							$value['phone'] 		= $file[$i][2];
							$value['country_code']	= $file[$i][3];
							$value['region']		= $file[$i][4];
							$value['street']		= $file[$i][5];
							$value['city']			= $file[$i][6];
							$value['postal_code']	= $file[$i][7];
							$value['desc']			= $file[$i][8];
							$value['latitude']		= $file[$i][9];
							$value['longitude']		= $file[$i][10];
							$value['stores']		= $file[$i][11];
							$value['website']		= $file[$i][12];
							$value['icon']			= $file[$i][13];
							$value['image']			= $file[$i][14];
							$value['position']		= $file[$i][15];

							$model->setData($value);
							$model->save();
						}
							// Mage::log($value);
						
	                }
			        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Import has been done successfuly.'));
			        $this->_redirect('*/*/index');
	                
	    		}
	    		catch (Exception $e) {
		               Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		               $this->_redirect('*/*/upload');
		           }
	    	}   
		}		

	    protected function _isAllowed()
	    {
	        return Mage::getSingleton('admin/session')->isAllowed('icube_distributor_upload');
	    }

}
