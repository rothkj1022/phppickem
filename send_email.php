<?php
require('includes/application_top.php');

if (!$user->is_admin) {
	header('Location: ./');
	exit;
}

//get vars
$week = (int)getCurrentWeek();
$prevWeek = $week - 1;
$firstGameTime = getFirstGameTime($week);

$weekStats = array();
$playerTotals = array();
$possibleScoreTotal = 0;
calculateStats();

$winners = '';
if (sizeof($weekStats) > 0) {
	foreach($weekStats[$prevWeek][winners] as $winner => $winnerID) {
		$tmpUser = $login->get_user_by_id($winnerID);
		switch (USER_NAMES_DISPLAY) {
			case 1:
				$winners .= ((strlen($winners) > 0) ? ', ' : '') . trim($tmpUser->firstname . ' ' . $tmpUser->lastname);
				break;
			case 2:
				$winners .= ((strlen($winners) > 0) ? ', ' : '') . $tmpUser->userName;
				break;
			default: //3
				$winners .= ((strlen($winners) > 0) ? ', ' : '') . trim($tmpUser->firstname . ' ' . $tmpUser->lastname) . ' (' . $tmpUser->userName . ')';
				break;
		}
	}
}

$tmpWins = 0;
$i = 1;
if (isset($playerTotals)) {
	//show top 3 winners
	arsort($playerTotals);
	foreach($playerTotals as $playerID => $stats) {
		if ($tmpWins < $stats[wins]) $tmpWins = $stats[wins]; //set initial number of wins
		//if next lowest # of wins is reached, increase counter
		if ($stats[wins] < $tmpWins ) $i++;
		//if wins is zero or counter is 3 or higher, break
		if ($stats[wins] == 0 || $i > 3) break;
		switch (USER_NAMES_DISPLAY) {
			case 1:
				$currentLeaders .= $i . '. ' . $stats[name] . ' - ' . $stats[wins] . (($stats[wins] > 1) ? ' wins' : ' win') . '<br />';
				break;
			case 2:
				$currentLeaders .= $i . '. ' . $stats[userName] . ' - ' . $stats[wins] . (($stats[wins] > 1) ? ' wins' : ' win') . '<br />';
				break;
			default: //3
				$currentLeaders .= $i . '. ' . $stats[name] . ' (' . $stats[userName] . ') - ' . $stats[wins] . (($stats[wins] > 1) ? ' wins' : ' win') . '<br />';
				break;
		}
		$tmpWins = $stats[wins]; //set last # wins
	}
}

$tmpScore = 0;
$i = 1;
if (isset($playerTotals)) {
	//show top 3 pick ratios
	$playerTotals = sort2d($playerTotals, 'score', 'desc');
	foreach($playerTotals as $playerID => $stats) {
		if ($tmpScore < $stats[score]) $tmpScore = $stats[score]; //set initial top score
		//if next lowest score is reached, increase counter
		if ($stats[score] < $tmpScore ) $i++;
		//if score is zero or counter is 3 or higher, break
		if ($stats[score] == 0 || $i > 3) break;
		$pickRatio = $stats[score] . '/' . $possibleScoreTotal;
		$pickPercentage = number_format((($stats[score] / $possibleScoreTotal) * 100), 2) . '%';
		switch (USER_NAMES_DISPLAY) {
			case 1:
				$bestPickRatios .= $i . '. ' . $stats[name] . ' - ' . $pickRatio . ' (' . $pickPercentage . ')<br />';
				break;
			case 2:
				$bestPickRatios .= $i . '. ' . $stats[userName] . ' - ' . $pickRatio . ' (' . $pickPercentage . ')<br />';
				break;
			default: //3
				$bestPickRatios .= $i . '. ' . $stats[name] . ' (' . $stats[userName] . ') - ' . $pickRatio . ' (' . $pickPercentage . ')<br />';
				break;
		}
		$tmpScore = $stats[score]; //set last # wins
	}
}

