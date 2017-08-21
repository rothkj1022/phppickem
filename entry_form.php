<?php
require_once('includes/application_top.php');
require('includes/classes/team.php');
require_once('includes/classes/class.phpmailer.php');

if ($_POST['action'] == 'Submit') {
	$week = $_POST['week'];
	$cutoffDateTime = getCutoffDateTime($week);
	$bestBet = (isset($_POST['bestBet']) ? (int)($_POST['bestBet']) : 0);

	//update summary table
	$sql = "delete from " . DB_PREFIX . "picksummary where weekNum = " . $_POST['week'] . " and userID = " . $user->userID . ";";
	$mysqli->query($sql) or die('Error updating picks summary: ' . $mysqli->error);
	$sql = "insert into " . DB_PREFIX . "picksummary (weekNum, userID, showPicks, bestBet, tieBreakerPoints) values (" . $_POST['week'] . ", " . $user->userID . ", " . (int)$_POST['showPicks'] . ", $bestBet);";
	$mysqli->query($sql) or die('Error updating picks summary: ' . $mysqli->error);

	//loop through non-expire weeks and update picks
	$pickText = "";
	$bbTeam = "";
	if (ENABLE_LATE_PICKS)
		$sql = "select * from " . DB_PREFIX . "schedule where weekNum = " . $_POST['week'] . ";";
	else
		$sql = "select * from " . DB_PREFIX . "schedule where weekNum = " . $_POST['week'] . " and (DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) < gameTimeEastern and DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) < '" . $cutoffDateTime . "');";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		while ($row = $query->fetch_assoc()) {
			$sql = "delete from " . DB_PREFIX . "picks where userID = " . $user->userID . " and gameID = " . $row['gameID'];
			$mysqli->query($sql) or die('Error deleting picks: ' . $mysqli->error);

			if (!empty($_POST['game' . $row['gameID']])) {
				$sql = "insert into " . DB_PREFIX . "picks (userID, gameID, pickID) values (" . $user->userID . ", " . $row['gameID'] . ", '" . $_POST['game' . $row['gameID']] . "')";
				$mysqli->query($sql) or die('Error inserting picks: ' . $mysqli->error);

				$pickText .= $_POST['game' . $row['gameID']] . " ";
				if ($row['gameID'] == $bestBet)
					$bbTeam = $_POST['game' . $row['gameID']];
			}
		}
	}
	$query->free;

	if (ENABLE_PICK_EMAIL) {
		// Send notification email
		$mail = new PHPMailer();
		$mail->IsHTML(true);

		$mail->From = $adminUser->email;
		$mail->FromName = SITE_NAME;

		$addresses .= ((strlen($addresses) > 0) ? ', ' : '') . $result['email'];
		$mail->AddAddress(MAILING_LIST);
		$mail->Subject = $user->userName . " has entered picks";

		// html text block
		$mail->Body = "Picks: $pickText, Best Bet = $bbTeam";
		$mail->Send();
	}

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
	$teamList = getTeamsList();
}

