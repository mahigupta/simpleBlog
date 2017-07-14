<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Session {
	
	 public function cookie($name, $value, $expire = SESSION_TIMEOUT, $path = '/') {
		 return setcookie($name, $value, $expire, $path);
	 }
	 
	 public function createLoginCookie($username) {
		 return $this->cookie(SESSION_USERNAME_COOKIE, $username, time() + SESSION_TIMEOUT);
	 }
	 
	 
	 public function getCookie($name) {
		 return $_COOKIE[$name];
	 }
}