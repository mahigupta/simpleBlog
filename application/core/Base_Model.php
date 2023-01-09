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
		
		return $this->session->current_user_record();
	}
}