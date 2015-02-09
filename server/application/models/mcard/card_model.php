<?php
	class Card_model extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		public function get_all_card()
		{
			$query = $this->db->get('t_card');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_card_by_id($cardId)
		{
			$this->db->where('cardId', $cardId);
			$query = $this->db->get('t_card');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_card_by_name($name)
		{
			$this->db->where('name', $name);
			$query = $this->db->get('t_card');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function del($cardId)
		{
			$this->db->where('cardId', $cardId);
			$this->db->delete('t_card');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function add($name, $bank, $remark, $createTime, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'bank'=>$bank,
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
		public function mod($userId, $name, $bank, $remark, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'bank'=>$bank,
				'remark'=>$remark,
				'modifyTime'=>$modifyTime
			);
			$this->db->where('userId', $userId);
			$this->db->update('t_card', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
}
