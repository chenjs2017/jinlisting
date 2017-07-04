var aglActionName = 'agl_request';

var autocomplete;

function initAutocomplete() {
	if (document.getElementById("autocomplete") != null) {
					 autocomplete = new google.maps.places.Autocomplete(
							/** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
							{types: ['geocode']});
					autocomplete.addListener('place_changed', fillInAddress);
	}
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();
	var lat = place.geometry.location.lat();
	var lon = place.geometry.location.lng();
//	alert(JSON.stringify(place.address_components));	
	var addr = place.address_components[0]['short_name'] + ',' 
		+ place.address_components[1]['short_name'] + ',' 
		+ place.address_components[2]['short_name'] + ',' 
		+ place.address_components[4]['short_name'];
		aglPostData(lat, lon, addr);
	location.reload();
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
	
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}

function getAddressFromLatLang(lat,lng){
      var geocoder = new google.maps.Geocoder();
        var latLng = new google.maps.LatLng(lat, lng);
        geocoder.geocode( { 'latLng': latLng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[1]) {
            console.log(results[1]);
						aglPostData(lat,lng,results[1].formatted_address);
          }
        }else{
          alert("Geocode was not successful for the following reason: " + status);
        }
        });
}

function aglInitialise() {
	if (document.getElementById("aglResult") != null) {
		document.getElementById("aglResult").innerHTML = "<div>正在查询附近商家...</div>";
	}
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
		 	getAddressFromLatLang(position.coords.latitude, position.coords.longitude);
		});
	} else {
		jQuery.getJSON('https://ipapi.co/json', function(data){
			var addr = data.city +',' +  data.region + ',' + data.country;
			aglPostData(data.latitude, data.longitude, addr);		
    });	
		}
}

function aglPostData(lat, lon, addr) {
	var data = {
    'action': aglActionName,
    'lat': parseFloat( lat ),
    'lon': parseFloat( lon),
		'addr': addr
	} ;
//	alert(JSON.stringify(data));
	jQuery.post(aglParams.ajaxUrl, data, function(response) {
    }, 'json');
	aglGetItems();
}


var fulltext = '';
var halftext = '';

function aglGetItems() {
	if (document.getElementById("aglResult") == null) {
		return;	
	}
	document.getElementById("aglResult").innerHTML = "<div>正在查询附近商家...</div>";
	var ajax = jQuery.ajax({
	    url: aglParams.ajaxUrl + '?action=agl_ask',
	    type: 'GET',
	    contentType: 'text/plain; charset=utf-8',
	    dataType: 'html',
	    async: true,
	    statusCode: {
	        404: function () {
	            alert('Page not found.');
	        }
	    }
	});

	ajax.done(function (response, textStatus, jqXHR) {
		var max = 4;
		var arr = response.split("|");
		var len = arr.length;
		var str = "";
		var i;
		if (len > max) {
			fulltext = response + "<a href='#' onclick='less()'>收起</a>";
			for (i = 0; i < max; i ++) {
				str = str + arr[i] + "|";
			}
			halftext = str + "<a href='#' onclick='more()'>更多...</a>";
			document.getElementById("aglResult").innerHTML = halftext;
		} else {
			document.getElementById("aglResult").innerHTML = response;
		}
	});

	ajax.fail(function (jqXHR, textStatus, errorThrown) {
	//    alert('No data available!');
	});
}
function more(){
		document.getElementById("aglResult").innerHTML=fulltext;
}

function less(){
		document.getElementById("aglResult").innerHTML=halftext;
}


function locateReload() {
	aglInitialise();
	location.reload();
}

jQuery(document).ready(function($) {
	if (document.cookie && document.cookie.indexOf('agl-values=') != -1){
		aglGetItems();
	} else {
		window.onload = aglInitialise;
	}
	
	jQuery('#aglId').click(aglInitialise);
	jQuery('#aglLocateReload').click(locateReload);

	if (document.getElementById("autocomplete") != null) {
		google.maps.event.addDomListener(window, 'load', initAutocomplete);
	}
});

