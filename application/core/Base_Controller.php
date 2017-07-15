<?php


class Base {
	
	function __construct() {
		// instantiate input , output
		$this->output = new Output();
		$this->input = new Input();
		$this->database = new Database();
		$this->session = new Session();
		
		// if user currently logged in, then update session cookie time to keep their session active
		// reaching this function means, user interacted with UI.
		if (_currently_logged_in()) {
			$this->session->cookie(SESSION_USERNAME_COOKIE, $this->session->getCookie(SESSION_USERNAME_COOKIE), time() + SESSION_TIMEOUT);
		}
	}
}

