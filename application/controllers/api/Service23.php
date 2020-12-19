<?php



class Service23 extends CI_Controller {



    public function __construct() {

        parent::__construct();

        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->model('Service_model_15');

        $this->load->model('login_model');

        $this->load->helper('security');

        $this->load->helper('string');

        $this->load->helper(array('swift'));

        $this->load->library('email');

        header('Access-Control-Allow-Origin: *');

        header('Access-Control-Allow-Methods: GET, POST');

        header("Access-Control-Allow-Headers: X-Requested-With");

        date_default_timezone_set('Asia/Kolkata');

        $this->Squadli_tarce();

        $this->version_code = '71';

//		ini_set('display_errors', '-1');

    }



    public function Squadli_tarce() {

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

        $Squadli_info = $this->Service_model_15->master_insert("alldata", $user_track_data);

        //return true;

    }

	public function check_density() {

		$token = $this->input->get_post('token');

		$date = $this->input->get_post('date');

		if ($token != "" && $date != "") {

			$list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

			if ($list) {

				$location_id = $list[0]['l_id'];

				$checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_daily_density", array("date" => $date, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

				//echo $this->db->last_Query();

				if($checkentry){

					echo $this->json_data("1", "", $checkentry);

				}else{

					echo $this->json_data("0", "", "");

				}

			}else{

				echo $this->json_data("3", "Token expired. Please login again. ", "");

			}

		}else{

			echo $this->json_data("0", "Parameter Not passed", "");

		}

	}

public function add_density() {

	$p_morning_hydro_reading = $this->input->get_post('p_morning_hydro_reading');

	$p_morning_temp = $this->input->get_post('p_morning_temp');

	$p_morning_density = $this->input->get_post('p_morning_density');

	$p_decant_hydro_reading = $this->input->get_post('p_decant_hydro_reading');

	$p_decant_temp = $this->input->get_post('p_decant_temp');

	$p_decant_density = $this->input->get_post('p_decant_density');

	$d_morning_hydro_reading = $this->input->get_post('d_morning_hydro_reading');

	$d_morning_temp = $this->input->get_post('d_morning_temp');

	$d_morning_density = $this->input->get_post('d_morning_density');

	$d_decant_hydro_reading = $this->input->get_post('d_decant_hydro_reading');

	$d_decant_temp = $this->input->get_post('d_decant_temp');

	$d_decant_density = $this->input->get_post('d_decant_density');

	$xpp_morning_hydro_reading = $this->input->get_post('xpp_morning_hydro_reading');

	$xpp_morning_temp = $this->input->get_post('xpp_morning_temp');

	$xpp_morning_density = $this->input->get_post('xpp_morning_density');

	$xpp_decant_hydro_reading = $this->input->get_post('xpp_decant_hydro_reading');

	$xpp_decant_temp = $this->input->get_post('xpp_decant_temp');

	$xpp_decant_density = $this->input->get_post('xpp_decant_density');

	$xpd_morning_hydro_reading = $this->input->get_post('xpd_morning_hydro_reading');

	$xpd_morning_temp = $this->input->get_post('xpd_morning_temp');

	$xpd_morning_density = $this->input->get_post('xpd_morning_density');

	$xpd_decant_hydro_reading = $this->input->get_post('xpd_decant_hydro_reading');

	$xpd_decant_temp = $this->input->get_post('xpd_decant_temp');

	$xpd_decant_density = $this->input->get_post('xpd_decant_density');

	$this->load->model('Service_model_15');

	$token = $this->input->get_post('token');

	$date = $this->input->get_post('date');

	$query_type = $this->input->get_post('query_type');

	if ($token != "" && $date != "") {

		$list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

		if ($list) {

			$checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_daily_density", array("date" => $date, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

			if ($checkentry) {

				/*echo $this->json_data("0", "Sorry you already added detail.", "");

				die();*/

			}

			$id = $list[0]['id'];

			$location_id = $list[0]['l_id'];

			$data = array(

				'user_id' => $id,

				'date' => $date,

				'location_id' => $location_id,

				'p_morning_hydro_reading' => $p_morning_hydro_reading,

				'p_morning_temp' => $p_morning_temp,

				'p_morning_density' => $p_morning_density,

				'p_decant_hydro_reading' => $p_decant_hydro_reading,

				'p_decant_temp' => $p_decant_temp,

				'p_decant_density' => $p_decant_density,

				'd_morning_hydro_reading' => $d_morning_hydro_reading,

				'd_morning_temp' => $d_morning_temp,

				'd_morning_density' => $d_morning_density,

				'd_decant_hydro_reading' => $d_decant_hydro_reading,

				'd_decant_temp' => $d_decant_temp,

				'd_decant_density' => $d_decant_density,

				'xpp_morning_hydro_reading' => $xpp_morning_hydro_reading,

				'xpp_morning_temp' => $xpp_morning_temp,

				'xpp_morning_density' => $xpp_morning_density,

				'xpp_decant_hydro_reading' => $xpp_decant_hydro_reading,

				'xpp_decant_temp' => $xpp_decant_temp,

				'xpp_decant_density' => $xpp_decant_density,

				'xpd_morning_hydro_reading' => $xpd_morning_hydro_reading,

				'xpd_morning_temp' => $xpd_morning_temp,

				'xpd_morning_density' => $xpd_morning_density,

				'xpd_decant_hydro_reading' => $xpd_decant_hydro_reading,

				'xpd_decant_temp' => $xpd_decant_temp,

				'xpd_decant_density' => $xpd_decant_density,

				'created_date' => date("Y-m-d H:i:s")

			);

			if($query_type != ""){

				$update = $this->Service_model_15->update("sh_daily_density", array("id" => $query_type), $data);

			}else{

			$insert = $this->Service_model_15->master_insert("sh_daily_density", $data);

			}

			echo $this->json_data("1", "Done", "");

		} else {

			echo $this->json_data("3", "Token expired. Please login again. ", "");

		}

	}else{

		echo $this->json_data("0", "Parameter Not passed", "");

	}

}

public function add_tank_density() {

	$data = $this->input->get_post('data');

	$token = $this->input->get_post('token');

	$date = $this->input->get_post('date');

	$pamoutnew = json_decode($data, TRUE);

	if ($token != "" && $date != "") {

		$this->load->model('Service_model_15');

		$list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

		if ($list) {
		
			$checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_daily_tank_density", array("date" => $date, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

			if ($checkentry) {

				echo $this->json_data("0", "Sorry you already added detail.", "");

				die();

			}
			$nddeate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
			$checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_daily_tank_density", array("date" => $nddeate, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

			if (!$checkentry) {

				echo $this->json_data("0", "Sorry, Please Add Previous Density of : " . date('d-m-Y', strtotime($nddeate)), "");

                            die();

			}

			$id = $list[0]['id'];

			$location_id = $list[0]['l_id'];

			foreach($pamoutnew as $detail){

			$data = array(

				'user_id' => $id,

				'date' => $date,

				'tank_id' => $detail['tankId'],

				'type' => $detail['fuelType'],

				'location_id' => $location_id,

				'hydro_reading' => $detail['hydrometerReading'],

				'temp' => $detail['temperature'],

				'density' => $detail['density'],

				'created_date' => date("Y-m-d H:i:s")

			);

			$insert = $this->Service_model_15->master_insert("sh_daily_tank_density", $data);

			}

			echo $this->json_data("1", "Done", "");

		} else {

			echo $this->json_data("3", "Token expired. Please login again. ", "");

		}

	}else{

		echo $this->json_data("0", "Parameter Not passed", "");

	}

}



    public function index() {

        echo "PaloilApp";

    }



    public function Squadli_versioversion() {

        echo $this->json_data("1", "", "2");

    }



    public function get_content($URL) {

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

            $row = $this->Service_model_15->master_num_rows("customer_master", array("email" => $email, "status" => 1));

            if ($row == 0) {

                $email = strtolower($email);

                $insert = $this->Service_model_15->master_fun_insert("customer_master", array("name" => $name, "type" => $type, "email" => $email, "password" => $password, "mobile" => $mobile, "active" => '0'));

                $config['mailtype'] = 'html';

                $this->email->initialize($config);

                $message = "Hello $name. <br/><br/>";

                $message .= "Thank you for registering with us at Squadli.<br/>

                To complete your registration please verify your account by clicking the button below..<br/><br/>";

                $base = base_url();

                $message .= "<a href='" . $base . "service/Verify/" . md5($insert) . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Click To Email Verification</a><br/><br/>";

                $message .= "If you are having problems, simply email us at: <a href='mailto:support@squadli.com'>support@squadli.com</a> for assistance. <br/>";

                $message .= "Thanks <br/>The Squadli<br/><br/>";

                $message .= "<hr><br/><a href='www.directivecommunication.net'>directivecommunication.net</a> <br/>� 2016 <a href='directivecommunication.net' >directivecommunication.net</a>  Avalon #1, Jalan Carmazzi, Mawang Kelod, Ubud, Bali - Indonesia<br/>";



                //$this->email->to($email);

//              $this->email->to($email.',jabir@virtualheight.com');

                //$this->email->from('support@squadli.com', 'Squadli');

                //$this->email->subject("Squadli - Welcome, Please Verify Your New Account");

                //$this->email->message($message);

                //$this->email->send();

                send_mail($email, 'Squadli - Welcome, Please Verify Your New Account', $message);





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

        $update = $this->Service_model_15->master_fun_update_1("customer_master", $id, $data1);

        echo "thank you your account has been successfully verified";

    }



    public function verify1($id) {

        $data1 = array("active" => '1');

        $update = $this->Service_model_15->master_fun_update("customer_master", $id, $data1);

    }



    public function login() {

        $email = $this->input->get_post('email');

        $password = $this->input->get_post('password');

        if ($email != NULL && $password != NULL) {

            $result = $this->login_model->checkloginuser($email, $password);

            if ($result != "") {

                $data = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("UserEmail" => $email, "UserPassword" => $password, "status" => 1, "Active" => 1), array("id", "asc"));

                $uniqueId = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);

                $data1 = array("token" => $uniqueId);

                $Active = $data[0]['Active'];

                $id = $data[0]['id'];

                $update = $this->Service_model_15->master_fun_updateid("shusermaster", $id, $data1);

                if ($Active == '1') {

                    $row = $this->Service_model_15->master_num_rows("shusermaster", array("id" => $data[0]['id'], "status" => 1, "Active" => 1));

                    $locationname = $this->Service_model_15->master_fun_get_tbl_val("sh_location", array("l_id" => $data[0]['l_id'], "status" => 1));

                    $membercount = $this->Service_model_15->master_num_rows("shusermaster", array("id" => $data[0]['id'], "status" => 1, "Active" => 1));

                    $data[0]['team_count'] = "$row";

                    $list = array();

                    $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("id" => $data[0]['id'], "status" => 1, "Active" => 1), array("id", "id"));

                    $user_team = array();

                    $user_team = $this->Service_model_15->select_all("shusermaster", $id);

                    //echo $this->db->last_query();

                    $petrol = $this->Service_model_15->get_pump_list('P', $data[0]['l_id']);

                    $diesel = $this->Service_model_15->get_pump_list('D', $data[0]['l_id']);

                    $oil = $this->Service_model_15->get_pump_list_oil('O', $data[0]['l_id']);

                    $expensein = $this->Service_model_15->expensein_type_list();

                    $location_data = $this->Service_model_15->master_fun_get_tbl_val("sh_location", array("l_id" => $data[0]['l_id'], "status" => 1), array("l_id", "l_id"));

                    $data[0]['location_name'] = $location_data[0]['l_name'];

                    $fina_Array = array();

                    foreach ($expensein as $expenseindetail) {

                        $expenseindetail['expensein_detail'] = $this->Service_model_15->selectbyidarray('sh_expensein_types', $data[0]['company_id'], 'comapny_id');

                        array_push($fina_Array, $expenseindetail);

                    }

                    $data[0]['token'] = $uniqueId;

                    $meter_reading['petrol'] = $petrol;

                    $meter_reading['diesel'] = $diesel;

                    $data[0]['meter_reading'] = $meter_reading;

                    $data[0]['oil_type'] = $oil;

                    $data[0]['expensein_type'] = $fina_Array;

                    $data[0]['patrol_buy_vat'] = 20;

                    $data[0]['diesel_buy_vat'] = 20;

                    $data[0]['patrol_sell_vat'] = 20;

                    $data[0]['diesel_sell_vat'] = 20;

					$data[0]['xp_patrol_sell_vat'] = 20;

                    $data[0]['xp_diesel_sell_vat'] = 20;

                    $data[0]['gst'] = 9;

                    $data[0]['oil_benift'] = 5;

                    $data[0]['type'] = 'employee';

                    $data[0]['location'] = $locationname[0]['l_name'];

                    $data[0]['xp_type'] = $locationname[0]['xp_type'];

					$data[0]['xpp_type'] = $locationname[0]['xpp_type'];

					$data[0]['xpd_type'] = $locationname[0]['xpd_type'];

                    $data[0]['vesion_code'] = array("vesion_code" => "$this->version_code", "flag" => "true");

                    $data2 = $this->Service_model_15->master_fun_get_tbl_val_service("shusermaster", array("UserEmail" => $email, "UserPassword" => $password, "status" => 1, "Active" => 1), array("id", "asc"));

                    echo $this->json_data("1", "", array($data[0]));

                } else {

                    echo $this->json_data("0", "Please Verify Your Email Address", "");

                }

            } else {

                $result = $this->login_model->checklogincompany($email, $password);



                if ($result != "") {

                    $data = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("email" => $email, "password" => $password, "status" => 1), array("id", "asc"));

                    $uniqueId = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);

                    $data1 = array("token" => $uniqueId);

                    $Active = $data[0]['active'];

                    $id = $data[0]['id'];

                    $update = $this->Service_model_15->master_fun_updateid("sh_com_registration", $id, $data1);

                    if ($Active == '1') {

                        $row = $this->Service_model_15->master_num_rows("sh_com_registration", array("id" => $data[0]['id'], "status" => 1));

                        $membercount = $this->Service_model_15->master_num_rows("sh_com_registration", array("id" => $data[0]['id'], "status" => 1));

                        $data[0]['team_count'] = "$row";

                        $list = array();

                        $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("id" => $data[0]['id'], "status" => 1), array("id", "id"));

                        // $user_team = array();

                        // $user_team = $this->Service_model_15->select_all("shusermaster",$id);

                        $petrol = $this->Service_model_15->get_pump_list('P', '');

                        $diesel = $this->Service_model_15->get_pump_list('D', '');

                        $oil = $this->Service_model_15->oil_type_list();

                        $expensein = $this->Service_model_15->expensein_type_list();

                        $fina_Array = array();

                        foreach ($expensein as $expenseindetail) {

                            $expenseindetail['expensein_detail'] = $this->Service_model_15->selectbyidarray('sh_expensein_types', $expenseindetail['id'], 'exps_id');

                            array_push($fina_Array, $expenseindetail);

                        }

                        $data[0]['token'] = $uniqueId;

                        $meter_reading['petrol'] = $petrol;

                        $meter_reading['diesel'] = $diesel;

                        $data[0]['meter_reading'] = $meter_reading;

                        $data[0]['oil_type'] = $oil;

                        $data[0]['expensein_type'] = $fina_Array;

                        $data[0]['patrol_buy_vat'] = 20;

                        $data[0]['diesel_buy_vat'] = 20;

                        $data[0]['patrol_sell_vat'] = 20;

                        $data[0]['diesel_sell_vat'] = 20;

                        $data[0]['xp_patrol_sell_vat'] = 20;

                        $data[0]['xp_diesel_sell_vat'] = 20;

                        $data[0]['gst'] = 9;

                        $data[0]['oil_benift'] = 5;

                        $data[0]['type'] = 'company';

                        $data[0]['location'] = "";

                        $data[0]['xp_type'] = "";

						$data[0]['xpp_type'] = $locationname[0]['xpp_type'];

						$data[0]['xpd_type'] = $locationname[0]['xpd_type'];

                        $data[0]['vesion_code'] = array("vesion_code" => "$this->version_code", "flag" => "true");

                        $data2 = $this->Service_model_15->master_fun_get_tbl_val_service_1("sh_com_registration", array("email" => $email, "password" => $password, "status" => 1), array("id", "asc"));

