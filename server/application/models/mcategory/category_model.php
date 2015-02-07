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
		public function get_category_by_name($name)
		{
			$this->db->where('name', $name);
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
			$this-db->delete('t_category');
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
			$this->db->where($data);
			$this->db->insert('t_category');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod($name, $remark, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'remark'=>$remark,
				'modifyTime'=>$modifyTime
			);
			$this->db->where($data);
			$this->db->update('t_category');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
}
