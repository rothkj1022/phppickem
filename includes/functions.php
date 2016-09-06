<?php
// functions.php
function getCurrentWeek() {
	//get the current week number
	global $mysqli;
	$sql = "select distinct weekNum from " . DB_PREFIX . "schedule where DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) < gameTimeEastern order by weekNum limit 1";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		return $row['weekNum'];
	} else {
		$sql = "select max(weekNum) as weekNum from " . DB_PREFIX . "schedule";
		$query2 = $mysqli->query($sql);
		if ($query2->num_rows > 0) {
			$row = $query2->fetch_assoc();
			return $row['weekNum'];
		}
		$query2->free;
	}
	$query->free;
	die('Error getting current week: ' . $mysqli->error);
}

function getCutoffDateTime($week) {
	//get the cutoff date for a given week
	global $mysqli;
	$sql = "select gameTimeEastern from " . DB_PREFIX . "schedule where weekNum = " . $week . " and DATE_FORMAT(gameTimeEastern, '%W') = 'Sunday' order by gameTimeEastern limit 1;";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		return $row['gameTimeEastern'];
	}
	$query->free;
	die('Error getting cutoff date: ' . $mysqli->error);
}

function getFirstGameTime($week) {
	//get the first game time for a given week
	global $mysqli;
	$sql = "select gameTimeEastern from " . DB_PREFIX . "schedule where weekNum = " . $week . " order by gameTimeEastern limit 1";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		return $row['gameTimeEastern'];
	}
	$query->free;
	die('Error getting first game time: ' . $mysqli->error);
}

function getPickID($gameID, $userID) {
	//get the pick id for a particular game
	global $mysqli;
	$sql = "select pickID from " . DB_PREFIX . "picks where gameID = " . $gameID . " and userID = " . $userID;
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		return $row['pickID'];
	} else {
		return false;
	}
	$query->free;
	die('Error getting pick id: ' . $mysqli->error);
}

function getGameIDByTeamName($week, $teamName) {
	//get the pick id for a particular game
	global $mysqli;
	$sql = "select gameID ";
	$sql .= "from " . DB_PREFIX . "schedule s ";
	$sql .= "inner join " . DB_PREFIX . "teams t1 on s.homeID = t1.teamID ";
	$sql .= "inner join " . DB_PREFIX . "teams t2 on s.visitorID = t2.teamID ";
	$sql .= "where weekNum = " . $week;
	$sql .= " and ((t1.city = '" . $teamName . "' or t1.displayName = '" . $teamName . "') or (t2.city = '" . $teamName . "' or t2.displayName = '" . $teamName . "'))";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		return $row['gameID'];
	} else {
		return false;
	}
	$query->free;
	die('Error getting game id: ' . $mysqli->error);
}

function getGameIDByTeamID($week, $teamID) {
	//get the pick id for a particular game
	global $mysqli;
	$sql = "select gameID ";
	$sql .= "from " . DB_PREFIX . "schedule s ";
	$sql .= "inner join " . DB_PREFIX . "teams t1 on s.homeID = t1.teamID ";
	$sql .= "inner join " . DB_PREFIX . "teams t2 on s.visitorID = t2.teamID ";
	$sql .= "where weekNum = " . $week;
	$sql .= " and (t1.teamID = '" . $teamID . "' or t2.teamID = '" . $teamID . "')";
	//echo $sql . "\n\n";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		return $row['gameID'];
	} else {
		return false;
	}
	$query->free;
	die('Error getting game id: ' . $mysqli->error);
}

function getUserPicks($week, $userID) {
	//gets user picks for a given week
	global $mysqli;
	$picks = array();
	$sql = "select p.* ";
	$sql .= "from " . DB_PREFIX . "picks p ";
	$sql .= "inner join " . DB_PREFIX . "schedule s on p.gameID = s.gameID ";
	$sql .= "where s.weekNum = " . $week . " and p.userID = " . $userID . ";";
	$query = $mysqli->query($sql);
	while ($row = $query->fetch_assoc()) {
		$picks[$row['gameID']] = array('pickID' => $row['pickID'], 'points' => $row['points']);
	}
	$query->free;
	return $picks;
}

function getUserScore($week, $userID) {
	global $mysqli, $user;

	$score = 0;

	//get array of games
	$games = array();
	$sql = "select * from " . DB_PREFIX . "schedule where weekNum = " . $week . " order by gameTimeEastern, gameID";
	$query = $mysqli->query($sql);
	while ($row = $query->fetch_assoc()) {
		$games[$row['gameID']]['gameID'] = $row['gameID'];
		$games[$row['gameID']]['homeID'] = $row['homeID'];
		$games[$row['gameID']]['visitorID'] = $row['visitorID'];
		if ((int)$row['homeScore'] > (int)$row['visitorScore']) {
			$games[$row['gameID']]['winnerID'] = $row['homeID'];
		}
		if ((int)$row['visitorScore'] > (int)$row['homeScore']) {
			$games[$row['gameID']]['winnerID'] = $row['visitorID'];
		}
	}
	$query->free;

	//loop through player picks & calculate score
	$sql = "select p.userID, p.gameID, p.pickID, p.points ";
	$sql .= "from " . DB_PREFIX . "picks p ";
	$sql .= "inner join " . DB_PREFIX . "users u on p.userID = u.userID ";
	$sql .= "inner join " . DB_PREFIX . "schedule s on p.gameID = s.gameID ";
	$sql .= "where s.weekNum = " . $week . " and u.userID = " . $user->userID . " ";
	$sql .= "order by u.lastname, u.firstname, s.gameTimeEastern";
	$query = $mysqli->query($sql);
	while ($row = $query->fetch_assoc()) {
		if (!empty($games[$row['gameID']]['winnerID']) && $row['pickID'] == $games[$row['gameID']]['winnerID']) {
			//player has picked the winning team
			$score++;
		}
	}
	$query->free;

	return $score;
}

