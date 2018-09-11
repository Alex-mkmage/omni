/*******************************
* jQuery equalHeightColumns
* Author: Matthew Peach
* Version: 1.3 //add index counter
* Description: 
* This plugin will calculate the height of the columns specified and make all of them
* the equal height of the tallest column.
* Usage: $('.items-to-target').equalHeightColumns();

* How to change row size at different intervals:
$('.inventory-list .inventory-item a').equalHeightColumns(4,function(count){
    var winWidth = $(window).width();
    var count = (winWidth <= 1200 && winWidth >= 900)? 3 : count;
    return count;
});
* Note affected elements can not have transitions or the math gets messed up.
********************************/

(function($){
  jQuery.fn.equalHeightColumns = function(count,onRun){
    var obj = this;

    count = (!count)? obj.length : count;

    if(onRun == undefined){
      onRun = function(){return count;};
    }
    
    resizeColumns(this);
    $(window).on('resize.equalHeightColumns',function(){
      resizeColumns(obj);
    });
    
    return this.each(function(){
      return true;  
    });
    
    function resizeColumns(obj){

      newCount = onRun(count);

      var maxHeight = 0;
      var tallest_col;
      var length = obj.length;

      obj.css({"height":"auto"});
      
      var countIndex = 0;
      obj.each(function(i){
        if($(this).outerHeight() > maxHeight){
          tallest_col = $(this);
          maxHeight = $(this).outerHeight();
        }
        ++countIndex;
        //If the loop has counted the specific number specified in the "count" variable
        if(countIndex >= newCount || i == (obj.length-1) ){
          //Specify the base number for the slice method, which is the index of the element in the full array minus the number of current interations
          var base = i - (countIndex - 1);
          //add the height to the group of elements
          $(obj).slice(base,i+1).css({"height":maxHeight+"px"});
          //Reset the maxHeight to ) for the next row of elements and reset the count loop.
          maxHeight = 0;
          countIndex = 0;
        }
      });
      
      // obj.css({"height":maxHeight+"px"});
    };
  };
})(jQuery);
jQuery.noConflict();