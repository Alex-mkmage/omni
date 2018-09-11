$myslidertest = jQuery.noConflict();

$myslidertest(document).ready(function(){
    popuphtml = '<div id="popup" class="popup" style="display:none;"><div><ul class="news_navigate"><li class="popup_news_prev"><a title="Previous" onClick="previous_news()" href="#">&nbsp;</a></li><li class="popup_news_next"><a title="Next"  onClick="next_news()" href="#">&nbsp;</a></li></ul></div><div  class="cancel" onclick="closePopup();">X</div><div id="popupdiv"><div class="news-title-popup"><h2 class="news-title-popup left" >First News </h2><div style="clear:both;"></div></div><span class="news-date-popup"></span><div class="news-contain"><div class="news-image-popup"><img align="left" alt="Thumbnail" src="#"></div><div class="news-content-popup"><p></p></div><div class="popup-social-buttons"><p></p></div></div></div></div><div class="overlay-fixed" onclick="closePopup();" id="news-overlay" style="display:none;"></div>';
    jQuery('body').append(popuphtml);

$myslidertest(this).keyup(function(event) {
		if (event.which == 27) { // 27 is 'Ecs' in the keyboard
			closePopup();  // function close pop up
		}  	
	});

});

var current_obj = '';
var currentIndex = 0;
var myclassname= '';
function previous_news()
{
    currentIndex = parseInt(currentIndex) - 1;
    var newsHtml = jQuery('.'+myclassname+currentIndex).html();
    var n = jQuery('.'+myclassname+(currentIndex-1)).html();
    jQuery('.'+myclassname+currentIndex).trigger('click');
            jQuery('#popupdiv').css("opacity","1");
    if(n == null)
    {
       
            jQuery('.popup_news_prev').hide();
    }
    else if(newsHtml)
    {
         
            jQuery('.popup_news_next').show();
    }
    else
    {
        jQuery('.popup_news_prev').hide();
    }
}
function next_news()
{
    currentIndex = parseInt(currentIndex) + 1;
    var newsHtml = jQuery('.'+myclassname+currentIndex).html();

    var n = jQuery('.'+myclassname+(currentIndex+1)).html();
     jQuery('.'+myclassname+currentIndex).trigger('click');
            jQuery('#popupdiv').css("opacity","1");
    if(n == null)
    {
       
            jQuery('.popup_news_next').hide();
        
    }
    else if(newsHtml)
    {
        
            jQuery('.popup_news_prev').show();
    }
    else
    {
        jQuery('.popup_news_next').hide();
    }
}
function openPopup(thisDiv,sliderIndex,currentClass)
{
    currentIndex = sliderIndex;
    current_obj = thisDiv;
    myclassname = currentClass;
    currentIndex = parseInt(currentIndex);
    var shareMedia = '';
    var nextItem = jQuery('.'+myclassname+(currentIndex+1)).html();
    
    var title = jQuery(thisDiv).html();

    var all = jQuery(thisDiv).parent().parent().parent().html();
    var newsdate = jQuery(thisDiv).parent().parent().parent().children('.news-date').html();

    var newsimg = jQuery(thisDiv).parent().parent().parent().children('.news-img-large').html();
    var newstext = jQuery(thisDiv).parent().parent().parent().children('.news-content-full').html();
    
    var socialmedia = jQuery(thisDiv).parent().parent().parent().children('.news-social-buttons').html();
    
    if(socialmedia != '')
    {
        shareMedia = socialmedia;
     // jQuery('.popup-social-buttons').html(socialmedia);      
    }

   // jQuery('.news-title-popup').html('<strong>' + title +'</strong>');
    //jQuery('.news-date-popup').html(newsdate);
    //jQuery('.news-image-popup').html(newsimg).fadeIn(5000);
    //jQuery('.news-content-popup').html(newstext).fadeIn(5000);
    
    var nextHtml = '<div class="news-title-popup"><strong>'+ title +'</strong></div><span class="news-date-popup">'+newsdate+'</span><div class="news-contain"><div class="news-image-popup">'+newsimg+'</div><div class="news-content-popup">'+newstext+'</div><div class="popup-social-buttons">'+shareMedia+'</div></div>';
    
    jQuery('#popup').css('display','block');
    jQuery('#popupdiv').fadeTo('fast', 0.3, function() {
		jQuery(this).html(nextHtml).fadeTo('fast', 1);
    });
  
    if(nextItem == null) {
        jQuery('.popup_news_next').hide();
    } else {
        jQuery('.popup_news_next').show();
        }
    if(currentIndex == 1) {
        jQuery('.popup_news_prev').hide();
    } else {
        jQuery('.popup_news_prev').show();
    }
    jQuery('#news-overlay').show();
}
function closePopup()
{
    jQuery('#news-overlay').hide();
    document.getElementById('popup').style.display = 'none';
}