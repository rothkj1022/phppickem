<?php
error_reporting(E_ALL ^ E_NOTICE);
//session_start();

require_once('includes/application_top.php');
require('includes/classes/crypto.php');
$crypto = new phpFreaksCrypto;

$_SESSION = array();

if(!empty($_POST['submitPass'])){
	$login->validate_password();
}

//require_once('includes/header.php');
if(empty($_SESSION['logged']) || $_SESSION['logged'] !== 'yes') {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NFL Pick 'Em Login</title>
	<link href="css/main.css" rel="stylesheet" type="text/css" media="screen" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
	<div id="bgextend">
		<div id="login">
		<table>
			<tr valign="top">
				<td><img src="images/logos/nfl-logo.png" /></td>
				<td>&nbsp;</td>
				<td>
					<h1>NFL Pick 'Em Login</h1>
					<?php
					if ($_GET['login'] == 'failed') {
						echo '<div class="responseError">Oops!  Login failed, please try again.</div><br />';
					} else if ($_GET['signup'] == 'no') {
						echo '<div class="responseError">Sorry, signup is disabled.  Please contact your administrator.</div><br />';
					}
					?>
					<div style="margin: 25px; width: 500px; margin: auto;">
						<form action="login.php" method="POST" name="login">
								<table>
									<tr>
										<td><label for="name">Username:</label></td>
										<td><input name="username" id="username" type="text" size="40" /></td>
									</tr>
									<tr>
										<td><label for="password">Password:</label></td>
										<td><input name="password" type="password" size="40" /></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><input type="submit" name="submitPass" value="Submit" class="button"></td>
									</tr>
								</table>
						</form>
						<?php
						if ($allow_signup && $show_signup_link) {
							echo '<p><a href="signup.php">Click here to sign up for an account</a></p>';
						}
						?>
						<p>Having trouble logging in?  Click here to <a href="password_reset.php">reset your password</a>.</p>
						
					</div>
					<script type="text/javascript">
					document.login.username.focus();
					</script>
				</td>
			</tr>
		</table>
	</div>
<?php
}

require('includes/footer.php');
?>