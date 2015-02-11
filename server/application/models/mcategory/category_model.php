<?php
	class Category_model extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		public function get_all_category($userId)
		{
			$this->db->where('userId', $userId);
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_category_by_id($userId, $categoryId)
		{
			$this->db->where('userId', $userId);
			$this->db->where('categoryId', $categoryId);
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_category_by_name($userId, $name)
		{
			$this->db->where('userId', $userId);
			$this->db->where('name', $name);
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_category_like_name($userId, $name)
		{
			$this->db->where('userId', $userId);
			$this->db->like('name', $name);
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_category_by_name_and_remark($userId,$name, $remark)
		{
			$data = array(
				'name'=>$name,
				'remark'=>$remark
			);
			$this->db->where('userId', $userId);
			$this->db->like($data);
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_category_by_name_or_remark($userId, $name, $remark)
		{
			$this->db->where('userId', $userId);
			$this->db->like('name', $name);
			$this->db->or_like('remark',$remark);
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_category_like_remark($userId, $remark)
		{
			$this->db->where('userId', $userId);
			$this->db->like('remark', $remark);
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function del($userId, $categoryId)
		{
			$this->db->where('userId', $userId);
			$this->db->where('categoryId', $categoryId);
			$this->db->delete('t_category');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function add($userId, $name, $remark, $createTime, $modifyTime)
		{
			$data = array(
				'userId'=>$userId,
				'name'=>$name,
				'remark'=>$remark,
				'createTime'=>$createTime,
				'modifyTime'=>$modifyTime
			);
			$this->db->insert('t_category', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod($categoryId, $userId, $name, $remark, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'remark'=>$remark,
				'modifyTime'=>$modifyTime
			);
			$this->db->where('categoryId', $categoryId);
			$this->db->where('userId', $userId);
			$this->db->update('t_category', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
}
