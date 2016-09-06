<?php
require_once('includes/application_top.php');
include('includes/classes/class.formvalidation.php');

if (!ALLOW_SIGNUP) {
	header('location: login.php?signup=no');
	exit;
}

if (isset($_POST['submit'])) {

	$my_form = new validator;
	$mail = new PHPMailer();

	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];

	if($my_form->checkEmail($email)) { // check for good mail
		if ($my_form->validate_fields('firstname,lastname,email,username,password')) { // comma delimited list of the required form fields
			if ($password == $password2) {
				//create new user, disabled
				$username = $mysqli->real_escape_string(str_replace(' ', '_', $username));
				$sql = "SELECT userName FROM " . DB_PREFIX . "users WHERE userName='".$username."';";
				$query = $mysqli->query($sql);
				if ($query->num_rows > 0) {
					$display = '<div class="responseError">User already exists, please try another username.</div><br/>';
				} else {
					$sql = "SELECT email FROM " . DB_PREFIX . "users WHERE email='".$mysqli->real_escape_string($email)."';";
					$query = $mysqli->query($sql);
					if ($query->num_rows > 0) {
						$display = '<div class="responseError">Email address already exists.  If this is your email account, please log in or reset your password.</div><br/>';
					} else {
						$salt = substr($crypto->encrypt((uniqid(mt_rand(), true))), 0, 10);
						$secure_password = $crypto->encrypt($salt . $crypto->encrypt($password));
						$sql = "INSERT INTO " . DB_PREFIX . "users (userName, password, salt, firstname, lastname, email, status)
							VALUES ('".$username."', '".$secure_password."', '".$salt."', '".$firstname."', '".$lastname."', '".$mysqli->real_escape_string($email)."', 1);";
						$mysqli->query($sql) or die($mysqli->error);

						//send confirmation email
						$mail->IsHTML(true);

						$mail->From = $user->email; // the email field of the form
						$mail->FromName = 'NFL Pick \'Em Admin'; // the name field of the form

						$mail->AddAddress($_POST['email']); // the form will be sent to this address
						$mail->Subject = 'NFL Pick \'Em Confirmation'; // the subject of email

						// html text block
						$mail->Body = '<p>Thank you for signing up for the NFL Pick \'Em Pool.  Please click the below link to confirm your account:<br />' . "\n" .
							SITE_URL . 'signup.php?confirm=' . $crypto->encrypt($username) . '</p>';

						//$mail->Send();

						//header('Location: login.php');
						//exit;
						$_SESSION['logged'] = 'yes';
						$_SESSION['loggedInUser'] = $username;
						header('Location: ./?login=success');
						exit;
					}
				}
			} else {
				$display = '<div class="responseError">Passwords do not match, please try again.</div><br/>';
			}
		} else {
			$display = str_replace($_SESSION['email_field_name'], 'Email', $my_form->error);
			$display = '<div class="responseError">' . $display . '</div><br/>';
		}
	} else {
		$display = '<div class="responseError">There seems to be a problem with your email address, please check.</div><br/>';
	}
}
?>
<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>NFL Pick 'Em Signup</title>

	<base href="<?php echo SITE_URL; ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.min.css" />
	<!--link rel="stylesheet" type="text/css" media="all" href="css/all.css" /-->
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/modernizr-2.7.0.min.js"></script>
	<script type="text/javascript" src="js/svgeezy.min.js"></script>
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<style type="text/css">
	body { background-color: #eee; }
	.form-signin {
		max-width: 330px;
		padding: 15px;
		margin: 0 auto;
	}
	</style>
</head>

<body>
	<div class="container">
		<form class="form-signin" role="form" action="signup.php" method="POST">
			<h1>NFL Pick 'Em Signup</h1>
<?php
if(isset($display)) {
	echo $display;
}
?>
			<p><label for="firstname">First Name:</label>
			<input type="text" name="firstname" value="<?php echo $_POST['firstname']; ?>" class="form-control" placeholder="First Name" required autofocus /></p>
			<p><label for="lastname">Last Name:</label>
			<input type="text" name="lastname" value="<?php echo $_POST['lastname']; ?>" class="form-control" placeholder="Last Name" required /></p>
			<p><label for="email">Email:</label>
			<input type="email" name="email" value="<?php echo $_POST['email']; ?>" class="form-control" placeholder="Email" required /></p>
			<p><label for="username">User Name:</label>
			<input type="text" name="username" value="<?php echo $_POST['username']; ?>" class="form-control" placeholder="User Name" /></p>
			<p><label for="password">Password:</label>
			<input type="password" name="password" value="" class="form-control" placeholder="Password" required /></p>
			<p>Confirm Password:</label>
			<input type="password" name="password2" value="" class="form-control" placeholder="Password (again)" required /></p>
			<p><input type="submit" name="submit" value="Submit" class="btn btn-lg btn-primary btn-block" /></p>
		</form>

    </div> <!-- /container -->
</body>
</html>
<?php
//include('includes/footer.php');
