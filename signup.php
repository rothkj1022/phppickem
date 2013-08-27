<?php
require('includes/application_top.php');
require('includes/classes/crypto.php');
include('includes/classes/class.formvalidation.php');
include('includes/classes/class.phpmailer.php');

if (!$allow_signup) {
	header('location: login.php?signup=no');
	exit;
}

if (isset($_POST['submit'])) {
	
	$my_form = new validator;
	$mail = new PHPMailer();
	$crypto = new phpFreaksCrypto;
	
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
				$username = mysql_real_escape_string(str_replace(' ', '_', $username));
				$sql = "SELECT userName FROM " . $db_prefix . "users WHERE userName='".$username."';";
				$result = mysql_query($sql);
				if(mysql_numrows($result) > 0){
					$display = '<div class="responseError">User already exists, please try another username.</div><br/>';
				} else {
					$sql = "SELECT email FROM " . $db_prefix . "users WHERE email='".mysql_real_escape_string($email)."';";
					$result = mysql_query($sql);
					if(mysql_numrows($result) > 0){
						$display = '<div class="responseError">Email address already exists.  If this is your email account, please log in or reset your password.</div><br/>';
					} else {
						$salt = substr($crypto->encrypt((uniqid(mt_rand(), true))), 0, 10);
						$secure_password = $crypto->encrypt($salt . $crypto->encrypt($password));
						$sql = "INSERT INTO " . $db_prefix . "users (userName, password, salt, firstname, lastname, email, status) 
							VALUES ('".$username."', '".$secure_password."', '".$salt."', '".$firstname."', '".$lastname."', '".mysql_real_escape_string($email)."', 1);";
						mysql_query($sql) or die(mysql_error());
						
						//send confirmation email
						$mail->IsHTML(true);
				
						$mail->From = $user->email; // the email field of the form
						$mail->FromName = 'NFL Pick \'Em Admin'; // the name field of the form
				
						$mail->AddAddress($_POST['email']); // the form will be sent to this address
						$mail->Subject = 'NFL Pick \'Em Confirmation'; // the subject of email
				
						// html text block
						$mail->Body = '<p>Thank you for signing up for the NFL Pick \'Em Pool.  Please click the below link to confirm your account:<br />' . "\n" . 
						$siteUrl . 'signup.php?confirm=' . $crypto->encrypt($username) . '</p>';
										
						//$mail->Send();
						
						//header('Location: login.php');
						$_SESSION['logged'] = 'yes';
						$_SESSION['loggedInUser'] = $username;
						header('Location: index.php?login=success');
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NFL Pick 'Em Signup</title>
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
				<h1>NFL Pick 'Em Signup</h1>
				<?php 
					if(isset($display)) {
						echo $display;
					}
				?>
				<form action="signup.php" method="post" name="addnewuser">	
					<fieldset>
					<legend style="font-weight:bold;">Sign Up</legend>
						<table cellpadding="3" cellspacing="0" border="0">
							<tr><td>First Name:</td><td><input type="text" name="firstname" value="<?php echo $_POST['firstname']; ?>"></td></tr>
							<tr><td>Last Name:</td><td><input type="text" name="lastname" value="<?php echo $_POST['lastname']; ?>"></td></tr>
							<tr><td>Email:</td><td><input type="text" name="email" value="<?php echo $_POST['email']; ?>" size="30"></td></tr>
							<tr><td>User Name:</td><td><input type="text" name="username" value="<?php echo $_POST['username']; ?>"></td></tr>
							<tr><td>Password:</td><td><input type="password" name="password" value=""></td></tr>
							<tr><td>Confirm Password:</td><td><input type="password" name="password2" value=""></td></tr>
							<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Submit"></td></tr>
						</table>
					</fieldset>
				</form>
			</td>
		</tr>
	</table>
<?php
include('includes/footer.php');
?>