                        echo $this->json_data("1", "", array($data[0]));

                    } else {

                        echo $this->json_data("0", "Please Verify Your Email Address", "");

                    }

                } else {

                    echo $this->json_data("0", "We could not find the account that associated with $email", "");

                }

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function pump_list() {

        $data = $this->Service_model_15->get_active_record_Pump();

        echo $this->json_data("1", "", $data);

    }



    public function all_list() {

    ///////////////////////vishal 11-4 start

        $token = $this->input->get_post('token');

        $login_type = $this->input->get_post('login_type');

        $location = "";

        $company = "";

        if ($token != "") {

            $tokendata = $this->Service_model_15->master_fun_get_tbl_val_3("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "asc"));



            if ($login_type != "company") {

                if ($tokendata) {

                    $location = $tokendata['0']['l_id'];

                    $company = $tokendata['0']['company_id'];

                } else {

                    echo $this->json_data("3", "Token expired. Please login again.", "");

                    die();

                }

            }

        }

        $locationname = $this->Service_model_15->master_fun_get_tbl_val("sh_location", array("l_id" => $tokendata[0]['l_id'], "status" => 1));





        $petrol = $this->Service_model_15->get_pump_list('P', $location);

        //$data['petrol'] = $petrol;

        $diesel = $this->Service_model_15->get_pump_list('D', $location);

        //$data['diesel'] = $diesel;

        //$oil = $this->Service_model_15->oil_type_list();

        $oil = $this->Service_model_15->get_pump_list_oil('O', $location);



        $expensein = $this->Service_model_15->expensein_type_list();

        $fina_Array = array();

        foreach ($expensein as $expenseindetail) {

            $expenseindetail['expensein_detail'] = $this->Service_model_15->selectbyidarray('sh_expensein_types', $company, 'comapny_id');

            array_push($fina_Array, $expenseindetail);

        }

        $location_data = $this->Service_model_15->master_fun_get_tbl_val("sh_location", array("l_id" => $location, "status" => 1), array("l_id", "l_id"));

        $data['location'] = $location_data[0]['l_name'];

        //$data['oil'] = $oil;

        $meter_reading['petrol'] = $petrol;

        $meter_reading['diesel'] = $diesel;

        $data['meter_reading'] = $meter_reading;

        $data['oil_type'] = $oil;

        $data['expensein_type'] = $fina_Array;

        $data['patrol_buy_vat'] = 20;

        $data['diesel_buy_vat'] = 20;

        $data['patrol_sell_vat'] = 20;

        $data['diesel_sell_vat'] = 20;

        $data['xp_patrol_sell_vat'] = 20;

        $data['xp_diesel_sell_vat'] = 20;

        $data['gst'] = 9;

        $data['oil_benift'] = 5;

        $data['location'] = $locationname[0]['l_name'];

        $data['xp_type'] = $locationname[0]['xp_type'];

        $data['xpp_type'] = $locationname[0]['xpp_type'];

        $data['xpd_type'] = $locationname[0]['xpd_type'];

        $data['vesion_code'] = $finalarray = array("vesion_code" => "$this->version_code", "flag" => "true");

        echo $this->json_data("1", "", array($data));

    }



    ///////////////////////vishal 11-4 end

    public function forget_password() {

        $this->load->library('email');

        $email = $this->input->get_post('email');

        if ($email != NULL) {



            $row = $this->Service_model_15->master_fun_get_tbl_val_1("shusermaster", array("UserEmail" => $email, "status" => 1), array("id", "asc"));

            $title = $this->config->item('title');

            if ($row != null) {

                $uniqueId = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5);

                //print_r($row); die();

                $password = $row[0]['UserPassword'];

                $user = $row[0]['UserFName'];

                //print_r($password);

                $config['mailtype'] = 'html';

                $this->email->initialize($config);

                $message = "Hi " . ucwords($user) . ",<br/><br/>";

                $message .= "We received a request that you forgot the password for your Shri Hari account.<br/><br/>";

                $base = base_url();

                $message .= "<a href='" . $base . "login/get_password/" . $uniqueId . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Click To Reset password </a><br/><br/>";

                $message .= "If you did not make this request, please ignore this email or reply to let us know.<br/><br/>";

                $message .= "Thanks <br/> Shri Hari";

                send_mail($email, $title . ' forgotten Password', $message);

                $data1 = array("Rs" => $uniqueId);

                $insert = $this->Service_model_15->master_fun_update_UserEmail1('shusermaster', $email, $data1);

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

        $data1 = array("id" => $id);

        //print_r($Rs);



        $result = $this->Service_model_15->get_terms($id);

        //print_r($result);

        $id1 = $result; //die();

        if ($result == "") {

            $this->session->set_flashdata('fail', 'This link is already used');

            redirect('login', 'refresh');

        }

        $this->form_validation->set_rules('AdminPassword', 'Password', 'required|trim');

        $UserPassword = $this->input->post('AdminPassword');

        $id1 = $this->input->post('id');

//      print_r($_POST); die();

//      echo $UserPassword;

        $data1 = array("id" => $id);

        //print_r($data);

        if ($this->form_validation->run() == FALSE) {

            $data1 = array("id" => $id);

            $this->load->view('user/header');

            $this->load->view('user/newpassword', $data1);

            $this->load->view('user/footer');

        } else {

            $data2 = array("UserPassword" => $UserPassword,

                "Rs" => '');

//          print_r($data1); die();



            $update = $this->Login_model->master_fun_update_2("AdminMaster", $id1, $data2);

//          print_r($update); die();

            $this->session->set_flashdata('success', 'Your Password Reset');

            redirect('login', 'refresh');

        }

    }



    public function view_profile() {

        $token = $this->input->get_post('token');

        if ($token != null) {

            $data = $this->Service_model_15->view_profile($token);

            echo $this->json_data("1", "", $data);

        } else {



            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function employee_detail() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $data = $this->Service_model_15->master_fun_get_tbl_val_3("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "asc"));

            if ($data) {

                $data = $this->Service_model_15->employee_detail("shusermaster", array("status" => 1, "Active" => 1), array("id", "asc"));

                echo $this->json_data("1", "", $data);

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function edit_profile() {

        $token = $this->input->get_post('token');

        //echo $user_id;

        $name = $this->input->get_post('name');

        $email = $this->input->get_post('email');

        $mobile = $this->input->get_post('mobile');

        //print_r($_POST); die();

        if ($token != "" && $name != "" && $email != "" && $mobile != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            //print_r($list);

            if ($list) {

                $user = $this->Service_model_15->userlist_active_record($token);



                if ($user) {



                    $email2 = $user[0]['UserEmail'];



                    if ($email2 == $email) {



                        //print_r("<pre>"); print_r($user); die();

                        $data = array(

                            "UserFName" => $name,

                            "UserEmail" => $email,

                            "UserMNumber" => $mobile,

                        );



                        $update = $this->Service_model_15->master_fun_update("shusermaster", $token, $data);

                        if ($update) {

                            echo $this->json_data("1", "Your Profile has been Updated", "");

                        }

                    } else {

                        $row = $this->Service_model_15->master_num_rows("shusermaster", array("UserEmail" => $email, "status" => 1, "Active" => 1));

                        if ($row == 0) {

                            $data = array(

                                "UserFName" => $name,

                                "UserEmail" => $email,

                                "UserMNumber" => $mobile,

                            );



                            $update = $this->Service_model_15->master_fun_update("shusermaster", $token, $data);

                            if ($update) {

                                echo $this->json_data("1", "Your Profile has been Updated", "");

                                //  array(array("msg" => "Your Profile has been Updated"))

                            }

                        } else {

                            echo $this->json_data("0", "Email Already Registered", "");

                        }

                    }

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    function addoil($location_id, $date) {



        $inventoryoil = $this->Service_model_15->get_inventory_detail('O', $location_id, $date);

        if ($inventoryoil) {

            

        } else {



            $newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

            $oildata = $this->Service_model_15->inventory_detail_for_add($location_id, $newdate, "o");



            if ($oildata) {

                $oil_total_amount = $oil_total_amount + $oildata->oil_total_amount;

                $salesdata = $this->Service_model_15->sels_detail_for_add($location_id, $newdate);

                if ($salesdata) {

                    $oil_total_amount = $oil_total_amount - $salesdata->oil_reading;

                }

            }





            $id = $list[0]['id'];

            $data = array(

                'user_id' => $id,

                'date' => $date,

                'location_id' => $location_id,

                'invoice_no' => '',

                'paymenttype' => '',

                'chequenumber' => '',

                'paidamount' => '',

                'fuel_type' => 'o',

                'p_stock' => '',

                'p_quantity' => '',

                'p_fuelamount' => '',

                'pv_taxamount' => '',

                'prev_p_stock' => '',

                'prev_p_price' => '',

                'p_ev' => '',

                'p_cess_tax' => '',

                'p_price' => '',

                'd_stock' => '',

                'd_quantity' => '',

                'd_fuelamount' => '',

                'dv_taxamount' => '',

                'prev_d_stock' => '',

                'prev_d_price' => '',

                'd_ev' => '',

                'd_cess_tax' => '',

                'd_price' => '',

                'o_type' => $oil_type,

                'o_quantity' => $o_quantity,

                'o_amount' => $oil_amount,

                'oil_cgst' => '',

                'oil_sgst' => '',

                'o_stock' => $o_stock,

                'oil_total_amount' => $oil_total_amount,

                'bank_name' => '',

                'prev_o_stock' => $prev_o_stock,

                "p_new_price" => '',

                "d_new_price" => '',

                "d_total_amount" => '',

                "p_total_amount" => '',

                'created_date' => date("Y-m-d H:i:s"),

                'deep_reading' => ''

            );

            $this->Service_model_15->master_insert("sh_inventory", $data);

        }

    }



    public function add_details() {

        //sales inventory 

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $oil_reading = $this->input->get_post('oil_reading');

        $p_tank_reading = $this->input->get_post('p_tank_reading');

        $d_tank_reading = $this->input->get_post('d_tank_reading');

        $xpp_tank_reading = $this->input->get_post('xpp_tank_reading');

        $xpd_tank_reading = $this->input->get_post('xpd_tank_reading');

        $p_deep_reading = $this->input->get_post('p_deep_reading');

        $d_deep_reading = $this->input->get_post('d_deep_reading');

		$xpp_deep_reading = $this->input->get_post('xpp_deep_reading');

        $xpd_deep_reading = $this->input->get_post('xpd_deep_reading');

        $p_total_selling = $this->input->get_post('p_total_selling');

        $d_total_selling = $this->input->get_post('d_total_selling');

		$xpp_total_selling = $this->input->get_post('xpp_total_selling');

        $xpd_total_selling = $this->input->get_post('xpd_total_selling');

        $p_selling_price = $this->input->get_post('p_selling_price');

        $d_selling_price = $this->input->get_post('d_selling_price');

		$xpp_selling_price = $this->input->get_post('xpp_selling_price');

        $xpd_selling_price = $this->input->get_post('xpd_selling_price');

        $p_sales_vat = $this->input->get_post('p_sales_vat');

        $d_sales_vat = $this->input->get_post('d_sales_vat');

		$xpp_sales_vat = $this->input->get_post('xpp_sales_vat');

        $xpd_sales_vat = $this->input->get_post('xpd_sales_vat');

        $d_testing = $this->input->get_post('d_testing');

        $p_testing = $this->input->get_post('p_testing');

		$xpd_testing = $this->input->get_post('xpd_testing');

        $xpp_testing = $this->input->get_post('xpp_testing');

        $cash_on_hand = $this->input->get_post('cash_on_hand');

        $oil_pure_benefit = $this->input->get_post('oil_pure_benefit');

        $data = $this->input->get_post('data');

        $pamoutnew = json_decode($data, TRUE);

        $myJSON = json_encode($_POST);

        $datap = $myJSON;

        $deep_data = $this->input->get_post('deep_data');

        $tank_reading = json_decode($deep_data, TRUE);

        $time = date('Y-m-d H:i:s');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $shift = $list[0]['shift'];

                $location_id = $list[0]['l_id'];

                $company_id = $list[0]['company_id'];

                $checkdata = $this->Service_model_15->master_fun_get_tbl_val("shdailyreadingdetails", array("location_id" => $location_id, "date" => $date, "status" => 1), array("id", "asc"));

                if ($checkdata) {

                    echo $this->json_data("0", "Sorry you already data added.", "");

                } else {

$checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_daily_tank_density", array("date" => $date, "status" => 1, "location_id" => $location_id), array("id", "asc"));

			if (!$checkentry) {

				echo $this->json_data("0", "Please Add Daily Tank density.", "");

				die();

			}

                    $checkdata = $this->Service_model_15->master_fun_get_tbl_val("shdailyreadingdetails", array("location_id" => $location_id, "status" => 1), array("id", "asc"));

                    if ($checkdata) {

                        $nddeate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                        $temp_prev = $this->Service_model_15->master_fun_get_tbl_val("shdailyreadingdetails", array("location_id" => $location_id, "date" => $nddeate, "status" => 1), array("id", "asc"));

                        if (!$temp_prev) {

                            echo $this->json_data("0", "Sorry, Please Add Previous Sales of : " . date('d-m-Y', strtotime($nddeate)), "");

                            die();

                        }

                    }



                    $data1 = array(

                        "UserId" => $id,

                        "location_id" => $location_id,

                        "date" => $date,

                        "data" => $data,

                        "shift" => $shift,

                        "oil_reading" => $oil_reading,

                        "p_tank_reading" => $p_tank_reading,

                        "d_tank_reading" => $d_tank_reading,

                        "p_deep_reading" => $p_deep_reading,

                        "d_deep_reading" => $d_deep_reading,

                        "p_total_selling" => $p_total_selling,

                        "d_total_selling" => $d_total_selling,

                        "p_selling_price" => $p_selling_price,

                        "d_selling_price" => $d_selling_price,

                        "xpp_tank_reading" => $xpp_tank_reading,

                        "xpd_tank_reading" => $xpd_tank_reading,

                        "xpp_deep_reading" => $xpp_deep_reading,

                        "xpd_deep_reading" => $xpd_deep_reading,

                        "xpp_total_selling" => $xpp_total_selling,

                        "xpd_total_selling" => $xpd_total_selling,

                        "xpp_selling_price" => $xpp_selling_price,

                        "xpd_selling_price" => $xpd_selling_price,

                        "p_sales_vat" => $p_sales_vat,

                        "d_sales_vat" => $d_sales_vat,

						"xpp_sales_vat" => $xpp_sales_vat,

                        "xpd_sales_vat" => $xpd_sales_vat,

                        "oil_pure_benefit" => $oil_pure_benefit,

                        "all_data" => $datap,

                        "p_testing" => $p_testing,

                        "d_testing" => $d_testing,

                        "xpp_testing" => $xpp_testing,

                        "xpd_testing" => $xpd_testing,

                        "created_at" => date("Y-m-d"),

                        "cash_on_hand" => $cash_on_hand

                    );



                    $insertid = $this->Service_model_15->master_insert("shdailyreadingdetails", $data1);

                    foreach ($tank_reading as $row) {

                        $data1 = array(

                            "sales_id" => $insertid,

                            "location_id" => $location_id,

                            "date" => $date,

                            "tank_id" => $row['tank_id'],

                            "deepreading" => $row['deepReading'],

                            "volume" => $row['volume'],

                            "tank_name" => $row['reading'],

                            "type" => $row['fuel_type'],

                            "created_at" => date("Y-m-d H:i:s")

                        );

                        $this->Service_model_15->master_insert("sh_tank_wies_reading_sales", $data1);

                    }

                    if ($pamoutnew != "") {

                        $p_total_selling = 0;

                        $d_total_selling = 0;

                        $newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                        foreach ($pamoutnew as $row) {

                            $fuelType = $row['fuelType'];

                            if ($fuelType == 'p' || $fuelType == 'd' || $fuelType == 'xpp' || $fuelType == 'xpd') {

                                $pump_id = $row['id'];

                                $reading = $row['Reading'];

                                $get_reset = $this->Service_model_15->master_fun_get_tbl_val("sh_reset_pump", array("pump_id" => $pump_id, "date" => $date, "status" => 1), array("id", "asc"));

                                if ($get_reset) {

                                    $get_preding = $this->Service_model_15->master_fun_get_tbl_val("shreadinghistory", array("PumpId" => $pump_id, "date" => $newdate, "status" => 1), array("id", "asc"));

                                    $prev_reding = $get_preding[0]['Reading'];

                                    $reset_reding = $get_reset[0]['reading'];

                                    $restqty = $reset_reding - $prev_reding;

                                    $row['qty'] = $row['qty'] + $restqty;

                                    if ($fuelType == 'p') {

                                        $p_total_selling = $p_total_selling + $row['qty'];

                                    }

                                    if ($fuelType == 'd') {

                                        $d_total_selling = $d_total_selling + $row['qty'];

                                    }

                                } else {

                                    if ($fuelType == 'p') {

                                        $p_total_selling = $p_total_selling + $row['qty'];

                                    }

                                    if ($fuelType == 'd') {

                                        $d_total_selling = $d_total_selling + $row['qty'];

                                    }

                                }

                                $data1 = array(

                                    "UserId" => $id,

                                    "RDRId" => $insertid,

                                    "Type" => $fuelType,

                                    "date" => $date,

                                    "PumpId" => $pump_id,

                                    "Reading" => $reading,

                                    "created_at" => $time,

                                    "qty" => $row['qty']);

                                $this->Service_model_15->master_insert("shreadinghistory", $data1);

                            }

                            if ($fuelType == 'o') {

                                $pump_id = $row['id'];

                                $fuelType = $row['fuelType'];

                                $reading = $row['value'];

                                $data1 = array(

                                    "UserId" => $id,

                                    "RDRId" => $insertid,

                                    "Type" => $fuelType,

                                    "date" => $date,

                                    "PumpId" => $pump_id,

                                    "Reading" => $reading,

                                    "created_at" => $time,

                                    "qty" => $row['qty']);

                                $o_insert_id = $this->Service_model_15->master_insert("shreadinghistory", $data1);

                                

                                $pdata = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_daily_price", array("o_p_id" => $pump_id, "status" => 1,'date'=>$newdate), array("id", "id"));

								if($pdata){

									$pdata[0]['spacket_value'] = $pdata[0]['bay_price'];

									$pdata[0]['packet_value'] = $pdata[0]['sel_price'];

									$pdata[0]['location_id'] = $pdata[0]['location_id'];

									$pdata[0]['p_type'] = $pdata[0]['packet_type'];

									$pdata[0]['stock'] = $pdata[0]['stock'];

								}else{

									$pdata = $this->Service_model_15->master_fun_get_tbl_val("shpump", array("id" => $pump_id, "status" => 1), array("id", "id"));

								}

                                $p_stock = $pdata[0]['stock'];



                                $qty = floatval($reading);



                                $t_stock = $p_stock - $qty;

                                $this->Service_model_15->update("shpump", array("id" => $pump_id), array("stock" => $t_stock));

                                //$this->oil_pumb_daily_price($date, $qty, $location_id);

                                $data = array("date" => $date,

                                    "o_p_id" => $pump_id,

                                    "bay_price" => $pdata[0]['spacket_value'],

                                    "sel_price" => $pdata[0]['packet_value'],

                                    "location_id" => $pdata[0]['location_id'],

                                    "stock" => $t_stock,

                                    "packet_type" => $pdata[0]['p_type']);

                                $this->Service_model_15->master_insert("sh_oil_daily_price", $data);

                                $history_data = array('inventory_id' => $o_insert_id,

                                    'p_reading' => $p_stock,

                                    'n_reading' => $qty,

                                    'type' => "Update(-)",

                                    'f_reading' => $t_stock);

                                $this->Service_model_15->master_insert("sh_oil_inventory_history", $history_data);

                            }

                        }

                        //  $pdata = $this->Service_model_15->master_fun_get_tbl_val("shpump", array("location_id" => $location_id, "status" => 1), array("id", "id"));



                        $pdata = $this->Service_model_15->master_fun_get_tbl_val("shpump", array("location_id" => $location_id, "status" => 1, "type" => "o"), array("id", "id"));



                        foreach ($pdata as $p) {

                            $pump_id = $p['id'];

                            $reading = $p['stock'];

                            $parice = array();

                            if ($pump_id != "") {

                                $parice = $this->Service_model_15->master_fun_get_tbl_val("shreadinghistory", array("date" => $date, "status" => 1, "PumpId" => $pump_id), array("id", "asc"));

                            }

                            if (empty($parice)) {

                                $data1 = array(

                                    "UserId" => $id,

                                    "RDRId" => $insertid,

                                    "Type" => "o",

                                    "date" => $date,

                                    "PumpId" => $pump_id,

                                    "Reading" => 0,

                                    "created_at" => $time,

                                    "qty" => $reading);

                                $o_insert_id = $this->Service_model_15->master_insert("shreadinghistory", $data1);

                            }

                            if ($pump_id != "") {

                                $parice2 = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_daily_price", array("date" => $date, "o_p_id" => $pump_id), array("id", "asc"));

                            }

                            if (empty($parice2)) {

								$newpad = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_daily_price", array("o_p_id" => $pump_id, "status" => 1,'date'=>$newdate), array("id", "id"));

								

								//$this->load->helper(array('swift'));

								//send_mail('vishal@virtualheight.com', $this->db->last_Query(), json_encode($newpad));

								if($newpad){

                                $data = array("date" => $date,

                                    "o_p_id" => $pump_id,

                                    "bay_price" => $newpad[0]['bay_price'],

                                    "sel_price" => $newpad[0]['sel_price'],

                                    "location_id" => $newpad[0]['location_id'],

                                    "stock" => $newpad[0]['stock'],

                                    "packet_type" => $newpad[0]['packet_type']

									);

								}else{

									$data = array("date" => $date,

                                    "o_p_id" => $pump_id,

                                    "bay_price" => $p['spacket_value'],

                                    "sel_price" => $p['packet_value'],

                                    "location_id" => $p['location_id'],

                                    "stock" => $p['stock'],

                                    "packet_type" => $p['p_type']

									);

								}

                                $o_insert_id = $this->Service_model_15->master_insert("sh_oil_daily_price", $data);

                            }

                        }





                        $this->Service_model_15->master_fun_updatforid("shdailyreadingdetails", $insertid, array("p_total_selling" => $p_total_selling - $p_testing,

                            "d_total_selling" => $d_total_selling - $d_testing));



                        $get_prev_daystock = $this->Service_model_15->master_fun_get_tbl_val("shdailyreadingdetails", array("location_id" => $location_id, "date" => $newdate, "status" => 1), array("id", "asc"));

                        $ev_p = 0;

                        $ev_d = 0;

                        if ($get_prev_daystock) {

                            $get_prev_purches_petrol = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("location_id" => $location_id, "date" => $newdate, "status" => 1, "fuel_type" => 'p'), array("id", "asc"));

                            $get_prev_purches_diesal = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("location_id" => $location_id, "date" => $newdate, "status" => 1, "fuel_type" => 'd'), array("id", "asc"));

                            if ($get_prev_purches_petrol) {

                                $ev_p = $p_tank_reading - (($get_prev_daystock['0']['p_tank_reading'] + $get_prev_purches_petrol['0']['p_quantity']) - ($p_total_selling - $p_testing));

                                $ev_d = $d_tank_reading - (($get_prev_daystock['0']['d_tank_reading'] + $get_prev_purches_diesal['0']['d_quantity']) - ($d_total_selling - $d_testing));

                            }

                        }

                        $slidt = array();

                        if ($ev_p != 0 || $ev_D != 0) {

                            $devicelist = $this->Service_model_15->master_fun_get_tbl_val("sh_users_device", array("user_id" => $company_id, "status" => 1), array("id", "asc"));

                            foreach ($devicelist as $d) {



                                if ($d['device_type'] == 'android') {

                                    array_push($slidt, $d['device_id']);

                                }

                            }

                        }

                        if ($ev_p != 0) {

                            $this->android_notification($slidt, "Overshot in Petrol", "", "");

                        }

                        if ($ev_d != 0) {

                            $this->android_notification($slidt, "Overshot in Diesel", "", "");

                        }

                        if ($insertid) {



                            //echo $this->json_data("1", "Reading add successfully (".$d_tank_reading." - (".$get_prev_daystock['0']['d_tank_reading']." + ".$get_prev_purches_diesal['0']['d_quantity']." - ".$d_total_selling." - ".$d_testing." )) == (".$p_tank_reading ."- (".$get_prev_daystock['0']['p_tank_reading']." + ".$get_prev_purches_petrol['0']['p_quantity']." - ".$p_total_selling." - ".$p_testing." ))", "");

                            echo $this->json_data("1", "Reading add successfully " . $ev_d . " " . $ev_p, "");

                            $this->set_stock($date, $location_id);

                            $this->addoil($location_id, $date);

                        } else {

                            echo $this->json_data("0", "Some thing is Wrong Please try again", "");

                        }

                    }

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

            die();

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

		$this->addnewdatainoil();

    }



    public function add_expense() {



        $token = $this->input->get_post('token');

        $date2 = $this->input->get_post('date');

        $amount = $this->input->get_post('amount');

        $reson = $this->input->get_post('reson');

        $expense_id = $this->input->get_post('expense_id');

        $data = $this->input->get_post('data');

        $pamoutnew = json_decode($data, TRUE);

        $myJSON = json_encode($_POST);

        $datap = $myJSON;

        $time = $date = date('Y-m-d H:i:s');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];



                $data1 = array(

                    "user_id" => $id,

                    "location_id" => $location_id,

                    "all_data" => $data,

                    "date" => $date2,

                    "amount" => $amount,

                    "reson" => $reson,

                    'expense_id' => $expense_id);



                $insertid = $this->Service_model_15->master_insert("sh_expensein_details", $data1);



                // if($pamoutnew != ""){

                // foreach($pamoutnew as $row){

                // $ex_id = $row['id'];

                // $ex_value = $row['value'];

                // $comment = "";

                // if($row['title'] != "dropdown"){

                // $comment = $row['title'];

                // }

                // $data = array(

                // "UserId" => $id,

                // "ex_id" =>  $insertid,

                // "expensein_id"=> $ex_id,

                // "value" => $ex_value,

                // "date" => $date2,

                // "created_at"=>$time,

                // "comment"=>$comment

                // );

                // $insert = $this->Service_model_15->master_insert("sh_expensein_d_history",$data);

                // }

                // }

                echo $this->json_data("1", "Expense add successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function dailyprice_add() {

        $this->load->model('Service_model_15');

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $pet_price = $this->input->get_post('pet_price');

        $dis_price = $this->input->get_post('dis_price');

        $xp_pet_price = $this->input->get_post('xp_pet_price');

        $xp_dis_price = $this->input->get_post('xp_dis_price');



        if ($token != "" && $date != "" && $pet_price != "" && $dis_price != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {



                $id = $list[0]['l_id'];

                $checkdata = $this->Service_model_15->master_fun_get_tbl_val("sh_dailyprice", array("user_id" => $id, "date" => $date, "status" => 1), array("id", "asc"));



                if ($checkdata) {

                    echo $this->json_data("0", "Sorry you already added price.", "");

                } else {

                    $data = array(

                        'user_id' => $id,

                        'date' => $date,

                        'pet_price' => $pet_price,

                        'dis_price' => $dis_price,

                        'xp_pet_price' => $xp_dis_price,

                        'xp_dis_price' => $xp_pet_price,

                        'created_date' => date("Y-m-d H:i:sa")

                    );

                    $insert = $this->Service_model_15->master_insert("sh_dailyprice", $data);

                    $newdate = date('Y-m-d', strtotime($date . '-1 days'));

                    $vat_data = $this->Service_model_15->master_fun_get_tbl_val("vat_list", array("date"=>$newdate), array("id", "id"));

                    $vat_array = array("vat_per"=>$vat_data[0]['vat_per'],

                                       "date"=>$date);

                    $this->Service_model_15->master_insert("vat_list", $vat_array);

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }

	

	

	public function xp_add_inventory() { 

        // add fuel inventory 

        $this->load->model('Service_model_15');

        //coman 

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');



        $p_invoice_no = $this->input->get_post('p_invoice_no');

        $d_invoice_no = $this->input->get_post('d_invoice_no');

        $p_paymenttype = $this->input->get_post('p_paymenttype');

        $d_paymenttype = $this->input->get_post('d_paymenttype');

        $p_chequenumber = $this->input->get_post('p_chequenumber');

        $d_chequenumber = $this->input->get_post('d_chequenumber');

        //$paidamount = $this->input->get_post('paidamount');

        $fuel_type = $this->input->get_post('fuel_type');

        $p_bank_name = $this->input->get_post('p_bank_name');

        $d_bank_name = $this->input->get_post('d_bank_name');

        $deep_reading = $this->input->get_post('deep_reading');

        // petrol inventory

        $p_stock = $this->input->get_post('p_stock');

        $p_quantity = $this->input->get_post('p_quantity');

        $p_fuelamount = $this->input->get_post('p_fuelamount');

        $pv_taxamount = $this->input->get_post('pv_taxamount');

        $p_price = $this->input->get_post('p_price');

        $prev_p_stock = $this->input->get_post('prev_p_stock');

        $prev_p_price = $this->input->get_post('prev_p_price');

        $p_ev = $this->input->get_post('p_ev');

        $p_cess_tax = $this->input->get_post('p_cess_tax');

        // Disel inventory

        $d_stock = $this->input->get_post('d_stock');

        $d_quantity = $this->input->get_post('d_quantity');

        $d_fuelamount = $this->input->get_post('d_fuelamount');

        $dv_taxamount = $this->input->get_post('dv_taxamount');

        $d_price = $this->input->get_post('d_price');

        $prev_d_stock = $this->input->get_post('prev_d_stock');

        $prev_d_price = $this->input->get_post('prev_d_price');

        $d_ev = $this->input->get_post('d_ev');

        $d_cess_tax = $this->input->get_post('d_cess_tax');

        // Oil inventory

        $oil_type = $this->input->get_post('oil_type');

        $o_quantity = $this->input->get_post('o_quantity');

        $oil_amount = $this->input->get_post('oil_amount');

        $oil_cgst = $this->input->get_post('oil_cgst');

        $oil_sgst = $this->input->get_post('oil_sgst');

        $o_stock = $this->input->get_post('o_stock');

        $prev_o_stock = $this->input->get_post('prev_o_stock');

        $oil_total_amount = $this->input->get_post('oil_total_amount');

        $data = $this->input->get_post('oil_data');

        $pamoutnew = json_decode($data, TRUE);

        $tankdata = $this->input->get_post('deep_reading');

        $tank_reading = json_decode($tankdata, TRUE);

        $p_new_price = $this->input->get_post('p_new_price');

        $d_new_price = $this->input->get_post('d_new_price');

        $p_total_amount = $this->input->get_post('p_total_amount');

        $d_total_amount = $this->input->get_post('d_total_amount');

		

        $p_vehicle_no = $this->input->get_post('p_vehicle_no');

        $p_invoice_density = $this->input->get_post('p_invoice_density');

        $p_observer_density = $this->input->get_post('p_observer_density');

        $p_sample = $this->input->get_post('p_sample');

		$p_sample_list = json_decode($p_sample, TRUE);

		

		$d_vehicle_no = $this->input->get_post('d_vehicle_no');

        $d_invoice_density = $this->input->get_post('d_invoice_density');

        $d_observer_density = $this->input->get_post('d_observer_density');

        $d_sample = $this->input->get_post('d_sample');

		$d_sample_list = json_decode($d_sample, TRUE);

		

		$qty_in_tank = $this->input->get_post('qty_in_tank');

		$qty_in_tank_list = json_decode($qty_in_tank, TRUE);

		

        

		

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                if ($fuel_type != 'o') {

                    $checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => 'xpp', "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                    if ($checkentry) {

                        echo $this->json_data("0", "Sorry you already added detail.", "");

                        die();

                    }

                    $checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => 'xpd', "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                    if ($checkentry) {

                        echo $this->json_data("0", "Sorry you already added detail.", "");

                        die();

                    }

                } else {

                    $checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                    if ($checkentry) {

                        echo $this->json_data("0", "Sorry you already added detail.", "");

                        die();

                    }

                }

                // $checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                // if ($checkentry) {

                // echo $this->json_data("0", "Sorry you already added detail.", "");

                //	die();

                // } else {

                //$tempcheck_prev = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));



                if ($fuel_type != 'o') {

                    $nddeate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                    $newtemp_prev = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                    if ($newtemp_prev) {

                        $temp_prev = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $nddeate, "fuel_type" => 'xpp', "status" => 1, "location_id" => $list['0']['l_id'], "date" => $nddeate), array("id", "asc"));

                        if (!$temp_prev) {

                            echo $this->json_data("0", "Sorry, Please Add Previous Inventory of : " . date('d-m-Y', strtotime($nddeate)), "");

                            die();

                        }

                        $temp_prev = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $nddeate, "fuel_type" => 'xpd', "status" => 1, "location_id" => $list['0']['l_id'], "date" => $nddeate), array("id", "asc"));

                        if (!$temp_prev) {

                            echo $this->json_data("0", "Sorry, Please Add Previous Inventory of : " . date('d-m-Y', strtotime($nddeate)), "");

                            die();

                        }

                        $temp_prev = $this->Service_model_15->master_fun_get_tbl_val("shdailyreadingdetails", array("date" => $nddeate, "status" => 1, "location_id" => $list['0']['l_id'], "date" => $nddeate), array("id", "asc"));

                        if (!$temp_prev) {

                            echo $this->json_data("0", "Sorry, Please Add Previous Sales of : " . date('d-m-Y', strtotime($nddeate)), "");

                            die();

                        }

                    }

                }

                if ($fuel_type == 'o') {

                    $newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                    $oildata = $this->Service_model_15->inventory_detail_for_add($list['0']['l_id'], $newdate, "o");



                    if ($oildata) {

                        $oil_total_amount = $oil_total_amount + $oildata->oil_total_amount;

                        $salesdata = $this->Service_model_15->sels_detail_for_add($list['0']['l_id'], $newdate);



                        if ($salesdata) {

                            $oil_total_amount = $oil_total_amount - $salesdata->oil_reading;

                        }

                    }

                    $tankdata = $data;

                }



                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];

                if ($fuel_type == 'o') {

                    $data = array(

                        'user_id' => $id,

                        'date' => $date,

                        'location_id' => $location_id,

                        'fuel_type' => 'o',

                        'o_type' => $oil_type,

                        'o_quantity' => $o_quantity,

                        'o_amount' => $oil_amount,

                        'oil_cgst' => $oil_cgst,

                        'oil_sgst' => $oil_sgst,

                        'o_stock' => $o_stock,

                        'oil_total_amount' => $oil_total_amount,

                        'prev_o_stock' => $prev_o_stock,

                        'created_date' => date("Y-m-d H:i:s")

                    );

                    $insert = $this->Service_model_15->master_insert("sh_inventory", $data);

                    foreach ($pamoutnew as $row) {

                        $data1 = array(

                            "inv_id" => $insert,

                            "oil_id" => $row['oil_id'],

                            "qty" => $row['qty'],

                            "ltr" => $row['ltr'],

                            "created_at" => date("Y-m-d H:i:s"));

                        $this->Service_model_15->master_insert("sh_oil_inventory", $data1);

                    }

                } else {

                    $data = array(

                        'user_id' => $id,

                        'date' => $date,

                        'location_id' => $location_id,

                        'invoice_no' => $p_invoice_no,

                        'paymenttype' => $p_paymenttype,

                        'chequenumber' => $p_chequenumber,

                        'fuel_type' => 'xpp',

                        'p_stock' => $p_stock,

                        'p_quantity' => $p_quantity,

                        'p_fuelamount' => $p_fuelamount,

                        'pv_taxamount' => $pv_taxamount,

                        'prev_p_stock' => $prev_p_stock,

                        'prev_p_price' => $prev_p_price,

                        'p_ev' => $p_ev,

                        'p_cess_tax' => $p_cess_tax,

                        //'p_tankerreading' => $p_tankerreading,

                        'p_price' => $p_price,

                        'o_type' => $oil_type,

                        'o_quantity' => $o_quantity,

                        'o_amount' => $oil_amount,

                        'oil_cgst' => $oil_cgst,

                        'oil_sgst' => $oil_sgst,

                        'o_stock' => $o_stock,

                        'oil_total_amount' => $oil_total_amount,

                        'bank_name' => $p_bank_name,

                        'prev_o_stock' => $prev_o_stock,

                        "p_new_price" => $p_new_price,

                        "p_total_amount" => $p_total_amount,

                        'created_date' => date("Y-m-d H:i:s"),

                        'tankdata' => $tankdata,

						'p_vehicle_no' => $p_vehicle_no,

                        'p_invoice_density' => $p_invoice_density,

                        'p_observer_density' => $p_observer_density,

                        'p_sample' => $p_sample

                    );



                    $insert = $this->Service_model_15->master_insert("sh_inventory", $data);

foreach ($p_sample_list as $row) {

                        $data1 = array(

                            "inv_id" => $insert,

                            "location_id" => $location_id,

                            "date" => $date,

                            "type" => 'p',

							"name" => $row['name'],

							"created_by" => $id,

                            "created_at" => date("Y-m-d H:i:s")

                        );

                        $this->Service_model_15->master_insert("sh_sample_list", $data1);

                    }

					

					foreach ($qty_in_tank_list as $row) {

						if($row['fuelType'] == 'xpp'){

						$data1 = array(

							"inv_id" => $insert,

							"location_id" => $location_id,

							"date" => $date,

							"type" => $row['fuelType'],

							"tank_id" => $row['tank_id'],

							"volume" => $row['volume'],

							"name" => $row['reading'],

							"created_by" => $id,

							"created_date_time" => date("Y-m-d H:i:s")

						);

						$this->Service_model_15->master_insert("tank_volume_inventory", $data1);

						}

					}



                    $data = array(

                        'user_id' => $id,

                        'date' => $date,

                        'location_id' => $location_id,

                        'invoice_no' => $d_invoice_no,

                        'paymenttype' => $d_paymenttype,

                        'chequenumber' => $d_chequenumber,

                        'fuel_type' => 'xpd',

                        'd_stock' => $d_stock,

                        'd_quantity' => $d_quantity,

                        'd_fuelamount' => $d_fuelamount,

                        'dv_taxamount' => $dv_taxamount,

                        'prev_d_stock' => $prev_d_stock,

                        'prev_d_price' => $prev_d_price,

                        'd_ev' => $d_ev,

                        'd_cess_tax' => $d_cess_tax,

                        // 'd_tankerreading' => $d_tankerreading,

                        'd_price' => $d_price,

                        'bank_name' => $d_bank_name,

                        'prev_o_stock' => $prev_o_stock,

                        "d_new_price" => $d_new_price,

                        "d_total_amount" => $d_total_amount,

                        'created_date' => date("Y-m-d H:i:s"),

                        'tankdata' => $tankdata,

						'd_vehicle_no' => $d_vehicle_no,

                        'd_invoice_density' => $d_invoice_density,

                        'd_observer_density' => $d_observer_density,

                        'd_sample' => $d_sample

                    );

                    $insert = $this->Service_model_15->master_insert("sh_inventory", $data);

                    foreach ($tank_reading as $row) {

                        $data1 = array(

                            "inv_id" => $insert,

                            "location_id" => $location_id,

                            "date" => $date,

                            "tank_id" => $row['tank_id'],

                            "deepreading" => $row['deepReading'],

                            "volume" => $row['volume'],

                            "tank_name" => $row['reading'],

                            "type" => $fuel_type,

                            "created_at" => date("Y-m-d H:i:s")

                        );

                        $this->Service_model_15->master_insert("sh_tank_wies_reading", $data1);

                    }

					

					

					

					

					foreach ($d_sample_list as $row) {

                        $data1 = array(

                            "inv_id" => $insert,

                            "location_id" => $location_id,

                            "date" => $date,

                            "type" => 'd',

							"name" => $row['name'],

							"created_by" => $id,

                            "created_at" => date("Y-m-d H:i:s")

                        );

                        $this->Service_model_15->master_insert("sh_sample_list", $data1);

                    }

					foreach ($qty_in_tank_list as $row) {

						if($row['fuelType'] == 'xpd'){

						$data1 = array(

							"inv_id" => $insert,

							"location_id" => $location_id,

							"date" => $date,

							"type" => $row['fuelType'],

							"tank_id" => $row['tank_id'],

							"volume" => $row['volume'],

							"name" => $row['reading'],

							"created_by" => $id,

							"created_date_time" => date("Y-m-d H:i:s")

						);

						$this->Service_model_15->master_insert("tank_volume_inventory", $data1);

						}

					}

                }





                if ($insert) {

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                } else {

                    echo $this->json_data("0", "Some thing is Wrong Please try again", "");

                }

                // }

            } else {

                echo $this->json_data("3", "Token expired. Please login again. ", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }

	

	

	

    public function add_inventory() { 

        // add fuel inventory 

        $this->load->model('Service_model_15');

        //coman 

		$token = $this->input->get_post('token');

        $date = $this->input->get_post('date');



        $p_invoice_no = $this->input->get_post('p_invoice_no');

        $d_invoice_no = $this->input->get_post('d_invoice_no');

        $p_paymenttype = $this->input->get_post('p_paymenttype');

        $d_paymenttype = $this->input->get_post('d_paymenttype');

        $p_chequenumber = $this->input->get_post('p_chequenumber');

        $d_chequenumber = $this->input->get_post('d_chequenumber');

        //$paidamount = $this->input->get_post('paidamount');

        $fuel_type = $this->input->get_post('fuel_type');

        $p_bank_name = $this->input->get_post('p_bank_name');

        $d_bank_name = $this->input->get_post('d_bank_name');

        $deep_reading = $this->input->get_post('deep_reading');

        // petrol inventory

        $p_stock = $this->input->get_post('p_stock');

        $p_quantity = $this->input->get_post('p_quantity');

        $p_fuelamount = $this->input->get_post('p_fuelamount');

        $pv_taxamount = $this->input->get_post('pv_taxamount');

        $p_price = $this->input->get_post('p_price');

        $prev_p_stock = $this->input->get_post('prev_p_stock');

        $prev_p_price = $this->input->get_post('prev_p_price');

        $p_ev = $this->input->get_post('p_ev');

        $p_cess_tax = $this->input->get_post('p_cess_tax');

        // Disel inventory

        $d_stock = $this->input->get_post('d_stock');

        $d_quantity = $this->input->get_post('d_quantity');

        $d_fuelamount = $this->input->get_post('d_fuelamount');

        $dv_taxamount = $this->input->get_post('dv_taxamount');

        $d_price = $this->input->get_post('d_price');

        $prev_d_stock = $this->input->get_post('prev_d_stock');

        $prev_d_price = $this->input->get_post('prev_d_price');

        $d_ev = $this->input->get_post('d_ev');

        $d_cess_tax = $this->input->get_post('d_cess_tax');

        // Oil inventory

        $oil_type = $this->input->get_post('oil_type');

        $o_quantity = $this->input->get_post('o_quantity');

        $oil_amount = $this->input->get_post('oil_amount');

        $oil_cgst = $this->input->get_post('oil_cgst');

        $oil_sgst = $this->input->get_post('oil_sgst');

        $o_stock = $this->input->get_post('o_stock');

        $prev_o_stock = $this->input->get_post('prev_o_stock');

        $oil_total_amount = $this->input->get_post('oil_total_amount');

        $data = $this->input->get_post('oil_data');

        $pamoutnew = json_decode($data, TRUE);

        $tankdata = $this->input->get_post('deep_reading');

        $tank_reading = json_decode($tankdata, TRUE);

        $p_new_price = $this->input->get_post('p_new_price');

        $d_new_price = $this->input->get_post('d_new_price');

        $p_total_amount = $this->input->get_post('p_total_amount');

        $d_total_amount = $this->input->get_post('d_total_amount');

		

        $p_vehicle_no = $this->input->get_post('p_vehicle_no');

        $p_invoice_density = $this->input->get_post('p_invoice_density');

        $p_observer_density = $this->input->get_post('p_observer_density');

        $p_sample = $this->input->get_post('p_sample');

		$p_sample_list = json_decode($p_sample, TRUE);

		

		$d_vehicle_no = $this->input->get_post('d_vehicle_no');

        $d_invoice_density = $this->input->get_post('d_invoice_density');

        $d_observer_density = $this->input->get_post('d_observer_density');

        $d_sample = $this->input->get_post('d_sample');

        $qty_in_tank = $this->input->get_post('qty_in_tank');
        $p_other_tax = $this->input->get_post('p_other_tax');
        $d_other_tax = $this->input->get_post('d_other_tax');

		$d_sample_list = json_decode($d_sample, TRUE);

		$qty_in_tank_list = json_decode($qty_in_tank, TRUE);

		

		

		

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                if ($fuel_type != 'o') {

                    $checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => 'p', "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                    if ($checkentry) {

                        echo $this->json_data("0", "Sorry you already added detail.", "");

                        die();

                    }

                    $checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => 'd', "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                    if ($checkentry) {

                        echo $this->json_data("0", "Sorry you already added detail.", "");

                        die();

                    }

                } else {

                    $checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                    if ($checkentry) {

                        echo $this->json_data("0", "Sorry you already added detail.", "");

                        die();

                    }

                }

                // $checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                // if ($checkentry) {

                // echo $this->json_data("0", "Sorry you already added detail.", "");

                //	die();

                // } else {

                //$tempcheck_prev = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));



                if ($fuel_type != 'o') {

                    $nddeate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                    $newtemp_prev = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                    if ($newtemp_prev) {

                        $temp_prev = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $nddeate, "fuel_type" => 'p', "status" => 1, "location_id" => $list['0']['l_id'], "date" => $nddeate), array("id", "asc"));

                        if (!$temp_prev) {

                            echo $this->json_data("0", "Sorry, Please Add Previous Inventory of : " . date('d-m-Y', strtotime($nddeate)), "");

                            die();

                        }

                        $temp_prev = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $nddeate, "fuel_type" => 'd', "status" => 1, "location_id" => $list['0']['l_id'], "date" => $nddeate), array("id", "asc"));

                        if (!$temp_prev) {

                            echo $this->json_data("0", "Sorry, Please Add Previous Inventory of : " . date('d-m-Y', strtotime($nddeate)), "");

                            die();

                        }

                        $temp_prev = $this->Service_model_15->master_fun_get_tbl_val("shdailyreadingdetails", array("date" => $nddeate, "status" => 1, "location_id" => $list['0']['l_id'], "date" => $nddeate), array("id", "asc"));

                        if (!$temp_prev) {

                            echo $this->json_data("0", "Sorry, Please Add Previous Sales of : " . date('d-m-Y', strtotime($nddeate)), "");

                            die();

                        }

                    }

                }

                if ($fuel_type == 'o') {

                    $newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                    $oildata = $this->Service_model_15->inventory_detail_for_add($list['0']['l_id'], $newdate, "o");



                    if ($oildata) {

                        $oil_total_amount = $oil_total_amount + $oildata->oil_total_amount;

                        $salesdata = $this->Service_model_15->sels_detail_for_add($list['0']['l_id'], $newdate);



                        if ($salesdata) {

                            $oil_total_amount = $oil_total_amount - $salesdata->oil_reading;

                        }

                    }

                    $tankdata = $data;

                }



                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];

                if ($fuel_type == 'o') {

                    $data = array(

                        'user_id' => $id,

                        'date' => $date,

                        'location_id' => $location_id,

                        'fuel_type' => 'o',

                        'o_type' => $oil_type,

                        'o_quantity' => $o_quantity,

                        'o_amount' => $oil_amount,

                        'oil_cgst' => $oil_cgst,

                        'oil_sgst' => $oil_sgst,

                        'o_stock' => $o_stock,

                        'oil_total_amount' => $oil_total_amount,

                        'prev_o_stock' => $prev_o_stock,

                        'created_date' => date("Y-m-d H:i:s")

                    );

                    $insert = $this->Service_model_15->master_insert("sh_inventory", $data);

                    foreach ($pamoutnew as $row) {

                        $data1 = array(

                            "inv_id" => $insert,

                            "oil_id" => $row['oil_id'],

                            "qty" => $row['qty'],

                            "ltr" => $row['ltr'],

                            "created_at" => date("Y-m-d H:i:s"));

                        $this->Service_model_15->master_insert("sh_oil_inventory", $data1);

                    }

                } else {

                    $data = array(

                        'user_id' => $id,

                        'date' => $date,

                        'location_id' => $location_id,

                        'invoice_no' => $p_invoice_no,

                        'paymenttype' => $p_paymenttype,

                        'chequenumber' => $p_chequenumber,

                        'fuel_type' => 'p',

                        'p_stock' => $p_stock,

                        'p_quantity' => $p_quantity,

                        'p_fuelamount' => $p_fuelamount,

                        'pv_taxamount' => $pv_taxamount,

                        'prev_p_stock' => $prev_p_stock,

                        'prev_p_price' => $prev_p_price,

                        'p_ev' => $p_ev,

                        'p_cess_tax' => $p_cess_tax,

                        //'p_tankerreading' => $p_tankerreading,

                        'p_price' => $p_price,

                        'o_type' => $oil_type,

                        'o_quantity' => $o_quantity,

                        'o_amount' => $oil_amount,

                        'oil_cgst' => $oil_cgst,

                        'oil_sgst' => $oil_sgst,

                        'o_stock' => $o_stock,

                        'oil_total_amount' => $oil_total_amount,

                        'bank_name' => $p_bank_name,

                        'prev_o_stock' => $prev_o_stock,

                        "p_new_price" => $p_new_price,

                        "p_total_amount" => $p_total_amount,

                        'created_date' => date("Y-m-d H:i:s"),

                        'tankdata' => $tankdata,

						'p_vehicle_no' => $p_vehicle_no,

                        'p_invoice_density' => $p_invoice_density,

                        'p_observer_density' => $p_observer_density,

                        'p_sample' => $p_sample,
                        'qty_in_tank' => $qty_in_tank,
                        'p_other_tax' => $p_other_tax

                    );



                    $insert = $this->Service_model_15->master_insert("sh_inventory", $data);

foreach ($p_sample_list as $row) {

                        $data1 = array(

                            "inv_id" => $insert,

                            "location_id" => $location_id,

                            "date" => $date,

                            "type" => 'p',

							"name" => $row['name'],

							"created_by" => $id,

                            "created_at" => date("Y-m-d H:i:s")

                        );

                        $this->Service_model_15->master_insert("sh_sample_list", $data1);

                    }



					foreach ($qty_in_tank_list as $row) {

						if($row['fuelType'] == 'p'){

                        $data1 = array(

                            "inv_id" => $insert,

                            "location_id" => $location_id,

                            "date" => $date,

                            "type" => $row['fuelType'],

							"tank_id" => $row['tank_id'],

							"volume" => $row['volume'],

							"name" => $row['reading'],

							"created_by" => $id,

                            "created_date_time" => date("Y-m-d H:i:s")

                        );

                        $this->Service_model_15->master_insert("tank_volume_inventory", $data1);

                    }

					}

                    $data = array(

                        'user_id' => $id,

                        'date' => $date,

                        'location_id' => $location_id,

                        'invoice_no' => $d_invoice_no,

                        'paymenttype' => $d_paymenttype,

                        'chequenumber' => $d_chequenumber,

                        'fuel_type' => 'd',

                        'd_stock' => $d_stock,

                        'd_quantity' => $d_quantity,

                        'd_fuelamount' => $d_fuelamount,

                        'dv_taxamount' => $dv_taxamount,

                        'prev_d_stock' => $prev_d_stock,

                        'prev_d_price' => $prev_d_price,

                        'd_ev' => $d_ev,

                        'd_cess_tax' => $d_cess_tax,

                        // 'd_tankerreading' => $d_tankerreading,

                        'd_price' => $d_price,

                        'bank_name' => $d_bank_name,

                        'prev_o_stock' => $prev_o_stock,

                        "d_new_price" => $d_new_price,

                        "d_total_amount" => $d_total_amount,

                        'created_date' => date("Y-m-d H:i:s"),

                        'tankdata' => $tankdata,

						'd_vehicle_no' => $d_vehicle_no,

                        'd_invoice_density' => $d_invoice_density,

                        'd_observer_density' => $d_observer_density,
'qty_in_tank' => $qty_in_tank,
                        'd_sample' => $d_sample,
                        'd_other_tax' => $d_other_tax,

                    );

                    $insert = $this->Service_model_15->master_insert("sh_inventory", $data);

                    foreach ($tank_reading as $row) {

                        $data1 = array(

                            "inv_id" => $insert,

                            "location_id" => $location_id,

                            "date" => $date,

                            "tank_id" => $row['tank_id'],

                            "deepreading" => $row['deepReading'],

                            "volume" => $row['volume'],

                            "tank_name" => $row['reading'],

                            "type" => $fuel_type,

                            "created_at" => date("Y-m-d H:i:s")

                        );

                        $this->Service_model_15->master_insert("sh_tank_wies_reading", $data1);

                    }

					

					

					

					

					foreach ($d_sample_list as $row) {

                        $data1 = array(

                            "inv_id" => $insert,

                            "location_id" => $location_id,

                            "date" => $date,

                            "type" => 'd',

							"name" => $row['name'],

							"created_by" => $id,

                            "created_at" => date("Y-m-d H:i:s")

                        );

                        $this->Service_model_15->master_insert("sh_sample_list", $data1);

                    }

					foreach ($qty_in_tank_list as $row) {

						if($row['fuelType'] == 'd'){

                        $data1 = array(

                            "inv_id" => $insert,

                            "location_id" => $location_id,

                            "date" => $date,

                            "type" => $row['fuelType'],

							"tank_id" => $row['tank_id'],

							"volume" => $row['volume'],

							"name" => $row['reading'],

							"created_by" => $id,

                            "created_date_time" => date("Y-m-d H:i:s")

                        );

                        $this->Service_model_15->master_insert("tank_volume_inventory", $data1);

                    }

					}

                }



					



                if ($insert) {

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                } else {

                    echo $this->json_data("0", "Some thing is Wrong Please try again", "");

                }

                // }

            } else {

                echo $this->json_data("3", "Token expired. Please login again. ", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function update_details() {

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

        $myJSON = json_encode($_POST);

        $datap = $myJSON;

        $time = $date = date('Y-m-d H:i:s');

        if ($token != "" && $PatrolReading != "" && $DieselReading != "" && $meterReading != "" && $TotalCash != "" && $TotalCredit != "" && $TotalExpenses != "" && $TotalAmount != "" && $pamout != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

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

                    "created_at" => $time

                );

                $insert = $this->Service_model_15->master_insert("shdailyreadingdetails", $data);

                $RDRId = $insert;

                if ($pamout != "") {

                    foreach ($pamoutnew as $row) {

                        $id = $row['pump_id'];

                        $type = $row['type'];

                        $reading = $row['reading'];

                        $pump_id = $row['pump_id'];

                        $data1 = array();

                        $data1 = array(

                            "RDRId" => $RDRId,

                            "Type" => $type,

                            "PumpId" => $pump_id,

                            "Reading" => $reading,

                            "created_at" => $time);

                        $insert = $this->Service_model_15->master_insert("shreadinghistory", $data1);

                    }

                    echo $this->json_data("1", "Your Details has been Updated", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function change_password() {

        $token = $this->input->get_post('token');

        $oldpassword = $this->input->get_post('oldpassword');

        $password = $this->input->get_post('password');

        if ($token != "" && $password != "" && $oldpassword != "") {



            $data2 = $this->Service_model_15->master_fun_get_tbl_val_3("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "asc"));

            if ($data2) {



                $row = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "asc"));

                $oldpass = $row[0]['UserPassword'];

                if ($oldpassword == $oldpass) {

                    $data = array(

                        "UserPassword" => $password,

                    );

                    $update = $this->Service_model_15->master_fun_update("shusermaster", $token, $data);

                    if ($update) {

                        echo $this->json_data("1", "Your Password has been Updated", "");

                    }

                } else {

                    echo $this->json_data("0", "old password not match", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function json_data($status, $error_msg, $data = NULL) {



        if ($data == NULL) {

            $data = array();

        }

        if ($status == '3') {

            $data = array(array("vesion_code" => array("vesion_code" => "$this->version_code", "flag" => "true")));

        }

        $final = array("status" => $status, "error_msg" => $error_msg, "data" => $data);

        return str_replace('}]"', '}]', str_replace('"[{', '[{', str_replace("null", '" "', stripcslashes(json_encode($final)))));

    }



    public function send_notification($tokens, $msg) {

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



    public function test() {

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



    public function gcm() {

        $user_id = $this->input->get_post('user_id');

        $device_id = $this->input->get_post('device_id');

        $type = $this->input->get_post('type');

        if ($user_id != NULL && $device_id != NULL && $type != NULL) {

            $update = $this->Service_model_15->device_update("customer_master", $device_id, array("device_id" => "", "device_type" => ""));

            $update = $this->Service_model_15->master_fun_update("customer_master", $user_id, array("device_id" => $device_id, "device_type" => $type));



            echo $this->json_data("1", "", array(array("msg" => "Your Device Id Saved")));

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function testgcm() {

        $device_id = 'APA91bHqu4emQq_Mq6EyLYX1WlS_U3Z8wcJmVwtl5-VVjj8nXkH-bldsxlyCUfHmK2UTziu3OEgrNchgtm4AG19LAbufedn9XoF90YlQuFsd7U_wqPUVep3VizEMk34jwbn0iFEkwQIK';

        $notification_data = array("title" => "TEAM Squadli", "message" => "notification message");

        print_r($notification_data);

        $pushServer = new PushServer();

        $test = $pushServer->pushToGoogle(array($device_id), $notification_data);

        echo $test;

    }



    public function success($amount) {

        $data['amount'] = $this->input->get('amount');

        $this->load->view('success', $data);

    }



    public function indexstripe($id, $pid) {

        $data["stripe"] = $this->Service_model_15->master_fun_get_tbl_val("stripe", array("id" => '1'), array("id", "asc"));

        $data["stripe_package"] = $this->Service_model_15->master_fun_get_tbl_val("stripe_package", array("id" => $pid), array("id", "asc"));



        if ($id != NULL) {

            $data['user_id'] = $id;

            $this->load->view('index', $data);

        } else {

            echo "usernot available";

        }

    }



    public function indexpackage($id) {

        $packa_select = $this->Service_model_15->user_select_pack($id);

        if ($packa_select) {

            $data['package_id'] = $packa_select->package_id;

        } else {

            $data['package_id'] = "";

        }

        //$data["stripe"] = $this->Service_model_15->master_fun_get_tbl_val("stripe_packege", array("startus" => '1'), array("id", "asc"));

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



    public function mail_demo() {

        $this->load->helper(array('swift'));

        $email = "vishal@virtualheight.com";



        $message = '<div style="background:#fff; border:1px solid #ccc; padding:2px 30px"><img alt="" src="http://ec2-52-62-23-230.ap-southeast-2.compute.amazonaws.com/user_assets/images/logo.png" /></div>



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



        send_mail($email, 'test mail tender', $message);

        echo $message;

    }



    public function database_backup() {



        $this->load->dbutil();



        $prefs = array('format' => 'sql', // gzip, zip, txt 

            'filename' => 'Translance_backup' . date('Y-m-d H-i') . 'sql',

            // File name - NEEDED ONLY WITH ZIP FILES 

            'add_drop' => TRUE,

            // Whether to add DROP TABLE statements to backup file

            'add_insert' => TRUE,

            // Whether to add INSERT data to backup file 

            'newline' => "\n"

                // Newline character used in backup file 

        );

        $backup = $this->dbutil->backup($prefs);



        $this->load->helper('file');

        $path = './upload/' . date('Y-m-d-H-i') . '.sql';

        // $file = write_file($path, $backup);

        if (!write_file($path, $backup)) {

            echo 'Unable to write the file';

        } else {

            $this->Service_model_15->drop_tbl('admin_master');

            $this->Service_model_15->drop_tbl('alldata');

            $this->Service_model_15->drop_tbl('award_master');

            $this->Service_model_15->drop_tbl('customer_master');

            $this->Service_model_15->drop_tbl('emotion_award_master');

            $this->Service_model_15->drop_tbl('emotion_master');



            $this->Service_model_15->drop_tbl('help_master');

            $this->Service_model_15->drop_tbl('menu_master');

            $this->Service_model_15->drop_tbl('objective_master');

            $this->Service_model_15->drop_tbl('objective_rank_master');

            $this->Service_model_15->drop_tbl('payment');

            $this->Service_model_15->drop_tbl('referral_team');



            $this->Service_model_15->drop_tbl('stripe');

            $this->Service_model_15->drop_tbl('stripe_package');

            $this->Service_model_15->drop_tbl('team_master');

            $this->Service_model_15->drop_tbl('team_member_master');

            $this->Service_model_15->drop_tbl('user_permission');

            $this->Service_model_15->drop_tbl('user_type_master');

        }

    }



    public function only_db() {

        echo "<a href='" . base_url() . "Service/database_backup'>click Here</a>";

    }



    // get user data from userlist table

    public function user_list() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1  ), array("id", "id"));

            if ($list) {

                $data = $this->Service_model_15->get_user_list($list[0]['company_id'], $list[0]['l_id']);

//                echo $this->db->last_query(); die();

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Customer not available.", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    // insert data into bank deposit table

    public function bank_deposit() {



        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $deposit_amount = $this->input->get_post('cash_deposit_amount');

        $withdraw_amount = $this->input->get_post('cheque_deposit_amount');

        $deposited_by = $this->input->get_post('deposited_by');

        $cheque_no = $this->input->get_post('cheque_no');

        $customer_id = $this->input->get_post('customer_id');

        $bank_name = $this->input->get_post('bank_name');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                // if($deposited_by == 'cs') // n == cash and c == cheque

                // {

                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];

                $data = array(

                    'user_id' => $id,

                    'date' => $date,

                    'deposit_amount' => $deposit_amount,

                    'withdraw_amount' => $withdraw_amount,

                    'deposited_by' => $deposited_by,

                    'location_id' => $location_id,

                    'created_by' => date("Y-m-d H:i:s"),

                    'customer_id' => $customer_id,

                    'cheque_no' => $cheque_no,

                    'bank_name' => $bank_name

                );

                $insert = $this->Service_model_15->master_insert("sh_bankdeposit", $data);



                // if($customer_id != ""){

                // $data = array(

                // 'date' => $date,

                // 'payment_type' => 'd',

                // 'user_id' => $id,

                // 'location_id' => $location_id,

                // 'customer_id' => $customer_id,

                // 'bill_no' => '',

                // 'batch_no' => '',

                // 'vehicle_no' => '',

                // 'fuel_type' => '',

                // 'amount' => $withdraw_amount,

                // 'quantity' => '',

                // 'remark' => 'add from bank deposit',

                // 'created_by' => date("Y-m-d H:i:s") 

                // );

                // $insert = $this->Service_model_15->master_insert("sh_credit_debit",$data);

                // }

                if ($insert) {

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                } else {

                    echo $this->json_data("1", "Opps Some thng is wrong", "");

                }

                // }

                // else

                // {

                // if($cheque_no != "" && $customer_id != "")

                // {

                // $id = $list[0]['id'];

                // $location_id = $list[0]['l_id']; 

                // $data = array(

                // 'user_id' => $id,

                // 'location_id' => $location_id,

                // 'date' => $date,

                // 'deposit_amount' => $deposit_amount,

                // 'withdraw_amount' => $withdraw_amount,

                // 'deposited_by' => $deposited_by,

                // 'customer_id' => $customer_id,

                // 'cheque_no' => $cheque_no,

                // 'created_by' => date("Y-m-d H:i:sa"),

                // 'bank_name' => $bank_name

                // );

                // $insert = $this->Service_model_15->master_insert("sh_bankdeposit",$data);

                // echo $this->json_data("1","Your Data submitted successfully","");       

                // }

                // else

                // {

                // echo $this->json_data("0","Cheque number and customer id required","");

                // }

                // }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function bank_deposit_new() {



        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $deposit_amount = $this->input->get_post('cash_deposit_amount');

        $amount = $this->input->get_post('amount');

        $jsondata = $this->input->get_post('data');

        $arraydata = json_decode($jsondata, TRUE);

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];

                date_default_timezone_set('Asia/Kolkata');

                $data = array(

                    'user_id' => $id,

                    'date' => $date,

                    'deposit_amount' => $deposit_amount,

                    'amount' => $amount,

                    'location_id' => $location_id,

                    'created_by' => date("Y-m-d H:i:s"),

                );

                $insert = $this->Service_model_15->master_insert("sh_bankdeposit", $data);



                if ($insert) {

                    $amount = 0;

                    foreach ($arraydata as $row) {

                        $data = array(

                            'date' => $date,

                            'payment_type' => 'd',

                            'user_id' => $id,

                            'location_id' => $location_id,

                            'customer_id' => $row['customerId'],

                            'amount' => $row['amount'],

                            'bankdeposit_id' => $insert,

                            'transaction_type' => $row['paymentType'],

                            'transaction_number' => $row['transactioNo'],

                            'created_by' => date("Y-m-d H:i:sa"),

                            'bank_name' => $row['bankName'],    

                            'remark' => $row['remark']

                        );

                        

                        $this->Service_model_15->master_insert("sh_credit_debit", $data);

                        if ($row['paymentType'] != 'cs' && $row['paymentType'] != 'ccard') {

                            $amount = $amount + $row['amount'];

                        }

                    }

                    $this->Service_model_15->master_fun_updateid("sh_bankdeposit", $insert, array('amount' => $amount));

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                } else {

                    echo $this->json_data("1", "Opps Some thng is wrong", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // credit debit 

    public function credit_debit() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $payment_type = $this->input->get_post('payment_type');

        $customer_id = $this->input->get_post('customer_id');

        $customer_name = $this->input->get_post('customer_name');

        $bill_no = $this->input->get_post('bill_no');

        $batch_no = $this->input->get_post('batch_no');

        $vehicle_no = $this->input->get_post('vehicle_no');

        $fuel_type = $this->input->get_post('fuel_type');

        $amount = $this->input->get_post('amount');

        $quantity = $this->input->get_post('quantity');

        // if($token != "" && $date != "" && $payment_type != "" && $bill_no != "" && $vehicle_no != "" && $fuel_type != "" && $amount != "" && $quantity != "" && $batch_no != "")

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));



            if ($list) {

                if ($payment_type == 'd' && $customer_id == '0') {



                    if ($customer_name != "") {

                        $id = $list[0]['id'];

                        $location_id = $list[0]['l_id'];

                        date_default_timezone_set('Asia/Kolkata');

                        $data = array();



                        $data = array(

                            'date' => $date,

                            'payment_type' => $payment_type,

                            'user_id' => $id,

                            'location_id' => $location_id,

                            'customer_id' => $customer_id,

                            'customer_name' => $customer_name,

                            'bill_no' => $bill_no,

                            'batch_no' => $batch_no,

                            'vehicle_no' => $vehicle_no,

                            'fuel_type' => $fuel_type,

                            'amount' => $amount,

                            'quantity' => $quantity,

                            'created_by' => date("Y-m-d H:i:sa")

                        );

                        $insert = $this->Service_model_15->master_insert("sh_credit_debit", $data);



                        echo $this->json_data("1", "Your Data submitted successfully", "");

                    } else {

                        echo $this->json_data("0", "Customername is required", "");

                    }

                } else {

                    $id = $list[0]['id'];

                    $location_id = $list[0]['l_id'];

                    date_default_timezone_set('Asia/Kolkata');

                    $data = array();



                    $data = array(

                        'date' => $date,

                        'payment_type' => $payment_type,

                        'user_id' => $id,

                        'location_id' => $location_id,

                        'customer_id' => $customer_id,

                        'customer_name' => $customer_name,

                        'bill_no' => $bill_no,

                        'batch_no' => $batch_no,

                        'vehicle_no' => $vehicle_no,

                        'fuel_type' => $fuel_type,

                        'amount' => $amount,

                        'quantity' => $quantity,

                        'created_by' => date("Y-m-d H:i:sa")

                    );

                    $insert = $this->Service_model_15->master_insert("sh_credit_debit", $data);

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // pranjal service for company registratio 17/4/2018

    public function company_registration() {

        $name = $this->input->get_post('name');

        $email = $this->input->get_post('email');

        $password = $this->input->get_post('password');

        $mobile = $this->input->get_post('mobile');



        if ($name != "" && $email != "" && $password != "" && $mobile != "") {

            $row = $this->Service_model_15->master_num_rows("sh_com_registration", array("email" => $email, "status" => 1));

            if ($row == 0) {

                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'name' => $name,

                    'email' => $email,

                    'password' => $password,

                    'mobile' => $mobile,

                    'created_by' => date("Y-m-d H:i:sa")

                );

                $insert = $this->Service_model_15->master_insert("sh_com_registration", $data);

                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("0", "Email Already Registered", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    // code for company login

    public function company_login() {

        $email = $this->input->get_post('email');

        $password = $this->input->get_post('password');



        if ($email != "" && $password != "") {

            $result = $this->login_model->checkcompanylogin($email, $password);

            $data = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("email" => $email, "password" => $password, "status" => 1), array("id", "asc"));





            if ($result != "") {

                $id = $data[0]['id'];



                $uniqueId = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);

                $data1 = array("token" => $uniqueId);

                $update = $this->Service_model_15->master_fun_updateid("sh_com_registration", $id, $data1);



                echo $this->json_data("1", "Login successfully", $data);

            } else {

                echo $this->json_data("0", "Email Id or password wrong try again..", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed.", "");

        }

    }



    // code for company edit profile

    public function company_editprofile() {

        //echo "123";die

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $email = $this->input->get_post('email');

        $mobile = $this->input->get_post('mobile');



        if ($token != "" && $name != "" && $email != "" && $mobile != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $user = $this->Service_model_15->companylist_active_record($token);

                if ($user) {

                    $email2 = $user[0]['email'];

                    if ($email2 == $email) {

                        date_default_timezone_set('Asia/Kolkata');

                        $data = array(

                            "name" => $name,

                            "email" => $email,

                            "mobile" => $mobile,

                            "updated_by" => date("Y-m-d H:i:sa")

                        );



                        $update = $this->Service_model_15->master_fun_update("sh_com_registration", $token, $data);

                        echo $this->json_data("1", "Your Profile has been Updated", "");

                    } else {

                        $row = $this->Service_model_15->master_num_rows("sh_com_registration", array("email" => $email, "status" => 1));

                        if ($row == 0) {

                            date_default_timezone_set('Asia/Kolkata');

                            $data = array(

                                "name" => $name,

                                "email" => $email,

                                "mobile" => $mobile,

                                "updated_by" => date("Y-m-d H:i:sa")

                            );



                            $update = $this->Service_model_15->master_fun_update("sh_com_registration", $token, $data);

                            if ($update) {

                                echo $this->json_data("1", "Your Profile has been Updated", "");

                            }

                        } else {

                            echo $this->json_data("0", "email already exist try another email..", "");

                        }

                    }

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed.", "");

        }

    }



    // pranjal code end 24/04/2018

    // Service of get company location

    public function company_location() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {

                $data = $this->Service_model_15->master_fun_get_tbl_val_company_location("sh_location", array("company_id" => $company_id, "status" => 1), array("l_name", "asc"));

                if ($data) {



                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed");

        }

    }



    // Service for get company pump detail

    public function company_pump() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {

                if ($location_id) {

                    $condition = array("shpump.company_id" => $company_id, "shpump.location_id" => $location_id, "shpump.status" => 1, "shpump.type!=" => 'O');

                } else {

                    $condition = array("shpump.company_id" => $company_id, "shpump.status" => 1, "shpump.type !=" => 'O');

                }

                $data = $this->Service_model_15->master_fun_get_tbl_val_company_pump("shpump", $condition, array("shpump.name", "asc"));



                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "No Data Available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    // service for get employee of company

    public function company_employee() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {

                $data = $this->Service_model_15->master_fun_get_tbl_val_company_employee("shusermaster", array("shusermaster.company_id" => $company_id, "shusermaster.Active" => 1, "shusermaster.status" => 1, "shusermaster.location_id"), array("id", "asc"), $location_id);

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    // service for insert location in company

    public function add_location() {

        $token = $this->input->get_post('token');

        $location_name = $this->input->get_post('location_name');

        $phone_no = $this->input->get_post('phone_no');

        $address = $this->input->get_post('address');

        $tank_type = $this->input->get_post('tank_type');

        $tin = $this->input->get_post('tin');

        $dealar = $this->input->get_post('dealar');

        $gst = $this->input->get_post('gst');



        if ($token != "" && $location_name != "" && $phone_no != "" && $address != "" && $tank_type != "" && $tin != "" && $dealar != "" && $gst != "" && !empty($_FILES['logo']['name'])) {

            $_FILES['file']['name'] = time() . $_FILES['logo']['name'];

            $_FILES['file']['type'] = $_FILES['logo']['type'];

            $_FILES['file']['tmp_name'] = $_FILES['logo']['tmp_name'];

            $_FILES['file']['error'] = $_FILES['logo']['error'];

            $_FILES['file']['size'] = $_FILES['logo']['size'];

            $config['allowed_types'] = 'jpg|png|gif|jpeg';

            $config['upload_path'] = './uploads/';

            $config['name'] = time() . $_FILES['logo']['name'];

            $config['file_name'] = time() . $_FILES['logo']['name'];

            $config['file_name'] = str_replace(' ', '_', $config['file_name']);

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('logo')) {

                $error = $this->upload->display_errors();

                echo $this->json_data("0", "Image Upload Failed", $error);

            } else {

                $data2 = array('upload_data' => $this->upload->data());

                $logo = $data2["upload_data"]["file_name"];

            }

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'company_id' => $company_id,

                    'l_name' => $location_name,

                    'phone_no' => $phone_no,

                    'address' => $address,

                    'tank_type' => $tank_type,

                    'tin' => $tin,

                    'dealar' => $dealar,

                    'gst' => $gst,

                    'logo' => $logo,

                    'created_by' => date("Y-m-d H:i:sa")

                );

                $insert = $this->Service_model_15->master_insert("sh_location", $data);

                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // Service for Add employee 

    public function add_employee() {

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $mobile = $this->input->get_post('mobile');

        $email = $this->input->get_post('email');

        $password = $this->input->get_post('password');

        $location_id = $this->input->get_post('location_id');

        $shift = $this->input->get_post('shift');



        if ($token != "" && $name != "" && $mobile != "" && $email != "" && $password != "" && $location_id != "" && $shift != "") {



            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $email1 = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("UserEmail" => $email, "status" => 1, "Active" => 1), array("id", "id"));



                if ($email1) {



                    echo $this->json_data("0", "$email is already exist try another email.", "");

                } else {

                    $company_id = $list[0]['id'];



                    date_default_timezone_set('Asia/Kolkata');

                    $data = array();



                    $data = array(

                        'company_id' => $company_id,

                        'UserFName' => $name,

                        'UserMNumber' => $mobile,

                        'UserEmail' => $email,

                        'UserPassword' => $password,

                        'l_id' => $location_id,

                        'shift' => $shift,

                        'createddate' => date("Y-m-d H:i:sa")

                    );

                    $insert = $this->Service_model_15->master_insert("shusermaster", $data);

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // Service for add pump

    public function add_pump() {

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $type = $this->input->get_post('type');

        $location_id = $this->input->get_post('location_id');

        $tank_id = $this->input->get_post('tank_id');

        if ($token != "" && $name != "" && $tank_id != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'company_id' => $company_id,

                    'name' => $name,

                    'type' => $type,

                    'location_id' => $location_id,

                    'created_at' => date("Y-m-d H:i:sa"),

                    "tank_id" => $tank_id

                );

                $insert = $this->Service_model_15->master_insert("shpump", $data);

                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // Service for edit Location

    public function edit_location() {

        $location_id = $this->input->get_post('location_id');

        $token = $this->input->get_post('token');

        $location_name = $this->input->get_post('location_name');

        $phone_no = $this->input->get_post('phone_no');

        $address = $this->input->get_post('address');

        $tank_type = $this->input->get_post('tank_type');

        $tin = $this->input->get_post('tin');

        $dealar = $this->input->get_post('dealar');

        $gst = $this->input->get_post('gst');



        if ($token != "" && $location_name != "" && $location_id != "" && $phone_no != "" && $address != "" && $tank_type != "" && $tin != "" && $dealar != "" && $gst != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $data = array();

                if (!empty($_FILES['logo']['name'])) {

                    $_FILES['file']['name'] = time() . $_FILES['logo']['name'];

                    $_FILES['file']['type'] = $_FILES['logo']['type'];

                    $_FILES['file']['tmp_name'] = $_FILES['logo']['tmp_name'];

                    $_FILES['file']['error'] = $_FILES['logo']['error'];

                    $_FILES['file']['size'] = $_FILES['logo']['size'];

                    $config['allowed_types'] = 'jpg|png|gif|jpeg';

                    $config['upload_path'] = './uploads/';

                    $config['name'] = time() . $_FILES['logo']['name'];

                    $config['file_name'] = time() . $_FILES['logo']['name'];

                    $config['file_name'] = str_replace(' ', '_', $config['file_name']);

                    $this->load->library('upload', $config);

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('logo')) {

                        $error = $this->upload->display_errors();

                        echo $this->json_data("0", "Image Upload Failed", $error);

                    } else {

                        $data2 = array('upload_data' => $this->upload->data());

                        $logo = $data2["upload_data"]["file_name"];

                        $data = array(

                            'l_name' => $location_name,

                            'phone_no' => $phone_no,

                            'address' => $address,

                            'tank_type' => $tank_type,

                            'tin' => $tin,

                            'dealar' => $dealar,

                            'gst' => $gst,

                            'logo' => $logo,

                            'updated_by' => date("Y-m-d H:i:sa")

                        );

                    }

                } else {

                    $data = array(

                        'l_name' => $location_name,

                        'phone_no' => $phone_no,

                        'address' => $address,

                        'tank_type' => $tank_type,

                        'tin' => $tin,

                        'dealar' => $dealar,

                        'gst' => $gst,

                        'updated_by' => date("Y-m-d H:i:sa")

                    );

                }

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');





                $this->Service_model_15->master_fun_update_location("sh_location", $location_id, $data);

                echo $this->json_data("1", "Your Data updated successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function oil_package_list() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');



        if ($token) {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $olist = $this->Service_model_15->get_oil_pckg_list($list[0]['id'], $location_id);

                echo $this->json_data("1", "Your Data retrived successfully", $olist);

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function add_oil_package() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('sel_loc');

        $pump_name = $this->input->get_post('pump_name');

        $packet_value = $this->input->get_post('packet_value');

        $packet_type = $this->input->get_post('packet_type');

        $p_type = $this->input->get_post('p_type');

        $p_qty = $this->input->get_post('p_qty');



        if ($token != "" && $location_id != "" && $pump_name != "" && $packet_value != "" && $packet_type != "" && $p_type != "" && $p_qty != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $data = array(

                    'location_id' => $location_id,

                    'company_id' => $list[0]['id'],

                    'name' => $pump_name,

                    'type' => 'O',

                    'packet_value' => $packet_value,

                    'packet_type' => $packet_type,

                    'created_at' => date("Y-m-d H:i:sa"),

                    'p_type' => $p_type,

                    'p_qty' => $p_qty

                );

                $oil_package_insert_id = $this->Service_model_15->add_oil_pckg($data);



                echo $this->json_data("1", "Oil Package Inserted successfully.", array());

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed.", "");

        }

    }



    public function edit_oil_package() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('sel_loc');

        $pump_name = $this->input->get_post('pump_name');

        $packet_value = $this->input->get_post('packet_value');

        $packet_type = $this->input->get_post('packet_type');

        $p_type = $this->input->get_post('p_type');

        $p_qty = $this->input->get_post('p_qty');

        $pkg_id = $this->input->get_post('pkg_id');



        if ($token != "" && $location_id != "" && $pump_name != "" && $packet_value != "" && $packet_type != "" && $p_type != "" && $p_qty != "" && $pkg_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $data = array(

                    'location_id' => $location_id,

                    'company_id' => $list[0]['id'],

                    'name' => $pump_name,

                    'type' => 'O',

                    'packet_value' => $packet_value,

                    'packet_type' => $packet_type,

                    'created_at' => date("Y-m-d H:i:sa"),

                    'p_type' => $p_type,

                    'p_qty' => $p_qty

                );

                $response = $this->Service_model_15->update_oil_pckg($pkg_id, $data);

                echo $this->json_data("1", "Oil Package Updated successfully.", array());

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed.", "");

        }

    }



    public function delete_oil_package() {

        $token = $this->input->get_post('token');

        $pkg_id = $this->input->get_post('pkg_id');



        if ($token != "" && $pkg_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $data = array(

                    'delete_at' => date("Y-m-d H:i:s"),

                    'status' => '0'

                );

                $response = $this->Service_model_15->update_oil_pckg($pkg_id, $data);

                if ($response) {

                    echo $this->json_data("1", "Oil Package Deleted successfully.", array());

                } else {

                    echo $this->json_data("0", "Entry Not Found.", array());

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed.", "");

        }

    }



    // Service for update employee

    public function edit_employee() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $mobile = $this->input->get_post('mobile');

        $email = $this->input->get_post('email');

        $password = $this->input->get_post('password');

        $location_id = $this->input->get_post('location_id');

        $shift = $this->input->get_post('shift');



        if ($id != "" && $token != "" && $name != "" && $mobile != "" && $email != "" && $password != "" && $location_id != "" && $shift != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $email1 = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("UserEmail " => $email, "id !=" => $id, "status" => 1, "Active" => 1), array("id", "id"));



                if ($email1) {

                    echo $this->json_data("0", "email already exist", "");

                } else {

                    $company_id = $list[0]['id'];



                    date_default_timezone_set('Asia/Kolkata');

                    $data = array();



                    $data = array(

                        'company_id' => $company_id,

                        'UserFName' => $name,

                        'UserMNumber' => $mobile,

                        'UserEmail' => $email,

                        'UserPassword' => $password,

                        'l_id' => $location_id,

                        'shift' => $shift,

                        'updated_at' => date("Y-m-d H:i:sa")

                    );

                    $this->Service_model_15->master_fun_update_employee("shusermaster", $id, $data);

                    echo $this->json_data("1", "Your Data Updated successfully", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // Service For edit pump

    public function edit_pump() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $type = $this->input->get_post('type');

        $location_id = $this->input->get_post('location_id');



        if ($token != "" && $name != "" && $type != "" && $location_id != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'name' => $name,

                    'type' => $type,

                    'location_id' => $location_id,

                    'update_at' => date("Y-m-d H:i:sa")

                );

                $this->Service_model_15->master_fun_update_employee("shpump", $id, $data);

                echo $this->json_data("1", "Your Data updated successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // Service for Delete location

    public function delete_location() {

        $location_id = $this->input->get_post('location_id');

        $token = $this->input->get_post('token');





        if ($token != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'status' => 0

                );

                $this->Service_model_15->master_fun_update_location("sh_location", $location_id, $data);

                echo $this->json_data("1", "Data Deleted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // Service for delete employee

    public function delete_employee() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post('token');



        if ($id != "" && $token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'status' => 0

                );

                $this->Service_model_15->master_fun_update_employee("shusermaster", $id, $data);

                echo $this->json_data("1", "Data Deleted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // Service For Delete Pump

    public function delete_pump() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post('token');



        if ($token != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'status' => 0

                );

                $this->Service_model_15->master_fun_update_employee("shpump", $id, $data);

                echo $this->json_data("1", "Data Deleted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // pranjal work 25/4/2018

    // webservice for inventory report 

    public function inventory_report() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');

        $token = $this->input->get_post('token');

        $user_id = $this->input->get_post('user_id');

        $location_id = $this->input->get_post('location_id');

        $date_to = $this->input->get_post('date_to');

        $date_from = $this->input->get_post('date_from');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {



                //$data = $this->Service_model_15->master_fun_get_tbl_val_company_inventory_1($user_id, $date_to, $date_from, $current_date, $list[0]['id'], $location_id);

                $this->load->model('Daily_reports_model_new');

                //$data = $this->daily_reports_model->report($location_id, $date_from, $date_to);

                $data = $this->Daily_reports_model_new->report($location_id, $date_from, $date_to);

                if ($_GET['debug'] == '1') {

                    echo$this->db->last_query();

                }

                if ($data == null) {

                    echo $this->json_data("0", "Inventory not available", $data);

                } else {

                    echo $this->json_data("1", "", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    // Webservice for daily price report

    public function dailyprice_report() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');

        $token = $this->input->get_post('token');

        //$user_id = $this->input->get_post('user_id');

        $location_id = $this->input->get_post('location_id');

        $date_to = $this->input->get_post('date_to');

        $date_from = $this->input->get_post('date_from');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $data = $this->Service_model_15->master_fun_get_tbl_val_company_dailyprice($date_to, $date_from, $current_date, $location_id);

                //	echo $this->db->last_Query();

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    // webservice for reading report

    public function reading_report() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');

        $token = $this->input->get_post('token');

        $user_id = $this->input->get_post('user_id');

        $location_id = $this->input->get_post('location_id');

        $date_to = $this->input->get_post('date_from');

        $date_from = $this->input->get_post('date_to');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {

                $data = $this->Service_model_15->master_fun_get_tbl_val_company_reading($date_from, $date_to, $location_id);

                //echo $this->db->last_query();

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Sales not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    // pranjal works start 26/4/18

    // webservice for edit profile of company

    public function company_edit_profile() {

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $email = $this->input->get_post('email');

        $mobile = $this->input->get_post('mobile');

        if ($token != "" && $name != "" && $email != "" && $mobile != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $user = $this->Service_model_15->companylist_active_record($token);

                if ($user) {

                    $email2 = $user[0]['email'];

                    if ($email2 == $email) {

                        $data = array(

                            "name" => $name,

                            "email" => $email,

                            "mobile" => $mobile,

                        );

                        $update = $this->Service_model_15->master_fun_update("sh_com_registration", $token, $data);

                        if ($update) {

                            echo $this->json_data("1", "Your Profile has been Updated", "");

                        }

                    } else {

                        $row = $this->Service_model_15->master_num_rows("sh_com_registration", array("email" => $email, "status" => 1));

                        if ($row == 0) {

                            $data = array(

                                "name" => $name,

                                "email" => $email,

                                "mobile" => $mobile,

                            );



                            $update = $this->Service_model_15->master_fun_update("sh_com_registration", $token, $data);

                            if ($update) {

                                echo $this->json_data("1", "Your Profile has been Updated", "");

                            }

                        } else {

                            echo $this->json_data("0", "Email Already Registered", "");

                        }

                    }

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    // webservice for change password of company

    public function company_change_password() {

        $token = $this->input->get_post('token');

        $oldpassword = $this->input->get_post('oldpassword');

        $password = $this->input->get_post('password');

        if ($token != "" && $password != "" && $oldpassword != "") {



            $data2 = $this->Service_model_15->master_fun_get_tbl_val_company("sh_com_registration", array("token" => $token, "status" => 1), array("id", "asc"));

            if ($data2) {



                $row = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "asc"));

                $oldpass = $row[0]['password'];

                if ($oldpassword == $oldpass) {

                    $data = array(

                        "password" => $password,

                    );

                    $update = $this->Service_model_15->master_fun_update("sh_com_registration", $token, $data);

                    if ($update) {

                        echo $this->json_data("1", "Your Password has been Updated", "");

                    }

                } else {

                    echo $this->json_data("0", "old password not match", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    // webservice for forget password of company

    public function company_forget_password() {

        $this->load->library('email');

        $email = $this->input->get_post('email');

        if ($email != NULL) {



            $row = $this->Service_model_15->master_fun_get_tbl_val_1("sh_com_registration", array("email" => $email, "status" => 1), array("id", "asc"));

            $title = $this->config->item('title');

            if ($row != null) {

                $uniqueId = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5);

                $password = $row[0]['password'];

                $user = $row[0]['name'];

                $config['mailtype'] = 'html';

                $this->email->initialize($config);

                $message = "Hi " . ucwords($user) . ",<br/><br/>";

                $message .= "We received a request that you forgot the password for your Shri Hari account.<br/><br/>";

                $base = base_url();

                $message .= "<a href='" . $base . "login/get_company_password/" . $uniqueId . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Click To Reset password </a><br/><br/>";

                $message .= "If you did not make this request, please ignore this email or reply to let us know.<br/><br/>";

                $message .= "Thanks <br/> Shri Hari";

                send_mail($email, $title . ' forgotten Password', $message);

                $data1 = array("Rs" => $uniqueId);

                $insert = $this->Service_model_15->master_fun_update_companyEmail('sh_com_registration', $email, $data1);

                echo $this->json_data("1", "An email has been sent to your email address", "");

            } else {



                echo $this->json_data("0", "We couldn't find Shri Hari account associated with $email.", "");

            }

        } else {



            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    // Webservice for get company customer details

    public function company_customer_detail() {

        $token = $this->input->get_post("token");

        $location_id = $this->input->get_post("location_id");



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $company_id = $list[0]['id'];

                $data = $this->Service_model_15->compcustliast($location_id);

//                echo $this->db->last_query();

                if ($data) {



                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    // Webservice for get employee customer details

    public function employee_user_detail() {

        $token = $this->input->get_post("token");



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['company_id'];

                $data = $this->Service_model_15->master_fun_get_tbl_val_company_customer("sh_userdetail", array("sh_userdetail.company_id" => $company_id, "sh_userdetail.status" => 1), array("id", "asc"));

                echo $this->json_data("1", "", $data);

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    // Webservice for add customer in company

    public function add_customer() {

        $token = $this->input->get_post("token");

        $customer_name = $this->input->get_post('customer_name');

        $phone_no = $this->input->get_post('phone_no');

        $address = $this->input->get_post('address');

        $cheque_no = $this->input->get_post('cheque_no');

        $bank_name = $this->input->get_post('bank_name');

        $personal_guarantor = $this->input->get_post('personal_guarantor');

        $location_id = $this->input->get_post('location_id');



        if ($token != "" && $customer_name != "" && $phone_no != "" && $address != "" && $cheque_no != "" && $bank_name != "" && $personal_guarantor != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'company_id' => $company_id,

                    'name' => $customer_name,

                    'phone_no' => $phone_no,

                    'address' => $address,

                    'cheque_no' => $cheque_no,

                    'bank_name' => $bank_name,

                    'personal_guarantor' => $personal_guarantor,

                    'location_id' => $location_id,

                    'created_by' => date("Y-m-d H:i:s")

                );

                $insert = $this->Service_model_15->master_insert("sh_userdetail", $data);

                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not Passed.", "");

        }

    }



    // Webservice for edit customer in company

    public function edit_customer() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post("token");

        $customer_name = $this->input->get_post('customer_name');

        $phone_no = $this->input->get_post('phone_no');

        $address = $this->input->get_post('address');

        $cheque_no = $this->input->get_post('cheque_no');

        $bank_name = $this->input->get_post('bank_name');

        $personal_guarantor = $this->input->get_post('personal_guarantor');

        $location_id = $this->input->get_post('location_id');





        if ($token != "" && $customer_name != "" && $id != "" && $phone_no != "" && $address != "" && $cheque_no != "" && $bank_name != "" && $personal_guarantor != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'company_id' => $company_id,

                    'name' => $customer_name,

                    'phone_no' => $phone_no,

                    'address' => $address,

                    'cheque_no' => $cheque_no,

                    'bank_name' => $bank_name,

                    'personal_guarantor' => $personal_guarantor,

                    'location_id' => $location_id,

                    'created_by' => date("Y-m-d H:i:s")

                );

                $this->Service_model_15->master_fun_update_customer("sh_userdetail", $id, $data);

                echo $this->json_data("1", "Your Data Updated successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not Passed.", "");

        }

    }



    // Webservice for delete customer

    public function delete_customer() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post("token");





        if ($token != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'status' => 0

                );

                $this->Service_model_15->master_fun_update_customer("sh_userdetail", $id, $data);

                echo $this->json_data("1", "Your Data Deleted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not Passed.", "");

        }

    }



    // Webservice for expence report

    public function expense_report() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');



        $token = $this->input->get_post('token');



        $user_id = $this->input->get_post('user_id');

        $date_to = $this->input->get_post('date_to');

        $date_from = $this->input->get_post('date_from');

        $location_id = $this->input->get_post('location_id');





        if ($token != "") {



            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {

                $data = $this->Service_model_15->expence_date($location_id, $date_to, $date_from);

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function expense_details() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');



        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $location_id = $this->input->get_post('location_id');





        if ($token != "") {



            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {

                $data = $this->Service_model_15->expense_details($location_id, $date);

                //echo $this->db->last_Query();

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function online_transaction() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $invoice_no = $this->input->get_post('invoice_no');

        $creditors_id = $this->input->get_post('creditors_id');

        $amount = $this->input->get_post('amount');

        $paid_by = $this->input->get_post('paid_by');

        $cheque_tras_no = $this->input->get_post('cheque_tras_no');

        $bank_name = $this->input->get_post('bank_name');

        $remark = $this->input->get_post('remark');



        if ($token != "") {



            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];

                date_default_timezone_set('Asia/Kolkata');

                $data = array();



                $data = array(

                    'user_id' => $id,

                    'location_id' => $location_id,

                    'date' => $date,

                    'invoice_no' => $invoice_no,

                    'customer_name' => $creditors_id,

                    'amount' => $amount,

                    'paid_by' => $paid_by,

                    'cheque_tras_no' => $cheque_tras_no,

                    'created_by' => date("Y-m-d H:i:sa"),

                    'bank_name' => $bank_name,

                    'remark' => $remark,

                );

                $insert = $this->Service_model_15->master_insert("sh_onlinetransaction", $data);

                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function expence_detail() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');

        $ex_id = $this->input->get_post('ex_id');

        $token = $this->input->get_post('token');



        if ($token != "" && $ex_id != "") {



            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {



                $data = $this->Service_model_15->master_fun_get_tbl_val_expense_detail($company_id, $ex_id);



                echo $this->json_data("1", "", $data);

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    // pranjal works start 27/4/18

    // webservice for bankdeposit

    public function bankdeposit() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');



        $token = $this->input->get_post('token');

        //$user_id = $this->input->get_post('user_id');

        $date_to = $this->input->get_post('date_to');

        $date_from = $this->input->get_post('date_from');

        $location_id = $this->input->get_post('location_id');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {



                $data = $this->Service_model_15->master_fun_get_tbl_val_company_bankdeposit($date_to, $date_from, $current_date, $location_id);

                //echo $this->db->last_query();

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data no available.", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // webservice for bankdeposit

    public function onlinetransaction() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');



        $token = $this->input->get_post('token');

        $user_id = $this->input->get_post('user_id');

        $date_to = $this->input->get_post('date_to');

        $date_from = $this->input->get_post('date_from');

        $location_id = $this->input->get_post('location_id');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {



                $data = $this->Service_model_15->master_fun_get_tbl_val_company_onlinetrans($user_id, $date_to, $date_from, $current_date, $company_id, $location_id);

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data no available.", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function creditdebit_copy() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');



        $token = $this->input->get_post('token');

        $user_id = $this->input->get_post('user_id');

        $date_to = $this->input->get_post('date_to');

        $date_from = $this->input->get_post('date_from');

        $location_id = $this->input->get_post('location_id');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {



                $data = $this->Service_model_15->master_fun_get_tbl_val_company_credit_debit($user_id, $date_to, $date_from, $current_date, $company_id, $location_id);

                if ($data) {



                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function creditdebit() {

        date_default_timezone_set('Asia/Kolkata');

        $current_date = date('Y-m-d');



        $token = $this->input->get_post('token');

        $user_id = $this->input->get_post('customer_id');

        $date_to = $this->input->get_post('date_to');

        $date_from = $this->input->get_post('date_from');

        $location_id = $this->input->get_post('location_id');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            //$company_id = $list[0]['id'];

            if ($list) {



                $data = $this->Service_model_15->master_fun_get_tbl_val_company_credit_debit($user_id, $date_to, $date_from, $current_date, $location_id);

                //echo $this->db->last_Query();

                if ($data) {



                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // webservice for company user detail

    public function company_user_detail() {

        $token = $this->input->get_post('token');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                $data = $this->Service_model_15->company_user_detail($company_id);



                echo $this->json_data("1", "", $data);

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed.", "");

        }

    }



    // Service for add worker

    public function add_worker() {

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $shift = $this->input->get_post('shift');

        $location_id = $this->input->get_post('location_id');

        $mobile = $this->input->get_post('mobile');

        $address = $this->input->get_post('address');

        $adhar_no = $this->input->get_post('adhar_no');

        $salary = $this->input->get_post('salary');

        $extra_salary = $this->input->get_post('extra_salary');



        if ($token != "" && $name != "" && $shift != "" && $location_id != "" && $mobile != "" && $address != "" && $salary != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                $data = array(

                    'company_id' => $company_id,

                    'name' => $name,

                    'shift' => $shift,

                    'location_id' => $location_id,

                    'mobile' => $mobile,

                    'address' => $address,

                    'adhar_no' => $adhar_no,

                    'created_at' => date("Y-m-d H:i:sa"),

                    'salary' => $salary,

                    'extra_salary' => $extra_salary

                );

                $insert = $this->Service_model_15->master_insert("sh_workers", $data);



                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // Webservice for edit worker

    public function edit_worker() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $shift = $this->input->get_post('shift');

        $location_id = $this->input->get_post('location_id');

        $mobile = $this->input->get_post('mobile');

        $address = $this->input->get_post('address');

        $adhar_no = $this->input->get_post('adhar_no');

        $salary = $this->input->get_post('salary');

        $extra_salary = $this->input->get_post('extra_salary');



        if ($token != "" && $name != "" && $shift != "" && $location_id != "" && $mobile != "" && $address != "" && $salary != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $data = array(

                    'name' => $name,

                    'shift' => $shift,

                    'location_id' => $location_id,

                    'mobile' => $mobile,

                    'address' => $address,

                    'adhar_no' => $adhar_no,

                    'created_at' => date("Y-m-d H:i:sa"),

                    'extra_salary' => $extra_salary,

                    'salary' => $salary

                );

                $this->Service_model_15->master_fun_update_customer("sh_workers", $id, $data);

                echo $this->json_data("1", "Your Data Updated successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not Passed.", "");

        }

    }



    // Webservice for delete worker

    public function delete_worker() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post("token");





        if ($token != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                $data = array(

                    'status' => 0

                );

                $this->Service_model_15->master_fun_update_customer("sh_workers", $id, $data);

                echo $this->json_data("1", "Your Data Deleted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not Passed.", "");

        }

    }



    // service for get worker

    public function worker_list() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {

                $data = $this->Service_model_15->company_worker_list($company_id, $location_id);

//echo $this->db->last_query(); 

                if ($data) {

                    echo $this->json_data("1", "Worker list available", $data);

                } else {

                    echo $this->json_data("0", "Worker not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    // Service for add creditors

    public function add_creditors() {

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $location_id = $this->input->get_post('location_id');

        if ($token != "" && $name != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                $data = array(

                    'company_id' => $company_id,

                    'name' => $name,

                    'location_id' => $location_id,

                    'created_at' => date("Y-m-d H:i:sa"),

                );

                $insert = $this->Service_model_15->master_insert("sh_creditors", $data);



                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    // Webservice for edit creditors

    public function edit_creditors() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post('token');

        $name = $this->input->get_post('name');

        $location_id = $this->input->get_post('location_id');

        if ($token != "" && $name != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $data = array(

                    'name' => $name,

                    'location_id' => $location_id,

                    'created_at' => date("Y-m-d H:i:sa"),

                );

                $this->Service_model_15->master_fun_update_customer("sh_creditors", $id, $data);

                echo $this->json_data("1", "Your Data Updated successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not Passed.", "");

        }

    }



    // Webservice for delete creditors

    public function delete_creditors() {

        $id = $this->input->get_post('id');

        $token = $this->input->get_post("token");





        if ($token != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];



                $data = array(

                    'status' => 0

                );

                $this->Service_model_15->master_fun_update_customer("sh_creditors", $id, $data);

                echo $this->json_data("1", "Your Data Deleted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not Passed.", "");

        }

    }



    public function dummyreturn() {

        echo "<!DOCTYPE html>

        <html>

        <head>

        </head>

        <body>

        

        <table>

          <tr>

            <th>Firstname</th>

            <th>Lastname</th> 

          </tr>

          <tr>

            <td>Jill</td>

            <td>Smith</td>

          </tr>

          <tr>

            <td>Eve</td>

            <td>Jackson</td>

          </tr>

          <tr>

            <td>John</td>

            <td>Doe</td>

          </tr>

        </table>

        

        </body>

        </html>";

    }



    // service for get creditors

    public function creditors_list() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {



                $data = $this->Service_model_15->company_creditors_list($company_id, $location_id);

                if ($data) {

                    echo $this->json_data("1", "Creditors list available", $data);

                } else {

                    echo $this->json_data("0", "Creditors not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function company_creditors_list() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            $company_id = $list[0]['company_id'];

            $location_id = $list[0]['l_id'];

            if ($list) {

                $data = $this->Service_model_15->company_creditors_list($company_id, $location_id);



                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Creditors not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function add_salary() {

        $token = $this->input->get_post('token');

        $worker_id = $this->input->get_post('worker_id');

        $amount = $this->input->get_post('amount');

        $extra_amount = $this->input->get_post('extra_amount');

        $date = $this->input->get_post('date');

        $remark = $this->input->get_post('remark');

        $cutfromtheloan = $this->input->get_post('cutfromtheloan');

        $loanamount = $this->input->get_post('add_advance');

        $bonas_amount = $this->input->get_post('bonas_amount');

        $paymentType = $this->input->get_post('paymentType');

        $transactionNo = $this->input->get_post('transactionNo');

        $bankName = $this->input->get_post('bankName');

        $hours = $this->input->get_post('hours');

        if ($token != "" && $worker_id != "" && $date != "") {

			if($paymentType == 'n'){

				$paymentType = 'online';

			}

			if($paymentType == 'cs'){

				$paymentType = 'cash';

			}

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $companyid = $list[0]['company_id'];

                $location = $list[0]['l_id'];

                $data = array(

                    'worker_id' => $worker_id,

                    'amount' => $amount,

                    'date' => $date,

                    'remark' => $remark,

                    'created_at' => date("Y-m-d H:i:s"),

                    'extra_amount' => $extra_amount,

                    'loan_amount' => $loanamount,

                    'bonas_amount' => $bonas_amount,

                    'paid_loan_amount' => $cutfromtheloan,

                    'hours' => $hours,

					'paid_type'=>$paymentType

                );

                $insert = $this->Service_model_15->master_insert("sh_workers_salary", $data);

if($paymentType == 'online'){

	

	$insertData = array("user_id"=>$list[0]['id'],

	'location_id'=>$location,

	'date'=>$date,

	'invoice_no'=>'',

	'customer_name'=>'',

	'amount'=>$amount,

	'paid_by'=>'n',

	'cheque_tras_no'=>$transactionNo,

	'created_by'=>date('Y-m-d H:i:s'),

	'status'=>'1',

	'bank_name'=>$bankName,

	'salary_id'=>$insert);

	

	$this->Service_model_15->master_insert("sh_onlinetransaction", $insertData);

}

                // if($insert){

                // if($cutfromtheloan > 0 ){

                // $data = array(

                // 'worker_id' => $worker_id,

                // 'user_id' => $list[0]['id'],

                // 'paid_loan_amount' => $cutfromtheloan,

                // 'date' => $date,

                // 'remark' => $remark,

                // 'created_at' => date("Y-m-d H:i:s") ,

                // 'location_id'=>$location

                // );

                // $insert = $this->Service_model_15->master_insert("sh_personal_loan",$data);

                // if($loanamount > 0){

                // $data = array("worker_id"=>$worker_id,"user_id"=>$list[0]['id'],"location_id"=>$location,"loan_amount"=>$loanamount,'remark'=>$remark,'date'=>$date);

                // $insert = $this->Service_model_15->master_insert("sh_personal_loan",$data);

                // }

                // }

                // }

                if ($insert) {

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                } else {

                    echo $this->json_data("1", "Some thingis wrong", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    function worker_remaning_salsry() {

        $token = $this->input->get_post('token');

        $worker_id = $this->input->get_post('worker_id');

        $date = $this->input->get_post('date');

        if ($token != "" && $worker_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $month = date("m", date(strtotime($date)));

                $year = date("Y", date(strtotime($date)));

                $data = $this->Service_model_15->worker_salary_remening($worker_id, $month, $year);

                $loandetail = $this->Service_model_15->get_worker_loan_detail($worker_id, $date);

                $data->loan = $loandetail->loan_total - $loandetail->paid_loan_amount;

                //echo $this->db->last_query();

                //if($data){

                echo $this->json_data("1", "", array($data));

                //}else{

                //  echo $this->json_data("0","Data not available",$data);

                //}

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function emply_worker_list() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));



            $location_id = $list[0]['l_id'];

            if ($list) {

                $data = $this->Service_model_15->emp_worker_list($location_id);

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Worker not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function tank_dep_reding() {

        $list = $this->Service_model_15->get_tankreading('20kl');

        echo $this->json_data("1", "", $list);

    }



    public function tank_dep_reding_new() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            $location_id = $list[0]['l_id'];

            if ($list) {

                $tank_list = $this->Service_model_15->master_fun_get_tbl_val_with_order("sh_tank_list", array("location_id" => $location_id, "status" => 1), array("tank_name", "asc"));



                $fianlarray = array();

                foreach ($tank_list as $tank) {

                    $temp = array();

                    $temp['id'] = $tank->id;

                    $temp['name'] = $tank->tank_name;

                    $temp['type'] = $tank->fuel_type;

                    $temp['tank_chart'] = $this->Service_model_15->master_fun_get_tbl_val_with_order("sh_tank_chart", array("tank_id" => $tank->id, "status" => 1), array("reading", "asc"));

                    $fianlarray[] = $temp;

                }

                $data = $this->Service_model_15->get_tankreading($location[0]['tank_type']);

                if ($fianlarray) {

                    echo $this->json_data("1", "", $fianlarray);

                } else {

                    echo $this->json_data("0", "Sorry tank is not availeble.", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function daily_price() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "asc"));

            if ($list) {

                $companyid = $list[0]['l_id'];

                $data = $this->Service_model_15->master_fun_get_tbl_val("sh_dailyprice", array("user_id" => $companyid, "date" => $date, "status" => 1), array("id", "asc"));

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Daily Price not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function meter_reading_report() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $location_id = $this->input->get_post('location_id');

        if ($token != "" && $date != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $companyid = $list[0]['id'];

                $salesdetail = $this->Service_model_15->master_fun_get_tbl_val_select("id,UserId,shift,location_id,oil_reading,p_tank_reading,d_tank_reading,p_deep_reading,d_deep_reading,p_total_selling,d_total_selling,p_sales_vat,d_sales_vat,oil_pure_benefit,p_selling_price,d_selling_price,p_testing,d_testing,cash_on_hand", "shdailyreadingdetails", array("location_id" => $location_id, "status" => 1, "date" => $date), array("id", "id"));

                $data['deatil'] = $salesdetail[0];

                //echo "<pre>"; print_r($data); 



                $data['meterreading'] = $this->Service_model_15->master_fun_get_tbl_val("shreadinghistory", array("RDRId" => $salesdetail[0]['id'], "status" => "1", "date" => $date), array("id", "asc"));



                //echo "<pre>"; print_r($data); die();

                if ($data) {

                    echo $this->json_data("1", "", array($data));

                } else {

                    echo $this->json_data("0", "Merter Reading not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function inventory_detail() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $location_id = $this->input->get_post('location_id');



        if ($token != "" && $date != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $companyid = $list[0]['id'];

                $data = $this->Service_model_15->master_fun_get_tbl_val_meter_reading_data($date, $companyid, $location_id);

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Merter Reading not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function daily_price_new() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "asc"));

            if ($list) {

                $companyid = $list[0]['company_id'];

                $location = $list[0]['l_id'];

                $data = $this->Service_model_15->master_fun_get_tbl_val("sh_dailyprice", array("user_id" => $location, "date" => $date, "status" => 1), array("id", "asc"));



                if ($data) {



                    $inventorypetrol = $this->Service_model_15->get_inventory_detail('P', $location, $date);

                    if ($inventorypetrol) {

                        $inventorydiesel = $this->Service_model_15->get_inventory_detail('D', $location, $date);

                        if ($inventorydiesel) {

                            // $inventoryoil = $this->Service_model_15->get_inventory_detail('O',$location,$date);

                            // if($inventoryoil){}else{

                            // echo $this->json_data("0","Daily Inventory not available for oil","");

                            // die();

                            // }

                        } else {

                            echo $this->json_data("0", "Daily Inventory not available for diesel", "");

                            die();

                        }

                    } else {

                        echo $this->json_data("0", "Daily Inventory not available for petrol", "");

                        die();

                    }
					
					$checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_daily_tank_density", array("date" => $date, "status" => 1, "location_id" => $location), array("id", "asc"));

						if (!$checkentry) {

							echo $this->json_data("0", "Please Add Daily Tank density.", "");

							die();

						}




$newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                    $petrol = $this->Service_model_15->get_pump_list('P', $location);

                    $diesel = $this->Service_model_15->get_pump_list('D', $location);

                    $oil = $this->Service_model_15->get_pump_list_oil_new($location,$newdate);

                    

                    $petrolwithreading = array();

                    $xppetrolwithreading = array();

                    foreach ($petrol as $plist) {

                        $get_preding = $this->Service_model_15->master_fun_get_tbl_val("shreadinghistory", array("PumpId" => $plist['id'], "date" => $newdate, "status" => 1), array("id", "asc"));

                        if ($get_preding) {

                            $get_reset = $this->Service_model_15->master_fun_get_tbl_val("sh_reset_pump", array("pump_id" => $plist['id'], "date" => $date, "status" => 1), array("id", "asc"));

                            if ($get_reset) {

                                $plist['Reading'] = "00";

                            } else {

                                $plist['Reading'] = $get_preding[0]['Reading'];

                            }

                        } else {

                            $plist['Reading'] = "00";

                        }

						if($plist['xp_type'] == 'Yes'){

							$xppetrolwithreading[] = $plist;

						}else{

							$petrolwithreading[] = $plist;

						}

                    }

                    $dieselwithreading = array();

                    $xpdieselwithreading = array();

                    foreach ($diesel as $plist) {

                        $get_preding = $this->Service_model_15->master_fun_get_tbl_val("shreadinghistory", array("PumpId" => $plist['id'], "date" => $newdate, "status" => 1), array("id", "asc"));

                        if ($get_preding) {

                            $get_reset = $this->Service_model_15->master_fun_get_tbl_val("sh_reset_pump", array("pump_id" => $plist['id'], "date" => $date, "status" => 1), array("id", "asc"));

                            if ($get_reset) {

                                $plist['Reading'] = "00";

                            } else {

                                $plist['Reading'] = $get_preding[0]['Reading'];

                            }

                        } else {

                            $plist['Reading'] = "00";

                        }

						if($plist['xp_type'] == 'Yes'){

							$xpdieselwithreading[] = $plist;

						}else{

							$dieselwithreading[] = $plist;

						}

                    }

                    $meter_reading['petrol'] = $petrolwithreading;

                    $meter_reading['diesel'] = $dieselwithreading;

					$meter_reading['xppetrol'] = $xppetrolwithreading;

                    $meter_reading['xpdiesel'] = $xpdieselwithreading;

                    /*$tank = $this->Service_model_15->master_fun_get_tbl_val_with_order('sh_tank_list', array('status' => '1', 'location_id' => $location), array('tank_name', 'asc'));*/

					$tank = $this->Service_model_15->master_fun_get_tbl_val_with_order('sh_tank_list', array('status' => '1', 'location_id' => $location), array('tank_name', 'asc'));

					$tank_list = array();

					foreach($tank as $tliat){

						if($tliat->mobile_show == '0'){}else{

							$tank_list[] = $tliat;

						}

					}

                    $data[0]['meter_reading'] = $meter_reading;

                    $data[0]['oil_type'] = $oil;

                    $data[0]['tanks'] = $tank_list;

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Daily Price not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function inventory_detail_for_add() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $location_id = $list[0]['l_id'];

                $petroldata = $this->Service_model_15->inventory_detail_for_add($location_id, $date, "p");

                $xppetroldata = $this->Service_model_15->inventory_detail_for_add($location_id, $date, "xpp");

                $dieseldata = $this->Service_model_15->inventory_detail_for_add($location_id, $date, "d");

                $xpdieseldata = $this->Service_model_15->inventory_detail_for_add($location_id, $date, "xpd");

                $oildata = $this->Service_model_15->inventory_detail_for_add($location_id, $date, "o");

                $tankList = $this->Service_model_15->master_fun_get_tbl_val_with_order('sh_tank_list', array('status' => '1', 'location_id' => $location_id), array('tank_name', 'asc'));
				$tank = array();
				foreach($tankList as $tlist){
					
					if($tlist->mobile_show != 0 || $tlist->mobile_show == NULL){
					$tank[] = $tlist;
					}
				}

//echo $this->db->last_Query();

                $salesdata = $this->Service_model_15->sels_detail_for_add($location_id, $date);

                $temparra = (object) array("o_stock" => "0.00", "d_stock" => "0.00", "p_stock" => "0.00", "p_price" => "61.09", "d_price" => "65.23", "d_quantity" => "0.00", "p_quantity" => "0.00");

                if ($petroldata) {

                    

                } else {

                    $petroldata = $temparra;

                }

				if ($xppetroldata) {

                    

                } else {

                    $xppetroldata = $temparra;

                }

                if ($dieseldata) {

                    

                } else {

                    $dieseldata = $temparra;

                }

				if ($xpdieseldata) {

                    

                } else {

                    $xpdieseldata = $temparra;

                }

                if ($oildata) {

                    

                } else {

                    $oildata = $temparra;

                }

                if ($salesdata) {

                    

                } else {

                    $salesdata = (object) array("oil_reading" => "0.00", "p_tank_reading" => "0.00", "d_tank_reading" => "0.00");

                }

                $finalarray = array(

                    'petrol' => array($petroldata),

                    'diesel' => array($dieseldata),

					'xppetrol' => array($xppetroldata),

                    'xpdiesel' => array($xpdieseldata),

                    'oil' => array($oildata),

                    'selling' => array($salesdata),

                    'tanks' => $tank

                );



                // print_r($dieseldata);

                // print_r($oildata);

                // print_r($salesdata);

                if ($finalarray) {

                    echo $this->json_data("1", "", array($finalarray));

                } else {

                    echo $this->json_data("0", "Creditors not available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function detail_for_last_mnth() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $companyid = $list[0]['company_id'];

                $location_id = $list[0]['l_id'];

                $totalsalary = $this->Service_model_15->total_salary($companyid);

                $totalpaid = $this->Service_model_15->total_paid_salary($companyid, date('m', strtotime($date)), date('Y', strtotime($date)));

                $totaldebit = $this->Service_model_15->total_credit($location_id, date('m', strtotime($date)), date('Y', strtotime($date)), 'd');

                $TotalCredit = $this->Service_model_15->total_credit($location_id, date('m', strtotime($date)), date('Y', strtotime($date)), 'c');

                $total_onlinetransaction = $this->Service_model_15->total_onlinetransaction($location_id, date('m', strtotime($date)), date('Y', strtotime($date)));

                $total_bankdeposit = $this->Service_model_15->total_bankdeposit($location_id, date('m', strtotime($date)), date('Y', strtotime($date)));

                $temptotal = $total_bankdeposit->deposit_amount + $total_bankdeposit->withdraw_amount;

                $date = strtotime($date);

                $month = date("m", strtotime("-1 month", $date));



                $year = date("Y", strtotime("-1 month", $date));



                $c_month = date("m", $date);

                $c_year = date("Y", $date);

//                print_r($c_month);

//                die();

                $last_m_salary = $this->Service_model_15->last_month_data($month, $year, $location_id);

                //echo $this->db->last_query();

                $current_salary = $this->Service_model_15->last_month_data($c_month, $c_year, $location_id);

                ;

                $data = array('current_salary' => $current_salary->budget, 'last_m_salary' => $last_m_salary->budget, 'totalsalary' => $totalsalary->totalsalary, "totalpaid" => $totalpaid->totalpaidsalary, "totaldebit" => $totaldebit->total, "TotalCredit" => $TotalCredit->total, 'total_onlinetransaction' => $total_onlinetransaction->total, "total_bankdeposit" => "" . $temptotal);

                echo $this->json_data("1", "", array($data));

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function add_last_mnth_data() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $l_salary = $this->input->get_post('l_salary');

        $company_discount = $this->input->get_post('company_discount');

        $company_charge = $this->input->get_post('company_charge');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $location_id = $list[0]['l_id'];

                $data = array(

                    'location_id' => $location_id,

                    'date' => $this->input->get_post('date'),

                    // 'petrol' => $this->input->get_post('petrol'),

                    // 'diesel'=> $this->input->get_post('diesel'),

                    // 'oil'=> $this->input->get_post('oil'),

                    // 'axis_bank'=> $this->input->get_post('axis_bank'),

                    // 'advance_pay'=> $this->input->get_post('advance_pay'),

                    // 'bank_balance'=> $this->input->get_post('bank_balance'),

                    // 'ioc_balance'=> $this->input->get_post('ioc_balance'),

                    'cash_on_hand' => $this->input->get_post('cash_on_hand'),

                    'debit' => $this->input->get_post('debit'),

                    'credit' => $this->input->get_post('credit'),

                    'company_discount' => $this->input->get_post('company_discount'),

                    'l_salary' => $this->input->get_post('l_salary'),

                    'company_charge' => $this->input->get_post('company_charge'),

                    'ioc_amount' => $this->input->get_post('ioc_amount'),

                    'budget' => $this->input->get_post('budget'),

                        // 'salary' => $this->input->get_post('salary'),

                        // 'vat' => $this->input->get_post('vat'),

                        // 'pure_benefit'=> $this->input->get_post('pure_benefit'),

                        // 'mis_match'=>$this->input->get_post('mis_match') 

                );

                $insert = $this->Service_model_15->master_insert("sh_last_day_entry", $data);

                if ($insert) {



                    echo $this->json_data("1", "Your Data submitted successfully", "");

                } else {

                    echo $this->json_data("0", "Some thing is Wrong Please try again", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }



    public function new_credit_debit() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

      //  $payment_type = $this->input->get_post('payment_type');

      //  $batch_no = $this->input->get_post('batch_no');

        $iocbatch_no = $this->input->get_post('iocbatch_no');

       // $amount = $this->input->get_post('amount');

        $iocamount = $this->input->get_post('iocamount');

        $customer_id = $this->input->get_post('customer_id');

        $bill_no = $this->input->get_post('bill_no');

        $vehicle_no = $this->input->get_post('vehicle_no');

        $fuel_type = $this->input->get_post('fuel_type');

        $quantity = $this->input->get_post('quantity');

        $remark = $this->input->get_post('remark');

        $transaction_type = $this->input->get_post('transaction_type');

        $transaction_number = $this->input->get_post('transaction_number');

        $walletdata = $this->input->get_post('walletdata');

        $typedata = $this->input->get_post('type');

        $book = json_decode($walletdata, true);

        $type = json_decode($typedata, true);



        $bank_name = $this->input->get_post('bank_name');

        // if($token != "" && $date != "" && $payment_type != "" && $bill_no != "" && $vehicle_no != "" && $fuel_type != "" && $amount != "" && $quantity != "" && $batch_no != "")

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));



            if ($list) {

                if ($date != 'Select Date') {

                    $id = $list[0]['id'];

                    $location_id = $list[0]['l_id'];

                    foreach ($type as $key ){ 

                    $extra_id = $key['id'];

                    $amount = $key['amount'];

                    $batch_no = $key['batch_no'];

                    $data = array(

                        'date' => $date,

                        'payment_type' => 'd',

                        'batch_no' => $batch_no,

                        'amount' => $amount,

                        'bill_no' => $bill_no,

                        'vehicle_no' => $vehicle_no,

                        'fuel_type' => $fuel_type,

                        'quantity' => $quantity,

                        'user_id' => $id,

                        'location_id' => $location_id,

                        'remark' => $remark,

                        'transaction_type' => $transaction_type,

                        'transaction_number' => $transaction_number,

                        'bank_name' => $bank_name,

                        'type' => '2',

                        'created_by' => date("Y-m-d H:i:s"),

                        'customer_id' => $customer_id,

                        'extra_id' => $extra_id

                    );

                    $insert = $this->Service_model_15->master_insert("sh_credit_debit", $data);

                }

                    if ($customer_id == '' && $iocbatch_no != "" && $iocamount != "") {

                        $data = array(

                            'date' => $date,

                            'payment_type' => 'ioc',

                            'batch_no' => $iocbatch_no,

                            'amount' => $iocamount,

                            'bill_no' => '',

                            'vehicle_no' => '',

                            'fuel_type' => '',

                            'quantity' => '',

                            'user_id' => $id,

                            'location_id' => $location_id,

                            'remark' => $remark,

                            'transaction_type' => '',

                            'transaction_number' => '',

                            'bank_name' => '',

                            'type' => '1',

                            'created_by' => date("Y-m-d H:i:sa")

                        );

                        $insert = $this->Service_model_15->master_insert("sh_credit_debit", $data);

                        //	print_r($data); die();

                    }

                    if ($walletdata != "") {

                        foreach ($book as $row) {

                            $extra_id = $row['id'];

                            $name = $row['name'];

                            $value = $row['value'];

                            $data = Array(

                                'date' => $date,

                                'location_id' => $location_id,

                                'user_id' => $id,

                                'extra_id' => $extra_id,

                                'payment_type' => 'extra',

                                'amount' => $value,

                                'batch_no' => $name,

                                'type' => '3',

                                'created_by' => date("Y-m-d H:i:s")

                            );



                            $insert = $this->Service_model_15->master_insert("sh_credit_debit", $data);

                        }

                    }

                    if ($insert) {

                        echo $this->json_data("1", "Your Data submitted successfully", "");

                    } else {

                        echo $this->json_data("0", "Some think is wrong", "");

                    }

                } else {

                    echo $this->json_data("0", "Please Select valid date", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function check_version() {

        $finalarray = array("vesion_code" => "$this->version_code", "flag" => "TRUE");

        echo $this->json_data("1", "", array($finalarray));

    }



    public function add_loan() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $amount = $this->input->get_post('amount');

        $worker_id = $this->input->get_post('worker_id');

        $remark = $this->input->get_post('remark');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];

                $data = array("worker_id" => $worker_id, "user_id" => $id, "location_id" => $location_id, "loan_amount" => $amount, 'remark' => $remark, 'date' => $date);

                $insert = $this->Service_model_15->master_insert("sh_personal_loan", $data);

                if ($insert) {

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                } else {

                    echo $this->json_data("0", "Some think is wrong", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function inventory_report_detail() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');

        $date = $this->input->get_post('date');



        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                //$this->load->model('daily_reports_model');

                $this->load->model('daily_reports_model_new');



                $data = $this->daily_reports_model_new->report_date($location_id, $date);

                if ($data) {

                    $data->meter_details = $this->daily_reports_model_new->meter_details($location_id, $date);

                    // echo $this->db->last_Query();

                    $data->oil_details = $this->daily_reports_model_new->oil_data($location_id, $date);



                    //  echo $this->db->last_query();

                    $main_id = $data->oil_details[0]->id;

                    //  echo $main_id;

                    $data->oil_details[0]->oil_data = $this->daily_reports_model_new->all_oil_data($main_id);

                    echo $this->json_data("1", "", array($data));

                } else {

                    echo $this->json_data("0", "Data not available", $data);

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function bank_report() {

        $token = $this->input->get_post('token');

        $fdate = $this->input->get_post('sdate');

        $tdate = $this->input->get_post('edate');

        $location = $this->input->get_post('lid');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            if ($list) {

                /* $list = $this->Service_model_15->bankdeposit_list($fdate, $tdate, $location);

                  $onlinelist = $this->Service_model_15->online_list($fdate, $tdate, $location);

                  $creadit_dabit_list = $this->Service_model_15->creadit_dabit_list($fdate, $tdate, $location); */

                $this->load->model('bank_deposit_model');

                $list = $this->bank_deposit_model->bankdeposit_list($fdate, $tdate, $location);

                $onlinelist = $this->bank_deposit_model->online_list($fdate, $tdate, $location);

                $creadit_dabit_list = $this->bank_deposit_model->creadit_dabit_list($fdate, $tdate, $location);

                $wallet_list = $this->bank_deposit_model->wallet_list($fdate, $tdate, $location);

                $petty_cash_deposit_list = $this->bank_deposit_model->petty_cash_deposit_list($fdate, $tdate, $location);

                $petty_cash_withdrawal_list = $this->bank_deposit_model->petty_cash_withdrawal_list($fdate, $tdate, $location);

                $fianlarray = array();

                foreach ($list as $bankdetail) {

                    $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;

                    $fianlarray[$bankdetail->date]['deposit_amount'] = $bankdetail->deposit_amount;

                    $fianlarray[$bankdetail->date]['depositamonut'] = $bankdetail->cs_total;

                    $fianlarray[$bankdetail->date]['amount'] = "00.00";

                    $fianlarray[$bankdetail->date]['card_amount'] = "00.00";

                    $fianlarray[$bankdetail->date]['wallet_list'] = "00.00";

                    $fianlarray[$bankdetail->date]['petty_cash_deposit'] = "00.00";

                    $fianlarray[$bankdetail->date]['petty_cash_withdrawal'] = "00.00";

                }

                foreach ($onlinelist as $bankdetail) {

                    $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;

                    $fianlarray[$bankdetail->date]['amount'] = $bankdetail->amount;

                    if ($fianlarray[$bankdetail->date]['deposit_amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['deposit_amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['depositamonut']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['depositamonut'] = "00.00";

                    }

                    $fianlarray[$bankdetail->date]['card_amount'] = "00.00";

                    $fianlarray[$bankdetail->date]['wallet_list'] = "00.00";

                    $fianlarray[$bankdetail->date]['petty_cash_deposit'] = "00.00";

                    $fianlarray[$bankdetail->date]['petty_cash_withdrawal'] = "00.00";

                }

                foreach ($creadit_dabit_list as $bankdetail) {

                    $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;

                    $fianlarray[$bankdetail->date]['card_amount'] = $bankdetail->card_amount;

                    if ($fianlarray[$bankdetail->date]['deposit_amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['deposit_amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['depositamonut']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['depositamonut'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['amount'] = "00.00";

                    }

                    $fianlarray[$bankdetail->date]['wallet_list'] = "00.00";

                    $fianlarray[$bankdetail->date]['petty_cash_deposit'] = "00.00";

                    $fianlarray[$bankdetail->date]['petty_cash_withdrawal'] = "00.00";

                }

                foreach ($wallet_list as $bankdetail) {

                    $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;

                    $fianlarray[$bankdetail->date]['wallet_list'] = $bankdetail->card_amount;

                    if ($fianlarray[$bankdetail->date]['deposit_amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['deposit_amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['depositamonut']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['depositamonut'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['card_amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['card_amount'] = "00.00";

                    }

                    $fianlarray[$bankdetail->date]['petty_cash_deposit'] = "00.00";

                    $fianlarray[$bankdetail->date]['petty_cash_withdrawal'] = "00.00";

                }

                foreach ($petty_cash_deposit_list as $bankdetail) {



                    $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;

                    $fianlarray[$bankdetail->date]['petty_cash_deposit'] = $bankdetail->total;



                    if ($fianlarray[$bankdetail->date]['deposit_amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['deposit_amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['depositamonut']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['depositamonut'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['card_amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['card_amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['wallet_list']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['wallet_list'] = "00.00";

                    }

                    $fianlarray[$bankdetail->date]['petty_cash_withdrawal'] = "00.00";

                }

                foreach ($petty_cash_withdrawal_list as $bankdetail) {

                    $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;

                    $fianlarray[$bankdetail->date]['petty_cash_withdrawal'] = $bankdetail->total;

                    if ($fianlarray[$bankdetail->date]['deposit_amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['deposit_amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['depositamonut']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['depositamonut'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['card_amount']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['card_amount'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['wallet_list']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['wallet_list'] = "00.00";

                    }

                    if ($fianlarray[$bankdetail->date]['petty_cash_deposit']) {

                        

                    } else {

                        $fianlarray[$bankdetail->date]['petty_cash_deposit'] = "00.00";

                    }

                }

                /* $fianlarray = array();

                  foreach ($list as $bankdetail) {

                  $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;

                  $fianlarray[$bankdetail->date]['deposit_amount'] = $bankdetail->deposit_amount;

                  $fianlarray[$bankdetail->date]['chequedeposit'] = $bankdetail->depositamonut;

                  }

                  foreach ($onlinelist as $bankdetail) {

                  $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;

                  $fianlarray[$bankdetail->date]['amount'] = $bankdetail->amount;

                  }

                  foreach ($creadit_dabit_list as $bankdetail) {

                  $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;

                  $fianlarray[$bankdetail->date]['card_amount'] = $bankdetail->card_amount;

                  } */



                function sortByName($a, $b) {

                    $a = $a['date'];

                    $b = $b['date'];



                    if ($a == $b)

                        return 0;

                    return ($a < $b) ? -1 : 1;

                }



                usort($fianlarray, 'sortByName');

                if ($fianlarray) {

                    echo $this->json_data("1", "", $fianlarray);

                } else {

                    echo $this->json_data("0", "Data not available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed");

        }

    }



    public function get_pump_list() {

        $token = $this->input->get_post('token');

        $id = $this->input->get_post('id');

        $date = $this->input->get_post('date');

        //$location_id = $this->input->get_post('location_id');







        if ($token != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $data = $this->Service_model_15->meter_details($id);

                //  echo $this->db->last_query();

                //$data = $this->Service_model_15->get_pump_list_Detail($id);

                //echo $this->db->last_query();

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function bank_report_details() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $location = $this->input->get_post('lid');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            $company_id = $list[0]['id'];

            $data = array();

            if ($list) {

                /* $data['bankdeposit'] = $this->Service_model_15->bankdeposit_list_view($date, $location);

                  $data['onlinelist'] = $this->Service_model_15->online_list_view($date, $location);

                  $data['creadit_dabit_list'] = $this->Service_model_15->creadit_dabit_list_view($date, $location); */

                $this->load->model('bank_deposit_model');

                $data['bankdeposit'] = $this->bank_deposit_model->bankdeposit_list_view($date, $location);

                $data['onlinelist'] = $this->bank_deposit_model->online_list_view($date, $location);

                $data['creadit_dabit_list'] = $this->bank_deposit_model->creadit_dabit_list_view($date, $location);

                $data['wallet_list'] = $this->bank_deposit_model->wallet_list_view($date, $location);

                $data['get_petty_cash_tasection_list'] = $this->bank_deposit_model->get_petty_cash_tasection_list($date, $location);

                if ($data) {

                    echo $this->json_data("1", "", array($data));

                } else {

                    echo $this->json_data("0", "Data not available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed");

        }

    }



    function bankdeposit_edit() {

        $token = $this->input->get_post('token');

        $id = $this->input->get_post('bankdeposit_id');

//        print_r($_POST);



        if ($token != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            //echo $this->db->last_query();

            if ($list) {

                $data['bankdeposit'] = $this->Service_model_15->bankdeposit_info($id);



                $data['d_amount'] = $this->Service_model_15->view_d_amount($id);

//                echo $this->db->last_query();

                if ($data) {

                    echo $this->json_data("1", "", array($data));

                } else {

                    echo $this->json_data("0", "Data not available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function get_expence_list() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $location_id = $list[0]['l_id'];

                $data = $this->Service_model_15->get_expence_list($location_id);



                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function get_expence_types_list() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');

        if ($token != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $data = $this->Service_model_15->getall("sh_expensein_types", array("comapny_id" => $company_id, "status" => 1, "exps_id" => 1, "location_id" => $location_id));

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data not available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function insert_expence_types() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');

        $exps_name = $this->input->get_post('exps_name');

        if ($token != "" && $exps_name != "" && $location_id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $data = $this->Service_model_15->master_insert("sh_expensein_types", array("comapny_id" => $company_id, "status" => 1, "exps_id" => 1, "location_id" => $location_id, "exps_name" => $exps_name));

                if ($data) {

                    echo $this->json_data("1", "Data Added", array());

                } else {

                    echo $this->json_data("0", "Data Not Added", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function update_expence_types() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');

        $exps_name = $this->input->get_post('exps_name');

        $id = $this->input->get_post('id');

        if ($token != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $data = $this->Service_model_15->master_update("sh_expensein_types", array("id" => $id), array("comapny_id" => $company_id, "location_id" => $location_id, "exps_name" => $exps_name));

                if ($data) {

                    echo $this->json_data("1", "Data Updated", array());

                } else {

                    echo $this->json_data("0", "Data Not Updated", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function delete_expence_types() {

        $token = $this->input->get_post('token');

        $id = $this->input->get_post('id');

        if ($token != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $data = $this->Service_model_15->master_update("sh_expensein_types", array("id" => $id), array("status" => 0));

                if ($data) {

                    echo $this->json_data("1", "Data Deleted", array());

                } else {

                    echo $this->json_data("0", "Data Not Deleted", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function comapny_tank_list() {

        $token = $this->input->get_post('token');

        $location = $this->input->get_post('location');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {



                $company_id = $list[0]['id'];

                $cond = array("company_id" => $company_id);

                if ($location != "") {

                    $cond['location_id'] = $location;

                }

                $data = $this->Service_model_15->master_fun_get_tbl_val_with_order('sh_tank_list', $cond, array('tank_name', 'asc'));

                if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data Not Available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }

	public function location_tank_list() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {



                $company_id = $list[0]['id'];

                $cond = array("location_id" => $list[0]['l_id'],"show"=>"1","status"=>"1");

                

                

                $data = $this->Service_model_15->master_fun_get_tbl_val_with_order('sh_tank_list', $cond, array('tank_name', 'asc'));

				

				if ($data) {

                    echo $this->json_data("1", "", $data);

                } else {

                    echo $this->json_data("0", "Data Not Available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }

    public function comapny_tank_add() {

        $token = $this->input->get_post('token');

        $location = $this->input->get_post('location');

        $name = $this->input->get_post('name');

        $type = $this->input->get_post('type');

        $fuel_type = $this->input->get_post('fuel_type');

        if ($token != "" && $location != "" && $name != "" && $type != "" && $fuel_type != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $array = array('location_id' => $location,

                    'company_id' => $company_id,

                    'tank_name' => $name,

                    'tank_type' => $type,

                    'fuel_type' => $fuel_type);

                $data = $this->Service_model_15->master_insert("sh_tank_list", $array);

                if ($data) {

                    echo $this->json_data("1", "Your Data submitted successfully.", $data);

                } else {

                    echo $this->json_data("0", "Something is wrong please try after some time", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function comapny_tank_update() {

        $token = $this->input->get_post('token');

        $location = $this->input->get_post('location');

        $name = $this->input->get_post('name');

        $type = $this->input->get_post('type');

        $fuel_type = $this->input->get_post('fuel_type');

        $id = $this->input->get_post('id');

        if ($token != "" && $location != "" && $name != "" && $type != "" && $fuel_type != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $array = array('location_id' => $location,

                    'company_id' => $company_id,

                    'tank_name' => $name,

                    'tank_type' => $type,

                    'fuel_type' => $fuel_type);

                $data = $this->Service_model_15->master_update("sh_tank_list", array("id" => $id), $array);

                if ($data) {

                    echo $this->json_data("1", "Your Data updated successfully.", $data);

                } else {

                    echo $this->json_data("0", "Something is wrong please try after some time", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function comapny_tank_delete() {

        $token = $this->input->get_post('token');

        $id = $this->input->get_post('id');

        if ($token != "" && $id != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $company_id = $list[0]['id'];

                $array = array('status' => '0');

                $data = $this->Service_model_15->master_update("sh_tank_list", array("id" => $id), $array);



                if ($data) {

                    echo $this->json_data("1", "Your Data deleted successfully.", $data);

                } else {

                    echo $this->json_data("0", "Something is wrong please try after some time", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function get_user_entry() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $inventory = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("user_id" => $id, "status" => 1, "date" => $date), array("date", "asc"));

                $shdailyreadingdetails = $this->Service_model_15->master_fun_get_tbl_val_new("shdailyreadingdetails", array("UserId" => $id, "status" => 1, "date" => $date), array("date", "asc"), 'id,data,date,oil_reading,p_tank_reading,d_tank_reading,p_deep_reading,d_deep_reading,d_total_selling,p_total_selling,p_selling_price,d_selling_price,p_sales_vat,d_sales_vat,p_testing,d_testing,cash_on_hand');



                $shdailyreadingdetails[0]['tank_wies_reading_sales'] = $this->Service_model_15->master_fun_get_tbl_val_new("sh_tank_wies_reading_sales", array("sales_id" => $shdailyreadingdetails[0]['id'], "status" => 1, "date" => $date), array("date", "asc"), '*');

                $sh_expensein_details = $this->Service_model_15->master_fun_get_tbl_val("sh_expensein_details", array("user_id" => $id, "status" => 1, "date" => $date), array("date", "asc"));

                $sh_credit_debit = $this->Service_model_15->master_fun_get_tbl_val_new("sh_credit_debit", array("user_id" => $id, "status" => 1, "date" => $date), array("date", "asc"), 'date,payment_type,batch_no,amount,customer_id,bill_no,vehicle_no,fuel_type,quantity,transaction_type,transaction_number,bank_name');

                $sh_bankdeposit = $this->Service_model_15->master_fun_get_tbl_val("sh_bankdeposit", array("user_id" => $id, "status" => 1, "date" => $date), array("date", "asc"));

                $sh_onlinetransaction = $this->Service_model_15->master_fun_get_tbl_val("sh_onlinetransaction", array("user_id" => $id, "status" => 1, "date" => $date), array("date", "asc"));

                $data['inventory'] = $inventory;

                $data['shdailyreadingdetails'] = $shdailyreadingdetails;

                $data['sh_expensein_details'] = $sh_expensein_details;

                $data['sh_credit_debit'] = $sh_credit_debit;

                $data['sh_bankdeposit'] = $sh_bankdeposit;

                $data['sh_onlinetransaction'] = $sh_onlinetransaction;

                echo str_replace('\"', '"', $this->json_data("1", "", array($data)));

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function get_user_entry_inventory() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $l_id = $list[0]['l_id'];

//                $inventory = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("user_id" => $id, "status" => 1, "date" => $date), array("date", "asc"));

                $inventory = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("location_id" => $l_id, "status" => 1, "date" => $date), array("date", "asc"));

                

//				$oil_inventory = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_inventory_data_master", array("user_id" => $id, "status" => 1, "date" => $date), array("date", "asc"));

				$oil_inventory = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_inventory_data_master", array("location_id" => $l_id, "status" => 1, "date" => $date), array("date", "asc"));

                $oil_details = $this->Service_model_15->oil_view_details($oil_inventory[0]["id"]);

                if (!empty($oil_details)) {

                    $oil_inventory[0]['oil_details'] = $oil_details;

                }

                if ($_GET['dub'] == 1) {

					echo "<pre>"; print_r($inventory); die;

                    print_r($inventory);

					echo "<br><br><br>";	

                    print_r($oil_inventory);

                }

                //if (!empty($inventory) && !empty($oil_inventory)) {

                if (!empty($inventory)) {

					$final = $inventory;

					$inventory = array();

					foreach($final as $finallist){

						$invid = $finallist['id'];

						$finallist['qty_in_tank_list'] = $this->Service_model_15->master_fun_get_tbl_val("tank_volume_inventory", array("inv_id" => $invid, "status" => 1), array("id", "asc"));

						$inventory[] = $finallist;

					}

                    $data['inventory'] = $inventory;

                    $data['oil_inventory'] = $oil_inventory;

                    echo str_replace('\"', '"', $this->json_data("1", "", array($data)));

                } else {

                    echo $this->json_data("0", "Entry Not Available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function get_user_entry_onlinetransaction() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $sh_onlinetransaction = $this->Service_model_15->get_user_entry_onlinetransaction($id, $date);



                if ($sh_onlinetransaction) {



                    echo $this->json_data("1", "", $sh_onlinetransaction);

                } else {

                    echo $this->json_data("0", "Entry not available.", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function get_user_entry_bankdeposit() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));



            if ($list) {

                $id = $list[0]['id'];

                $l_id = $list[0]['l_id'];

                $sh_bankdeposit = $this->Service_model_15->get_bankdeposit_entry($l_id, $date,$id);

//               echo $this->db->last_query();

                $sh_bankdeposit[0]->credit_debit_data = $this->Service_model_15->get_credit_debit_data_by_user($l_id, $date,$id);

//echo $this->db->last_query();

                if (!empty($sh_bankdeposit) && !empty($sh_bankdeposit[0]->credit_debit_data)) {

                    echo $this->json_data("1", "", $sh_bankdeposit);

                } else {

                    echo $this->json_data("0", "Entry not available.", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function get_user_entry_credit_debit() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $l_id = $list[0]['l_id'];

                $credi_debit = $this->Service_model_15->date_credi_debit($date, $id);



                $wallet_data = $this->Service_model_15->get_credit_debit_data($date, $l_id);

                $farray = array("credi_debit" => $credi_debit,

                    "wallet_data" => $wallet_data);

                if ($farray) {

                    echo $this->json_data("1", "", array($farray));

                } else {

                    echo $this->json_data("0", "Entry not available.", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function get_user_entry_expensein_details() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $sh_expensein_details = $this->Service_model_15->master_fun_get_tbl_val("sh_expensein_details", array("user_id" => $id, "status" => 1, "date" => $date), array("date", "asc"));

                $data['sh_expensein_details'] = $sh_expensein_details;

                echo str_replace('\"', '"', $this->json_data("1", "", $sh_expensein_details));

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function get_user_entry_readingdetails() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $shdailyreadingdetails = $this->Service_model_15->master_fun_get_tbl_val_new("shdailyreadingdetails", array("UserId" => $id, "status" => 1, "date" => $date), array("date", "asc"), 'id,data,date,oil_reading,p_tank_reading,d_tank_reading,p_deep_reading,d_deep_reading,d_total_selling,p_total_selling,p_selling_price,d_selling_price,p_sales_vat,d_sales_vat,p_testing,d_testing,cash_on_hand');

                if ($shdailyreadingdetails) {

                    $shdailyreadingdetails[0]['tank_wies_reading_sales'] = $this->Service_model_15->master_fun_get_tbl_val_new("sh_tank_wies_reading_sales", array("sales_id" => $shdailyreadingdetails[0]['id'], "status" => 1, "date" => $date), array("date", "asc"), '*');

                    $shdailyreadingdetails[0]['get_oil_detail_separate'] = $this->Service_model_15->get_oil_detail_separate_price($id, $date);

                    if ($_GET['dub'] == 1) {

                        echo $this->db->last_query();

                    }

                    $data['shdailyreadingdetails'] = $shdailyreadingdetails[0];

                    echo str_replace('\"', '"', $this->json_data("1", "", $shdailyreadingdetails));

                } else {

                    echo $this->json_data("0", "Entry Not Available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function demo() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function master_credit_debit() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $payment_type = $this->input->get_post('payment_type');

        $data = $this->input->get_post('data');

        // $batch_no = $this->input->get_post('batch_no');

        // $iocbatch_no = $this->input->get_post('iocbatch_no');

        // $amount = $this->input->get_post('amount');

        // $iocamount = $this->input->get_post('iocamount');

        // $customer_id = $this->input->get_post('customer_id');

        // $bill_no = $this->input->get_post('bill_no');

        // $vehicle_no = $this->input->get_post('vehicle_no');

        // $fuel_type = $this->input->get_post('fuel_type');

        // $quantity = $this->input->get_post('quantity');

        // $remark = $this->input->get_post('remark');

        // $transaction_type = $this->input->get_post('transaction_type');

        // $transaction_number = $this->input->get_post('transaction_number');

        // $bank_name = $this->input->get_post('bank_name');

        // if($token != "" && $date != "" && $payment_type != "" && $bill_no != "" && $vehicle_no != "" && $fuel_type != "" && $amount != "" && $quantity != "" && $batch_no != "")

        if ($token != "" && $date != "" && $data != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));



            if ($list) {

                $all_data = json_decode($data, TRUE);

                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];

                $datains = array("user_id" => $id, "location_id" => $location_id, "data" => $data, "date" => $date);

                $insertid = $this->Service_model_15->master_insert("sh_master_credit_debit", $datains);

                foreach ($all_data as $datadetail) {

                    if ($datadetail['fuelType'] == 'p') {

                        $fuelType = 'Petrol';

                    } else if ($datadetail['fuelType'] == 'd') {

                        $fuelType = 'Diesel';

                    } else {

                        $fuelType = 'Oil';

                    }

                    $data = array(

                        'date' => $date,

                        'payment_type' => $payment_type,

                        'amount' => $datadetail['amount'],

                        'bill_no' => $datadetail['billNo'],

                        'vehicle_no' => $datadetail['vehicleNo'],

                        'fuel_type' => $fuelType,

                        'quantity' => $datadetail['qty'],

                        'user_id' => $id,

                        'location_id' => $location_id,

                        'remark' => $datadetail['remarks'],

                        'created_by' => date("Y-m-d H:i:s"),

                        'customer_id' => $datadetail['customerId'],

                        'c_d_id' => $insertid,

                        'varification_code' => $datadetail['varification_code']

                    );

                    $insert = $this->Service_model_15->master_insert("sh_credit_debit", $data);

                }



                if ($insert) {

                    echo $this->json_data("1", "Your Data submitted successfully", "");

                } else {

                    echo $this->json_data("0", "Some think is wrong", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function employee_wallet_list() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $wallet_list = $this->Service_model_15->master_fun_get_tbl_val("sh_wallet_list", array("location_id" => $list[0]['l_id'], "status" => 1), array("name", "asc"));

				$card_list = $this->Service_model_15->master_fun_get_tbl_val("sh_card_list", array("location_id" => $list[0]['l_id'], "status" => 1), array("name", "asc"));

				$final = array("wallet_list"=>$wallet_list,"card_list"=>$card_list);

                if ($final) {

                    echo str_replace('\"', '"', $this->json_data("1", "", array($final)));

                } else {

                    echo $this->json_data("0", "Data Not Available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function update_profit() {

        $month = date('m');

        $year = date('Y');

//        print_r($month);

        $update_profit = $this->Service_model_15->update_profit($month, $year);

//        print_r($update_profit);

//        echo $this->db->last_query();

//        die();

        foreach ($update_profit as $pro) {

            $row = $this->Service_model_15->master_num_rows("monthly_selling", array("month" => $pro->month, "year" => $pro->year, "location_id" => $pro->location_id, "status" => 1));

            $data = array("month" => $pro->month,

                "location_id" => $pro->location_id,

                "year" => $pro->year,

                "p_selling" => $pro->p_selling,

                "d_selling" => $pro->d_selling);



            if ($row == 0) {

                $insert = $this->Service_model_15->master_insert("monthly_selling", $data);

            } else {

                $data = $this->Service_model_15->master_update("monthly_selling", array("month" => $pro->month, "year" => $pro->year, "location_id" => $pro->location_id), $data);

            }

        }

        echo $this->json_data("1", "Data save successfully", "");

    }



    public function master_add_expense() {

        $token = $this->input->get_post('token');

        $date2 = $this->input->get_post('date');

        $data = $this->input->get_post('data');

        $pamoutnew = json_decode($data, TRUE);

        $time = $date = date('Y-m-d H:i:s');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];

                $insert = $this->Service_model_15->master_insert("sh_expensein_master_details", array("user_id" => $id, "location_id" => $location_id, "date" => $date2, "data" => $data));

                if ($insert) {

                    foreach ($pamoutnew as $expence) {

                        $data1 = array(

                            "user_id" => $id,

                            "location_id" => $location_id,

                            "date" => $date2,

                            "amount" => $expence['value'],

                            "reson" => $expence['reason'],

                            'expense_id' => $expence['id'],

							"expense_type" => $expence['expense_type']

							);

							

							

                        $insertid = $this->Service_model_15->master_insert("sh_expensein_details", $data1);

						if($expence['expense_type'] == 'bank'){

								 $data = array(

								'user_id' => $id,

								'location_id' => $location_id,

								'date' => $date2,

								'invoice_no' => 'Expense entry auto',

								'customer_name' => '',

								'amount' => $expence['value'],

								'paid_by' => 'c',

								'cheque_tras_no' => 'Expense entry auto',

								'created_by' => date("Y-m-d H:i:sa"),

								'bank_name' => $expence["reason"],

								'expence_id' => $insertid

							);

							

							$insert = $this->Service_model_15->master_insert("sh_onlinetransaction", $data);

							//echo $this->db->last_Query(); die();

							}

                    }

                    echo $this->json_data("1", "Expense add successfully", "");

                } else {

                    echo $this->json_data("0", "Something is wrong please try again.", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    function refreshtoken() {

        $new_device_id = $this->input->get_post('new_device_id');

        $old_device_id = $this->input->get_post('old_device_id');

        $device_type = $this->input->get_post('device_type');

        $user_id = $this->input->get_post('user_id');

        $type = $this->input->get_post('type');

        if ($new_device_id != '' && $user_id != '') {

            $this->Service_model_15->update("sh_users_device", array("user_id" => $user_id, "device_id" => $old_device_id, "device_type" => $device_type), array("status" => '0'));

            $this->Service_model_15->master_insert("sh_users_device", array("user_id" => $user_id, "device_id" => $new_device_id, "device_type" => $device_type,'datetime'=>date('Y-m-d H:i:s'),'type'=>$type));

            echo $this->json_data("1", "Token Update succesfully.", "");

        } else {

            echo $this->json_data("0", "All Parameter are Required!", "");

        }

    }



    function logout() {

        $device_id = $this->input->get_post('device_id');

        $device_type = $this->input->get_post('device_type');

        $user_id = $this->input->get_post('user_id');

        $type = $this->input->get_post('type');

        if ($device_id != '' && $user_id != '') {

            $this->Service_model_15->update("sh_users_device", array("user_id" => $user_id, "device_id" => $device_id, "device_type" => $device_type, "type" => $type), array("status" => '0'));



            echo $this->json_data("1", "Logout Successfully!", "");

        } else {

            echo $this->json_data("0", "All Parameter are Required!", "");

        }

        $this->output($output);

    }



    function android_notification1($divice_id, $message, $type, $id) {

        $this->load->library('PushServer');

        $pushServer = new PushServer();

        $test = $pushServer->pushToGoogle($divice_id, 'Pal Oil App', $message, $type, $id);

        return $test;

    }



    function android_notification($divice_id, $message, $type, $id) {

        $this->load->library('PushServer');

        $pushServer = new PushServer();

        $test = $pushServer->pushToGoogle($divice_id, 'Pal Oil App', $message, $type, $id);

    }



    function testnotfy() {

        $devicelist = $this->Service_model_15->master_fun_get_tbl_val("sh_users_device", array("user_id" => '1', "status" => 1), array("id", "asc"));

        $slidt = array();

        foreach ($devicelist as $d) {



            if ($d['device_type'] == 'android') {

                array_push($slidt, $d['device_id']);

            }

        }

        $test = $this->android_notification($slidt, "Overshit in Petrol", "", "");

        $test1 = $this->android_notification($slidt, "Overshit in Diesel", "", "");

    }



    function testnotfy_test($divice_id) {

        $slidt = array($divice_id);

        $test = $this->android_notification1($slidt, "Overshit in Petrol", "", "");

        echo "<pre>";

        print_r($test);

    }



    public function petty_cash_member_list() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $wallet_list = $this->Service_model_15->master_fun_get_tbl_val("petty_cash_member", array("location_id" => $list[0]['l_id'], "status" => 1,"show"=>1), array("name", "asc"));

                if ($wallet_list) {

                    echo str_replace('\"', '"', $this->json_data("1", "", $wallet_list));

                } else {

                    echo $this->json_data("0", "Data Not Available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }

     public function saving_member_member_list() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $wallet_list = $this->Service_model_15->master_fun_get_tbl_val("saving_member", array("location_id" => $list[0]['l_id'], "status" => 1), array("name", "asc"));

                if ($wallet_list) {

                    echo str_replace('\"', '"', $this->json_data("1", "", $wallet_list));

                } else {

                    echo $this->json_data("0", "Data Not Available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function petty_cash_transaction() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $memberid = $this->input->get_post('memberid');

        $remark = $this->input->get_post('remark');

        $type = $this->input->get_post('type');

        $amount = $this->input->get_post('amount');



        $paymenttype = $this->input->get_post('paymenttype');

        $count_status = $this->input->get_post('count_status');

        $chequenumber = $this->input->get_post('chequenumber');

        $bank_name = $this->input->get_post('bank_name');

        if ($token != "" && $date != "" && $memberid != "" && $type != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['l_id'];

                $data = array(

                    'member_id' => $memberid,

                    'date' => $date,

                    'type' => $type,

                    'remark' => $remark,

                    'amount' => $amount,

                    'created_at' => date("Y-m-d H:i:sa"),

                    'transaction_type' => $paymenttype,

                    'count_status' => $count_status,

                    'transaction_no' => $chequenumber,

                    'bank_name' => $bank_name,

                    'location_id' => $id

                );

                $insert = $this->Service_model_15->master_insert("petty_cash_transaction", $data);

                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }

    public function saving_member_transaction() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $memberid = $this->input->get_post('memberid');

        $remark = $this->input->get_post('remark');

        $amount = $this->input->get_post('amount');

        if ($token != "" && $date != "" && $memberid != "" ) {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['l_id'];

                $data = array(

                    'member_id' => $memberid,

                    'date' => $date,

                    'remark' => $remark,

                    'amount' => $amount,

                    'created_at' => date("Y-m-d H:i:sa"),

                    'location_id' => $id

                );

                $insert = $this->Service_model_15->master_insert("saving_member_transaction", $data);

                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    function set_stock($date, $lid) {

        $date = date('Y-m-d', strtotime('-1 day', strtotime($date)));

        //$date = $date;

        $date2 = '2018-12-01';

        if (strtotime($date) < strtotime($date2)) {

            return 1;

        } else {

            $this->load->model('daily_reports_model');

            $list = $this->daily_reports_model->get_all_order('shdailyreadingdetails', array('status' => '1', 'location_id' => $lid, 'date >=' => $date), array('date', 'asc'));

            $p_original_stock = $list[0]->p_opening_original_stock;

            $d_original_stock = $list[0]->d_opening_original_stock;

			$xpp_original_stock = $list[0]->xpp_opening_original_stock;

            $xpd_original_stock = $list[0]->xpd_opening_original_stock;

            $cnt = 0;

            foreach ($list as $detail) {

                //echo "<br><br>";

                //echo $detail->date."<br>";

                //echo $p_original_stock."<br>";

                //echo $d_original_stock."<br>";



                if ($cnt != 0) {

                    $this->daily_reports_model->update_data('shdailyreadingdetails', array('id' => $detail->id), array("p_opening_original_stock" => $p_original_stock));

                    $this->daily_reports_model->update_data('shdailyreadingdetails', array('id' => $detail->id), array("d_opening_original_stock" => $d_original_stock));

					$this->daily_reports_model->update_data('shdailyreadingdetails', array('id' => $detail->id), array("xpp_opening_original_stock" => $xpp_original_stock));

                    $this->daily_reports_model->update_data('shdailyreadingdetails', array('id' => $detail->id), array("xpd_opening_original_stock" => $xpd_original_stock));

                }

                $Petrol_inventory = $this->daily_reports_model->get_one_data('sh_inventory', array('location_id' => $lid, 'date' => $detail->date, 'fuel_type' => 'p', 'status != ' => '0'));

                $Dieasl_inventory = $this->daily_reports_model->get_one_data('sh_inventory', array('location_id' => $lid, 'date' => $detail->date, 'fuel_type' => 'd', 'status != ' => '0'));

                $XPPetrol_inventory = $this->daily_reports_model->get_one_data('sh_inventory', array('location_id' => $lid, 'date' => $detail->date, 'fuel_type' => 'xpp', 'status != ' => '0'));

                $XPDieasl_inventory = $this->daily_reports_model->get_one_data('sh_inventory', array('location_id' => $lid, 'date' => $detail->date, 'fuel_type' => 'xpd', 'status != ' => '0'));

                //echo $p_original_stock ."+". $Petrol_inventory->p_quantity ."-". $detail->p_total_selling."-".$pshort."<br>";

                //echo $d_original_stock ."+". $Dieasl_inventory->d_quantity ."-". $detail->d_total_selling."-".$dshort."<br>"; 

                $pshort = round(($detail->p_total_selling * 0.75) / 100, 2);

                $dshort = round(($detail->d_total_selling * 0.20) / 100, 2);

				$xppshort = round(($xpdetail->p_total_selling * 0.75) / 100, 2);

                $xpdshort = round(($xpdetail->d_total_selling * 0.20) / 100, 2);

                $p_original_stock = $p_original_stock + $Petrol_inventory->p_quantity - $detail->p_total_selling - $pshort;

                $d_original_stock = $d_original_stock + $Dieasl_inventory->d_quantity - $detail->d_total_selling - $dshort;

				$xpp_original_stock = $xpp_original_stock + $XPPetrol_inventory->p_quantity - $xpdetail->p_total_selling - $xppshort;

                $xpd_original_stock = $xpd_original_stock + $XPDieasl_inventory->d_quantity - $xpdetail->d_total_selling - $xpdshort;



                //echo $p_original_stock."<br>";

                //echo $d_original_stock."<br>";

                $this->daily_reports_model->update_data('shdailyreadingdetails', array('id' => $detail->id), array("p_closing_original_stock" => $p_original_stock, "d_closing_original_stock" => $d_original_stock, 'dshort' => $dshort, 'pshort' => $pshort,"xpp_closing_original_stock" => $xpp_original_stock, "xpd_closing_original_stock" => $xpd_original_stock, 'xpdshort' => $dshort, 'xppshort' => $xppshort));

                //echo $this->db->last_query()."<br>";

                $cnt++;

            }

        }

    }



    public function petty_cash_member_list_company() {

        $token = $this->input->get_post('token');

        $location = $this->input->get_post('location');

        if ($token != "" & $location != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $wallet_list = $this->Service_model_15->master_fun_get_tbl_val("petty_cash_member", array("location_id" => $location, "status" => 1), array("name", "asc"));

                if ($wallet_list) {

                    echo str_replace('\"', '"', $this->json_data("1", "", $wallet_list));

                } else {

                    echo $this->json_data("0", "Data Not Available", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    function petty_reportlist() {

        $token = $this->input->get_post('token');

        $lid = $this->input->get_post('location');

        $sdate = $this->input->get_post('sdate');

        $edate = $this->input->get_post('edate');

        $member_id = $this->input->get_post('member_id');

        if ($token != "" && $lid != "" && $sdate != "" && $edate != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {

                $this->load->model('Petty_cash_member_model');

                $current_date = date('Y-m-d');

                $customercedit_list = $this->Petty_cash_member_model->get_tasection_list_Credit($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);

                $customerdebit_list = $this->Petty_cash_member_model->get_tasection_list_Debit($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);

                $date2 = "";

                $fianlarray = array();

                foreach ($customercedit_list as $cedit) {

                    $fianlarray[$cedit->date]['date'] = $cedit->date;

                    $fianlarray[$cedit->date]['amount'] = $cedit->amount;

                    $fianlarray[$cedit->date]['name'] = $cedit->name;

                    $fianlarray[$cedit->date]['id'] = $cedit->id;

                    $fianlarray[$cedit->date]['remark'] = $cedit->remark;

                    $fianlarray[$cedit->date]['d_amount'] = "";

                }

                foreach ($customerdebit_list as $cedit) {

                    $fianlarray[$cedit->date]['date'] = $cedit->date;

                    $fianlarray[$cedit->date]['name'] = $cedit->name;

                    $fianlarray[$cedit->date]['id'] = $cedit->id;

                    $fianlarray[$cedit->date]['remark'] = $cedit->remark;

                    $fianlarray[$cedit->date]['d_amount'] = $cedit->amount;

                    if (isset($fianlarray[$cedit->date]['amount'])) {

                        

                    } else {

                        $fianlarray[$cedit->date]['amount'] = "";

                    }

                }

                $fianl = array();

                foreach ($fianlarray as $detail) {



                    array_push($fianl, $detail);

                }

                if ($fianl) {

                    echo $this->json_data("1", "", $fianl);

                } else {

                    echo $this->json_data("0", "Transaction Not Available.", "");

                }

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    public function oil_pump_data() {

        $token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        if ($token != "" && $date != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['l_id'];

                $shpump = $this->Service_model_15->master_fun_get_tbl_val_new_new("shpump", array("location_id" => $id, "status" => 1, "type" => 'O'), array("order", "asc"));

				//echo $this->db->last_query();

				foreach($shpump as $p){

					$p->p_qty = $p->new_p_qty;

				}

                $location_id = $list[0]['l_id'];

                $oildata = $this->Service_model_15->inventory_detail_for_add($location_id, $date, "o");

//echo $this->db->last_Query();

                $salesdata = $this->Service_model_15->sels_detail_for_add($location_id, $date);

                $temparra = (object) array("o_stock" => "0.00", "d_stock" => "0.00", "p_stock" => "0.00", "p_price" => "61.09", "d_price" => "65.23", "d_quantity" => "0.00", "p_quantity" => "0.00");



                if ($oildata) {

                    

                } else {

                    $oildata = $temparra;

                }

                if ($salesdata) {

                    

                } else {

                    $salesdata = (object) array("oil_reading" => "0.00", "p_tank_reading" => "0.00", "d_tank_reading" => "0.00");

                }

                $finalarray = array(

                    'oil' => array($oildata),

                    'selling' => array($salesdata)

                );

                $data['inventory_detail'] = $finalarray;

                $data['pump_detail'] = $shpump;

                echo $this->json_data("1", "", array($data));

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    function petty_cash_report_view() {

        $token = $this->input->get_post('token');

        $lid = $this->input->get('lid');

        $date = $this->input->get('date');

        $member_id = $this->input->get('member_id');

        if ($token != "" && $lid != "" && $date != "") {

            $this->load->model('Petty_cash_member_model');

            $data['cedit_list'] = $this->Petty_cash_member_model->get_tasection_list_credit_date($lid, date("Y-m-d", strtotime($date)), $member_id);

            $data['debit_list'] = $this->Petty_cash_member_model->get_tasection_list_debit_date($lid, date("Y-m-d", strtotime($date)), $member_id);

            echo $this->json_data("1", "", array($data));

        } else {

            echo $this->json_data("0", "Parameter not passed", "");

        }

    }



    function vishal_test() {



        $devicelist = $this->Service_model_15->master_fun_get_tbl_val("sh_users_device", array("user_id" => '25', "status" => 1), array("id", "asc"));

        $slidt = array();

        foreach ($devicelist as $d) {



            if ($d['device_type'] == 'android') {

                array_push($slidt, $d['device_id']);

            }

        }

        print_r($slidt);



        $this->android_notification($slidt, "Overshot in Petrol", "", "");

    }



public function addnewdatainoil($lid,$date){

	$lists = $this->Service_model_15->master_fun_get_tbl_val("sh_add_oil", array("status" => 1), array("id", "id"));

	foreach($lists as $list){

		$date = $list['date'];

		$cdate = date('Y-m-d');

		for($i = $date; strtotime($date) <= strtotime($cdate);$date = date('Y-m-d', strtotime('+1 day', strtotime($date)))){

		

		$currentstock = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_daily_price", array("o_p_id"=>$list['oil_id'],"date"=>$date,"status" => 1), array("id", "id"));

		if($currentstock){

			$this->Service_model_15->update("sh_oil_daily_price", array("id" => $currentstock[0]['id']), array("stock" => $currentstock[0]['stock']+$list['qty']));

			$this->Service_model_15->update("sh_add_oil", array("id" => $list['id']), array("status" => 0));

		}

		}

	}

}





    public function oil_inventory() {

        // add  oil inventory

        $token = $this->input->get_post('token');

        $oil_inventory = $this->input->get_post('oil_data');

        $date = $this->input->get_post('date');

        $invoice_no = $this->input->get_post('invoice_no');

        $oil_cgst = $this->input->get_post('oil_cgst');

        $oil_sgst = $this->input->get_post('oil_sgst');

        $oil_amount = $this->input->get_post('oil_amount');

        $benefits = $this->input->get_post('benefits');

        $charges = $this->input->get_post('charges');

        $nett_total = $this->input->get_post('nett_total');

        $o_quantity = $this->input->get_post('o_quantity');

        $oil_type = $this->input->get_post('oil_type');

        $prev_o_stock = $this->input->get_post('prev_o_stock');

        $o_stock = $this->input->get_post('o_stock');

        $oil_cgst_percent = $this->input->get_post('oil_cgst_percent');

        $oil_sgst_percent = $this->input->get_post('oil_sgst_percent');



        // print_r($_POST);

        if ($token != "" && $oil_inventory != "" && $date != "" && $invoice_no != "" && $oil_cgst != "" && $oil_sgst != "" && $oil_amount != "" && $nett_total != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $fuel_type = 'o';

                if ($fuel_type == 'o') {

                    $checkentry = $this->Service_model_15->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                    if ($checkentry) {

                        echo $this->json_data("0", "Sorry you already added detail.", "");

                        die();

                    }

                }

                if ($fuel_type == 'o') {

                    $newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                    $oildata = $this->Service_model_15->inventory_detail_for_add($list['0']['l_id'], $newdate, "o");



                    if ($oildata) {

                        $nett_total = $nett_total + $oildata->oil_total_amount;

                        $salesdata = $this->Service_model_15->sels_detail_for_add($list['0']['l_id'], $newdate);



                        if ($salesdata) {

                            $nett_total = $nett_total - $salesdata->oil_reading;

                        }

                    }

                    $tankdata = $data;

                }

                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];





                $o_m_data = array(

                    'user_id' => $id,

                    "date" => $date,

                    "invoice_no" => $invoice_no,

                    "location_id" => $location_id,

                    "oil_cgst" => $oil_cgst,

                    "oil_sgst" => $oil_sgst,

                    "oil_amount" => $oil_amount,

                    "benefits" => $benefits,

                    "charges" => $charges,

                    "nett_total" => $nett_total,

					"oil_sgst_percent" => $oil_sgst_percent,

					"oil_cgst_percent" => $oil_cgst_percent

					);



                $insert = $this->Service_model_15->master_insert("sh_oil_inventory_data_master", $o_m_data);

                $oil_array = json_decode($oil_inventory);

                $data = array(

                    'user_id' => $id,

                    'date' => $date,

                    'location_id' => $location_id,

                    'fuel_type' => 'o',

                    'o_type' => $oil_type,

                    'o_quantity' => $o_quantity,

                    'o_amount' => $oil_amount,

                    'oil_cgst' => $oil_cgst,

                    'oil_sgst' => $oil_sgst,

                    'o_stock' => $o_stock,

                    'oil_total_amount' => $nett_total,

                    'prev_o_stock' => $prev_o_stock,

                    'created_date' => date("Y-m-d H:i:s"),

					"oil_sgst_percent" => $oil_sgst_percent,

					"oil_cgst_percent" => $oil_cgst_percent

                );

                $insert1 = $this->Service_model_15->master_insert("sh_inventory", $data);

                foreach ($oil_array as $oil_data) {



                    $o_data = array("p_id" => $oil_data->oil_id,

                        "o_m_id" => $insert,

                        "date" => $date,

                        "location_id" => $location_id,

                        "buyprice" => ($oil_data->cgst+$oil_data->sgst+$oil_data->nettTotal)/$oil_data->qty,

                        "qty" => $oil_data->qty,

                        "net_total" => $oil_data->nettTotal,

							"cgst"=>$oil_data->cgst,

							"sgst"=>$oil_data->sgst,

							"nettTotal"=>$oil_data->nettTotal,

							"newprice"=> $oil_data->buy_price,

							"oil_sgst_percent" => $oil_sgst_percent,

					"oil_cgst_percent" => $oil_cgst_percent

                    );

                    $this->Service_model_15->master_insert("sh_oil_inventory_data", $o_data);

					$o_data = array("oil_id" => $oil_data->oil_id,

                        "date" => $date,

                        "location_id" => $location_id,

                        "qty" => $oil_data->qty,

                        "buy_price" =>$oil_data->buy_price,

						"oil_sgst_percent" => $oil_sgst_percent,

					"oil_cgst_percent" => $oil_cgst_percent

                    );

                    $this->Service_model_15->master_insert("sh_add_oil", $o_data);

                    $data1 = array(

                        "inv_id" => $insert1,

                        "oil_id" => $oil_data->oil_id,

                        "qty" => $oil_data->qty,

                        "ltr" => $oil_data->ltr,

                        "created_at" => date("Y-m-d H:i:s"),

						"oil_sgst_percent" => $oil_sgst_percent,

					"oil_cgst_percent" => $oil_cgst_percent

					);

                    $o_insert_id = $this->Service_model_15->master_insert("sh_oil_inventory", $data1);



                    $pdata = $this->Service_model_15->master_fun_get_tbl_val("shpump", array("id" => $oil_data->oil_id, "status" => 1), array("id", "id"));



                    $p_stock = $pdata[0]['stock'];

                    $qty = floatval($oil_data->qty);

                    $t_stock = $p_stock + $qty;

                    $history_data = array('inventory_id' => $o_insert_id,

                        'p_reading' => $p_stock,

                        'n_reading' => $qty,

                        'type' => "add",

                        'f_reading' => $t_stock,

						"oil_sgst_percent" => $oil_sgst_percent,

					"oil_cgst_percent" => $oil_cgst_percent

					);

                    $this->Service_model_15->master_insert("sh_oil_inventory_history", $history_data);

                    $this->Service_model_15->update("shpump", array("id" => $oil_data->oil_id), array("spacket_value" => $oil_data->buyprice, "stock" => $t_stock));

                }

                $shpumpdata = $this->Service_model_15->master_fun_get_tbl_val("shpump", array("location_id" => $location_id, "status" => 1, "type" => 'o'), array("id", "asc"));

                foreach ($shpumpdata as $p) {

                    $pumpdata = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_inventory_data", array("p_id" => $p['id']), array("id", "asc"));

                    if (empty($pumpdata)) {

                        $o_data = array("p_id" => $p['id'],

                            "o_m_id" => $insert,

                            "buyprice" => $p["spacket_value"],

                            "qty" => 0,

                            "net_total" => 0,

                            "date" => $date,

                            "location_id" => $location_id,

							"oil_sgst_percent" => $oil_sgst_percent,

					"oil_cgst_percent" => $oil_cgst_percent

                        );

                        $this->Service_model_15->master_insert("sh_oil_inventory_data", $o_data);

                    }

                }

                echo $this->json_data("1", "Your Data submitted successfully", "");

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not passed", "");

        }

    }



    public function oil_pumb_daily_price($date, $qty, $location_id) {

        $list = $this->Service_model_15->master_fun_get_tbl_val("shpump", array("status" => 1, "id" => $pump_id), array("id", "id"));

        //  print_r($list);

        // $history_data = array();

        foreach ($list as $l) {

            if ($l['packet_value'] == "") {

                $l['packet_value'] = 0;

            }

            if ($l['spacket_value'] == "") {

                $l['spacket_value'] = 0;

            }

            $list2 = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_daily_price", array("o_p_id" => $l['id'], "date" => $date), array("id", "id"));

            if (empty($list2)) {

                $data = array("date" => $date,

                    "o_p_id" => $l['id'],

                    "bay_price" => $l['spacket_value'],

                    "sel_price" => $l['packet_value'],

                    "stock" => $l['stock'],

                    "packet_type" => $l['p_type']);



                //print_r($data);

                $this->Service_model_15->master_insert("sh_oil_daily_price", $data);

            }

        }

        //  echo $this->json_data("1", "Your Data submitted successfully", "");

        // 

    }

/*

    public function test_data() {

        $token = $this->input->get_post('token');

        $location_id = $this->input->get_post('location_id');

        $date = $this->input->get_post('date');

        $insertid = $this->input->get_post('reading_id');

        $time = date('Y-m-d H:i:s');

        $id = "74";

        $pdata = $this->Service_model_15->master_fun_get_tbl_val("shpump", array("location_id" => $location_id, "status" => 1, "type" => "o"), array("id", "id"));



        foreach ($pdata as $p) {

            $pump_id = $p['id'];

            $reading = $p['stock'];

            $parice = array();

            if ($pump_id != "") {

                $parice = $this->Service_model_15->master_fun_get_tbl_val("shreadinghistory", array("date" => $date, "status" => 1, "PumpId" => $pump_id), array("id", "asc"));

                echo "<pre>";

                echo $this->db->last_query();

            }

            if (empty($parice)) {

                $data1 = array(

                    "UserId" => $id,

                    "RDRId" => $insertid,

                    "Type" => "o",

                    "date" => $date,

                    "PumpId" => $pump_id,

                    "Reading" => 0,

                    "created_at" => $time,

                    "qty" => 0);

                $o_insert_id = $this->Service_model_15->master_insert("shreadinghistory", $data1);

            }

            if ($pump_id != "") {

                $parice2 = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_daily_price", array("date" => $date, "o_p_id" => $pump_id), array("id", "asc"));

            }

            if (empty($parice2)) {

                $data = array("date" => $date,

                    "o_p_id" => $pump_id,

                    "bay_price" => $p['spacket_value'],

                    "sel_price" => $p['packet_value'],

                    "location_id" => $p['location_id'],

                    "stock" => $p['stock'],

                    "packet_type" => $p['p_type']);

                $o_insert_id = $this->Service_model_15->master_insert("sh_oil_daily_price", $data);

            }

        }

    } */

	function add_company_credit_debit_master(){

		$token = $this->input->get_post('token');

        $date = $this->input->get_post('date');

        $data = $this->input->get_post('data');

        $type = $this->input->get_post('type');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

                $id = $list[0]['id'];

                $location_id = $list[0]['l_id'];

                date_default_timezone_set('Asia/Kolkata');

				$pamoutnew = json_decode($data, TRUE);

				foreach($pamoutnew as $newdata){

					$insData = array('date'=>$date,'user_id'=>$id,'location_id'=>$location_id,'amount'=>$newdata['amount'],'type'=>$type,'remark'=>$newdata['remark'],'doc_no'=>$newdata['transactioNo']);

					$this->Service_model_15->master_insert("sh_company_credit_debit", $insData);

				}

				echo $this->json_data("1", "Your Data submitted successfully", "");

			}else{

				echo $this->json_data("3", "Token expired. Please login again.", "");

			}

		}else{

			echo $this->json_data("0", "Parameter Not passed", "");

		}

	}

	

	function daily_maintenance_cat(){

		$token = $this->input->get_post('token');

		if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

				$location_id = $list[0]['l_id'];

				$maintenance_cat = $this->Service_model_15->master_fun_get_tbl_val("sh_company_daily_maintain", array("location_id" => $location_id, "status" => 1), array("id", "id"));

				echo $this->json_data("1", "", $maintenance_cat);

			}else{

				echo $this->json_data("3", "Token expired. Please login again.", "");

			}

		}else{

			echo $this->json_data("0", "Parameter Not passed", "");

		}

	}

	

	function daily_maintenance_submit(){

		$token = $this->input->get_post('token');

		$data = $this->input->get_post('data');

		$date = $this->input->get_post('date');

		if ($token != "" && $date != "" && $data != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

				$location_id = $list[0]['l_id'];

				$id = $list[0]['id'];

				$report_submit = $this->Service_model_15->master_fun_get_tbl_val("daily_maintain_submit", array("date" => $date, "status" => 1, "location_id" => $location_id), array("id", "id"));

				if($report_submit){

					echo $this->json_data("0", "Report already submitted.", "");

				}else{

					$submited_data = json_decode($data, TRUE);

					foreach($submited_data as $detail){

						$insrtdata = array("date"=>$date,"location_id"=>$location_id,"maintain_id"=>$detail['id'],"report"=>$detail['report'],"remark"=>$detail['remark'],"user_id"=>$id,"created_at"=>date("Y-m-d H:i:s"));

						$Squadli_info = $this->Service_model_15->master_insert("daily_maintain_submit", $insrtdata);

					}

					echo $this->json_data("1", "Report submitted successfully", "");

				}

			}else{

				echo $this->json_data("3", "Token expired. Please login again.", "");

			}

		}else{

			echo $this->json_data("0", "Parameter Not passed", "");

		}

	}

	

	/*

	

	function allworker(){

		$lists = $this->Service_model_15->master_fun_get_tbl_val("sh_workers", array("status" => 1,"show"=>'1','active'=>'1'), array("id", "id"));

		//echo $this->db->last_Query(); die();

		foreach($lists as $list){

			

			$salary = $this->Service_model_15->master_fun_get_tbl_val("sh_workers_monthly_salary", , array("id", "id"));

			if($salary){

				//$update = $this->Service_model_15->master_fun_updateid("sh_workers", $list['id'],array('salary'=>$salary[0]['salary']));

				// echo $this->db->last_Query()."<br>";

			 }else{

				$this->Service_model_15->master_insert("sh_workers_monthly_salary", array("month" => date('m'),'year'=>date('Y'),'workers_id'=>$list['id'],'salary'=>$list['salary']));

			echo "dfhgf"; 

			 }

		}

	}*/

	

	function setoildatat(){

		die();

		$data = '[{"Reading":"24198.86","fuelType":"p","id":"255","name":"PUMP 1  B1","prevReading":"24193.86","qty":"5.00","total":"0.0","txtBoxValue":"24198.86","value":"24193.86","viewType":1},{"Reading":"41353.54","fuelType":"p","id":"253","name":"PUMP 1 A1","prevReading":"40921.64","qty":"431.90","total":"0.0","txtBoxValue":"41353.54","value":"40921.64","viewType":1},{"Reading":"2323.42","fuelType":"p","id":"254","name":"PUMP 1 A2","prevReading":"2318.42","qty":"5.00","total":"0.0","txtBoxValue":"2323.42","value":"2318.42","viewType":1},{"Reading":"1770.22","fuelType":"p","id":"256","name":"PUMP 1 B2","prevReading":"1765.22","qty":"5.00","total":"0.0","txtBoxValue":"1770.22","value":"1765.22","viewType":1},{"Reading":"24030.90","fuelType":"p","id":"364","name":"PUMP 2    B1","prevReading":"23469.88","qty":"561.02","total":"0.0","txtBoxValue":"24030.90","value":"23469.88","viewType":1},{"Reading":"31517.18","fuelType":"p","id":"365","name":"PUMP 2 A1","prevReading":"31018.79","qty":"498.39","total":"0.0","txtBoxValue":"31517.18","value":"31018.79","viewType":1},{"Reading":"16949.34","fuelType":"p","id":"370","name":"PUMP 3    B1","prevReading":"16165.79","qty":"783.55","total":"0.0","txtBoxValue":"16949.34","value":"16165.79","viewType":1},{"Reading":"7425.93","fuelType":"p","id":"368","name":"PUMP 3 A1","prevReading":"6992.32","qty":"433.61","total":"0.0","txtBoxValue":"7425.93","value":"6992.32","viewType":1},{"Reading":"56467.62","fuelType":"d","id":"367","name":"PUMP 2 A2","prevReading":"55629.92","qty":"837.70","total":"0.0","txtBoxValue":"56467.62","value":"55629.92","viewType":1},{"Reading":"43816.76","fuelType":"d","id":"366","name":"PUMP 2 B2","prevReading":"43240.56","qty":"576.20","total":"0.0","txtBoxValue":"43816.76","value":"43240.56","viewType":1},{"Reading":"8770.10","fuelType":"d","id":"371","name":"PUMP 3    B2","prevReading":"8770.10","qty":"0.00","total":"0.0","txtBoxValue":"8770.10","value":"8770.10","viewType":1},{"Reading":"14126.42","fuelType":"d","id":"369","name":"PUMP 3 A2","prevReading":"13833.41","qty":"293.01","total":"0.0","txtBoxValue":"14126.42","value":"13833.41","viewType":1},{"Reading":"00","fuelType":"d","id":"372","name":"PUMP 4      1","prevReading":"00","qty":"0.00","total":"0.0","txtBoxValue":"00","value":"00","viewType":1},{"Reading":"00","fuelType":"d","id":"373","name":"PUMP 4 2","prevReading":"00","qty":"0.00","total":"0.0","txtBoxValue":"00","value":"00","viewType":1}]';

		$date = '2020-01-15';

		$id = '87';

		$insertid = '1445';

		$time = '2020-01-16 11:01:26';

		$location_id = '60';

		

		$pamoutnew = json_decode($data, TRUE);

		//echo print_r($pamoutnew); die();

		if ($pamoutnew != "") {

                        $newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                        foreach ($pamoutnew as $row) {

                            $fuelType = $row['fuelType'];

                            if ($fuelType == 'o') {

                                $pump_id = $row['id'];

                                $fuelType = $row['fuelType'];

                                $reading = $row['value'];

                                $data1 = array(

                                    "UserId" => $id,

                                    "RDRId" => $insertid,

                                    "Type" => $fuelType,

                                    "date" => $date,

                                    "PumpId" => $pump_id,

                                    "Reading" => $reading,

                                    "created_at" => $time,

                                    "qty" => $row['qty']);

                                $o_insert_id = $this->Service_model_15->master_insert("shreadinghistory", $data1);

                                

                                $pdata = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_daily_price", array("o_p_id" => $pump_id, "status" => 1,'date'=>$newdate), array("id", "id"));

								if($pdata){

									$pdata[0]['spacket_value'] = $pdata[0]['bay_price'];

									$pdata[0]['packet_value'] = $pdata[0]['sel_price'];

									$pdata[0]['location_id'] = $pdata[0]['location_id'];

									$pdata[0]['p_type'] = $pdata[0]['packet_type'];

									$pdata[0]['stock'] = $pdata[0]['stock'];

								}else{

									$pdata = $this->Service_model_15->master_fun_get_tbl_val("shpump", array("id" => $pump_id, "status" => 1), array("id", "id"));

								}

                                $p_stock = $pdata[0]['stock'];



                                $qty = floatval($reading);



                                $t_stock = $p_stock - $qty;

                                $this->Service_model_15->update("shpump", array("id" => $pump_id), array("stock" => $t_stock));

                                //$this->oil_pumb_daily_price($date, $qty, $location_id);

                                $data = array("date" => $date,

                                    "o_p_id" => $pump_id,

                                    "bay_price" => $pdata[0]['spacket_value'],

                                    "sel_price" => $pdata[0]['packet_value'],

                                    "location_id" => $pdata[0]['location_id'],

                                    "stock" => $t_stock,

                                    "packet_type" => $pdata[0]['p_type']);

                                $this->Service_model_15->master_insert("sh_oil_daily_price", $data);

                                $history_data = array('inventory_id' => $o_insert_id,

                                    'p_reading' => $p_stock,

                                    'n_reading' => $qty,

                                    'type' => "Update(-)",

                                    'f_reading' => $t_stock);

                                $this->Service_model_15->master_insert("sh_oil_inventory_history", $history_data);

                            }

                        }

                        $pdata = $this->Service_model_15->master_fun_get_tbl_val("shpump", array("location_id" => $location_id, "status" => 1, "type" => "o"), array("id", "id"));

                        foreach ($pdata as $p) {

                            $pump_id = $p['id'];

                            $reading = $p['stock'];

                            $parice = array();

                            if ($pump_id != "") {

                                $parice = $this->Service_model_15->master_fun_get_tbl_val("shreadinghistory", array("date" => $date, "status" => 1, "PumpId" => $pump_id), array("id", "asc"));

                            }

                            if (empty($parice)) {

                                $data1 = array(

                                    "UserId" => $id,

                                    "RDRId" => $insertid,

                                    "Type" => "o",

                                    "date" => $date,

                                    "PumpId" => $pump_id,

                                    "Reading" => 0,

                                    "created_at" => $time,

                                    "qty" => $reading);

                                $o_insert_id = $this->Service_model_15->master_insert("shreadinghistory", $data1);

                            }

                            if ($pump_id != "") {

                                $parice2 = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_daily_price", array("date" => $date, "o_p_id" => $pump_id), array("id", "asc"));

                            }

                            if (empty($parice2)) {

								$newpad = $this->Service_model_15->master_fun_get_tbl_val("sh_oil_daily_price", array("o_p_id" => $pump_id, "status" => 1,'date'=>$newdate), array("id", "id"));

								if($newpad){

                                $data = array("date" => $date,

                                    "o_p_id" => $pump_id,

                                    "bay_price" => $newpad[0]['bay_price'],

                                    "sel_price" => $newpad[0]['sel_price'],

                                    "location_id" => $newpad[0]['location_id'],

                                    "stock" => $newpad[0]['stock'],

                                    "packet_type" => $newpad[0]['packet_type']

									);

								}else{

									$data = array("date" => $date,

                                    "o_p_id" => $pump_id,

                                    "bay_price" => $p['spacket_value'],

                                    "sel_price" => $p['packet_value'],

                                    "location_id" => $p['location_id'],

                                    "stock" => $p['stock'],

                                    "packet_type" => $p['p_type']

									);

								}

                                $o_insert_id = $this->Service_model_15->master_insert("sh_oil_daily_price", $data);

                            }

                        }

                        if ($insertid) {

                            echo $this->json_data("1", "Reading add successfully ");

                            $this->set_stock($date, $location_id);

                            $this->addoil($location_id, $date);

                        } else {

                            echo $this->json_data("0", "Some thing is Wrong Please try again", "");

                        }

                    }

		

	}

	public function tank_nozzle() {

        $token = $this->input->get_post('token');

        if ($token != "") {

            $list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "asc"));

            if ($list) {

                $companyid = $list[0]['company_id'];

                $location = $list[0]['l_id'];

				$petrol = $this->Service_model_15->get_pump_list('P', $location);

                    $diesel = $this->Service_model_15->get_pump_list('D', $location);

                    

                    $petrolwithreading = array();

                    foreach ($petrol as $plist) {

                        $get_preding = $this->Service_model_15->master_fun_get_tbl_val("shreadinghistory", array("PumpId" => $plist['id'], "date" => $newdate, "status" => 1), array("id", "asc"));

                        if ($get_preding) {

                            $get_reset = $this->Service_model_15->master_fun_get_tbl_val("sh_reset_pump", array("pump_id" => $plist['id'], "date" => $date, "status" => 1), array("id", "asc"));

                            if ($get_reset) {

                                $plist['Reading'] = "00";

                            } else {

                                $plist['Reading'] = $get_preding[0]['Reading'];

                            }

                        } else {

                            $plist['Reading'] = "00";

                        }

                        $petrolwithreading[] = $plist;

                    }

                    $dieselwithreading = array();

                    foreach ($diesel as $plist) {

                        $get_preding = $this->Service_model_15->master_fun_get_tbl_val("shreadinghistory", array("PumpId" => $plist['id'], "date" => $newdate, "status" => 1), array("id", "asc"));

                        if ($get_preding) {

                            $get_reset = $this->Service_model_15->master_fun_get_tbl_val("sh_reset_pump", array("pump_id" => $plist['id'], "date" => $date, "status" => 1), array("id", "asc"));

                            if ($get_reset) {

                                $plist['Reading'] = "00";

                            } else {

                                $plist['Reading'] = $get_preding[0]['Reading'];

                            }

                        } else {

                            $plist['Reading'] = "00";

                        }

                        $dieselwithreading[] = $plist;

                    }

                    $meter_reading['petrol'] = $petrolwithreading;

                    $meter_reading['diesel'] = $dieselwithreading;

                    /*$tank = $this->Service_model_15->master_fun_get_tbl_val_with_order('sh_tank_list', array('status' => '1', 'location_id' => $location), array('tank_name', 'asc'));*/

					$tank = $this->Service_model_15->master_fun_get_tbl_val_with_order('sh_tank_list', array('status' => '1', 'location_id' => $location), array('tank_name', 'asc'));

					$tank_list = array();

					foreach($tank as $tliat){

						if($tliat->mobile_show == '0'){}else{

							$tank_list[] = $tliat;

						}

					}

                    $data[0]['meter_reading'] = $meter_reading;

                    $data[0]['tanks'] = $tank_list;

                    echo $this->json_data("1", "", $data);

                

            } else {

                echo $this->json_data("3", "Token expired. Please login again.", "");

            }

        } else {

            echo $this->json_data("0", "Parameter Not Passed", "");

        }

    }

	public function add_tank_entry(){

		$token = $this->input->get_post('token');

		$date = $this->input->get_post('date');

		$liter = $this->input->get_post('liter');

		$meterjson = $this->input->get_post('meterjson');

		$user_post_data = $meterjson;

		if($token != "" && $date !="" && $liter != "" && $meterjson !="" ){

			$list = $this->Service_model_15->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1, "Active" => 1), array("id", "id"));

            if ($list) {

				$location_id = $list[0]['l_id'];

				$insertArray = array("date"=>$date,

				"location_id"=>$location_id,

				"user_id"=>$list[0]['id'],

				"buying_liter"=>$liter,

				"created_date_time"=>date('Y-m-d H:i:s'),

				"alldata"=>$user_post_data);

				$insert = $this->Service_model_15->master_insert("tank_inventory", $insertArray);

				if($insert){

					$meterarray = json_decode($meterjson, TRUE);

					foreach($meterarray as $meter){

						

						if($meter['type'] == 'tank'){

						$tankInserArray = array("tank_inventory_id"=>$insert,

						"tank_id"=>$meter['id'],

						"name"=>$meter['meterName'],

						"fuel_type"=>$meter['fuelType'],

						"befor_deep"=>$meter['beforeReading'],

						"befor_liter"=>$meter['beforeDeepReading'],

						"after_deep"=>$meter['afterReading'],

						"after_liter"=>$meter['afterDeepReading'],

						"buying_liter"=>$liter,

						"created_by"=>$list[0]['id'],

						"created_date_time"=>date('Y-m-d H:i:s'));

						$this->Service_model_15->master_insert("tank_inventory_list", $tankInserArray);



						}

						

						if($meter['type'] == 'meter'){

						$tankInserArray = array("tank_inventory_id"=>$insert,

						"meter_id"=>$meter['id'],

						"name"=>$meter['meterName'],

						"fuel_type"=>$meter['fuelType'],

						"befor_meter"=>$meter['beforeReading'],

						"after_meter"=>$meter['afterReading'],

						"selling"=>$meter['sales'],

						"created_by"=>$list[0]['id'],

						"created_date_time"=>date('Y-m-d H:i:s'));

						

						

						$this->Service_model_15->master_insert("tank_inventory_meter", $tankInserArray);

						

						}

					} 

					echo $this->json_data("1", "Thank you for submit", array());

				}else{

					echo $this->json_data("0", "Something is wrong", array());

				}

			}else{

				echo $this->json_data("3", "Token expired. Please login again.", "");

			}

		}else{

			echo $this->json_data("0", "Parameter Not Passed", "");

		}

	}

	public function add_tank_report(){

		$l_id = $this->input->get_post('l_id');

		$sdate = $this->input->get_post('sdate');

		$edate = $this->input->get_post('edate');

		if($l_id != "" && $sdate != "" && $edate != ""){

			$inventoryList = $this->Service_model_15->tankInventoryList($l_id,$sdate,$edate);

			if(count($inventoryList) > 0){

				foreach($inventoryList as $list){

					$list->tankdetail = $this->Service_model_15->tankInventorydetail($list->id);

					$list->meterdetail = $this->Service_model_15->meterInventorydetail($list->id);

				}

				echo $this->json_data("1", "report list", $inventoryList);

			}else{

				echo $this->json_data("0", "tankor inventory not available", "");

			}

		}else{

			echo $this->json_data("0", "Parameter Not Passed", "");

		}

	}

}



?>