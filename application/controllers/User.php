<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
       $this->load->model('user_model');
		$this->load->library('Session');
		$this->load->database();
    }
    
	function index(){
//		if(isset($_SESSION['logged_in']) == ""){
//    	redirect('login');
//		}
	if($_SESSION['logged_in'] == ""){
		redirect('LoginAdmin');
	}else{
		//redirect('Product');
	}	//print_r($_SESSION['logged_in']);
//		print_r($_POST);
		$data["logged_in"] = $_SESSION['logged_in']; 
		$data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
		$userid = $data["logged_in"]["id"];
		$this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
			if($this->input->post('chng_pwd')){
				$this->form_validation->set_rules('passwordn', 'Password', 'trim|required');
			}
        if ($this->form_validation->run() == FALSE) {
		$this->load->view('header',$data);
		$this->load->view('nav',$data);
		$this->load->view('edit_user',$data);
		$this->load->view('footer');
		}else{
			$username = $this->input->post("username");
			$email = $this->input->post("email");
			//print_r($_POST);
			//print_r($_FILES["userfile"]["name"]);
			if($_FILES["userfile"]["name"]){
				$config['upload_path'] = './upload/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['file_name'] = time().$_FILES["userfile"]["name"];
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload())
				{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('header');
			$this->load->view('nav',$data);
			$this->load->view('edit_user', $error);
			$this->load->view('footer');
				}else {
					$data = array('upload_data' => $this->upload->data());
					$file_name = $data["upload_data"]["file_name"];
				}
			}
			if(isset($file_name)) {
				$data1 = array(
					"AdminName" => $username,
					"AdminEmail" => $email,
 					"profile_pic" => $file_name
				);
			}else {
				$data1 = array(
					"AdminName" => $username,
					"AdminEmail" => $email,
 					
				);
			}
			
				if($this->input->post('chng_pwd')){
					$data1['AdminPassword']=$this->input->post('passwordn');
				}
		
			$this->user_model->update_user($data1,$userid);
			$data["logged_in"] = $_SESSION['logged_in'];
			$data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
		$this->load->view('header');
		$this->load->view('nav',$data);
		$this->load->view('edit_user',$data);
		$this->load->view('footer');
		
	}
	}
	
	
}
?>        

