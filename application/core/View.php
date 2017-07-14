<?php

/*
 * return view template
 * if cant find view file...return 404.html template
 */

function _load_view($view) {
	return file_exists(APPLICATION_PATH."/view/$view") ? file_get_contents(APPLICATION_PATH."/view/$view") : file_get_contents(APPLICATION_PATH."/view/erros/404.html");
}

