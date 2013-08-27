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
		global $db_prefix;
		$salty = $this->salt;
		$user_password_SQL_raw = "INSERT INTO " . $db_prefix . "users SET userName = '".$user_name."', password = '".$this->secure_password."', salt = '".$salty."'";
		$user_password_SQL_result = mysql_query($user_password_SQL_raw);
	}

	function validate_password() {
		global $crypto;
		$user_name = $this->no_injections($_POST['username']);
		$password = $this->no_injections($_POST['password']);
		$user = $this->get_user($user_name);
		if (isset($user) && strlen($password) > 0 && $user->password == $crypto->encrypt($user->salt . $crypto->encrypt($password))) {
			$_SESSION['logged'] = 'yes';
			$_SESSION['loggedInUser'] = $user->userName;
//			$_SESSION['level'] = md5($user->user_level);
			header('Location: index.php?login=success');
		} else {
			$_SESSION = array();
			header('Location: login.php?login=failed');
		}
	}
	
	function get_user($user_name) {
		global $db_prefix;
		$get_user_SQL = "SELECT * FROM " . $db_prefix . "users WHERE userName = '" . $user_name . "' and status = 1";
		$result = mysql_query($get_user_SQL);
		$user_info = mysql_fetch_object($result);
		return $user_info;
	}
	
	function get_user_by_id($user_id) {
		global $db_prefix;
		$get_user_SQL = "SELECT * FROM " . $db_prefix . "users WHERE userID = '" . $user_id . "' and status = 1";
		$result = mysql_query($get_user_SQL);
		$user_info = mysql_fetch_object($result);
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
?>