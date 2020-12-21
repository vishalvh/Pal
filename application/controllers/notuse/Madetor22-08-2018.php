<?php

class Madetor extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Madetor_model');

        $this->load->database();
        $this->load->library('form_validation');
        // $this->load->library('fpdf');
    }

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
        $data = array();
        $this->load->view('web/madetor/madetor_list', $data);
    }

    function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $data["logged_company"]['id'];
//                $data['location_list'] = $this->Madetor_model->select_all('sh_location',array('status' => '1','company_id' => $c_id));

        $this->form_validation->set_rules('madetorname', 'Madetor Name', 'required');
        $this->form_validation->set_rules('emailid', 'Email Name', 'required|callback_email_validation');
        $this->form_validation->set_rules('mobileno', 'Mobile No', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {
            $data = array('company_id' => $_SESSION['logged_company']['id'],
                'name' => $this->input->post('madetorname'),
                'email_id' => $this->input->post('emailid'),
                'mobile_no' => $this->input->post('mobileno'),
                'password' => $this->input->post('password')
            );
            $this->db->insert('sh_madetor', $data);
            $this->session->set_flashdata('success', 'Madetor Add Successfully..');
            redirect('madetor');
        } else {
            $this->load->view('web/madetor/madetor_add', $data);
        }
    }

    function email_validation($email) {
        $check = $this->Madetor_model->check_email($email);
        if ($check == "") {
            $this->form_validation->set_message('email_validation', 'Email Address already exist');
            return false;
        } else {
            return true;
        }
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $id = $_SESSION['logged_company']['id'];
        $extra = $this->input->get('extra');
        $list = $this->Madetor_model->get_datatables($id);
        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];
        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {
            $no++;
            $edit = "<a href='" . $base_url . "madetor/update/" . $customers->id . " '><i class='fa fa-edit'></i></a>  
			<a href='" . $base_url . "madetor/delete/" . $customers->id . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a>";
            $row = array();
            $row[] = $no;
            $row[] = $customers->name;
            $row[] = $customers->email_id;
            $row[] = $customers->mobile_no;
            $row[] = $edit;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Madetor_model->count_all($id),
            "recordsFiltered" => $this->Madetor_model->count_all($id),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // update profile for admin 

    function update($id) {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $data["logged_company"]['id'];
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->form_validation->set_rules('madetorname', 'Madetor Name', 'required');
        $this->form_validation->set_rules('emailid', 'Email id', 'required|callback_email_validation2');
        $this->form_validation->set_rules('mobileno', 'Mobile No', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == true) {
            $data = array('company_id' => $_SESSION['logged_company']['id'],
                'name' => $this->input->post('madetorname'),
                'email_id' => $this->input->post('emailid'),
                'mobile_no' => $this->input->post('mobileno'),
                'password' => $this->input->post('password')
            );

            $update = $this->Madetor_model->update($id, $data);
            //echo $this->db->last_query();die();
            if ($update) {
                $this->session->set_userdata('logged_company', $data);
            }
            $this->session->set_flashdata('success', 'Updated Successfully..');
            redirect('madetor');
        } else {
            $data['detail'] = $this->Madetor_model->select($id);
            $this->load->view('web/madetor/madetor_edit', $data);
        }
    }

    function email_validation2($email) {

        $id = $this->input->post('id');

        $user = $this->Madetor_model->check_email1($email, $id);
        echo $this->db->last_query();

        if ($user != 0) {

            $this->form_validation->set_message('email_validation2', 'Email Address already exist');
            return false;
        } else {
            return true;
        }
    }

    function delete($id) {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data = array('status' => '0');
        $update = $this->Madetor_model->update($id, $data);
        $this->session->set_flashdata('success', 'Delete Successfully..');
        redirect('madetor');
    }

}

?>