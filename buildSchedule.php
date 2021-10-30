<?php
require('includes/application_top.php');

$weeks = 18;
$schedule = array();

for ($week = 1; $week <= $weeks; $week++) {
	$url = "https://www.espn.com/nfl/schedule/_/year/".SEASON_YEAR."/week/".$week."?xhr=1";
	if ($json = @file_get_contents($url)) {
		$jsonDecoded = json_decode($json, true);
		$scheduleData = $jsonDecoded['content']['schedule'];
	} else {
		die('Error getting schedule from espn.com.');
	}

	//build scores array, to group teams and scores together in games
	foreach ($scheduleData as $gameDay) {
		foreach ($gameDay['games'] as $game) {
			$gameID = substr($game['uid'], strrpos($game['uid'], ':') + 1);

			//get game time (UTC) and set to eastern
			$date = new DateTime($game['date']);
			$date->setTimezone(new DateTimeZone('America/New_York'));
			$gameTimeEastern = $date->format('Y-m-d H:i:00');

			//get tv
			foreach ($game['competitions'][0]['geoBroadcasts'] as $broadcast) {
				if ($broadcast['type']['shortName'] == 'TV') {
					$tv = $broadcast['media']['shortName'];
				}
			}

			//get team codes
			foreach ($game['competitions'][0]['competitors'] as $team) {
				if ($team['homeAway'] == 'home') {
					$home_team = $team['team']['abbreviation'];
					$home_score = $team['score'];
				} else {
					$away_team = $team['team']['abbreviation'];
					$away_score = $team['score'];
				}
			}

			$schedule[] = array(
				'game_id' => $gameID,
				'season' => SEASON_YEAR,
				'season_type' => 'REG',
				'week_num' => $week,
				'game_time_eastern' => $gameTimeEastern,
				'home_id' => $home_team,
				'visitor_id' => $away_team,
				'home_score' => $home_score,
				'visitor_score' => $away_score,
				'tv' => $tv
			);
		}
	}
}

//output to csv
// create a file pointer connected to the output stream
$fp = fopen('php://output', 'w');

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=nfl_schedule_'.SEASON_YEAR.'.csv');

// output the column headings
fputcsv($fp, array_keys($schedule[0]));

//output the data
foreach ($schedule as $row) {
	fputcsv($fp, $row);
}

fclose($fp);
