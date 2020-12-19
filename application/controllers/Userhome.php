<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userhome extends CI_Controller {
	
	function __construct() {
            parent::__construct();
            $this->load->model('login_model');
            $this->load->database();
            $this->load->library('session');
            $this->load->model('master_model');
            $this->load->model('user_model');
            $this->load->model('home_model');
        }
	public function index()
	{
        if($_SESSION['logged_in'] == ""){
            redirect('LoginAdmin');
	}
        $data["logged_in"] = $_SESSION['logged_in'];
		$data["totaladmin"] = $this->home_model->getadmin();
            $this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
            $this->load->view('Admin/home_view',$data);
            $this->load->view('Admin/footer');
	}
        function profile() {
        if($_SESSION['logged_in'] == ""){
            redirect('login');
        }
        $data["logged_in"] = $_SESSION['logged_in']; 
        $data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
        $data["id"] = $data["logged_in"]['id'];
        $data['query'] = $this->master_model->master_get_tbl_val_id("shadminmaster", array("id" => $data["id"]), array("id", "desc"));
			
        
		//	print_r($data['query']);
        $this->load->view('Admin/header');
        $this->load->view('Admin/nav', $data);
        $this->load->view('Admin/company_edit_copy', $data);
        $this->load->view('Admin/footer');
    }
    function query(){
        if($_SESSION['logged_in'] == ""){
            redirect('login');
        }
        $data["logged_in"] = $_SESSION['logged_in']; 
        $data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
        $data["id"] = $data["logged_in"]['id'];
        $id = $data["logged_in"]['id'];
        
        $data['query'] = $this->master_model->get_val("select * from demo_query where status='1' and  user_id ='$id' order by id desc ");
        $this->load->view('Admin/header');
        $this->load->view('Admin/nav', $data);
        $this->load->view('Admin/query', $data);
        $this->load->view('Admin/footer');
    }
    function query_add(){
        $data["logged_in"] = $_SESSION['logged_in']; 
        $data["id"] = $data["logged_in"]['id'];
        $id = $data["logged_in"]['id'];
        $data = $this->input->post();
        $data['user_id'] = $id;
        $insert_id = $this->master_model->master_insert('demo_query',$data);
        $this->session->set_flashdata('success', "Your query submitted successfully.");
        echo "1";
    }
	function query_delete($id){
		$insert_id = $this->master_model->master_update('demo_query',array("id"=>$id),array("status"=>"0"));
		$this->session->set_flashdata('success', "Your queries deleted successfully.");
		redirect('userhome/query');
	}
    function logout(){
    	$this->session->unset_userdata('logged_in');
    	redirect('login');
    }
}
