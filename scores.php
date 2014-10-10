<?php
require('includes/application_top.php');
require('includes/classes/team.php');

if (!$user->is_admin) {
	header('Location: ./');
	exit;
}

if ($_POST['action'] == 'Update') {
	foreach($_POST['game'] as $game) {
		$homeScore = ((strlen($game['homeScore']) > 0) ? $game['homeScore'] : 'NULL');
		$visitorScore = ((strlen($game['visitorScore']) > 0) ? $game['visitorScore'] : 'NULL');
		$overtime = ((!empty($game['OT'])) ? '1' : '0');
		$sql = "update " . DB_PREFIX . "schedule ";
		$sql .= "set homeScore = " . $homeScore . ", visitorScore = " . $visitorScore . ", overtime = " . $overtime . " ";
		$sql .= "where gameID = " . $game['gameID'];
		$mysqli->query($sql) or die('Error updating score: ' . $mysqli->error);
	}
	header('Location: ./');
	exit;
}

$week = (int)$_GET['week'];
if (empty($week)) {
	//get current week
	$week = (int)getCurrentWeek();
}

include('includes/header.php');
?>
	<h1>Enter Scores - Week <?php echo $week; ?></h1>
<?php
//display week nav
$sql = "select distinct weekNum from " . DB_PREFIX . "schedule order by weekNum;";
$query = $mysqli->query($sql);
$weekNav = '<div class="navbar3"><b>Go to week:</b> ';
$i = 0;
while ($row = $query->fetch_assoc()) {
	if ($i > 0) $weekNav .= ' | ';
	if ($week !== (int)$row['weekNum']) {
		$weekNav .= '<a href="scores.php?week=' . $row['weekNum'] . '">' . $row['weekNum'] . '</a>';
	} else {
		$weekNav .= $row['weekNum'];
	}
	$i++;
}
$query->free;
$weekNav .= '</div>' . "\n";
echo $weekNav;
?>
<script type="text/javascript">
function getScores(weekNum) {
	$.get("getHtmlScores.php", {week: weekNum}, function(data) {
		for(var item in data) {
			visitorScoreField = document.getElementById('game[' + data[item].gameID + '][visitorScore]');
			homeScoreField = document.getElementById('game[' + data[item].gameID + '][homeScore]');
			OTField = document.getElementById('game[' + data[item].gameID + '][OT]');
			if (visitorScoreField.value !== data[item].visitorScore) {
				visitorScoreField.value = data[item].visitorScore;
				visitorScoreField.className="fieldLoaded";
			}
			if (homeScoreField.value !== data[item].homeScore) {
				homeScoreField.value = data[item].homeScore;
				homeScoreField.className="fieldLoaded";
			}
			if (data[item].overtime == '1') {
				OTField.checked = true;
			}
		}
	},'json');
}
</script>
<p><input type="button" value="Load Scores" onclick="return getScores(<?php echo $week; ?>);" class="btn btn-info" /></p>
<form id="scoresForm" name="scoresForm" action="scores.php" method="post">
<input type="hidden" name="week" value="<?php echo $week; ?>" />
<div class="table-responsive">
<?php
$sql = "select s.*, ht.city, ht.team, ht.displayName, vt.city, vt.team, vt.displayName ";
$sql .= "from " . DB_PREFIX . "schedule s ";
$sql .= "inner join " . DB_PREFIX . "teams ht on s.homeID = ht.teamID ";
$sql .= "inner join " . DB_PREFIX . "teams vt on s.visitorID = vt.teamID ";
$sql .= "where weekNum = " . $week . " ";
$sql .= "order by gameTimeEastern";
$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
	echo '<table class="table table-striped">' . "\n";
	echo '	<tr><th colspan="6" align="left">Week ' . $week . '</th></tr>' . "\n";
	$i = 0;
	while ($row = $query->fetch_assoc()) {
		$homeTeam = new team($row['homeID']);
		$visitorTeam = new team($row['visitorID']);
		$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
		echo '		<tr' . $rowclass . '>' . "\n";
		echo '			<td><input type="hidden" name="game[' . $row['gameID'] . '][gameID]" value="' . $row['gameID'] . '" />' . date('D n/j g:i a', strtotime($row['gameTimeEastern'])) . ' ET</td>' . "\n";
		echo '			<td align="right"><input type="hidden" name="gameID[' . strtolower($visitorTeam->team) . ']" value="' . $row['gameID'] . '" />' . $visitorTeam->teamName . '</td>' . "\n";
		echo '			<td><input type="text" name="game[' . $row['gameID'] . '][visitorScore]" id="game[' . $row['gameID'] . '][visitorScore]" value="' . $row['visitorScore'] . '" size="3" /></td>' . "\n";
		echo '			<td align="right"><input type="hidden" name="gameID[' . strtolower($homeTeam->team) . ']" value="' . $row['gameID'] . '" />at ' . $homeTeam->teamName . '</td>' . "\n";
		echo '			<td><input type="text" name="game[' . $row['gameID'] . '][homeScore]" id="game[' . $row['gameID'] . '][homeScore]" value="' . $row['homeScore'] . '" size="3" /></td>' . "\n";
		echo '			<td>OT <input type="checkbox" name="game[' . $row['gameID'] . '][OT]" id="game[' . $row['gameID'] . '][OT]" value="1"' . (($row['overtime']) ? ' checked="checked"' : '') . '" /></td>' . "\n";
		echo '		</tr>' . "\n";
		$i++;
	}
	echo '</table>' . "\n";
}
$query->free;
?>
</div>
<input type="submit" name="action" value="Update" class="btn btn-info" />
</form>
<?php
include('includes/footer.php');
