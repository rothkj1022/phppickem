<?php
class Login{
	function Login(){
	}

	function new_user($user_name, $password, $confirm) {
		global $crypto;
		$confirm = $this->no_injections($confirm);
		$password = $this->no_injections($password);
		$user_name = $this->no_injections($user_name);
		if($confirm === $password && $this->confirm_user($user_name)){
			$this->salt = substr($crypto->encrypt((uniqid(mt_rand(), true))), 0, 10);
			$this->secure_password = $crypto->encrypt($this->salt . $crypto->encrypt($password));
			$this->store_user($user_name);
		}
	}

	function store_user($user_name) {
		global $mysqli;
		$salty = $this->salt;
		$user_password_SQL_raw = "INSERT INTO " . DB_PREFIX . "users SET userName = '".$user_name."', password = '".$this->secure_password."', salt = '".$salty."'";
		$user_password_SQL_result = $mysqli->query($user_password_SQL_raw);
	}

	function validate_password() {
		global $crypto;
		$user_name = $this->no_injections($_POST['username']);
		$password = $this->no_injections($_POST['password']);
		$user = $this->get_user($user_name);
		$passwordEncrypted = $crypto->encrypt($user->salt . $crypto->encrypt($password));
		/*echo 'User input:<br />'.
			'Username: '.$user_name.'<br />'.
			'Password: '.$password.'<br />'.
			'Password (encrypted): '.$passwordEncrypted.'<br /><br />'.
			'Database:</br />'.
			'Username: '.$user->userName.'<br />'.
			'Password: '.$user->password.'<br />'.
			'Salt: '.$user->salt.'<br />'.
			'Password (decrypted): '.$crypto->decrypt($user->salt . $user->password);*/
		if (!empty($user) && !empty($password) && $user->password == $passwordEncrypted) {
			$_SESSION['logged'] = 'yes';
			$_SESSION['loggedInUser'] = $user->userName;
			$_SESSION['is_admin'] = $user->is_admin;
			header('Location: '.SITE_URL);
			exit;
		} else {
			$_SESSION = array();
			header('Location: '.SITE_URL.'login.php?login=failed');
			exit;
		}
	}

	function get_user($user_name) {
		global $mysqli;
		$sql = "SELECT * FROM " . DB_PREFIX . "users WHERE userName = '" . $user_name . "' and status = 1";
		$query = $mysqli->query($sql);
		if ($query->num_rows > 0) {
			$user_info = $query->fetch_object() or die('Mysql error: '.$mysqli->error.', $sql: '.$sql);
			return $user_info;
		}
		$query->free;
		return false;
	}

	function get_user_by_id($user_id) {
		global $mysqli;
		$sql = "SELECT * FROM " . DB_PREFIX . "users WHERE userID = '" . $user_id . "' and status = 1";
		$query = $mysqli->query($sql);
		$user_info = $query->fetch_object();
		$query->free;
		return $user_info;
	}

	function confirm_user($old_user){
		$new_user = $this->get_user($old_user);
		if($new_user == null){
			return true;
		}else{
			return false;
		}
	}

	function no_injections($username){
		$injections = array('/(\n+)/i','/(\r+)/i','/(\t+)/i','/(%0A+)/i','/(%0D+)/i','/(%08+)/i','/(%09+)/i');
		$username = preg_replace($injections,'',$username);
		$username = trim($username);
		return $username;
	}

	function logout(){
		$_SESSION = array();
	}

}
