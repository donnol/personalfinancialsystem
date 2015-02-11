<?php
	class Card_model extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		public function get_all_card($userId)
		{
			$this->db->where('userId', $userId);
			$query = $this->db->get('t_card');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_card_by_id($userId, $cardId)
		{
			$this->db->where('userId', $userId);
			$this->db->where('cardId', $cardId);
			$query = $this->db->get('t_card');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_card_by_name($userId, $name)
		{
			$this->db->where('userId', $userId);
			$this->db->where('name', $name);
			$query = $this->db->get('t_card');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_card_like_name($userId, $name)
		{
			$this->db->where('userId', $userId);
			$this->db->like('name', $name);
			$query = $this->db->get('t_card');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_card_like_remark($userId, $remark)
		{
			$this->db->where('userId', $userId);
			$this->db->like('remark', $remark);
			$query = $this->db->get('t_card');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_card_like_name_and_remark($userId, $name, $remark)
		{
			$data = array(
				'name'=>$name,
				'remark'=>$remark
			);
			$this->db->where('userId', $userId);
			$this->db->like($data);
			$query = $this->db->get('t_card');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function del($userId, $cardId)
		{
			$this->db->where('userId', $userId);
			$this->db->where('cardId', $cardId);
			$this->db->delete('t_card');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function add($userId, $name, $bank, $card, $money, $remark, $createTime, $modifyTime)
		{
			$data = array(
				'userId'=>$userId,
				'name'=>$name,
				'bank'=>$bank,
				'card'=>$card,
				'money'=>$money,
				'remark'=>$remark,
				'createTime'=>$createTime,
				'modifyTime'=>$modifyTime
			);
			$this->db->insert('t_card', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod($userId, $cardId, $name, $bank, $card, $money, $remark, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'bank'=>$bank,
				'card'=>$card,
				'money'=>$money,
				'remark'=>$remark,
				'modifyTime'=>$modifyTime
			);
			$this->db->where('userId', $userId);
			$this->db->where('cardId', $cardId);
			$this->db->update('t_card', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
}
