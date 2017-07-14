<?php

class Database {
	
	private $_config, $_connection = null;
	
	function __construct() {
		$this->_config = json_decode(file_get_contents(APPLICATION_PATH."/database/mysql.json"));
		$this->_connect();
	}
	
	private function _connect() {
		$this->_connection = new mysqli($this->_config->host, $this->_config->user, 
				$this->_config->password, DATABASE_NAME, $this->_config->port);
		
		if ($this->_connection->connect_error) {
			echo ajaxErrorResponse('Connect Error (' . $this->_connection->connect_errno . ') '. $this->_connection->connect_error, "DB_ERROR");
			die();
		}
	}
	
	public function query($query, $param = array()) {
		
		$sql = $this->_paramatrized($query, $param);
		
		return $this->_connection->query($sql);
	}
	
	public function insert_id() {
		return $this->_connection->insert_id;
	}
	
	
	private function _paramatrized($query, $param = array()) {
		$breakQuery = explode('?', $query);
		
		if (count($param) > 0) {
			
			foreach($breakQuery as $index => &$q) {
				if (!empty($q) && !empty($param[$index])) {
					$p = $this->_connection->escape_string($param[$index]);
					$q .=  "'$p'";
				}
				
			}	
		}
		
		return implode('', $breakQuery);
	}
}

