<?php
require_once('includes/application_top.php');
require('includes/classes/team.php');

if ($_POST['action'] == 'Submit') {
	$week = $_POST['week'];
	$cutoffDateTime = getCutoffDateTime($week);

	//update summary table
	$sql = "delete from " . DB_PREFIX . "picksummary where weekNum = " . $_POST['week'] . " and userID = " . $user->userID . ";";
	$mysqli->query($sql) or die('Error updating picks summary: ' . $mysqli->error);
	$sql = "insert into " . DB_PREFIX . "picksummary (weekNum, userID, showPicks) values (" . $_POST['week'] . ", " . $user->userID . ", " . (int)$_POST['showPicks'] . ");";
	$mysqli->query($sql) or die('Error updating picks summary: ' . $mysqli->error);

	//loop through non-expire weeks and update picks
	$sql = "select * from " . DB_PREFIX . "schedule where weekNum = " . $_POST['week'] . " and (DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) < gameTimeEastern and DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) < '" . $cutoffDateTime . "');";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		while ($row = $query->fetch_assoc()) {
			$sql = "delete from " . DB_PREFIX . "picks where userID = " . $user->userID . " and gameID = " . $row['gameID'];
			$mysqli->query($sql) or die('Error deleting picks: ' . $mysqli->error);

			if (!empty($_POST['game' . $row['gameID']])) {
				$sql = "insert into " . DB_PREFIX . "picks (userID, gameID, pickID) values (" . $user->userID . ", " . $row['gameID'] . ", '" . $_POST['game' . $row['gameID']] . "')";
				$mysqli->query($sql) or die('Error inserting picks: ' . $mysqli->error);
			}
		}
	}
	$query->free;
	header('Location: results.php?week=' . $_POST['week']);
	exit;
} else {
	$week = (int)$_GET['week'];
	if (empty($week)) {
		//get current week
		$week = (int)getCurrentWeek();
	}
	$cutoffDateTime = getCutoffDateTime($week);
	$firstGameTime = getFirstGameTime($week);
}

include('includes/header.php');
include('includes/column_right.php');

//display week nav
$sql = "select distinct weekNum from " . DB_PREFIX . "schedule order by weekNum;";
$query = $mysqli->query($sql);
$weekNav = '<div class="navbar3"><b>Go to week:</b> ';
$i = 0;
if ($query->num_rows > 0) {
	while ($row = $query->fetch_assoc()) {
		if ($i > 0) $weekNav .= ' | ';
		if ($week !== (int)$row['weekNum']) {
			$weekNav .= '<a href="entry_form.php?week=' . $row['weekNum'] . '">' . $row['weekNum'] . '</a>';
		} else {
			$weekNav .= $row['weekNum'];
		}
		$i++;
	}
}
$query->free;
$weekNav .= '</div>' . "\n";
echo $weekNav;
?>
<!--
	<table cellpadding="0" cellspacing="0">
		<tr valign="top">
			<td width="60%">
