<?php

/**
 * @author         Vladimir Popov
 * @copyright      Copyright (c) 2017 Vladimir Popov
 */
class VladimirPopov_WebForms_Model_Captcha
    extends Mage_Core_Model_Abstract
{

    protected $_publicKey;
    protected $_privateKey;
    protected $_theme = 'standard';

    public function setPublicKey($value)
    {
        $this->_publicKey = $value;
    }

    public function setPrivateKey($value)
    {
        $this->_privateKey = $value;
    }

    public function setTheme($value)
    {
        $this->_theme = $value;
    }

    // cURL method
    function getCurlData($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $curlData = curl_exec($curl);
        curl_close($curl);
        return $curlData;
    }

    // file_get_contents method
    function verifyResponse($url, $data)
    {
        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        return $verify;
    }

    public function verify($response)
    {

        //Get user ip
        $ip = $_SERVER['REMOTE_ADDR'];

        //Build up the url
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $full_url = $url . '?secret=' . $this->_privateKey . '&response=' . $response . '&remoteip=' . $ip;

        if (Mage::getStoreConfig('webforms/captcha/validation_function') == 'file_get_contents') {
            $data = array(
                'secret' => $this->_privateKey,
                'response' => $response,
            );
            $data = json_decode($this->verifyResponse($url, $data));
        } else {
            //Get the response back decode the json
            $data = json_decode($this->getCurlData($full_url));
        }

        //Return true or false, based on users input
        if (isset($data->success) && $data->success == true) {
            return true;
        }

        return false;
    }

    public function getHtml()
    {
        $languageCode = substr(Mage::getStoreConfig('general/locale/code'), 0, 2);

        $output = '';
        $rand = Mage::helper('webforms')->randomAlphaNum();
        if (!Mage::registry('webforms_recaptcha_gethtml')) {
            $output .= '<script>var reWidgets =[];</script>';
        }

        $output .= <<<HTML
<script>
    function recaptchaCallback{$rand}(response){
        $('re{$rand}').value = response;
        Validation.validate($('re{$rand}'));
        for(var i=0; i<reWidgets.length;i++){
            if(reWidgets[i].id != '{$rand}')
                grecaptcha.reset(reWidgets[i].inst);
        }
    }
    reWidgets.push({id:'{$rand}',inst : '',callback: recaptchaCallback{$rand}});

</script>
<div id="g-recaptcha{$rand}" class="g-recaptcha"></div>
<input type="hidden" id="re{$rand}" name="recapcha{$rand}" class="required-entry"/>
HTML;

        if (!Mage::registry('webforms_recaptcha_gethtml')) {
            $output .= <<<HTML
<script>
    function recaptchaOnload(){
        for(var i=0; i<reWidgets.length;i++){
            reWidgets[i].inst = grecaptcha.render('g-recaptcha'+reWidgets[i].id,{
                'sitekey' : '{$this->_publicKey}',
                'theme' : '{$this->_theme}',
                'callback': reWidgets[i].callback
            });
        }
    }
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=recaptchaOnload&render=explicit&hl={$languageCode}" async defer></script>
HTML;
        }
        if (!Mage::registry('webforms_recaptcha_gethtml')) Mage::register('webforms_recaptcha_gethtml', true);

        return $output;
    }
}
