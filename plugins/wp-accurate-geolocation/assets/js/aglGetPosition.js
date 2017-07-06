"use strict";

var aglActionName = 'agl_request';
var reload = false;
var getItem = false;
var autocomplete;
var fulltext = '';
var halftext = '';


function initAutocomplete() {
	if (document.getElementById("aglAddress") != null) {
					 autocomplete = new google.maps.places.Autocomplete(
							/** @type {!HTMLInputElement} */(document.getElementById('aglAddress')),
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
}

function getAddressFromLatLang(lat,lng){
      var geocoder = new google.maps.Geocoder();
      var latLng = new google.maps.LatLng(lat, lng);
      geocoder.geocode( { 'latLng': latLng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
           if (results[1]) {
		   			aglPostData(lat,lng,results[1].formatted_address);
     	    }else {
		   			alert( 'no result');
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
function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
	
function aglPostData(lat, lon, addr) {
	var data = {
    'action': aglActionName,
    'lat': parseFloat( lat ),
    'lon': parseFloat( lon),
		'addr': addr
	} ;
	setCookie('agl-values',JSON.stringify(data));
	if (document.getElementById("aglAddress") != null) {
		document.getElementById("aglAddress").value = addr; 
	}
	if (reload) {
		location.reload();
	}
	if (getItem) {
			aglGetItems();
	}
}


function aglGetItems() {
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


jQuery(document).ready(function($) {
	reload = document.getElementById("aglReload") !=null;
	getItem = document.getElementById("aglResult") !=null;
	if (document.cookie && document.cookie.indexOf('agl-values=') != -1){
		if (getItem){
			aglGetItems();
		}
	} else {
		window.onload = aglInitialise;
	}
	
	jQuery('#aglId').click(aglInitialise);

	if (document.getElementById("aglAddress") != null) {
		google.maps.event.addDomListener(window, 'load', initAutocomplete);
	}

});

