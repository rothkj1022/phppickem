<?php

// dtjr
include('includes/column_countdown.php');

include('includes/column_stats.php');
// dtjr

if (COMMENTS_SYSTEM !== 'disabled') {
	echo '		<p class="bg-info"><b>Taunt your friends!</b><br /><a href="'.$_SERVER['REQUEST_URI'].'#comments">Post a comment</a> now!</p>'."\n";
}

//include('includes/comments.php');

?>
