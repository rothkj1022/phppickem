<?php
// functions.php
function getCurrentWeek() {
	//get the current week number
	global $db_prefix;
	$sql = "select distinct weekNum from " . $db_prefix . "schedule where DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) < gameTimeEastern order by weekNum limit 1";
	$qryGetCurrentWeek = mysql_query($sql);
	if (mysql_num_rows($qryGetCurrentWeek) > 0) {
		$rstGetCurrentWeek = mysql_fetch_array($qryGetCurrentWeek);
		return $rstGetCurrentWeek['weekNum'];
	} else {
		$sql = "select max(weekNum) as weekNum from " . $db_prefix . "schedule";
		$qryGetCurrentWeek = mysql_query($sql);
		if (mysql_num_rows($qryGetCurrentWeek) > 0) {
			$rstGetCurrentWeek = mysql_fetch_array($qryGetCurrentWeek);
			return $rstGetCurrentWeek['weekNum'];
		}
	}
	die('Error getting current week: ' . mysql_error());
}

function getCutoffDateTime($week) {
	//get the cutoff date for a given week
	global $db_prefix;
	$sql = "select gameTimeEastern from " . $db_prefix . "schedule where weekNum = " . $week . " and DATE_FORMAT(gameTimeEastern, '%W') = 'Sunday' order by gameTimeEastern limit 1;";
	$qryCutoff = mysql_query($sql);
	if (mysql_num_rows($qryCutoff) > 0) {
		$rstCutoff = mysql_fetch_array($qryCutoff);
		return $rstCutoff['gameTimeEastern'];
	}
	die('Error getting cutoff date: ' . mysql_error());
}

function getFirstGameTime($week) {
	//get the first game time for a given week
	global $db_prefix;
	$sql = "select gameTimeEastern from " . $db_prefix . "schedule where weekNum = " . $week . " order by gameTimeEastern limit 1";
	$qryFirstGameTime = mysql_query($sql);
	if (mysql_num_rows($qryFirstGameTime) > 0) {
		$rstFirstGameTime = mysql_fetch_array($qryFirstGameTime);
		return $rstFirstGameTime['gameTimeEastern'];
	}
	die('Error getting first game time: ' . mysql_error());
}

function getPickID($gameID, $userID) {
	//get the pick id for a particular game
	global $db_prefix;
	$sql = "select pickID from " . $db_prefix . "picks where gameID = " . $gameID . " and userID = " . $userID;
	$qryPickID = mysql_query($sql);
	if (mysql_num_rows($qryPickID) > 0) {
		$rstPickID = mysql_fetch_array($qryPickID);
		return $rstPickID['pickID'];
	} else {
		return false;
	}
}

function getGameIDByTeamName($week, $teamName) {
	//get the pick id for a particular game
	global $db_prefix;
	$sql = "select gameID ";
	$sql .= "from " . $db_prefix . "schedule s ";
	$sql .= "inner join " . $db_prefix . "teams t1 on s.homeID = t1.teamID ";
	$sql .= "inner join " . $db_prefix . "teams t2 on s.visitorID = t2.teamID ";
	$sql .= "where weekNum = " . $week;
	$sql .= " and ((t1.city = '" . $teamName . "' or t1.displayName = '" . $teamName . "') or (t2.city = '" . $teamName . "' or t2.displayName = '" . $teamName . "'))";
	$qryGameID = mysql_query($sql);
	if (mysql_num_rows($qryGameID) > 0) {
		$rstGameID = mysql_fetch_array($qryGameID);
		return $rstGameID['gameID'];
	} else {
		return false;
	}
}

function getGameIDByTeamID($week, $teamID) {
	//get the pick id for a particular game
	global $db_prefix;
	$sql = "select gameID ";
	$sql .= "from " . $db_prefix . "schedule s ";
	$sql .= "inner join " . $db_prefix . "teams t1 on s.homeID = t1.teamID ";
	$sql .= "inner join " . $db_prefix . "teams t2 on s.visitorID = t2.teamID ";
	$sql .= "where weekNum = " . $week;
	$sql .= " and (t1.teamID = '" . $teamID . "' or t2.teamID = '" . $teamID . "')";
	//echo $sql . "\n\n";
	$qryGameID = mysql_query($sql);
	if (mysql_num_rows($qryGameID) > 0) {
		$rstGameID = mysql_fetch_array($qryGameID);
		return $rstGameID['gameID'];
	} else {
		return false;
	}
}

