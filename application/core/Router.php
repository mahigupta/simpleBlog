<?php

/* 
 * A Simple router class.
 */

class Router {
	
	private $_params;
	
	// follwing controller and methods do not require 
	// user to logged in currently. add future controller
	// and methods in it.
	private $_controllers_with_no_auth = array(
			'blog' => array('listing', 'view'),
			'login' => array('check', 'authenticate'),
			'register' => array('index'),
			'comments' => array('get')
		);
	
	function __construct() {
		
		$this->_params = array(
			'controller' => '/',
			'method' => ''
		);
	}
	
	private function _parseUrl() {
				
		$query = preg_split('#\?#i', isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/', 2);
		
		$uri = $query[0];
		
		if (isset($query[1])) {
			$_SERVER['QUERY_STRING'] = $query[1];
			parse_str($_SERVER['QUERY_STRING'], $_GET);
		} else {
			$_SERVER['QUERY_STRING'] = '';
			$_GET = array();
		}
		
		if($uri === '/') {
			return;
		}
		
		$parts = explode('/', $uri);
		
		if (count($parts) > 1 && isset($parts[1])) {
			$this->_params['controller'] = $parts[1];
			$this->_params['method'] = isset($parts[2]) ? $parts[2] : 'index';
		}
		
		// if user make post request with content type application/json
		$POST = json_decode(file_get_contents('php://input'), true);
		
		if (!empty($POST)) {
			$_POST = array_merge($POST, $_POST);
		}
		
	}
	
	public function getController() {
		return $this->_params['controller'];
	}
	
	public function getMethod() {
		return $this->_params['method'];
	}
	
	public function init() {
		$this->_parseUrl();
	}
	
	public function is_log_in_require() {
		// check _controllers_with_no_auth array 
		// if current controller called require auth
		
		return (!isset($this->_controllers_with_no_auth[$this->_params['controller']])) ||
				(array_search($this->_params['method'], $this->_controllers_with_no_auth[$this->_params['controller']]) === false)  ;
	}
}

function _process_route() {
	
	$route = new Router();
	
	$route->init();
	
	return $route;
}

// if request sent with HTTP_X_REQUESTED_WITH header then assume
// its a ajax request
function _is_ajax_request() {
	return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// check if user session cookie set or not
function _currently_logged_in() {

	if (isset($_COOKIE[SESSION_COOKIE])) {
		$database = new Database();
		$rows = $database->query("Select id from active_session where session_id = ? ", array($_COOKIE[SESSION_COOKIE]));
		return $rows->num_rows > 0;
	}

	return false;
}

function _redirect($url, $code = 303) {
	header('Location: ' . $url, true, $code);
	die();
}