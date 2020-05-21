<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("crud_model",'crud');
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
	}

	public function index()
	{	
		$this->load->view('crud_view');
	}
	public function fetch_user(){

		$task_data = $this->db->order_by("id", "asc")->get('task')->result_array();
		$f_array = array();
		foreach ($task_data as $value) {
			$exp_data = explode(',',$value['user_id'] );
			$user_name='';
			$user_names = '';
			foreach ($exp_data as $values) {
				$user_name = $this->db->get_where('users',array('id'=>$values))->row_array();	
				$user_names .= $user_name['name'].',';
			}
			$f_array[] = array(
				'id'=>$value['id'],
				'task_name'=> $value['task_name'],
				'users'=> rtrim($user_names,',') 
			);
		}
		
		$data["draw"] = "1";
	    $data["recordsTotal"] = "0";
		$data["recordsFiltered"] = "0";
		$data['data'] = $f_array;

		echo json_encode($data);
	}

	public function addTask(){
		//echo "herereeee";exit;
		$data = $this->input->post();
		$this->db->insert('task',$data);
		echo '1';
	}

	public function getEditUser(){
		//$id = $this->input->post('id');
		$userData = $this->db->get('users')->result_array();
		echo json_encode($userData);
	}

	public function saveUserToTask(){
		$data = $this->input->post();
		$this->db->where('id',$data['taskid']);
		$this->db->update('task',array('user_id'=>$data['userid']));
	}
	public function deleteTask(){
		$id = $this->input->post('id');
		$result = $this->db->delete('task', array('id' => $id)); 
		echo $result;
	}
}
