
<?php

//Get page that contains the rankings
$fifaRankingsUrl = "http://www.uefa.com/memberassociations/uefarankings/club/index.html";
$response = file_get_contents($fifaRankingsUrl);

//Extract the numbers of teams in this list
preg_match ('/var lclubautosugg=new Array\(([0-9]*)\)/', $response, $match);
$numTeams = $match[1];

//Extract the piece that contains the rankings
preg_match ('/\<tbody>.*\<\/tbody\>/', $response, $match);
$rankingsBlob = $match[0];
//echo $rankingsBlob;

//Extract info on each team

//Club name
preg_match_all ('/title="([^"]{3,})"/', $rankingsBlob, $clubNames);

//Club Id
preg_match_all ('/\/([0-9]*)\.png/', $rankingsBlob, $clubIds);

//Club Country Code
preg_match_all ('/countrycode">([A-Z]{3})</', $rankingsBlob, $countryCodes);


$rankingDetails = array();
for($i=0; $i< $numTeams; $i++)
{
	$clubName = $clubNames[1][$i];
	$clubId = $clubIds[1][$i];
	$countryCode = $countryCodes[1][$i];
	
	//echo $team;
	//$team = ascii_to_entities($team);
	array_push($rankingDetails, array( 	"rank" => $i+1 ,
										"clubName" => $clubName,
										"clubId" => $clubId,
										"countryCode" => $countryCode
									));
}

//print_r ($rankingDetails);
echo json_encode($rankingDetails);


function ascii_to_entities($str) 
{ 
   $count    = 1; 
   $out    = ''; 
   $temp    = array(); 

   for ($i = 0, $s = strlen($str); $i < $s; $i++) 
   { 
	   $ordinal = ord($str[$i]); 

	   if ($ordinal < 128) 
	   { 
			if (count($temp) == 1) 
			{ 
				$out  .= '&#'.array_shift($temp).';'; 
				$count = 1; 
			} 
		
			$out .= $str[$i]; 
	   } 
	   else 
	   { 
		   if (count($temp) == 0) 
		   { 
			   $count = ($ordinal < 224) ? 2 : 3; 
		   } 
	
		   $temp[] = $ordinal; 
	
		   if (count($temp) == $count) 
		   { 
			   $number = ($count == 3) ? (($temp['0'] % 16) * 4096) + 
											(($temp['1'] % 64) * 64) + 
											($temp['2'] % 64) : (($temp['0'] % 32) * 64) + 
											($temp['1'] % 64); 

			   $out .= '&#'.$number.';'; 
			   $count = 1; 
			   $temp = array(); 
		   } 
	   } 
   } 

   return $out; 
} 


?>