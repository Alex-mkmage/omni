<?php

class Icube_Distributor_IndexController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
    {

    	$code = $this->getRequest()->getParam('code');

    	if($code){
    		$distributor = Mage:: getModel('distributor/distributor')->getDistributorList($code);

    		$data = array();
            if($distributor->getData()){
        		foreach ($distributor as $value) {
        			//$data['country'] = 
                    $data['distributers'][] = $value->getData();
        		}                
            }else{
                $data['distributers'] = null;
            }

            $data['country'] = Mage::getModel('directory/country')->loadByCode($code)->getName();
    		echo json_encode($data);
            $this->setCountryAction($code);
    	}
    }

    public function getAllDistributorsAction()
    {
		$distributor = Mage:: getModel('distributor/distributor')->getAll();

		$data = array();
        if($distributor->getData()){
    		foreach ($distributor as $value) {
    			//$data['country'] = 
                $data['distributers'][] = $value->getData();
    		}                
        }else{
            $data['distributers'] = null;
        }
		echo json_encode($data);
    	
    }

    public function setCountryAction($code = null){

        if(!$code){
            $countryCode = $this->getRequest()->getParam('country');
        }else{
            $countryCode = $code;
        }

        $countryName = Mage::getModel('directory/country')->loadByCode($countryCode)->getName();
        $distributor = Mage:: getModel('distributor/distributor')->getDistributorList($countryCode);

        $data = array();
        foreach ($distributor as $value) {
            $data[] = $value->getData();
        }

        $country = array(
                'code'          => $countryCode,
                'name'          => $countryName,
                'distibutors'   => $data
            );

        $session = Mage::getSingleton('core/session');
        $session->setData('current_country', $country);

    }

    public function getCountryAction(){
        $current_country = Mage::getSingleton('core/session')->getData('current_country');

        echo $current_country['name'];
    }

    public function setDistributerAction(){
        $distributorId = $this->getRequest()->getParam('distributerId');
        $data = Mage:: getSingleton('distributor/distributor')->getDistributorData($distributorId)->getData();

        foreach ($data as $value) {
            $distributor=$value;
        }

        $session = Mage::getSingleton('core/session');
        $session->setData('current_distributer', $distributor);
    }

    public function getCurrentDistributerAction(){
        $distributer = Mage::getSingleton('core/session')->getData('current_distributer');

        echo json_encode($distributer);   
    }



    public function getRegionAction(){

        $country = $this->getRequest()->getParam('code');
        $country_name = Mage::getModel('directory/country')->loadByCode($countryCode);
        Mage::log($country);
        $regions = Mage::getModel('directory/region_api')->items($country);

    }

    public function saveCookieAction(){

        $session = Mage::getSingleton('core/session');
        
        $period = 2592000;

        Mage::getSingleton('core/cookie')->set('current_country', 
                                            serialize($session->getData('current_country')), 
                                            $period,
                                            '/'
                                            );

        Mage::getSingleton('core/cookie')->set('current_distributer', 
                                            serialize($session->getData('current_distributer')),
                                            $period,
                                            '/'
                                            );
    }

}