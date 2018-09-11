var jq = document.createElement('script');
jq.src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js";
document.getElementsByTagName('head')[0].appendChild(jq);
// ... give time for script to load, then type (or see below for non wait option)
jQuery.noConflict();

$(".accordion").click(function() {
	console.log("Test");
    $(this).next(".panel").slideToggle();
  } );


$(".item").click(function(){
	var display = $(this).attr("id");
	console.log(display);
	$(".prodCurrentHide > div").hide();
	$("#p" + display).show();
});

