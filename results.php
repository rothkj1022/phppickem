<?php
require('includes/application_top.php');

$week = (int)$_GET['week'];
if (empty($week)) {
	//get current week
	$week = (int)getCurrentWeek();
}

$cutoffDateTime = getCutoffDateTime($week);
$weekExpired = ((date("U", time()+(SERVER_TIMEZONE_OFFSET * 3600)) > strtotime($cutoffDateTime)) ? 1 : 0);

include('includes/header.php');
//include('includes/column_right.php');

//display week nav
$sql = "select distinct weekNum from " . $db_prefix . "schedule order by weekNum;";
$query = mysql_query($sql);
$weekNav = '<div class="navbar3"><b>Go to week:</b> ';
$i = 0;
while ($result = mysql_fetch_array($query)) {
	if ($i > 0) $weekNav .= ' | ';
	if ($week !== (int)$result['weekNum']) {
		$weekNav .= '<a href="results.php?week=' . $result['weekNum'] . '">' . $result['weekNum'] . '</a>';
	} else {
		$weekNav .= $result['weekNum'];
	}
	$i++;
}
$weekNav .= '</div>' . "\n";
echo $weekNav;

//get array of games
$allScoresIn = true;
$games = array();
$sql = "select * from " . $db_prefix . "schedule where weekNum = " . $week . " order by gameTimeEastern, gameID";
$query = mysql_query($sql);
while ($result = mysql_fetch_array($query)) {
	$games[$result['gameID']]['gameID'] = $result['gameID'];
	$games[$result['gameID']]['homeID'] = $result['homeID'];
	$games[$result['gameID']]['visitorID'] = $result['visitorID'];
	if (strlen($result['homeScore']) > 0 && strlen($result['visitorScore']) > 0) {
		if ((int)$result['homeScore'] > (int)$result['visitorScore']) {
			$games[$result['gameID']]['winnerID'] = $result['homeID'];
		}
		if ((int)$result['visitorScore'] > (int)$result['homeScore']) {
			$games[$result['gameID']]['winnerID'] = $result['visitorID'];
		}
	} else {
		$games[$result['gameID']]['winnerID'] = '';
		$allScoresIn = false;
	}
}

//get array of player picks
$playerPicks = array();
$playerTotals = array();
$sql = "select p.userID, p.gameID, p.pickID, p.points ";
$sql .= "from " . $db_prefix . "picks p ";
$sql .= "inner join " . $db_prefix . "users u on p.userID = u.userID ";
$sql .= "inner join " . $db_prefix . "schedule s on p.gameID = s.gameID ";
$sql .= "where s.weekNum = " . $week . " and u.userName <> 'admin' ";
$sql .= "order by p.userID, s.gameTimeEastern, s.gameID";
$query = mysql_query($sql);
$i = 0;
while ($result = mysql_fetch_array($query)) {
	$playerPicks[$result['userID']][$result['gameID']] = $result['pickID'];
	if (!empty($games[$result['gameID']]['winnerID']) && $result['pickID'] == $games[$result['gameID']]['winnerID']) {
		//player has picked the winning team
		$playerTotals[$result['userID']] += 1;
	} else {
		$playerTotals[$result['userID']] += 0;
	}
	$i++;
}
?>
<script type="text/javascript">
$(document).ready(function(){
$(".table1 tr").mouseover(function() {
	$(this).addClass("over");}).mouseout(function() {$(this).removeClass("over");
});
$(".table1 tr").click(function() {
	if ($(this).attr('class').indexOf('overPerm') > -1) {
		$(this).removeClass("overPerm");
	} else {
		$(this).addClass("overPerm");
	}
});
});
</script>
<style type="text/css">
.pickTD { width: 24px; font-size: 9px; text-align: center; }
</style>
<h1>Results - Week <?php echo $week; ?></h1>
<?php
if (!$allScoresIn) {
	echo '<p style="font-weight: bold; color: #DBA400;">* Not all scores have been updated for week ' . $week . ' yet.</p>' . "\n";
}

$hideMyPicks = hidePicks($user->userID, $week);
if ($hideMyPicks && !$weekExpired) {
	echo '<p style="font-weight: bold; color: green;">* Your picks are currently hidden to other users.</p>' . "\n";
}

