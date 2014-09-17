	<!--div id="columnRight"-->
		<div class="boxRight">
			<b>Current Time (Eastern):</b><br />
			<span id="jclock1"></span>
			<script type="text/javascript">
			$(function($) {
				var optionsEST = {
			        timeNotation: '12h',
			        am_pm: true,
					utc: true,
					utc_offset: -<?php echo 4 + SERVER_TIMEZONE_OFFSET; ?>
				}
				$('#jclock1').jclock(optionsEST);
		    });
			</script>
		</div>

		<!-- start countdown code - http://keith-wood.name/countdown.html -->
		<?php
		if ($firstGameTime !== $cutoffDateTime && !$firstGameExpired) {
		?>
		<div id="firstGame" class="countdown boxRight"></div>
		<script type="text/javascript">
		//set up countdown for first game
		var firstGameTime = new Date("<?php echo date('F j, Y H:i:00', strtotime($firstGameTime)); ?>");
		firstGameTime.setHours(firstGameTime.getHours() -1);
		$('#firstGame').countdown({until: firstGameTime, description: 'until first game is locked'});
		</script>
		<?php
		}
		if (!$weekExpired) {
		?>
		<div id="picksLocked" class="countdown boxRight"></div>
		<script type="text/javascript">
		//set up countdown for picks lock time
		var picksLockedTime = new Date("<?php echo date('F j, Y H:i:00', strtotime($cutoffDateTime)); ?>");
		picksLockedTime.setHours(picksLockedTime.getHours() -1);
		$('#picksLocked').countdown({until: picksLockedTime, description: 'until week <?php echo $currentWeek; ?> is locked'});
		</script>
		<?php
		} else {
			//current week is expired
		}
		?>
		<!-- end countdown code -->

<?php
$weekStats = array();
$playerTotals = array();
$possibleScoreTotal = 0;
calculateStats();

$tmpWins = 0;
$i = 1;
if (is_array($playerTotals) && sizeof($playerTotals) > 0) {
	//show top 3 winners
	echo '		<div class="boxRight">' . "\n";
	echo '			<b>Current Leaders (# wins):</b><br />' . "\n";
	arsort($playerTotals);
	foreach($playerTotals as $playerID => $stats) {
		if ($tmpWins < $stats[wins]) $tmpWins = $stats[wins]; //set initial number of wins
		//if next lowest # of wins is reached, increase counter
		if ($stats[wins] < $tmpWins ) $i++;
		//if wins is zero or counter is 3 or higher, break
		if ($stats[wins] == 0 || $i > 3) break;
		echo '			' . $i . '. ' . $stats[name] . ' - ' . $stats[wins] . (($stats[wins] > 1) ? ' wins' : ' win') . '<br />';
		$tmpWins = $stats[wins]; //set last # wins
	}
	echo '		</div>' . "\n";
}

$tmpScore = 0;
$i = 1;
if (is_array($playerTotals) && sizeof($playerTotals) > 0) {
	//show top 3 pick ratios
	echo '		<div class="boxRight">' . "\n";
	echo '			<b>Current Leaders (pick %):</b><br />' . "\n";
	$playerTotals = sort2d($playerTotals, 'score', 'desc');
	foreach($playerTotals as $playerID => $stats) {
		if ($tmpScore < $stats[score]) $tmpScore = $stats[score]; //set initial top score
		//if next lowest score is reached, increase counter
		if ($stats[score] < $tmpScore ) $i++;
		//if score is zero or counter is 3 or higher, break
		if ($stats[score] == 0 || $i > 3) break;
		$pickRatio = $stats[score] . '/' . $possibleScoreTotal;
		$pickPercentage = number_format((($stats[score] / $possibleScoreTotal) * 100), 2) . '%';
		echo '			' . $i . '. ' . $stats[name] . ' - ' . $pickRatio . ' (' . $pickPercentage . ')<br />';
		$tmpScore = $stats[score]; //set last # wins
	}
	echo '		</div>' . "\n";
}
?>
		<!--
		<div class="boxRight"><b>Latest Comments:</b></div>
		//-->
	<!--/div-->