include('includes/header.php');
?>
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
		if (document.getElementById('tiebreaker').value == ""){
      return confirm('You have not entered a tiebreaker score!  Do you want to submit anyway?');
    }
    if(document.getElementById('survivor').value === "") {
    	alert('You have not entered a survivor pick');
    	return false;
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
	function checkRadios() {
	  $('input[type=radio]').each(function(){
	   //alert($(this).attr('checked'));
	    var targetLabel = $('label[for="'+$(this).attr('id')+'"]');
	    console.log($(this).attr('id')+': '+$(this).is(':checked'));
	    if ($(this).is(':checked')) {
	      //console.log(targetLabel);
	     targetLabel.addClass('highlight');
	    } else {
	      targetLabel.removeClass('highlight');
	    }
	  });
	}
	$(function() {
		checkRadios();
		$('input[type=radio]').click(function(){
		  checkRadios();
		});
		$('label').click(function(){
		  checkRadios();
		});
	});
	</script>
<?php
//display week nav
$sql = "select distinct weekNum from " . DB_PREFIX . "schedule order by weekNum;";
$query = $mysqli->query($sql);
$weekNav = '<div id="weekNav" class="row">';
$weekNav .= '	<div class="navbar3 col-xs-12"><b>Go to week:</b> ';
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
$weekNav .= '	</div>' . "\n";
$weekNav .= '</div>' . "\n";
echo $weekNav;
?>
		<div class="row">
			<div class="col-md-4 col-xs-12 col-right">
<?php
include('includes/column_right.php');
?>
			</div>
			<div id="content" class="col-md-8 col-xs-12">
				<h2>Week <?php echo $week; ?> - Make Your Picks:</h2>
				<p>Please make your picks below for each game.</p>
	<?php
	//get existing picks
	$picks = getUserPicks($week, $user->userID);
	$survivorPicks = getSurvivorPrevPicks($user->userID);
	$survivorPick = "";

        //get tie-breaker status
	$sql = "select * from " . DB_PREFIX . "picksummary where weekNum = " . $week . " and userID = " . $user->userID . ";";
	$query = $mysqli->query($sql) or die('Error getting tie-breaker status: ' . $mysqli->error);
	if ($query->num_rows > 0) {
		$result = $query->fetch_assoc();
                $tieBreakerPoints = (int)$result['tieBreakerPoints'];
        } else {
                $tieBreakerPoints = DEFAULT_TIEBREAKER_POINTS;
        }
	//initial db sets tiBreakerPoints=0 so the following is needed to set default points
	//a user can still set this to 0 since we don't check after a number is entered
	//if they attempt to change their points/picks again the default value will
	//show the default from config.php and if submitted it will be set to the default
        if ($tieBreakerPoints == 0 OR $tieBreakerPoints == "") {
		$tieBreakerPoints = DEFAULT_TIEBREAKER_POINTS;
	}
$pickSummary = get_pick_summary($user->userID, $week);
	//get show picks status
	$sql = "select * from " . DB_PREFIX . "picksummary where weekNum = " . $week . " and userID = " . $user->userID . ";";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		$showPicks = (int)$row['showPicks'];
		$tiebreaker = $row['tieBreakerPoints'];
		$survivorPick = $row['survivor'];
	} else {
		$showPicks = 0;
		$tiebreaker = "";
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
	$query = $mysqli->query($sql) or die($mysqli->error);
	if ($query->num_rows > 0) {
		echo '<form name="entryForm" action="entry_form.php" method="post" onsubmit="return checkform();">' . "\n";
		echo '<input type="hidden" name="week" value="' . $week . '" />' . "\n";
		//echo '<table cellpadding="4" cellspacing="0" class="table1">' . "\n";
		//echo '	<tr><th>Home</th><th>Visitor</th><th align="left">Game</th><th>Time / Result</th><th>Your Pick</th></tr>' . "\n";
		echo '		<div class="row">'."\n";
		echo '			<div class="col-xs-12">'."\n";
		$i = 0;
		while ($row = $query->fetch_assoc()) {
			$scoreEntered = false;
			$homeTeam = new team($row['homeID']);
			$visitorTeam = new team($row['visitorID']);
			$homeScore = (int)$row['homeScore'];
			$visitorScore = (int)$row['visitorScore'];
			$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
			echo '				<div class="matchup">' . "\n";
			echo '					<div class="row bg-row1">'."\n";
			if (strlen($row['homeScore']) > 0 && strlen($row['visitorScore']) > 0) {
				//if score is entered, show score
				$scoreEntered = true;
				$homeScore = (int)$row['homeScore'];
				$visitorScore = (int)$row['visitorScore'];
				if ($homeScore > $visitorScore) {
					$winnerID = $row['homeID'];
				} else if ($visitorScore > $homeScore) {
					$winnerID = $row['visitorID'];
				};
				//$winnerID will be null if tie, which is ok
				echo '					<div class="col-xs-12 center"><b>Final: ' . $row['visitorScore'] . ' - ' . $row['homeScore'] . '</b></div>' . "\n";
			} else {
				//else show time of game
				echo '					<div class="col-xs-12 center">' . date('D n/j g:i a', strtotime($row['gameTimeEastern'])) . ' ET</div>' . "\n";
			}
			echo '					</div>'."\n";
			echo '					<div class="row versus">' . "\n";

			echo '						<div class="col-xs-1 center">' . "\n";
			if (ENABLE_BEST_BET) {
				echo '							<label for="bb' . $row['gameID'] . '" class="label-for-check"><div class="bbLabel" onclick="document.entryForm.bb'.$row['gameID'].'[0].checked=true;"><p>BB</p></div>'. "\n";
			}
			echo '						</div>' . "\n";

			echo '						<div class="col-xs-4">'."\n";
			echo '							<label for="' . $row['gameID'] . $visitorTeam->teamID . '" class="label-for-check"><div class="team-logo"><img src="images/logos/'.$visitorTeam->teamID.'.svg" onclick="document.entryForm.game'.$row['gameID'].'[0].checked=true;" /></div></label>' . "\n";
			echo '						</div>'."\n";
			echo '						<div class="col-xs-2">@</div>' . "\n";
			echo '						<div class="col-xs-4">'."\n";
			echo '							<label for="' . $row['gameID'] . $homeTeam->teamID . '" class="label-for-check"><div class="team-logo"><img src="images/logos/'.$homeTeam->teamID.'.svg" onclick="document.entryForm.game' . $row['gameID'] . '[1].checked=true;" /></div></label>'."\n";
			echo '						</div>' . "\n";
			echo '						<div class="col-xs-1"></div>' . "\n";
			echo '					</div>' . "\n";
			if (!$row['expired'] || ENABLE_LATE_PICKS) {
				echo '					<div class="row bg-row2">'."\n";

				echo '						<div class="col-xs-1 center">' . "\n";
				if (ENABLE_BEST_BET) {
					$checkedText = (($pickSummary['bestBet'] == $row['gameID']) ? ' checked="checked"' : '');
					echo '							<input type="radio" name="bestBet" value="' . $row['gameID'] . '" id="bb' . $row['gameID'] . '"' . $checkedText . '/>' . "\n";
				}
				echo '						</div>' . "\n";

				echo '						<div class="col-xs-4 center">'."\n";
				echo '							<input type="radio" class="check-with-label" name="game' . $row['gameID'] . '" value="' . $visitorTeam->teamID . '" id="' . $row['gameID'] . $visitorTeam->teamID . '"' . (($picks[$row['gameID']]['pickID'] == $visitorTeam->teamID) ? ' checked' : '') . ' />'."\n";
				echo '						</div>'."\n";
				//echo '						<div class="col-xs-2 center" style="font-size: 0.8em;">&#9664; Choose &#9654;</div>' . "\n";
				echo '						<div class="col-xs-2"></div>' . "\n";
				echo '						<div class="col-xs-4 center">'."\n";
				echo '							<input type="radio" class="check-with-label" name="game' . $row['gameID'] . '" value="' . $homeTeam->teamID . '" id="' . $row['gameID'] . $homeTeam->teamID . '"' . (($picks[$row['gameID']]['pickID'] == $homeTeam->teamID) ? ' checked' : '') . ' />' . "\n";
				echo '						</div>' . "\n";
				echo '						<div class="col-xs-1"></div>' . "\n";
				echo '					</div>' . "\n";
			}
			if (ENABLE_SPREAD) {
				$homeSpread = (($row['spread'] == "") ? 0 : $row['spread']);
				$awaySpread = $homeSpread * -1;
				$homeSpreadStr = " (" . sprintf("%+.1f", $homeSpread) . ")";
				$awaySpreadStr = " (" . sprintf("%+.1f", $awaySpread) . ")";
			} else {
				$homeSpreadStr = "";
				$awaySpreadStr = "";
			}

			echo '					<div class="row bg-row3">'."\n";
			echo '						<div class="col-xs-6 center">'."\n";
			echo '							<div class="team">' . $visitorTeam->city . ' ' . $visitorTeam->team . '</div>'."\n";
			$teamRecord = trim(getTeamRecord($visitorTeam->teamID,$week));
			if (!empty($teamRecord)) {
				echo '							<div class="record">Record: ' . $teamRecord . '</div>'."\n";
			}
			$teamStreak = trim(getTeamStreak($visitorTeam->teamID,$week));
			if (!empty($teamStreak)) {
				echo '							<div class="streak">Streak: ' . $teamStreak . '</div>'."\n";
			}
			echo '							<div class="team">' . $visitorTeam->city . ' ' . $visitorTeam->team . $awaySpreadStr . '</div>'."\n";
			echo '							<div class="record">Record: ' . getTeamRecord($visitorTeam->teamID) . '</div>'."\n";
			echo '							<div class="streak">Streak: ' . getTeamStreak($visitorTeam->teamID) . '</div>'."\n";
			echo '						</div>'."\n";
			echo '						<div class="col-xs-6 center">' . "\n";
			echo '							<div class="team">' . $homeTeam->city . ' ' . $homeTeam->team . '</div>'."\n";
			$teamRecord = trim(getTeamRecord($homeTeam->teamID,$week));
			if (!empty($teamRecord)) {
				echo '							<div class="record">Record: ' . $teamRecord . '</div>'."\n";
			}
			$teamStreak = trim(getTeamStreak($homeTeam->teamID,$week));
			if (!empty($teamStreak)) {
				echo '							<div class="streak">Streak: ' . $teamStreak . '</div>'."\n";
			}
			echo '							<div class="team">' . $homeTeam->city . ' ' . $homeTeam->team . $homeSpreadStr . '</div>'."\n";
			echo '							<div class="record">Record: ' . getTeamRecord($homeTeam->teamID) . '</div>'."\n";
			echo '							<div class="streak">Streak: ' . getTeamStreak($homeTeam->teamID) . '</div>'."\n";
			echo '						</div>' . "\n";
			echo '					</div>'."\n";
			if ($row['expired'] && !ENABLE_LATE_PICKS) {
				//else show locked pick
				echo '					<div class="row bg-row4">'."\n";
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
					if ($pickID == $winnerID) {
						$statusImg = '<img src="images/check_16x16.png" width="16" height="16" alt="" />';
					} else {
						$statusImg = '<img src="images/cross_16x16.png" width="16" height="16" alt="" />';
					}
				}
				echo '						<div class="col-xs-12 center your-pick"><b>Your Pick:</b></br />';
				echo $statusImg . ' ' . $pickLabel;
				if (ENABLE_BEST_BET && ($pickSummary['bestBet'] == $result['gameID']))
					echo "<p>Best Bet</p>\n";
				echo '</div>' . "\n";
				echo '					</div>' . "\n";
			}
			echo '				</div>'."\n";
			$i++;
		}
		echo '		</div>' . "\n";
		echo '		</div>' . "\n";
		if (ALWAYS_HIDE_PICKS) {
			echo '<p class="noprint"><input type="hidden" name="showPicks" id="showPicks" value="0"' . (($showPicks) ? ' checked="checked"' : '') . ' /> <label for="showPicks">' . "\n";
		} else {
			echo '<p class="noprint"><input type="checkbox" name="showPicks" id="showPicks" value="1"' . (($showPicks) ? ' checked="checked"' : '') . ' /> <label for="showPicks">Allow others to see my picks</label></p>' . "\n";
		}
		if (SHOW_TIEBREAKER_POINTS) {
			echo '<p><strong>Tie Breaker Points</strong> <input type="text" name="tieBreakerPoints" id="tieBreakerPoints" maxlength="3" size=3 value="' . $tieBreakerPoints . '" /> ' . " << Default is " . DEFAULT_TIEBREAKER_POINTS . "\n";
		} else {
                	echo '<input type="hidden" name="tieBreakerPoints" id="tieBreakerPoints" value="0" />' . "\n";
		}
		echo '<p class="noprint"><input type="submit" name="action" value="Submit" /></p>' . "\n";
		echo '</form>' . "\n";
	}

echo '	</div>'."\n"; // end col
echo '	</div>'."\n"; // end entry-form row

//echo '<div id="comments" class="row">';
include('includes/comments.php');
//echo '</div>';

include('includes/footer.php');
