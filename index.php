<?php
require_once('includes/application_top.php');
require('includes/classes/team.php');

include('includes/header.php');

if (!$isAdmin) {
	//get current week
	$currentWeek = getCurrentWeek();
	
	$cutoffDateTime = getCutoffDateTime($currentWeek);
	$firstGameTime = getFirstGameTime($currentWeek);
	
	$firstGameExpired = ((date("U", time()+(SERVER_TIMEZONE_OFFSET * 3600)) > strtotime($firstGameTime)) ? true : false);
	$weekExpired = ((date("U", time()+(SERVER_TIMEZONE_OFFSET * 3600)) > strtotime($cutoffDateTime)) ? true : false);
	
	if ($weekExpired) {
		//current week is expired, show message
		echo '	<div class="warning">The current week is locked.  <a href="results.php">Check the Results &gt;&gt;</a></div>' . "\n";
	} else {
		//if all picks not submitted yet for current week
		$picks = getUserPicks($currentWeek, $user->userID);
		$gameTotal = getGameTotal($currentWeek);
		if (sizeof($picks) < $gameTotal) {
			echo '	<div class="warning">You have NOT yet made all of your picks for week ' . $currentWeek . '.  <a href="entry_form.php">Make Your Picks &gt;&gt;</a></div>' . "\n";
		}
	}

	include('includes/column_right.php');
?>
	
	<!-- start countdown code - http://keith-wood.name/countdown.html -->
	<?php if ($firstGameTime !== $cutoffDateTime && !$firstGameExpired) { ?>
	<div id="firstGame" class="countdown"></div>
	<script type="text/javascript">
	<!--
	//set up countdown for first game
	var firstGameTime = new Date("<?php echo date('F j, Y H:i:00', strtotime($firstGameTime)); ?>");
	firstGameTime.setHours(firstGameTime.getHours() -1); 
	$('#firstGame').countdown({until: firstGameTime, description: 'until first game is locked'});
	//-->
	</script>
	<?php } ?>
	<?php if (!$weekExpired) { ?>
	<div id="picksLocked" class="countdown"></div>
	<script type="text/javascript">
	<!--
	//set up countdown for picks lock time
	var picksLockedTime = new Date("<?php echo date('F j, Y H:i:00', strtotime($cutoffDateTime)); ?>");
	picksLockedTime.setHours(picksLockedTime.getHours() -1); 
	$('#picksLocked').countdown({until: picksLockedTime, description: 'until week <?php echo $currentWeek; ?> is locked'});
	//-->
	</script>
	<?php } ?>
	<div style="clear: left;"></div>
	<!-- end countdown code -->
	
	<h3>Your Picks At A Glance:</h3>
	<table cellpadding="4" cellspacing="0" class="table1">
		<tr><th>Week</th><th>First Game</th><th>Cutoff</th><th>Picks</th></tr>
	<?php
	$lastCompletedWeek = getLastCompletedWeek();
	
	$sql = "select s.weekNum, count(s.gameID) as gamesTotal,";
	$sql .= " min(s.gameTimeEastern) as firstGameTime,";
	$sql .= " (select gameTimeEastern from " . $db_prefix . "schedule where weekNum = s.weekNum and DATE_FORMAT(gameTimeEastern, '%W') = 'Sunday' order by gameTimeEastern limit 1) as cutoffTime,";
	$sql .= " (DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) > (select gameTimeEastern from " . $db_prefix . "schedule where weekNum = s.weekNum and DATE_FORMAT(gameTimeEastern, '%W') = 'Sunday' order by gameTimeEastern limit 1)) as expired ";
	$sql .= "from " . $db_prefix . "schedule s ";
	$sql .= "group by s.weekNum ";
	$sql .= "order by s.weekNum;";
	$query = mysql_query($sql);
	$i = 0;
	$rowclass = '';
	while ($result = mysql_fetch_array($query)) {
		$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
		echo '		<tr' . $rowclass . '>' . "\n";
		echo '			<td>Week ' . $result['weekNum'] . '</td>' . "\n";
		echo '			<td>' . date('n/j g:i a', strtotime($result['firstGameTime'])) . '</td>' . "\n";
		echo '			<td>' . date('n/j g:i a', strtotime($result['cutoffTime'])) . '</td>' . "\n";
		if ($result['expired']) {
			//if week is expired, show score (if scores are entered)
			if ($lastCompletedWeek >= (int)$result['weekNum']) {
				//scores entered, show score
				$weekTotal = getGameTotal($result['weekNum']);
				//get player score
				$userScore = getUserScore($result['weekNum'], $user->userID);
				echo '			<td class="lighter" style="color: #000;">Score: ' . $userScore . '/' . $weekTotal . ' (' . number_format(($userScore / $weekTotal) * 100, 2) . '%)</td>' . "\n";
			} else {
				//scores not entered, show ???
				echo '			<td class="lighter" style="color: #000;">week closed, scores not entered.</td>' . "\n";
			}
		} else {
			//week is not expired yet, check to see if all picks have been entered
			$picks = getUserPicks($result['weekNum'], $user->userID);
			if (sizeof($picks) < (int)$result['gamesTotal']) {
				//not all picks were entered
				$tmpStyle = '';
				if ((int)$currentWeek == (int)$result['weekNum']) {
					//only show in red if this is the current week
					$tmpStyle = ' style="color: red;"';
				}
				echo '			<td class="lighter"' . $tmpStyle . '>Missing ' . ((int)$result['gamesTotal'] - sizeof($picks)) . ' / ' . $result['gamesTotal'] . ' picks.  <a href="entry_form.php?week=' . $result['weekNum'] . '">enter now &gt;&gt;</a></td>' . "\n";
			} else {
				//all picks were entered
				echo '			<td class="lighter" style="color: green;">All picks entered.</td>' . "\n";
			}
		}
		$i++;
	}
	?>
	</table>
	<div style="clear: both;"></div>
	<div><?php include('includes/comments.php'); ?></div>
<?php
} else {
?>
	<h1>Welcome, Admin!</h1>
	<img src="images/art_holst_nfl.jpg" width="192" height="295" alt="ref" style="float: right; padding-left: 10px;" />
	<p><b>If you feel that the work I've done has value to you,</b> I would greatly appreciate a paypal donation (click button below).  I have spent many hours working on this project, and I will continue its development as I find the time.  Again, I am very grateful for any and all contributions.</p>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="7664369">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
<?php
}

require('includes/footer.php'); 
?>
