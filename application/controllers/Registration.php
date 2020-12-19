<?php
if (!defined('BASEPATH'))

    exit('No direct script access allowed');


class Registration extends CI_Controller {

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
    public function check_email(){
        $email =  $this->input->get('email');
        $result = $this->master_model->select_user("*",array("UserEmail"=>$email,"status"=>"1"));
        if($result){
            echo "1";
        }else{
            echo "0";
        }
    }
    public function check_email_edit(){
        $email =  $this->input->get('email');
		$id =  $this->input->get('id');
        $result = $this->master_model->select_user("*",array("UserEmail"=>$email,"id != "=>$id,"status"=>"1"));
        if($result){
            echo "1";
        }else{
            echo "0";
        }
    }
    public function check_email_only(){
        
        $email =  $this->input->get('email');
        $id =  $this->input->get('id');
        $result = $this->master_model->select_user("*",array("UserEmail"=>$email,"status"=>"1"));
        if($result){
            echo "1";
        }else{
            echo "0";
        }
    }
    public function check_email_edit_user(){
        $email =  $this->input->get('email');
        $id =  $this->input->get('id');
        $passval =  $this->input->get('passval');
        $pass =  $this->input->get('pass');
        $result = $this->master_model->select_user("*",array("UserEmail"=>$email,"id != " => $id,"status"=>"1"));
        if($result){
            echo "1";
        }else{
            if($passval == '0'){
                $result = $this->master_model->select_user("UserPassword",array("id" => $id,"status"=>"1"));
                if($pass == $result['0']->UserPassword){
                    echo '0';
                }else{
                    echo '3';
                }
            }else{
                echo "0";
            }
            
        }
    }
    public function registration_data(){
        $data = $this->input->post();
        $this->load->helper(array('swift'));
        $insert_id = $this->master_model->master_insert('AdgUserMaster',$data);
        if($insert_id != ""){
             $message = "Hello ".$data['UserFName'].". <br/><br/>";
            $message .= "Thank you for registering with us at Demo.<br/>To complete your registration please verify your account by clicking the button below..<br/><br/>";
                            $base = base_url();
            $message .= "<a href='".$base."registration/verify/" . md5($insert_id) . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Click To Email Verification</a><br/><br/>";
            $message .= "If you are having problems, simply email us at: <a href='mailto:support@demo.com'>support@demo.com</a> for assistance. <br/>";
            $message .= "Thanks <br/>The Demo<br/><br/>";
            $message .= "<hr><br/> <a href='$base' >$base</a>  <br/>";
            send_mail($data['UserEmail'],'Demo - Welcome, Please Verify Your New Account',$message);
            $this->session->set_flashdata('success', "Thank you for registration please verify your account");
            echo "1";
        } else {
            echo "0";
        }
    }
    public function registration_data_update(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $insert_id = $this->master_model->master_update('AdgUserMaster',array('id'=>$id),$data);
        $this->session->set_flashdata('success', "Customer successfully edit");
        echo "1";
    }
    public function registration_data_update_user(){
        $data = $this->input->post();
        if(isset($data['change_pass']) && $data['change_pass'] == 1){
            $newdata = $data;
        }else{
            $newdata = array(
                "UserFName"=>$data['UserFName'],
                "UserLName"=>$data['UserLName'],
                "UserEmail"=>$data['UserEmail'],
                "UserGender"=>$data['UserGender'],
                "UserCountry"=>$data['UserCountry'],
                "UserState"=>$data['UserState'],
                "UserMNumber"=>$data['UserMNumber']
            );
        }
        $id = $this->input->post('id');
        $insert_id = $this->master_model->master_update('AdgUserMaster',array('id'=>$id),$newdata);
        $this->session->set_flashdata('success', "Your profile update successfully");
        echo "1";
    }
    function index(){  
		if($_SESSION['logged_in'] != ""){
				redirect('home');
		}
        $data['country_list'] = $this->master_model->get_val("select * from demo_country where status='1'");
        $this->load->view('user/registration',$data);
    }
    public function getState(){
        $id = $this->input->post('id');
        $result = $this->master_model->get_val("select * from demo_state where status='1' and country_fk='".$id."'");
        $state_array = '';
        $state_array .='<option value="">Select State</option>';   
        foreach($result as $val){
            $state_array .= '<option value="'.$val['id'].'">'.$val['state_name'].'</option>';
        }
        echo $state_array;
    }
    public function verify($id=""){
        if($id != ""){
            $result = $this->master_model->select_user("*",array("md5(id)"=>$id,"status"=>"1"));
            if($result){
                if($result[0]->active == 0){
                    $this->master_model->master_update('AdgUserMaster',array("id"=>$result[0]->id),array("active"=>"1"));
                    $this->session->set_flashdata('success', "Your account successfully verified");
                }else{
                    $this->session->set_flashdata('fail', "Your account already verified");
                }
            }else{
                $this->session->set_flashdata('fail', "your account has expired");
            }
        }else{
            $this->session->set_flashdata('fail', "Sorry something is wrong please try again");
        }
        redirect('login', 'refresh');
    }
	function check_database($password) {
        $this->load->library('session');
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
        $username = $this->input->post('UserEmail');
		  $result = $this->Login_model->checkemail($username);
		
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
		
		if($_SESSION['logged_in'] != ""){
				redirect('home');
		}
		$this->form_validation->set_rules('UserEmail', 'Email', 'required|trim|callback_check_data');
		$UserEmail = $this->input->post('UserEmail');
		//print_r($UserEmail);
		if ($this->form_validation->run() == FALSE) {
		$data1 = array();
		$this->load->view('user/header');	
		$this->load->view('user/Forgot_password');
		$this->load->view('user/footer');
		}else{
			
	
			
		
//$this->email->cc('manoj@virtualheight.com');
//$this->email->bcc('them@their-example.com');
				//$this->email->initialize($config);
                $message = "Reset Password. <br/><br/>";
                $message .= "Thank you for registering with us at Aldridge.<br/>To complete your registration please verify your account by clicking the button below..<br/><br/>";
				$base = base_url();
                $message .= "<a href='".$base."Registration/resetp/" . md5($UserEmail) . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Click To Reset password </a><br/><br/>";
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
				send_mail($UserEmail,'Demo - Forgot password',$message);
				//echo "here";
	
			
		}	
		$data = array();
			
		$this->load->view('user/header');	
		$this->load->view('user/Forgot_password1');
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
			$this->load->view('user/header');
			$this->load->view('user/newpassword',$data1);
			$this->load->view('user/footer');
		}else{
			       $data1 = array("UserPassword" => $UserPassword );
			
			$update = $this->Login_model->master_fun_update_2("AdgUserMaster", $id1, $data1);
			$data['success'] = "Your Password Reset";
			$this->load->view('user/header');
			$this->load->view('user/login',$data);
			$this->load->view('user/footer');
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

			redirect('Login');

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