<?php
require('includes/application_top.php');
require('includes/classes/team.php');

if (!$isAdmin) {
	header('Location: index.php');
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
		$sql = "select * from " . $db_prefix . "schedule where gameID = " . $gameID;
		$query = mysql_query($sql);
		if (mysql_num_rows($query) > 0) {
			$result = mysql_fetch_array($query);
			if (date('U') < strtotime($result['gameTimeEastern'])) {
				if ($week !== $result['weekNum'] || $homeID !== $result['homeID'] || $visitorID !== $result['visitorID']) {
					//delete picks for current game
					$sql = "delete from " . $db_prefix . "picks where gameID = " . $gameID;
					mysql_query($sql) or die('error deleting picks');
				}
			}
		} else {
			die('ah, something isn\'t quite right here...');
		}
		
		//update game and redirect to same week
		$sql = "update " . $db_prefix . "schedule ";
		$sql .= "set weekNum = " . $week . ", gameTimeEastern = '" . $gameTimeEastern . "', homeID = '" . $homeID . "', visitorID = '" . $visitorID . "' ";
		$sql .= "where gameID = " . $gameID;
		mysql_query($sql) or die(mysql_error() . '. Query:' . $sql);
		
		header('Location: ' . $_SERVER['PHP_SELF'] . '?week=' . $week);
		break;
	case 'delete':
		$gameID = $_GET['id'];
		$week = $_GET['week'];
		
		//delete picks for current game
		$sql = "delete from " . $db_prefix . "picks where gameID = " . $gameID;
		mysql_query($sql) or die('error deleting picks');
		
		$sql = "delete from " . $db_prefix . "schedule where gameID = " . $gameID;
		mysql_query($sql) or die('error deleting game: ' . $sql);
		header('Location: ' . $_SERVER['PHP_SELF'] . '?week=' . $week);
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
		$sql = "select * from " . $db_prefix . "schedule where gameID = " . (int)$_GET['id'];
		$query = mysql_query($sql);
		if (mysql_num_rows($query) > 0) {
			$result = mysql_fetch_array($query);
			$week = $result['weekNum'];
			$gameTimeEastern = $result['gameTimeEastern'];
			$homeID = $result['homeID'];
			$visitorID = $result['visitorID'];
		} else {
			header('Location: ' . $_SERVER['PHP_SELF']);
		}
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
<table>
	<tr>
		<td>Week:</td>
		<td><input type="text" name="weekNum" value="<?php echo $week; ?>" size="5" /></td>
	</tr>
	<tr>
		<td>Date/Time:</td>
		<td>
			<input type="text" id="gameTimeEastern" name="gameTimeEastern" value="<?php echo date('Y-m-d', strtotime($gameTimeEastern)); ?>" size="10" />
			<input type="text" id="gameTimeEastern2" name="gameTimeEastern2" value="<?php echo date('h:i A', strtotime($gameTimeEastern)); ?>" size="10" />
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
		</td>
	</tr>
	<tr>
		<td>Home Team:</td>
		<td>
			<select name="homeID">
				<option value=""></option>
<?php
$sql = "select * from " . $db_prefix . "teams order by city, team";
$query = mysql_query($sql);
while($result = mysql_fetch_array($query)) {
	if ($homeID == $result['teamID']) {
		echo '				<option value="' . $result['teamID'] . '" selected="selected">' . $result['city'] . ' ' . $result['team'] . '</option>';
	} else {
		echo '				<option value="' . $result['teamID'] . '">' . $result['city'] . ' ' . $result['team'] . '</option>';
	}
}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Visiting Team:</td>
		<td>
			<select name="visitorID">
				<option value=""></option>
<?php
$sql = "select * from " . $db_prefix . "teams order by city, team";
$query = mysql_query($sql);
while($result = mysql_fetch_array($query)) {
	if ($visitorID == $result['teamID']) {
		echo '				<option value="' . $result['teamID'] . '" selected="selected">' . $result['city'] . ' ' . $result['team'] . '</option>';
	} else {
		echo '				<option value="' . $result['teamID'] . '">' . $result['city'] . ' ' . $result['team'] . '</option>';
	}
}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="submit" name="submit" value="<?php echo ucfirst($action); ?>" />&nbsp;
			<input type="button" name="cancel" value="Cancel" onclick="javascript:location.href='<?php echo $_SERVER['PHP_SELF']; ?>?week=<?php echo $week; ?>';" />
		</td>
	</tr>
</table>
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
	$sql = "select distinct weekNum from " . $db_prefix . "schedule order by weekNum;";
	$query = mysql_query($sql);
	while ($result = mysql_fetch_array($query)) {
		echo '	<option value="' . $result['weekNum'] . '"' . ((!empty($week) && $week == $result['weekNum']) ? ' selected="selected"' : '') . '>' . $result['weekNum'] . '</option>' . "\n";
	}
?>
</select></p>
<!--p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=add&week=<?php echo $week; ?>"><img src="images/icons/add_16x16.png" width="16" height="16" alt="Add Game" /></a>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=add">Add Game</a></p-->
<?php
	$sql = "select s.*, ht.city, ht.team, ht.displayName, vt.city, vt.team, vt.displayName from " . $db_prefix . "schedule s ";
	$sql .= "inner join " . $db_prefix . "teams ht on s.homeID = ht.teamID ";
	$sql .= "inner join " . $db_prefix . "teams vt on s.visitorID = vt.teamID ";
	$where .= " where weekNum = " . $week;
	$sql .= $where . " order by gameTimeEastern";
	$query = mysql_query($sql);
	if (mysql_num_rows($query) > 0) {
		echo '<table cellpadding="4" cellspacing="0" class="table1">' . "\n";
		echo '	<tr><th>Home</th><th>Visitor</th><th align="left">Game</th><th>Time / Result</th><th>&nbsp;</th></tr>' . "\n";
		$i = 0;
		$prevWeek = 0;
		while ($result = mysql_fetch_array($query)) {
			if ($prevWeek !== $result['weekNum'] && empty($team)) {
				echo '		<tr class="subheader"><td colspan="5">Week ' . $result['weekNum'] . '</td></tr>' . "\n";
			}
			$homeTeam = new team($result['homeID']);
			$visitorTeam = new team($result['visitorID']);
			$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
			echo '		<tr' . $rowclass . '>' . "\n";
			echo '			<td><img src="images/helmets_small/' . $homeTeam->teamID . 'R.gif" /></td>' . "\n";
			echo '			<td><img src="images/helmets_small/' . $visitorTeam->teamID . 'L.gif" /></td>' . "\n";
			echo '			<td>' . $visitorTeam->teamName . ' @ ' . $homeTeam->teamName . '</td>' . "\n";
			if (is_numeric($result['homeScore']) && is_numeric($result['visitorScore'])) {
				//if score is entered, show result
				echo '			<td></td>' . "\n";
			} else {
				//show time
				echo '			<td>' . date('D n/j g:i a', strtotime($result['gameTimeEastern'])) . ' ET</td>' . "\n";
			}
			echo '			<td><a href="' . $_SERVER['PHP_SELF'] . '?action=edit&id=' . $result['gameID'] . '"><img src="images/icons/edit_16x16.png" width="16" height="16" alt="edit" /></a>&nbsp;<a href="javascript:confirmDelete(\'' . $result['gameID'] . '\');"><img src="images/icons/delete_16x16.png" width="16" height="16" alt="delete" /></a></td>' . "\n";
			echo '		</tr>' . "\n";
			$prevWeek = $result['weekNum'];
			$i++;
		}
		echo '</table>' . "\n";
	}
}
?>
<script type="text/javascript">
<!--
function confirmDelete(id) {
	//confirm delete
	if (confirm('Are you sure you want to delete this game? This action cannot be undone.')) {
		location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&id=" + id;
	}
}
//-->
</script>
<?php
include('includes/footer.php');
?>
