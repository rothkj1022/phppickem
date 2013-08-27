<?php
// application_top.php -- included first on all pages
require('includes/config.php');
require('includes/functions.php');
require('includes/htmlpurifier/HTMLPurifier.auto.php');
$purifier_config = HTMLPurifier_Config::createDefault();
$purifier_config->set('Cache.DefinitionImpl', null); //turns off caching

//filter for cross-site scripting attacks
$purifier = new HTMLPurifier($purifier_config);
foreach($_POST as $key=>$value) {
	if (!is_array($_POST[$key])) {
		$_POST[$key] = $purifier->purify($value);
	}
}

foreach($_GET as $key=>$value){
	$_GET[$key] = $purifier->purify($value);
}

if ($dbConnected) {
	//check for presence of install folder
	if (is_dir('install')) {
		//do a query to see if db installed
		//$testQueryOK = false;
		$sql = "select * from  " . $db_prefix . "teams";
		//die($sql);
		if ($query = mysql_query($sql)) {
			//query is ok, display warning
			$warnings[] = 'For security, please delete or rename the install folder.';
		} else {
			//tables not not present, redirect to installer
			header('location: ./install/');
			exit;
		}
	}
} else {
	die('Database not connected.  Please check your config file for proper installation.');
}

session_start();
require('includes/classes/login.php');
$login = new Login;

$okFiles = array('login.php', 'signup.php', 'password_reset.php');
if (!in_array(basename($_SERVER['PHP_SELF']), $okFiles) && (empty($_SESSION['logged']) || $_SESSION['logged'] !== 'yes')) {
	header( 'Location: login.php' ) ;
} else {
	$user = $login->get_user($_SESSION['loggedInUser']);
	$adminUser = $login->get_user('admin');
}

$isAdmin = 0;
if ($_SESSION['loggedInUser'] === 'admin' && $_SESSION['logged'] === 'yes') {
	$isAdmin = 1;
}