function getGameTotal($week) {
	//get the total number of games for a given week
	global $mysqli;
	$sql = "select count(gameID) as gameTotal from " . DB_PREFIX . "schedule where weekNum = " . $week;
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		return $row['gameTotal'];
	}
	$query->free;
	die('Error getting game total: ' . $mysqli->error);
}

function gameIsLocked($gameID) {
	//find out if a game is locked
	global $mysqli, $cutoffDateTime;
	$sql = "select (DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) > gameTimeEastern or DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) > '" . $cutoffDateTime . "')  as expired from " . DB_PREFIX . "schedule where gameID = " . $gameID;
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		return $row['expired'];
	}
	$query->free;
	die('Error getting game locked status: ' . $mysqli->error);
}

function hidePicks($userID, $week) {
	//find out if user is hiding picks for a given week
	global $mysqli;
	$sql = "select showPicks from " . DB_PREFIX . "picksummary where userID = " . $userID . " and weekNum = " . $week;
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		return (($row['showPicks']) ? 0 : 1);
	}
	$query->free;
	return 0;
}

function getLastCompletedWeek() {
	global $mysqli;
	$lastCompletedWeek = 0;
	$sql = "select s.weekNum, max(s.gameTimeEastern) as lastGameTime,";
	$sql .= " (select count(*) from " . DB_PREFIX . "schedule where weekNum = s.weekNum and (homeScore is NULL or visitorScore is null)) as scoresMissing ";
	$sql .= "from " . DB_PREFIX . "schedule s ";
	$sql .= "where s.gameTimeEastern < DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) ";
	$sql .= "group by s.weekNum ";
	$sql .= "order by s.weekNum";
	//echo $sql;
	$query = $mysqli->query($sql);
	while ($row = $query->fetch_assoc()) {
		if ((int)$row['scoresMissing'] == 0) {
			$lastCompletedWeek = (int)$row['weekNum'];
		}
	}
	$query->free;
	return $lastCompletedWeek;
}

function calculateStats() {
	global $mysqli, $weekStats, $playerTotals, $possibleScoreTotal;
	//get latest week with all entered scores
	$lastCompletedWeek = getLastCompletedWeek();

	//loop through weeks
	for ($week = 1; $week <= $lastCompletedWeek; $week++) {
		//get array of games
		$games = array();
		$sql = "select * from " . DB_PREFIX . "schedule where weekNum = " . $week . " order by gameTimeEastern, gameID";
		$query = $mysqli->query($sql);
		while ($row = $query->fetch_assoc()) {
			$games[$row['gameID']]['gameID'] = $row['gameID'];
			$games[$row['gameID']]['homeID'] = $row['homeID'];
			$games[$row['gameID']]['visitorID'] = $row['visitorID'];
			if ((int)$row['homeScore'] > (int)$row['visitorScore']) {
				$games[$row['gameID']]['winnerID'] = $row['homeID'];
			}
			if ((int)$row['visitorScore'] > (int)$row['homeScore']) {
				$games[$row['gameID']]['winnerID'] = $row['visitorID'];
			}
		}
		$query->free;

		//get array of player picks
		$playerPicks = array();
		$playerWeeklyTotals = array();
		$sql = "select p.userID, p.gameID, p.pickID, p.points, u.firstname, u.lastname, u.userName ";
		$sql .= "from " . DB_PREFIX . "picks p ";
		$sql .= "inner join " . DB_PREFIX . "users u on p.userID = u.userID ";
		$sql .= "inner join " . DB_PREFIX . "schedule s on p.gameID = s.gameID ";
		$sql .= "where s.weekNum = " . $week . " and u.userName <> 'admin' ";
		$sql .= "order by u.lastname, u.firstname, s.gameTimeEastern";
		$query = $mysqli->query($sql);
		while ($row = $query->fetch_assoc()) {
			$playerPicks[$row['userID'] . $row['gameID']] = $row['pickID'];
			$playerWeeklyTotals[$row['userID']][week] = $week;
			$playerTotals[$row['userID']][wins] += 0;
			$playerTotals[$row['userID']][name] = $row['firstname'] . ' ' . $row['lastname'];
			$playerTotals[$row['userID']][userName] = $row['userName'];
			if (!empty($games[$row['gameID']]['winnerID']) && $row['pickID'] == $games[$row['gameID']]['winnerID']) {
				//player has picked the winning team
				$playerWeeklyTotals[$row['userID']][score] += 1;
				$playerTotals[$row['userID']][score] += 1;
			} else {
				$playerWeeklyTotals[$row['userID']][score] += 0;
				$playerTotals[$row['userID']][score] += 0;
			}
		}
		$query->free;

		//get winners & highest score for current week
		$highestScore = 0;
		arsort($playerWeeklyTotals);
		foreach($playerWeeklyTotals as $playerID => $stats) {
			if ($stats[score] > $highestScore) $highestScore = $stats[score];
			if ($stats[score] < $highestScore) break;
			$weekStats[$week][winners][] = $playerID;
			$playerTotals[$playerID][wins] += 1;
		}
		$weekStats[$week][highestScore] = $highestScore;
		$weekStats[$week][possibleScore] = getGameTotal($week);
		$possibleScoreTotal += $weekStats[$week][possibleScore];
	}
}