//-->
				<h2>Week <?php echo $week; ?> - Make Your Picks:</h2>
				<p>Make your picks below by clicking on the team helmet or checking the radio buttons to the right.</p>
				<script type="text/javascript">
				function checkform() {
					//make sure all picks have a checked value
					var f = document.entryForm;
					var allChecked = true;
					var allR = document.getElementsByTagName('input');
					for (var i=0; i < allR.length; i++) {
						if(allR[i].type == 'radio') {
							if (!radioIsChecked(allR[i].name)) {
								allChecked = false;
							}
						}
				    }
				    if (!allChecked) {
    					return confirm('One or more picks are missing for the current week.  Do you wish to submit anyway?');
					}
					return true;
				}
				function radioIsChecked(elmName) {
					var elements = document.getElementsByName(elmName);
					for (var i = 0; i < elements.length; i++) {
						if (elements[i].checked) {
							return true;
						}
					}
					return false;
				}
				</script>
	<div style="float: right; width: 270px; margin-right: 10px"><?php include('includes/comments.php'); ?></div>
	<?php
	//get existing picks
	$picks = getUserPicks($week, $user->userID);

	//get show picks status
	$sql = "select * from " . DB_PREFIX . "picksummary where weekNum = " . $week . " and userID = " . $user->userID . ";";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		$showPicks = (int)$row['showPicks'];
	} else {
		$showPicks = 1;
	}
	$query->free;

	//display schedule for week
	$sql = "select s.*, (DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) > gameTimeEastern or DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) > '" . $cutoffDateTime . "')  as expired ";
	$sql .= "from " . DB_PREFIX . "schedule s ";
	$sql .= "inner join " . DB_PREFIX . "teams ht on s.homeID = ht.teamID ";
	$sql .= "inner join " . DB_PREFIX . "teams vt on s.visitorID = vt.teamID ";
	$sql .= "where s.weekNum = " . $week . " ";
	$sql .= "order by s.gameTimeEastern, s.gameID";
	//echo $sql;
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		echo '<form name="entryForm" action="entry_form.php" method="post" onsubmit="return checkform();">' . "\n";
		echo '<input type="hidden" name="week" value="' . $week . '" />' . "\n";
		echo '<table cellpadding="4" cellspacing="0" class="table1">' . "\n";
		//echo '	<tr><th>Home</th><th>Visitor</th><th align="left">Game</th><th>Time / Result</th><th>Your Pick</th></tr>' . "\n";
		$i = 0;
		while ($row = $query->fetch_assoc()) {
			$homeTeam = new team($row['homeID']);
			$visitorTeam = new team($row['visitorID']);
			$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
			//$pickExpired = ((date("U") > strtotime($row['gameTimeEastern'])) ? true : false);
			echo '		<tr' . $rowclass . '>' . "\n";
			echo '			<td align="center">' . "\n";
			echo '				<table width="100%" border="0" cellpadding="2" cellspacing="0" class="nostyle">' . "\n";
			echo '					<tr valign="middle">' . "\n";
			echo '						<td align="center"><label for="' . $row['gameID'] . $visitorTeam->teamID . '"><img src="images/helmets_big/' . strtolower($visitorTeam->teamID) . '1.gif" onclick="document.entryForm.game' . $row['gameID'] . '[0].checked=true;" /></label><br /><span style="font-size: 9px;"><b>' . $visitorTeam->city . ' ' . $visitorTeam->team . '</b><br />Record: ' . getTeamRecord($visitorTeam->teamID) . '<br />Streak: ' . getTeamStreak($visitorTeam->teamID) . '</span></td>' . "\n";
			echo '						<td align="center">at</td>' . "\n";
			echo '						<td align="center"><label for="' . $row['gameID'] . $homeTeam->teamID . '"><img src="images/helmets_big/' . strtolower($homeTeam->teamID) . '2.gif" onclick="document.entryForm.game' . $row['gameID'] . '[1].checked=true;" /></label><br /><span style="font-size: 9px;"><b>' . $homeTeam->city . ' ' . $homeTeam->team . '</b><br />Record: ' . getTeamRecord($homeTeam->teamID) . '<br />Streak: ' . getTeamStreak($homeTeam->teamID) . '</span></td>' . "\n";
			echo '					</tr>' . "\n";
			if (strlen($row['homeScore']) > 0 && strlen($row['visitorScore']) > 0) {
				//if score is entered, show score
				echo '					<tr><td colspan="3" align="center"><b>Final: ' . $row['visitorScore'] . ' - ' . $row['homeScore'] . '</b></td></tr>' . "\n";
			} else {
				//else show time of game
				echo '					<tr><td colspan="3" align="center">' . date('D n/j g:i a', strtotime($row['gameTimeEastern'])) . ' ET</td></tr>' . "\n";
			}
			echo '				</table>' . "\n";
			echo '			</td>' . "\n";
			echo '			<td align="left"><b>Your Pick:</b><br />' . "\n";
			if (!$row['expired']) {
				//if game is not expired, show pick
				echo '			<input type="radio" name="game' . $row['gameID'] . '" value="' . $visitorTeam->teamID . '" id="' . $row['gameID'] . $visitorTeam->teamID . '"' . (($picks[$row['gameID']]['pickID'] == $visitorTeam->teamID) ? ' checked="checked"' : '') . ' /> <label for="' . $row['gameID'] . $visitorTeam->teamID . '">' . $visitorTeam->teamName . '</label><br />' . "\n";
				echo '			<input type="radio" name="game' . $row['gameID'] . '" value="' . $homeTeam->teamID . '" id="' . $row['gameID'] . $homeTeam->teamID . '"' . (($picks[$row['gameID']]['pickID'] == $homeTeam->teamID) ? ' checked="checked"' : '') . ' /> <label for="' . $row['gameID'] . $homeTeam->teamID . '">' . $homeTeam->teamName . '</label><br />' . "\n";
			} else {
				//else show locked pick
				$pickID = getPickID($row['gameID'], $user->userID);
				if (!empty($pickID)) {
					$statusImg = '';
					$pickTeam = new team($pickID);
					$pickLabel = $pickTeam->teamName;
				} else {
					$statusImg = '<img src="images/cross_16x16.png" width="16" height="16" alt="" />';
					$pickLabel = 'None Selected';
				}
				if ($scoreEntered) {
					//set status of pick (correct, incorrect)
					if ($pickID == $row['winnerID']) {
						$statusImg = '<img src="images/check_16x16.png" width="16" height="16" alt="" />';
					} else {
						$statusImg = '<img src="images/cross_16x16.png" width="16" height="16" alt="" />';
					}
				}
				echo '			' . $statusImg . ' ' . $pickLabel . "\n";
			}
			echo '			</td>' . "\n";
			echo '		</tr>' . "\n";
			$i++;
		}
		echo '</table>' . "\n";
		echo '<p><input type="checkbox" name="showPicks" id="showPicks" value="1"' . (($showPicks) ? ' checked="checked"' : '') . ' /> <label for="showPicks">Allow others to see my picks</label></p>' . "\n";
		echo '<p><input type="submit" name="action" value="Submit" /></p>' . "\n";
		echo '</form>' . "\n";
	}
	?>
<!--
			</td>
			<td width="40%">
				<h2>Latest Comments:</h2>
				<p>comment</p>
				<div>

				</div>
			</td>
		</tr>
	</table>
//-->
<?php
include('includes/footer.php');
