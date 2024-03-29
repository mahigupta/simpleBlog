<?php

class register extends Base {
	
	function __construct() {
		parent::__construct();
		
		include_once APPLICATION_PATH.'/models/user.php';
		$this->user_model = new user_model($this->database, $this->session);
	}
	
	public function index() {
		$this->output->setContentType('application/json');
		$username = $this->input->getPost('username');
		$password = $this->input->getPost('password');
		$email = $this->input->getPost('email');

		$result = $this->user_model->register($username, $password, $email);
		$this->output->setOutput($result);
	}
}