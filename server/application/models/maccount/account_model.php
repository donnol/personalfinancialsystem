<?php
	class Account_model extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		public function get_all_account()
		{
			$query = $this->db->get('t_account');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_account_by_id($accountId)
		{
			$this->db->where('accountId', $accountId);
			$query = $this->db->get('t_account');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_account_by_name($name)
		{
			$this->db->where('name', $name);
			$query = $this->db->get('t_account');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function del($accountId)
		{
			$this->db->where('accountId', $accountId);
			$this->db->delete('t_account');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function add($name, $money, $type, $categoryId, $typeId, $remark, $createTime, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'money'=>$money,
				'type'=>$type,
				'categoryId'=>$categoryId,
				'typeId'=>$typeId,
				'remark'=>$remark,
				'createTime'=>$createTime,
				'modifyTime'=>$modifyTime
			);
			$this->db->where($data);
			$this->db->insert('t_account');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod($name, $money, $type, $categoryId, $typeId, $remark, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'money'=>$money,
				'type'=>$type,
				'categoryId'=>$categoryId,
				'typeId'=>$typeId,
				'remark'=>$remark,
				'modifyTime'=>$modifyTime
			);
			$this->db->where($data);
			$this->db->update('t_account');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
}
