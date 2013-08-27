<?php
require('includes/application_top.php');

if (!$isAdmin) {
	header('Location: index.php');
}

$email_template_key = $_POST['email_template_key'];
if ($_POST['action'] == 'Update') {
	$sql = "update " . $db_prefix . "email_templates ";
	$sql .= "set subject = '" . mysql_real_escape_string($_POST['subject']) . "', message = '" . mysql_real_escape_string($_POST['message']) . "' ";
	$sql .= "where email_template_key = '" . $email_template_key . "';";
	mysql_query($sql);
	header('Location: email_templates.php');
	exit;
} else if (!empty($email_template_key)) {
	$sql = "select * from " . $db_prefix . "email_templates where email_template_key = '" . $email_template_key . "'";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	$subject = $result['subject'];
	$message = $result['message'];
}

include('includes/header.php');
?>
<script language="JavaScript" type="text/javascript" src="js/cbrte/html2xhtml.js"></script>
<script language="JavaScript" type="text/javascript" src="js/cbrte/richtext_compressed.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function submitForm() {
	//make sure hidden and iframe values are in sync for all rtes before submitting form
	updateRTEs();
	
	return true;
}

//Usage: initRTE(imagesPath, includesPath, cssFile, genXHTML, encHTML)
initRTE("js/cbrte/images/", "js/cbrte/", "", true);
//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
<h1>Email Templates</h1>
<form name="emailtemplate" action="email_templates.php" method="post" onsubmit="return submitForm();">
<table cellpadding="4" cellspacing="0">
	<tr valign="top">
		<td><b>Select Email Template:</b></td>
		<td>
			<select name="email_template_key">
				<option value=""></option>
				<?php
				$sql = "select * from " . $db_prefix . "email_templates";
				$query = mysql_query($sql);
				while ($result = mysql_fetch_array($query)) {
					echo '<option value="' . $result['email_template_key'] . '"' . (($email_template_key == $result['email_template_key']) ? ' selected="selected"' : '') . '>' . $result['email_template_title'] . '</option>' . "\n";
				}
				?>
			</select>&nbsp;<input type="submit" value="Select" />
		</td>
	</tr>
	<tr valign="top">
		<td><b>Subject:</b></td>
		<td><input type="text" name="subject" value="<?php echo $subject; ?>" size="40"></td>
	</tr>
	<tr valign="top">
		<td><b>Message:</b><br /><br />
			Available Variables:<br />
			<ul>
				<li>{week}</li>
				<li>{player}</li>
				<li>{first_game}</li>
				<li>{site_url}</li>
				<li>{rules_url}</li>
				<li>{winners}</li>
				<li>{previousWeek}</li>
				<li>{winningScore}</li>
				<li>{possibleScore}</li>
				<li>{currentLeaders}</li>
				<li>{bestPickRatios}</li>
			</ul>
		</td>
		<td>
			<script language="JavaScript" type="text/javascript">
			<!--
			//build new richTextEditor
			var message = new richTextEditor('message');
			<?php
			//format content for preloading
			if (!empty($message)) {
				$message = rteSafe($message);
			}
			?>
			message.html = '<?php echo $message; ?>';
			//rte1.toggleSrc = false;
			message.build();
			//-->
			</script>
		</td>
	</tr>
	<tr><td>&nbsp;</td><td><input name="action" type="submit" value="Update"<?php echo ((empty($email_template_key)) ? 'disabled="disabled"' : ''); ?> /></td></tr>
</table>
</form>

<?php
include('includes/footer.php');
?>