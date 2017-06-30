var aglActionName = 'agl_request';
var aglPhpParams;

var placeSearch, autocomplete;

function initAutocomplete() {
	 autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
      {types: ['geocode']});
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();
	var lat = place.geometry.location.lat();
	var lon = place.geometry.location.lng();
	var data = {
        'action': aglActionName,
        'lat': parseFloat( lat ),
        'lon': parseFloat( lon )
	} ;
	aglPostData(data);
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


function aglInitialise() {
	if (document.getElementById("aglResult") != null) {
		document.getElementById("aglResult").innerHTML = "<div>正在查询附近商家...</div>";
	}
	if ( geoPosition.init() ) {
		geoPosition.getCurrentPosition(aglShowPosition, aglShowError, {maximumAge: aglPhpParams.gcp_maximumAge, enableHighAccuracy: aglPhpParams.gcp_enableHighAccuracy, timeout: aglPhpParams.gcp_timeout} );
	} else {
		var data = {
	        'action': aglActionName,
	        'error_code': -1,
	        'error_message': 'Geolocation is not available. Try getting a device from the Stone Age, at least :)'
    	};

    	aglPostData(data);
	}
}

// Information of our Request
function aglShowPosition(position) {
	var data = {
        'action': aglActionName,
        'lat': parseFloat( position.coords.latitude ),
        'lon': parseFloat( position.coords.longitude )
	} ;
	aglPostData(data);
	aglGetItems();
}

function aglShowError(error) {
    var data = {
        'action': aglActionName,
        'error_code': error.code,
        'error_message': error.message
	};
	//jschen: don't post error back, aglPostData(data);
}

function aglPostData(data) {
	jQuery.post(aglParams.ajaxUrl, data, function(response) {
	//		alert(JSON.stringify(response));
    }, 'json');
}

function aglGetPhpParams() {
	var ajax = jQuery.ajax({
	    url: aglParams.ajaxUrl + '?action=agl_get_php',
	    type: 'POST',
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    async: false,
	    statusCode: {
	        404: function () {
	            alert('Page not found.');
	        }
	    }
	});

	ajax.done(function (response, textStatus, jqXHR) {
	    aglPhpParams = response;
	}); ajax.fail(function (jqXHR, textStatus, errorThrown) {
	    alert('No data available!');
	});
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
	aglGetPhpParams();

	if (aglPhpParams.is_cookie_permission != 'yes') {
		if (aglPhpParams.is_ask_onload == 'yes') {
			window.onload = aglInitialise;
		}
	} else {
		aglGetItems();
	}
	
	if (aglPhpParams.is_ask_onclick == 'yes') {
		jQuery('#aglId').click(aglInitialise);
	}
	jQuery('#aglLocateReload').click(locateReload);
//  document.getElementById('pointfinder_google_search_coord').value = '';
//	jQuery('#aglSearch').click(search);
});

