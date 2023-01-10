<?php

class comment_model extends base_model {
	
	public function fetchCommentList($blog_id, $page = 0, $limit = 10) {
		
		$sql = "Select comments.id, users.username, comments.comment,  "
				. "unix_timestamp(comments.last_modified) AS `last_modified` from comments, users where comments.blogid = ? "
				. "and comments.userid = users.id order by comments.last_modified desc limit $page, $limit";
		
		$rows = $this->database->query($sql, array($blog_id));
		
		$results = array();
		
		if ($rows && $rows->num_rows > 0) {
			while($row = $rows->fetch_array(MYSQLI_ASSOC)) {
				$results[] = $row;
			}
		}
		

		return $results;
	}
	
	
	public function post($blog_id, $comment) {
		$user = $this->currentUser();
		$sql = "Insert into comments (blogid, userid, comment) values (?, ?, ?)";
		
		return $this->database->query($sql, array($blog_id, $user['id'], $comment));
	}

	public function get_comment_count($blog_id) {
		$sql = "select count(*) as `count` from comments where blogid = ?";
		$rows = $this->database->query($sql, array($blog_id));
		$count = 0;

		while($row = $rows->fetch_array(MYSQLI_ASSOC)) {
			$count = (int)$row['count'];
		}

		return $count;
	}

}
