<?php
if ($_POST['action'] == 'Add Comment') {
	//if user has not submitted within the last minute
	$sql = "select * from " . DB_PREFIX . "comments where userID = " . $user->userID . " and subject = '" . $_POST['subject'] . "' and postDateTime > date_add(now(), INTERVAL -1 MINUTE)";
	$query = $mysqli->query($sql);
	if ($query->num_rows == 0) {
		$sql = "insert into " . DB_PREFIX . "comments (userID, subject, comment, postDateTime) values (" . $user->userID . ", '" . $_POST['subject'] . "', '" . $_POST['comment'] . "', now());";
		$mysqli->query($sql);
	}
	$query->free;
}
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr><td><h4 style="margin-bottom: 0px;">Comments/Taunts</h4></td><td align="right"><a href="#addcomment">add &gt;&gt;</a></td></tr>
</table>
<?php
$sql = "select * from " . DB_PREFIX . "comments order by postDateTime desc limit 12";
$query = $mysqli->query($sql);
while ($row = $query->fetch_assoc()) {
	$postUser = $login->get_user_by_id($row['userID']);
	switch ($user_names_display) {
		case 1:
			echo '<div style="margin: 10px 0px; border-bottom: 1px solid #ccc;" /><b>' . $row['subject'] . '</b> <em>by ' . trim($postUser->firstname . ' ' . $postUser->lastname) . '</b> on ' . date('n/j @ g:i a', strtotime($row['postDateTime'])) . '</em></div>';
			break;
		case 2:
			echo '<div style="margin: 10px 0px; border-bottom: 1px solid #ccc;" /><b>' . $row['subject'] . '</b> <em>by ' . $postUser->userName . '</b> on ' . date('n/j @ g:i a', strtotime($row['postDateTime'])) . '</em></div>';
			break;
		default: //3
			echo '<div style="margin: 10px 0px; border-bottom: 1px solid #ccc;" /><b>' . $row['subject'] . '</b> <em>by <abbrev title="' . trim($postUser->firstname . ' ' . $postUser->lastname) . '">' . $postUser->userName . '</abbrev></b> on ' . date('n/j @ g:i a', strtotime($row['postDateTime'])) . '</em></div>';
			break;
	}
	echo '<p>' . nl2br(trim($row['comment'])) . '</p>' . "\n";
}
$query->free;
?>
<hr />
<script type="text/javascript">
function checkForm() {
	var f = document.comments;
	if (f.subject.value.length == 0) {
		alert("Please enter a subject.");
		return false;
	}
	if (f.comment.value.length == 0) {
		alert("Please enter a comment.");
		return false;
	}
	return true;
}
</script>
<a name="addcomment"></a>
<form name="comments" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return checkForm();">
<fieldset>
	<legend>Add Comment:</legend>
	<div>Subject:<br /><input type="text" name="subject" value="" /><br />
	Comment:<br /><textarea name="comment" cols="30" rows="4"></textarea><br />
	<input type="submit" name="action" value="Add Comment" /></div>
</fieldset>
</form>
