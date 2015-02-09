<?php
class Cookie_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcookie/cookie_model', 'cookie_model');
	}
	public function get_cookie()
	{
		$data = $this->cookie_model->get_cookie();
		return $data;
	}
	public function get_cookie_by_id($cookieId)
	{
		$data = $this->cookie_model->get_cookie_by_id($cookieId);
		return $data;
	}
	public function add_cookie($cookieId, $ipAddress, $userAgent, $lastActivity, $userData)
	{
		$data = $this->cookie_model->add_cookie($cookieId, $ipAddress, $userAgent, $lastActivity, $userData);
		return $data;
	}
	public function del_cookie($cookieId)
	{
		$data = $this->cookie_model->del_cookie($cookieId);
		return $data;
	}
}
