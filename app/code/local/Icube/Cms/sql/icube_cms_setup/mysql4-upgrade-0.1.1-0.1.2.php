<?php
/*
 * Description:
 * - update text to Home Page for SEO purpose position
 */

$installer = $this;
$installer->startSetup();
try {
    //set config skin
    $config = Mage::getModel('core/config');
    $content =<<<EOF
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css' />
<!-- BEGIN LivePerson Monitor. -->
<script type="text/javascript">
    window.lpTag={site:'25366500',_v:'1.1',protocol:location.protocol,events:{bind:function(app,ev,fn){lpTag.defer(function(){lpTag.events.bind(app,ev,fn);});},trigger:function(app,ev,json){lpTag.defer(function(){lpTag.events.trigger(app,ev,json);});}},defer:function(fn){this._defL=this._defL||[];this._defL.push(fn);},load:function(src,chr,id){var t=this;setTimeout(function(){t._load(src,chr,id);},0);},_load:function(src,chr,id){var url=src;if(!src){url=this.protocol+'//'+((this.ovr&&this.ovr.domain)?this.ovr.domain:'lptag.liveperson.net')+'/tag/tag.js?site='+this.site;}var s=document.createElement('script');s.setAttribute('charset',chr?chr:'UTF-8');if(id){s.setAttribute('id',id);}s.setAttribute('src',url);document.getElementsByTagName('head').item(0).appendChild(s);},init:function(){this._timing=this._timing||{};this._timing.start=(new Date()).getTime();var that=this;if(window.attachEvent){window.attachEvent('onload',function(){that._domReady('domReady');});}else{window.addEventListener('DOMContentLoaded',function(){that._domReady('contReady');},false);window.addEventListener('load',function(){that._domReady('domReady');},false);}if(typeof(window._lptStop)=='undefined'){this.load();}},_domReady:function(n){if(!this.isDom){this.isDom=true;this.events.trigger('LPT','DOM_READY',{t:n});}this._timing[n]=(new Date()).getTime();}};lpTag.init();
</script>
<!-- END LivePerson Monitor. -->
EOF;
    $config->saveConfig('design/footer/absolute_footer', $content, 'default');

    unset ($config);

} catch (Exception $e) {
    throw new Exception('CMS PAGE UPDATE FAILS. ' . $e->getMessage());
}



$installer->endSetup();

