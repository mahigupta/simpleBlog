<?php

class blog_model extends base_model
{

    public function fetchBlogList($page = 0, $limit = 10, $user = '')
    {

        $sql = "Select blog.id, users.username, blog.title, SUBSTRING(blog.content, 1, 200) as content, REPLACE(blog.title, ' ', '-') as `slug`, "
            . "unix_timestamp(blog.last_modified) AS `last_modified` from blog left join users on (blog.userid = users.id)";

        if (!empty($user)) {
            $sql .= " Where blog.userid = $user";
        }

        $sql .= " order by blog.last_modified desc limit $page, $limit";
        $rows = $this->database->query($sql);

        $results = array();

        if ($rows && $rows->num_rows > 0) {
            while ($row = $rows->fetch_array(MYSQLI_ASSOC)) {
                $results[] = $row;
            }
        }

        return $results;
    }

    public function fetchBlog($id, $slug)
    {

        $sql = "Select blog.id, users.username, blog.title, blog.content,  blog.slug, "
            . "unix_timestamp(blog.last_modified) AS `last_modified` from blog left join users on (blog.userid = users.id) where blog.id = ? "
            . " and blog.slug = ?";

        $rows = $this->database->query($sql, array($id, $slug));

        $results = array();

        if ($rows && $rows->num_rows > 0) {
            while ($row = $rows->fetch_array(MYSQLI_ASSOC)) {
                $results[] = $row;
            }
        }

        return $results;
    }

    public function post($title, $content, $id = '')
    {
        $user = $this->currentUser();
        $params = array($title, $content);

        if (empty($id)) {
            $sql = "Insert into blog (title, content, userid) values (?, ?, ?)";
            array_push($params, $user['id']);
        } else {
            $sql = "update blog set title = ?, content = ? where id = ? and blog.userid = ?";
            array_push($params, $id, $user['id']);
        }

        $return = $this->database->query($sql, $params);

        return $return && empty($id) ? $this->database->insert_id() : $id;
    }

    public function delete($id)
    {
        $sql = "Delete from blog where id = ? and blog.userid = ?";
        $user = $this->currentUser();

        $return = $this->database->query($sql, array($id, $user['id']));

        return $return ? ajaxSuccessResponse(array(), "Deleted successfully") : $return;
    }
}