<?php
//modify vars below
// Database
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'dbpass');
define('DB_DATABASE', 'nflpickem');
define('DB_PREFIX', 'nflp_');

define('SITE_URL', 'http://localhost/personal/applications/phppickem/');
define('ALLOW_SIGNUP', true);
define('SHOW_SIGNUP_LINK', true);
define('USER_NAMES_DISPLAY', 3); // 1 = real names, 2 = usernames, 3 = usernames w/ real names on hover
define('COMMENTS_SYSTEM', 'basic'); // basic, disqus, or disabled
define('DISQUS_SHORTNAME', ''); // only needed if using Disqus for comments

define('SEASON_YEAR', '2015');

//set timezone offset, hours difference between your server's timezone and eastern
define('SERVER_TIMEZONE_OFFSET', 0);

//define a batch update "key" that a cronjob can pass to update scores automatically
//can be anything you want, as long as it can be sent as a get parameter on the URL
//NOTE: make your life easier and just use alpha-numerics w/out any special chars...
//NOTE: THE PAGE NAME IS CASE SENSEITVE TO BYPASS LOG-IN, IF THE CASE NOT MATCH, IT WILL REDIRECT TO LOGIN W/OUT UPDATING SCORES!
//example:
// curl -O 'http://www.yourdomain.com/getHtmlScores.php?BATCH_SCORE_UPDATE_KEY=yourRandomDefinedValueHere'
// wget 'http://www.yourdomain.com/getHtmlScores.php?BATCH_SCORE_UPDATE_KEY=yourRandomDefinedValueHere'
define('BATCH_SCORE_UPDATE_KEY', 'f5fe57a1950f903a420e6c43cc266f62');
//enable or disable batch updates here
define('BATCH_SCORE_UPDATE_ENABLED', true);

// ***DO NOT EDIT ANYTHING BELOW THIS LINE***
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
