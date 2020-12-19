<?php

class Service8 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('service_model_8');
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
        $Squadli_info = $this->service_model_8->master_insert("alldata", $user_track_data);
        //return true;
    }

    public function index() {
        echo "Mobile Squadlilicaton";
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
            $row = $this->service_model_8->master_num_rows("customer_master", array("email" => $email, "status" => 1));
            if ($row == 0) {
                $email = strtolower($email);
                $insert = $this->service_model_8->master_fun_insert("customer_master", array("name" => $name, "type" => $type, "email" => $email, "password" => $password, "mobile" => $mobile, "active" => '0'));
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
        $update = $this->service_model_8->master_fun_update_1("customer_master", $id, $data1);
        echo "thank you your account has been successfully verified";
    }

    public function verify1($id) {
        $data1 = array("active" => '1');
        $update = $this->service_model_8->master_fun_update("customer_master", $id, $data1);
    }

    public function login() {
        $email = $this->input->get_post('email');
        $password = $this->input->get_post('password');
        if ($email != NULL && $password != NULL) {
            $result = $this->login_model->checkloginuser($email, $password);
            if ($result != "") {
                $data = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("UserEmail" => $email, "UserPassword" => $password, "status" => 1), array("id", "asc"));
                $uniqueId = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);
                $data1 = array("token" => $uniqueId);
                $Active = $data[0]['Active'];
                $id = $data[0]['id'];
                $update = $this->service_model_8->master_fun_updateid("shusermaster", $id, $data1);
                if ($Active == '1') {
                    $row = $this->service_model_8->master_num_rows("shusermaster", array("id" => $data[0]['id'], "status" => 1));
                    $membercount = $this->service_model_8->master_num_rows("shusermaster", array("id" => $data[0]['id'], "status" => 1));
                    $data[0]['team_count'] = "$row";
                    $list = array();
                    $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("id" => $data[0]['id'], "status" => 1), array("id", "id"));
                    $user_team = array();
                    $user_team = $this->service_model_8->select_all("shusermaster", $id);
                    $petrol = $this->service_model_8->get_pump_list('P', $data[0]['l_id']);
                    $diesel = $this->service_model_8->get_pump_list('D', $data[0]['l_id']);
                    $oil = $this->service_model_8->get_pump_list_oil('O', $data[0]['l_id']);
                    $expensein = $this->service_model_8->expensein_type_list();
                    $fina_Array = array();
                    foreach ($expensein as $expenseindetail) {
                        $expenseindetail['expensein_detail'] = $this->service_model_8->selectbyidarray('sh_expensein_types', $data[0]['company_id'], 'comapny_id');
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
                    $data[0]['gst'] = 9;
                    $data[0]['oil_benift'] = 5;
                    $data[0]['type'] = 'employee';
                    $data2 = $this->service_model_8->master_fun_get_tbl_val_service("shusermaster", array("UserEmail" => $email, "UserPassword" => $password, "status" => 1), array("id", "asc"));
                    echo $this->json_data("1", "", array($data[0]));
                } else {
                    echo $this->json_data("0", "Please Verify Your Email Address", "");
                }
            } else {
                $result = $this->login_model->checklogincompany($email, $password);

                if ($result != "") {
                    $data = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("email" => $email, "password" => $password, "status" => 1), array("id", "asc"));
                    $uniqueId = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);
                    $data1 = array("token" => $uniqueId);
                    $Active = $data[0]['active'];
                    $id = $data[0]['id'];
                    $update = $this->service_model_8->master_fun_updateid("sh_com_registration", $id, $data1);
                    if ($Active == '1') {
                        $row = $this->service_model_8->master_num_rows("sh_com_registration", array("id" => $data[0]['id'], "status" => 1));
                        $membercount = $this->service_model_8->master_num_rows("sh_com_registration", array("id" => $data[0]['id'], "status" => 1));
                        $data[0]['team_count'] = "$row";
                        $list = array();
                        $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("id" => $data[0]['id'], "status" => 1), array("id", "id"));
                        // $user_team = array();
                        // $user_team = $this->service_model_8->select_all("shusermaster",$id);
                        $petrol = $this->service_model_8->get_pump_list('P', '');
                        $diesel = $this->service_model_8->get_pump_list('D', '');
                        $oil = $this->service_model_8->oil_type_list();
                        $expensein = $this->service_model_8->expensein_type_list();
                        $fina_Array = array();
                        foreach ($expensein as $expenseindetail) {
                            $expenseindetail['expensein_detail'] = $this->service_model_8->selectbyidarray('sh_expensein_types', $expenseindetail['id'], 'exps_id');
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
                        $data[0]['gst'] = 9;
                        $data[0]['oil_benift'] = 5;
                        $data[0]['type'] = 'company';

                        $data2 = $this->service_model_8->master_fun_get_tbl_val_service_1("sh_com_registration", array("email" => $email, "password" => $password, "status" => 1), array("id", "asc"));
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
        $data = $this->service_model_8->get_active_record_Pump();
        echo $this->json_data("1", "", $data);
    }

    ///////////////////////vishal 11-4 start
    public function all_list() {
        $token = $this->input->get_post('token');
        $login_type = $this->input->get_post('login_type');
        $location = "";
        $company = "";
        if ($token != "") {
            $tokendata = $this->service_model_8->master_fun_get_tbl_val_3("shusermaster", array("token" => $token, "status" => 1), array("id", "asc"));

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



        $petrol = $this->service_model_8->get_pump_list('P', $location);
        //$data['petrol'] = $petrol;
        $diesel = $this->service_model_8->get_pump_list('D', $location);
        //$data['diesel'] = $diesel;
        //$oil = $this->service_model_8->oil_type_list();
        $oil = $this->service_model_8->get_pump_list_oil('O', $location);
		
        $expensein = $this->service_model_8->expensein_type_list();
        $fina_Array = array();
        foreach ($expensein as $expenseindetail) {

            $expenseindetail['expensein_detail'] = $this->service_model_8->selectbyidarray('sh_expensein_types', $company, 'comapny_id');

            array_push($fina_Array, $expenseindetail);
        }
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
        $data['gst'] = 9;
        $data['oil_benift'] = 5;
        $data['vesion_code'] = $finalarray = array("vesion_code" => "27", "flag" => "TRUE");
        echo $this->json_data("1", "", array($data));
    }

    ///////////////////////vishal 11-4 end
    public function forget_password() {
        $this->load->library('email');
        $email = $this->input->get_post('email');
        if ($email != NULL) {

            $row = $this->service_model_8->master_fun_get_tbl_val_1("shusermaster", array("UserEmail" => $email, "status" => 1), array("id", "asc"));
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
                $insert = $this->service_model_8->master_fun_update_UserEmail1('shusermaster', $email, $data1);
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

        $result = $this->service_model_8->get_terms($id);
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
            $data = $this->service_model_8->view_profile($token);
            echo $this->json_data("1", "", $data);
        } else {

            echo $this->json_data("0", "Parameter not passed", "");
        }
    }

    public function employee_detail() {
        $token = $this->input->get_post('token');
        if ($token != "") {
            $data = $this->service_model_8->master_fun_get_tbl_val_3("shusermaster", array("token" => $token, "status" => 1), array("id", "asc"));
            if ($data) {
                $data = $this->service_model_8->employee_detail("shusermaster", array("status" => 1), array("id", "asc"));
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            //print_r($list);
            if ($list) {
                $user = $this->service_model_8->userlist_active_record($token);

                if ($user) {

                    $email2 = $user[0]['UserEmail'];

                    if ($email2 == $email) {

                        //print_r("<pre>"); print_r($user); die();
                        $data = array(
                            "UserFName" => $name,
                            "UserEmail" => $email,
                            "UserMNumber" => $mobile,
                        );

                        $update = $this->service_model_8->master_fun_update("shusermaster", $token, $data);
                        if ($update) {
                            echo $this->json_data("1", "Your Profile has been Updated", "");
                        }
                    } else {
                        $row = $this->service_model_8->master_num_rows("shusermaster", array("UserEmail" => $email, "status" => 1));
                        if ($row == 0) {
                            $data = array(
                                "UserFName" => $name,
                                "UserEmail" => $email,
                                "UserMNumber" => $mobile,
                            );

                            $update = $this->service_model_8->master_fun_update("shusermaster", $token, $data);
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

        $inventoryoil = $this->service_model_8->get_inventory_detail('O', $location_id, $date);
        if ($inventoryoil) {
            
        } else {

            $newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
            $oildata = $this->service_model_8->inventory_detail_for_add($location_id, $newdate, "o");

            if ($oildata) {
                $oil_total_amount = $oil_total_amount + $oildata->oil_total_amount;
                $salesdata = $this->service_model_8->sels_detail_for_add($location_id, $newdate);
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
            $this->service_model_8->master_insert("sh_inventory", $data);
        }
    }

    public function add_details() {
        $token = $this->input->get_post('token');
        $date = $this->input->get_post('date');
        $oil_reading = $this->input->get_post('oil_reading');
        $p_tank_reading = $this->input->get_post('p_tank_reading');
        $d_tank_reading = $this->input->get_post('d_tank_reading');
        $p_deep_reading = $this->input->get_post('p_deep_reading');
        $d_deep_reading = $this->input->get_post('d_deep_reading');
        $p_total_selling = $this->input->get_post('p_total_selling');
        $d_total_selling = $this->input->get_post('d_total_selling');
        $p_selling_price = $this->input->get_post('p_selling_price');
        $d_selling_price = $this->input->get_post('d_selling_price');
        $p_sales_vat = $this->input->get_post('p_sales_vat');
        $d_sales_vat = $this->input->get_post('d_sales_vat');
        $d_testing = $this->input->get_post('d_testing');
        $p_testing = $this->input->get_post('p_testing');
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $id = $list[0]['id'];
                $shift = $list[0]['shift'];
                $location_id = $list[0]['l_id'];

                $checkdata = $this->service_model_8->master_fun_get_tbl_val("shdailyreadingdetails", array("UserId" => $id, "location_id" => $location_id, "date" => $date, "status" => 1), array("id", "asc"));
                if ($checkdata) {
                    echo $this->json_data("0", "Sorry you already data added.", "");
                } else {

					$checkdata = $this->service_model_8->master_fun_get_tbl_val("shdailyreadingdetails", array("location_id" => $location_id,"status" => 1), array("id", "asc"));
					if($checkdata){
						$nddeate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
						$temp_prev = $this->service_model_8->master_fun_get_tbl_val("shdailyreadingdetails", array("location_id" => $location_id,"date" => $nddeate, "status" => 1), array("id", "asc"));
						if(!$temp_prev){
							echo $this->json_data("0", "Sorry, Please Add Previous Sales of : ".date('d-m-Y',strtotime($nddeate)), "");
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
                        "p_sales_vat" => $p_sales_vat,
                        "d_sales_vat" => $d_sales_vat,
                        "oil_pure_benefit" => $oil_pure_benefit,
                        "all_data" => $datap,
                        "p_testing" => $p_testing,
                        "d_testing" => $d_testing,
                        "created_at" => date("Y-m-d"),
                        "cash_on_hand" => $cash_on_hand
                    );

                    $insertid = $this->service_model_8->master_insert("shdailyreadingdetails", $data1);
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
                        $this->service_model_8->master_insert("sh_tank_wies_reading_sales", $data1);
                    }
                    if ($pamoutnew != "") {
                        foreach ($pamoutnew as $row) {
                            $fuelType = $row['fuelType'];
                            if ($fuelType == 'p' || $fuelType == 'd') {
                                $pump_id = $row['id'];
                                $fuelType = $row['fuelType'];
                                $reading = $row['Reading'];
                                $data1 = array(
                                    "UserId" => $id,
                                    "RDRId" => $insertid,
                                    "Type" => $fuelType,
                                    "date" => $date,
                                    "PumpId" => $pump_id,
                                    "Reading" => $reading,
                                    "created_at" => $time,
                                    "qty" => $row['qty']);
									$this->service_model_8->master_insert("shreadinghistory", $data1);
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
                                $this->service_model_8->master_insert("shreadinghistory", $data1);
                            }
                        }
                        if ($insertid) {
                            echo $this->json_data("1", "Reading add successfully", "");
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
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

                $insertid = $this->service_model_8->master_insert("sh_expensein_details", $data1);

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
                // $insert = $this->service_model_8->master_insert("sh_expensein_d_history",$data);
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
        $this->load->model('service_model_8');
        $token = $this->input->get_post('token');
        $date = $this->input->get_post('date');
        $pet_price = $this->input->get_post('pet_price');
        $dis_price = $this->input->get_post('dis_price');

        if ($token != "" && $date != "" && $pet_price != "" && $dis_price != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {

                $id = $list[0]['l_id'];
                $checkdata = $this->service_model_8->master_fun_get_tbl_val("sh_dailyprice", array("user_id" => $id, "date" => $date, "status" => 1), array("id", "asc"));

                if ($checkdata) {
                    echo $this->json_data("0", "Sorry you already added price.", "");
                } else {
                    $data = array(
                        'user_id' => $id,
                        'date' => $date,
                        'pet_price' => $pet_price,
                        'dis_price' => $dis_price,
                        'created_date' => date("Y-m-d H:i:sa")
                    );
                    $insert = $this->service_model_8->master_insert("sh_dailyprice", $data);
                    echo $this->json_data("1", "Your Data submitted successfully", "");
                }
            } else {
                echo $this->json_data("3", "Token expired. Please login again.", "");
            }
        } else {
            echo $this->json_data("0", "Parameter Not passed", "");
        }
    }

    public function add_inventory() {
        $this->load->model('service_model_8');
        //coman 
        $token = $this->input->get_post('token');
        $date = $this->input->get_post('date');
        $invoice_no = $this->input->get_post('invoice_no');
        $paymenttype = $this->input->get_post('paymenttype');
        $chequenumber = $this->input->get_post('chequenumber');
        $paidamount = $this->input->get_post('paidamount');
        $fuel_type = $this->input->get_post('fuel_type');
        $bank_name = $this->input->get_post('bank_name');
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
        if ($token != "" && $date != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $checkentry = $this->service_model_8->master_fun_get_tbl_val("sh_inventory", array("date" => $date, "fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));

                if ($checkentry) {
                    echo $this->json_data("0", "Sorry you already added detail.", "");
					die();
                } else {
					$tempcheck_prev = $this->service_model_8->master_fun_get_tbl_val("sh_inventory", array("fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id']), array("id", "asc"));
					
					if($tempcheck_prev){
						$nddeate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
						$temp_prev = $this->service_model_8->master_fun_get_tbl_val("sh_inventory", array("date" =>$nddeate,"fuel_type" => $fuel_type, "status" => 1, "location_id" => $list['0']['l_id'],"date"=>$nddeate), array("id", "asc"));
						if(!$temp_prev){
							echo $this->json_data("0", "Sorry, Please Add Previous Inventory of : ".date('d-m-Y',strtotime($nddeate)), "");
							die();
						}
						$temp_prev = $this->service_model_8->master_fun_get_tbl_val("shdailyreadingdetails", array("date" =>$nddeate, "status" => 1, "location_id" => $list['0']['l_id'],"date"=>$nddeate), array("id", "asc"));
						if(!$temp_prev){
							echo $this->json_data("0", "Sorry, Please Add Previous Sales of : ".date('d-m-Y',strtotime($nddeate)), "");
							die();
						}
					}
                    if ($fuel_type == 'o') {
                        $newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                        $oildata = $this->service_model_8->inventory_detail_for_add($list['0']['l_id'], $newdate, "o");

                        if ($oildata) {
                            $oil_total_amount = $oil_total_amount + $oildata->oil_total_amount;
                            $salesdata = $this->service_model_8->sels_detail_for_add($list['0']['l_id'], $newdate);

                            if ($salesdata) {
                                $oil_total_amount = $oil_total_amount - $salesdata->oil_reading;
                            }
                        }
						$tankdata = $data;
                    }

                    $id = $list[0]['id'];
                    $location_id = $list[0]['l_id'];
                    $data = array(
                        'user_id' => $id,
                        'date' => $date,
                        'location_id' => $location_id,
                        'invoice_no' => $invoice_no,
                        'paymenttype' => $paymenttype,
                        'chequenumber' => $chequenumber,
                        'paidamount' => $paidamount,
                        'fuel_type' => $fuel_type,
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
                        'o_type' => $oil_type,
                        'o_quantity' => $o_quantity,
                        'o_amount' => $oil_amount,
                        'oil_cgst' => $oil_cgst,
                        'oil_sgst' => $oil_sgst,
                        'o_stock' => $o_stock,
                        'oil_total_amount' => $oil_total_amount,
                        'bank_name' => $bank_name,
                        'prev_o_stock' => $prev_o_stock,
                        "p_new_price" => $p_new_price,
                        "d_new_price" => $d_new_price,
                        "d_total_amount" => $d_total_amount,
                        "p_total_amount" => $p_total_amount,
                        'created_date' => date("Y-m-d H:i:s"),
                        'deep_reading' => $deep_reading,
						'tankdata' => $tankdata
                    );

                    $insert = $this->service_model_8->master_insert("sh_inventory", $data);
					
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
                        $this->service_model_8->master_insert("sh_tank_wies_reading", $data1);
                    }
                    foreach ($pamoutnew as $row) {
                        $data1 = array(
                            "inv_id" => $insert,
                            "oil_id" => $row['oil_id'],
                            "qty" => $row['qty'],
                            "ltr" => $row['ltr'],
                            "created_at" => date("Y-m-d H:i:s"));
                        $this->service_model_8->master_insert("sh_oil_inventory", $data1);
                    }

                    if ($insert) {
                        echo $this->json_data("1", "Your Data submitted successfully", "");
                    } else {
                        echo $this->json_data("0", "Some thing is Wrong Please try again", "");
                    }
                }
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
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
                $insert = $this->service_model_8->master_insert("shdailyreadingdetails", $data);
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
                        $insert = $this->service_model_8->master_insert("shreadinghistory", $data1);
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

            $data2 = $this->service_model_8->master_fun_get_tbl_val_3("shusermaster", array("token" => $token, "status" => 1), array("id", "asc"));
            if ($data2) {

                $row = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "asc"));
                $oldpass = $row[0]['UserPassword'];
                if ($oldpassword == $oldpass) {
                    $data = array(
                        "UserPassword" => $password,
                    );
                    $update = $this->service_model_8->master_fun_update("shusermaster", $token, $data);
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
            $update = $this->service_model_8->device_update("customer_master", $device_id, array("device_id" => "", "device_type" => ""));
            $update = $this->service_model_8->master_fun_update("customer_master", $user_id, array("device_id" => $device_id, "device_type" => $type));

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
        $data["stripe"] = $this->service_model_8->master_fun_get_tbl_val("stripe", array("id" => '1'), array("id", "asc"));
        $data["stripe_package"] = $this->service_model_8->master_fun_get_tbl_val("stripe_package", array("id" => $pid), array("id", "asc"));

        if ($id != NULL) {
            $data['user_id'] = $id;
            $this->load->view('index', $data);
        } else {
            echo "usernot available";
        }
    }

    public function indexpackage($id) {
        $packa_select = $this->service_model_8->user_select_pack($id);
        if ($packa_select) {
            $data['package_id'] = $packa_select->package_id;
        } else {
            $data['package_id'] = "";
        }
        //$data["stripe"] = $this->service_model_8->master_fun_get_tbl_val("stripe_packege", array("startus" => '1'), array("id", "asc"));
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
            $this->service_model_8->drop_tbl('admin_master');
            $this->service_model_8->drop_tbl('alldata');
            $this->service_model_8->drop_tbl('award_master');
            $this->service_model_8->drop_tbl('customer_master');
            $this->service_model_8->drop_tbl('emotion_award_master');
            $this->service_model_8->drop_tbl('emotion_master');

            $this->service_model_8->drop_tbl('help_master');
            $this->service_model_8->drop_tbl('menu_master');
            $this->service_model_8->drop_tbl('objective_master');
            $this->service_model_8->drop_tbl('objective_rank_master');
            $this->service_model_8->drop_tbl('payment');
            $this->service_model_8->drop_tbl('referral_team');

            $this->service_model_8->drop_tbl('stripe');
            $this->service_model_8->drop_tbl('stripe_package');
            $this->service_model_8->drop_tbl('team_master');
            $this->service_model_8->drop_tbl('team_member_master');
            $this->service_model_8->drop_tbl('user_permission');
            $this->service_model_8->drop_tbl('user_type_master');
        }
    }

    public function only_db() {
        echo "<a href='" . base_url() . "Service/database_backup'>click Here</a>";
    }

    // get user data from userlist table
    public function user_list() {
        $token = $this->input->get_post('token');
        if ($token != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $data = $this->service_model_8->get_user_list($list[0]['company_id'], $list[0]['l_id']);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
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
                $insert = $this->service_model_8->master_insert("sh_bankdeposit", $data);

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
                // $insert = $this->service_model_8->master_insert("sh_credit_debit",$data);
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
                // $insert = $this->service_model_8->master_insert("sh_bankdeposit",$data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
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
                $insert = $this->service_model_8->master_insert("sh_bankdeposit", $data);

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
                            'bank_name' => $row['bank_name']
                        );
                        $this->service_model_8->master_insert("sh_credit_debit", $data);
                        if ($row['paymentType'] != 'cs') {
                            $amount = $amount + $row['amount'];
                        }
                    }
                    $this->service_model_8->master_fun_updateid("sh_bankdeposit", $insert, array('amount' => $amount));
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));

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
                        $insert = $this->service_model_8->master_insert("sh_credit_debit", $data);

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
                    $insert = $this->service_model_8->master_insert("sh_credit_debit", $data);
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
            $row = $this->service_model_8->master_num_rows("sh_com_registration", array("email" => $email, "status" => 1));
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
                $insert = $this->service_model_8->master_insert("sh_com_registration", $data);
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
            $data = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("email" => $email, "password" => $password, "status" => 1), array("id", "asc"));


            if ($result != "") {
                $id = $data[0]['id'];

                $uniqueId = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);
                $data1 = array("token" => $uniqueId);
                $update = $this->service_model_8->master_fun_updateid("sh_com_registration", $id, $data1);

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $user = $this->service_model_8->companylist_active_record($token);
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

                        $update = $this->service_model_8->master_fun_update("sh_com_registration", $token, $data);
                        echo $this->json_data("1", "Your Profile has been Updated", "");
                    } else {
                        $row = $this->service_model_8->master_num_rows("sh_com_registration", array("email" => $email, "status" => 1));
                        if ($row == 0) {
                            date_default_timezone_set('Asia/Kolkata');
                            $data = array(
                                "name" => $name,
                                "email" => $email,
                                "mobile" => $mobile,
                                "updated_by" => date("Y-m-d H:i:sa")
                            );

                            $update = $this->service_model_8->master_fun_update("sh_com_registration", $token, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {
                $data = $this->service_model_8->master_fun_get_tbl_val_company_location("sh_location", array("company_id" => $company_id, "status" => 1), array("l_name", "asc"));
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {
                if ($location_id) {
                    $condition = array("shpump.company_id" => $company_id, "shpump.location_id" => $location_id, "shpump.status" => 1, "shpump.type!=" => 'O');
                } else {
                    $condition = array("shpump.company_id" => $company_id, "shpump.status" => 1, "shpump.type !=" => 'O');
                }
                $data = $this->service_model_8->master_fun_get_tbl_val_company_pump("shpump", $condition, array("shpump.name", "asc"));

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {
                $data = $this->service_model_8->master_fun_get_tbl_val_company_employee("shusermaster", array("shusermaster.company_id" => $company_id, "shusermaster.status" => 1, "shusermaster.location_id"), array("id", "asc"), $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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
                $insert = $this->service_model_8->master_insert("sh_location", $data);
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

            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $email1 = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("UserEmail" => $email, "status" => 1), array("id", "id"));

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
                    $insert = $this->service_model_8->master_insert("shusermaster", $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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
                $insert = $this->service_model_8->master_insert("shpump", $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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


                $this->service_model_8->master_fun_update_location("sh_location", $location_id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $olist = $this->service_model_8->get_oil_pckg_list($list[0]['id'], $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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
                $oil_package_insert_id = $this->service_model_8->add_oil_pckg($data);

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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
                $response = $this->service_model_8->update_oil_pckg($pkg_id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $data = array(
                    'delete_at' => date("Y-m-d H:i:s"),
                    'status' => '0'
                );
                $response = $this->service_model_8->update_oil_pckg($pkg_id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $email1 = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("UserEmail " => $email, "id !=" => $id, "status" => 1), array("id", "id"));

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
                    $this->service_model_8->master_fun_update_employee("shusermaster", $id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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
                $this->service_model_8->master_fun_update_employee("shpump", $id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];

                date_default_timezone_set('Asia/Kolkata');
                $data = array();

                $data = array(
                    'status' => 0
                );
                $this->service_model_8->master_fun_update_location("sh_location", $location_id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];

                date_default_timezone_set('Asia/Kolkata');
                $data = array();

                $data = array(
                    'status' => 0
                );
                $this->service_model_8->master_fun_update_employee("shusermaster", $id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];

                date_default_timezone_set('Asia/Kolkata');
                $data = array();

                $data = array(
                    'status' => 0
                );
                $this->service_model_8->master_fun_update_employee("shpump", $id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {

                //$data = $this->service_model_8->master_fun_get_tbl_val_company_inventory_1($user_id, $date_to, $date_from, $current_date, $list[0]['id'], $location_id);
                $this->load->model('daily_reports_model');
                $data = $this->daily_reports_model->report($location_id, $date_from, $date_to);
                //echo$this->db->last_query();
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];
                $data = $this->service_model_8->master_fun_get_tbl_val_company_dailyprice($date_to, $date_from, $current_date, $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {
                $data = $this->service_model_8->master_fun_get_tbl_val_company_reading($date_from, $date_to, $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $user = $this->service_model_8->companylist_active_record($token);
                if ($user) {
                    $email2 = $user[0]['email'];
                    if ($email2 == $email) {
                        $data = array(
                            "name" => $name,
                            "email" => $email,
                            "mobile" => $mobile,
                        );
                        $update = $this->service_model_8->master_fun_update("sh_com_registration", $token, $data);
                        if ($update) {
                            echo $this->json_data("1", "Your Profile has been Updated", "");
                        }
                    } else {
                        $row = $this->service_model_8->master_num_rows("sh_com_registration", array("email" => $email, "status" => 1));
                        if ($row == 0) {
                            $data = array(
                                "name" => $name,
                                "email" => $email,
                                "mobile" => $mobile,
                            );

                            $update = $this->service_model_8->master_fun_update("sh_com_registration", $token, $data);
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

            $data2 = $this->service_model_8->master_fun_get_tbl_val_company("sh_com_registration", array("token" => $token, "status" => 1), array("id", "asc"));
            if ($data2) {

                $row = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "asc"));
                $oldpass = $row[0]['password'];
                if ($oldpassword == $oldpass) {
                    $data = array(
                        "password" => $password,
                    );
                    $update = $this->service_model_8->master_fun_update("sh_com_registration", $token, $data);
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

            $row = $this->service_model_8->master_fun_get_tbl_val_1("sh_com_registration", array("email" => $email, "status" => 1), array("id", "asc"));
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
                $insert = $this->service_model_8->master_fun_update_companyEmail('sh_com_registration', $email, $data1);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];
                $company_id = $list[0]['id'];
                $data = $this->service_model_8->compcustliast($location_id);
                //echo $this->db->last_query();
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['company_id'];
                $data = $this->service_model_8->master_fun_get_tbl_val_company_customer("sh_userdetail", array("sh_userdetail.company_id" => $company_id, "sh_userdetail.status" => 1), array("id", "asc"));
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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
                $insert = $this->service_model_8->master_insert("sh_userdetail", $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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
                $this->service_model_8->master_fun_update_customer("sh_userdetail", $id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];

                date_default_timezone_set('Asia/Kolkata');
                $data = array();

                $data = array(
                    'status' => 0
                );
                $this->service_model_8->master_fun_update_customer("sh_userdetail", $id, $data);
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

            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {
                $data = $this->service_model_8->expence_date($location_id, $date_to, $date_from);
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

            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {
                $data = $this->service_model_8->expense_details($location_id, $date);
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

        if ($token != "") {

            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
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
                    'bank_name' => $bank_name
                );
                $insert = $this->service_model_8->master_insert("sh_onlinetransaction", $data);
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

            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {

                $data = $this->service_model_8->master_fun_get_tbl_val_expense_detail($company_id, $ex_id);

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {

                $data = $this->service_model_8->master_fun_get_tbl_val_company_bankdeposit($date_to, $date_from, $current_date, $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {

                $data = $this->service_model_8->master_fun_get_tbl_val_company_onlinetrans($user_id, $date_to, $date_from, $current_date, $company_id, $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {

                $data = $this->service_model_8->master_fun_get_tbl_val_company_credit_debit($user_id, $date_to, $date_from, $current_date, $company_id, $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            //$company_id = $list[0]['id'];
            if ($list) {

                $data = $this->service_model_8->master_fun_get_tbl_val_company_credit_debit($user_id, $date_to, $date_from, $current_date, $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];

                $data = $this->service_model_8->company_user_detail($company_id);

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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
                $insert = $this->service_model_8->master_insert("sh_workers", $data);

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
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
                $this->service_model_8->master_fun_update_customer("sh_workers", $id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];

                $data = array(
                    'status' => 0
                );
                $this->service_model_8->master_fun_update_customer("sh_workers", $id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {
                $data = $this->service_model_8->company_worker_list($company_id, $location_id);

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];

                $data = array(
                    'company_id' => $company_id,
                    'name' => $name,
                    'location_id' => $location_id,
                    'created_at' => date("Y-m-d H:i:sa"),
                );
                $insert = $this->service_model_8->master_insert("sh_creditors", $data);

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];
                $data = array(
                    'name' => $name,
                    'location_id' => $location_id,
                    'created_at' => date("Y-m-d H:i:sa"),
                );
                $this->service_model_8->master_fun_update_customer("sh_creditors", $id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];

                $data = array(
                    'status' => 0
                );
                $this->service_model_8->master_fun_update_customer("sh_creditors", $id, $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {

                $data = $this->service_model_8->company_creditors_list($company_id, $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['company_id'];
            $location_id = $list[0]['l_id'];
            if ($list) {
                $data = $this->service_model_8->company_creditors_list($company_id, $location_id);

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
        if ($token != "" && $worker_id != "" && $amount != "" && $date != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $companyid = $list[0]['company_id'];
                $location = $list[0]['l_id'];
                $data = array(
                    'worker_id' => $worker_id,
                    'amount' => $amount,
                    'date' => $date,
                    'remark' => $remark,
                    'created_at' => date("Y-m-d H:i:sa"),
                    'extra_amount' => $extra_amount,
                    'loan_amount' => $loanamount,
                    'bonas_amount' => $bonas_amount,
                    'paid_loan_amount' => $cutfromtheloan
                );
                $insert = $this->service_model_8->master_insert("sh_workers_salary", $data);

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
                // $insert = $this->service_model_8->master_insert("sh_personal_loan",$data);
                // if($loanamount > 0){
                // $data = array("worker_id"=>$worker_id,"user_id"=>$list[0]['id'],"location_id"=>$location,"loan_amount"=>$loanamount,'remark'=>$remark,'date'=>$date);
                // $insert = $this->service_model_8->master_insert("sh_personal_loan",$data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $month = date("m", date(strtotime($date)));
                $year = date("Y", date(strtotime($date)));
                $data = $this->service_model_8->worker_salary_remening($worker_id, $month, $year);
                $loandetail = $this->service_model_8->get_worker_loan_detail($worker_id, $date);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));

            $location_id = $list[0]['l_id'];
            if ($list) {
                $data = $this->service_model_8->emp_worker_list($location_id);
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
        $list = $this->service_model_8->get_tankreading('20kl');
        echo $this->json_data("1", "", $list);
    }

    public function tank_dep_reding_new() {
        $token = $this->input->get_post('token');
        if ($token != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            $location_id = $list[0]['l_id'];
            if ($list) {
                $tank_list = $this->service_model_8->master_fun_get_tbl_val_with_order("sh_tank_list", array("location_id" => $location_id, "status" => 1), array("tank_name", "asc"));

				$fianlarray = array();
				foreach($tank_list as $tank){
					$temp = array();
					$temp['id'] = $tank->id;
					$temp['name'] = $tank->tank_name;
					$temp['type'] = $tank->fuel_type;
					$temp['tank_chart'] = $this->service_model_8->master_fun_get_tbl_val_with_order("sh_tank_chart", array("tank_id" => $tank->id, "status" => 1), array("reading", "asc"));
					$fianlarray[] = $temp;
				}
                $data = $this->service_model_8->get_tankreading($location[0]['tank_type']);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "asc"));
            if ($list) {
                $companyid = $list[0]['l_id'];
                $data = $this->service_model_8->master_fun_get_tbl_val("sh_dailyprice", array("user_id" => $companyid, "date" => $date, "status" => 1), array("id", "asc"));
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $companyid = $list[0]['id'];
                $salesdetail = $this->service_model_8->master_fun_get_tbl_val_select("id,UserId,shift,location_id,oil_reading,p_tank_reading,d_tank_reading,p_deep_reading,d_deep_reading,p_total_selling,d_total_selling,p_sales_vat,d_sales_vat,oil_pure_benefit,p_selling_price,d_selling_price,p_testing,d_testing,cash_on_hand", "shdailyreadingdetails", array("location_id" => $location_id, "status" => 1, "date" => $date), array("id", "id"));
                $data['deatil'] = $salesdetail[0];
                //echo "<pre>"; print_r($data); 

                $data['meterreading'] = $this->service_model_8->master_fun_get_tbl_val("shreadinghistory", array("RDRId" => $salesdetail[0]['id'], "status" => "1", "date" => $date), array("id", "asc"));

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $companyid = $list[0]['id'];
                $data = $this->service_model_8->master_fun_get_tbl_val_meter_reading_data($date, $companyid, $location_id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "asc"));
            if ($list) {
                $companyid = $list[0]['company_id'];
                $location = $list[0]['l_id'];
                $data = $this->service_model_8->master_fun_get_tbl_val("sh_dailyprice", array("user_id" => $location, "date" => $date, "status" => 1), array("id", "asc"));

                if ($data) {

                    $inventorypetrol = $this->service_model_8->get_inventory_detail('P', $location, $date);
                    if ($inventorypetrol) {
                        $inventorydiesel = $this->service_model_8->get_inventory_detail('D', $location, $date);
                        if ($inventorydiesel) {
                            // $inventoryoil = $this->service_model_8->get_inventory_detail('O',$location,$date);
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


                    $petrol = $this->service_model_8->get_pump_list('P', $location);
                    $diesel = $this->service_model_8->get_pump_list('D', $location);
                    $oil = $this->service_model_8->get_pump_list_oil('O', $location);
                    $newdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                    $petrolwithreading = array();
                    foreach ($petrol as $plist) {
                        $get_preding = $this->service_model_8->master_fun_get_tbl_val("shreadinghistory", array("PumpId" => $plist['id'], "date" => $newdate, "status" => 1), array("id", "asc"));
                        if ($get_preding) {
                            $plist['Reading'] = $get_preding[0]['Reading'];
                        } else {
                            $plist['Reading'] = "00";
                        }
                        $petrolwithreading[] = $plist;
                    }
                    $dieselwithreading = array();
                    foreach ($diesel as $plist) {
                        $get_preding = $this->service_model_8->master_fun_get_tbl_val("shreadinghistory", array("PumpId" => $plist['id'], "date" => $newdate, "status" => 1), array("id", "asc"));
                        if ($get_preding) {
                            $plist['Reading'] = $get_preding[0]['Reading'];
                        } else {
                            $plist['Reading'] = "00";
                        }
                        $dieselwithreading[] = $plist;
                    }
                    $meter_reading['petrol'] = $petrolwithreading;
                    $meter_reading['diesel'] = $dieselwithreading;
					$tank = $this->service_model_8->master_fun_get_tbl_val_with_order('sh_tank_list',array('status'=>'1','location_id'=>$location),array('tank_name','asc'));
                    $data[0]['meter_reading'] = $meter_reading;
                    $data[0]['oil_type'] = $oil;
					$data[0]['tanks'] = $tank;
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $location_id = $list[0]['l_id'];
                $petroldata = $this->service_model_8->inventory_detail_for_add($location_id, $date, "p");
                $dieseldata = $this->service_model_8->inventory_detail_for_add($location_id, $date, "d");
                $oildata = $this->service_model_8->inventory_detail_for_add($location_id, $date, "o");
				$tank = $this->service_model_8->master_fun_get_tbl_val_with_order('sh_tank_list',array('status'=>'1','location_id'=>$location_id),array('tank_name','asc'));
				
//echo $this->db->last_Query();
                $salesdata = $this->service_model_8->sels_detail_for_add($location_id, $date);
                $temparra = (object) array("o_stock" => "0.00", "d_stock" => "0.00", "p_stock" => "0.00", "p_price" => "61.09", "d_price" => "65.23", "d_quantity" => "0.00", "p_quantity" => "0.00");
                if ($petroldata) {
                    
                } else {
                    $petroldata = $temparra;
                }
                if ($dieseldata) {
                    
                } else {
                    $dieseldata = $temparra;
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $companyid = $list[0]['company_id'];
                $location_id = $list[0]['l_id'];
                $totalsalary = $this->service_model_8->total_salary($companyid);
                $totalpaid = $this->service_model_8->total_paid_salary($companyid, date('m', strtotime($date)), date('Y', strtotime($date)));
                $totaldebit = $this->service_model_8->total_credit($location_id, date('m', strtotime($date)), date('Y', strtotime($date)), 'd');
                $TotalCredit = $this->service_model_8->total_credit($location_id, date('m', strtotime($date)), date('Y', strtotime($date)), 'c');
                $total_onlinetransaction = $this->service_model_8->total_onlinetransaction($location_id, date('m', strtotime($date)), date('Y', strtotime($date)));
                $total_bankdeposit = $this->service_model_8->total_bankdeposit($location_id, date('m', strtotime($date)), date('Y', strtotime($date)));
                $temptotal = $total_bankdeposit->deposit_amount + $total_bankdeposit->withdraw_amount;
                $data = array('totalsalary' => $totalsalary->totalsalary, "totalpaid" => $totalpaid->totalpaidsalary, "totaldebit" => $totaldebit->total, "TotalCredit" => $TotalCredit->total, 'total_onlinetransaction' => $total_onlinetransaction->total, "total_bankdeposit" => "" . $temptotal);
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
        if ($token != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
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
                    'ioc_amount' => $this->input->get_post('ioc_amount'),
                    'budget' => $this->input->get_post('budget'),
                        // 'salary' => $this->input->get_post('salary'),
                        // 'vat' => $this->input->get_post('vat'),
                        // 'pure_benefit'=> $this->input->get_post('pure_benefit'),
                        // 'mis_match'=>$this->input->get_post('mis_match') 
                );
                $insert = $this->service_model_8->master_insert("sh_last_day_entry", $data);
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
        $payment_type = $this->input->get_post('payment_type');
        $batch_no = $this->input->get_post('batch_no');
        $iocbatch_no = $this->input->get_post('iocbatch_no');
        $amount = $this->input->get_post('amount');
        $iocamount = $this->input->get_post('iocamount');
        $customer_id = $this->input->get_post('customer_id');
        $bill_no = $this->input->get_post('bill_no');
        $vehicle_no = $this->input->get_post('vehicle_no');
        $fuel_type = $this->input->get_post('fuel_type');
        $quantity = $this->input->get_post('quantity');
        $remark = $this->input->get_post('remark');
        $transaction_type = $this->input->get_post('transaction_type');
        $transaction_number = $this->input->get_post('transaction_number');
        $bank_name = $this->input->get_post('bank_name');
        // if($token != "" && $date != "" && $payment_type != "" && $bill_no != "" && $vehicle_no != "" && $fuel_type != "" && $amount != "" && $quantity != "" && $batch_no != "")
        if ($token != "" && $date != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));

            if ($list) {
                $id = $list[0]['id'];
                $location_id = $list[0]['l_id'];
                $data = array(
                    'date' => $date,
                    'payment_type' => $payment_type,
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
                    'created_by' => date("Y-m-d H:i:s"),
                    'customer_id' => $customer_id
                );
                $insert = $this->service_model_8->master_insert("sh_credit_debit", $data);
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
                        'created_by' => date("Y-m-d H:i:sa")
                    );
                    $insert = $this->service_model_8->master_insert("sh_credit_debit", $data);
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

    public function check_version() {
        $finalarray = array("vesion_code" => "1", "flag" => "TRUE");
        echo $this->json_data("1", "", array($finalarray));
    }

    public function add_loan() {
        $token = $this->input->get_post('token');
        $date = $this->input->get_post('date');
        $amount = $this->input->get_post('amount');
        $worker_id = $this->input->get_post('worker_id');
        $remark = $this->input->get_post('remark');
        if ($token != "" && $date != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $id = $list[0]['id'];
                $location_id = $list[0]['l_id'];
                $data = array("worker_id" => $worker_id, "user_id" => $id, "location_id" => $location_id, "loan_amount" => $amount, 'remark' => $remark, 'date' => $date);
                $insert = $this->service_model_8->master_insert("sh_personal_loan", $data);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $this->load->model('daily_reports_model');
                $data = $this->daily_reports_model->report_date($location_id, $date);
                if ($data) {
                    $data->meter_details = $this->daily_reports_model->meter_details($location_id, $date);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            if ($list) {
                $list = $this->service_model_8->bankdeposit_list($fdate, $tdate, $location);
                $onlinelist = $this->service_model_8->online_list($fdate, $tdate, $location);
                $creadit_dabit_list = $this->service_model_8->creadit_dabit_list($fdate, $tdate, $location);
                $fianlarray = array();
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
                }

                function sortByName($a, $b) {
                    $a = $a['date'];
                    $b = $b['date'];

                    if ($a == $b)
                        return 0;
                    return ($a < $b) ? -1 : 1;
                }

                $base_url = base_url();
                $html = "";
                $msg = '"Are you sure you want to remove this data?"';
                $deposit = 0;
                $onlinetrasectin = 0;
                $withdraw = 0;
                $list1 = array_merge($list, $onlinelist);
                $list2 = array_merge($list1, $creadit_dabit_list);
                $count = count($list2);
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

        if ($token != "" && $id != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $data = $this->service_model_8->get_pump_list_Detail($id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            $company_id = $list[0]['id'];
            $data = array();
            if ($list) {
                $data['bankdeposit'] = $this->service_model_8->bankdeposit_list_view($date, $location);

                $data['onlinelist'] = $this->service_model_8->online_list_view($date, $location);
                $data['creadit_dabit_list'] = $this->service_model_8->creadit_dabit_list_view($date, $location);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            //echo $this->db->last_query();
            if ($list) {
                $data['bankdeposit'] = $this->service_model_8->bankdeposit_info($id);

                $data['d_amount'] = $this->service_model_8->view_d_amount($id);
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
            $list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $location_id = $list[0]['l_id'];
                $data = $this->service_model_8->get_expence_list($location_id);

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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];
                $data = $this->service_model_8->getall("sh_expensein_types", array("comapny_id" => $company_id, "status" => 1, "exps_id" => 1, "location_id" => $location_id));
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];
                $data = $this->service_model_8->master_insert("sh_expensein_types", array("comapny_id" => $company_id, "status" => 1, "exps_id" => 1, "location_id" => $location_id, "exps_name" => $exps_name));
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $company_id = $list[0]['id'];
                $data = $this->service_model_8->master_update("sh_expensein_types", array("id" => $id), array("comapny_id" => $company_id, "location_id" => $location_id, "exps_name" => $exps_name));
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
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
                $data = $this->service_model_8->master_update("sh_expensein_types", array("id" => $id), array("status" => 0));
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
	
	public function comapny_tank_list(){
		$token = $this->input->get_post('token');
		$location = $this->input->get_post('location');
        if ($token != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
				
				$company_id = $list[0]['id'];
				$cond = array("company_id" => $company_id );
				if($location != ""){
					$cond['location_id'] = $location;
				}
				$data = $this->service_model_8->master_fun_get_tbl_val_with_order('sh_tank_list', $cond, array('tank_name','asc'));
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
	public function comapny_tank_add(){
		$token = $this->input->get_post('token');
		$location = $this->input->get_post('location');
		$name = $this->input->get_post('name');
		$type = $this->input->get_post('type');
		$fuel_type = $this->input->get_post('fuel_type');
        if ($token != "" && $location != "" && $name != "" && $type != "" && $fuel_type != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
				$company_id = $list[0]['id'];
				$array = array('location_id'=>$location,
				'company_id'=>$company_id,
				'tank_name'=>$name,
				'tank_type'=>$type,
				'fuel_type'=>$fuel_type );
				$data = $this->service_model_8->master_insert("sh_tank_list",$array);
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
	public function comapny_tank_update(){
		$token = $this->input->get_post('token');
		$location = $this->input->get_post('location');
		$name = $this->input->get_post('name');
		$type = $this->input->get_post('type');
		$fuel_type = $this->input->get_post('fuel_type');
		$id = $this->input->get_post('id');
        if ($token != "" && $location != "" && $name != "" && $type != "" && $fuel_type != "" && $id != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
				$company_id = $list[0]['id'];
				$array = array('location_id'=>$location,
				'company_id'=>$company_id,
				'tank_name'=>$name,
				'tank_type'=>$type,
				'fuel_type'=>$fuel_type );
				$data = $this->service_model_8->master_update("sh_tank_list", array("id" => $id),$array);
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
	public function comapny_tank_delete(){
		$token = $this->input->get_post('token');
		$id = $this->input->get_post('id');
        if ($token != "" && $id != "") {
            $list = $this->service_model_8->master_fun_get_tbl_val("sh_com_registration", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
				$company_id = $list[0]['id'];
				$array = array('status'=>'0' );
				$data = $this->service_model_8->master_update("sh_tank_list", array("id" => $id),$array);
				
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
	public function get_user_entry(){
		$token = $this->input->get_post('token');
		$date = $this->input->get_post('date');
        if ($token != "" && $date != "") {
			$list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
				$id = $list[0]['id'];
				$inventory = $this->service_model_8->master_fun_get_tbl_val("sh_inventory", array("user_id" => $id, "status" => 1,"date"=>$date), array("date", "asc"));
				$shdailyreadingdetails = $this->service_model_8->master_fun_get_tbl_val_new("shdailyreadingdetails", array("UserId" => $id, "status" => 1,"date"=>$date), array("date", "asc"),'id,data,date,oil_reading,p_tank_reading,d_tank_reading,p_deep_reading,d_deep_reading,d_total_selling,p_total_selling,p_selling_price,d_selling_price,p_sales_vat,d_sales_vat,p_testing,d_testing,cash_on_hand');
				
				$shdailyreadingdetails[0]['tank_wies_reading_sales'] = $this->service_model_8->master_fun_get_tbl_val_new("sh_tank_wies_reading_sales", array("sales_id" => $shdailyreadingdetails[0]['id'], "status" => 1,"date"=>$date), array("date", "asc"),'*');
				$sh_expensein_details = $this->service_model_8->master_fun_get_tbl_val("sh_expensein_details", array("user_id" => $id, "status" => 1,"date"=>$date), array("date", "asc"));
				$sh_credit_debit = $this->service_model_8->master_fun_get_tbl_val_new("sh_credit_debit", array("user_id" => $id, "status" => 1,"date"=>$date), array("date", "asc"),'date,payment_type,batch_no,amount,customer_id,bill_no,vehicle_no,fuel_type,quantity,transaction_type,transaction_number,bank_name');
				$sh_bankdeposit = $this->service_model_8->master_fun_get_tbl_val("sh_bankdeposit", array("user_id" => $id, "status" => 1,"date"=>$date), array("date", "asc"));
				$sh_onlinetransaction = $this->service_model_8->master_fun_get_tbl_val("sh_onlinetransaction", array("user_id" => $id, "status" => 1,"date"=>$date), array("date", "asc"));
				$data['inventory'] = $inventory;
				$data['shdailyreadingdetails'] = $shdailyreadingdetails;
				$data['sh_expensein_details'] = $sh_expensein_details;
				$data['sh_credit_debit'] = $sh_credit_debit;
				$data['sh_bankdeposit'] = $sh_bankdeposit;
				$data['sh_onlinetransaction'] = $sh_onlinetransaction;
				echo str_replace('\"','"',$this->json_data("1", "", array($data)));
			}else{
				echo $this->json_data("3", "Token expired. Please login again.", "");
			}
		}else{
			echo $this->json_data("0", "Parameter not passed", "");
		}
	}
	public function demo(){
		$token = $this->input->get_post('token');
		$date = $this->input->get_post('date');
        if ($token != "" && $date != "") {
			$list = $this->service_model_8->master_fun_get_tbl_val("shusermaster", array("token" => $token, "status" => 1), array("id", "id"));
            if ($list) {
			}else{
				echo $this->json_data("3", "Token expired. Please login again.", "");
			}
		}else{
			echo $this->json_data("0", "Parameter not passed", "");
		}
	}
}
?>