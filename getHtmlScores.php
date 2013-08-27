<?php
require('includes/application_top.php');

$week = (int)$_GET['week'];

//load source code, depending on the current week, of the website into a variable as a string
//$url = "http://scores.espn.go.com/nfl/scoreboard?seasonYear=2008&seasonType=2&weekNumber=2";
$url = "http://scores.espn.go.com/nfl/scoreboard?seasonYear=2011&seasonType=2&weekNumber=" . $week;
$raw = file_get_contents($url);

$teamCodes = array(
	'GNB' => 'GB',
	'JAC' => 'JAX',
	'KAN' => 'KC',
	'NWE' => 'NE',
	'NOR' => 'NO',
	'SDG' => 'SD',
	'SFO' => 'SF',
	'TAM' => 'TB'
);

$newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
$content = str_replace($newlines, "", html_entity_decode($raw));

$start = strpos($content,'<div class="gameDay-Container">');
$end = strpos($content,'<!-- begin sponsored links',$start) + 26;
$content = substr($content,$start,$end-$start);

//set search pattern (using regular expressions)
//$find = '|<div class="game-header">(.*?)<div class="game-links">|is';
$find = '|<p id=".*?-statusText">(.*?)</p>.*?<a href="/nfl/clubhouse\?team=(.*?)">(.*?)</a>.*?<li class="final" id=".*?-aTotal">(.*?)</li>.*?<a href="/nfl/clubhouse\?team=(.*?)">(.*?)</a>.*?<li class="final" id=".*?-hTotal">(.*?)</li>|is';
preg_match_all($find, $content, $matches);
//print_r($matches);
//exit;

//initiate scores array, to group teams and scores together in games
$scores = array();

//count number of teams found, to be used in the loop below
$count = count($matches[1]);

for ($i = 0; $i < $count; $i++) {
   $overtime = (($matches[1][$i] == 'Final/OT') ? 1 : 0);
   $away_team = strtoupper($matches[2][$i]);
   $home_team = strtoupper($matches[5][$i]);
	foreach ($teamCodes as $espnCode => $nflpCode) {
		if ($away_team == $espnCode) $away_team = $nflpCode;
		if ($home_team == $espnCode) $home_team = $nflpCode;
	}
   $away_score = (int)$matches[4][$i];
   $home_score = (int)$matches[7][$i];

   $winner = ($away_score > $home_score) ? $away_team : $home_team;
   $gameID = getGameIDByTeamID($week, $home_team);
   if (is_numeric(strip_tags($home_score)) && is_numeric(strip_tags($away_score))) {
   	if ($away_score > 0 || $home_score > 0) {
	   	$scores[] = array(
	      	'gameID' => $gameID,
	      	'awayteam' => $away_team,
	      	'visitorScore' => $away_score,
	      	'hometeam' => $home_team,
	      	'homeScore' => $home_score,
	      	'overtime' => $overtime,
	      	'winner' => $winner
	   	);
	   }
   }
}

//see how the scores array looks
//echo '<pre>' . print_r($scores, true) . '</pre>';
echo json_encode($scores);

//game results and winning teams can now be accessed from the scores array
//e.g. $scores[0]['awayteam'] contains the name of the away team (['awayteam'] part) from the first game on the page ([0] part)
?>
