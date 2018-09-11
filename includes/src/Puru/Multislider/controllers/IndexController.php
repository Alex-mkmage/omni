<?php
class Puru_Multislider_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/multislider?id=15 
    	 *  or
    	 * http://site.com/multislider/id/15 	
    	 */
    	/* 
		$multislider_id = $this->getRequest()->getParam('id');

  		if($multislider_id != null && $multislider_id != '')	{
			$multislider = Mage::getModel('multislider/multislider')->load($multislider_id)->getData();
		} else {
			$multislider = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($multislider == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$multisliderTable = $resource->getTableName('multislider');
			
			$select = $read->select()
			   ->from($multisliderTable,array('multislider_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$multislider = $read->fetchRow($select);
		}
		Mage::register('multislider', $multislider);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}