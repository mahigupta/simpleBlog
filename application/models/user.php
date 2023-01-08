<?php

class user_model extends base_model {
	
	
	public function login($username, $password) {
		
		$sql = "Select * from users where username = ?";
		
		$rows = $this->database->query($sql, array($username));
		
		if ($rows->num_rows === 0) {
			return ajaxErrorResponse("Invalid username or password");
		}
		
		$result = array();
		
		while($row = $rows->fetch_array(MYSQLI_ASSOC)) {
			$result = $row;
		}
		
		if (password_verify($password, $result['password'])) {
			$this->session->createLoginCookie($username);
			return ajaxSuccessResponse(array($username), "Successfully logged in");
		}
		
		return ajaxErrorResponse("Invalid username or password");
	}
	
	
	public function register($username, $password, $email) {
		
		if (empty($username) || empty($password) || empty($email)) {
			return ajaxErrorResponse("Require param missing");
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ajaxErrorResponse("Invalid email");
		}
		
		$sql = "Select * from users where (username = ? or email = ?";
		
		$rows = $this->database->query($sql, array($username, $email));
		
		if ($rows->num_rows > 0) {
			return ajaxErrorResponse("username/email already exists");
		}
		
		$hash_pwd = password_hash($password, PASSWORD_BCRYPT);
		
		$sql = "Insert into users (username, password, email) values (?, '$hash_pwd', ?)";
		
		$response = $this->database->query($sql, array($username, $email));
		
		if ($response) {
			$this->session->createLoginCookie($username);
			return ajaxSuccessResponse(array($username), "Successfully registered");
		}
		
		return ajaxErrorResponse("Unable to register");
	}
}