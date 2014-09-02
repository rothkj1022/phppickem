<?php
header('Content-Type:text/html; charset=utf-8');
header('X-UA-Compatible:IE=Edge,chrome=1'); //IE8 respects this but not the meta tag when under Local Intranet
?>
<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>NFL Pick 'Em</title>

	<base href="<?php echo SITE_URL; ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/all.css" />
	<!--link rel="shortcut icon" type="image/x-icon" href="<?php echo $currentUri['protocol'] . '://' . WS_DOMAIN . WS_WWW_ROOT; ?>favicon.ico" /-->
	<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/modernizr-2.7.0.min.js"></script>
	<script type="text/javascript" src="js/svgeezy.min.js"></script>
	<script type="text/javascript" src="js/jquery.main.js"></script>


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
