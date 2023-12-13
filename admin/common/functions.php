<?php
function encrypt_md5string($str){
	return md5($str);
}

function decrypt_md5string($orinalstring,$str){
	$conver = md5($orinalstring);
	
	if($conver == $str){
		return true;	
	}else{
		return false;	
	}
}

function redirect($url){
	header("Location: ".$url);
}

function deleteImage($imgarr,$path){
		
		unlink('http://www.gospelscout.com/'.$path.'/'.$imgarr);
}

function googleCalcDistance($from, $to) {
    // Google Maps Calculations
    $u_from = urlencode($from . ", UK");
    $u_to   = urlencode($to . ", UK");

    $url  = "http://maps.googleapis.com/maps/api/distancematrix/json?origins=$u_from&destinations=$u_to&units=imperial&sensor=false";

    $calcData = file_get_contents($url);

    $obj = json_decode($calcData);

    if ( $obj->status == "OK" ) {
      $distance=(float)preg_replace('/[^\d\.]/','',$obj->rows[0]->elements[0]->distance->text);
      $duration=$obj->rows[0]->elements[0]->duration->text;
      $duration_sec = $obj->rows[0]->elements[0]->duration->value;
    } else {
      $distance     = 0;
      $duration     = 0;
      $duration_sec = 0;
    }
    
    return array($distance, $duration_sec);
}


function googlePlacesCheck($location) {

	// implement database recording/checking for $location -> $results matches to avoid Google API calls (due to daily limits)

	$loc                   = urlencode($location);

	$google_places_api_key = "AIzaSyBUtV5fl8cz1yi86Vd3qKu59ggyPHSoUak";
	$google_places_url     = "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=$loc&sensor=false&components=country:uk&types=(regions)&key=$google_places_api_key";

	$placesdata            = json_decode(file_get_contents($google_places_url));

	$count                 = count($placesdata->predictions);

	$real_match            = array();
	$matches               = array();

	if ( $count > 0 ) {
		foreach ( $placesdata->predictions as $object ) {
			$place_name  = $object->description;
			$place_id    = $object->id;
			$offset      = $object->matched_substrings[0]->offset;
			foreach ( $object->terms as $offset_matches ) {
				$offset_check = $offset_matches->offset;
				if ( $offset_check == $offset ) {
					$place_match = $offset_matches->value;
				}
			}
			if ( strtoupper($place_match) == strtoupper($location) ) {
				$real_match['id']   = $place_id;
				$real_match['name'] = $place_match;
			} else {
				$matches[$place_id] = $place_match;
			}
		}
		if ( count($real_match) > 0 ) {
			//echo "Match: " . $real_match['name'] . "\n";
			return array("match", $real_match);
		} else {
			//echo "Possible matches:\n";
			//foreach ($matches as $match_id => $match_name) {
			//	echo "$match_name\n";
			//}
			return array("options", $matches);
		}
	} else {
		return array("no match");
	}
}

function calculatepercentage($total, $percentage)
{
	return round((($percentage*100)/$total));
} 

function calculateStarRating($likes, $dislikes){ 
	$maxNumberOfStars = 5; // Define the maximum number of stars possible.
	$totalRating = $likes + $dislikes; // Calculate the total number of ratings.
	$likePercentageStars = ($likes / $totalRating) * $maxNumberOfStars;
	return round($likePercentageStars);
}

