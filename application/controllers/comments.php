<?php

class comments extends Base {
	
	function __construct() {
		parent::__construct();
		
		include_once APPLICATION_PATH.'/models/comment.php';
		$this->comment_model = new comment_model($this->database, $this->session);
	}
	
	public function get() {
		$this->output->setContentType('application/json');
		
		$page = $this->input->getPost('page');
		$limit = $this->input->getPost('limit');
		$blog_id = $this->input->getPost('blog_id');
		
		$result = $this->comment_model->fetchCommentList($blog_id, $page, $limit);
		$this->output->setOutput(ajaxSuccessResponse($result));
	}
	
	
	public function post() {
		$this->output->setContentType('application/json');
		
		$comment = $this->input->getPost('comment');
		$blog_id = $this->input->getPost('blog_id');
		
		$result = $this->comment_model->post($blog_id, $comment);
		
		$this->output->setOutput($result ? ajaxSuccessResponse(array(), "Successfully Posted") : ajaxErrorResponse("Unable to post comment"));
	}
}
