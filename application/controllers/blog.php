<?php

class blog extends Base {
	
	function __construct() {
		parent::__construct();
		
		include_once APPLICATION_PATH.'/models/blog.php';
		$this->blog_model = new blog_model($this->database, $this->session);
	}
	public function listing() {
		$this->output->setContentType('application/json');
		
		$page = $this->input->getPost('page');
		$limit = $this->input->getPost('limit');
		
		$result = $this->blog_model->fetchBlogList($page, $limit);
		$this->output->setOutput(ajaxSuccessResponse($result));
	}
	
	
	public function myBlogs() {
		$this->output->setContentType('application/json');
		
		$page = $this->input->getPost('page');
		$limit = $this->input->getPost('limit');
		$user = $this->blog_model->currentUser();
		
		$result = $this->blog_model->fetchBlogList($page, $limit, $user['id']);
		$this->output->setOutput(ajaxSuccessResponse($result));
	}
	
	public function view() {
		$this->output->setContentType('application/json');
		
		$id = $this->input->getPost('id');
		
		$result = $this->blog_model->fetchBlog($id);
		
		if (!empty($result)) {
			$this->output->setOutput(ajaxSuccessResponse($result));
		} else {
			show_404();
		}
		
	}
	
	
	public function post() {
		$this->output->setContentType('application/json');
		
		$title = $this->input->getPost('title');
		$content = $this->input->getPost('content');
		$id = $this->input->getPost('id');
		
		$result = $this->blog_model->post($title, $content, $id);
		$this->output->setOutput(ajaxSuccessResponse($result));
	}
	
	public function delete() {
		$this->output->setContentType('application/json');
		
		$id = $this->input->getPost('id');
		
		$result = $this->blog_model->delete($id);
		$this->output->setOutput($result);
	}
	
	
}

