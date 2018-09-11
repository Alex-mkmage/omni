<?php					
class Ey_RelatedAjax_IndexController extends Mage_Core_Controller_Front_Action {        

	public function indexAction() {

		$attrs = Mage::app()->getRequest()->getPost();
		$p_id = $attrs['p_id'];
		
		$RelProduct = Mage::getModel('catalog/product')->load($p_id);
		$relIDs = $RelProduct->getRelatedProductIds();

		$block = $this->getLayout()->createBlock('core/template')->setTemplate('ey/relatedajax/related-ajax.phtml');
		$block->setData('related_ids', $relIDs);
		
		echo $block->toHtml();
		exit(0);
		
	}

}
