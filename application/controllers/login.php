<?php


class login extends Base {
	
	
	function __construct() {
		parent::__construct();
		
		include_once APPLICATION_PATH.'/models/user.php';
		$this->user_model = new user_model($this->database, $this->session);
	}
	
	public function check() {
		$this->output->setContentType('application/json');
		
		$response = array('ok' => _currently_logged_in());
		
		if ($response['ok']) {
			$response['user'] = $this->session->getCookie(SESSION_USERNAME_COOKIE);
		}
		
		$this->output->setOutput(json_encode($response));
	}
	
	public function authenticate() {
		
		$this->output->setContentType('application/json');
		$username = $this->input->getPost('username');
		$password = $this->input->getPost('password');
		
		$result = $this->user_model->login($username, $password);
		$this->output->setOutput($result);
	}
}

