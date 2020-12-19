<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_master extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master_model');
		$this->load->model('user_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->database();
    }

    function index() {
       if($_SESSION['logged_in'] == ""){
			redirect('loginadmin');
		}
		
		if ($this->session->userdata('success') != null) {
                $data['success'] = $this->session->userdata("success");
                $this->session->unset_userdata('success');
            }
            if ($this->session->userdata('unsuccess') != null) {
                $data['unsuccess'] = $this->session->userdata("unsuccess");
                $this->session->unset_userdata('unsuccess');
            }
		

		$data["login_data"] = $_SESSION['logged_in']; 
		$data["user"] = $this->user_model->getUser($data["login_data"]["id"]);
		$userid = $data["login_data"]["id"];
		

        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[shadminmaster.AdminEmail]');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[shadminmaster.AdminName]');
	 $this->form_validation->set_rules('password', 'Password', 'trim|required');
			
        if ($this->form_validation->run() == FALSE) {
			$data["logged_in"] = $_SESSION['logged_in'];
		$this->load->view('Admin/header');
		$this->load->view('Admin/nav',$data);
		$this->load->view('Admin/admin_add',$data);
		$this->load->view('Admin/footer');
		}else{
			$username = $this->input->post("username");
			$email = $this->input->post("email");
			$password = $this->input->post("password");
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
			$this->load->view('admin_add', $error);
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
					"AdminPassword" =>$password,
 					"profile_pic" => $file_name,
					"status" => '1'
				);
			}else {
				$data1 = array(
					"profile_pic"=>'images1.png',
					"AdminName" => $username,
					"AdminPassword" =>$password,
					"AdminEmail" => $email,
 					"status" => '1'
				);
			}
		
			$insert=$this->master_model->master_fun_insert('shadminmaster',$data1);
			$data["login_data"] = $_SESSION['logged_in']; 
			$data["user"] = $this->user_model->getUser($data["login_data"]["id"]);
			if($insert)
			{
				$ses = array("Admin Successfully Inserted!");
                $this->session->set_userdata('success', $ses);  
				redirect('admin_master/admin_list');
			}
	}
    }

    function admin_list() {
		if($_SESSION['logged_in'] == ""){
			redirect('login');
		}

		if ($this->session->userdata('success') != null) {
                $data['success'] = $this->session->userdata("success");
                $this->session->unset_userdata('success');
            }
            if ($this->session->userdata('unsuccess') != null) {
                $data['unsuccess'] = $this->session->userdata("unsuccess");
                $this->session->unset_userdata('unsuccess');
            }
		
		$data["logged_in"] = $_SESSION['logged_in']; 
		$data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
		$userid = $data["logged_in"]["id"];
		
			
	  		$user=$this->input->get("user");
	 		$email=$this->input->get("email");
	 		
	
          	 if ($user!='' || $email!=''){
			
			$data['username']=$user;
			$data['email']=$email;
			
			
				 $query="select * from shadminmaster where type = '2' AND  status=1 ";
				 
				// print_r($query);
				 if($user != NULL)
				 {
					 $query.=" and AdminName like '%$user%'";
				 }
				 if($email != NULL)
				 {
					 $query.=" and AdminEmail like '%$email%'";
				 }
				
                    $data["query"] = $this->master_model->get_data($query);
				 //print_r($data["query"]); die();
                    $totalRows = count($data["query"]);
				 
                    $config = array();
                    $config["base_url"] = base_url() . "admin_master/admin_list/srch?" . $_SERVER['QUERY_STRING'];
                    $config["total_rows"] = $totalRows;
                    $config["per_page"] = 10;
                    $config['page_query_string'] = TRUE;
                    $this->pagination->initialize($config);
                    $page = ($this->input->get("per_page")) ? $this->input->get("per_page") : 0;
                    $data["links"] = $this->pagination->create_links();
                    $data["query"] = $this->master_model->get_active_record3($query, $config["per_page"], $page);
                    $data['count'] = $page + 1;
                    //pagination end
			
			 }else{
			// print_r($data);
			$data["query"]=$this->master_model->get_active_record();
            $totalRows = count($data["query"]);
            $config = array();
            $config["base_url"] = base_url() . "admin_master/admin_list/";
            $config["total_rows"] = $totalRows;
            $config["per_page"] = 10;
            $config["uri_segment"] = 3;
            $this->pagination->initialize($config);
            $sort = $this->input->get("sort");
            $by = $this->input->get("by");
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["query"] = $this->master_model->get_active_record1($config["per_page"], $page);
             $data["links"] = $this->pagination->create_links();
			
			
		$data["login_data"] = $_SESSION['logged_in']; 
		$data["user"] = $this->user_model->getUser($data["login_data"]["id"]);
			 }
		$this->load->view('Admin/header');
		$this->load->view('Admin/nav',$data);
		$this->load->view('Admin/admin_view',$data);
		$this->load->view('Admin/footer');
		
    	
	}
    function admin_delete() {
$cid = $this->uri->segment('3');
            $data = array(
                "status" => '0'
            );
			
            //$delete=$this->admin_model->delete($cid,$data);
            $delete = $this->master_model->master_fun_update("shadminmaster", $this->uri->segment('3'), $data);
            if ($delete) {
                $ses = array("Admin Successfully Deleted!");
                $this->session->set_userdata('success', $ses);
                redirect('admin_master/admin_list', 'refresh');
            }
       
    }

    function admin_edit() {
       if($_SESSION['logged_in'] == ""){
			redirect('loginAdmin');
		}

		$data["login_data"] = $_SESSION['logged_in'];
		$data["user"] = $this->user_model->getUser($data["login_data"]["id"]);
		
     $data["id"]=$this->uri->segment('3');
		   if ($this->session->userdata('unsuccess') != null) {
                $data['unsuccess'] = $this->session->userdata("unsuccess");
                $this->session->unset_userdata('unsuccess');
            }
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
	 $this->form_validation->set_rules('password', 'Password', 'trim|required');
		
        if ($this->form_validation->run() != FALSE) {
			
			$username = $this->input->post("username");
			$email = $this->input->post("email");
			$password = $this->input->post("password");
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
			$this->load->view('admin_edit', $error);
			$this->load->view('footer');
				}else {
					$data = array('upload_data' => $this->upload->data());
					$file_name = $data["upload_data"]["file_name"];
				}
			}
			$querynm=$this->master_model-> master_num_rows('AdgAdminMmaster',array('status'=>'1','id !='=>$this->uri->segment('3'),'AdminName'=>$username));
                if($querynm == 0)
				{
        $querynm=$this->master_model-> master_num_rows('AdgAdminMmaster',array('status'=>'1','id !='=>$this->uri->segment('3'),'AdminEmail'=>$email));
                if($querynm == 0)
				{
		
			if(isset($file_name)) {
				$data1 = array(
					"AdminName" => $username,
					"AdminEmail" => $email,
					"AdminPassword" =>$password,
 					"profile_pic" => $file_name
				);
			}else {
				$data1 = array(
					"AdminName" => $username,
					"AdminPassword" =>$password,
					"AdminEmail" => $email
 					
				);
			}
		
			$update=$this->master_model->master_fun_update("AdgAdminMmaster", $this->uri->segment('3'), $data1);
			if($update)
			{
			$ses = array("Admin Successfully Updated!");
                $this->session->set_userdata('success', $ses);
			redirect('admin_master/admin_list');
	
			}
				}
					else
					{
						$ses = array("Email Address Already Exists!");
                $this->session->set_userdata('unsuccess', $ses);
                
			redirect('admin_master/admin_edit/'.$this->uri->segment('3'));
					}
				}
			else
					{
						$ses = array("User Name Already Exists!");
                $this->session->set_userdata('unsuccess', $ses);
                
			redirect('admin_master/admin_edit/'.$this->uri->segment('3'));

					}
		}
		else
		{
		$data['query'] = $this->master_model->master_fun_get_tbl_val("AdgAdminMmaster ", array("id" => $this->uri->segment('3')), array("id", "desc"));
		}
		
			$this->load->view('header');
			$this->load->view('nav',$data);
			$this->load->view('admin_edit', $data);
			$this->load->view('footer');
		
	}
    public function remove_all_data(){
        $this->master_model->remove_data_table("companycount_master");
        $this->master_model->remove_data_table("category_advertise_master");
	$this->master_model->remove_data_table("category_master");
        $this->master_model->remove_data_table("company_master");
        $this->master_model->remove_data_table("company_product_master");
	$this->master_model->remove_data_table("gallery_master");
        $this->master_model->remove_data_table("home_advertise_master");
        $this->master_model->remove_data_table("reg_advertise_master");
	$this->master_model->remove_data_table("gallery_master");
    }
}
?>