function getUserPicks($week, $userID) {
	//gets user picks for a given week
	global $db_prefix;
	$picks = array();
	$sql = "select p.* ";
	$sql .= "from " . $db_prefix . "picks p ";
	$sql .= "inner join " . $db_prefix . "schedule s on p.gameID = s.gameID ";
	$sql .= "where s.weekNum = " . $week . " and p.userID = " . $userID . ";";
	$qryUserPicks = mysql_query($sql);
	while ($rstUserPicks = mysql_fetch_array($qryUserPicks)) {
		$picks[$rstUserPicks['gameID']] = array('pickID' => $rstUserPicks['pickID'], 'points' => $rstUserPicks['points']);
	}
	return $picks;
}

function getUserScore($week, $userID) {
	global $db_prefix, $user;
	
	$score = 0;
	
	//get array of games
	$games = array();
	$sql = "select * from " . $db_prefix . "schedule where weekNum = " . $week . " order by gameTimeEastern, gameID";
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query)) {
		$games[$result['gameID']]['gameID'] = $result['gameID'];
		$games[$result['gameID']]['homeID'] = $result['homeID'];
		$games[$result['gameID']]['visitorID'] = $result['visitorID'];
		if ((int)$result['homeScore'] > (int)$result['visitorScore']) {
			$games[$result['gameID']]['winnerID'] = $result['homeID'];
		}
		if ((int)$result['visitorScore'] > (int)$result['homeScore']) {
			$games[$result['gameID']]['winnerID'] = $result['visitorID'];
		}
	}
	
	//loop through player picks & calculate score
	$sql = "select p.userID, p.gameID, p.pickID, p.points ";
	$sql .= "from " . $db_prefix . "picks p ";
	$sql .= "inner join " . $db_prefix . "users u on p.userID = u.userID ";
	$sql .= "inner join " . $db_prefix . "schedule s on p.gameID = s.gameID ";
	$sql .= "where s.weekNum = " . $week . " and u.userID = " . $user->userID . " ";
	$sql .= "order by u.lastname, u.firstname, s.gameTimeEastern";
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query)) {
		if (!empty($games[$result['gameID']]['winnerID']) && $result['pickID'] == $games[$result['gameID']]['winnerID']) {
			//player has picked the winning team
			$score++;
		}
	}
	
	return $score;
}

function getGameTotal($week) {
	//get the total number of games for a given week
	global $db_prefix;
	$sql = "select count(gameID) as gameTotal from " . $db_prefix . "schedule where weekNum = " . $week;
	$qryGameTotal = mysql_query($sql);
	if (mysql_num_rows($qryGameTotal) > 0) {
		$rstGameTotal = mysql_fetch_array($qryGameTotal);
		return $rstGameTotal['gameTotal'];
	}
	die('Error getting game total: ' . mysql_error());
}

function gameIsLocked($gameID) {
	//find out if a game is locked
	global $cutoffDateTime, $db_prefix;
	$sql = "select (DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) > gameTimeEastern or DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) > '" . $cutoffDateTime . "')  as expired from " . $db_prefix . "schedule where gameID = " . $gameID;
	$qryGameLocked = mysql_query($sql);
	if (mysql_num_rows($qryGameLocked) > 0) {
		$rstGameLocked = mysql_fetch_array($qryGameLocked);
		return $rstGameLocked['expired'];
	}
	die('Error getting game locked status: ' . mysql_error());
}

function hidePicks($userID, $week) {
	//find out if user is hiding picks for a given week
	global $db_prefix;
	$sql = "select showPicks from " . $db_prefix . "picksummary where userID = " . $userID . " and weekNum = " . $week;
	$qryHidePicks = mysql_query($sql);
	if (mysql_num_rows($qryHidePicks) > 0) {
		$rstHidePicks = mysql_fetch_array($qryHidePicks);
		return (($rstHidePicks['showPicks']) ? 0 : 1);
	}
	return 0;
}

function getLastCompletedWeek() {
	global $db_prefix;
	$lastCompletedWeek = 0;
	$sql = "select s.weekNum, max(s.gameTimeEastern) as lastGameTime,";
	$sql .= " (select count(*) from " . $db_prefix . "schedule where weekNum = s.weekNum and (homeScore is NULL or visitorScore is null)) as scoresMissing ";
	$sql .= "from " . $db_prefix . "schedule s ";
	$sql .= "where s.gameTimeEastern < DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) ";
	$sql .= "group by s.weekNum ";
	$sql .= "order by s.weekNum";
	//echo $sql;
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query)) {
		if ((int)$result['scoresMissing'] == 0) {
			$lastCompletedWeek = (int)$result['weekNum'];
		}
	}
	return $lastCompletedWeek;
}

