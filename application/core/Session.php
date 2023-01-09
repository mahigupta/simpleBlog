<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Session {

	public function __construct()
    {
        $this->database = new Database();
    }
	
	 public function cookie($name, $value, $expire = SESSION_TIMEOUT, $path = '/') {
		return setcookie($name, $value, $expire, $path);
	 }

	 private function session_hour_timeout() {
		return SESSION_TIMEOUT / 3600 ;
	 }
	 
	 public function createLoginCookie($userid) {
		$session_id = $this->db_create($userid);

		if (!$session_id) {
			return false;
		}
		return $this->cookie(SESSION_COOKIE, $session_id, time() + SESSION_TIMEOUT);
	 }

	 public function extend_session() {
		$this->db_update($this->getCookie(SESSION_COOKIE));
		$this->cookie(SESSION_COOKIE, $this->getCookie(SESSION_COOKIE), time() + SESSION_TIMEOUT);
	 }
	 
	 
	 public function getCookie($name) {
		return $_COOKIE[$name];
	 }

	 public function db_create($user_id) {
        $sql = "Select * from users where id = ?";
		$rows = $this->database->query($sql, array($user_id));

        if ($rows->num_rows === 0) {
			return false;
		}

        $user = array();
		
		while($row = $rows->fetch_array(MYSQLI_ASSOC)) {
			$user = $row;
		}

        $mix = array($user_id, $user['username'], $user['email'], time());

        $session_id = hash('sha256', implode("|", $mix));

        $hours = $this->session_hour_timeout() ;

        $sql = "Insert into active_session (userid, session_id, expired_at) values (?, ?, DATE_ADD(NOW(), INTERVAL $hours HOUR))";
        
        $this->database->query($sql, array($user_id, $session_id));

        return $session_id;
    }

    public function db_get($session_id) {
        $rows = $this->database->query("Select * from active_session where session_id = ? ", array($session_id));
		
        $result = array();
		
		while($row = $rows->fetch_array(MYSQLI_ASSOC)) {
			$result = $row;
		}

        return $result;
    }

	public function current_user_record() {
		$rows = $this->database->query("Select users.id, users.username, users.email from users  left join active_session on (active_session.userid = users.id) where active_session.session_id = ? ", array($this->getCookie(SESSION_COOKIE)));
		
		$result = array();
		
		if ($rows && $rows->num_rows > 0) {
			while($row = $rows->fetch_array(MYSQLI_ASSOC)) {
				$result = $row;
			}
		}

		return $result;
	}

    public function db_update($session_id) {
		$hours = $this->session_hour_timeout() ;
        $sql = "update active_session set expired_at = DATE_ADD(NOW(), INTERVAL $hours HOUR) where session_id = ?";
        return $this->database->query($sql, array($session_id));
    }

    public function db_delete($session_id){
        $sql = "Delete from active_session where session_id = ? ";
        return $this->database->query($sql, array($session_id));
    }
}