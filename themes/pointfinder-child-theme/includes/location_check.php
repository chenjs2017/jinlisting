<?php

/*
 * Radius Check
 */
if (!class_exists('RadiusCheck')) {

    class RadiusCheck {

        var $maxLat;
        var $minLat;
        var $maxLong;
        var $minLong;

        public function __construct ($Latitude, $Longitude, $Miles) {
            global $maxLat, $minLat, $maxLong, $minLong;
            $EQUATOR_LAT_MILE = 69.172; // in MIles
            $maxLat = $Latitude + $Miles / $EQUATOR_LAT_MILE;
            $minLat = $Latitude - ($maxLat - $Latitude);
            $maxLong = $Longitude + $Miles / (cos($minLat * M_PI / 180) * $EQUATOR_LAT_MILE);
            $minLong = $Longitude - ($maxLong - $Longitude);
        }

        function MaxLatitude() {
            return $GLOBALS["maxLat"];
        }

        function MinLatitude() {
            return $GLOBALS["minLat"];
        }

        function MaxLongitude() {
            return $GLOBALS["maxLong"];
        }

        function MinLongitude() {
            return $GLOBALS["minLong"];
        }

    }

}
/*
 * Check Distance
 */
if (!class_exists('DistanceCheck')) {

    class DistanceCheck {

        public function __construct() {

        }

        function Calculate($lat1, $lon1, $lat2, $lon2) {
					$theta = $lon1 - $lon2;
				  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
				  $dist = acos($dist);
				  $dist = rad2deg($dist);
				  $miles = $dist * 60 * 1.1515;
					return $miles;
				}
  }

}
