<?php

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
       $this->load->model('service_model');
        //$this->load->model('service_model');
        $this->load->model('login_model');
	//	$this->load->model('Login_model');
        $this->load->helper('security');
        $this->load->helper('string');
		$this->load->helper(array('swift'));
        $this->load->library('email');
       // $this->load->library('pushserver');
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

    function edit_profile1() {
        $user_fk = $this->input->get_post('user_id');
        $name = $this->input->get_post('name');
        $email = $this->input->get_post('email');
        $mobile = $this->input->get_post('mobile');
        $address = $this->input->get_post('address');
        $gender = $this->input->get_post('gender');
        $country = $this->input->get_post('country');
        $state = $this->input->get_post('state');
        $city = $this->input->get_post('city');
        $pic = $this->input->get_post('pic');
        if ($user_fk != "" && $name != "" && $email != "" && $mobile != " ") {
            $data = array(
                "pic" => $pic,
                "full_name" => $name,
                "email" => $email,
                "mobile" => $mobile,
                "address" => $address,
                "gender" => $gender,
                "country" => $country,
                "state" => $state,
                "city" => $city,
            );
            $update = $this->service_model->master_fun_update("customer_master", $user_fk, $data);
            if ($update) {
                echo $this->json_data("1", "Your Profile has been Updated","");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
	function add_details() {
        $token = $this->input->get_post('token');
        $data = $this->input->get_post('data');
       $pamoutnew = json_decode($data, TRUE);
	//	 print_r($pamoutnew); die();
		$myJSON = json_encode($_POST);	
		 $datap = $myJSON;
//	echo "<pre>";	print_r($datap);
		$time =  $date = date('Y-m-d H:i:s');
       // $pic = $this->input->get_post('pic');
        if ($token != "" && $datap != "") {
			$list = $this->service_model->master_fun_get_tbl_val("shadminmaster", array("token" => $token, "status" => 1), array("id", "id"));
//			print_r($list);
//			die();
			if($list){
			$id =	$list[0]['id']; 
			//print_r($insert); die();
				$data1 = array();
					$data1 = array(
					"UserId" => $id,);
			$insertid = $this->service_model->master_insert("shdailyReadingdetails",$data1);
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
//				$insert = $this->service_model->master_insert("shdailyReadingdetails",$data1);
				$update = $this->service_model->master_fun_updatforid("shdailyReadingdetails", $insertid, $datapump);
					}
					elseif($fuelType == 'td'  ){
			//	echo"<pre>";	print_r($row); 
						
						$reading = $row['value'];
						$datapump = array();
					$datapump = array(
					"UserId" => $id,
					"DieselReading" => $reading,
					"created_at"=>$time);		
//				$insert = $this->service_model->master_insert("shdailyReadingdetails",$data1);
				$update = $this->service_model->master_fun_updatforid("shdailyReadingdetails", $insertid, $datapump);
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
          
			$insert = $this->service_model->master_insert("shdailyReadingdetails",$data);
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

	
	function reading_list() {
			$date1 =$this->input->get_post("to");
	  		$date2 =$this->input->get_post("form");
	  		$Employeename =$this->input->get_post("Employeename");
		 $token = $this->input->get_post('token');
		if ($token != "") {
            $data = $this->service_model->master_fun_get_tbl_val_2("shadminmaster", array("token" => $token, "status" => 1), array("id", "asc"));
			if ($data) {
          	 if ($date1 !='' || $date2 != '' || $Employeename != ""){
		$result = $this->service_model->select_reading_list($date1,$date2,$Employeename); 
				 $row = array();
				 $final =array ();
				 foreach ($result as $row) {
					 $id = $row['id'];
					 
					  $result2 = $this->service_model->manufacture_get_record('shreadinghistory',array('RDRId'=> $id)); 
						//echo"<pre>"; print_r($result2);
					$row['deayal'] =$result2;
						array_push($final,$row);
					 }
				
				 echo $this->json_data("1", "", $final);
			 }else{
					$result = $this->service_model->shdailyreadingdetails_active_record_service();
			 $row = array();
				 $final =array ();
				 foreach ($result as $row) {
					 $id = $row['id'];
					 
					  $result2 = $this->service_model->manufacture_get_record('shreadinghistory',array('RDRId'=> $id)); 
						//echo"<pre>"; print_r($result2);
					$row['deayal'] =$result2;
						array_push($final,$row);
					 }
				 echo $this->json_data("1", "", $final);
				
			 }
				} else {
                echo $this->json_data("0", "Token expired. Please login again.", "");
            }
		} else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
		
		
		
    	
	}

    function join_team() {
        $code = $this->input->get_post('code');
        $user_id = $this->input->get_post('user_id');
        if ($code != NULL && $user_id) {
            $row = $this->service_model->master_num_rows("team_member_master", array("user_id" => $user_id, "status" => 1));
            if ($row == 0) {
                $team = $this->service_model->get_by_id("id,name,manager_id", "team_master", array("status" => "1", "code" => $code));
                if ($team) {
                    $team_id = $team->id;
                    $team_name = $team->name;
                    $manager = $team->manager_id;
                    $payment = $this->service_model->get_by_id("payment", "customer_master", array("status" => "1", "id" => $manager));
                    if ($payment->payment == '1') {
                        $row = $this->service_model->master_num_rows("team_member_master", array("user_id" => $user_id, "status" => 1, "team_id" => $team_id));
                        if ($row == 0) {
                            $insert = $this->service_model->master_fun_insert("team_member_master", array("user_id" => $user_id, "team_id" => $team_id));
                            echo $this->json_data("1", "", array(array("id" => "$insert", "team_id" => "$team_id", "team_name" => "$team_name")));
                            $device = $this->service_model->get_by_id("device_id,device_type", "customer_master", array("status" => "1", "id" => $team->manager_id));
                            $usersetail = $this->service_model->get_by_id("name", "customer_master", array("status" => "1", "id" => $user_id));
                            $username = ucwords($usersetail->name);
                            if ($device->device_type == 'android') {
                                $device_id = array($device->device_id);
                                $notification_data = array("title" => "TEAM Squadli", "message" => "$username is Join $team_name Team");
                                $pushServer = new PushServer();
                                $pushServer->pushToGoogle($device_id, $notification_data);
                            }
							if($device->device_type=='IOS'){
								$device_id = $device->device_id;
								$message = $username." is Join ".$team_name." Team";
								$url = 'http://website-demo.in/teamSquadli/push.php?device_id='.$device_id.'&message='.$message;
								$url = str_replace(" ","%20",$url);
								$data = $this->get_content($url);
								$data2 = json_decode($data);
							}
                        } else {
                            echo $this->json_data("0", "User Allready Join Team", "");
                        }
                    } else {
                        $teammember = $this->service_model->master_num_rows("team_member_master", array("status" => 1, "team_id" => $team_id));
                        //echo $teammember; die();
                        if ($teammember < 6) {
                            $row = $this->service_model->master_num_rows("team_member_master", array("user_id" => $user_id, "status" => 1, "team_id" => $team_id));
                            if ($row == 0) {
                                $insert = $this->service_model->master_fun_insert("team_member_master", array("user_id" => $user_id, "team_id" => $team_id));
                                echo $this->json_data("1", "", array(array("id" => "$insert", "team_id" => "$team_id", "team_name" => "$team_name")));
                                $device = $this->service_model->get_by_id("device_id", "customer_master", array("status" => "1", "id" => $team->manager_id));
                                $usersetail = $this->service_model->get_by_id("name", "customer_master", array("status" => "1", "id" => $user_id));
                                $username = ucwords($usersetail->name);
                                if ($device->device_type == 'android') {
                                    $device_id = array($device->device_id);
                                    $notification_data = array("title" => "TEAM Squadli", "message" => "$username is Join $team_name Team");
                                    $pushServer = new PushServer();
                                    $pushServer->pushToGoogle($device_id, $notification_data);
                                }
								if($device->device_type=='IOS'){
									$device_id = $device->device_id;
									$message = $username." is Join ".$team_name." Team";
									$url = 'http://website-demo.in/teamSquadli/push.php?device_id='.$device_id.'&message='.$message;
									$url = str_replace(" ","%20",$url);
									$data = $this->get_content($url);
									$data2 = json_decode($data);
								}
                            } else {
                                echo $this->json_data("0", "User Already Join Team", "");
                            }
                        } else {
                            echo $this->json_data("0", "Maximum 5 Member Allowed Please Contact TO Manager", "");
                        }
                    }
                } else {
                    echo $this->json_data("0", "Code Is Invalid ", "");
                }
            } else {
                echo $this->json_data("0", "User Already Join Team", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function send_invitation() {
        $code = $this->input->get_post('code');
        $name = $this->input->get_post('name');
        $email = $this->input->get_post('email');
		$email = strtolower($email);
        if ($code != NULL && $name != NULL && $email != NUll) {
            $team = $this->service_model->get_by_id("id,name", "team_master", array("status" => "1", "code" => $code));
            if ($team) {
                $row = $this->service_model->master_num_rows("customer_master", array("email" => $email, "status" => 1));
                $teamname = $team->name;
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $message = "Hello Dear $name.<br/><br/>";
                $message .= "You are Invition For Team Squadli of $teamname .<br/><br/>";
                $message .= "Team Code is $code .<br/><br/>";
                $message .= "Thanks <br/>";
                //$this->email->to($email);
                //$this->email->from('support@squadli.com', 'TEAM Squadli');
                //$this->email->subject("TEAM Squadli INVITATION");
                //$this->email->message($message);
                //$this->email->send();
				send_mail($email,'TEAM Squadli INVITATION',$message);
                echo $this->json_data("1", "", array("Invitation Send"));
            } else {
                echo $this->json_data("0", "Code Is Invalid ", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    public function objective_list() {
        $team_id = $this->input->get_post('team_id');
//
        if ($team_id != null) {
            $data = $this->service_model->get_by_id_list("id,name,description,img,color", "objective_master", array("status" => "1", "team_id" => $team_id));
            if ($data) {
                echo $this->json_data("1", "", $data);
            } else {
                echo $this->json_data("0", "Objective List Not Found", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    /*public function team_member_list() {
        $team_id = $this->input->get_post('team_id');
        $user_id = $this->input->get_post('user_id');
        if ($team_id != NULL && $user_id != NULL) {
            $team = $this->service_model->get_by_id("id,name", "team_master", array("status" => "1", "id" => $team_id));
            if ($team) {
                $list = $this->service_model->get_top_member_team($team_id, $user_id);
//			$list = $this->service_model->team_membe_list($team_id,$user_id);
                if ($list) {

                    $team->member_list = $list;

                    echo $this->json_data("1", "", array($team));
                } else {
                    echo $this->json_data("0", "No Member Available", "");
                }
            } else {
                echo $this->json_data("0", "Team Is Invalid ", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }*/
	public function team_member_list() {
		$finallist =array();
        $team_id = $this->input->get_post('team_id');
        $user_id = $this->input->get_post('user_id');
        if ($team_id != NULL && $user_id != NULL) {
            $team = $this->service_model->get_by_id("id,name", "team_master", array("status" => "1", "id" => $team_id));
			$final = array();
            if ($team) {
                $list = $this->service_model->get_top_member_team($team_id, $user_id);
				$type="";$self="";
				foreach ($list as $userlist) {
                    $rank = $this->service_model->rank($userlist->id, $type, $self);
                    $row = $this->service_model->rank_award($userlist->id, $type, $self);
                    $point = $rank->point;
                    $row = $row * 3;
                    $point = $point + $row;
                    if (!$point) {
                        $point = "0";
                    }
                    $topobj = $this->service_model->topobj($userlist->id, $type, $self);
                    $topaward = $this->service_model->topaward1($userlist->id, $type, $self);
                    $cntobj = count($topobj); 
                    $cntaward = count($topaward); 
                    if ($cntaward < $cntobj) {
                        $j = $cntobj;
                    } else {
                        $j = $cntaward;
                    }
					
                    $final = array();
                    for ($i = 0; $i < $j; $i++) {
                        $tobjid = $topobj[$i]->objective_id;
                        for ($ii = 0; $ii < $j; $ii++) {
                            if ($tobjid == $topaward[$ii]->objective_id) {
                                $sum = $topaward[$ii]->point + $topobj[$i]->point;
                                $temp = array("objid" => $topaward[$ii]->objective_id, "points" => $sum);
                                array_push($final, $temp);
                            }
                        }
                    }
					$testrank = array();
                    if (empty($final)) {

                        $temppoint = 0;
                        $tempobjectiv = 0;
                        foreach ($topobj as $topobj) {
                            if ($temppoint < $topobj->point) {
                                $temppoint = $topobj->point;
                                $tempobjectiv = $topobj->objective_id;
                            }
                        }
                        foreach ($topaward as $topobj) {
                            if ($temppoint < $topobj->point) {
                                $temppoint = $topobj->point;
                                $tempobjectiv = $topobj->objective_id;
                            }
                        }
                        $obj = $this->service_model->get_by_id("id,name,color,img", "objective_master", array("id" => $tempobjectiv));
                        if($obj)
                        	$obj->point = $temppoint;
                    } else {
                        $max = -9999999; //will hold max val
                        $found_item = null; //will hold item with max val;
                        foreach ($final as $k => $v) {
                            if ($v['points'] > $max) {
                                $max = $v['points'];
                                $found_item = $v;
                            }
                        }
                        array_push($testrank, array("teamuserid" => $userlist->id, "teamuserrank" => $max));
							
						foreach ($testrank as $testrank1) {
							if ($testrank1['teamuserid'] == $user_id) {
								break;
							}
								$rankcnt++;
							}				
						}
						$userlist->point=$rankcnt;
						array_push($finallist,$userlist);
                }
				
				
				$col  = 'point';
				$sort = array();
				foreach ($finallist as $i => $obj) {
				  $sort[$i] = $obj->{$col};
				}
				$sorted_db = array_multisort($sort, SORT_ASC, $finallist);
				
//			$list = $this->service_model->team_membe_list($team_id,$user_id);
                if ($list) {
                    $team->member_list = $finallist;

                    echo $this->json_data("1", "", array($team));
                } else {
                    echo $this->json_data("0", "No Member Available", "");
                }
            } else {
                echo $this->json_data("0", "Team Is Invalid ", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
    function test_upload() {
        echo form_open_multipart("service/upload_pic1", array("method" => "post", "role" => "form"));
        echo "<input type='file' name='userfile' />";

        echo "<input type='submit' name='test' value='upload'/>";
        echo "</form>";
    }

    public function user_detail() {
        $token = $this->input->get_post('token');
       // $team_id = $this->input->get_post('team_id');
        if ($token != "") {
            $data = $this->service_model->master_fun_get_tbl_val_2("shadminmaster", array("token" => $token, "status" => 1), array("id", "asc"));
			//print_r($data);
            
            if ($data) {
                echo $this->json_data("1", "", $data);
            } else {
                echo $this->json_data("0", "Token expired. Please login again.", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
	public function employee_detail() {
        $token = $this->input->get_post('token');
       // $team_id = $this->input->get_post('team_id');
        if ($token != "") {
              $data = $this->service_model->master_fun_get_tbl_val_2("shadminmaster", array("token" => $token, "status" => 1), array("id", "asc"));
			//print_r($data);
            
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
        
        $type = $this->input->get_post('type');
		//print_r($_POST); die();
        if ($token != "" && $name != "" && $email != "" && $mobile != "" && $type != NULL) {
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
                    "type" => $type,
                );
               
                $update = $this->service_model->master_fun_update("shadminmaster", $token, $data);
                if ($update) {
                    echo $this->json_data("1", "Your Profile has been Updated","" );
                }}
				else {
				//print_r($email);
				//print_r($user);
                $row = $this->service_model->master_num_rows("shadminmaster", array("AdminEmail" => $email, "status" => 1));
                if ($row == 0) {
                    $data = array(
                    "AdminName" => $name,
                    "AdminEmail" => $email,
                    "AdminMNumber" => $mobile,
                    "type" => $type,
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

//////////////////////////////////////////////////end vishal 28-06-2016//////////////////////////////////////////////
//////////////////////////////////////////////////Start vishal 02-07-2016//////////////////////////////////////////////
    public function create_objective() {
        $name = $this->input->get_post('name');
        $description = $this->input->get_post('description');
        $color = $this->input->get_post('color');
        $team_id = $this->input->get_post('team_id');
        $user_id = $this->input->get_post('user_id');
        $img = $this->input->get_post('img');
//echo	$img = $files['userfile']['name'];
        if ($img != NULL && $name != NULL && $description != NULL && $color != NULL && $team_id != NULL && $user_id != NULL) {
            $row = $this->service_model->master_num_rows("objective_master", array("name" => $name, "team_id" => $team_id, "status" => 1));
            if ($row == 0) {
                $data1 = array("name" => $name, "description" => $description, "color" => $color, "team_id" => $team_id, "user_id" => $user_id, "img" => $img);
                /* if($_FILES["userfile"]["name"] != NULL){
                  $files = $_FILES;
                  $this->load->library('upload');
                  $config['allowed_types'] = 'png|jpg|gif|jpeg';
                  $config['max_size'] = '2000'; // 2MB
                  $config['max_width'] = '3000'; // 3000px
                  $config['max_height'] = '3000'; // 3000px
                  if (isset($files['userfile']) && $files['userfile']['name'] != "") {
                  $config['upload_path'] = './upload/objective/';
                  $config['file_name'] = time().$files['userfile']['name'];
                  $this->upload->initialize($config);
                  if (!is_dir($config['upload_path'])){
                  mkdir($config['upload_path'], 0755, TRUE);
                  }
                  if (!$this->upload->do_upload('userfile')) {
                  $error = $this->upload->display_errors();
                  $error = str_replace("<p>","",$error);
                  $error = str_replace("</p>","",$error);
                  echo $this->json_data("0",$error,"");
                  }else {
                  $doc_data = $this->upload->data();
                  $filename = $doc_data['file_name'];
                  $uploads = array('upload_data' => $this->upload->data("identity"));
                  $data1['img'] = $filename;
                  }
                  }
                  } */
                $insert = $this->service_model->master_fun_insert("objective_master", $data1);
                echo $this->json_data("1", "", array(array("id" => "$insert")));
                $list = $this->service_model->get_top_member_team_id($team_id, $user_id);
                $device_id = array();
				
                foreach ($list as $lists) {
                    if ($lists->device_id != "" && $lists->device_type == 'android') {
                        array_push($device_id, $lists->device_id);
                    }
					if($lists->device_type=='IOS' && $lists->device_id != ""){
						$device_id = $lists->device_id;
						$message = "New objective created by manager";
						$url = 'http://website-demo.in/teamSquadli/push.php?device_id='.$device_id.'&message='.$message;
						$url = str_replace(" ","%20",$url);
						$data = $this->get_content($url);
						$data2 = json_decode($data);
					}
                }
                $notification_data = array("title" => "TEAM Squadli", "message" => "New objective created by manager");
                $pushServer = new PushServer();
                $pushServer->pushToGoogle($device_id, $notification_data);
            } else {
                echo $this->json_data("0", "Objective Name Already Use", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    public function emotion_list() {
        $data = $this->service_model->get_by_id_list("id,name,img", "emotion_master", array("status" => "1"));
        if ($data) {
            echo $this->json_data("1", "", $data);
        } else {
            echo $this->json_data("0", "Objective List Not Found", "");
        }
    }

    public function award_list() {
        $data = $this->service_model->get_by_id_list("id,name,comment,img", "award_master", array("status" => "1"));
        if ($data) {
            echo $this->json_data("1", "", $data);
        } else {
            echo $this->json_data("0", "Objective List Not Found", "");
        }
    }

    function send_emotion() {
        $user_id = $this->input->get_post('user_id');
        $select_user_id = $this->input->get_post('select_user_id');
        $emotion = $this->input->get_post('emotion_award');
        $objective = $this->input->get_post('objective');
        $type = $this->input->get_post('type');
        $comment = $this->input->get_post('comment');
        $visibility = $this->input->get_post('visibility');
        $team_id = $this->input->get_post('team_id');
        if ($user_id != NULL && $select_user_id != NULL && $emotion != NUll && $objective != NULL && $type != NULL && $comment != NULL && $team_id != NULL) {
            $data = array("emotion_award_id" => $emotion,
                "objective_id" => $objective,
                "comment" => $comment,
                "set_user_id" => $select_user_id,
                "user_id" => $user_id,
                "type" => $type,
                "visibility" => $visibility,
                "team_id" => $team_id
            );
            $insert = $this->service_model->master_fun_insert("emotion_award_master", $data);
            echo $this->json_data("1", "", array(array("id" => "$insert")));
            $team = $this->service_model->get_by_id("name", "team_master", array("status" => "1", "id" => $team_id));
            $selectuser = $this->service_model->get_by_id("name,email,device_id,device_type", "customer_master", array("status" => "1", "id" => $select_user_id)); 
            $senduser = $this->service_model->get_by_id("name", "customer_master", array("status" => "1", "id" => $user_id));
            $selectname = $selectuser->name;
            $email = $selectuser->email;
            $sendusername = $senduser->name;
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            if ($type == 'award') {
                $type = 'Award';
            } else {
                $type = 'Emotion';
            }
            if ($type == 'Award') {
                $message = "Hi " . ucwords($selectname) . "<br/><br/>";
                $message .= "You have one new Notification for " . $type . " in " . ucwords($team->name) . "<br/><br/>";
                $message .= "its a Good one!.<br/><br/>";
                $message .= "Here is their comment: $comment <br/><br/>";
                $message .= "Stay Awesome<br/>The Squadli Team<br/><br/>";
            } else {
                $message = "Hi " . ucwords($selectname) . "<br/><br/>";
		$message .= "You have one new Notification for $type in ".ucwords($team->name)."<br/><br/>";
		$emotionpoint = $this->service_model->get_by_id("point", "emotion_master", array("status" => "1", "id" => $emotion));		
		if($emotionpoint > 0){
			$message .= "its a Good one!.<br/><br/>";
		}

                //$message .= "You must be AWESOME!, " . ucwords($sendusername) . " just sent you an Award from the " . ucwords($team->name) . "<br/><br/>";
                $message .= "here is what they say: $comment <br/><br/>";
                $message .= "Stay Awesome<br/>The Squadli Team<br/><br/><br/><br/>";
            }
            //$message .= "Thanks <br/>Squadli";
            //$this->email->to($email);
            //$this->email->from('support@squadli.com', 'Squadli');
            //$this->email->subject("Squadli $type");
            //$this->email->message($message);
            //$this->email->send();
			
			send_mail($email,'Squadli '.$type,$message);
            if ($selectuser->device_type == 'android') {
                $device_id = array($selectuser->device_id);
                $notification_data = array("title" => "TEAM Squadli", "message" => "$type Add by  $sendusername To You.");
                $pushServer = new PushServer();
                $pushServer->pushToGoogle($device_id, $notification_data);
            }
			
			if($selectuser->device_type=='IOS' && $selectuser->device_id != "" ){
						$device_id = $selectuser->device_id;
						$message = $type." Add by  ".$sendusername." To You.";
						$url = 'http://website-demo.in/teamSquadli/push.php?device_id='.$device_id.'&message='.$message;
						$url = str_replace(" ","%20",$url);
						$data = $this->get_content($url);
						$data2 = json_decode($data);
					}
            //echo $this->json_data("1","",array("Invitation Send"));	
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

//////////////////////////////////////////////////end vishal 02-07-2016//////////////////////////////////////////////
//////////////////////////////////////////////////start vishal 04-07-2016//////////////////////////////////////////////
    function array_orderby() {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row->$field;
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }

    function top_contributor_objective() {
        $objective_id = $this->input->get_post('objective_id');
        $team_id = $this->input->get_post('team_id');
        $user_id = $this->input->get_post('user_id');
        if ($objective_id != NULL && $team_id != NULL && $user_id != NULL) {
            $user_list = $this->service_model->get_user_objective($objective_id, $team_id, $user_id);
            $list = array();
//		echo "<pre>"; 
            foreach ($user_list as $user) {
                $emotio_point = $this->service_model->get_user_emotion_point($user->id, $objective_id, $team_id);
                $award_count = $this->service_model->get_user_award_count($user->id, $objective_id, $team_id);
                if ($emotio_point) {
                    $temppoint = $emotio_point->total;
                } else {
                    $temppoint = 0;
                }
                if ($award_count) {
                    $tempaward = $award_count->totalcount;
                } else {
                    $tempaward = 0;
                }
                $num = $tempaward + $temppoint;
                $user->num = $num;
                array_push($list, $user);
                //$award_count->totalcount;
                //$emotio_point->total;
            }
            $sorted = $this->array_orderby($list, 'num', SORT_DESC);
            if ($list) {
                echo $this->json_data("1", "", $sorted);
            } else {
                echo $this->json_data("0", "Top Contributor not available ", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    /*
      function top_contributor_objective(){
      $objective_id = $this->input->get_post('objective_id');
      if($objective_id != NULL){
      $list = $this->service_model->get_top_contributor_objective($objective_id);
      if($list){
      echo $this->json_data("1","",$list);
      }else{
      echo $this->json_data("0","No One Top Objective Contributor ","");
      }
      }else{
      echo $this->json_data("0","Parameter not passed","");
      }

      } */

    function top_member_team() {
        $team_id = $this->input->get_post('team_id');
        if ($team_id != NULL) {
            $list = $this->service_model->get_top_contributor_objective($team_id);
            if ($list) {
                echo $this->json_data("1", "", $list);
            } else {
                echo $this->json_data("0", "Top Contributor not available ", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function user_rank() {
        $user_id = $this->input->get_post('user_id');
        $type = $this->input->get_post('type');
        $self = $this->input->get_post('self');
        $team_id = $this->input->get_post('team_id');
        if ($user_id != NULL && $team_id !== NULL) {
            $user = $this->service_model->get_by_id("id,name,type", "customer_master", array("status" => "1", "id" => $user_id));
            $usertype = $user->type;
            $manger = $this->service_model->get_by_id("manager_id", "team_master", array("status" => "1", "id" => $team_id));
            $manger_payment = $this->service_model->get_by_id("payment", "customer_master", array("status" => "1", "id" => $manger->manager_id));
            if ($user) {
                $testrank = array();
                $list = $this->service_model->get_top_member_team_1($team_id, $user_id);

                foreach ($list as $userlist) {

                    $rank = $this->service_model->rank($userlist->id, $type, $self);
                    $row = $this->service_model->rank_award($userlist->id, $type, $self);
                    $point = $rank->point;
                    $row = $row * 3;
                    $point = $point + $row;
                    if (!$point) {
                        $point = "0";
                    }
                    $topobj = $this->service_model->topobj($userlist->id, $type, $self);
                    $topaward = $this->service_model->topaward1($userlist->id, $type, $self);


                    $cntobj = count($topobj);
                    $cntaward = count($topaward);
                    if ($cntaward < $cntobj) {
                        $j = $cntobj;
                    } else {
                        $j = $cntaward;
                    }
                    $final = array();
                    for ($i = 0; $i <= $j; $i++) {
                        $tobjid = $topobj[$i]->objective_id;
                        for ($ii = 0; $ii <= $j; $ii++) {
                            if ($tobjid == $topaward[$ii]->objective_id) {
                                $sum = $topaward[$ii]->point + $topobj[$i]->point;
                                $temp = array("objid" => $topaward[$ii]->objective_id, "points" => $sum);
                                array_push($final, $temp);
                            }
                        }
                    }
                    if (empty($final)) {
                        $temppoint = 0;
                        $tempobjectiv = 0;
                        foreach ($topobj as $topobj) {
                            if ($temppoint < $topobj->point) {
                                $temppoint = $topobj->point;
                                $tempobjectiv = $topobj->objective_id;
                            }
                        }
                        foreach ($topaward as $topobj) {
                            if ($temppoint < $topobj->point) {
                                $temppoint = $topobj->point;
                                $tempobjectiv = $topobj->objective_id;
                            }
                        }
                        $obj = $this->service_model->get_by_id("id,name,color,img", "objective_master", array("id" => $tempobjectiv));
                        $obj->point = $temppoint;
                    } else {
                        $max = -9999999; //will hold max val
                        $found_item = null; //will hold item with max val;
                        foreach ($final as $k => $v) {
                            if ($v['points'] > $max) {
                                $max = $v['points'];
                                $found_item = $v;
                            }
                        }
                        array_push($testrank, array("teamuserid" => $userlist->id, "teamuserrank" => $max));
                    }
                }

                function cmp($a, $b) {
                    return $b["teamuserrank"] - $a["teamuserrank"];
                }

                usort($testrank, "cmp");

                $rankcnt = 1;
                foreach ($testrank as $testrank1) {
                    if ($testrank1['teamuserid'] == $user_id) {
                        break;
                    }
                    $rankcnt++;
                }

                $rank = $this->service_model->rank($user_id, $type, $self);
                $row = $this->service_model->rank_award($user_id, $type, $self);
                $point = $rank->point;
                $row = $row * 3;
                $point = $point + $row;
                if (!$point) {
                    $point = "0";
                }
                $topobj = $this->service_model->topobj($user_id, $type, $self);
                $topaward = $this->service_model->topaward1($user_id, $type, $self);
//echo "<pre>"; print_r($topobj); print_r($topaward); die();
                $cntobj = count($topobj);
                $cntaward = count($topaward);
                if ($cntaward < $cntobj) {
                    $j = $cntobj;
                } else {
                    $j = $cntaward;
                }
                $final = array();
                for ($i = 0; $i < $j; $i++) {
                    $tobjid = $topobj[$i]->objective_id;
                    for ($ii = 0; $ii < $j; $ii++) {
//					echo $tobjid ."==". $topaward[$ii]->objective_id."<br>";
                        if ($tobjid == $topaward[$ii]->objective_id) {
                            $sum = $topaward[$ii]->point + $topobj[$i]->point;
                            $temp = array("objid" => $topaward[$ii]->objective_id, "points" => $sum);
                            array_push($final, $temp);
                        }
                    }
                }
                if (empty($final)) {
                    $temppoint = 0;
                    $tempobjectiv = 0;
                    foreach ($topobj as $topobj) {
                        if ($temppoint < $topobj->point) {
                            $temppoint = $topobj->point;
                            $tempobjectiv = $topobj->objective_id;
                        }
                    }
                    foreach ($topaward as $topobj) {
                        if ($temppoint < $topobj->point) {
                            $temppoint = $topobj->point;
                            $tempobjectiv = $topobj->objective_id;
                        }
                    }
//echo $tempobjectiv;
                    $obj = $this->service_model->get_by_id("id,name,color,img", "objective_master", array("id" => $tempobjectiv));
//print_r($obj); die();
                    if($obj)
                    	$obj->point = $temppoint;
                } else {
                    //print_r($final); echo "<br>";
                    $max = -9999999; //will hold max val
                    $found_item = null; //will hold item with max val;
                    foreach ($final as $k => $v) {
                        if ($v['points'] > $max) {
                            $max = $v['points'];
                            $found_item = $v;
                        }
                    }
                    $obj = $this->service_model->get_by_id("id,name,color,img", "objective_master", array("id" => $found_item['objid']));
                    $obj->point = $max;
                }

                $emotion = $this->service_model->get_top_emotion($user_id, $type, $self);
                $award = $this->service_model->get_top_award($user_id, $type, $self);
                $objective = $this->service_model->get_top_objective($user_id, $type, $self);
                $data = array(
                    "rank" => $this->userTeamMembersRanks($user_id, $team_id), //$rankcnt,
                    "emotion" => $emotion,
                    "award" => $award,
                    "objective" => $objective,
                    "user_name" => $user->name,
                    "payment" => $manger_payment->payment,
                    "topobjective" => $obj,
                    "usertype" => $usertype
                );
                echo $this->json_data("1", "", array($data));
            } else {
                echo $this->json_data("0", "User Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function userTeamMembersRanks($user_id, $team_id){
        $rankList = array();

        $teamList = $this->service_model->team_membe_list($team_id);
        if(count($teamList)){
            foreach ($teamList as $member) {
                if($member->type != 2)
                    continue;

                $rankList[$member->id] = $this->user_rank_calc($member->id, $team_id, $member->type);
            }
        }

        arsort($rankList);
        $arrayKeys = array_keys($rankList);
        return intval(array_search($user_id, $arrayKeys)) + 1;
    }

    function user_rank_calc($uID, $tID, $typ = 0){
        $emos = 0;
        $awards = 0;
        $userEmos = $this->service_model->get_user_emotions($uID, $tID, $typ);
        if(count($userEmos)){
            foreach ($userEmos as $emo) {
                $emos += ($emo->point * $emo->num);
            }
        }

        $userAwards = $this->service_model->get_user_awards($uID, $tID, $typ);
        if(count($userAwards)){
            foreach ($userAwards as $award) {
                $awards += ($award->point * $award->num);
            }
        }

        return $emos + $awards;        
    }

    function user_rank_tst() {
        $user_id = $this->input->get_post('user_id');
        $type = $this->input->get_post('type');
        $self = $this->input->get_post('self');
        $team_id = $this->input->get_post('team_id');
        if ($user_id != NULL && $team_id !== NULL) {
            $user = $this->service_model->get_by_id("id,name,type", "customer_master", array("status" => "1", "id" => $user_id));
            $usertype = $user->type;
            $manger = $this->service_model->get_by_id("manager_id", "team_master", array("status" => "1", "id" => $team_id));
            $manger_payment = $this->service_model->get_by_id("payment", "customer_master", array("status" => "1", "id" => $manger->manager_id));
            if ($user) {
                $testrank = array();
                $list = $this->service_model->get_top_member_team_1($team_id, $user_id);

                foreach ($list as $userlist) {

                    $rank = $this->service_model->rank($userlist->id, $type, $self);
                    $row = $this->service_model->rank_award($userlist->id, $type, $self);
                    $point = $rank->point;
                    $row = $row * 3;
                    $point = $point + $row;
                    if (!$point) {
                        $point = "0";
                    }
                    $topobj = $this->service_model->topobj($userlist->id, $type, $self);
                    $topaward = $this->service_model->topaward1($userlist->id, $type, $self);


                    $cntobj = count($topobj);
                    $cntaward = count($topaward);
                    if ($cntaward < $cntobj) {
                        $j = $cntobj;
                    } else {
                        $j = $cntaward;
                    }
                    $final = array();
                    for ($i = 0; $i <= $j; $i++) {
                        $tobjid = $topobj[$i]->objective_id;
                        for ($ii = 0; $ii <= $j; $ii++) {
                            if ($tobjid == $topaward[$ii]->objective_id) {
                                $sum = $topaward[$ii]->point + $topobj[$i]->point;
                                $temp = array("objid" => $topaward[$ii]->objective_id, "points" => $sum);
                                array_push($final, $temp);
                            }
                        }
                    }
                    if (empty($final)) {
                        $temppoint = 0;
                        $tempobjectiv = 0;
                        foreach ($topobj as $topobj) {
                            if ($temppoint < $topobj->point) {
                                $temppoint = $topobj->point;
                                $tempobjectiv = $topobj->objective_id;
                            }
                        }
                        foreach ($topaward as $topobj) {
                            if ($temppoint < $topobj->point) {
                                $temppoint = $topobj->point;
                                $tempobjectiv = $topobj->objective_id;
                            }
                        }
                        $obj = $this->service_model->get_by_id("id,name,color,img", "objective_master", array("id" => $tempobjectiv));
                        $obj->point = $temppoint;
                    } else {
                        $max = -9999999; //will hold max val
                        $found_item = null; //will hold item with max val;
                        foreach ($final as $k => $v) {
                            if ($v['points'] > $max) {
                                $max = $v['points'];
                                $found_item = $v;
                            }
                        }
                        array_push($testrank, array("teamuserid" => $userlist->id, "teamuserrank" => $max));
                    }
                }

                function cmp($a, $b) {
                    return $b["teamuserrank"] - $a["teamuserrank"];
                }

                usort($testrank, "cmp");

                $rankcnt = 1;
                foreach ($testrank as $testrank1) {
                    if ($testrank1['teamuserid'] == $user_id) {
                        break;
                    }
                    $rankcnt++;
                }

                $rank = $this->service_model->rank($user_id, $type, $self);
                $row = $this->service_model->rank_award($user_id, $type, $self);
                $point = $rank->point;
                $row = $row * 3;
                $point = $point + $row;
                if (!$point) {
                    $point = "0";
                }
                $topobj = $this->service_model->topobj($user_id, $type, $self);
                $topaward = $this->service_model->topaward1($user_id, $type, $self);

                $cntobj = count($topobj);
                $cntaward = count($topaward);
                if ($cntaward < $cntobj) {
                    $j = $cntobj;
                } else {
                    $j = $cntaward;
                }
                $final = array();
                for ($i = 0; $i < $j; $i++) {
                    $tobjid = $topobj[$i]->objective_id;
                    for ($ii = 0; $ii < $j; $ii++) {
//					echo $tobjid ."==". $topaward[$ii]->objective_id."<br>";
                        if ($tobjid == $topaward[$ii]->objective_id) {
                            $sum = $topaward[$ii]->point + $topobj[$i]->point;
                            $temp = array("objid" => $topaward[$ii]->objective_id, "points" => $sum);
                            array_push($final, $temp);
                        }
                    }
                }
                if (empty($final)) {
                    $temppoint = 0;
                    $tempobjectiv = 0;
                    foreach ($topobj as $topobj) {
                        if ($temppoint < $topobj->point) {
                            $temppoint = $topobj->point;
                            $tempobjectiv = $topobj->objective_id;
                        }
                    }
                    foreach ($topaward as $topobj) {
                        if ($temppoint < $topobj->point) {
                            $temppoint = $topobj->point;
                            $tempobjectiv = $topobj->objective_id;
                        }
                    }

                    $obj = $this->service_model->get_by_id("id,name,color,img", "objective_master", array("id" => $tempobjectiv));

                    if($obj)
                    	$obj->point = $temppoint;
                } else {
                    //print_r($final); echo "<br>";
                    $max = -9999999; //will hold max val
                    $found_item = null; //will hold item with max val;
                    foreach ($final as $k => $v) {
                        if ($v['points'] > $max) {
                            $max = $v['points'];
                            $found_item = $v;
                        }
                    }
                    $obj = $this->service_model->get_by_id("id,name,color,img", "objective_master", array("id" => $found_item['objid']));
                    $obj->point = $max;
                }

                $emotion = $this->service_model->get_top_emotion_tst($user_id, $type, $self);
                $award = $this->service_model->get_top_award($user_id, $type, $self);
                $objective = $this->service_model->get_top_objective($user_id, $type, $self);
                $data = array(
                    "rank" => $rankcnt,
                    "emotion" => $emotion,
                    "award" => $award,
                    "objective" => $objective,
                    "user_name" => $user->name,
                    "payment" => $manger_payment->payment,
                    "topobjective" => $obj,
                    "usertype" => $usertype
                );
                echo $this->json_data("1", "", array($data));
            } else {
                echo $this->json_data("0", "User Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
/*
    function get_all_users_tst() {
    	$users = $this->service_model->get_all_users();
    	exit(print_r($users));
    	return json_encode($users);
    }

    function get_user_emo_tst($uid) {
    	$emos = $this->service_model->get_user_emotions($uid);
    	exit(print_r($emos));
    	return ;
    }

    function get_user_awards_tst($uid) {
    	$awards = $this->service_model->get_user_award($uid);
    	exit(print_r($awards));
    	return ;
    }
*/

    /* function user_rank(){
      $user_id = $this->input->get_post('user_id');
      $type = $this->input->get_post('type');
      $self = $this->input->get_post('self');
      $team_id = $this->input->get_post('team_id');
      if($user_id != NULL){
      $user = $this->service_model->get_by_id("id,name","customer_master",array("status"=>"1","id"=>$user_id));
      $manger = $this->service_model->get_by_id("manager_id","team_master",array("status"=>"1","id"=>$team_id));
      $manger_payment = $this->service_model->get_by_id("payment","customer_master",array("status"=>"1","id"=>$manger->manager_id));
      if($user){

      $rank = $this->service_model->rank($user_id,$type,$self);
      $row = $this->service_model->rank_award($user_id,$type,$self);
      $point = $rank->point;
      $row = $row *3;
      $point = $point + $row;
      if(!$point){ $point = "0";}
      $topobj = $this->service_model->topobj($user_id,$type,$self);
      $topaward = $this->service_model->topaward1($user_id,$type,$self);
      //echo "<pre>"; print_r($topobj); print_r($topaward); die();
      $cntobj=count($topobj);
      $cntaward=count($topaward);
      if($cntaward < $cntobj){
      $j=$cntobj;
      }else{
      $j=$cntaward;
      }
      $final=array();
      for($i=0;$i<$j;$i++){
      $tobjid = $topobj[$i]->objective_id;
      for($ii= 0;$ii<$j;$ii++)
      {
      //					echo $tobjid ."==". $topaward[$ii]->objective_id."<br>";
      if($tobjid == $topaward[$ii]->objective_id){
      $sum = $topaward[$ii]->point+$topobj[$i]->point;
      $temp = array("objid"=> $topaward[$ii]->objective_id, "points" => $sum);
      array_push($final,$temp);
      }
      }
      }
      if (empty($final)) {
      $temppoint=0;
      $tempobjectiv=0;
      foreach($topobj as $topobj){
      if($temppoint < $topobj->point){
      $temppoint = $topobj-> point;
      $tempobjectiv = $topobj-> objective_id;
      }
      }
      foreach($topaward as $topobj){
      if($temppoint < $topobj->point){
      $temppoint = $topobj-> point;
      $tempobjectiv = $topobj-> objective_id;
      }
      }
      //echo $tempobjectiv;
      $obj = $this->service_model->get_by_id("id,name,color,img","objective_master",array("id"=>$tempobjectiv));
      //print_r($obj); die();
      $obj->point=$temppoint;
      }else{
      //print_r($final); echo "<br>";
      $max = -9999999; //will hold max val
      $found_item = null; //will hold item with max val;
      foreach($final as $k=>$v)
      {
      if($v['points']>$max)
      {
      $max = $v['points'];
      $found_item = $v;
      }
      }
      $obj = $this->service_model->get_by_id("id,name,color,img","objective_master",array("id"=>$found_item['objid']));
      $obj->point=$max;
      }

      $emotion = $this->service_model->get_top_emotion($user_id,$type,$self);
      $award = $this->service_model->get_top_award($user_id,$type,$self);
      $objective = $this->service_model->get_top_objective($user_id,$type,$self);
      $data = array(
      "rank" => $point,
      "emotion" => $emotion,
      "award" => $award,
      "objective" => $objective,
      "user_name" => $user->name,
      "payment" => $manger_payment->payment,
      "topobjective" => $obj
      );
      echo $this->json_data("1","",array($data));
      }else{
      echo $this->json_data("0","User Not available","");
      }
      }else{
      echo $this->json_data("0","Parameter not passed","");
      }

      } */
    /* function user_rank(){
      $user_id = $this->input->get_post('user_id');
      $type = $this->input->get_post('type');
      $self = $this->input->get_post('self');
      $team_id = $this->input->get_post('team_id');
      if($user_id != NULL){
      $user = $this->service_model->get_by_id("id,name","customer_master",array("status"=>"1","id"=>$user_id));
      $manger = $this->service_model->get_by_id("manager_id","team_master",array("status"=>"1","id"=>$team_id));
      $manger_payment = $this->service_model->get_by_id("payment","customer_master",array("status"=>"1","id"=>$manger->manager_id));
      if($user){
      $rank = $this->service_model->rank($user_id,$type,$self);

      $point = $rank->point;
      if(!$point){ $point = "0";}
      $emotion = $this->service_model->get_top_emotion($user_id,$type,$self);
      $award = $this->service_model->get_top_award($user_id,$type,$self);
      $objective = $this->service_model->get_top_objective($user_id,$type,$self);
      $data = array(
      "rank" => $point,
      "emotion" => $emotion,
      "award" => $award,
      "objective" => $objective,
      "user_name" => $user->name,
      "payment" => $manger_payment->payment
      );
      echo $this->json_data("1","",array($data));
      }else{
      echo $this->json_data("0","User Not available","");
      }
      }else{
      echo $this->json_data("0","Parameter not passed","");
      }

      } */

//////////////////////////////////////////////////end vishal 04-07-2016//////////////////////////////////////////////
//////////////////////////////////////////////////start vishal 05-07-2016//////////////////////////////////////////////
    function user_award() {
        $user_id = $this->input->get_post('user_id');
        $type = $this->input->get_post('type');
        if ($user_id != NULL) {
            $user = $this->service_model->get_by_id("id", "customer_master", array("status" => "1", "id" => $user_id));
            if ($user) {
                $awards = $this->service_model->get_user_award($user_id, $type);
                if ($awards) {
                    $final = array();
                    foreach ($awards as $award) {
                        $objective = $this->service_model->get_objective_award($user_id, $award->id, $type);
                        $award->objective = $objective;
                        array_push($final, $award);
                    }
                    echo $this->json_data("1", "", $final);
                } else {
                    echo $this->json_data("0", "No Award available", "");
                }
            } else {
                echo $this->json_data("0", "User Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function user_emotion() {
        $user_id = $this->input->get_post('user_id');
        $type = $this->input->get_post('type');
        if ($user_id != NULL) {
            $user = $this->service_model->get_by_id("id", "customer_master", array("status" => "1", "id" => $user_id));
            if ($user) {
                $emotions = $this->service_model->get_user_emotion($user_id, $type);
                if ($emotions) {
                    $final = array();
                    foreach ($emotions as $emotion) {
                        $objective = $this->service_model->get_objective_emotion($user_id, $emotion->id, $type);
                        $emotion->objective = $objective;
                        array_push($final, $emotion);
                    }
                    echo $this->json_data("1", "", $final);
                } else {
                    echo $this->json_data("0", "No Feedback Available", "");
                }
            } else {
                echo $this->json_data("0", "User Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function emotions_comment() {
        $user_id = $this->input->get_post('user_id');
        $obj_id = $this->input->get_post('obj_id');
        $type = $this->input->get_post('type');
        $data = $this->input->get_post('data');
        if ($user_id != NULL && $data != NULL) {
            $user = $this->service_model->get_by_id("id", "customer_master", array("status" => "1", "id" => $user_id));
            if ($user) {
                $emotions_comment = $this->service_model->emotions_comment($user_id, $obj_id, $type, $data);
                if ($emotions_comment) {
                    echo $this->json_data("1", "", $emotions_comment);
                } else {
                    echo $this->json_data("0", "No Comment available", "");
                }
            } else {
                echo $this->json_data("0", "User Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
	function emotions_comment1() {
        $user_id = $this->input->get_post('user_id');
        $obj_id = $this->input->get_post('obj_id');
        $type = $this->input->get_post('type');
        $data = $this->input->get_post('data');
        if ($user_id != NULL && $data != NULL) {
        	$vishal = (object) array();        	
            $user = $this->service_model->get_by_id("id", "customer_master", array("status" => "1", "id" => $user_id));
            if ($user) {
                $emotions_comment = $this->service_model->emotions_comment1($user_id, $obj_id, $type, $data);
				$objidlist = array();
				$cnt = 0;
				$final = "";
				if($emotions_comment){
					$final = '<meta name="viewport" content="width=device-width, initial-scale=1"> <div style=" float: left;"><table ><tbody>';
					foreach ($emotions_comment as $comment){
						if(in_array($comment->oid,$objidlist)){
							$final .= '<tr><td></td><td></td><td>'.$comment->comment.'</td></tr>';
						}else{
							$cnt++;
							array_push($objidlist,$comment->oid);
							$final .= '<tr><td>Objectives '.$cnt.' :</td><td>'.$comment->oname.'</td></tr><tr><td></td><td>Comments :</td><td>'.$comment->comment.'</td></tr>';
						}
					}
					$final .= '</tbody></table></div>';
				}
				$vishal->html = $final;
				echo $this->json_data("1", "", array($vishal) );
            } else {
                echo $this->json_data("0", "User Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }
    function change_email() {
        $user_id = $this->input->get_post('user_id');
        $email = $this->input->get_post('email');
        if ($user_id != NULL && $email != NULL) {
            $user = $this->service_model->get_by_id("id,email", "customer_master", array("status" => "1", "id" => $user_id));
            if ($user) {
                if ($user->email == $email) {
                    echo $this->json_data("1", "", array(array("msg" => "Your Email has been Updated")));
                } else {
                    $row = $this->service_model->master_num_rows("customer_master", array("email" => $email, "status" => 1));
                    if ($row == 0) {
                        $update = $this->service_model->master_fun_update("customer_master", $user_id, array('email' => $email));
                        echo $this->json_data("1", "", array(array("msg" => "Your Email has been Updated")));
                    } else {
                        echo $this->json_data("0", "Email Already Registered", "");
                    }
                }
            } else {
                echo $this->json_data("0", "User Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function change_name() {
        $user_id = $this->input->get_post('user_id');
        $name = $this->input->get_post('name');
        if ($user_id != NULL && $name != NULL) {
            $user = $this->service_model->get_by_id("id,email", "customer_master", array("status" => "1", "id" => $user_id));
            if ($user) {
                $update = $this->service_model->master_fun_update("customer_master", $user_id, array('name' => $name));
                echo $this->json_data("1", "", array(array("msg" => "Your name has changed")));
            } else {
                echo $this->json_data("0", "User Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

//////////////////////////////////////////////////end vishal 05-07-2016//////////////////////////////////////////////
//////////////////////////////////////////////////end vishal 06-07-2016//////////////////////////////////////////////
    function objective_detail() {
        $obj_id = $this->input->get_post('objective_id');
        if ($obj_id) {
            $object = $this->service_model->get_by_id("id,name,img,description,color", "objective_master", array("status" => "1", "id" => $obj_id));
            if ($object) {
                echo $this->json_data("1", "", array($object));
            } else {
                echo $this->json_data("0", "Objective Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    public function update_objective() {
        $name = $this->input->get_post('name');
        $description = $this->input->get_post('description');
        $color = $this->input->get_post('color');
        $obj_id = $this->input->get_post('objective_id');
        $img = $this->input->get_post('img');
        if ($name != NULL && $description != NULL && $color != NULL && $img != NULL) {
            $object = $this->service_model->get_by_id("team_id,name", "objective_master", array("status" => "1", "id" => $obj_id));
            if ($object->name != $name) {
                $row = $this->service_model->master_num_rows("objective_master", array("name" => $name, "team_id" => $object->team_id, "status" => 1));
            } else {
                $row = 0;
            }
            if ($row == 0) {
                $data1 = array("name" => $name, "description" => $description, "color" => $color, "img" => $img);
                /* if($_FILES["userfile"]["name"]){
                  $files = $_FILES;
                  $this->load->library('upload');
                  $config['allowed_types'] = 'png|jpg|gif|jpeg';
                  $config['max_size'] = '2000'; // 2MB
                  $config['max_width'] = '3000'; // 3000px
                  $config['max_height'] = '3000'; // 3000px
                  if (isset($files['userfile']) && $files['userfile']['name'] != "") {
                  $config['upload_path'] = './upload/objective/';
                  $config['file_name'] = time().$files['userfile']['name'];
                  $this->upload->initialize($config);
                  if (!is_dir($config['upload_path'])){
                  mkdir($config['upload_path'], 0755, TRUE);
                  }
                  if (!$this->upload->do_upload('userfile')) {
                  $error = $this->upload->display_errors();
                  $error = str_replace("<p>","",$error);
                  $error = str_replace("</p>","",$error);
                  echo $this->json_data("0",$error,"");
                  }else {
                  $doc_data = $this->upload->data();
                  $filename = $doc_data['file_name'];
                  $uploads = array('upload_data' => $this->upload->data("identity"));
                  $data1['img'] = $filename;
                  }
                  }
                  } */
                $this->service_model->master_fun_update("objective_master", $obj_id, $data1);
                echo $this->json_data("1", "", array(array("msg" => "Your Objective has been Updated")));
            } else {
                echo $this->json_data("0", "Objective Name Already in Use", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    public function delete_objective() {
        $obj_id = $this->input->get_post('obj_id');
        if ($obj_id != NULL) {
            $data1 = array("status" => "0");
            $this->service_model->master_fun_update("objective_master", $obj_id, $data1);
            echo $this->json_data("1", "", array(array("msg" => "Your Objectve Delete")));
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    public function update_team() {
        $name = $this->input->get_post('name');
        $team_id = $this->input->get_post('team_id');
        $user_id = $this->input->get_post('user_id');
        if ($name != NULL && $team_id != NULL && $user_id != NULL) {
            $team = $this->service_model->get_by_id("name", "team_master", array("status" => "1", "id" => $team_id));
            if ($team->name != $name) {
                $row = $this->service_model->master_num_rows("team_master", array("name" => $name, "manager_id" => $user_id, "status" => 1));
            } else {
                $row = 0;
            }
            if ($row == 0) {
                $data1 = array("name" => $name);
                $this->service_model->master_fun_update("team_master", $team_id, $data1);
                echo $this->json_data("1", "", array(array("msg" => "Your Team has been Updated")));
            } else {
                echo $this->json_data("0", "Team Name Already in Use", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    public function upload_pic() {
        $user_id = $this->input->get_post('user_id');

        if ($user_id != NULL) {
            $files = $_FILES;
            $data = array();
            $this->load->library('upload');
//echo $files['userfile']['name'];
            $config['allowed_types'] = 'png|jpg|gif|jpeg';
            $config['max_size'] = '2000'; // 2MB
//	$config['max_width'] = '3000'; // 3000px
//	$config['max_height'] = '3000'; // 3000px
            if (isset($files['userfile']) && $files['userfile']['name'] != "") {
                $config['upload_path'] = './upload/user/';
                $config['file_name'] = time() . $files['userfile']['name'];
                $this->upload->initialize($config);
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0755, TRUE);
                }
                if (!$this->upload->do_upload('userfile')) {
                    $error = $this->upload->display_errors();
                    $error = str_replace("<p>", "", $error);
                    $error = str_replace("</p>", "", $error);
                    $tetstst = pathinfo($files['userfile']['name'], PATHINFO_EXTENSION);
                    echo $this->json_data("0", $error, "");
                } else {
                    $doc_data = $this->upload->data();
                    $filename = $doc_data['file_name'];
                    $uploads = array('upload_data' => $this->upload->data("identity"));
                    $this->service_model->master_fun_update("customer_master", $user_id, array("img" => $filename));
                    echo $this->json_data("1", "", array(array("filename" => $filename)));
                }
            } else {
                echo $this->json_data("0", "You did not select a file to upload", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    public function update_user_pic() {
        $user_id = $this->input->get_post('user_id');
        $userfile = $this->input->get_post('userfile');
        if ($user_id != "" && $userfile != "") {
            $this->service_model->master_fun_update("customer_master", $user_id, array("img" => $userfile));
            echo $this->json_data("1", "", array(array("filename" => $userfile)));
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    public function upload_pic1() {
        $files = $_FILES;
        $data = array();
        $this->load->library('upload');
        $config['allowed_types'] = 'png|jpg|gif|jpeg';
        $config['max_size'] = '2000'; // 2MB
        if (isset($files['userfile']) && $files['userfile']['name'] != "") {
            $config['upload_path'] = './upload/user/';
            $config['file_name'] = time() . $files['userfile']['name'];
            $this->upload->initialize($config);
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, TRUE);
            }
            if (!$this->upload->do_upload('userfile')) {
                $error = $this->upload->display_errors();
                $error = str_replace("<p>", "", $error);
                $error = str_replace("</p>", "", $error);
                $tetstst = pathinfo($files['userfile']['name'], PATHINFO_EXTENSION);
                echo $this->json_data("0", $error, "");
            } else {
                $doc_data = $this->upload->data();
                $filename = $doc_data['file_name'];
                $uploads = array('upload_data' => $this->upload->data("identity"));
                $this->service_model->master_fun_update("customer_master", $user_id, array("img" => $filename));
                echo $this->json_data("1", "", array(array("filename" => $filename)));
            }
        } else {
            echo $this->json_data("0", "You did not select a file to upload", "");
        }
    }

    public function update_position() {
        $position = $this->input->get_post('position');
        $user_id = $this->input->get_post('user_id');
        if ($position != NULL && $user_id != NULL) {
            $user = $this->service_model->get_by_id("id", "customer_master", array("status" => "1", "id" => $user_id));
            if ($user) {
                $this->service_model->master_fun_update("customer_master", $user_id, array("deignation" => $position));
                echo $this->json_data("1", "", array(array("msg" => "Your Position has been Updated")));
            } else {
                echo $this->json_data("0", "user Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
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

//////////////////////////////////////////////////end vishal 06-07-2016//////////////////////////////////////////////
//////////////////////////////////////////////////start vishal 12-07-2016//////////////////////////////////////////////
    function update360() {
        $team_id = $this->input->get_post('team_id');
        $enable = $this->input->get_post('enable360');
        if ($team_id != NULL && $enable != NULL) {
            $team = $this->service_model->get_by_id("id", "team_master", array("status" => "1", "id" => $team_id));
            if ($team) {
                $update = $this->service_model->master_fun_update("team_master", $team_id, array("enable360" => $enable));
                echo $this->json_data("1", "", array(array("enable360" => $enable)));
            } else {
                echo $this->json_data("0", "Team Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function updatepeer_ranking() {
        $team_id = $this->input->get_post('team_id');
        $peer_ranking = $this->input->get_post('peer_ranking');
        if ($team_id != NULL && $peer_ranking != NULL) {
            $team = $this->service_model->get_by_id("id", "team_master", array("status" => "1", "id" => $team_id));
            if ($team) {
                $update = $this->service_model->master_fun_update("team_master", $team_id, array("peer_ranking" => $peer_ranking));
                echo $this->json_data("1", "", array(array("peer_ranking" => $peer_ranking)));
            } else {
                echo $this->json_data("0", "Team Not available", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

//////////////////////////////////////////////////end vishal 12-07-2016//////////////////////////////////////////////
    function send_invitation1() {

        $team_id = $this->input->get_post('team_id');
        $name = $this->input->get_post('name');
        $email = $this->input->get_post('email');
	    $user_id = $this->input->get_post('user_id');
        if ($team_id != NULL && $name != NULL && $email != NUll) {
            $team = $this->service_model->get_by_id("id,name", "team_master", array("status" => "1", "id" => $team_id));
            if ($team) {
                    $this->load->helper('string');
                    $code = random_string('alnum', 6);
					$email = strtolower($email);
                    $data = array(
                        "code" => $code,
                        "team_id" => $team_id,
                        "email" => $email
                    );
                    $insert = $this->service_model->master_fun_insert("referral_team", $data);
                    if ($insert) {
			$senderuser = $this->service_model->get_by_id("name,email", "customer_master", array("status" => "1", "id" => $user_id));
                        $teamname = $team->name;
			$sendername = ucwords($senderuser->name);
			$senderemail = $senderuser->email;
                        $config['mailtype'] = 'html';
                        $this->email->initialize($config);
						$message = "<!DOCTYPE html>
<html lang='en'>
<head>
  
 
</head>
<body style='padding:0;margin:0;'>

<div class='full_div' style='background:#F9F9F9;margin:10px auto;width:100%;border-bottom:6px dashed #4D8378;padding: 20px 0 65px 0;'>
		<center><a href='#'><img src='".base_url()."img/logo_squadli.png' style='width:70px;height:70px;'/></a></center>
	<div class='inner_full' style='width:70%;margin:20px auto;background:#fff;padding: 20px;'>
			<h1 style='color:#2AB27B;text-align:center;'>Confirm your email with the following code</h1>
			<p style='color:#373737;text-align:center;margin: 10px 0;font-size: 20px;'>Hi $name</p>
			<p style='color:#373737;text-align:center;margin: 10px 0;font-size: 20px;'>Congratulations, You have an invitation to join the Team Review and performance app: Squadli</p>
			<p style='color:#373737;text-align:center;margin: 10px 0;font-size: 20px;'>Team Name: $teamname.</p>
			<p style='color:#373737;text-align:center;margin: 10px 0;font-size: 20px;'>You will need to download the Squadli from Google Play <a href='https://play.google.com/store/apps/details?id=com.awesome.reviewapp&hl=en'>https://play.google.com/store/apps/details?id=com.awesome.reviewapp&hl=en</a> or Apple AppStore <a href='https://itunes.apple.com/cz/app/squadli/id1193968087?mt=8'>https://itunes.apple.com/cz/app/squadli/id1193968087?mt=8</a>. After downloading the app, sign up choosing the 'Team Member' option (not the Manager Option)</p>
			<p style='color:#373737;text-align:center;margin: 10px 0;font-size: 20px;'>Once you verify your account, please login and type the following team code to get access to your Squadli Team.</p>
			
			<center><h1 style='color:#373737;text-align:center;font-size: 48px;'> $code </h1></center>
			<p style='color:#373737;text-align:left;margin: 10px 0;font-size: 20px;'>With Gratitude</p>
			<p style='color:#373737;text-align:left;margin: 10px 0;font-size: 20px;'>Arthur Carmazzi</p>
			<p style='color:#373737;text-align:left;margin: 10px 0;font-size: 20px;'>Chief Awesomeness Officer</p>
	</div>
  
</div>
    
</body>
</html>";
						
                        //$this->email->to($email);
                        //$this->email->from('support@squadli.com', 'Squadli');
                        //$this->email->subject("Squadli Invitation");
                        //$this->email->message($message);
                        //$this->email->send();
						
						send_mail($email,'Squadli Invitation',$message);
                        echo $this->json_data("1", "", array(array("code" => $code)));
                    } else {
                        echo $this->json_data("0", "Some Thig Is Wrong Pleas try again", "");
                    }
                //} else {
                //    echo $this->json_data("0", "This email has been exist in this team. Please invite other email", "");
                //}
            } else {
                echo $this->json_data("0", "Team Not Availebale", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function user_payment() {
        $data = $this->input->get_post('data');
        $user_id = $this->input->get_post('user_id');
        $amount = $this->input->get_post('amount');
//$data = ' {"response": { "state": "Squadliroved", "id": "PAY-18X32451H0459092JKO7KFUI", "create_time": "2014-07-18T18:46:55Z", "intent": "sale" }, "client": { "platform": "Android", "paypal_sdk_version": "2.14.4", "product_name": "PayPal-Android-SDK", "environment": "mock" }, "response_type": "payment" }';
//$user_id = '1';
//$amount = '100';
        if ($data != "" and $data != "") {
            $temp = json_decode($data);
            if ($temp) {
                $data1 = array(
                    "status" => $temp->response->state,
                    "payment_id" => $temp->response->id,
                    "creater_date" => $temp->response->create_time,
                    "data" => $data,
                    "amount" => $amount,
                    "user_id" => $user_id
                );

                $insert = $this->service_model->master_fun_insert("payment", $data1);
                $update = $this->service_model->master_fun_update("customer_master", $user_id, array("payment" => "1"));
                echo $this->json_data("1", "", array());
            } else {
                echo $this->json_data("0", "Somethink is Wrong", "");
            }
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function update_payment($id, $temp) {
        $update = $this->service_model->master_fun_update("customer_master", $id, array("payment" => $temp));
    }

    function manager_team() {
        $user_id = $this->input->get_post('user_id');
        if ($user_id) {
            //$user_id = $this->service_model->get_by_id_list('id,name,enable360,manager_id,peer_ranking', 'team_master', array('status' => '1', 'manager_id' => $user_id));
            $team_list = $this->service_model->join_team_list($user_id);
            echo $this->json_data("1", "", $team_list);
        } else {
            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    function get_code($id) {
        $team = $this->service_model->get_by_id("id,code", "referral_team", array("id" => $id));
        echo $this->json_data("1", "", $team);
    }

    function delete_team($id) {
        $update = $this->service_model->update("team_member_master", array("user_id" => $id), array("status" => '0'));
        echo "done";
    }

    function refl_team($id) {
        $update = $this->service_model->update("referral_team", array("id" => $id), array("status" => '1'));
        echo "done";
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
	public function help(){
		$helpdata = $this->service_model->get_by_id("help", "help_master", array("id" => '1'));
		$data['help'] = $helpdata->help;
		$this->load->view('admin/help',$data);
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

}

?>
