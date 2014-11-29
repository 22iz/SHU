<?php
date_default_timezone_set('PRC');
class th_usr_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function load_token(){
		$result=$this->db->get('dd_shudong_v2');
		foreach ($result->result_array() as $row) {
		 	$token = $row['token'];
		} 
		 return $token;
	}
	function post_insert($data=null){
		print_r($data);
		$this->db->insert('th_post',$data);
	}
}