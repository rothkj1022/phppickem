<?php
require('includes/application_top.php');
include('includes/classes/class.phpmailer.php');

if (!$isAdmin) {
	header('Location: index.php');
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
		switch ($user_names_display) {
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
		switch ($user_names_display) {
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
		switch ($user_names_display) {
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
	
	$sql = "select * from " . $db_prefix . "email_templates where email_template_key = '" . $cannedMsg . "'";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	$subjectTemplate = $result['subject'];
	$messageTemplate = $result['message'];
	
	//replace variables
	$template_vars = array('{week}', '{first_game}', '{site_url}', '{rules_url}', '{winners}', '{previousWeek}', '{winningScore}', '{possibleScore}', '{currentLeaders}', '{bestPickRatios}');
	$replacement_values = array($week, date('l F j, g:i a', strtotime($firstGameTime)), $siteUrl, $siteUrl . 'rules.php', $winners, $prevWeek, $weekStats[$prevWeek][highestScore], getGameTotal($prevWeek), $currentLeaders, $bestPickRatios);
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
		$sql .= "from " . $db_prefix . "users u ";
		$sql .= "where u.userName <> 'admin' ";
		$sql .= "group by u.firstname, u.email ";
		$sql .= "having userPicks < " . $totalGames;
	} else {
		//select all users
		$sql = "select firstname, email from " . $db_prefix . "users where userName <> 'admin'";
	}
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query)) {
		//fire it off!
		$subject = stripslashes($_POST['subject']);
		$message = stripslashes($_POST['message']);
		$message = str_replace('{player}', $result['firstname'], $message);
		
		$mail = new PHPMailer();
		$mail->IsHTML(true);

		$mail->From = $adminUser->email; // the email field of the form
		$mail->FromName = 'NFL Pick \'Em Admin'; // the name field of the form
		
		$addresses .= ((strlen($addresses) > 0) ? ', ' : '') . $result['email'];
		$mail->AddAddress($result['email']); // the form will be sent to this address
		$mail->Subject = $subject; // the subject of email

		// html text block
		$mail->Body = $message;
		$mail->Send();
		//echo $subject . '<br />';
		//echo $message;
	}
	$display = '<div class="responseOk">Message successfully sent to: ' . $addresses . '.</div><br/>';
	//header('Location: send_email.php');
}

include('includes/header.php');

if(isset($display)) {
	echo $display;
} else {
?>
<script language="JavaScript" type="text/javascript" src="js/cbrte/html2xhtml.js"></script>
<script language="JavaScript" type="text/javascript" src="js/cbrte/richtext_compressed.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function submitForm() {
	//make sure hidden and iframe values are in sync for all rtes before submitting form
	updateRTEs();
	
	return true;
}

//Usage: initRTE(imagesPath, includesPath, cssFile, genXHTML, encHTML)
initRTE("js/cbrte/images/", "js/cbrte/", "", true);
//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
<form name="cannedmsgform" action="send_email.php" method="post" onsubmit="return submitForm();">
<table cellpadding="4" cellspacing="0">
	<tr valign="top">
		<td>Select Email Template:</td>
		<td>
			<select name="cannedMsg">
				<option value=""></option>
				<?php
				$sql = "select * from " . $db_prefix . "email_templates";
				$query = mysql_query($sql);
				while ($result = mysql_fetch_array($query)) {
					echo '<option value="' . $result['email_template_key'] . '"' . (($_POST['cannedMsg'] == $result['email_template_key']) ? ' selected="selected"' : '') . '>' . $result['email_template_title'] . '</option>' . "\n";
				}
				?>
			</select>&nbsp;<input type="submit" name="action" value="Select" />
		</td>
	</tr>
	<tr valign="top">
		<td>Subject:</td>
		<td><input type="text" name="subject" value="<?php echo $subject; ?>" size="40"></td>
	</tr>
	<tr valign="top">
		<td>Message:</td>
		<td>
			<script language="JavaScript" type="text/javascript">
			<!--
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
			//-->
			</script>
		</td>
	</tr>
	<tr><td>&nbsp;</td><td><input name="action" type="submit" value="Send Message" /></td></tr>
</table>
</form>
<?php
}

include('includes/footer.php');
?>