function rteSafe($strText) {
	//returns safe code for preloading in the RTE
	$tmpString = $strText;

	//convert all types of single quotes
	$tmpString = str_replace(chr(145), chr(39), $tmpString);
	$tmpString = str_replace(chr(146), chr(39), $tmpString);
	$tmpString = str_replace("'", "&#39;", $tmpString);

	//convert all types of double quotes
	$tmpString = str_replace(chr(147), chr(34), $tmpString);
	$tmpString = str_replace(chr(148), chr(34), $tmpString);
//	$tmpString = str_replace("\"", "\"", $tmpString);

	//replace carriage returns & line feeds
	$tmpString = str_replace(chr(10), " ", $tmpString);
	$tmpString = str_replace(chr(13), " ", $tmpString);

	return $tmpString;
}

//the following function was found at http://www.codingforums.com/showthread.php?t=71904
function sort2d ($array, $index, $order='asc', $natsort=FALSE, $case_sensitive=FALSE) {
	if (is_array($array) && count($array) > 0) {
		foreach(array_keys($array) as $key) {
			$temp[$key]=$array[$key][$index];
		}
		if(!$natsort) {
			($order=='asc')? asort($temp) : arsort($temp);
		} else {
			($case_sensitive)? natsort($temp) : natcasesort($temp);
			if($order!='asc') {
				$temp=array_reverse($temp,TRUE);
			}
		}
		foreach(array_keys($temp) as $key) {
			(is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
		}
		return $sorted;
	}
	return $array;
}

function getTeamRecord($teamID) {
	global $mysqli;

	$sql = "select weekNum, (homeScore > visitorScore) as gameWon, (homeScore = visitorScore) as gameTied ";
	$sql .= "from " . DB_PREFIX . "schedule ";
	$sql .= "where (homeScore not in(null, '0') and visitorScore not in(null, '0'))";
	$sql .= " and homeID = '" . $teamID . "' ";
	$sql .= "union ";
	$sql .= "select weekNum, (homeScore < visitorScore) as gameWon, (homeScore = visitorScore) as gameTied ";
	$sql .= "from " . DB_PREFIX . "schedule ";
	$sql .= "where (homeScore not in(null, '0') and visitorScore not in(null, '0'))";
	$sql .= " and visitorID = '" . $teamID . "' ";
	$sql .= "order by weekNum";
	//echo $sql;
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$wins = 0;
		$losses = 0;
		$ties = 0;
		while ($row = $query->fetch_assoc()) {
			if ($row['gameTied']) {
				$ties++;
			} else if ($row['gameWon']) {
				$wins++;
			} else {
				$losses++;
			}
		}
		return $wins . '-' . $losses . '-' . $ties;
	} else {
		return '';
	}
	$query->free;
}

function getTeamStreak($teamID) {
	global $mysqli;

	$sql = "select weekNum, (homeScore > visitorScore) as gameWon, (homeScore = visitorScore) as gameTied ";
	$sql .= "from " . DB_PREFIX . "schedule ";
	$sql .= "where (homeScore not in(null, '0') and visitorScore not in(null, '0'))";
	$sql .= " and homeID = '" . $teamID . "' ";
	$sql .= "union ";
	$sql .= "select weekNum, (homeScore < visitorScore) as gameWon, (homeScore = visitorScore) as gameTied ";
	$sql .= "from " . DB_PREFIX . "schedule ";
	$sql .= "where (homeScore not in(null, '0') and visitorScore not in(null, '0'))";
	$sql .= " and visitorID = '" . $teamID . "' ";
	$sql .= "order by weekNum";
	//echo $sql;
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$prev = '';
		$iStreak = 0;
		while ($row = $query->fetch_assoc()) {
			if ($row['gameTied']) {
				$current = 'T';
			} else if ($row['gameWon']) {
				$current = 'W';
			} else {
				$current = 'L';
			}
			if ($prev == $current) {
				$iStreak++;
			} else {
				$iStreak = 1;
			}
			$prev = $current;
		}
		return $current . ' ' . $iStreak;
	} else {
		return '';
	}
	$query->free;
}
