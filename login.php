<?php
error_reporting(E_ALL ^ E_NOTICE);
//session_start();

require_once('includes/application_top.php');

$_SESSION = array();

if(is_array($_POST) && sizeof($_POST) > 0){
	$login->validate_password();
}

//require_once('includes/header.php');
if(empty($_SESSION['logged']) || $_SESSION['logged'] !== 'yes') {
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
		<form class="form-signin" role="form" action="login.php" method="POST">
			<h2 class="form-signin-heading">NFL Pick 'Em Login</h2>
			<?php
			//print_r($_POST);
			if ($_GET['login'] == 'failed') {
				echo '<div class="responseError">Oops!  Login failed, please try again.</div><br />';
			} else if ($_GET['signup'] == 'no') {
				echo '<div class="responseError">Sorry, signup is disabled.  Please contact your administrator.</div><br />';
			}
			?>
			<p><input type="text" name="username" class="form-control" placeholder="Username" required autofocus />
			<input type="password" name="password" class="form-control" placeholder="Password" required /></p>
			<!--label class="checkbox"><input type="checkbox" value="remember-me"> Remember me</label-->
			<p><button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button></p>
			<?php
			if (ALLOW_SIGNUP && SHOW_SIGNUP_LINK) {
				echo '<p><a href="signup.php">Click here to sign up for an account</a></p>';
			}
			?>
			<p>Having trouble logging in?  Click here to <a href="password_reset.php">reset your password</a>.</p>
		</form>

    </div> <!-- /container -->
</body>
</html>
<?php
//require('includes/footer.php');
}
