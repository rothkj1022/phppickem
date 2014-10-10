<?php
require('includes/application_top.php');
require('includes/classes/team.php');

if (!$user->is_admin) {
	header('Location: ./');
	exit;
}

$action = $_GET['action'];
switch ($action) {
	case 'edit_action':
		$gameID = $_POST['gameID'];
		$week = $_POST['weekNum'];
		$gameTimeEastern = date('Y-m-d G:i:00', strtotime($_POST['gameTimeEastern'] . ' ' . $_POST['gameTimeEastern2']));
		$homeID = $_POST['homeID'];
		$visitorID = $_POST['visitorID'];

		//make sure all required fields are filled in and valid
		if (empty($homeID) || empty($visitorID)) {
			die('error: missing home or visiting team.');
		}

		//delete all picks already entered for this game
		//IF teams or week num changed, and game is still in the future
		$sql = "select * from " . DB_PREFIX . "schedule where gameID = " . $gameID;
		$query = $mysqli->query($sql);
		if ($query->num_rows > 0) {
			$row = $query->fetch_assoc();
			if (date('U') < strtotime($row['gameTimeEastern'])) {
				if ($week !== $row['weekNum'] || $homeID !== $row['homeID'] || $visitorID !== $row['visitorID']) {
					//delete picks for current game
					$sql = "delete from " . DB_PREFIX . "picks where gameID = " . $gameID;
					$mysqli->query($sql) or die('error deleting picks');
				}
			}
		} else {
			die('ah, something isn\'t quite right here...');
		}
		$query->free;

		//update game and redirect to same week
		$sql = "update " . DB_PREFIX . "schedule ";
		$sql .= "set weekNum = " . $week . ", gameTimeEastern = '" . $gameTimeEastern . "', homeID = '" . $homeID . "', visitorID = '" . $visitorID . "' ";
		$sql .= "where gameID = " . $gameID;
		$mysqli->query($sql) or die($mysqli->error . '. Query:' . $sql);

		header('Location: ' . $_SERVER['PHP_SELF'] . '?week=' . $week);
		exit;
		break;
	case 'delete':
		$gameID = $_GET['id'];
		$week = $_GET['week'];

		//delete picks for current game
		$sql = "delete from " . DB_PREFIX . "picks where gameID = " . $gameID;
		$mysqli->query($sql) or die('error deleting picks');

		$sql = "delete from " . DB_PREFIX . "schedule where gameID = " . $gameID;
		$mysqli->query($sql) or die('error deleting game: ' . $sql);
		header('Location: ' . $_SERVER['PHP_SELF'] . '?week=' . $week);
		exit;
		break;
	default:
		break;
}

include('includes/header.php');

if ($action == 'add' || $action == 'edit') {
	//display add/edit screen
	if ($action =='add') {
		$week = $_GET['week'];
		if (empty($week)) {
			$week = getCurrentWeek();
		}
	} else if ($action == 'edit') {
		$sql = "select * from " . DB_PREFIX . "schedule where gameID = " . (int)$_GET['id'];
		$query = $mysqli->query($sql);
		if ($query->num_rows > 0) {
			$row = $query->fetch_assoc();
			$week = $row['weekNum'];
			$gameTimeEastern = $row['gameTimeEastern'];
			$homeID = $row['homeID'];
			$visitorID = $row['visitorID'];
		} else {
			header('Location: ' . $_SERVER['PHP_SELF']);
			exit;
		}
		$query->free;
	}
?>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.datepicker.js"></script>
<link href="css/jquery-ui-themeroller.css" rel="stylesheet" type="text/css" media="screen" />
<!-- timePicker found at http://labs.perifer.se/timedatepicker/ -->
<script type="text/javascript" src="js/jquery.timePicker.js"></script>
<link href="css/timePicker.css" rel="stylesheet" type="text/css" media="screen" />

<h1><?php echo ucfirst($action); ?> Game</h1>
<div class="warning">Warning: Changes made to future games will erase picks entered for games affected.</div>
<form name="addeditgame" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=<?php echo $action; ?>_action" method="post">
<input type="hidden" name="gameID" value="<?php echo (int)$_GET['id']; ?>" />

<p>Week:<br />
<input type="text" name="weekNum" value="<?php echo $week; ?>" size="5" /></p>

<p>Date/Time:<br />
<input type="date" id="gameTimeEastern" name="gameTimeEastern" value="<?php echo date('Y-m-d', strtotime($gameTimeEastern)); ?>" size="10" />&nbsp;
<input type="time" id="gameTimeEastern2" name="gameTimeEastern2" value="<?php echo date('H:i', strtotime($gameTimeEastern)); ?>" size="10" />
<?php /*
			<script type="text/javascript">
			$("#gameTimeEastern").datepicker({
			    dateFormat: $.datepicker.W3C,
			    showOn: "both",
			    buttonImage: "images/icons/calendar_16x16.png",
			    buttonImageOnly: true
			});
			$("#gameTimeEastern2").timePicker({
				show24Hours:false,
				step: 15
			});
			</script>
*/ ?>
</p>

<p>Home Team:<br />
<select name="homeID">
	<option value=""></option>
<?php
$sql = "select * from " . DB_PREFIX . "teams order by city, team";
$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
	while ($row = $query->fetch_assoc()) {
		if ($homeID == $row['teamID']) {
			echo '	<option value="' . $row['teamID'] . '" selected="selected">' . $row['city'] . ' ' . $row['team'] . '</option>';
		} else {
			echo '	<option value="' . $row['teamID'] . '">' . $row['city'] . ' ' . $row['team'] . '</option>';
		}
	}
}
$query->free;
?>
</select></p>

