<?php

class logout extends Base {

	public function index() {
		$this->session->db_delete($this->session->getCookie(SESSION_COOKIE));
		$this->session->cookie(SESSION_COOKIE, '', time() - SESSION_TIMEOUT);
		_redirect('/');
	}
}