if ($_POST['action'] == 'Select' && isset($_POST['cannedMsg'])) {
	$cannedMsg = $_POST['cannedMsg'];

	$sql = "select * from " . DB_PREFIX . "email_templates where email_template_key = '" . $cannedMsg . "'";
	$query = $mysqli->query($sql);
	$row = $query->fetch_assoc();
	$subjectTemplate = $row['subject'];
	$messageTemplate = $row['message'];

	//replace variables
	$template_vars = array('{week}', '{first_game}', '{site_url}', '{rules_url}', '{winners}', '{previousWeek}', '{winningScore}', '{possibleScore}', '{currentLeaders}', '{bestPickRatios}');
	$replacement_values = array($week, date('l F j, g:i a', strtotime($firstGameTime)), SITE_URL, SITE_URL . 'rules.php', $winners, $prevWeek, $weekStats[$prevWeek][highestScore], getGameTotal($prevWeek), $currentLeaders, $bestPickRatios);
	$subject = stripslashes(str_replace($template_vars, $replacement_values, $subjectTemplate));
	$message = stripslashes(str_replace($template_vars, $replacement_values, $messageTemplate));
}

if ($_POST['action'] == 'Send Message') {
	$totalGames = getGameTotal($week);
	//get users to send message to
	if ($_POST['cannedMsg'] == 'WEEKLY_PICKS_REMINDER') {
		//select only users missing picks for the current week
		$sql = "select u.firstname, u.email,";
		$sql .= "(select count(p.pickID) from nflp_picks p inner join nflp_schedule s on p.gameID = s.gameID where userID = u.userID and s.weekNum = " . $week . ") as userPicks ";
		$sql .= "from " . DB_PREFIX . "users u ";
		$sql .= "where u.`status` = 1 and u.userName <> 'admin' ";
		$sql .= "group by u.firstname, u.email ";
		$sql .= "having userPicks < " . $totalGames;
	} else {
		//select all users
		$sql = "select firstname, email from " . DB_PREFIX . "users where `status` = 1 and userName <> 'admin'";
	}
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		while ($row = $query->fetch_assoc()) {
			//fire it off!
			$subject = stripslashes($_POST['subject']);
			$message = stripslashes($_POST['message']);
			$message = str_replace('{player}', $row['firstname'], $message);

			$mail = new PHPMailer();
			$mail->IsHTML(true);

			$mail->From = $adminUser->email; // the email field of the form
			$mail->FromName = 'NFL Pick \'Em Admin'; // the name field of the form

			$addresses .= ((strlen($addresses) > 0) ? ', ' : '') . $row['email'];
			$mail->AddAddress($row['email']); // the form will be sent to this address
			$mail->Subject = $subject; // the subject of email

			// html text block
			$mail->Body = $message;
			$mail->Send();
			//echo $subject . '<br />';
			//echo $message;
		}
		$display = '<div class="responseOk">Message successfully sent to: ' . $addresses . '.</div><br/>';
		//header('Location: send_email.php');
		//exit;
	}
	$query->free;
}

include('includes/header.php');

if(isset($display)) {
	echo $display;
} else {
?>
<script language="JavaScript" type="text/javascript" src="js/cbrte/html2xhtml.js"></script>
<script language="JavaScript" type="text/javascript" src="js/cbrte/richtext_compressed.js"></script>
<script language="JavaScript" type="text/javascript">
function submitForm() {
	//make sure hidden and iframe values are in sync for all rtes before submitting form
	updateRTEs();

	return true;
}

//Usage: initRTE(imagesPath, includesPath, cssFile, genXHTML, encHTML)
initRTE("js/cbrte/images/", "js/cbrte/", "", true);
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
<form name="cannedmsgform" action="send_email.php" method="post" onsubmit="return submitForm();">

<p>Select Email Template:<br />
<select name="cannedMsg">
	<option value=""></option>
	<?php
	$sql = "select * from " . DB_PREFIX . "email_templates";
	$query = $mysqli->query($sql);
	while ($row = $query->fetch_assoc()) {
		echo '<option value="' . $row['email_template_key'] . '"' . (($_POST['cannedMsg'] == $row['email_template_key']) ? ' selected="selected"' : '') . '>' . $row['email_template_title'] . '</option>' . "\n";
	}
	$query->free;
	?>
</select>&nbsp;<input type="submit" name="action" value="Select" class="btn btn-info" /></p>

<p>Subject:<br />
<input type="text" name="subject" value="<?php echo $subject; ?>" size="40"></p>

<p>Message:<br />
<script language="JavaScript" type="text/javascript">
//build new richTextEditor
var message = new richTextEditor('message');
<?php
//format content for preloading
if (!empty($message)) {
	$message = rteSafe($message);
}
?>
message.html = '<?php echo $message; ?>';
//rte1.toggleSrc = false;
message.build();
</script>
</p>

<p><input name="action" type="submit" value="Send Message" class="btn btn-info" /></p>
</form>
<?php
}

include('includes/footer.php');
