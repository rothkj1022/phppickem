<?php
require_once('includes/application_top.php');
require('includes/classes/team.php');

$activeTab = 'home';

include('includes/header.php');

if ($user->userName == 'admin') {
?>
	<img src="images/art_holst_nfl.jpg" width="192" height="295" alt="ref" style="float: right; padding-left: 10px;" />
	<h1>Welcome, Admin!</h1>
	<p><b>If you feel that the work I've done has value to you,</b> I would greatly appreciate a paypal donation (click button below).  I have spent many hours working on this project, and I will continue its development as I find the time.  Again, I am very grateful for any and all contributions.</p>
<?php
	include('includes/donate_button.inc.php');
} else {
	if ($weekExpired) {
		//current week is expired, show message
		echo '	<div class="bg-warning">The current week is locked.  <a href="results.php">Check the Results &gt;&gt;</a></div>' . "\n";
	} else {
		//if all picks not submitted yet for current week
		$picks = getUserPicks($currentWeek, $user->userID);
		$gameTotal = getGameTotal($currentWeek);
		if (sizeof($picks) < $gameTotal) {
			echo '	<div class="bg-warning">You have NOT yet made all of your picks for week ' . $currentWeek . '.  <a href="entry_form.php">Make Your Picks &gt;&gt;</a></div>' . "\n";
		}
	}
	//include('includes/column_right.php');
?>
	<div class="row">
		<div class="col-md-4 col-xs-12 col-right">
<?php
include('includes/column_right.php');
?>
		</div>
		<div id="content" class="col-md-8 col-xs-12">
			<h3>Your Picks At A Glance:</h3>
	<?php
	$lastCompletedWeek = getLastCompletedWeek();

	$sql = "select s.weekNum, count(s.gameID) as gamesTotal,";
	$sql .= " min(s.gameTimeEastern) as firstGameTime,";
	$sql .= " (select gameTimeEastern from " . DB_PREFIX . "schedule where weekNum = s.weekNum and DATE_FORMAT(gameTimeEastern, '%W') = 'Sunday' order by gameTimeEastern limit 1) as cutoffTime,";
	$sql .= " (DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) > (select gameTimeEastern from " . DB_PREFIX . "schedule where weekNum = s.weekNum and DATE_FORMAT(gameTimeEastern, '%W') = 'Sunday' order by gameTimeEastern limit 1)) as expired ";
	$sql .= "from " . DB_PREFIX . "schedule s ";
	$sql .= "group by s.weekNum ";
	$sql .= "order by s.weekNum;";
	$query = $mysqli->query($sql);
	$i = 0;
	$rowclass = '';
	while ($row = $query->fetch_assoc()) {
		//$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
		echo '		<div class="row-week">' . "\n";
		echo '			<p><b>Week ' . $row['weekNum'] . '</b><br />' . "\n";
		echo '			First game: ' . date('n/j g:i a', strtotime($row['firstGameTime'])) . '<br />' . "\n";
		echo '			Cutoff: ' . date('n/j g:i a', strtotime($row['cutoffTime'])) . '</p>' . "\n";
		//echo '		</tr>'."\n";
		if ($row['expired']) {
			//if week is expired, show score (if scores are entered)
			if ($lastCompletedWeek >= (int)$row['weekNum']) {
				//scores entered, show score
				$weekTotal = getGameTotal($row['weekNum']);
				//get player score
				$userScore = getUserScore($row['weekNum'], $user->userID);
				echo '			<div class="bg-info"><b>Score: ' . $userScore . '/' . $weekTotal . ' (' . number_format(($userScore / $weekTotal) * 100, 2) . '%)</b><br /><a href="results.php?week='.$row['weekNum'].'">See Results &raquo;</a></div>' . "\n";
			} else {
				//scores not entered, show ???
				echo '			<div class="bg-info">Week is closed,</b> but scores have not yet been entered.<br /><a href="results.php?week='.$row['weekNum'].'">See Results &raquo;</a></div>' . "\n";
			}
		} else {
			//week is not expired yet, check to see if all picks have been entered
			$picks = getUserPicks($row['weekNum'], $user->userID);
			if (sizeof($picks) < (int)$row['gamesTotal']) {
				//not all picks were entered
				$tmpStyle = '';
				if ((int)$currentWeek == (int)$row['weekNum']) {
					//only show in red if this is the current week
					$tmpStyle = ' style="color: red;"';
				}
				echo '			<div class="bg-warning"'.$tmpStyle.'><b>Missing ' . ((int)$row['gamesTotal'] - sizeof($picks)) . ' / ' . $row['gamesTotal'] . ' picks.</b><br /><a href="entry_form.php?week=' . $row['weekNum'] . '">Enter now &raquo;</a></div>' . "\n";
			} else {
				//all picks were entered
				echo '			<div class="bg-info" style="color: green;"><b>All picks entered.</b><br /><a href="entry_form.php?week=' . $row['weekNum'] . '">Change your picks &raquo;</a></div>' . "\n";
			}
		}
		echo '		</div>'."\n";
		$i++;
	}
	$query->free;
	?>
		</div><!-- end col -->
	</div><!-- end entry-form -->
<?php
	include('includes/comments.php');
}

require('includes/footer.php');
