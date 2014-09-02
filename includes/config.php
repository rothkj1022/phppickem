<?php
//modify vars below
// Database
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'g5W!jMt@#t2W');
define('DB_DATABASE', 'nflpickem');
define('DB_PREFIX', 'nflp_');

define('SITE_URL', 'http://localhost/personal/applications/phppickem/');
define('ALLOW_SIGNUP', true);
define('SHOW_SIGNUP_LINK', true);
define('USER_NAMES_DISPLAY', 3); // 1 = real names, 2 = usernames, 3 = usernames w/ real names on hover

define('SEASON_YEAR', '2014');

//set timezone offset, hours difference between your server's timezone and eastern
define('SERVER_TIMEZONE_OFFSET', 1);

// ***DO NOT EDIT ANYTHING BELOW THIS LINE***
error_reporting(E_ALL ^ E_NOTICE);
