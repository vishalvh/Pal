<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('home_model');
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->library('form_validation');
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
		$data["totaladmin"] = $this->home_model->getadmin();
		//$data["totalcusromer"] = $this->home_model->getcust();
		//$data["totalqueries"] = $this->home_model->getquery();
		//$data["graph"] = $this->home_model->graph();
		
		$userid = $data["logged_in"]["id"];
			$this->load->view('header',$data);
			$this->load->view('user/nav',$data);
			$this->load->view('home_view',$data);
			$this->load->view('footer');
		
	}
	
	function index2(){
		if($_SESSION['logged_in'] == ""){
			redirect('login');
		}
	if($this->session->flashdata("error")) {
		$data["error"] = $this->session->flashdata("error");
		
		}
		$data["logged_in"] = $_SESSION['logged_in']; 
		$data["totaladmin"] = $this->home_model->getadmin();
		//$data["totalcategory"] = $this->home_model->getcategory();
		//$data["totalsubcategory"] = $this->home_model->getsubcategory();
		
		$this->load->view('header');
		$this->load->view('nav',$data);
		$this->load->view('home_view',$data);
		$this->load->view('footer');
	}
	
	
}
?>        

