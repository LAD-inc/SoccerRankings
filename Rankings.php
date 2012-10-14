
<?php



$rankingType = $_GET["rankingType"];

if ($rankingType == "club")
{
	require_once('ClubRankings.php');
}
else if ($rankingType == "country")
{
	require_once('CountryRankings.php');
}



?>