if (sizeof($playerTotals) > 0) {
?>
<table cellpadding="4" cellspacing="0" class="table1">
	<tr><th align="left">Player</th><th colspan="<?php echo sizeof($games); ?>">Week <?php echo $week; ?></th><th align="left">Score</th></tr>
<?php
	$i = 0;
	arsort($playerTotals);
	foreach($playerTotals as $userID => $totalCorrect) {
		$hidePicks = hidePicks($userID, $week);
		if ($i == 0) {
			$topScore = $totalCorrect;
			$winners[] = $userID;
		} else if ($totalCorrect == $topScore) {
			$winners[] = $userID;
		}
		$tmpUser = $login->get_user_by_id($userID);
		$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
		echo '	<tr' . $rowclass . '>' . "\n";
		switch ($user_names_display) {
			case 1:
				echo '		<td>' . trim($tmpUser->firstname . ' ' . $tmpUser->lastname) . '</td>' . "\n";
				break;
			case 2:
				echo '		<td>' . trim($tmpUser->userName) . '</td>' . "\n";
				break;
			default: //3
				echo '		<td><abbrev title="' . trim($tmpUser->firstname . ' ' . $tmpUser->lastname) . '">' . trim($tmpUser->userName) . '</abbrev></td>' . "\n";
				break;
		}
		//loop through all games
		foreach($games as $game) {
			$pick = '';
			$pick = $playerPicks[$userID][$game['gameID']];
			if (!empty($game['winnerID'])) {
				//score has been entered
				if ($playerPicks[$userID][$game['gameID']] == $game['winnerID']) {
					$pick = '<span class="winner">' . $pick . '</span>';
				}
			} else {
				//mask pick if pick and week is not locked and user has opted to hide their picks
				$gameIsLocked = gameIsLocked($game['gameID']);
				if (!$gameIsLocked && !$weekExpired && $hidePicks && (int)$userID !== (int)$user->userID) {
					$pick = '***';
				}
			}
			echo '		<td class="pickTD">' . $pick . '</td>' . "\n";
		}
		echo '		<td>' . $totalCorrect . '/' . sizeof($games) . ' (' . number_format(($totalCorrect / sizeof($games)) * 100, 2) . '%)</td>' . "\n";
		echo '	<tr>' . "\n";
		$i++;
	}

	//if all scores entered, display winner
	if ($allScoresIn) {
		foreach($winners as $winnerID) {
			$winner = $login->get_user_by_id($winnerID);
			if (strlen($winnersHtml) > 0) $winnersHtml .= ', ';
			switch ($user_names_display) {
				case 1:
					$winnersHtml .= trim($winner->firstname . ' ' . $winner->lastname);
					break;
				case 2:
					$winnersHtml .= trim($winner->userName);
					break;
				default: //3
					$winnersHtml .= '<abbrev title="' . trim($winner->firstname . ' ' . $winner->lastname) . '">' . $winner->userName . '</abbrev>';
					break;
			}
		}
		echo '	<tr><th colspan="' . (sizeof($games) + 2) . '" align="left">Winner: ' . $winnersHtml . '</th></tr>' . "\n";
	}
?>
</table>
<?php
	//display list of absent players
	$sql = "select * from " . $db_prefix . "users where userID not in(" . implode(',', array_keys($playerTotals)) . ") and userName <> 'admin'";
	$query = mysql_query($sql);
	if (mysql_num_rows($query) > 0) {
		$absentHtml = '<p><b>Absent Players:</b> ';
		$i = 0;
		while ($result = mysql_fetch_array($query)) {
			if ($i > 0) $absentHtml .= ', ';
			switch ($user_names_display) {
				case 1:
					$absentHtml .= trim($result['firstname'] . ' ' . $result['lastname']);
					break;
				case 2:
					$absentHtml .= $result['userName'];
					break;
				default: //3
					$absentHtml .= '<abbrev title="' . trim($result['firstname'] . ' ' . $result['lastname']) . '">' . $result['userName'] . '</abbrev>';
					break;
			}
			$i++;
		}
		echo $absentHtml;
	}
}

include('includes/comments.php');

include('includes/footer.php');
?>
