<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('master_model');
    }

    function index() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Admin/user_login_view');
        } else {
            $this->load->view('Admin/user_login_view');
        }
    }

    function verify_login() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Admin/user_login_view');
        } else {
            redirect('Userhome', 'refresh');
        }
    }

    function check_database($password) {
        $this->load->library('session');
        $username = $this->input->post('email');
        $result = $this->login_model->checklogin($username, $password);
       // echo $this->db->last_query();
        
        if ($result != "") {
            $result = $this->login_model->checklogin1($username, $password);
            if ($result != "") {
                $sess_array = array();
                foreach ($result as $row) {
                    $sess_array = array(
                        'id' => $row->id,
                        'AdminEmail' => $row->AdminEmail,
                        'AdminName' => $row->AdminName,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata('logged_in', $sess_array);
                }
                return TRUE;
            } else {
                $this->form_validation->set_message('check_database', 'Please Activate Your Account');
                return false;
            }
        } else {
            $this->form_validation->set_message('check_database', 'Invalid Email or password');
            return false;
        }
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        redirect('login');
    }
    function forgot_password(){
        $this->load->view('Admin/forgot_password');
    }
    function forgot_pass_data() {
            $email = $this->input->post('UserEmail');
	//	print_r($email);
            $check_email = $this->master_model->get_one("shadminmaster", array("AdminEmail" => $email, 'status' => '1'));
            
            if (empty($check_email)) {
                $this->session->set_flashdata('fail', "Invalid email Please Check It!");
               redirect('login/forgot_password');
            }
            $this->load->helper('string');
            $rs = random_string('alnum', 5);
            $data = array(
                'rs' => $rs
            );
            
            $update = $this->master_model->master_update("shadminmaster", array("AdminEmail" => $email, 'status' => '1'),$data);
            $this->load->helper(array('swift'));
            $subject = "Rest Password Link";
            $link=base_url(). "administrator/get_password/index/" . $rs;
            $message = "Dear ".ucwords($check_email->AdminName);
            $message .= "You recently requested to reset your password. Click the button below to reset it.<br/><br/>";
            $message .= "<a href='" . base_url() . "login/get_password/" . $rs . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Reset your password</a><br/><br/>";
            $message .= "If you did not request a password reset, please ignore this email or reply to let us know.<br/><br/>";
            $message .= "Thanks <br/> Shri Hari Pal";
            send_mail($email,'Shri Hari Pal Reset your forgotten Password',$message);
            $this->session->set_flashdata('success', "We have Sent you a link to change your password Please Check It!");
              redirect('login'); 
    }
    public function get_password($code) {
           $data['code'] = $code;
            $query = $this->master_model->get_one("shadminmaster", array("rs" => $code, 'status' => '1'));
		//print_r($query);
             if ($query == "") {
				  $this->session->set_flashdata('fail',"You Have Already Updated Password!");
                redirect('login');
            }else{
				  $this->load->view('Admin/gp_form',$data);
			 }   
           
    }
        public function set_password($rs = FALSE) {
            $code = $rs;
			//print_r($_POST);
			$data['code'] = $code;
            $query = $this->db->get_where('shadminmaster', array('rs' => $code, 'status' => '1'), 1);
			//print_r($query);
            if ($query->num_rows() == 0) {
				  $this->session->set_flashdata('unsuccess',"You Have Already Updated Password!");
                redirect('login');
            } else {
                $pass = $this->input->post('password');
                $cpass = $this->input->post('passconf');
                if ($pass == $cpass) {
                    $data = array(
                        'AdminPassword' => $this->input->post('password'),
                        'rs' => ''
                    );
                    $where = $this->db->where('status', '1');
                    $where = $this->db->where('rs', $code);
                    $where->update('shadminmaster', $data);
                    $this->session->set_flashdata('success', "Congratulation!! Your Password Changed Successfully!");
                     redirect('login');
                } else {
                    $this->session->set_flashdata('fail', "Password Do Not Match!");
                      $this->load->view('Admin/gp_form',$data);
                }
            }
        }
    
    
            function l() {
        $result = $this->login_model->d();
    }

}
?>