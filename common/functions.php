<?php

$totalCount = 0;

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
    $u_from = urlencode($from);
    $u_to   = urlencode($to);

   $url  = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$u_from&destinations=$u_to";

    $calcData = file_get_contents($url);

    $obj = json_decode($calcData);

    if ($obj->rows[0]->elements[0]->status == "OK" ) {
      $distance=(float)preg_replace('/[^\d\.,]/','',$obj->rows[0]->elements[0]->distance->text);
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
function get_driving_information($start, $finish, $raw = false)
{
	if(strcmp($start, $finish) == 0)
	{
		$time = 0;
		if($raw)
		{
			$time .= ' seconds';
		}
 
		return array('distance' => 0, 'time' => $time);
	}
 
	$start  = urlencode($start);
	$finish = urlencode($finish);
 
	$distance   = 'unknown';
	$time		= 'unknown';
 
	$url = 'http://maps.googleapis.com/maps/api/directions/xml?origin='.$start.'&destination='.$finish.'&sensor=false';
	if($data = file_get_contents($url))
	{
		$xml = new SimpleXMLElement($data);
 
		if(isset($xml->route->leg->duration->value) AND (int)$xml->route->leg->duration->value > 0)
		{
			if($raw)
			{
				$distance = (string)$xml->route->leg->distance->text;
				$time	  = (string)$xml->route->leg->duration->text;
			}
			else
			{
				$distance = (int)$xml->route->leg->distance->value / 1000 / 1.609344; 
				$time	  = (int)$xml->route->leg->duration->value;
			}
		}
		else
		{
			throw new Exception('Could not find that route');
		}
 
		return array('distance' => $distance, 'time' => $time);
	}
	else
	{
		throw new Exception('Could not resolve URL');
	}
}


function getArtistListHtml($searchResuilt) {
		
		$no = 0;
		
		$html = '<div class="mt20">';
		if (count($searchResuilt)) {
			
			foreach($searchResuilt as $k => $artist) {
				
				if ( $artist['average_rating'] > 0) {					
					$total = $artist['average_rating']; 
				} else { 					
					$total = 0;					
				}
				
				if ( $artist['sGroupType'] == 'group' ) { 
					$name = ucwords($artist['sGropName']);	
				} else { 
					$name = ucwords($artist['artist_name']);
				}
			$aid=$artist['iLoginID'];

		
		?>
<?php

/*-------------------------------------------------------+
| Content Management System 
| http://www.phphelptutorials.com/
+--------------------------------------------------------+
| Author: David Carr  Email: dave@daveismyname.co.uk
+--------------------------------------------------------+*/

ob_start();

define('DBHOST','localhost');
define('DBUSER','gospelsc_user');
define('DBPASS','Gg@123456');
define('DBNAME','gospelsc_db651933262');

// make a connection to mysql here
$conn = @mysql_connect (DBHOST, DBUSER, DBPASS);
$conn = @mysql_select_db (DBNAME);
if(!$conn){
	die( "Sorry! There seems to be a problem connecting to our database.");
}

	$query=mysql_query("select * from usermaster where iLoginID='$aid'");
	$row=mysql_fetch_array($query);
				
?>

<script language="javascript" type="text/javascript">
$(function() {
    $("#rating_star<?php echo $no;?>").codexworld_rating_widget01({
        starLength: '5',
        initialValue: '<?php echo $row['iRateAvg'];?>',
        callbackFunctionName: '',
        imageDirectory: '../img/',
        //inputAttr: 'postID'
    });
});


</script>

        <?php
			
				$html .= '<a style="cursor:pointer;" href="'. URL .'views/artistprofile.php?artist=' . $artist['iLoginID']. '">';
					$html .= '<div class="col-lg-3 col-mg-3 col-sm-3 pl0">';
						$html .= '<div class="hovereffect church">';
						$html .= '<img class="img-responsive" src="'. URL. 'upload/artist/'.$artist['sProfileName'] .'" alt="">';
						$html .= '<div class="overlay">';
                        $html .= '<p>'. $name .'</p>';
						$html .= '<p>'.ucwords($artist['iGiftID']) .'</p>';
						$html .= '<p>'. ucfirst($artist['cityname']).','.$artist['statename'].' '.$artist['iZipcode'].'</p>';					
						$html .= '<p style="margin-left: 25%;"><input name="rating" value="0" id="rating_star'.$no.'" type="hidden" postID="1" /></p>';
						$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</a>';
				if (($k+1)%4 == 0) {
					$html .= '<div style="clear:both;" class="mb20"></div>';
				}
				
				$no ++;
			}
			$html .= '</div>';
		} else {
			$html = 'Artist record not found.';
		}		
		return $html;
	}

function getChurchListHtml($searchResuilt) {
		

		$html = '<div class="mt20">';
		if (count($searchResuilt)) {
			foreach($searchResuilt as $k => $church) {
				
				
				$html .= '<a style="cursor:pointer;" href="'. URL .'views/churchprofile.php?church=' . $church['iLoginID']. '">';
					$html .= '<div class="col-lg-3 col-mg-3 col-sm-3 pl0">';
						$html .= '<div class="hovereffect church">';
						$html .= '<img class="img-responsive" src="'. URL. 'upload/church/'.$church['sProfileName'] .'" alt="">';
						$html .= '<div class="overlay" >';
						$html .= '<p>'.$church['sChurchName'].'</p>';						
											
						$html .= '<p>'. $church['sPastorName'] .'</p>';
						$html .= '<p>'.$church['sAddress'].' '.ucfirst($church['cityname']).','.$church['statename'].' '.$church['iZipcode'].'</p>';
						$html .= '<p>'. $church['sTitle'].' '.str_pad($church['iHour'], 2, "0", STR_PAD_LEFT).':'.str_pad($church['iMinute'], 2, "0", STR_PAD_LEFT).strtolower($church['ampm']).'</p>';
						$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</a>';
				if (($k+1)%4 == 0) {
					$html .= '<div style="clear:both;" class="mb20"></div>';
				}
			}
			$html .= '</div>';
		} else {
			$html = 'There Are No Churches.';
		}
		
		return $html;
	}

function getEventListHtml($searchResuilt) {


		$html = '<div class=" mt20">';
		if (count($searchResuilt)) {

			foreach($searchResuilt as $k => $church) {
				
				$siddhant=(explode(",",$church['sMultiImage']));
			
					$html .= '<div class="col-lg-3 col-mg-3 col-sm-3 pl0">';
						$html .= '<div class="hovereffect church">';
						$html .= '<img class="img-responsive" src="'. URL. 'upload/event/multiple/'. $siddhant[0] .'" alt="">';
						$html .= '<div class="overlay">';
                        $html .= '<h2>'. substr($church['event_name'],0,12) .'</h2>';
						$html .= '<div class="eventdate">'.date('Y-m-d',strtotime($church['doe'])).'</div>';
						$html .= '<p>'. substr($church['sDesc'],0,20) .'</p>';
						$html .= '<div class="eventmore"><a href="'.URL.'views/eventdetail.php?event='. $church['e_id'].'">MORE INFO</a> </div>';
						$html .= '<p>'. substr($church['address_event'],0,20).'</p>';
						$html .= '<p>'. date('h:i A',strtotime($church['toe'])).'</p>';
						$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				
				if (($k+1)%4 == 0) {
					$html .= '<div style="clear:both;" class="mb20"></div>';
				}
				}
			$html .= '</div>';
		} else {
			$html = 'There are currently no events listed.';
		}
		
		return $html;
	}

