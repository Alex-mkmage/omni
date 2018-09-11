var storelocator = {
		latitude : null, 
		longitude : null,
		current: false,
		height: 230,
		scrollWheel:true,
		mapTypeControl:true,
		scaleControl:true,
		
		showPosisiton: function(position){
			storelocator.latitude = position.coords.latitude
        	storelocator.longitude = position.coords.longitude
		},
		
		showError: function(error){
			switch(error.code) {
				case error.PERMISSION_DENIED:
		    		console.log("User denied the request for Geolocation.");
		    	break;
				case error.POSITION_UNAVAILABLE:
					console.log("Location information is unavailable.");
				break;
				case error.TIMEOUT:
					console.log("The request to get user location timed out.");
				break;
				case error.UNKNOWN_ERROR:
					console.log("An unknown error occurred.");
				break;
		    }
		}, 
		decorate: function(){
			setTimeout(function(){
				jQuery('.search-result .item').each(function(){
					var height = jQuery(this).outerHeight(true);
					console.log(height);
					if (storelocator.height < height){
						storelocator.height = height;
					}
				});
				
				jQuery('.search-result .item').each(function(){
					jQuery(this).css('height', storelocator.height);				
				});
			}, 500)
		}
};

var options = {
		 // enableHighAccuracy: true,
		  timeout: 5000,
		  maximumAge: Infinity
};

jQuery(document).ready(function($){
	navigator.geolocation.getCurrentPosition(storelocator.showPosisiton,storelocator.showError, options);
	
	$(".storelocator select").chosen({disable_search_threshold: 10});
	
	if ("geolocation" in navigator) {
	
	}else{
		$('#btn-current-location').remove();
	}
	
	/*var urlRegion = pluginUrl + 'storelocator/json/region';
	var urlSearch = pluginUrl + 'storelocator/json/search';*/

	$('#btn-current-location').click(function(){
		
		navigator.geolocation.getCurrentPosition(function(position) {
			storelocator.latitude  = position.coords.latitude;
			storelocator.longitude = position.coords.longitude;			
		});
		
		storelocator.current = true;
	});
	
	$('#storelocator-search').submit(function(){
		
			$('.loader-ajax').removeClass('hidden');
			var path= $(this).serialize();
			//storelocator.latitude = '40.158342';
			//storelocator.longitude = '-76.990336';
			if (storelocator.current==true){
				path += '&latitude=' + storelocator.latitude + '&longitude='+storelocator.longitude + '&current=true';
			}else{
				path += '&latitude=' + storelocator.latitude + '&longitude='+storelocator.longitude;
			}
			$.post(urlSearch, path, function(response){
				$('.loader-ajax').addClass('hidden');
				if (response.error==false){
					
					if (response.action=="viewresult"){				
						$('#search-result').html(response.result);
						if (response.maps.totalRecords==0){
							var mapOptions = {
									center : new google.maps.LatLng(0, 0),
									zoom : 1,
									mapTypeId : google.maps.MapTypeId.ROADMAP
							};
							var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
						}else{
								
							initGMap(response.maps, $);
						}
					}
			
				};
			},'json');
		
		return false;
	});
		
});



infoWindow = new Array();

function initGMap(mapsJson, $) {
	
	var bounds = new google.maps.LatLngBounds();
	if (mapsJson.totalRecords==0){
		return;
	}
	var mapOptions = {
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		zoom: 1,
		scrollwheel: storelocator.scrollWheel,
		scaleControl: storelocator.scaleControl,
		mapTypeControl:storelocator.mapTypeControl
	};
	
	var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
	
	if (mapsJson.totalRecords==1){
		
		var myLatlng = new google.maps.LatLng(mapsJson.items[0].latitude,mapsJson.items[0].longitude);
		bounds.extend(myLatlng);
		
		var marker = new google.maps.Marker({
		      position: myLatlng,
		      map: map,
		      title: mapsJson.items[0].title,
		      icon: image,
		      
		  });

		infoWindow[0] = new InfoBox({
	         content: mapsJson.items[0].content,
	         disableAutoPan: false,
	         maxWidth: 279,
	         pixelOffset: new google.maps.Size(-139, -286),
	         zIndex: null,
	         boxStyle: {
	            background: "none",
	            opacity: 1,
	            width: "279px",
	            top:"-10px"
	        },
	        closeBoxMargin: "0 0 0 0",
	        closeBoxURL: closeButton,
	        infoBoxClearance: new google.maps.Size(1, 1)
	    });
		
		google.maps.event.addListener(marker, 'click', function() {
			infoWindow[0].open(map, this);			   
		});
		 
		map.fitBounds(bounds);
	    map.panToBounds(bounds); 
	    
	  
	  
	  
		return;
	}else{
		
		var zoomChangeBoundsListener =
		    google.maps.event.addListener(map, 'bounds_changed', function(event) {
		        google.maps.event.removeListener(zoomChangeBoundsListener);
		        map.setZoom( Math.min( zoomData, map.getZoom() ) );
		    });
	
		$.each(mapsJson.items, function(index) {
			if (this.latitude!='0' && this.longitude!='0'){
				
				var myLatlng = new google.maps.LatLng(this.latitude,this.longitude);
				bounds.extend(myLatlng);
				
				var marker = new google.maps.Marker({
				      position: myLatlng,
				      map: map,
				      title: this.title,
				      icon: image
				 });
			    
		     
				infoWindow[index] = new InfoBox({
			         content: this.content,
			         disableAutoPan: false,
			         maxWidth: 279,
			         pixelOffset: new google.maps.Size(-139, -286),
			         zIndex: null,
			         boxStyle: {
			            background: "none",
			            opacity: 1,
			            width: "279px",
			            top:"-10px"
			        },
			        closeBoxMargin: "0 0 0 0",
			        closeBoxURL: closeButton,
			        infoBoxClearance: new google.maps.Size(1, 1)
			    });
				
				google.maps.event.addListener(marker, 'click', function() {
					infoWindow[index].open(map, this);			   
				});
			
				map.fitBounds(bounds);
			    map.panToBounds(bounds); 
			}
			
		});
	}

}
