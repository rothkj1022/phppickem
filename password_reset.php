<?php
require('includes/application_top.php');

if ($_GET['reset'] == 'true') {
	$display = '<div class="responseOk">Your password has been reset, and has been sent to you.</div><br/>';
}

if (is_array($_POST) && sizeof($_POST) > 0) {
	//create new user, disabled
	$sql = "SELECT * FROM " . DB_PREFIX . "users WHERE firstname='".$_POST['firstname']."' and email = '".$_POST['email']."';";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();

		//generate random password and update the db
		$password = randomString(10);
		$salt = substr($crypto->encrypt((uniqid(mt_rand(), true))), 0, 10);
		$secure_password = $crypto->encrypt($salt . $crypto->encrypt($password));
		$sql = "update " . DB_PREFIX . "users set salt = '".$salt."', password = '".$secure_password."' where firstname='".$_POST['firstname']."' and email = '".$_POST['email']."';";
		$mysqli->query($sql) or die($mysqli->error);

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
		$msg .= '<a href="' . SITE_URL . 'login.php">Click here to sign in</a>.</p>';

		$mail->Body = $msg;
		$mail->AltBody = strip_tags($msg);

		$mail->Send();

		header('Location: password_reset.php?reset=true');
		exit;
	} else {
		$display = '<div class="responseError">No account matched, please try again.</div><br/>';
	}
	$query->free;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>NFL Pick 'Em</title>

	<base href="<?php echo SITE_URL; ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.min.css" />
	<!--link rel="stylesheet" type="text/css" media="all" href="css/all.css" /-->
	<!--link rel="stylesheet" type="text/css" media="screen" href="css/jquery.countdown.css" /-->
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/modernizr-2.7.0.min.js"></script>
	<script type="text/javascript" src="js/svgeezy.min.js"></script>
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<style type="text/css">
	body { background-color: #eee; }
	.form-password-reset {
		max-width: 330px;
		padding: 15px;
		margin: 0 auto;
	}
	</style>
</head>

<body>
	<div class="container">
		<form class="form-password-reset" role="form" action="password_reset.php" method="post">
			<h2 class="form-password-reset-heading">Password Reset</h2>
			<?php if(isset($display)) echo $display; ?>
			<p>Enter your name and email address, and a new password will be generated and sent to you.</p>
			<p><input type="text" name="firstname" class="form-control" placeholder="First Name" required autofocus />
			<input type="email" name="email" class="form-control" placeholder="Email Address" required /></p>
			<!--label class="checkbox"><input type="checkbox" value="remember-me"> Remember me</label-->
			<p><button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button></p>
			<p><a href="login.php">Log In</a></p>
		</form>

    </div> <!-- /container -->
</body>
</html>
<?php
//include('includes/footer.php');

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