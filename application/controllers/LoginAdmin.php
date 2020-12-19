<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginAdmin extends CI_Controller {

    function __construct() {
        parent::__construct();
       $this->load->model('Login_model');
		$this->load->database();
		$this->load->library('session');
		
		
    }
    
	function index(){
		if($_SESSION['logged_in'] != ""){
				redirect('home');
		}
		$data = array();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
           // $sess_array = array();
           // $ses= "User Email Or Password Wrong";
           // $this->session->set_flashdata('notlogin',$ses);
          //  $data["error"] = $this->session->flashdata('notlogin');
			
			
			$this->load->view('login_view');
			
           // die();
           // redirect('login', 'refresh');
        } else {
            //Go to private area
            $this->load->view('user/header');
			$this->load->view('user/registration');
			$this->load->view('user/footer');
        }
	}
	
	function verify_login(){
		$this->load->library('form_validation');
//print_r($_POST); //die();
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $sess_array = array();
            $ses= "User Email Or Password Wrong";
            $this->session->set_flashdata('notlogin',$ses);
            $data["error"] = $this->session->flashdata('notlogin');
			//redirect('login', 'refresh');
			
			$this->load->view('login_view');
			
           // die();
			
           // redirect('login', 'refresh');
        } else {
            //Go to private area
			redirect('Home', 'refresh');
//			$this->load->view('user/header');
//			$this->load->view('user/registration');
//			$this->load->view('user/footer');
           
        }
	}
	
function check_database($password) {
       // $this->load->library('Session');
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('email');

        //query the database
        $result = $this->Login_model->checkloginAdmin($username, $password);
  //print_R($result) ; //DIE();
        if ($result != "") {
			$result = $this->Login_model->checklogin1Admin($username, $password);
			//print_r($result);
			if($result != ""){
//              die(manoj);
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'id' => $row->id,
                    'UserEmail' => $row->AdminEmail,
                    'UserFName' => $row->AdminName,
					'profile_pic'=>$row->profile_pic,
                    'logged_in' => TRUE
                );
				//print_r($sess_array);  die();
				
                $this->session->set_userdata('logged_in', $sess_array);
				//print_r($_SESSION['logged_in']); die();
            }
//			$this->load->view('user/footer');
				 //print_r($_SESSION, TRUE); die();
				//print_r($this->session->set_userdata($sess_array)); die();
            return TRUE;
			}else{

            $this->form_validation->set_message('check_database', 'Please Activate Your Account');
            return false;
        }	
        } else {

            $this->form_validation->set_message('check_database', 'Invalid Email or password');
            return false;
        }
    }
    
    function logout(){
    	$this->session->unset_userdata('logged_in');
    	redirect('loginAdmin');
    }
	
	
	function l(){
		$result = $this->Login_model->d();
	}
}
?>