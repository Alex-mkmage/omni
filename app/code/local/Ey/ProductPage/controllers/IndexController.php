<?php class Ey_ProductPage_IndexController extends Mage_Core_Controller_Front_Action {

        public function indexAction() {
            $id = $this->getRequest()->getParam('id');

            if($id) {
                $_category = Mage::getModel('catalog/category')->load($id);
                $product = Mage::getModel('catalog/product');

                //load the category's products as a collection
                $_productCollection = $product->getCollection()
                    ->addAttributeToSelect('*')
                    ->addCategoryFilter($_category)
                    ->load();

                // build an array for conversion
                $json_products = array();
                foreach ($_productCollection as $_product) {
                    $_product->getData();
                    $json_products[] = array(
                                'name' => ''.$helper->htmlEscape($_product->getName()).'',
                                'url' => ''.$_product->getProductUrl().'',
                                'description' => ''.nl2br($_product->getShortDescription()).'',
                                'price' => ''.$_product->getFormatedPrice().''),
                                'image' => ''.$_product->getImage().'');
                }

                $data = json_encode($items);

                echo $data;
            } 
        }
    }
