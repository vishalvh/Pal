<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginUser extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('User_login_model');
        $this->load->database();
        $this->load->library('session');
		if($_SESSION['logged_in'] != ""){
				redirect('/');
		}
    }

    function index() {
        $data = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('user_login_view');
        } else {
            $this->load->view('user/header');
            $this->load->view('user/registration');
            $this->load->view('user/footer');
        }
    }

    function verify_login() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
        if ($this->form_validation->run() == FALSE) {
            $sess_array = array();
            $ses = "User Email Or Password Wrong";
            $this->session->set_flashdata('notlogin', $ses);
            $data["error"] = $this->session->flashdata('notlogin');
            $this->load->view('user_login_view');
        } else {
            redirect('Userhome', 'refresh');
        }
    }

    function check_database($password) {
        $username = $this->input->post('email');
        $result = $this->User_login_model->checkloginAdmin($username, $password);
        if ($result != "") {
            $result = $this->User_login_model->checklogin1Admin($username, $password);
            if ($result != "") {
                $sess_array = array();
                foreach ($result as $row) {
                    $sess_array = array(
                        'id' => $row->id,
                        'UserEmail' => $row->AdminEmail,
                        'UserFName' => $row->AdminName,
                        'profile_pic' => $row->profile_pic,
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
        redirect('loginAdmin');
    }

    function l() {
        $result = $this->Login_model->d();
    }

}

?>