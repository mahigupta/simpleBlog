<?php


class Output {
	
	private $_headers = array();
	
	public function setContentType($mime = 'application/json') {
		
		 if (!empty($mime)) {
			$header = 'Content-Type: '.$mime;
			$this->headers[] = array($header, TRUE);
		 }
	}
	
	public function setOutput($output) {
		
		if (count($this->headers) > 0) {
			foreach ($this->headers as $header) {
				@header($header[0], $header[1]);
			}
		}
		
		echo $output;
		die();
	}
}


function show_404() {
	header('HTTP/1.0 404 Not Found', true, 404);
	echo _is_ajax_request() ? ajaxErrorResponse('404 Not Found') : _load_view('/erros/404.html');
	die();
}

function show_403() {
	header('HTTP/1.0 403 Unauthorized', true, 403);
	echo _is_ajax_request() ? ajaxErrorResponse('403 Unauthorized Access') : _load_view('/erros/403.html');
	die();
}

function ajaxSuccessResponse($data = array(), $message = '') {
	$response =  array(
		'status' => 'success',
		'data' => $data
	);
	
	if (!empty($message)) {
		$response['message'] = $message;
	}
	
	return json_encode($response);
}


function ajaxErrorResponse($message) {
	
	return json_encode(array(
		'status' => 'error',
		'message' => $message
	));
	
}
