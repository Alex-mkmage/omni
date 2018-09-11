<?php

class Ey_IpDetect_Model_Observer
{

	protected $_debug;
	protected $_routeInfo;
	
	protected $_visitorData = array(
		'country' => '',
		'distributor' => ''
	);
	protected $_visitorCountry = null;
	protected $_visitorDistributor = null;

	protected $_customerInfo = null;

	public function __construct() {
		$this->_debug = Mage::getStoreConfig('ey_ipdetect/ey_ipdetect_debug/debug',Mage::app()->getStore());
		$this->_routeInfo = array(
			Mage::app()->getRequest()->getRouteName(),
			Mage::app()->getRequest()->getActionName(),
			Mage::app()->getRequest()->getControllerName()
		);
	}
	
	protected function _setCookies($session,$countryCode,$visitorCookieData) {
		$cookieCountry = Mage::getSingleton('core/cookie')->get('current_country');		
		$cookieDistributer = Mage::getSingleton('core/cookie')->get('current_distributer');
		$saveUser = false; $country = null; $distributer = null;
		if (!$cookieCountry) {			
			$country = array(
				'code'          => $visitorCookieData['countryCode'],
				'name'          => $visitorCookieData['countryName'],
				'distibutors'   => $visitorCookieData['dist']
			);				
			Mage::getSingleton('core/cookie')->set('current_country', serialize($country), 315360000, '/');		
			Mage::log(array($this->_routeInfo,$country),null,'ipdetect.log');	
			$session->setData('current_country', $country);	
			$this->_visitorCountry = $country;
		}			
		if (!$cookieDistributer) {							
			if ($countryCode == 'US' || $countryCode == 'CA') {				
				$distCollection = $distModel = Mage::getModel('distributor/distributor')->getCollection();
				$omniInternationalDist = $distCollection->addFieldToFilter('title','Omni International')->getFirstItem();
				Mage::getSingleton('core/cookie')->set('current_distributer', serialize($omniInternationalDist->getData()), 315360000, '/');
				$session->setData('current_distributer', $omniInternationalDist->getData());
				$session->setData('show_dist', false);
				$this->_visitorDistributor = $omniInternationalDist->getData();
			} else {				
				if (count($visitorCookieData['dist']) == 1) {					
					Mage::getSingleton('core/cookie')->set('current_distributer', serialize($visitorCookieData['dist']), 315360000, '/');
					$session->setData('current_distributer', $visitorCookieData['dist'][0]);
					$session->setData('show_dist', false);
					$distributor = $visitorCookieData['dist'][0];
					$this->_visitorDistributor = $visitorCookieData['dist'][0];
				}					
			}							
		} else {
			 $session->setData('show_dist', false);
		}
	}
	
