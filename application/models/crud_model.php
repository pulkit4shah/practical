<?php

class crud_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function fetchData(){
		return $this->db->get('users')->result_array();
	}
	public function saveEditUser($data){
		$this->db->where('id',$data['id']);
		return $this->db->update('users',$data);
	}
	public function addRegister($data){
		$new_arr = array(
			'first_name'=>$data['fname'],
			'last_name'=>$data['lname'],
			'email'=>$data['email'],
			'gender'=>$data['gender'],
			'sports'=>$data['favorite'][0],
			'city'=>$data['city'],
			'country'=>'',
			'password'=>md5($data['password']),
		);
		return $this->db->insert('users',$new_arr);
	}
}


 ?>