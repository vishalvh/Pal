<?php

class main extends CI_Controller {

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->view('web/index', $data);
    }

    function register() {
        $this->load->view('register');
    }

    function form() {
        $this->load->view('form');
    }

    function test() {
        $this->load->view('test');
    }

    function add() {
        $this->load->view('form_insert');
    }

    // user insert
    public function insert() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[7]|is_unique[signup.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[signup.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[8]');
        if ($this->form_validation->run()) {
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );
            $this->db->insert('signup', $data);

            redirect('main/register', $data);
        } else {
            $this->register();
        }
    }

    function login_validation() {
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $this->load->model('user_login');
            $login = $this->user_login->login($email, $password);
            // echo $this->db->last_Query();die();
            // print_r($login[0]->email);
            // die();
            $id = $login[0]->id;
            $username = $login[0]->name;
            $email = $login[0]->email;
            $mobile = $login[0]->mobile;
            $password = $login[0]->password;
            $type = "c";
            if ($login != "") {
                // echo "hi";die();
                $session_data = array(
                    'id' => $id,
                    'name' => $username,
                    'email' => $email,
                    'mobile' => $mobile,
                    'type' =>$type
                );
                $this->session->set_userdata('logged_company', $session_data);
                redirect(base_url() . 'main/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid Username Or password');
                redirect(base_url() . 'company_login/index');
            }
        } else {
            $this->index();
        }
    }

    function dashboard() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $this->load->view('web/index', $data);
        // redirect(base_url() . 'main/index');
    }

    // logout code
    function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'company_login/index');
    }

}

?>