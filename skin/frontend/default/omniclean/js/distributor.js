$j(document).ready(function() {
var counter1 = 0;
var bcp = {
	getUrl: function(){
		var location = window.location;
		return location.origin;
	},
	init: function(array){
	  if(counter1 === 0){
		bcp.distributorArrays(array);
		counter1 = 1;
	  }else {
		$j('.fancybox-inner').css({height: 'auto', minHeight: '430px'});
		return;
	  }
	},
	europeList1: $j('.europe').find('.left'),
	europeList2: $j('.europe').find('.right'),
	namericaList: $j('.north_america').find('ul'),
	samericaList: $j('.south_america').find('ul'),
	selectOption: $j('#ddSelectCountry'),
	apacificList: $j('.asia_pacific').find('ul'),
	listItem: $j('<li>'),
	list: $j('<ul class="left">'),
	list2: $j('<ul class="right">'),
	counter: 0,
	europeArr: [],
	europeArr1: [],
	europeArr2: [],
	namericaArr: [],
	samericaArr: [],
	otherArr: [],
	apacificArr: [],
	countries: {
		'AC': 'Ascension Island',
		'AD': 'Andorra',
		'AE': 'United Arab Emirates',
		'AF': 'Afghanistan',
		'AG': 'Antigua and Barbuda',
		'AI': 'Anguilla',
		'AL': 'Albania',
		'AM': 'Armenia',
		'AN': 'Netherlands Antilles',
		'AO': 'Angola',
		'AQ': 'Antarctica',
		'AR': 'Argentina',
		'AS': 'American Samoa',
		'AT': 'Austria',
		'AU': 'Australia',
		'AW': 'Aruba',
		'AX': 'Aland Islands',
		'AZ': 'Azerbaijan',
		'BA': 'Bosnia and Herzegovina',
		'BB': 'Barbados',
		'BD': 'Bangladesh',
		'BE': 'Belgium',
		'BF': 'Burkina Faso',
		'BG': 'Bulgaria',
		'BH': 'Bahrain',
		'BI': 'Burundi',
		'BJ': 'Benin',
		'BM': 'Bermuda',
		'BN': 'Brunei Darussalam',
		'BO': 'Bolivia',
		'BR': 'Brazil',
		'BS': 'Bahamas',
		'BT': 'Bhutan',
		'BV': 'Bouvet Island',
		'BW': 'Botswana',
		'BY': 'Belarus',
		'BZ': 'Belize',
		'CA': 'Canada',
		'CC': 'Cocos (Keeling) Islands',
		'CD': 'Congo, Democratic Republic',
		'CF': 'Central African Republic',
		'CG': 'Congo',
		'CH': 'Switzerland',
		'CI': 'Cote D\'Ivoire (Ivory Coast)',
		'CK': 'Cook Islands',
		'CL': 'Chile',
		'CM': 'Cameroon',
		'CN': 'China',
		'CO': 'Colombia',
		'CR': 'Costa Rica',
		'CS': 'Czechoslovakia (former)',
		'CU': 'Cuba',
		'CV': 'Cape Verde',
		'CX': 'Christmas Island',
		'CY': 'Cyprus',
		'CZ': 'Czech Republic',
		'DE': 'Germany',
		'DJ': 'Djibouti',
		'DK': 'Denmark',
		'DM': 'Dominica',
		'DO': 'Dominican Republic',
		'DZ': 'Algeria',
		'EC': 'Ecuador',
		'EE': 'Estonia',
		'EG': 'Egypt',
		'EH': 'Western Sahara',
		'ER': 'Eritrea',
		'ES': 'Spain',
		'ET': 'Ethiopia',
		'EU': 'European Union',
		'FI': 'Finland',
		'FJ': 'Fiji',
		'FK': 'Falkland Islands (Malvinas)',
		'FM': 'Micronesia',
		'FO': 'Faroe Islands',
		'FR': 'France',
		'FX': 'France, Metropolitan',
		'GA': 'Gabon',
		'GB': 'Great Britain (UK)',
		'GD': 'Grenada',
		'GE': 'Georgia',
		'GF': 'French Guiana',
		'GG': 'Guernsey',
		'GH': 'Ghana',
		'GI': 'Gibraltar',
		'GL': 'Greenland',
		'GM': 'Gambia',
		'GN': 'Guinea',
		'GP': 'Guadeloupe',
		'GQ': 'Equatorial Guinea',
		'GR': 'Greece',
		'GS': 'S. Georgia and S. Sandwich Isls.',
		'GT': 'Guatemala',
		'GU': 'Guam',
		'GW': 'Guinea-Bissau',
		'GY': 'Guyana',
		'HK': 'Hong Kong',
		'HM': 'Heard and McDonald Islands',
		'HN': 'Honduras',
		'HR': 'Croatia (Hrvatska)',
		'HT': 'Haiti',
		'HU': 'Hungary',
		'ID': 'Indonesia',
		'IE': 'Ireland',
		'IL': 'Israel',
		'IM': 'Isle of Man',
		'IN': 'India',
		'IO': 'British Indian Ocean Territory',
		'IQ': 'Iraq',
		'IR': 'Iran',
		'IS': 'Iceland',
		'IT': 'Italy',
		'JE': 'Jersey',
		'JM': 'Jamaica',
		'JO': 'Jordan',
		'JP': 'Japan',
		'KE': 'Kenya',
		'KG': 'Kyrgyzstan',
		'KH': 'Cambodia',
		'KI': 'Kiribati',
		'KM': 'Comoros',
		'KN': 'Saint Kitts and Nevis',
		'KP': 'Korea (North)',
		'KR': 'Korea (South)',
		'KW': 'Kuwait',
		'KY': 'Cayman Islands',
		'KZ': 'Kazakhstan',
		'LA': 'Laos',
		'LB': 'Lebanon',
		'LC': 'Saint Lucia',
		'LI': 'Liechtenstein',
		'LK': 'Sri Lanka',
		'LR': 'Liberia',
		'LS': 'Lesotho',
		'LT': 'Lithuania',
		'LU': 'Luxembourg',
		'LV': 'Latvia',
		'LY': 'Libya',
		'MA': 'Morocco',
		'MC': 'Monaco',
		'MD': 'Moldova',
		'ME': 'Montenegro',
		'MG': 'Madagascar',
		'MH': 'Marshall Islands',
		'MK': 'F.Y.R.O.M. (Macedonia)',
		'ML': 'Mali',
		'MM': 'Myanmar',
		'MN': 'Mongolia',
		'MO': 'Macau',
		'MP': 'Northern Mariana Islands',
		'MQ': 'Martinique',
		'MR': 'Mauritania',
		'MS': 'Montserrat',
		'MT': 'Malta',
		'MU': 'Mauritius',
		'MV': 'Maldives',
		'MW': 'Malawi',
		'MX': 'Mexico',
		'MY': 'Malaysia',
		'MZ': 'Mozambique',
		'NA': 'Namibia',
		'NC': 'New Caledonia',
		'NE': 'Niger',
		'NF': 'Norfolk Island',
		'NG': 'Nigeria',
		'NI': 'Nicaragua',
		'NL': 'Netherlands',
		'NO': 'Norway',
		'NP': 'Nepal',
		'NR': 'Nauru',
		'NT': 'Neutral Zone',
		'NU': 'Niue',
		'NZ': 'New Zealand (Aotearoa)',
		'OM': 'Oman',
		'PA': 'Panama',
		'PE': 'Peru',
		'PF': 'French Polynesia',
		'PG': 'Papua New Guinea',
		'PH': 'Philippines',
		'PK': 'Pakistan',
		'PL': 'Poland',
		'PM': 'St. Pierre and Miquelon',
		'PN': 'Pitcairn',
		'PR': 'Puerto Rico',
		'PS': 'Palestinian Territory, Occupied',
		'PT': 'Portugal',
		'PW': 'Palau',
		'PY': 'Paraguay',
		'QA': 'Qatar',
		'RE': 'Reunion',
		'RS': 'Serbia',
		'RO': 'Romania',
		'RU': 'Russian Federation',
		'RW': 'Rwanda',
		'SA': 'Saudi Arabia',
		'SB': 'Solomon Islands',
		'SC': 'Seychelles',
		'SD': 'Sudan',
		'SE': 'Sweden',
		'SG': 'Singapore',
		'SH': 'St. Helena',
		'SI': 'Slovenia',
		'SJ': 'Svalbard & Jan Mayen Islands',
		'SK': 'Slovak Republic',
		'SL': 'Sierra Leone',
		'SM': 'San Marino',
		'SN': 'Senegal',
		'SO': 'Somalia',
		'SR': 'Suriname',
		'ST': 'Sao Tome and Principe',
		'SU': 'USSR (former)',
		'SV': 'El Salvador',
		'SY': 'Syria',
		'SZ': 'Swaziland',
		'TC': 'Turks and Caicos Islands',
		'TD': 'Chad',
		'TF': 'French Southern Territories',
		'TG': 'Togo',
		'TH': 'Thailand',
		'TJ': 'Tajikistan',
		'TK': 'Tokelau',
		'TM': 'Turkmenistan',
		'TN': 'Tunisia',
		'TO': 'Tonga',
		'TP': 'East Timor',
		'TR': 'Turkey',
		'TT': 'Trinidad and Tobago',
		'TV': 'Tuvalu',
		'TW': 'Taiwan',
		'TZ': 'Tanzania',
		'UA': 'Ukraine',
		'UG': 'Uganda',
		'UK': 'United Kingdom',
		'UM': 'US Minor Outlying Islands',
		'US': 'United States',
		'UY': 'Uruguay',
		'UZ': 'Uzbekistan',
		'VA': 'Vatican City State (Holy See)',
		'VC': 'Saint Vincent & the Grenadines',
		'VE': 'Venezuela',
		'VG': 'British Virgin Islands',
		'VI': 'Virgin Islands (U.S.)',
		'VN': 'Viet Nam',
		'VU': 'Vanuatu',
		'WF': 'Wallis and Futuna Islands',
		'WS': 'Samoa',
		'YE': 'Yemen',
		'YT': 'Mayotte',
		'YU': 'Serbia and Montenegro (former Yugoslavia)',
		'ZA': 'South Africa',
		'ZM': 'Zambia',
		'ZR': 'Zaireic',
		'ZW': 'Zimbabwe'
	},
	distributorArrays: function(arr){
		bcp.numDistributors = arr;
		bcp.numDistributors.forEach(function(distributor){
		  var europeDis = distributor.distributorRegion === 'europe',
			  namerica = distributor.distributorRegion === 'north america',
			  samerica = distributor.distributorRegion === 'south america',
			  other = distributor.distributorRegion === 'other',
			  apacific = distributor.distributorRegion === 'asia/pacific';
			if(europeDis){
		  		bcp.europeArr.push(distributor);
			}
			if(namerica){
		  		bcp.namericaArr.push(distributor);
			}
			if(samerica){
		  		bcp.samericaArr.push(distributor);
			}
			if(other){
		  		bcp.otherArr.push(distributor);
			}
			if(apacific){
		  		bcp.apacificArr.push(distributor);
			}
		});
		bcp.splitEurope();
	},
	splitEurope: function(){
		if(bcp.europeArr.length){
		  var europeLength = bcp.europeArr.length;
		  bcp.europeArr.forEach(function(dis){
			  if(bcp.counter <= (europeLength/2)){
				bcp.europeArr1.push(dis);
				bcp.counter++;
			  }else if(bcp.counter > (europeLength/2)) {
				bcp.europeArr2.push(dis);
			  }
		  });
		}
		bcp.buildList();
	},
	sortCountries: function(){
		if(bcp.europeArr){
			console.log('Sort Countries2', bcp.europeArr);
			bcp.europeArr.sort();
		}
		if(bcp.namericaArr){
			bcp.namericaArr.sort();
		}
		if(bcp.samericaArr){
			bcp.samericaArr.sort();
		}
		if(bcp.otherArr){
			bcp.otherArr.sort();
		}
		if(bcp.apacificArr){
			bcp.apacificArr.sort();
		}
		
	},
	createList: function(scope){
	  var country = scope,
		  countryCode = country.countryCode.toUpperCase(),
		  countryName = country.country,
		  altVal = countryCode+' '+countryName;
		if(countryCode){
			var listItem = '<li class="countryLink"><a href="#" alt="'+altVal+'">'+countryName+'</a></li>';
		  return listItem;
		}
  	},
	addEventListeners: function(){
	  	$j('.fancybox-inner').css({height: 'auto', minHeight: '430px'});
		$j('li.countryLink').on('click', function(){
			var values = $j(this).children().attr('alt'),
			    countryi = values.substr(0,values.indexOf(' ')),
			    countryNamei = values.substr(values.indexOf(' ')+1),
			    dataCountry = countryi,
		  	    dataCountryName = countryNamei;

			$j("#dataCountry").val(countryi);
		$j("#dataCountryName").val(countryNamei);
		localStorage.setItem('countryCode',dataCountry);
		localStorage.setItem('countryName',dataCountryName);
		bcp.getDistribution(event);
		});
	},
	buildList: function(){
		if(bcp.europeArr.length){
		  bcp.europeArr1.forEach(function(_thisCountry){
			  bcp.europeList1.append(bcp.createList(_thisCountry));
		  });
		  bcp.europeArr2.forEach(function(_thisCountry){
			  bcp.europeList2.append(bcp.createList(_thisCountry));
		  });
		}
		if(bcp.namericaArr.length){
		  bcp.namericaArr.forEach(function(_thisCountry){
			  bcp.namericaList.append(bcp.createList(_thisCountry));
		  });
		}
		if(bcp.samericaArr.length){
		  bcp.samericaArr.forEach(function(_thisCountry){
			  bcp.samericaList.append(bcp.createList(_thisCountry));
		  });
		}
		if(bcp.otherArr.length){
		  bcp.otherArr.forEach(function(otherdis){
			  bcp.selectOption.append($j("<option />").val(otherdis.countryCode).text(otherdis.country));
		  });
		}else if(!bcp.otherArr.length){
		  $j('.country.other').css('display', 'none');
		}
		if(bcp.apacificArr.length){
		  bcp.apacificArr.forEach(function(_thisCountry){
			  bcp.apacificList.append(bcp.createList(_thisCountry));
		  });
		}
		bcp.sortCountries();
		bcp.addEventListeners();
		bcp.setCountry();

	},
createDistributorInfo: function(distributor, country, countryName){
	var countrySelection = $j("#countrySection"),
	    distributorSection = $j("#distributorSection"),
		distributorList = $j('#distributorList'),
		loading = $j('.loading'),
		body = $j('body');

	if(distributor){
	if(country == 'US' || country == 'CA' || country == 'USA') {
		bcp.setDistributer(distributor[0]['id']);
	} else {
		loading.show();
		var n = distributor.length;
		var html = "";
		html="<ul>";
		for(var i=0; i<n; i++){
		  	var title = distributor[i]['title'],
			phone =distributor[i]['phone'],
			id =distributor[i]['id'],
			street = distributor[i]['street'],
			city = distributor[i]['city'],
			postal_code = distributor[i]['postal_code'],
			website = distributor[i]['website'];
			html += "<li class='distributorID' alt='"+id+"'><a href='#' class='distributor-name'>" + title + "</a>";
			html += "<p><span class='phone'>" + phone + '</span>';
			html += "<br/>" + street + ", ";
			if(city && city !== "NULL"){
			  html += city + ", ";
			}
			if(postal_code && postal_code !== "NULL"){
			  html += postal_code + ", ";
			}
			if(website && website !== "NULL"){
			  html += "<br><a href=" + website + " target='_blank' class='website-link' >WEBSITE</a></p></li>";
			}
		}
		countrySelection.hide();
		distributorSection.show();
		distributorList.html(html);
		loading.hide();
		body.removeClass('waiting');
		bcp.setDistributorEventList();
	}
	}else{
		html = "<p>No distributor found</p>";
  		countrySelection.hide();
  		distributorSection.show();
	    distributorList.html(html);
	    body.removeClass('waiting');
	    loading.hide();
	}
},
getDistribution: function(event){
	var ddd = event.target;
	$j('.loading').show();
	$j('body').addClass('waiting');
	var country = $j('#dataCountry').val();
	var countryName = $j('#dataCountryName').val();
	$j.ajax({
		url: bcp.getUrl()+'/distributor/index/index',
		type: "GET",
		data: {code: country},
		success: function(data) {
			results = JSON.parse(data);
			var distributor = results['distributers'];
			bcp.createDistributorInfo(distributor, country, countryName);
		}
	});
	$j('#distributorSection h3.country-name').text(countryName);
	},
	createFinalArray: function(results){
		var distributors = results.distributers,
			countryCodes = [],
			finalArray = [],
			disInCountry = [],
			alreadyAdded = [];
		distributors.forEach(function(distributor){
		  var cc = distributor.country_code.toUpperCase(),
			distributorRegion = distributor.region.toLowerCase(),
			dt = distributor.title.toLowerCase(),
			distributorWebsite = distributor.website,
			distributorCity = distributor.city,
			distributorStreet = distributor.street,
			distributorPostal = distributor.postal_code;
			countryCode = cc.replace("\\s+","");
			countryCodes.push(countryCode);
		  //create object map to push to finalArray
		  var distributorObj = {
			distributorTitle: dt.replace("\\s+",""),
			countryCode: cc.replace("\\s+",""),
			countryName: bcp.countries[countryCode],
			distributorRegion: distributorRegion,
			distributorWebsite: distributorWebsite,
			distributorCity: distributorCity,
			distributorStreet: distributorStreet,
			distributorPostal: distributorPostal
		  }
		  finalArray.push(distributorObj);
		});
		finalArray.sort();
		countryCodes.sort();
		var result = bcp.getCount(countryCodes);
		finalArray.forEach(function(distributor, index){
		  distributor.numOfDistributors = result[distributor.countryCode];
		});
		for(var i=0;i<finalArray.length;i++){
		var numDis = {
			number_of_distributors: finalArray[i].numOfDistributors,
			country: finalArray[i].countryName,
			distributorRegion: finalArray[i].distributorRegion,
			countryCode: finalArray[i].countryCode

		  } 
		  disInCountry.push(numDis);
		}
	  finalResult = disInCountry.filter(function (a) {
		var key = a.country + '|' + a.numofdistributors;
		if (!this[key]) {
			this[key] = true;
			return true;
		}
	}, Object.create(null));
	if(finalResult.length){
	  bcp.init(finalResult);
	}
},
getAllDistributors: function(){
	$j.ajax({
		url: bcp.getUrl()+'/distributor/index/getAllDistributors',
		type: "GET",
		success: function(data) {
			results = JSON.parse(data);
			bcp.createFinalArray(results);
		}
	});
},
getCount: function(arr){
	var result = {};
	for (var val of arr) result[val] = result[val] + 1 || 1;
	return result;
},
setDistributorEventList: function(id){
	$j('#distributorList').on('click', 'li', function(){
		var value = $j(this).attr('alt');
		bcp.setDistributer(value);
	});  
},
setCountry: function(){
	$j('#ddSelectCountry').on('change', function(){
		var value = $j(this).val(),
			text = $j( "#ddSelectCountry option:selected" ).text(),
			dataCountry = value,
			dataCountryName = text;
		$j("#dataCountry").val(dataCountry);
		$j("#dataCountryName").val(dataCountryName);
		localStorage.setItem('countryCode', dataCountry);
		localStorage.setItem('countryName', dataCountryName);
		bcp.getDistribution(event);
	});  
},
setDistributer: function(id){
	$j('.loading').show();
	$j('body').addClass('waiting');
	$j.ajax({
		  url: bcp.getUrl()+'/distributor/index/setDistributer',
		  type: "GET",
		  data: {distributerId: id},
		  success: function(data){
			bcp.doneButton();
		  }
	});
},
doPrev: function(){
	$j('#distributorSection').hide();
	$j('#countrySection').show();
},
doneButton: function(){
	$j.ajax({
		url: bcp.getUrl()+'/distributor/index/getCountry',
		type: "GET",
		success: function(data){
			console.log(data);
			if(localStorage.getItem('countryName')){
				$j('#changeLocation').html(localStorage.getItem('countryName'));
				console.log('true');
			}else {
				 var countryInit = $j('h3.country-name').text();
				 console.log(countryInit);
				 $j('#changeLocation').html(countryInit);
			}
			
			if($j('#rememberMe').is(':checked')){
				$j.ajax({
					url: bcp.getUrl()+'/distributor/index/saveCookie',
					type: "POST",
				success: function(data){
					bcp.closePopup();
				}
			});
			}else{
				bcp.closePopup();
			}
			$j('.loading').hide();
		}
	});
},
closePopup: function(){
	$j.fancybox.close();
	$j('#distributorSection').hide();
	$j('#countrySection').show();
	$j('body').removeClass('waiting');
	var currentPageModule = '<?php echo Mage::app()->getRequest()->getModuleName(); ?>';
	// refresh page if the current page is below
	if (currentPageModule == 'IWD_StoreLocator' || currentPageModule == 'checkout') {
	  location.reload();
	};
	bcp.refresh();
  },
  refresh: function(){
	var currentPageModule = '<?php echo Mage::app()->getRequest()->getModuleName(); ?>';
	// disable cart link
	bcp.refreshCartLink();
	// show/hide price, add to cart btn, and quote btn
	bcp.refreshPriceQuoteBtn();
	// refresh product custom options (in PDP)
	bcp.refreshCustomOptions();
	// if current page is quote page
	if (currentPageModule == 'qquoteadv') {
	  bcp.refreshPriceQuotePage();
	};
  },
  refreshCartLink: function(){
	var country   = $j('#dataCountry').val();
	var cartLinks   = $j('a[href="<?php echo Mage::getUrl("checkout/cart")?>"]');
	if(country == 'US' || country == 'CA' || country == 'USA') {
	  //enable all cart link
	  cartLinks.removeClass('disableClick');
	  //header link 
	  cartLinks.closest('.block-cart').show();
	  //cart page nav
	  cartLinks.closest('.tab-title').removeClass('disable');
	}else{
	  //disable all cart link
	  cartLinks.addClass('disableClick');
	  //header link 
	  cartLinks.closest('.block-cart').hide();
	  //cart page nav
	  cartLinks.closest('.tab-title').addClass('disable');
	  cartLinks.closest('.tab-title.disable').on('click', function(e) {
	  return false;
	  });
	}
	cartLinks.each(function() {
	  $j(this).on('click', function(e) {
		if ($j(this).hasClass('disableClick')) {
		  return false;
		}else{
		  return true;
		}
	  });
	});
  },
  refreshPriceQuoteBtn: function(){
	var country = $j('#dataCountry').val(),
	  price = $j('.price-box'),
	  btnQuote = $j('.btn-quote'),
	  btnQuoteBe = $j('.btn-quote.btn-quote-be'),
	  btnAddToCart = $j('.btn-cart');
	
	if(country == 'US' || country == 'CA' || country == 'USA') {
	  price.show();
	  btnQuote.show();
	  btnQuoteBe.show();
	  btnAddToCart.show();
	}else{
	  price.hide();
	  btnQuote.show();
	  btnQuoteBe.show();
	  btnAddToCart.hide();
	}
  },
  refreshPriceQuotePage: function(){
	var country = $j('#dataCountry').val(),
	  price = $j('#quotelist .price-box'),
	  noPrice = $j('#quotelist .alt-no-price');
	if(country == 'US' || country == 'CA' || country == 'USA') {
	  price.show();
	  noPrice.hide();
	}else{
	  price.hide();
	  noPrice.show();
	}
	// reload data distributer
	$j.ajax({
		  url: bcp.getUrl()+'/distributor/index/getCurrentDistributer',
		  type: "GET",
		  success: function(data){
			results = JSON.parse(data);
			var html = '<h4>' + results['title'] + '</h4>'+
			  '<p>' + results['phone'] + '</p>'+
			  '<p>' + results['street'] + ', ' +results['postal_code'] + '</p>' +
			  '<p><a href="' + results['website'] + '">WEBSITE</a></p>';
		$j('#qquote-tbl-billing .left').html(html);
		  }
	});
  },
  refreshCustomOptions: function(){
	// product custom options (in PDP)
	var country = $j('#dataCountry').val();
	if (typeof optionsPrice !== 'undefined') {
	  var customOptElm = $j('.product-custom-option');
	  if (customOptElm.length) {
		customOptElm.each(function(){
		  if ($(this).nodeName == 'SELECT') {
			$j(this).find('option').each(function() {
			  var price = $j(this).attr('price');
			  if (price) {
				var text = $j(this).text();
				var formatedPrice = optionsPrice.formatPrice(price);
				formatedPrice = (formatedPrice.charAt(0) != '-' && formatedPrice.charAt(0) != '+')? '+' + formatedPrice : formatedPrice;
				
				if(country == 'US' || country == 'CA' || country == 'USA') {
				  if (text.indexOf(formatedPrice) <= -1) {
					text = text + '' + formatedPrice;
				  }
				}else{
				  if (text.indexOf(formatedPrice) > -1) {
					text = text.replace(formatedPrice, '');
				  }
				}
				
				$j(this).text(text);
			  };
			});
		  };

		  if ($j(this).is(':radio') || $j(this).is(':checkbox')) {
			var label = $j("label[for='"+$j(this).attr('id')+"']");
			if(country == 'US' || country == 'CA' || country == 'USA') {
			  label.find('.price-notice').show();
			}else{
			  label.find('.price-notice').hide();
			}
		  };
		});
	  };
	};
  }
};
$j('.fancybox').fancybox({
  maxWidth  : 800,
  maxHeight : 600,
  fitToView : true,
  height    : 'auto',
  autoSize  : false,
  openEffect  : 'none',
  closeEffect : 'none',
  wrapCSS     : 'select-country-popup-wrapper',
  closeBtn    : false,
  helpers     : { 
		// prevents closing when press outside popup
	overlay : {closeClick: false}
  },
  keys : {
		// prevents closing when press ESC button
		close   : null
	},
	'beforeLoad': function(){
	if (typeof localStorage === 'object') {
		try {
			localStorage.setItem('localStorage', 1);
			localStorage.removeItem('localStorage');
			bcp.getAllDistributors();
		} catch (e) {
			Storage.prototype._setItem = Storage.prototype.setItem;
			Storage.prototype.setItem = function() {};
			console.log('Your web browser does not support storing settings locally. In Safari, the most common cause of this is using "Private Browsing Mode". Some settings may not save or some features may not work properly for you.');
		}
	}
	  
  }
});
$j('.btn-prev').on('click', bcp.doPrev);

if(localStorage.getItem('countryCode') === null || localStorage.getItem('countryName') === null){
  $j('#changeLocation').trigger('click');
}
// responsive
  enquire.register('handheld, screen and (max-width: 767px)', {
	  match : function() {
		  $j('#countrySection #ddSelectCountry').closest('.country').appendTo($j('#countrySection .col-3'));
	  },
	  unmatch : function() {
		  $j('#countrySection #ddSelectCountry').closest('.country').appendTo($j('#countrySection .col-2'));
	  }
  });
  if(localStorage.getItem('countryCode') === null || localStorage.getItem('countryName') === null){
  $j('#changeLocation').trigger('click');
}
bcp.refresh();
$j('#countrySection .country a').on('click', function() {
  $j('#countrySection .country a').removeClass('selected');
  $j('#countrySection .country #ddSelectCountry').removeClass('selected');
  $j(this).addClass('selected');
});
$j('#countrySection .country #ddSelectCountry').on('change', function() {
  if ($j(this).val()) {
	$j('#countrySection .country a').removeClass('selected');
	$j('#countrySection .country #ddSelectCountry').removeClass('selected');
	$j(this).addClass('selected');
  }else{
	$j('#countrySection .country a').removeClass('selected');
	$j('#countrySection .country #ddSelectCountry').removeClass('selected');
  }
});
$j('#distributorList > ul > li').on('click', function() {
  $j('#distributorList > ul > li').removeClass('selected');
  $j(this).addClass('selected');
});
});