function calculateStats() {
	global $db_prefix, $weekStats, $playerTotals, $possibleScoreTotal;
	//get latest week with all entered scores
	$lastCompletedWeek = getLastCompletedWeek();

	//loop through weeks
	for ($week = 1; $week <= $lastCompletedWeek; $week++) {
		//get array of games
		$games = array();
		$sql = "select * from " . $db_prefix . "schedule where weekNum = " . $week . " order by gameTimeEastern, gameID";
		$query = mysql_query($sql);
		while ($result = mysql_fetch_array($query)) {
			$games[$result['gameID']]['gameID'] = $result['gameID'];
			$games[$result['gameID']]['homeID'] = $result['homeID'];
			$games[$result['gameID']]['visitorID'] = $result['visitorID'];
			if ((int)$result['homeScore'] > (int)$result['visitorScore']) {
				$games[$result['gameID']]['winnerID'] = $result['homeID'];
			}
			if ((int)$result['visitorScore'] > (int)$result['homeScore']) {
				$games[$result['gameID']]['winnerID'] = $result['visitorID'];
			}
		}
		
		//get array of player picks
		$playerPicks = array();
		$playerWeeklyTotals = array();
		$sql = "select p.userID, p.gameID, p.pickID, p.points, u.firstname, u.lastname, u.userName ";
		$sql .= "from " . $db_prefix . "picks p ";
		$sql .= "inner join " . $db_prefix . "users u on p.userID = u.userID ";
		$sql .= "inner join " . $db_prefix . "schedule s on p.gameID = s.gameID ";
		$sql .= "where s.weekNum = " . $week . " and u.userName <> 'admin' ";
		$sql .= "order by u.lastname, u.firstname, s.gameTimeEastern";
		$query = mysql_query($sql);
		while ($result = mysql_fetch_array($query)) {
			$playerPicks[$result['userID'] . $result['gameID']] = $result['pickID'];
			$playerWeeklyTotals[$result['userID']][week] = $week;
			$playerTotals[$result['userID']][wins] += 0;
			$playerTotals[$result['userID']][name] = $result['firstname'] . ' ' . $result['lastname'];
			$playerTotals[$result['userID']][userName] = $result['userName'];
			if (!empty($games[$result['gameID']]['winnerID']) && $result['pickID'] == $games[$result['gameID']]['winnerID']) {
				//player has picked the winning team
				$playerWeeklyTotals[$result['userID']][score] += 1;
				$playerTotals[$result['userID']][score] += 1;
			} else {
				$playerWeeklyTotals[$result['userID']][score] += 0;
				$playerTotals[$result['userID']][score] += 0;
			}
		}
		
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
	global $db_prefix;
	
	$sql = "select weekNum, (homeScore > visitorScore) as gameWon, (homeScore = visitorScore) as gameTied ";
	$sql .= "from " . $db_prefix . "schedule ";
	$sql .= "where (homeScore is not null and visitorScore is not null)";
	$sql .= " and homeID = '" . $teamID . "' ";
	$sql .= "union ";
	$sql .= "select weekNum, (homeScore < visitorScore) as gameWon, (homeScore = visitorScore) as gameTied ";
	$sql .= "from " . $db_prefix . "schedule ";
	$sql .= "where (homeScore is not null and visitorScore is not null)";
	$sql .= " and visitorID = '" . $teamID . "' ";
	$sql .= "order by weekNum";
	//echo $sql;
	$query = mysql_query($sql);
	if (mysql_num_rows($query)) {
		$wins = 0;
		$losses = 0;
		$ties = 0;
		while ($result = mysql_fetch_array($query)) {
			if ($result['gameTied']) {
				$ties++;
			} else if ($result['gameWon']) {
				$wins++;
			} else {
				$losses++;
			}
		}
		return $wins . '-' . $losses . '-' . $ties;
	} else {
		return '';
	}
}

function getTeamStreak($teamID) {
	global $db_prefix;
	
	$sql = "select weekNum, (homeScore > visitorScore) as gameWon, (homeScore = visitorScore) as gameTied ";
	$sql .= "from " . $db_prefix . "schedule ";
	$sql .= "where (homeScore is not null and visitorScore is not null)";
	$sql .= " and homeID = '" . $teamID . "' ";
	$sql .= "union ";
	$sql .= "select weekNum, (homeScore < visitorScore) as gameWon, (homeScore = visitorScore) as gameTied ";
	$sql .= "from " . $db_prefix . "schedule ";
	$sql .= "where (homeScore is not null and visitorScore is not null)";
	$sql .= " and visitorID = '" . $teamID . "' ";
	$sql .= "order by weekNum";
	//echo $sql;
	$query = mysql_query($sql);
	if (mysql_num_rows($query)) {
		$prev = '';
		$iStreak = 0;
		while ($result = mysql_fetch_array($query)) {
			if ($result['gameTied']) {
				$current = 'T';
			} else if ($result['gameWon']) {
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
}
