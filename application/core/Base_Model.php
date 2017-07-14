<?php

class base_model {
	
	function __construct(Database $database, Session $session) {
		$this->database = $database;
		$this->session = $session;
	}
	
	
	function currentUser() {
		
		if (!_currently_logged_in()) {
			show_403();
		}
		
		$rows = $this->database->query("Select * from users where username = ? ", array($this->session->getCookie(SESSION_USERNAME_COOKIE)));
		
		$result = array();
		
		if ($rows && $rows->num_rows > 0) {
			while($row = $rows->fetch_array(MYSQLI_ASSOC)) {
				$result = $row;
			}
		}
		

		return $result;
	}
}

