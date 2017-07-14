


<?php

// define application folder
define('APPLICATION_PATH', __DIR__."/application");

// autoload all required files using autoloader
include_once APPLICATION_PATH.'/autoloader.php';


// initiate route
$ROUTE = _process_route();

$controller = $ROUTE->getController();
$method = $ROUTE->getMethod();

// if controller is root...load initial page
if ($controller === '/') {
	echo _load_view('bootstrap.php');
	die();
}

// if unknown controller requested...return 404
if (!file_exists(APPLICATION_PATH."/controllers/$controller.php")) {
	show_404();
}

// include controller class file
include_once APPLICATION_PATH."/controllers/$controller.php";

// instantiate controller class
$class = new $controller();

// if unknown method called..return 404
if (!method_exists($class, $method)) {
	show_404();
}

// if user currently not logged in and method need user to be logged in
// return 403
if (!_currently_logged_in() && $ROUTE->is_log_in_require()) {
	show_403();
}

// execute class method
$class->$method();

