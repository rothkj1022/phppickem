<?php
if ($_POST['action'] == 'Add Comment') {
	//if user has not submitted within the last 15 seconds
	$sql = "select * from " . DB_PREFIX . "comments where userID = " . $user->userID . " and subject = '" . $_POST['subject'] . "' and postDateTime > date_add(now(), INTERVAL -15 SECOND)";
	$query = $mysqli->query($sql);
	if ($query->num_rows == 0) {
		$sql = "insert into " . DB_PREFIX . "comments (userID, subject, comment, postDateTime) values (" . $user->userID . ", '" . $_POST['subject'] . "', '" . $_POST['comment'] . "', now());";
		$mysqli->query($sql);
	}
	$query->free;
}
?>
<div id="comments">
	<div class="row">
		<div class="col-xs-6 left">
			<h4 style="margin-bottom: 0px;">Comments/Taunts</h4>
		</div>
		<div class="col-xs-6 right">
			<a href="#addcomment" onclick="document.comments.subject.focus();">add &gt;&gt;</a>
		</div>
	</div>
<?php
$sql = "select * from " . DB_PREFIX . "comments order by postDateTime desc limit 12";
$query = $mysqli->query($sql);
while ($row = $query->fetch_assoc()) {
	$postUser = $login->get_user_by_id($row['userID']);
	switch ($user_names_display) {
		case 1:
			echo '<div style="margin: 10px 0px; border-bottom: 1px solid #ccc;"><b>' . $row['subject'] . '</b> <em>by ' . trim($postUser->firstname . ' ' . $postUser->lastname) . ' on ' . date('n/j @ g:i a', strtotime($row['postDateTime'])) . '</em></div>';
			break;
		case 2:
			echo '<div style="margin: 10px 0px; border-bottom: 1px solid #ccc;"><b>' . $row['subject'] . '</b> <em>by ' . $postUser->userName . ' on ' . date('n/j @ g:i a', strtotime($row['postDateTime'])) . '</em></div>';
			break;
		default: //3
			echo '<div style="margin: 10px 0px; border-bottom: 1px solid #ccc;"><b>' . $row['subject'] . '</b> <em>by <abbr title="' . trim($postUser->firstname . ' ' . $postUser->lastname) . '">' . $postUser->userName . '</abbr> on ' . date('n/j @ g:i a', strtotime($row['postDateTime'])) . '</em></div>';
			break;
	}
	echo '<p>' . nl2br(trim($row['comment'])) . '</p>' . "\n";
}
$query->free;
?>
	<hr />
	<form id="addcomment" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<fieldset>
			<legend>Add Comment:</legend>
			<p>Subject:<br /><input type="text" name="subject" value="" required /></p>
			<p>Comment:<br /><textarea name="comment" required style="width: 100%; height: 100px; max-width: 300px;"></textarea></p>
			<p><input type="submit" name="action" value="Add Comment" /></p>
		</fieldset>
	</form>
</div>