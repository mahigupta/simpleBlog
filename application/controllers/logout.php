<?php

class logout extends Base {
	
	
	public function index() {
		$this->session->cookie(SESSION_USERNAME_COOKIE, '', time() - SESSION_TIMEOUT);
		_redirect('/');
	}
}
