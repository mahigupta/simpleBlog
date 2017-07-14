<?php

Class Input {
	
	private $_input = array();
	
	function __construct() {
		
		foreach($_GET as $key => $val) {
			$this->_input[$key] = $val;
		}

		foreach($_POST as $key => $val) {
			$this->_input[$key] = $val;
		}
	}
	
	public function getPost($key) {
		return $this->_input[$key];
	}
	
}

