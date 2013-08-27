<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NFL Pick 'Em</title>
	<link href="css/main.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="css/jquery.countdown.css" rel="stylesheet" type="text/css" media="screen" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/jquery-1.2.6.pack.js"></script>
	<script type="text/javascript" src="js/jquery.countdown.pack.js"></script>
	<script type="text/javascript" src="js/jquery.jclock.js"></script>
</head>

<body>
	<div id="bgextend">
		<div id="pageContent">
		<?php
		if ($_SESSION['logged'] === 'yes') {
		?>
			<div class="navbar"><a href="index.php">Home</a> | <?php if (!$isAdmin) { ?><a href="entry_form.php<?php echo ((!empty($_GET['week'])) ? '?week=' . (int)$_GET['week'] : ''); ?>">Entry Form</a> | <?php } ?><a href="results.php<?php echo ((!empty($_GET['week'])) ? '?week=' . (int)$_GET['week'] : ''); ?>">Results</a> | <a href="standings.php">Standings</a> | <a href="teams.php">Teams</a> | <a href="schedules.php">Schedules</a> | <!--Standings | --><a href="user_edit.php">My Account</a> | <a href="logout.php">Logout <?php echo $_SESSION['loggedInUser']; ?></a> | <a href="rules.php">Rules/Help</a></div>
			<?php if ($isAdmin) { ?><div class="navbar2"><a href="scores.php">Enter Scores</a> | <a href="send_email.php">Send Email</a> | <a href="users.php">Update Users</a> | <a href="schedule_edit.php">Edit Schedule</a> | <a href="email_templates.php">Email Templates</a></div><?php } ?>
		<?php
		}
	
		if ($isAdmin && is_array($warnings) && sizeof($warnings) > 0) {
			echo '<div id="warnings">';
			foreach ($warnings as $warning) {
				echo $warning;
			}
			echo '</div>';
		}
		?>