	protected function _setUserInfo() {
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
			if (!is_null($this->_visitorCountry) || !is_null($this->_visitorDistributor)) {
				$ipdetectModel = Mage::getModel('ipdetect/ipdetect');
				
				$ipDetectCollection = $ipdetectModel->getCollection();
				$ipDetectCollection->addFieldToFilter('visitor_id',Mage::getSingleton('customer/session')->getCustomer()->getId());
				
				if($ipDetectCollection->getSize() > 0) {
					$ipdetectModel = $ipDetectCollection->getFirstItem();
					if (!is_null($this->_visitorCountry)) {
						$this->_visitorData['country'] = $this->_visitorCountry;
					}
					if (!is_null($this->_visitorDistributor)) {
						$this->_visitorData['distributor'] = $this->_visitorDistributor;
					}
					$ipdetectModel->save();
				} else {				
					$ipdetectModel->setData('visitor_id',Mage::getSingleton('customer/session')->getCustomer()->getId());
					if (!is_null($this->_visitorCountry)) {
						$this->_visitorData['country'] = $this->_visitorCountry;
					}
					if (!is_null($this->_visitorDistributor)) {
						$this->_visitorData['distributor'] = $this->_visitorDistributor;
					}
					$ipdetectModel->setData('visitor_data',base64_encode(json_encode($this->_visitorData)));
					$ipdetectModel->save();
				}				
			}
		}
	}
	
	protected function _customerHasInfo() {
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$ipDetectCollection = Mage::getModel('ipdetect/ipdetect')->getCollection();
		$ipDetectCollection->addFieldToFilter('visitor_id',$customer->getId());
		
		if ($ipDetectCollection->getSize()) {
			$this->_customerInfo = $ipDetectCollection->getFirstItem();		
			return true;
		}	
		return false;
	}

	public function handleVisitor($observer) {

		Mage::getSingleton('core/cookie')->set('visInfoDebug', 3, 0, '/');		
		
		if (Mage::getSingleton('customer/session')->isLoggedIn() && $this->_customerHasInfo()) {
			
			if(!is_null($this->_customerInfo)) {
				$info = json_decode(base64_decode($this->_customerInfo->getData('visitor_data')),true);
								
				if(isset($info['country']) && !empty($info['country'])) {
					Mage::getSingleton('core/cookie')->set('current_country', serialize($info['country']), 315360000, '/');			
					Mage::getSingleton('core/session')->setData('current_country', $info['country']);
				}			
					
				if(isset($info['distributor']) && !empty($info['distributor'])) {
					Mage::getSingleton('core/cookie')->set('current_distributer', serialize($info['distributor']), 315360000, '/');			
					Mage::getSingleton('core/session')->setData('current_distributer', $info['distributor']);
				}	
							
			}

		} else {
		
			$countryCode = isset($_SERVER['HTTP_CF_IPCOUNTRY']) && !empty($_SERVER['HTTP_CF_IPCOUNTRY']) ? $_SERVER['HTTP_CF_IPCOUNTRY'] : '';		
			$session = Mage::getSingleton('core/session');
		
			if (is_null($session->getData('show_dist'))) {				
				$session->setData('show_dist', true);				
			}
		
			$visitorCookie = Mage::getSingleton('core/cookie')->get('visInfo');		

			if (!$visitorCookie) {			
				if ($this->_debug) {
					$countryCode = Mage::getStoreConfig('ey_ipdetect/ey_ipdetect_debug/country',Mage::app()->getStore());
				}
							
				$countryName = isset($countryCode) && !empty($countryCode) ? Mage::getModel('directory/country')->loadByCode($countryCode)->getName() : '';
							
				if (!empty($countryCode)) {			
					$distModel = Mage::getModel('distributor/distributor');
					$distList = $distModel->getDistributorList($countryCode);
					$dist = null;
				
					foreach ($distList as $dL) {
						$dist[] = $dL->getData();
					}
				
					$visitorCookie = base64_encode(json_encode(array('countryCode' => $countryCode,'countryName' => $countryName,'dist' => $dist)));				
				
					Mage::getSingleton('core/cookie')->set('visInfo', $visitorCookie, 315360000, '/');						
				}			
			}
		
			$visitorCookieData = json_decode(base64_decode($visitorCookie), true);
		
			$this->_setCookies($session,$countryCode,$visitorCookieData);	
			
			if(Mage::getSingleton('customer/session')->isLoggedIn()) {
				$this->_setUserInfo();
			}
					
		}

	}
	
	public function handleVisitorAfterCountrySave($observer) {
		
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {

			$session = Mage::getSingleton('core/session');

			$ipdetectModel = Mage::getModel('ipdetect/ipdetect');
			
			$ipDetectCollection = $ipdetectModel->getCollection();
			$ipDetectCollection->addFieldToFilter('visitor_id',Mage::getSingleton('customer/session')->getCustomer()->getId());
				
			if ($ipDetectCollection->getSize() > 0) {
				$ipdetectModel = $ipDetectCollection->getFirstItem();
				$this->_visitorData = json_decode(base64_decode($ipdetectModel->getData('visitor_data')),true);
				if (!is_null($session->getData('current_country'))) {
					$this->_visitorData['country'] = $session->getData('current_country');
					$ipdetectModel->setData('visitor_data',base64_encode(json_encode($this->_visitorData)));
				}
				$currentCountry = $session->getData('current_country');
				if (count($currentCountry['distibutors']) == 1) {
					$this->_visitorData['distributor'] = $currentCountry['distributors'];
					$ipdetectModel->setData('visitor_data',base64_encode(json_encode($this->_visitorData)));
					$session->setData('current_distributer', $currentCountry['distributors']);
					Mage::getSingleton('core/cookie')->set('current_distributer', serialize($currentCountry['distributors']), 315360000, '/');
				} else {
					$this->_visitorData['distributor'] = null;
					$ipdetectModel->setData('visitor_data',base64_encode(json_encode($this->_visitorData)));
					$session->setData('current_distributer', null);
					Mage::getSingleton('core/cookie')->set('current_distributer', '', time() - 100, '/');
					$session->setData('show_dist', true);
				}
				$ipdetectModel->save();
			} else {				
				$ipdetectModel->setData('visitor_id',Mage::getSingleton('customer/session')->getCustomer()->getId());
				if (!is_null($session->getData('current_country'))) {
					$this->_visitorData['country'] = $session->getData('current_country');
					$ipdetectModel->setData('visitor_data',base64_encode(json_encode($this->_visitorData)));
				}				
				$ipdetectModel->save();
			}
		
		}
	
	}
	
	public function handleVisitorAfterDistributorSave($observer) {
		
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
		
			$session = Mage::getSingleton('core/session');
		
			$ipdetectModel = Mage::getModel('ipdetect/ipdetect');
		
			$ipDetectCollection = $ipdetectModel->getCollection();
			$ipDetectCollection->addFieldToFilter('visitor_id',Mage::getSingleton('customer/session')->getCustomer()->getId());
	
			if($ipDetectCollection->getSize() > 0) {
				$ipdetectModel = $ipDetectCollection->getFirstItem();
				$this->_visitorData = json_decode(base64_decode($ipdetectModel->getData('visitor_data')),true);
				if (!is_null($session->getData('current_distributer'))) {
					$this->_visitorData['distributor'] = $session->getData('current_distributer');
				}
			} else {				
				$ipdetectModel->setData('visitor_id',Mage::getSingleton('customer/session')->getCustomer()->getId());
				if (!is_null($session->getData('current_distributer'))) {
					$this->_visitorData['distributor'] = $session->getData('current_distributer');
				}
				$ipdetectModel->setData('visitor_data',base64_encode(json_encode($this->_visitorData)));
			}				

			$ipdetectModel->save();		
			
			$session->setData('show_dist', false);	
		
		}
		
	}
	
	public function beforeAddToQuote($observer) {
	
		if(is_null(Mage::getSingleton('core/session')->getData('current_distributer'))) {
			Mage::getSingleton('core/session')->addError('Select distributor before proceeding.');
			$url = Mage::helper('core/http')->getHttpReferer() ? Mage::helper('core/http')->getHttpReferer() : Mage::getUrl();
			Mage::app()->getFrontController()->getResponse()->setRedirect($url);
			Mage::app()->getResponse()->sendResponse();
			exit ;
		}
	
	}
	
	public function afterAddToQuote($observer) {
	
		$cnd1 = Mage::app()->getRequest()->getParam('quote_id');
		$cnd2 = Mage::app()->getRequest()->getParam('dist_id');
	
		$quoteId = !empty($cnd1) ? $cnd1 : '';
		$distId = !empty($cnd2) ? $cnd2 : '';
		
		$model = Mage::getModel('ipdetect/quoteextend');
		
		if(!empty($quoteId) && !empty($distId)) {
			$model->setData('quote_id',$quoteId);
			$model->setData('distributor_id',$distId);
		}
		
		$model->save();
	}
	
}

