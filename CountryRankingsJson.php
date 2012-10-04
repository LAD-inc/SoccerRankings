<html>
<head>
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
</head>
<body>
<?php

$fifaRankingsUrl = "http://www.fifa.com/worldranking/rankingtable/index.html";
$response = file_get_contents($fifaRankingsUrl);
//echo $response;
preg_match ('/pt_team_info_jsonObj = .*}];/', $response, $match);
//print_r ($match);
echo $match[0];

?>
</body>
</html>
