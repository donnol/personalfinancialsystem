<?php
	class Category_model extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
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
		public function search($userId, $where, $limit)
		{
			$this->db->where('userId', $userId);
			foreach($where as $key=>$value)
			{
				$this->db->like($key, $value);
			}
			$num = $this->db->count_all('t_category');

			$this->db->where('userId', $userId);
			foreach($where as $key=>$value)
			{
				$this->db->like($key, $value);
			}
			
			$index = $limit['pageIndex'];
			$size = $limit['pageSize'];
			
			if( $size != '' )
			{
			$limit_size = $num - $index;
			if( $limit_size <= $size )
				$size = $limit_size;

			$this->db->limit($size, $index);
			}
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
		public function add($userId, $name, $remark)
		{
			$data = array(
				'userId'=>$userId,
				'name'=>$name,
				'remark'=>$remark
			);
			$this->db->insert('t_category', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod($categoryId, $userId, $name, $remark)
		{
			$data = array(
				'name'=>$name,
				'remark'=>$remark
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
