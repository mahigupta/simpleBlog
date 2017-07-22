<?php

class blog_model extends base_model {

	public function fetchBlogList($page = 0, $limit = 10, $user = '') {

		$sql = "Select blog.id, users.username, blog.title, SUBSTRING(blog.content, 1, 200) as content, "
				. "unix_timestamp(blog.last_modified) AS `last_modified` from blog left join users on (blog.userid = users.id)";


		if (!empty($user)) {
			$sql .= " Where blog.userid = $user";
		}

		$sql .= " order by blog.last_modified desc limit $page, $limit";
		$rows = $this->database->query($sql);

		$results = array();

		if ($rows && $rows->num_rows > 0) {
			while($row = $rows->fetch_array(MYSQLI_ASSOC)) {
				$results[] = $row;
			}
		}


		return $results;
	}


	public function fetchBlog($id) {

		$sql = "Select blog.id, users.username, blog.title, blog.content, "
				. "unix_timestamp(blog.last_modified) AS `last_modified` from blog left join users on (blog.userid = users.id) where blog.id = ?";

		$rows = $this->database->query($sql, array($id));

		$results = array();

		if ($rows && $rows->num_rows > 0) {
			while($row = $rows->fetch_array(MYSQLI_ASSOC)) {
				$results[] = $row;
			}
		}

		return $results;
	}

	public function post($title, $content, $id = '') {

		$params = array($title, $content);

		if (empty($id)) {
			$sql = "Insert into blog (title, content, userid) values (?, ?, ?)";
			$user = $this->currentUser();
			array_push($params, $user['id']);
		} else {
			$sql = "update blog set title = ?, content = ? where id = ?";
			array_push($params, $id);
		}


		$return = $this->database->query($sql, $params);

		return $return && empty($id) ? $this->database->insert_id() : $id;
	}

	public function delete($id) {
		$sql = "Delete from blog where id = ?";

		$return = $this->database->query($sql, array($id));

		return $return ? ajaxSuccessResponse(array(), "Deleted successfully") : $return;
	}
}
