$j(document).ready(function() {
      $j("#owl-demo").owlCarousel({

      navigation : false,
      slideSpeed : 300,
      paginationNumbers : true,
      paginationSpeed : 400,
      singleItem : true,
      responsive : true

  });
  
    $j(".owl-wrapper .owl-item").each(function(i) {
        $j(this).addClass("img-" + (i+1));
      });
  
  $j(".owl-pagination .owl-page").each(function(i) {
    _i = i+1;
    text = $j(".img-"+_i+" .item > img").attr("alt");
        $j(this).find(".owl-numbers").replaceWith(text);
      });
});