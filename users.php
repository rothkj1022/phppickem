<?php
require('includes/application_top.php');
include('includes/classes/class.formvalidation.php');
require('includes/classes/crypto.php');
$crypto = new phpFreaksCrypto;

if (!$isAdmin) {
	header('Location: index.php');
}

$action = $_GET['action'];
switch ($action) {
	case 'add_action':
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$userName = $_POST['userName'];
		$userID = (int)$_POST['userID'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		
		$my_form = new validator;
		if($my_form->checkEmail($_POST['email'])) { // check for good mail
			if ($my_form->validate_fields('firstname,lastname,email,userName,password')) { // comma delimited list of the required form fields
				if ($password == $password2) {
					//check that username does not already exist
					$username = mysql_real_escape_string(str_replace(' ', '_', $_POST['username']));
					$sql = "SELECT userName FROM " . $db_prefix . "users WHERE userName='".$userName."';";
					$result = mysql_query($sql);
					if(mysql_numrows($result) == 0){
						//form is valid, perform insert
						$salt = substr($crypto->encrypt((uniqid(mt_rand(), true))), 0, 10);
						$secure_password = $crypto->encrypt($salt . $crypto->encrypt($password));
						$sql = "INSERT INTO " . $db_prefix . "users (userName, password, salt, firstname, lastname, email, status) 
							VALUES ('".$userName."', '".$secure_password."', '".$salt."', '".$firstname."', '".$lastname."', '".$email."', 1);";
						mysql_query($sql) or die(mysql_error());
						
						$display = '<div class="responseOk">User ' . $userName . ' Updated</div><br/>';
					} else {
						$display = '<div class="responseError">User already exists, please try another username.</div><br/>';
					}
				} else {
					$display = '<div class="responseError">Passwords do not match, please try again.</div><br/>';
				}
			} else {
				$display = '<div class="responseError">' . $my_form->error . '</div><br/>';
			}
		} else {
			$display = '<div class="responseError">Invalid email address, please try again.</div><br/>';
		}
		$action = 'add';
		break;
	case 'edit_action':
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$userName = $_POST['userName'];
		$userID = (int)$_POST['userID'];
		
		$my_form = new validator;
		if($my_form->checkEmail($_POST['email'])) { // check for good mail
			if ($my_form->validate_fields('firstname,lastname,email,userName')) { // comma delimited list of the required form fields
				//form is valid, perform update
				$sql = "update " . $db_prefix . "users ";
				$sql .= "set firstname = '" . $firstname . "', lastname = '" . $lastname . "', email = '" . $email . "', userName = '" . $userName . "' ";
				$sql .= "where userID = " . $userID . ";";
				mysql_query($sql) or die('error updating user');
				
				$display = '<div class="responseOk">User ' . $userName . ' Updated</div><br/>';
				/*
				if ($_POST['password'] == $_POST['password2']) {
				} else {
					$display = '<div class="responseError">Passwords do not match, please try again.</div><br/>';
				}*/
			} else {
				$display = '<div class="responseError">' . $my_form->error . '</div><br/>';
			}
		} else {
			$display = '<div class="responseError">Invalid email address, please try again.</div><br/>';
		}
		$action = 'edit';
		break;
	case 'delete':
		$sql = "delete from " . $db_prefix . "users where userID = " . (int)$_GET['id'];
		mysql_query($sql) or die('error deleting user: ' . $sql);
		$sql = "delete from " . $db_prefix . "picks where userID = " . (int)$_GET['id'];
		mysql_query($sql) or die('error deleting user picks: ' . $sql);
		$sql = "delete from " . $db_prefix . "picksummary where userID = " . (int)$_GET['id'];
		mysql_query($sql) or die('error deleting user picks summary: ' . $sql);
		header('Location: ' . $_SERVER['PHP_SELF']);
		break;
	default:
		$userID = $_GET['id'];
		break;
}

include('includes/header.php');

if ($action == 'add' || $action == 'edit') {
	//display add/edit screen
	if ($action == 'edit' && sizeof($_POST) == 0) {
		$sql = "select * from " . $db_prefix . "users where userID = " . $userID;
		$query = mysql_query($sql);
		if (mysql_num_rows($query) > 0) {
			$result = mysql_fetch_array($query);
			$firstname = $result['firstname'];
			$lastname = $result['lastname'];
			$email = $result['email'];
			$userName = $result['userName'];
		} else {
			header('Location: ' . $_SERVER['PHP_SELF']);
		}
	}
?>
<h1><?php echo ucfirst($action); ?> User</h1>
<?php 
	if(isset($display)) {
		echo $display;
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>?action=<?php echo $action; ?>_action" method="post" name="addedituser">
<input type="hidden" name="userID" value="<?php echo $userID; ?>" />	
<table cellpadding="3" cellspacing="0" border="0">
	<tr><td>First Name:</td><td><input type="text" name="firstname" value="<?php echo $firstname; ?>"></td></tr>
	<tr><td>Last Name:</td><td><input type="text" name="lastname" value="<?php echo $lastname; ?>"></td></tr>
	<tr><td>Email:</td><td><input type="text" name="email" value="<?php echo $email; ?>" size="30"></td></tr>
	<tr><td>User Name:</td><td><input type="text" name="userName" value="<?php echo $userName; ?>"></td></tr>
	<?php if ($action == 'add') { ?>
	<tr><td>Password:</td><td><input type="password" name="password" value=""></td></tr>
	<tr><td>Confirm Password:</td><td><input type="password" name="password2" value=""></td></tr>
	<?php } ?>
	<tr><td>&nbsp;</td><td><input type="submit" name="action" value="Submit"></td></tr>
</table>
</form>
<?php
} else {
	//display listing
?>
<h1>Update Users</h1>
<p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=add&week=<?php echo $week; ?>"><img src="images/icons/add_16x16.png" width="16" height="16" alt="Add Game" /></a>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=add">Add User</a></p>
<?php
	$sql = "select * from " . $db_prefix . "users order by lastname, firstname";
	$query = mysql_query($sql);
	if (mysql_num_rows($query) > 0) {
		echo '<table cellpadding="4" cellspacing="0" class="table1">' . "\n";
		echo '	<tr><th align="left">Username</th><th align="left">Name</th><th align="left">Email</th><th>Status</th><th>&nbsp;</th></tr>' . "\n";
		$i = 0;
		while ($result = mysql_fetch_array($query)) {
			$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
			echo '		<tr' . $rowclass . '>' . "\n";
			echo '			<td>' . $result['userName'] . '</td>' . "\n";
			echo '			<td>' . $result['lastname'] . ', ' . $result['firstname'] . '</td>' . "\n";
			echo '			<td>' . $result['email'] . '</td>' . "\n";
			echo '			<td align="center"><img src="images/icons/' . (($result['status']) ? 'check_16x16.png' : 'cross_16x16.png') . '" width="16" height="16" alt="status" /></td>' . "\n";
			echo '			<td><a href="' . $_SERVER['PHP_SELF'] . '?action=edit&id=' . $result['userID'] . '"><img src="images/icons/edit_16x16.png" width="16" height="16" alt="edit" /></a>&nbsp;<a href="javascript:confirmDelete(\'' . $result['userID'] . '\');"><img src="images/icons/delete_16x16.png" width="16" height="16" alt="delete" /></a></td>' . "\n";
			echo '		</tr>' . "\n";
			$i++;
		}
		echo '</table>' . "\n";
	}
}
?>
<script type="text/javascript">
<!--
function confirmDelete(id) {
	//confirm delete
	if (confirm('Are you sure you want to delete? This action cannot be undone.')) {
		location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&id=" + id;
	}
}
//-->
</script>
<?php
include('includes/footer.php');
?>
