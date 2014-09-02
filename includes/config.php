<?php
//modify vars below
$db_host = 'localhost';
$db_user = '';
$db_password = '';
$database = 'nflpickem';
$db_prefix = 'nflp_';

$siteUrl = 'http://localhost/personal/phppickem.com/application/';
$allow_signup = true;
$show_signup_link = true;
$user_names_display = 3; // 1 = real names, 2 = usernames, 3 = usernames w/ real names on hover

define('SEASON_YEAR', '2014');

//set timezone offset, hours difference between your server's timezone and eastern
define('SERVER_TIMEZONE_OFFSET', 1);

// ***DO NOT EDIT ANYTHING BELOW THIS LINE***
$dbConnected = false;
error_reporting(0);
if (mysql_connect($db_host, $db_user, $db_password)) {
	if (mysql_select_db($database)) {
		$dbConnected = true;
	}
}
error_reporting(E_ALL ^ E_NOTICE);
