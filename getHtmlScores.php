<?php
require('includes/application_top.php');

$week = (int)$_GET['week'];
if (empty($week)) {
	//get current week
	$week = (int)getCurrentWeek();
}

//load source code, depending on the current week, of the website into a variable as a string
$url = "http://www.nfl.com/ajax/scorestrip?season=".SEASON_YEAR."&seasonType=REG&week=".$week;
if ($xmlData = file_get_contents($url)) {
	$xml = simplexml_load_string($xmlData);
	$json = json_encode($xml);
	$games = json_decode($json, true);
}

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

//build scores array, to group teams and scores together in games
$scores = array();
foreach ($games['gms']['g'] as $gameArray) {
	$game = $gameArray['@attributes'];
	if ($game['q'] == 'F' || $game['q'] == 'FO') {
		$overtime = (($game['q'] == 'FO') ? 1 : 0);
		$away_team = $game['v'];
		$home_team = $game['h'];
		foreach ($teamCodes as $espnCode => $nflpCode) {
			if ($away_team == $espnCode) $away_team = $nflpCode;
			if ($home_team == $espnCode) $home_team = $nflpCode;
		}
		$away_score = (int)$game['vs'];
		$home_score = (int)$game['hs'];

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
}

//see how the scores array looks
//echo '<pre>' . print_r($scores, true) . '</pre>';
echo json_encode($scores);

//game results and winning teams can now be accessed from the scores array
//e.g. $scores[0]['awayteam'] contains the name of the away team (['awayteam'] part) from the first game on the page ([0] part)


//automatically update DB with scores if page is called by cronjob,etc
if(BATCH_SCORE_UPDATE_ENABLED && !empty($_GET['BATCH_SCORE_UPDATE_KEY']) && $_GET['BATCH_SCORE_UPDATE_KEY'] == BATCH_SCORE_UPDATE_KEY ){
	foreach($scores as $game) {
		$homeScore = ((strlen($game['homeScore']) > 0) ? $game['homeScore'] : 'NULL');
		$visitorScore = ((strlen($game['visitorScore']) > 0) ? $game['visitorScore'] : 'NULL');
		$overtime = ((!empty($game['OT'])) ? '1' : '0');
		$sql = "update " . DB_PREFIX . "schedule ";
		$sql .= "set homeScore = " . $homeScore . ", visitorScore = " . $visitorScore . ", overtime = " . $overtime . " ";
		$sql .= "where gameID = " . $game['gameID'];
		$mysqli->query($sql) or die('Error updating score: ' . $mysqli->error);
		//echo $sql . '<BR>';
	}
}
