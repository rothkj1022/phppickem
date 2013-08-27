<?php
require('includes/application_top.php');

$season = date('Y');
$games = 17;
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
$schedule = array();

for ($week = 1; $week <= $games; $week++) {
	$url = 'http://scores.espn.go.com/nfl/scoreboard?seasonYear='.$season.'&seasonType=2&weekNumber='.$week;
	$raw = file_get_contents($url);

	$newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
	$content = str_replace($newlines, "", html_entity_decode($raw));

	//trim down to just the data section of the page
	$startStr = 'espn.video.embeded.play(); }</script>';
	$endStr = '<!-- begin sponsored links2';
	$content = getInnerString($content, $startStr, $endStr);

	//let's make it easier to match the game days
	$markerStart = '<!-- start gameDay -->';
	$markerEnd = '<!-- end gameDay -->';
	//strip off the first character and add it back so first instance of pattern doesn't match during replace
	$content = substr($content, 1, strlen($content));
	$content = '<'.str_replace('<h4 class="games-date">', $markerEnd.'<h4 class="games-date">', $content) . $markerEnd;
	$content = str_replace('<h4 class="games-date">', $markerStart.'<h4 class="games-date">', $content);

	$gameDayHtml = explode($markerEnd.$markerStart, $content);
	//print_r($gameDayHtml);
	//exit;
	for ($i = 0; $i < sizeof($gameDayHtml); $i++) {
		//get the date
		$matches = array();
		$startStr = '<h4 class="games-date">';
		$endStr = '</h4>';
		$find = '|'.$startStr.'(.*?)'.$endStr.'|is';
		preg_match_all($find, $gameDayHtml[$i], $matches);
		$gameDate = getInnerString($matches[0][0], $startStr, $endStr);

		$matches = array();
		$find = '|<p id=".*?-statusText">(.*?)</p>.*?<a href="/nfl/clubhouse\?team=(.*?)">(.*?)</a>.*?<li class="final" id=".*?-aTotal">(.*?)</li>.*?<a href="/nfl/clubhouse\?team=(.*?)">(.*?)</a>.*?<li class="final" id=".*?-hTotal">(.*?)</li>|is';
		preg_match_all($find, $gameDayHtml[$i], $matches);
		//print_r($matches);
		//exit;

		$count = count($matches[1]);
		for ($j = 0; $j < $count; $j++) {
			$gameTimeEastern = $gameDate.' '.$matches[1][$j];
			$gameTimeEastern = str_replace(' ET', '', $gameTimeEastern);
			$gameTimeEastern = date('Y-m-d H:i:00', strtotime($gameTimeEastern));
			//$overtime = (($matches[1][$j] == 'Final/OT') ? 1 : 0);
			$away_team = strtoupper($matches[2][$j]);
			$away_team_name = $matches[3][$j];
			$home_team = strtoupper($matches[5][$j]);
			$home_team_name = $matches[6][$j];
			foreach ($teamCodes as $espnCode => $nflpCode) {
				if ($away_team == $espnCode) $away_team = $nflpCode;
				if ($home_team == $espnCode) $home_team = $nflpCode;
			}
			$away_score = (int)$matches[4][$j];
			$home_score = (int)$matches[7][$j];
			if ($away_score == 0 && $home_score == 0) {
				$schedule[] = array(
					'weekNum' => $week,
					'gameTimeEastern' => $gameTimeEastern,
					'homeID' => $home_team,
					'homeTeam' => $home_team_name,
					'visitorID' => $away_team,
					'visitorTeam' => $away_team_name
				);
			}
		}
		//echo '<pre>';
		//echo $gameDate;
		//print_r($matches);
		//echo $gameDayHtml[$i]."\n\n\n\n";
		//echo '</pre>';
	}
}

//output to excel
$output = '<table>'."\n".
	'<tr><td>weekNum</td><td>gameTimeEastern</td><td>homeID</td><td>homeTeam</td><td>visitorID</td><td>visitorTeam</td></tr>'."\n";
for ($i = 0; $i < sizeof($schedule); $i++) {
	$output .= '<tr><td>'.$schedule[$i]['weekNum'].'</td><td>'.$schedule[$i]['gameTimeEastern'].'</td><td>'.$schedule[$i]['homeID'].'</td><td>'.$schedule[$i]['homeTeam'].'</td><td>'.$schedule[$i]['visitorID'].'</td><td>'.$schedule[$i]['visitorTeam'].'</td></tr>'."\n";
}
$output .= '</table>';

// fix for IE catching or PHP bug issue
header("Pragma: public");
header("Expires: 0"); // set expiration time
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
// browser must download file from server instead of cache

header('Content-Type: application/vnd.ms-excel;');
//header("Content-type: application/x-msexcel");
//header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=nfl_schedule_".$season.".xls");

echo $output;
//echo '<pre>';
//print_r($schedule);
//echo '</pre>';
exit;

function getInnerString($content, $startStr, $endStr) {
	$startPos = strpos($content, $startStr);
	$endPos = strpos($content, $endStr, $startPos) + strlen($endStr);
	$content = substr($content, $startPos + strlen($startStr), $endPos-$startPos-(strlen($endStr)+strlen($startStr)));
	return $content;
}
