<?php 
class Puru_Multislider_Block_Multislider extends Mage_Core_Block_Template
{
	private $_display = '0';
	
	public function _prepareLayout()	{
		return parent::_prepareLayout();
	}
    
	public function getMultislider() { 
		if (!$this->hasData('multislider')) {
			$this->setData('multislider', Mage::registry('multislider'));
		}
		return $this->getData('multislider');			
	}
	
	public function setDisplay($display){
		$this->_display = $display;
	}
	
	public function getBannerCollection() {
		$collection = Mage::getModel('multislider/multislider')->getCollection()
			->addFieldToFilter('status',1)
			->addFieldToFilter('is_home',$this->_display);
		if ($this->_display == Puru_Multislider_Helper_Data::DISP_CATEGORY){
			$current_category = Mage::registry('current_category')->getId();
			$collection->addFieldToFilter('categories',array('finset' => $current_category));
		}
		
		$current_store = Mage::app()->getStore()->getId();
		$banners = array();
		foreach ($collection as $banner) {
			$stores = explode(',',$banner->getStores());
			if (in_array(0,$stores) || in_array($current_store,$stores))
			//if ($banner->getStatus())
				$banners[] = $banner;
		}
		return $banners;
	}
	
	public function getDelayTime() {
		$delay = (int) Mage::getStoreConfig('multislider/settings/time_delay');
		return $delay;
	}
	
	public function getShowDescription(){
		return (int)Mage::getStoreConfig('multislider/settings/show_description');
	}
	
	public function isShowSimple(){
		return (int)Mage::getStoreConfig('multislider/settings/show_simple');
	}
	
	public function getPauseTime(){
		return (int)Mage::getStoreConfig('multislider/settings/pause_time');
	}
	
	
	public function getCaptionOpacity(){
		$opacity = (float)Mage::getStoreConfig('multislider/settings/caption_opacity');
		return $opacity;
	}
	
	public function getSlicesCount(){
		return (int)Mage::getStoreConfig('multislider/settings/slices_count');
	}
	
	public function getBoxesCount(){
		return (int)Mage::getStoreConfig('multislider/settings/boxes_count');
	}
	
	public function getHoverPause(){
		return (int)Mage::getStoreConfig('multislider/settings/hover_pause');
	}
	
	public function getNavigationType(){
		return (int)Mage::getStoreConfig('multislider/settings/navigation_type');
	}
	
	public function getCaptionEffect(){
		return (string)Mage::getStoreConfig('multislider/settings/caption_effect');
	}
	
	
	
	
	public function getListStyle(){
		return (int)Mage::getStoreConfig('multislider/settings/list_style');
	}
	
	public function getImageWidth() {
		return (int)Mage::getStoreConfig('multislider/settings/image_width');
	}
	
	public function isBannerEnable() {
		return (int)Mage::getStoreConfig('multislider/settings/banner_enable');
	}
	public function getImageHeight() {
		return (int)Mage::getStoreConfig('multislider/settings/image_height');
	}
}