<p>Visiting Team:<br />
<select name="visitorID">
	<option value=""></option>
<?php
$sql = "select * from " . DB_PREFIX . "teams order by city, team";
$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
	while ($row = $query->fetch_assoc()) {
		if ($visitorID == $row['teamID']) {
			echo '	<option value="' . $row['teamID'] . '" selected="selected">' . $row['city'] . ' ' . $row['team'] . '</option>';
		} else {
			echo '	<option value="' . $row['teamID'] . '">' . $row['city'] . ' ' . $row['team'] . '</option>';
		}
	}
}
$query->free;
?>
</select></p>

<p><input type="submit" name="submit" value="<?php echo ucfirst($action); ?>" class="btn btn-info" />&nbsp;
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?week=<?php echo $week; ?>" />cancel</a></p>

</form>
<?php
} else {
	//display listing
	$week = $_GET['week'];
	if (empty($week)) {
		$week = getCurrentWeek();
	}
?>
<h1>Edit Schedule</h1>
<p>Select a Week:
<select name="week" onchange="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?week=' + this.value;">
<?php
	$sql = "select distinct weekNum from " . DB_PREFIX . "schedule order by weekNum;";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		while ($row = $query->fetch_assoc()) {
			echo '	<option value="' . $row['weekNum'] . '"' . ((!empty($week) && $week == $row['weekNum']) ? ' selected="selected"' : '') . '>' . $row['weekNum'] . '</option>' . "\n";
		}
	}
	$query->free;
?>
</select></p>
<!--p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=add&week=<?php echo $week; ?>"><img src="images/icons/add_16x16.png" width="16" height="16" alt="Add Game" /></a>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=add">Add Game</a></p-->
<div class="table-responsive">
<?php
	$sql = "select s.*, ht.city, ht.team, ht.displayName, vt.city, vt.team, vt.displayName from " . DB_PREFIX . "schedule s ";
	$sql .= "inner join " . DB_PREFIX . "teams ht on s.homeID = ht.teamID ";
	$sql .= "inner join " . DB_PREFIX . "teams vt on s.visitorID = vt.teamID ";
	$where .= " where weekNum = " . $week;
	$sql .= $where . " order by gameTimeEastern";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		echo '<table class="table table-striped">' . "\n";
		echo '	<tr><th>Home</th><th>Visitor</th><th align="left">Game</th><th>Time / Result</th><th>&nbsp;</th></tr>' . "\n";
		$i = 0;
		$prevWeek = 0;
		while ($row = $query->fetch_assoc()) {
			if ($prevWeek !== $row['weekNum'] && empty($team)) {
				echo '		<tr class="info"><td colspan="5">Week ' . $row['weekNum'] . '</td></tr>' . "\n";
			}
			$homeTeam = new team($row['homeID']);
			$visitorTeam = new team($row['visitorID']);
			$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
			echo '		<tr' . $rowclass . '>' . "\n";
			echo '			<td><img src="images/helmets_small/' . $homeTeam->teamID . 'R.gif" /></td>' . "\n";
			echo '			<td><img src="images/helmets_small/' . $visitorTeam->teamID . 'L.gif" /></td>' . "\n";
			echo '			<td>' . $visitorTeam->teamName . ' @ ' . $homeTeam->teamName . '</td>' . "\n";
			if (is_numeric($row['homeScore']) && is_numeric($row['visitorScore'])) {
				//if score is entered, show result
				echo '			<td></td>' . "\n";
			} else {
				//show time
				echo '			<td>' . date('D n/j g:i a', strtotime($row['gameTimeEastern'])) . ' ET</td>' . "\n";
			}
			echo '			<td><a href="' . $_SERVER['PHP_SELF'] . '?action=edit&id=' . $row['gameID'] . '"><img src="images/icons/edit_16x16.png" width="16" height="16" alt="edit" /></a>&nbsp;<a href="javascript:confirmDelete(\'' . $row['gameID'] . '\');"><img src="images/icons/delete_16x16.png" width="16" height="16" alt="delete" /></a></td>' . "\n";
			echo '		</tr>' . "\n";
			$prevWeek = $row['weekNum'];
			$i++;
		}
		echo '</table>' . "\n";
	}
}
?>
<script type="text/javascript">
function confirmDelete(id) {
	//confirm delete
	if (confirm('Are you sure you want to delete this game? This action cannot be undone.')) {
		location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&id=" + id;
	}
}
</script>
<?php
include('includes/footer.php');
