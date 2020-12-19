<?php
if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class RegistrationAdmin extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('Login_model');
		$this->load->model('master_model');
		$this->load->helper(array('swift'));
		$this->load->library('email');
		$this->load->database();
		$this->load->library('session');
    }
    
		function index(){  

		 
		//$this->form_validation->set_rules('area_name', 'Area Name', 'trim|required|xss_clean');
			$area_name = $this->input->post('area_name');
			if($area_name == ""){
				$ses1= "";
			$ses = "Email is Already registered";
			$this->session->set_flashdata('notlogin',$ses);
			$this->session->set_flashdata('login',$ses1);
            $data1["error"] = $this->session->flashdata('notlogin');
			$data1["error1"] = $this->session->flashdata('login');
				
		
		$this->load->view('registration');
		
			}
			else{
		//print_r($area_name); die();
 if ($this->form_validation->run() == FALSE) {
		
		
		$this->load->view('user/registration');
		
			
 }}}

	function savingdata()  
    {  
		
		// print_r($_POST);
		$this->form_validation->set_rules('UserFName', 'First Name', 'trim|required');
		$this->form_validation->set_rules('UserLName', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('UserEmail', 'Email', 'required|trim|callback_check_database');
		$this->form_validation->set_rules('UserPassword', 'Password', 'required|trim');
		$this->form_validation->set_rules('UserMNumber', 'Mobile Number', 'required|trim');
		$this->form_validation->set_rules('UserAddress', 'Address', 'required|trim');
		$this->form_validation->set_rules('UserDOB', 'User DOB', 'required|trim');
		$this->form_validation->set_rules('UserCity', 'User City', 'required|trim');
			$UserFName = $this->input->post('UserFName');
			$UserLName = $this->input->post('UserLName');
			$UserEmail = $this->input->post('UserEmail');
			$UserPassword = $this->input->post('UserPassword');
			$UserGender = $this->input->post('UserGender');
			$UserMNumber = $this->input->post('UserMNumber');
			$UserDOB = $this->input->post('UserDOB');
			$UserCity = $this->input->post('UserCity');
			$UserAddress = $this->input->post('UserAddress');
		$data1 = array(); 
		//print_r($_POST); die();
if ($this->form_validation->run() == FALSE) {
			$sess_array = array();
			$ses1= "";
			$ses = "";
			$this->session->set_flashdata('notlogin',$ses);
			$this->session->set_flashdata('login',$ses1);
            $data1["error"] = $this->session->flashdata('notlogin');
			$data1["error1"] = $this->session->flashdata('login');
		$this->load->view('user/header');	
		$this->load->view('user/registration',$data1);
		$this->load->view('user/footer');
}else{

		$data1 = array(
					"UserFName" => $UserFName,
					"UserLName" => $UserLName,
					"UserEmail" => $UserEmail,
					"UserPassword" => $UserPassword,
					"UserGender" => $UserGender,
					"UserMNumber" => $UserMNumber,
					"UserDOB" => $UserDOB,
					"UserCity" => $UserCity,
					"UserAddress" => $UserAddress,
					"status" =>'1'

				);
	
				$this->db->insert('AdgUserMaster',$data1);
			   $insert_id = $this->db->insert_id();
		if($insert_id != ""){
			
		
//$this->email->cc('manoj@virtualheight.com');
//$this->email->bcc('them@their-example.com');
				//$this->email->initialize($config);
                $message = "Hello $UserFName. <br/><br/>";
                $message .= "Thank you for registering with us at Aldridge.<br/>To complete your registration please verify your account by clicking the button below..<br/><br/>";
				$base = base_url();
                $message .= "<a href='".$base."Registration/Verify/" . md5($insert_id) . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Click To Email Verification</a><br/><br/>";
                $message .= "If you are having problems, simply email us at: <a href='mailto:support@aldridge.com'>support@aldridge.com</a> for assistance. <br/>";
                $message .= "Thanks <br/>The Squadli<br/><br/>";
                $message .= "<hr><br/><a href='www.directivecommunication.net'>directivecommunication.net</a> <br/>� 2016 <a href='directivecommunication.net' >directivecommunication.net</a>  Avalon #1, Jalan Carmazzi, Mawang Kelod, Ubud, Bali - Indonesia<br/>";

                //$this->email->to($email);
//				$this->email->to($email.',jabir@virtualheight.com');
                //$this->email->from('support@squadli.com', 'Squadli');
                //$this->email->subject("Squadli - Welcome, Please Verify Your New Account");
                //$this->email->message($message);
                //$this->email->send();
				//send_mail($UserEmail,'Squadli - Welcome, Please Verify Your New Account',$message);
				send_mail($UserEmail,'Aldridge - Welcome, Please Verify Your New Account',$message);
				//echo "here";
	}
		//die();
//redirect('login', 'refresh');
	//print_r(``````````````````````````````); die();
	$data['success'] = "Thank you, For Registertion , but check mail verify your Accout";
	//print_r($data);
	$this->load->view('user/header');
		$this->load->view('user/Login',$data);
	$this->load->view('user/footer');
//		
	
	
//		$sess_array = array();
//			$ses1= "";
//			$ses = "Email is Already registered";
//			$this->session->set_flashdata('notlogin',$ses);
//			$this->session->set_flashdata('login',$ses1);
//            $data1["error"] = $this->session->flashdata('notlogin');
//			$data1["error1"] = $this->session->flashdata('login');
		//$this->form_validation->set_message('savingdata', 'Invalid Email or password');
           
//		$this->load->view('user/header');	
//		$this->load->view('user/registration',$data1);
//		$this->load->view('user/footer');
}}
	
	
	function check_database($password) {
        $this->load->library('session');
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('UserEmail');
		  $result = $this->Login_model->checkemail($username);
		
        //query the database
  //print_R($result) ; DIE();
        if ($result == "") {
//              die(manoj);
            
            return TRUE;
			
        } else {

            $this->form_validation->set_message('check_database', 'sorry this email id is already registered');
            return false;
        }
    }
	function check_data($password) {
        $this->load->library('session');
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('email');
		//print_r($username);
		  $result = $this->Login_model->checkemailAdmin($username);
		
        //query the database
  //print_R($result) ; DIE();
        if ($result == "") {
//              die(manoj);
            $this->form_validation->set_message('check_data', 'Enter Right Email');
            return false;
			
        } else {

            
            return  TRUE;
        }
    }
	
    function Forgot_password(){
		//print_r($_POST);
		
		
		$this->form_validation->set_rules('email', 'Email', 'required|trim|callback_check_data');
		$UserEmail = $this->input->post('email');
		//print_r($UserEmail);
		if ($this->form_validation->run() == FALSE) {
		$data1 = array();
			
		$this->load->view('Forgot_password');
		
		}else{
			
	
			
		
//$this->email->cc('manoj@virtualheight.com');
//$this->email->bcc('them@their-example.com');
				//$this->email->initialize($config);
                $message = "Reset Password. <br/><br/>";
                $message .= "Thank you for registering with us at Aldridge.<br/>To complete your registration please verify your account by clicking the button below..<br/><br/>";
				$base = base_url();
                $message .= "<a href='".$base."RegistrationAdmin/resetp/" . md5($UserEmail) . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Click To Reset password </a><br/><br/>";
                $message .= "If you are having problems, simply email us at: <a href='mailto:support@squadli.com'>support@squadli.com</a> for assistance. <br/>";
                $message .= "Thanks <br/>The Squadli<br/><br/>";
                $message .= "<hr><br/><a href='www.directivecommunication.net'>directivecommunication.net</a> <br/>� 2016 <a href='directivecommunication.net' >directivecommunication.net</a>  Avalon #1, Jalan Carmazzi, Mawang Kelod, Ubud, Bali - Indonesia<br/>";

                //$this->email->to($email);
//				$this->email->to($email.',jabir@virtualheight.com');
                //$this->email->from('support@squadli.com', 'Squadli');
                //$this->email->subject("Squadli - Welcome, Please Verify Your New Account");
                //$this->email->message($message);
                //$this->email->send();
				//send_mail($UserEmail,'Squadli - Welcome, Please Verify Your New Account',$message);
				send_mail($UserEmail,'Aldridge - Forgot password',$message);
				//echo "here";
	
			$data = array();
			
		$this->load->view('Forgot_password1');
		}	
		
		
	}
	
	
	public function verify() {
		$id = $this->uri->segment('3');
		//print_r($id);
		
       $data1 = array("active" => '1');
       $update = $this->Login_model->master_fun_update_1("AdgAdminMmaster", $id, $data1);
$data['success'] = "Thank you your Account has been successfully verified";
		$this->load->view('user/header');
			$this->load->view('user/login',$data);
			$this->load->view('user/footer');
   }
	public function resetp() {
		$id = $this->uri->segment('3');
		//print_r($id);
		$this->form_validation->set_rules('UserPassword', 'Password', 'required|trim');
		$UserPassword = $this->input->post('UserPassword');
		$id1 = $this->input->post('id');
		//print_r($_POST);
//		echo $UserPassword;
		$data1 = array( "id"=> $id );
		//print_r($data);
		if ($this->form_validation->run() == FALSE) {
			$data1 = array("id"=> $id);
			$this->load->view('newpassword',$data1);
			
		}else{
			       $data1 = array("AdminPassword" => $UserPassword );
			
			$update = $this->Login_model->master_fun_update_Admin("AdgAdminMmaster", $id1, $data1);
			$data['success'] = "Your Password Reset";
			$this->load->view('login_view',$data);
			
   }}

   
	function catrgory_csv() {

        	if(!is_loggedin()){

				redirect('login');

			}

            $this->load->dbutil();

            $this->load->helper('file');

            $this->load->helper('download');

            $delimiter = ",";

            $newline = "\r\n";

            $filename = "Category.csv";

            $query = "SELECT type as Type,category_name as Category,description as Description FROM category_master where status='1' ORDER BY category_name ASC";

            $result = $this->db->query($query);

            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);

            force_download($filename, $data);      

    }

	function importcategory() {

		if(!is_loggedin()){

			redirect('login');

		}

		

		if (empty($_FILES['category_file']['name'])) {

            $this->form_validation->set_rules('category_file', 'Upload', 'required');

        }

        if ($this->form_validation->run() == FALSE) {

			

            $_FILES["category_file"]["type"];

            $config['upload_path'] = './uploads/';

            $config['allowed_types'] = 'text/x-csv|csv';

            $config['file_name'] = time() . $_FILES['category_file']['name'];

            $config['file_name'] = str_replace(' ', '_', $config['file_name']);

            $_FILES['category_file']['name'];

            $file1 = $config['file_name'];

            $this->load->library('upload', $config);

            $this->upload->initialize($config);



            if (!$this->upload->do_upload('category_file')) {

                $data['error'] = $this->upload->display_errors();



                $ses = array($data['error']);

                $this->session->set_userdata('successadd', $ses);

                redirect('category_master/area_list', 'refresh');

            } else {

                $file_data = $this->upload->data();

                $file_path = './uploads/' . $file_data['file_name'];

                if ($this->csvimport->get_array($file_path)) {

                    $csv_array = $this->csvimport->get_array($file_path);

                    $cnt = 0;

                    foreach ($csv_array as $row) {

                        if(!empty($row['Category']) &&!empty($row['Type'])){

$type = $row['Type'];

							$categoryname = $row['Category'];

							$description = $row['Description'];

							$get = $this->master_model->getuniq('category_master',array('category_name' => $row['Category'],'status ' => '1'));

							

							if($get == "0"){

							$time=$this->master_model->get_server_time();

							$data1 = array(

"type" => $type,

									"category_name" => $categoryname,

									"description" => $description,

									"status" =>'1',

									"created_date"=>$time['UTC_TIMESTAMP()']

								);



							$insert=$this->master_model->master_fun_insert('area_list',$data1);

							$data["login_data"] = logindata(); 

							$data["user"] = $this->user_model->getUser($data["login_data"]["id"]);

							$cnt++;

							}

                        }

						

                    }

                    if($cnt == 0){

                        $ses = "Please check your file";

                    }

                    else {

                    $ses = $cnt." Category Added Successfully";

                    }

					//echo $ses; die();

                    $this->session->set_flashdata('successf', $ses);

                    redirect('area_master/area_list', 'refresh');

                    //echo "<pre>"; print_r($insert_data);

                } else {

                    $this->load->view('admin/header', $data);

                    $this->load->view('admin/area_list', $data);

                    $this->load->view('admin/footer');

                }

            }

        } else {

			

            $this->session->set_flashdata('failf', "Pleas Select file");

			redirect('area_master/area_list', 'refresh');

        }

    }

}

?>