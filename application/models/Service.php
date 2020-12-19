<?php

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
       $this->load->model('service_model');
        $this->load->model('login_model');
        $this->load->helper('security');
        $this->load->helper('string');
		$this->load->helper(array('swift'));
        $this->load->library('email');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With");
		$this->Squadli_tarce();
    }
	function Squadli_tarce() {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $page = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
        if (!empty($_SERVER['QUERY_STRING'])) {
            $page = $_SERVER['QUERY_STRING'];
        } else {
            $page = "";
        }
        if (!empty($_POST)) {
            $user_post_data = $_POST;
        } else {
            $user_post_data = array();
        }
        $user_post_data = json_encode($user_post_data);
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $remotehost = @getHostByAddr($ipaddress);
        $user_info = json_encode(array("Ip" => $ipaddress, "Page" => $page, "UserAgent" => $useragent, "RemoteHost" => $remotehost));
        $user_track_data = array("url" => $actual_link, "user_details" => $user_info, "data" => $user_post_data, "createddate" => date("Y-m-d H:i"), "type" => "service");
        //print_R($user_track_data);
        $Squadli_info = $this->service_model->master_insert("alldata", $user_track_data);
        //return true;
    }
    public function index() {
        echo "Mobile Squadlilicaton";
    }
	public function Squadli_version(){
		echo $this->json_data("1", "", "2");
	}
	function get_content($URL){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $URL);
      $data = curl_exec($ch);
      curl_close($ch);
}
    public function register() {
        $email = $this->input->get_post('email');
        $name = $this->input->get_post('name');
        $password = $this->input->get_post('password');
        $mobile = $this->input->get_post('mobile');
        $type = $this->input->get_post('type');
        if ($mobile != NULL && $email != null && $password != null && $type != null && $name != null) {
            $row = $this->service_model->master_num_rows("customer_master", array("email" => $email, "status" => 1));
            if ($row == 0) {
				$email = strtolower($email);
                $insert = $this->service_model->master_fun_insert("customer_master", array("name" => $name, "type" => $type, "email" => $email, "password" => $password, "mobile" => $mobile, "active" => '0'));
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $message = "Hello $name. <br/><br/>";
                $message .= "Thank you for registering with us at Squadli.<br/>

To complete your registration please verify your account by clicking the button below..<br/><br/>";
$base = base_url();
                $message .= "<a href='".$base."service/Verify/" . md5($insert) . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Click To Email Verification</a><br/><br/>";
                $message .= "If you are having problems, simply email us at: <a href='mailto:support@squadli.com'>support@squadli.com</a> for assistance. <br/>";
                $message .= "Thanks <br/>The Squadli<br/><br/>";
                $message .= "<hr><br/><a href='www.directivecommunication.net'>directivecommunication.net</a> <br/>� 2016 <a href='directivecommunication.net' >directivecommunication.net</a>  Avalon #1, Jalan Carmazzi, Mawang Kelod, Ubud, Bali - Indonesia<br/>";

                //$this->email->to($email);
//				$this->email->to($email.',jabir@virtualheight.com');
                //$this->email->from('support@squadli.com', 'Squadli');
                //$this->email->subject("Squadli - Welcome, Please Verify Your New Account");
                //$this->email->message($message);
                //$this->email->send();
				send_mail($email,'Squadli - Welcome, Please Verify Your New Account',$message);


                echo $this->json_data("1", "", array(array("id" => "$insert")));
            } else {
                echo $this->json_data("0", "Email Already Registered", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
    public function verify($id) {
        $data1 = array("active" => '1');
        $update = $this->service_model->master_fun_update_1("customer_master", $id, $data1);
		echo "thank you your account has been successfully verified";
    }
    public function verify1($id) {
        $data1 = array("active" => '1');
        $update = $this->service_model->master_fun_update("customer_master", $id, $data1);
    }
    function login() {
        $email = $this->input->get_post('email');
		//print_r($email);
        $password = $this->input->get_post('password');
        if ($email != NULL && $password != NULL) {
            $result = $this->login_model->checkloginuser($email, $password);
			//print_r($result); die();
            if ($result != "") {

                $data = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("AdminEmail" => $email, "AdminPassword" => $password, "status" => 1), array("id", "asc"));
			//	print_r($data[0]); die();
				//print_r($data[0]['Active'] );
				$Active = $data[0]['Active'];
			
				$id = $data[0]['id'];
				if ($Active == '1') {
//                    if ($data[0]['login'] == '0') {
//                        $data1 = array(
//                            'login' => '1'
//                        );
//                        $update = $this->service_model->master_fun_update("customer_master", $data[0]['id'], $data1);
//                    }
                    $row = $this->service_model->master_num_rows("shadminmaster", array("id" => $data[0]['id'], "status" => 1,"type" => 2));
                    $membercount = $this->service_model->master_num_rows("shadminmaster", array("id" => $data[0]['id'], "status" => 1,"type" => 2));
					
                    $data[0]['team_count'] = "$row";
                    //$data[0]['member_count'] = "$membercount";
                    $list = array();
                    $list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("id" => $data[0]['id'], "status" => 1), array("id", "id"));
                   // $data[0]['manager_team'] = $list;
                    $user_team = array();
                    $user_team = $this->service_model->select_all("shadminmaster",$id);
					//print_r($data); die(); 
					//$packa_select = $this->service_model->user_select_pack($data[0]['id']);
					
//echo data[0]['type'];
					$uniqueId =	substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);
                    $data1 = array("token" => $uniqueId);
					$update = $this->service_model->master_fun_updateid("shadminmaster", $id, $data1); 
					//print_r($id);
					//print_r($update); die();
					 $data2 = $this->service_model->master_fun_get_tbl_val_service("shadminmaster", array("AdminEmail" => $email, "AdminPassword" => $password, "status" => 1), array("id", "asc"));

                    echo $this->json_data("1", "", $data2);
                } else {
                    echo $this->json_data("0", "Please Verify Your Email Address", "");
                }
            } else {
                echo $this->json_data("0", "We could not find the account that associated with $email", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
	function pump_list(){
		 $data = $this->service_model->get_active_record_Pump();
		echo $this->json_data("1", "", $data);
	}
	///////////////////////vishal 11-4 start
	function all_list(){		
		$petrol = $this->service_model->get_pump_list('P');
		//$data['petrol'] = $petrol;
		$diesel = $this->service_model->get_pump_list('D');
		//$data['diesel'] = $diesel;
		$oil = $this->service_model->oil_type_list();
		$expensein = $this->service_model->expensein_type_list();
		//$data['oil'] = $oil;
		$meter_reading['petrol'] = $petrol;
		$meter_reading['diesel'] = $diesel;
		$data['meter_reading'] = $meter_reading;
		$data['oil_type'] = $oil;
		$data['expensein_type'] = $expensein;
		echo $this->json_data("1", "", array($data));
	}
	///////////////////////vishal 11-4 end
    function forget_password() {
        $this->load->library('email');
        $email = $this->input->get_post('email');
        if ($email != NULL) {

            $row = $this->service_model->master_fun_get_tbl_val_1("shadminmaster", array("AdminEmail" => $email, "status" => 1), array("id", "asc"));
            $title = $this->config->item('title');
            if ($row != null) {
				$uniqueId=	substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5);
				//print_r($row); die();
                $password = $row[0]['AdminPassword'];
		$user = $row[0]['AdminName'];
				//print_r($password);
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
				$message = "Hi ".ucwords($user).",<br/><br/>";
                $message .= "We received a request that you forgot the password for your Shri Hari account.<br/><br/>";
				$base = base_url();
                //$message .= "Please use the following password: <strong>" . $password . "</strong><br/><br/> ";
				$message .= "<a href='".$base."login/get_password/" . $uniqueId . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Click To Reset password </a><br/><br/>";
                $message .= "If you did not make this request, please ignore this email or reply to let us know.<br/><br/>";
                $message .= "Thanks <br/> Shri Hari";
                //$this->email->to($email);
                //$this->email->from('support@squadli.com', 'Squadli');
                //$this->email->subject("$title forgotten Password");
                //$this->email->message($message);
                //$this->email->send();
				
				send_mail($email,$title.' forgotten Password',$message);
				
				$data1 = array("Rs" => $uniqueId);
			//print_r($data1); die();
			
			//$id = $_SESSION['user_logged_in']['id'];
//			echo $UserEmail;
			$insert = $this->service_model->master_fun_update_UserEmail('shadminmaster',$email,$data1);
				//print_r($insert); die();
                echo $this->json_data("1", "An email has been sent to your email address", "");
            } else {

                echo $this->json_data("0", "We couldn't find Shri Hari account associated with $email.", "");
            }
        } else {

            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
	public function resetp() {
		$id = $this->uri->segment('3');
		$data1 = array( "id"=> $id );
		//print_r($Rs);
		
		$result = $this->service_model->get_terms($id);
		//print_r($result);
		$id1 = $result; //die();
		if($result == ""){
			$this->session->set_flashdata('fail','This link is already used'); 
		redirect('login', 'refresh');
		}
		$this->form_validation->set_rules('AdminPassword', 'Password', 'required|trim');
		$UserPassword = $this->input->post('AdminPassword');
		$id1 = $this->input->post('id');
//		print_r($_POST); die();
//		echo $UserPassword;
		$data1 = array( "id"=> $id );
		//print_r($data);
		if ($this->form_validation->run() == FALSE) {
			$data1 = array("id"=> $id);
			$this->load->view('user/header');
			$this->load->view('user/newpassword',$data1);
			$this->load->view('user/footer');
		}else{
			       $data2 = array("UserPassword" => $UserPassword,
								 "Rs"=> '');
//			print_r($data1); die();
			
			$update = $this->Login_model->master_fun_update_2("AdminMaster", $id1, $data2);
//			print_r($update); die();
			$this->session->set_flashdata('success','Your Password Reset'); 
		redirect('login', 'refresh');
		}
			
  }
    function view_profile() {
        $token = $this->input->get_post('token');
        if ($token != null) {
            $data = $this->service_model->view_profile($token);
            echo $this->json_data("1", "", $data);
        } else {

            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
    public function employee_detail() {
        $token = $this->input->get_post('token');
        if ($token != "") {
              $data = $this->service_model->master_fun_get_tbl_val_2("shadminmaster", array("token" => $token, "status" => 1), array("id", "asc"));
		     if ($data) {
				$data = $this->service_model->employee_detail("shadminmaster", array( "type" => 2,  "status" => 1), array("id", "asc"));
                echo $this->json_data("1", "", $data);
            } else {
                echo $this->json_data("0", "Token expired. Please login again.", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
    function edit_profile() {
        $token = $this->input->get_post('token');
		//echo $user_id;
        $name = $this->input->get_post('name');
        $email = $this->input->get_post('email');
        $mobile = $this->input->get_post('mobile');
		//print_r($_POST); die();
        if ($token != "" && $name != "" && $email != "" && $mobile != "") {
			$list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
			//print_r($list);
			if($list){
            $user = $this->service_model->userlist_active_record($token);
				
			if($user){
				
		$email2 =  $user[0]['AdminEmail'];
				
            if ($email2 == $email) {
				
				//print_r("<pre>");	print_r($user); die();
                $data = array(
                    "AdminName" => $name,
                    "AdminEmail" => $email,
                    "AdminMNumber" => $mobile,
                );
               
                $update = $this->service_model->master_fun_update("shadminmaster", $token, $data);
                if ($update) {
                    echo $this->json_data("1", "Your Profile has been Updated","" );
                }}
				else {
                $row = $this->service_model->master_num_rows("shadminmaster", array("AdminEmail" => $email, "status" => 1));
                if ($row == 0) {
                    $data = array(
                    "AdminName" => $name,
                    "AdminEmail" => $email,
                    "AdminMNumber" => $mobile,
                );
                
                    $update = $this->service_model->master_fun_update("shadminmaster", $token, $data);
                    if ($update) {
                        echo $this->json_data("1", "Your Profile has been Updated","" );
					//	array(array("msg" => "Your Profile has been Updated"))
                    }
                } else {
                    echo $this->json_data("0", "Email Already Registered", "");
                }
            }
            } 
        }  else {
            echo $this->json_data("0", "Token expired. Please login again.", "");
        }
			}  else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
	function add_details() {
        $token = $this->input->get_post('token');
        $date2 = $this->input->get_post('date');
        $data = $this->input->get_post('data');
       $pamoutnew = json_decode($data, TRUE);
	//	 print_r($pamoutnew); die();
		$myJSON = json_encode($_POST);	
		 $datap = $myJSON;
//	echo "<pre>";	print_r($datap);
		$time =  $date = date('Y-m-d H:i:s');
       // $pic = $this->input->get_post('pic');
        if ($token != "" && $datap != "" && $date2 != "" && $data != "" ) {
			$list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
//			print_r($list);
//			die();
			if($list){
			$id =	$list[0]['id']; 
			//print_r($insert); die();
				$data1 = array();
					$data1 = array(
					"UserId" => $id,
					"date" => $date2);
			$insertid = $this->service_model->master_insert("ShDailyReadingDetails",$data1);
			if($pamoutnew != ""){
				foreach($pamoutnew as $row){
					
				
						$fuelType = $row['fuelType'];
					//print_r($fuelType);
					if($fuelType == 'p' || $fuelType == 'd' ){
						//echo"<pre>";	print_r($row); 
				$pump_id = $row['id'];
				$fuelType = $row['fuelType'];
				$reading = $row['value'];				
					$data1 = array();
					$data1 = array(
					"UserId" => $id,
					"RDRId" => 	$insertid,
					"Type"=> $fuelType,
					"date" => $date2,
					"PumpId" => $pump_id,
					"Reading" => $reading,
					"created_at"=>$time);
					$insert = $this->service_model->master_insert("shreadinghistory",$data1);
					
				}elseif($fuelType == 'tp'  ){
			//	echo"<pre>";	print_r($row); 
						
						$reading = $row['value'];
						$datapump = array();
					$datapump = array(
					"UserId" => $id,
					"PatrolReading" => $reading,
					"created_at"=>$time);		
//				$insert = $this->service_model->master_insert("ShDailyReadingDetails",$data1);
				$update = $this->service_model->master_fun_updatforid("ShDailyReadingDetails", $insertid, $datapump);
					}
					elseif($fuelType == 'td'  ){
			//	echo"<pre>";	print_r($row); 
						
						$reading = $row['value'];
						$datapump = array();
					$datapump = array(
					"UserId" => $id,
					"DieselReading" => $reading,
					"created_at"=>$time);		
//				$insert = $this->service_model->master_insert("ShDailyReadingDetails",$data1);
				$update = $this->service_model->master_fun_updatforid("ShDailyReadingDetails", $insertid, $datapump);
					}
					elseif($fuelType == 'tpdeep'  ){
                        
                        $reading = $row['value'];
                        $datapump = array();
                    $datapump = array(
                    "UserId" => $id,
                    "totalpetrol" => $reading,
                    "created_at"=>$time);       
//              $insert = $this->service_model->master_insert("ShDailyReadingDetails",$data1);
                $update = $this->service_model->master_fun_updatforid("ShDailyReadingDetails", $insertid, $datapump);
                    }
                    elseif($fuelType == 'tddeep'  ){
            //  echo"<pre>";    print_r($row); 
                        
                        $reading = $row['value'];
                        $datapump = array();
                    $datapump = array(
                    "UserId" => $id,
                    "totaldisel" => $reading,
                    "created_at"=>$time);       
//              $insert = $this->service_model->master_insert("ShDailyReadingDetails",$data1);
                $update = $this->service_model->master_fun_updatforid("ShDailyReadingDetails", $insertid, $datapump);
                    }
				}
			
				 echo $this->json_data("1", "Your Details has been Updated", "");
			}
			}else{
				 echo $this->json_data("1", " Token expired. Please login again.", "");
			}
			 die();
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
	function add_expense() {
        $token = $this->input->get_post('token');
        $date2 = $this->input->get_post('date');
        $data = $this->input->get_post('data');
//		print_r($data); die();
       $pamoutnew = json_decode($data, TRUE);
	//	 print_r($pamoutnew); die();
		$myJSON = json_encode($_POST);	
		 $datap = $myJSON;
//		print_r($datap); 
//	echo "<pre>";	print_r($datap);
		$time =  $date = date('Y-m-d H:i:s');

        if ($token != "" && $datap != "" && $date2 != "" && $data != "" ) {
			$list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));

//			die();
			if($list){
			$id =	$list[0]['id']; 
			//print_r($insert); die();
				$data1 = array();
					$data1 = array(
					"user_id" => $id,
					"date" => $date2);
			$insertid = $this->service_model->master_insert("sh_expensein_details",$data1);
			if($pamoutnew != ""){
				
				foreach($pamoutnew as $row){
					$ex_id = $row['id'];
					$ex_value = $row['value'];

					$data = array();
					$data = array(
					"UserId" => $id,
					"ex_id" => 	$insertid,
					"expensein_id"=> $ex_id,
					"value" => $ex_value,
					"date" => $date2,
					"created_at"=>$time);
					
					$insert = $this->service_model->master_insert("sh_expensein_d_history",$data);
				}
			
				 echo $this->json_data("1", "Your Details has been Updated", "");
			}
			}else{
				 echo $this->json_data("1", " Token expired. Please login again.", "");
			}
			 die();
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
	function dailyprice_add()
    {
        $this->load->model('service_model');
        $token = $this->input->get_post('token');
        $date = $this->input->get_post('date');
        $pet_price = $this->input->get_post('pet_price');
        $dis_price = $this->input->get_post('dis_price');
        
        if($token != "" && $date != "" && $pet_price != "" && $dis_price != "")
        {
            $list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
            if($list)
            {

                $id = $list[0]['id']; 
                date_default_timezone_set('Asia/Kolkata');
                $data =  array();

                $data = array(
                                'user_id' => $id,
                                'date' => $date,
                                'pet_price' => $pet_price,
                                'dis_price' => $dis_price,
                                'created_date' => date("Y-m-d H:i:sa") 
                             );
                $insert = $this->service_model->master_insert("sh_dailyprice",$data);
                echo $this->json_data("1","Your Data submitted successfully","");

            }
            else
            {
                echo $this->json_data("1", "Token expired. Please Login again","");
            }
        }
        else
        {
            echo $this->json_data("0","Parameter Not passed","");
        }
    }
//	function add_details1() {
//        $token = $this->input->get_post('token');
//        $PatrolReading = $this->input->get_post('PatrolReading');
//        $DieselReading = $this->input->get_post('DieselReading');
//        $meterReading = $this->input->get_post('meterReading');
//        $TotalCash = $this->input->get_post('TotalCash');
//        $TotalCredit = $this->input->get_post('TotalCredit');
//        $pamout = $this->input->get_post('pamout');        
//        $TotalExpenses = $this->input->get_post('TotalExpenses');
//        $TotalAmount = $this->input->get_post('TotalAmount');
//		$pamoutnew = json_decode($pamout, TRUE);
//		$myJSON = json_encode($_POST);
//		$datap = $myJSON;
//		$time =  $date = date('Y-m-d H:i:s');
//		if ($token != "" && $PatrolReading != "" && $DieselReading != "" && $meterReading != "" && $TotalCash != "" && $TotalCredit != "" && $TotalExpenses != "" && $TotalAmount != "" && $pamout != "") {
//			$list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
//			if($list){
//			$id =	$list[0]['id']; 
//            $data = array(
//                "UserId" => $id,
//                "PatrolReading" => $PatrolReading,
//                "DieselReading" => $DieselReading,
//                "meterReading" => $meterReading,
//                "TotalCash" => $TotalCash,
//                "TotalCredit" => $TotalCredit,
//                "TotalExpenses" => $TotalExpenses,
//                "TotalAmount" => $TotalAmount,
//                "data" => $datap,
//				"created_at"=>$time
//            );
//			$insert = $this->service_model->master_insert("ShDailyReadingDetails",$data);
//			$RDRId = $insert;
//			if($pamout != ""){
//				foreach($pamoutnew as $row){
//				$id = $row['pump_id'];
//				$type = $row['type'];
//				$reading = $row['reading'];
//				$pump_id = $row['pump_id'];
//					$data1 = array();
//					$data1 = array(
//					"RDRId" => $RDRId,
//					"Type"=> $type,
//					"PumpId" => $pump_id,
//					"Reading" => $reading,
//					"created_at"=>$time);
//					$insert = $this->service_model->master_insert("shreadinghistory",$data1);
//				}
//				 echo $this->json_data("1", "Your Details has been Updated", "");
//			}
//			}else{
//				 echo $this->json_data("1", " Token expired. Please login again.", "");
//			}
//        } else {
//            echo $this->json_data("0", "Parameter not passed", "");
//        }
//    }
	function add_inventory()
    {
        $this->load->model('Service_model');

        $token = $this->input->get_post('token');
        $date2 = $this->input->get_post('date');
        // petrol inventory
        $pi_number = $this->input->get_post('pi_number');
        $p_fuelamount = $this->input->get_post('p_fuelamount');
        $pv_taxamount = $this->input->get_post('pv_taxamount');
        $p_paymenttype = $this->input->get_post('p_paymenttype');
        $p_chequenumber = $this->input->get_post('p_chequenumber');
        $p_paidamount = $this->input->get_post('p_paidamount');
        $p_quantity = $this->input->get_post('p_quantity');
        $p_tankerreading = $this->input->get_post('p_tankerreading');

        // Disel inventory
        $di_number = $this->input->get_post('di_number');
        $d_fuelamount = $this->input->get_post('d_fuelamount');
        $dv_taxamount = $this->input->get_post('dv_taxamount');
        $d_paymenttype = $this->input->get_post('d_paymenttype');
        $d_chequenumber = $this->input->get_post('d_chequenumber');
        $d_paidamount = $this->input->get_post('d_paidamount');
        $d_quantity = $this->input->get_post('d_quantity');
        $d_tankerreading = $this->input->get_post('d_tankerreading');

        // Oil inventory
        $oil_type = $this->input->get_post('oil_type');
        $o_quantity = $this->input->get_post('o_quantity');

        if($token != "" && $pi_number != "" && $p_fuelamount != "" && $pv_taxamount != "" && $p_paymenttype != "" && $p_paidamount != "" && $p_quantity != "" && $p_tankerreading != "" && $di_number != "" && $d_fuelamount != "" && $dv_taxamount != "" && $d_paymenttype != ""  && $d_paidamount != "" && $d_quantity != "" && $d_tankerreading != "" && $oil_type != "" && $o_quantity  != "" && $date2 != "")
        {
            $list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
			
            if ($list)
            {
				$id =	$list[0]['id']; 
                date_default_timezone_set('Asia/Kolkata');
                $data =  array();

                $data = array(
                                'user_id' => $id,
                                'pi_number' => $pi_number,
                                'p_fuelamount' => $p_fuelamount,
                                'pv_taxamount' => $pv_taxamount,
                                'p_paymenttype' => $p_paymenttype,
                                'p_chequenumber' => $p_chequenumber,
                                'p_paidamount' => $p_paidamount,
                                'p_quantity' => $p_quantity,
                                'p_tankerreading' => $p_tankerreading,
                                'di_number' => $di_number,
                                'd_fuelamount' => $d_fuelamount,
                                'dv_taxamount' => $dv_taxamount,
                                'd_paymenttype' => $d_paymenttype,
                                'd_chequenumber' => $d_chequenumber,
                                'd_paidamount' => $d_paidamount,
                                'd_quantity' => $d_quantity,
                                'd_tankerreading' => $d_tankerreading,
                                'oil_type' => $oil_type,
                                'o_quantity' => $o_quantity,
                                'date' => $date2,
                                'created_date' => date("Y-m-d H:i:sa") 
                             );
                $insert = $this->service_model->master_insert("sh_inventory",$data);
                echo $this->json_data("1","Your Data submitted successfully","");

            }
            else
            {
                echo $this->json_data("1", "Token expired. Please Login again. ", "");
            }
        }
        else
        {
            echo $this->json_data("0","Parameter Not passed","");
        }
    }
	function update_details() {
        $token = $this->input->get_post('token');
        $PatrolReading = $this->input->get_post('PatrolReading');
        $DieselReading = $this->input->get_post('DieselReading');
        $meterReading = $this->input->get_post('meterReading');
        $TotalCash = $this->input->get_post('TotalCash');
        $TotalCredit = $this->input->get_post('TotalCredit');
        $TotalExpenses = $this->input->get_post('TotalExpenses');
        $TotalAmount = $this->input->get_post('TotalAmount');
        $Pdetailnew = $this->input->get_post('Pdetails');
        $idnew = $this->input->get_post('id');
        $shidnew = $this->input->get_post('pid');
        $type = $this->input->get_post('type');
		
       $pamoutnew = json_decode($pamout, TRUE);
	//	 print_r($pamoutnew); die();
		$myJSON = json_encode($_POST);
		
		 $datap = $myJSON;
		//print_r($datap);
		$time =  $date = date('Y-m-d H:i:s');
       // $pic = $this->input->get_post('pic');
        if ($token != "" && $PatrolReading != "" && $DieselReading != "" && $meterReading != "" && $TotalCash != "" && $TotalCredit != "" && $TotalExpenses != "" && $TotalAmount != "" && $pamout != "") {
			$list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
			//print_r($list);
			if($list){
			$id =	$list[0]['id']; 
            $data = array(
              
                "UserId" => $id,
                "PatrolReading" => $PatrolReading,
                "DieselReading" => $DieselReading,
                "meterReading" => $meterReading,
                "TotalCash" => $TotalCash,
                "TotalCredit" => $TotalCredit,
                "TotalExpenses" => $TotalExpenses,
                "TotalAmount" => $TotalAmount,
                "data" => $datap,
				"created_at"=>$time
            );
          
			$insert = $this->service_model->master_insert("ShDailyReadingDetails",$data);
			$RDRId = $insert;
			//print_r($insert); die();
			
			if($pamout != ""){
				foreach($pamoutnew as $row){
				//echo"<pre>";	print_r($row); 
				$id = $row['pump_id'];
				$type = $row['type'];
				$reading = $row['reading'];
				$pump_id = $row['pump_id'];
					$data1 = array();
					$data1 = array(
					"RDRId" => $RDRId,
					"Type"=> $type,
					"PumpId" => $pump_id,
					"Reading" => $reading,
					"created_at"=>$time);
					$insert = $this->service_model->master_insert("shreadinghistory",$data1);
					
				}
			
				 echo $this->json_data("1", "Your Details has been Updated", "");
			}
			}else{
				 echo $this->json_data("1", " Token expired. Please login again.", "");
			}
			
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function change_password() {
        $token = $this->input->get_post('token');
        $oldpassword = $this->input->get_post('oldpassword');
        $password = $this->input->get_post('password');
        if ($token != "" && $password != "" && $oldpassword != "") {
			$data2 = $this->service_model->master_fun_get_tbl_val_2("shadminmaster", array("token" => $token, "status" => 1), array("id", "asc"));
			if($data2){
            $row = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "asc"));
            $oldpass = $row[0]['AdminPassword'];
            if ($oldpassword == $oldpass) {
                $data = array(
                    "AdminPassword" => $password,
                );
                $update = $this->service_model->master_fun_update("shadminmaster", $token, $data);
                if ($update) {
                    echo $this->json_data("1", "Your Password has been Updated","");
                }
            } else {
                echo $this->json_data("0", "old password not match", "");
            }
		}else{
                echo $this->json_data("0", "Token expired. Please login again.", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function json_data($status, $error_msg, $data = NULL) {
        if ($data == NULL) {
            $data = array();
        }
        $final = array("status" => $status, "error_msg" => $error_msg, "data" => $data);
        return str_replace("null", '" "', json_encode($final));
    }

	function send_notification($tokens, $msg) {
        $url = "https://fcm.googleapis.com/fcm/send";
        $fields = array
            (
            'registration_ids' => $registrationIds,
            'data' => $msg
        );
        $headers = array
            (
            'Authorization: key=AIzaSyAPDjH6uvd1ek2mNbQPUVu9FH9qTnmR7hk',
            'Content-Type: Squadlilication/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result == FALSE) {
            die('Curl failed:' . curl_error($ch));
        }
        curl_close($ch);
        echo $result;
    }

    function test() {
        $tokens = array('-KLz0LmqbBfaRWxz4Nrt');
        $message = array('message' => 'here is a message. message',
            'title' => 'This is a title. title',
            'subtitle' => 'This is a subtitle. subtitle',
            'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
            'vibrate' => 1,
            'sound' => 1,
            'largeIcon' => 'large_icon',
            'smallIcon' => 'small_icon');
        $message_status = send_notification($tokens, $message);
        echo $message_status;
    }

    function gcm() {
        $user_id = $this->input->get_post('user_id');
        $device_id = $this->input->get_post('device_id');
        $type = $this->input->get_post('type');
        if ($user_id != NULL && $device_id != NULL && $type != NULL) {
            $update = $this->service_model->device_update("customer_master", $device_id, array("device_id" => "", "device_type" => ""));
            $update = $this->service_model->master_fun_update("customer_master", $user_id, array("device_id" => $device_id, "device_type" => $type));

            echo $this->json_data("1", "", array(array("msg" => "Your Device Id Saved")));
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function testgcm() {
        $device_id = 'APA91bHqu4emQq_Mq6EyLYX1WlS_U3Z8wcJmVwtl5-VVjj8nXkH-bldsxlyCUfHmK2UTziu3OEgrNchgtm4AG19LAbufedn9XoF90YlQuFsd7U_wqPUVep3VizEMk34jwbn0iFEkwQIK';
        $notification_data = array("title" => "TEAM Squadli", "message" => "notification message");
        print_r($notification_data);
        $pushServer = new PushServer();
        $test = $pushServer->pushToGoogle(array($device_id), $notification_data);
        echo $test;
    }
	public function success($amount) {
		$data['amount']=$this->input->get('amount');
        $this->load->view('success', $data);
    }

    public function indexstripe($id,$pid) {
        $data["stripe"] = $this->service_model->master_fun_get_tbl_val("stripe", array("id" => '1'), array("id", "asc"));
		$data["stripe_package"] = $this->service_model->master_fun_get_tbl_val("stripe_package", array("id" => $pid), array("id", "asc"));
		
        if ($id != NULL) {
            $data['user_id'] = $id;
            $this->load->view('index', $data);
        } else {
            echo "usernot available";
        }
    }
	public function indexpackage($id) {
		$packa_select = $this->service_model->user_select_pack($id);
		if($packa_select){
			$data['package_id'] = $packa_select->package_id;
		}else{
			$data['package_id'] = "";
		}
        //$data["stripe"] = $this->service_model->master_fun_get_tbl_val("stripe_packege", array("startus" => '1'), array("id", "asc"));
        if ($id != NULL) {
            $data['user_id'] = $id;
            $this->load->view('index_package', $data);
        } else {
            echo "usernot available";
        }
    }

    public function checkout() {
        try {
            require_once(SquadliPATH . 'libraries/Stripe/lib/Stripe.php'); //or you
            Stripe::setApiKey("sk_test_MbciDAILpQhIYz2s9023qUN1"); //Replace with your Secret Key
            require_once(SquadliPATH . 'libraries/Stripe/lib/Charge.php'); //or you
            $charge = Stripe_Charge::create(array(
                        "amount" => 10000,
                        "currency" => "usd",
                        "card" => $_POST['stripeToken'],
                        "description" => "Demo Transaction"
            ));
            echo "<h1>Your payment has been completed.</h1>";
        } catch (Stripe_CardError $e) {
            
        } catch (Stripe_InvalidRequestError $e) {
            
        } catch (Stripe_AuthenticationError $e) {
            
        } catch (Stripe_ApiConnectionError $e) {
            
        } catch (Stripe_Error $e) {
            
        } catch (Exception $e) {
            
        }
    }
	public function mail_demo(){
		$this->load->helper(array('swift'));
		$email="vishal@virtualheight.com";	
		
     $message='<div style="background:#fff; border:1px solid #ccc; padding:2px 30px"><img alt="" src="http://ec2-52-62-23-230.ap-southeast-2.compute.amazonaws.com/user_assets/images/logo.png" /></div>

<div style="background:#fff; border:1px solid #ccc; padding:30px">
<h1>Dear {{name}} ,</h1>

<h3>Welcome to TenderSeek, please see below your login and password details. TenderSeek provides daily updates of tender advertisments from over 2500 media channels across Australia. Your business email profile selected by you can be updated at any time by logging into your account, we suggest you monitor and make adjustments in the initial few months to ensure all opportunties matching your business expertise is captured. &nbsp; &nbsp;</h3>

<table cellpadding="10">
	<tbody>
		<tr>
			<th>Username :</th>
			<td>{{username}}</td>
		</tr>
		<tr>
			<th>Password :</th>
			<td>{{password}}</td>
		</tr>
		<tr>
			<td colspan="2">
			<p><a href="http://ec2-52-62-23-230.ap-southeast-2.compute.amazonaws.com/user_master/index">Login</a></p>

			<p>&nbsp;</p>

			<p>Kind Regards</p>

			<p>TenderSeek&nbsp;</p>

			<p>&nbsp;</p>
			</td>
		</tr>
	</tbody>
</table>
</div>
';    
			
	  send_mail($email,'test mail tender',$message);
	  echo $message;
	}
	function database_backup() {
	
            $this->load->dbutil();

  $prefs = array( 'format' => 'sql', // gzip, zip, txt 
                               'filename' => 'Translance_backup'. date('Y-m-d H-i').'sql', 
                                                      // File name - NEEDED ONLY WITH ZIP FILES 
                                'add_drop' => TRUE,
                                                     // Whether to add DROP TABLE statements to backup file
                               'add_insert'=> TRUE,
                                                    // Whether to add INSERT data to backup file 
                               'newline' => "\n"
                                                   // Newline character used in backup file 
                              ); 
            $backup = $this->dbutil->backup($prefs);
  
            $this->load->helper('file');
            $path = './upload/' . date('Y-m-d-H-i') . '.sql';
           // $file = write_file($path, $backup);
			if ( ! write_file($path, $backup))
					{
							echo 'Unable to write the file';
					}else{
            $this->service_model->drop_tbl('admin_master');
			$this->service_model->drop_tbl('alldata');
			$this->service_model->drop_tbl('award_master');
			$this->service_model->drop_tbl('customer_master');
			$this->service_model->drop_tbl('emotion_award_master');
			$this->service_model->drop_tbl('emotion_master');
			
			$this->service_model->drop_tbl('help_master');
			$this->service_model->drop_tbl('menu_master');
			$this->service_model->drop_tbl('objective_master');
			$this->service_model->drop_tbl('objective_rank_master');
			$this->service_model->drop_tbl('payment');
			$this->service_model->drop_tbl('referral_team');
			
			$this->service_model->drop_tbl('stripe');
			$this->service_model->drop_tbl('stripe_package');
			$this->service_model->drop_tbl('team_master');
			$this->service_model->drop_tbl('team_member_master');
			$this->service_model->drop_tbl('user_permission');
			$this->service_model->drop_tbl('user_type_master');
					}
       
    }
	function only_db(){
		echo "<a href='".base_url()."Service/database_backup'>click Here</a>";
	}

    // get user data from userlist table
    function user_list(){
        $token = $this->input->get_post('token');
        if ($token != "") 
        {
                $list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
                if ($list) 
                {
                    $data = $this->service_model->get_user_list();
                    echo $this->json_data("1", "", $data);
                }
                else
                {
                    echo $this->json_data("1","Token expired. Please login again","");
                }    
        }
        else
        {
            echo $this->json_data("0","Parameter not passed","");
        }
        

    }
    // insert data into bank deposit table
    function bank_deposit()
    {
        $token = $this->input->get_post('token');
        $date = $this->input->get_post('date');
        $deposit_amount = $this->input->get_post('deposit_amount');
        $withdraw_amount = $this->input->get_post('withdraw_amount');

        if($token != "" && $date != "" && $deposit_amount != "" && $withdraw_amount !="")
        {
            $list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
            if($list)
            {
                $id = $list[0]['id']; 
                date_default_timezone_set('Asia/Kolkata');
                $data =  array();

                $data = array(
                                'user_id' => $id,
                                'date' => $date,
                                'deposit_amount' => $deposit_amount,
                                'withdraw_amount' => $withdraw_amount,
                                'created_by' => date("Y-m-d H:i:sa") 
                             );
                $insert = $this->service_model->master_insert("sh_bankdeposit",$data);
                echo $this->json_data("1","Your Data submitted successfully","");
            }
            else
            {
                echo $this->json_data("1","token expired. please login again","");
            }
        }
        else
        {
            echo $this->json_data("0","Parameter Not passed","");
        }
    }
    // insert data into online transaction table
    function online_transaction()
    {
        $token = $this->input->get_post('token');
        $date = $this->input->get_post('date');
        $invoice_no = $this->input->get_post('invoice_no');
        $customer_name = $this->input->get_post('customer_name');
        $amount = $this->input->get_post('amount');
        $paid_by = $this->input->get_post('paid_by');
        $cheque_tras_no = $this->input->get_post('cheque_tras_no');
        
        if ($token != "" && $date != "" && $invoice_no != "" && $customer_name != "" && $amount != "" && $paid_by != "" && $cheque_tras_no != "") {
            
            $list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) 
            {
                $id = $list[0]['id']; 
                date_default_timezone_set('Asia/Kolkata');
                $data =  array();

                $data = array(
                                'user_id' => $id,
                                'date' => $date,
                                'invoice_no' => $invoice_no,
                                'customer_name' => $customer_name,
                                'amount' => $amount,
                                'paid_by' => $paid_by,
                                'cheque_tras_no' => $cheque_tras_no,
                                'created_by' => date("Y-m-d H:i:sa") 
                             );
                $insert = $this->service_model->master_insert("sh_onlinetransaction",$data);
                echo $this->json_data("1","Your Data submitted successfully","");   
            }
            else
            {
                echo $this->json_data("1","Token expired. Please login again", "");
            }
        }
        else
        {
            echo $this->json_data("0", "Parameter Not passed", "");
        }
    }

}

?>
