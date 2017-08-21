<p class="skip2content"><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#content">Skip to content &raquo;</a></p>

<div class="bg-primary">
	<b>Current Time (<?php echo SERVER_TIMEZONE_ABBR; ?>) &nbsp; :</b> &nbsp; <?php echo date('Y_m_d'); ?> &nbsp; -  &nbsp;
	<span id="jclock1"></span>
	<script type="text/javascript">
	$(function($) {
		var optionsEST = {
	        timeNotation: '24h',
	        am_pm: false,
			utc: true,
			utc_offset: <?php echo -1 * (4 + SERVER_TIMEZONE_OFFSET); ?>
		}
		$('#jclock1').jclock(optionsEST);
    });
	</script>
</div>

<!-- start countdown code - http://keith-wood.name/countdown.html -->
<?php
$week = (int)$_GET['week'];
if (empty($week)) {
	//get current week
	$week = (int)getCurrentWeek();
}

// echo "week = |" . $week . "|\n";
$firstGameTime = getFirstGameTime($week);
$firstGameExpired = ((date("U", time()+(SERVER_TIMEZONE_OFFSET * 3600)) > strtotime($firstGameTime)) ? true : false);
// echo "firstGameTime = |" . $firstGameTime . "|\n";
// echo "cutoffDateTime = |" . $cutoffDateTime . "|\n";
// echo "firstGameExpired = |" . $firstGameExpired . "|\n";
if ($firstGameTime !== $cutoffDateTime && !$firstGameExpired) {
?>
<div id="firstGame" class="countdown bg-success"></div>
<script type="text/javascript">
//set up countdown for first game
var firstGameTime = new Date("<?php echo date('F j, Y H:i:00', strtotime($firstGameTime)); ?>");
// firstGameTime.setHours(firstGameTime.getHours() -1);
firstGameTime.setHours(firstGameTime.getHours() - <?php echo SERVER_TIMEZONE_OFFSET; ?>);
$('#firstGame').countdown({until: firstGameTime, description: 'until first game in week <?php echo $week; ?> is locked'});
</script>
<?php
}
if (!$weekExpired) {

// $week = (int)$_GET['week'];
// if (empty($week)) {
// 	//get current week
// 	$week = (int)getCurrentWeek();
// }

?>
<div id="picksLocked" class="countdown bg-danger"></div>
<script type="text/javascript">
//set up countdown for picks lock time
var picksLockedTime = new Date("<?php echo date('F j, Y H:i:00', strtotime($cutoffDateTime)); ?>");
// picksLockedTime.setHours(picksLockedTime.getHours() -1);
picksLockedTime.setHours(picksLockedTime.getHours() - <?php echo SERVER_TIMEZONE_OFFSET; ?>);
// $('#picksLocked').countdown({until: picksLockedTime, description: 'until week <?php echo $currentWeek; ?> is locked'});
$('#picksLocked').countdown({until: picksLockedTime, description: 'until all games in week <?php echo $week; ?> is locked'});
</script>
<?php
} else {
	//current week is expired
}
?>
<!-- end countdown code -->
