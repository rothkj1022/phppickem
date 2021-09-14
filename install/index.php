<?php
require('../includes/config.php');

$mysqli = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT) or die('error connecting to db');
if ($mysqli) {
	$mysqli->set_charset('utf8');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Installer - PHP Pick 'Em</title>
	<link href="css/all.css" rel="stylesheet" type="text/css" media="screen" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
	<div id="pageContent">
		<img src="logo.gif" style="float: right;" />
<?php
$step = (int)$_GET['step'];

$pageTitle = 'Installer';
//include('../includes/header_form.php');
echo '<h1>PHP Pick \'Em Installation</h1>' . "\n";

switch ($step) {
	case 3:
		//install tables
		/*
		* Restore MySQL dump using PHP
		* (c) 2006 Daniel15
		* Last Update: 9th December 2006
		* Version: 0.1
		*/

		// Name of the file
		$filename = 'install.sql';
		//////////////////////////////////////////////////////////////////////////////////////////////

		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$lines = file($filename);
		// Loop through each line
		foreach ($lines as $line_num => $line) {
			// Only continue if it's not a comment
			if (substr($line, 0, 2) != '--' && $line != '') {
				// Add this line to the current segment
				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';') {
					// Perform the query
					$templine = str_replace('nflp_', DB_PREFIX, $templine);
					if (!$mysqli->query($templine)) {
						$errors[] = '<p>Error performing query \'<b>' . $templine . '</b>\': ' . $mysqli->error . '</p>';
					}
					// Reset temp variable to empty
					$templine = '';
				}
			}
		}
		if (sizeof($errors) > 0) {
			//we have errors, display
?>
<h2><img src="accept.png" /> Step 1 - Edit Config File</h2>
<h2><img src="cross.png" /> Step 2 - Install Database</h2>
<h3>Step 3 - Complete</h3>
<?php
			echo implode("\n", $errors);
		} else {
			//success
?>
<h3><img src="accept.png" /> Step 1 - Edit Config File</h3>
<h3><img src="accept.png" /> Step 2 - Install Database</h3>
<h2>&gt; Step 3 - Complete</h2>
<p>Congratulations!  Installation is complete.</p>
<p><strong style="color: red;">Please delete the install folder</strong> and click "Complete!" below to continue.</p>
<p>Log in for the first time with <b>admin / admin123</b>.  You may change your password once you are logged in.</p>
<p><input type="button" name="step" value="Complete!" onclick="location.href='../login.php';" /></p>
<?php
		}
		break;
	case 2:
		if (!$mysqli->ping()) {
?>
<h2><img src="cross.png" /> Step 1 - Edit Config File</h2>
<h3>Step 2 - Install Database</h3>
<h3>Step 3 - Complete</h3>
<h4 style="color: red;">Could not connect to database.</h4>
<p>Please check your config file and make sure your database credentials were entered correctly, and that the file was saved.</p>
<h4>Example:</h4>
<p><img src="config.gif" /></p>
<p><input type="button" name="step" value="Try Again" onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?step=2';" /></p>
<?php
		} else {
?>
<h3><img src="accept.png" /> Step 1 - Edit Config File</h3>
<h2>&gt; Step 2 - Install Database</h2>
<h3>Step 3 - Complete</h3>
<p>Thanks, we were able to connect to your database.</p>
<p><input type="button" name="step" value="Continue to step 3 of 3" onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?step=3';" /></p>
<?php
		}
		break;
	default:
?>
<h2>&gt; Step 1 - Edit Config File</h2>
<h3>Step 2 - Install Database</h3>
<h3>Step 3 - Complete</h3>
<h4>Instructions:</h4>
<p>Before getting started, we need some information on the database. You will need to know the following items before proceeding:
<ul>
	<li>Database Host</li>
	<li>Database Username</li>
	<li>Database Password</li>
	<li>Database Name</li>
</ul>
<p>Edit includes/config.php and set the following variables to connect to your database:</p>
<h4>Example:</h4>
<p><img src="config.gif" /></p>
<p><input type="button" name="step" value="Continue to step 2 of 3" onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>?step=2';" /></p>
<?php
		break;
}

//require('../includes/footer.php');
?>
	<div style="clear: both;"></div>
	</div>

</body>
</html>
