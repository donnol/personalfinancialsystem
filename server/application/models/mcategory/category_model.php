<?php
	class Category_model extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		public function get_category_by_name($where)
		{
			foreach($where as $key=>$value)
			{
				$this->db->where($key, $value);
			}
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_category_by_id($where)
		{
			foreach($where as $key=>$value)
			{
				$this->db->where($key, $value);
			}
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function search( $where, $limit)
		{
			foreach($where as $key=>$value)
			{
				if( $key == 'userId' )
				{
					$this->db->where($key, $value);
				}
				elseif( $key == 'categoryId' )
				{
					$this->db->where($key, $value);
				}
				else
				{
					$this->db->like($key, $value);
				}
			}
			$this->db->from('t_category');
			$num = $this->db->count_all_results();

			foreach($where as $key=>$value)
			{
				if( $key == 'userId' )
				{
					$this->db->where($key, $value);
				}
				elseif( $key == 'categoryId' )
				{
					$this->db->where($key, $value);
				}
				else
				{
					$this->db->like($key, $value);
				}
			}
			
			if( isset($limit['pageIndex']) && isset($limit['pageSize']))
			{
				if( $limit['pageSize'] != FALSE )
					$this->db->limit($limit['pageSize'], $limit['pageIndex']);
			}
			$query = $this->db->get('t_category');
			$data = $query->result_array();
			$result = array(
				'count'=>$num,
				'data'=>$data
			);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$result
			);
		}
		public function del($where)
		{
			foreach($where as $key=>$value)
			{
				$this->db->where($key, $value);
			}
			$this->db->delete('t_category');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function add($data)
		{
			$this->db->insert('t_category', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod($where, $data)
		{
			foreach($where as $key=>$value)
			{
				$this->db->where($key, $value);
			}
			$this->db->update('t_category', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
}
