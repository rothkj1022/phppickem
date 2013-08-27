<?php
require('includes/application_top.php');
require('includes/classes/team.php');

$team = $_GET['team'];
if (empty($team)) {
	$week = $_GET['week'];
	
	//get current week
	$currentWeek = getCurrentWeek();
	if (empty($week)) $week = $currentWeek;
}

include('includes/header.php');
?>
<h1>Schedules</h1>
<p>Select a Team: 
<select name="team" onchange="javascript:location.href='schedules.php?team=' + this.value;">
	<option value=""></option>
<?php
$sql = "select * from " . $db_prefix . "teams order by city, team";
$query = mysql_query($sql);
while ($result = mysql_fetch_array($query)) {
	echo '	<option value="' . $result['teamID'] . '"' . ((!empty($team) && $team == $result['teamID']) ? ' selected="selected"' : '') . '>' . $result['city'] . ' ' . $result['team'] . '</option>' . "\n";
}
?>
</select> <b>OR</b> Week: 
<select name="week" onchange="javascript:location.href='schedules.php?week=' + this.value;">
	<option value="all"<?php echo (($week == 'all') ? ' selected="selected"' : ''); ?>>All</option>
<?php
$sql = "select distinct weekNum from " . $db_prefix . "schedule order by weekNum;";
$query = mysql_query($sql);
while ($result = mysql_fetch_array($query)) {
	echo '	<option value="' . $result['weekNum'] . '"' . ((!empty($week) && $week == $result['weekNum']) ? ' selected="selected"' : '') . '>' . $result['weekNum'] . '</option>' . "\n";
}
?>
</select></p>
<?php
if (!empty($team)) {
	$teamDetails = new team($team);
	echo '<h2><img src="images/logos/' . $team . '.gif" height="60" /> ' . $teamDetails->teamName . ' Schedule</h2>';
}

$sql = "select s.*, ht.city, ht.team, ht.displayName, vt.city, vt.team, vt.displayName from " . $db_prefix . "schedule s ";
$sql .= "inner join " . $db_prefix . "teams ht on s.homeID = ht.teamID ";
$sql .= "inner join " . $db_prefix . "teams vt on s.visitorID = vt.teamID ";
if (!empty($team)) {
	//filter team
	$where .= " where homeID = '" . $team ."' or visitorID = '" . $team . "'";
} else if (!empty($week)) {
	//filter week
	if ($week !== 'all') {
		$where .= " where weekNum = " . $week;
	}
}
$sql .= $where . " order by gameTimeEastern";
$query = mysql_query($sql);
if (mysql_num_rows($query) > 0) {
	echo '<table cellpadding="4" cellspacing="0" class="table1">' . "\n";
	echo '	<tr><th>Home</th><th>Visitor</th><th align="left">Game</th><th>Time / Result</th></tr>' . "\n";
	$i = 0;
	$prevWeek = 0;
	while ($result = mysql_fetch_array($query)) {
		if ($prevWeek !== $result['weekNum'] && empty($team)) {
			echo '	<tr class="subheader"><td colspan="4">Week ' . $result['weekNum'] . '</td></tr>' . "\n";
		}
		$homeTeam = new team($result['homeID']);
		$visitorTeam = new team($result['visitorID']);
		$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
		echo '	<tr' . $rowclass . '>' . "\n";
		echo '		<td><img src="images/helmets_small/' . $homeTeam->teamID . 'R.gif" /></td>' . "\n";
		echo '		<td><img src="images/helmets_small/' . $visitorTeam->teamID . 'L.gif" /></td>' . "\n";
		echo '		<td>' . $visitorTeam->teamName . ' @ ' . $homeTeam->teamName . '</td>' . "\n";
		if (is_numeric($result['homeScore']) && is_numeric($result['visitorScore'])) {
			//if score is entered, show result
			echo '		<td></td>' . "\n";
		} else {
			//show time
			echo '		<td>' . date('D n/j g:i a', strtotime($result['gameTimeEastern'])) . ' ET</td>' . "\n";
		}
		echo '	</tr>' . "\n";
		$prevWeek = $result['weekNum'];
		$i++;
	}
	echo '</table>' . "\n";
}

include('includes/footer.php');
?>
