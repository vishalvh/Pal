<?php

class Admin extends CI_Controller {

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->database();
        $this->load->model('admin_model');
        $data['h'] = $this->admin_model->select();
        $this->load->view('web/form', $data);
    }

    function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('admin');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('admin_model');
        $data['r'] = $this->admin_model->select_location($id1);


        $this->load->view('web/form_insert', $data);
    }

    function profile() {

        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('admin');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->view('web/profile', $data);
    }

    function change_pass() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->view('web/change_password', $data);
    }

    public function insert() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('admin');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_email_validation');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile Numner', 'required|regex_match[/^[0-9]{10}$/]');

        if ($this->form_validation->run()) {
            date_default_timezone_set('Asia/Kolkata');
            $data = array(
                'l_id' => $this->input->post('sel_loc'),
                'company_id' => $_SESSION['logged_company']['id'],
                'UserFName' => $this->input->post('username'),
                'UserEmail' => $this->input->post('email'),
                'UserPassword' => $this->input->post('password'),
                'UserMNumber' => $this->input->post('mobile'),
                'CreatedDate' => date("Y-m-d H:i:sa"),
                'shift' => $this->input->post('shift'),
                'Active' => '1'
            );

            $this->db->insert('shusermaster', $data);

            $this->session->set_flashdata('success', 'You Are Registerd Successfully..');

            redirect('admin');
        } else {
            $this->add();
        }
    }

    function email_validation($email) {

        $this->load->model('admin_model');
        $check = $this->admin_model->check_email($email);
        if ($check == "") {
            $this->form_validation->set_message('email_validation', 'Email Address already exist');
            return false;
        } else {
            return true;
        }
    }

    function user_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('admin_model');
        $id = $this->uri->segment('3');

        $data = array(
            'status' => '0'
        );
        $this->admin_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'User Deleted Successfully..');
        redirect('admin');
    }

    function user_update() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('admin');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        //print_r($_POST);
        $this->load->model('admin_model');
        $id = $this->input->post('id');

        $data["id"] = $this->uri->segment('3');


        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_upd_email_validation');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile Numner', 'required|regex_match[/^[0-9]{10}$/]');

        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array(
                'l_id' => $this->input->post('sel_loc'),
                'shift' => $this->input->post('shift'),
                'UserFName' => $this->input->post('username'),
                'UserEmail' => $this->input->post('email'),
                'UserPassword' => $this->input->post('password'),
                'UserMNumber' => $this->input->post('mobile'),
                'updated_at' => date('Y-m-d H:i:sa')
            );

            $update = $this->admin_model->update($id, $data);

            $this->session->set_flashdata('success_update', 'User Data Updated Successfully..');
            redirect('admin');
        } else {

            $id = $this->uri->segment('3');
            $data["shift"] = $this->admin_model->select_shiftby_id($id);
            if ($id == "") {
                $id = $this->input->post('id');
            }
            $query = $this->db->get_where("shusermaster", array("id" => $id));
            $data['r'] = $query->result();

            $this->load->model('admin_model');
            $id1 = $_SESSION['logged_company']['id'];
            $data['r1'] = $this->admin_model->select_location($id1);

            $this->load->view('web/form_edit', $data);
        }
    }

    function upd_email_validation($email) {
        $id = $this->input->post('id');
        $this->load->model('admin_model');
        $user = $this->admin_model->check_user($id);

        $email1 = $user[0]->UserEmail;

        if ($email == $email1) {
            return true;
        } else {
            $check = $this->admin_model->check_email($email);
            if ($check == "") {
                $this->form_validation->set_message('upd_email_validation', 'Email already exist');
                return false;
            } else {
                return true;
            }
        }
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $logged_company = $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('admin_model');
        $id = $_SESSION['logged_company']['id'];

        $extra = $this->input->get('extra');
        $list = $this->admin_model->get_datatables($extra, $id);

        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {
            if ($customers->shift == 1) {
                $shift = "Day";
            }
            if ($customers->shift == 2) {
                $shift = "Night";
            }
            if ($customers->shift == 3) {
                $shift = "24 hours";
            }
            $no++;
            $edit = "<a href='" . $base_url . "admin/user_update/" . $customers->id . " '><i class='fa fa-edit'></i></a>  
			<a href='" . $base_url . "admin/user_delete/" . $customers->id . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a>";
            $name = $customers->UserFName;
            $name1 = ucfirst($name);
            $row = array();
            $row[] = $no;
            $row[] = $name1;
            $row[] = $customers->UserEmail;
            $row[] = $customers->UserMNumber;
            $row[] = $customers->l_name;
            $row[] = $shift;

            if ($logged_company['type'] == 'c') {
                $row[] = $edit;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin_model->count_all($extra, $id),
            "recordsFiltered" => $this->admin_model->count_filtered($extra, $id),
            "data" => $data,
        );

        echo json_encode($output);
    }

    // update profile for admin 

    function update_profile() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('admin');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('admin_model');
        $id = $_SESSION['logged_company']['id'];
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_pro_email');
        $this->form_validation->set_rules('mobile', 'Mobile Numner', 'required|regex_match[/^[0-9]{10}$/]');

        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'updated_by' => date('Y-m-d H:i:sa')
            );

            $update = $this->admin_model->update_profile($id, $data);
            $user = $this->admin_model->select2($id);
            //echo $this->db->last_query();
            $type = 'c';
            $session_data = array(
                'id' => $_SESSION['logged_company']['id'],
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'type' => $type
            );
            $this->session->set_userdata('logged_company', $session_data);

            $this->session->set_flashdata('update_profile', 'Your Profile Updated Successfully..');
            redirect('admin/profile');
        } else {

            $this->load->view('web/profile', $data);
        }
    }

    function pro_email($email) {
        $this->load->model('admin_model');
        $id = $_SESSION['logged_company']['id'];
        $check = $this->admin_model->check_email1($email, $id);
        if ($check == "") {
            $this->form_validation->set_message('pro_email', 'Email Address already exist');
            return false;
        } else {
            return true;
        }
    }

    function change_password() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $old_pass = $this->input->post('old_pass');

        $this->load->model('admin_model');
        $this->form_validation->set_rules('old_pass', 'Password', 'required');
        $this->form_validation->set_rules('new_pass', 'New Password', 'required');
        $this->form_validation->set_rules('con_pass', 'Confirm Password', 'required');
        if ($this->form_validation->run() == true) {

            $ds = $this->admin_model->check_password($old_pass);
            if ($ds == 1) {
                $n_pass = $this->input->post('new_pass');
                $cpass = $this->input->post('con_pass');
                if ($n_pass == $cpass) {
                    $data = array(
                        'password' => $n_pass
                    );
                    $this->admin_model->update_pass($data);

                    $this->session->set_flashdata('update_pass', 'Password Changed successfully');
                    redirect('admin/change_pass');
                } else {
                    $this->session->set_flashdata('chk_pass', 'Please check new password and confirm password');
                    $this->change_pass();
                }
            } else {
                $this->session->set_flashdata('upd_fail', 'Old Password Does Not Match');
                // $this->form_validation->set_message('old_pass', 'password doesnt match');
                $this->change_pass();
            }
        } else {
            $this->form_validation->set_message('old_pass', 'password doesnt match');
            $this->change_pass();
        }
    }

}

?>