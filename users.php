<?php
require('includes/application_top.php');
include('includes/classes/class.formvalidation.php');

if (!$user->is_admin) {
	header('Location: ./');
	exit;
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
					$username = $mysqli->real_escape_string(str_replace(' ', '_', $_POST['username']));
					$sql = "SELECT userName FROM " . DB_PREFIX . "users WHERE userName='".$userName."';";
					$query = $mysqli->query($sql);
					if ($query->num_rows == 0) {
						//form is valid, perform insert
						$salt = substr($crypto->encrypt((uniqid(mt_rand(), true))), 0, 10);
						$secure_password = $crypto->encrypt($salt . $crypto->encrypt($password));
						$sql = "INSERT INTO " . DB_PREFIX . "users (userName, password, salt, firstname, lastname, email, status)
							VALUES ('".$userName."', '".$secure_password."', '".$salt."', '".$firstname."', '".$lastname."', '".$email."', 1);";
						$mysqli->query($sql) or die($mysqli->error);

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
				$sql = "update " . DB_PREFIX . "users ";
				$sql .= "set firstname = '" . $firstname . "', lastname = '" . $lastname . "', email = '" . $email . "', userName = '" . $userName . "' ";
				$sql .= "where userID = " . $userID . ";";
				$mysqli->query($sql) or die('error updating user');

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
		$sql = "delete from " . DB_PREFIX . "users where userID = " . (int)$_GET['id'];
		$mysqli->query($sql) or die('error deleting user: ' . $sql);
		$sql = "delete from " . DB_PREFIX . "picks where userID = " . (int)$_GET['id'];
		$mysqli->query($sql) or die('error deleting user picks: ' . $sql);
		$sql = "delete from " . DB_PREFIX . "picksummary where userID = " . (int)$_GET['id'];
		$mysqli->query($sql) or die('error deleting user picks summary: ' . $sql);
		header('Location: ' . $_SERVER['PHP_SELF']);
		exit;
		break;
	default:
		$userID = $_GET['id'];
		break;
}

include('includes/header.php');

if ($action == 'add' || $action == 'edit') {
	//display add/edit screen
	if ($action == 'edit' && sizeof($_POST) == 0) {
		$sql = "select * from " . DB_PREFIX . "users where userID = " . $userID;
		$query = $mysqli->query($sql);
		if ($query->num_rows > 0) {
			$row = $query->fetch_assoc();
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$email = $row['email'];
			$userName = $row['userName'];
		} else {
			header('Location: ' . $_SERVER['PHP_SELF']);
			exit;
		}
	}
?>
<h1><?php echo ucfirst($action); ?> User</h1>
<?php
	if(isset($display)) {
		echo $display;
	}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=<?php echo $action; ?>_action" method="post" name="addedituser">
<input type="hidden" name="userID" value="<?php echo $userID; ?>" />
<p>First Name:<br />
<input type="text" name="firstname" value="<?php echo $firstname; ?>"></p>

<p>Last Name:<br />
<input type="text" name="lastname" value="<?php echo $lastname; ?>"></p>

<p>Email:<br />
<input type="text" name="email" value="<?php echo $email; ?>" size="30"></p>

<p>User Name:<br />
<input type="text" name="userName" value="<?php echo $userName; ?>"></p>

<?php if ($action == 'add') { ?>
<p>Password:<br />
<input type="password" name="password" value=""></p>

<p>Confirm Password:<br />
<input type="password" name="password2" value=""></p>
<?php } ?>

<p><input type="submit" name="action" value="Submit" class="btn btn-info" /></p>
</form>
<?php
} else {
	//display listing
?>
<h1>Update Users</h1>
<p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=add&week=<?php echo $week; ?>"><img src="images/icons/add_16x16.png" width="16" height="16" alt="Add Game" /></a>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=add">Add User</a></p>
<div class="table-responsive">
<?php
	$sql = "select * from " . DB_PREFIX . "users order by lastname, firstname";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {
		echo '<table class="table table-striped">' . "\n";
		echo '	<tr><th align="left">Username</th><th align="left">Name</th><th align="left">Email</th><th>Status</th><th>&nbsp;</th></tr>' . "\n";
		$i = 0;
		while ($row = $query->fetch_assoc()) {
			$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
			echo '		<tr' . $rowclass . '>' . "\n";
			echo '			<td>' . $row['userName'] . '</td>' . "\n";
			echo '			<td>' . $row['lastname'] . ', ' . $row['firstname'] . '</td>' . "\n";
			echo '			<td>' . $row['email'] . '</td>' . "\n";
			echo '			<td align="center"><img src="images/icons/' . (($row['status']) ? 'check_16x16.png' : 'cross_16x16.png') . '" width="16" height="16" alt="status" /></td>' . "\n";
			echo '			<td><a href="' . $_SERVER['PHP_SELF'] . '?action=edit&id=' . $row['userID'] . '"><img src="images/icons/edit_16x16.png" width="16" height="16" alt="edit" /></a>&nbsp;<a href="javascript:confirmDelete(\'' . $row['userID'] . '\');"><img src="images/icons/delete_16x16.png" width="16" height="16" alt="delete" /></a></td>' . "\n";
			echo '		</tr>' . "\n";
			$i++;
		}
		echo '</table>' . "\n";
	}
}
?>
<script type="text/javascript">
function confirmDelete(id) {
	//confirm delete
	if (confirm('Are you sure you want to delete? This action cannot be undone.')) {
		location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&id=" + id;
	}
}
</script>
<?php
include('includes/footer.php');
