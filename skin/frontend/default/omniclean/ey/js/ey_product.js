jQuery(function ($) {
    if($('.product-image > iframe').length && $('.product-image > .product-other-images').length && $('.more-views').length){
    	console.log('check');
    	
    	$('.more-views').on('click', '.iwd-pv-thumb-image', function(){
    		if($(this).hasClass('inset-360')){
                if($('#arqspin-iframe').attr('src') == ''){
                    $('#arqspin-iframe').attr('src', $('#arqspin-iframe').data('src'));
                }
    			$('.product-image').removeClass('open');
    		} else {
    			$('.product-image').addClass('open');
    		}
    		
    	});
    }
});