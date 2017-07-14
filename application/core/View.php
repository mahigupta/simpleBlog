<?php



function _load_view($view) {
	return file_exists(APPLICATION_PATH."/view/$view") ? file_get_contents(APPLICATION_PATH."/view/$view") : file_get_contents(APPLICATION_PATH."/view/erros/404.html");
}

