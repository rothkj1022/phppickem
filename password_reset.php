<?php
require('includes/application_top.php');
require('includes/classes/crypto.php');
$crypto = new phpFreaksCrypto;

include('includes/classes/class.phpmailer.php');

if ($_GET['reset'] == 'true') {
	$display = '<div class="responseOk">Your password has been reset, and has been sent to you.</div><br/>';
}

if (isset($_POST['submit'])) {
	//create new user, disabled
	$sql = "SELECT * FROM " . $db_prefix . "users WHERE firstname='".$_POST['firstname']."' and email = '".$_POST['email']."';";
	$query = mysql_query($sql);
	if(mysql_numrows($query) == 0){
		$display = '<div class="responseError">No account matched, please try again.</div><br/>';
	} else {
		$result = mysql_fetch_array($query);
		
		//generate random password and update the db
		$password = randomString(10);
		$salt = substr($crypto->encrypt((uniqid(mt_rand(), true))), 0, 10);
		$secure_password = $crypto->encrypt($salt . $crypto->encrypt($password));
		$sql = "update " . $db_prefix . "users set salt = '".$salt."', password = '".$secure_password."' where firstname='".$_POST['firstname']."' and email = '".$_POST['email']."';";
		mysql_query($sql) or die(mysql_error());
		
		//send confirmation email
		$mail = new PHPMailer();
		$mail->IsHTML(true);

		$mail->From = $adminUser->email; // the email field of the form
		$mail->FromName = 'NFL Pick \'Em Admin'; // the name field of the form

		$mail->AddAddress($_POST['email']); // the form will be sent to this address
		$mail->Subject = 'NFL Pick \'Em Password'; // the subject of email

		// html text block
		$msg = '<p>Your new password for NFL Pick \'Em has been generated.  Your username is: ' . $result['userName'] . '</p>' . "\n\n";
		$msg .= '<p>Your new password is: ' . $password . '</p>' . "\n\n";
		$msg .= '<a href="' . $siteUrl . 'login.php">Click here to sign in</a>.</p>';
		
		$mail->Body = $msg;
		$mail->AltBody = strip_tags($msg);
		
		$mail->Send();
		
		
		header('Location: password_reset.php?reset=true');
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Password Reset</title>
	<link href="css/main.css" rel="stylesheet" type="text/css" media="screen" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
	<style>
	body {
		width: 550px;
	}
	#login {
		margin: 20px auto;
	}
	</style>
	<div id="login">
	<table>
		<tr valign="top">
			<td><img src="images/logos/nfl-logo.png" /></td>
			<td>&nbsp;</td>
			<td>
				<h1>Password Reset</h1>
				<?php if(isset($display)) echo $display; ?>
				<p>Enter your name and email address, and a new password will be generated and sent to you.</p>
				<form action="password_reset.php" method="post" name="pwdreset">	
					<fieldset>
					<legend style="font-weight:bold;">Password Reset</legend>
						<table cellpadding="3" cellspacing="0" border="0">
							<tr><td>First Name:</td><td><input type="text" name="firstname" value="<?php echo $_POST['firstname']; ?>"></td></tr>
							<tr><td>Email:</td><td><input type="text" name="email" value="<?php echo $_POST['email']; ?>"></td></tr>
							<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Submit"></td></tr>
						</table>
					</fieldset>
				</form>
				<p><a href="login.php">Log In</a></p>
			</td>
		</tr>
	</table>
<?php
include('includes/footer.php');

function randomString($length) {
	// Generate random 32 charecter string
	$string = md5(time());

	// Position Limiting
	$highest_startpoint = 32-$length;

	// Take a random starting point in the randomly
	// Generated String, not going any higher then $highest_startpoint
	$randomString = substr($string,rand(0,$highest_startpoint),$length);

	return $randomString;
}
?>