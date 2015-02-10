<?php
	class Category_model extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		public function get_all_category()
		{
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_category_by_id($categoryId)
		{
			$this->db->where('categoryId', $categoryId);
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_category_by_name_or_remark($name, $remark)
		{
			$data = array(
				'name'=>$name,
				'remark'=>$remark
			);
			$this->db->like_or($data);
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function del($categoryId)
		{
			$this->db->where('categoryId', $categoryId);
			$this->db->delete('t_category');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function add($name, $remark, $createTime, $modifyTime)
		{
			$data = array(
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
		public function mod($userId, $name, $remark, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'remark'=>$remark,
				'modifyTime'=>$modifyTime
			);
			$this->db->where('userId', $userId);
			$this->db->update('t_category', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
}
