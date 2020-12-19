<?php

class Petty_cash_member extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_company')) {
            $this->load->model('user_login');
            if($this->session->userdata('logged_company')['type'] == 'c'){
			$sesid = $this->session->userdata('logged_company')['id'];
			$this->data['all_location_list'] = $this->user_login->get_all_location($sesid);
			$this->data['user_permission_list'] = $this->user_login->getAllPermission();
		}else{
			$sesid = $this->session->userdata('logged_company')['u_id'];
			$this->data['all_location_list'] = $this->user_login->get_location($sesid);
			$this->data['user_permission_list'] = $this->user_login->getUserPermission($sesid);
		}
            $this->load->library('Web_log');
            $p = new Web_log;
            $this->allper = $p->Add_data();
        }
    }

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $sesid = $this->session->userdata('logged_company')['id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        } else {
            $sesid = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        }
        $this->load->view('web/petty_cash_member', $data);
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('petty_cash_member_model');
        $id = $_SESSION['logged_company']['id'];
        $extra = $this->input->get('extra');
        $list = $this->petty_cash_member_model->get_datatables($extra, $id);
        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];
        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {
            if ($customers->show == 0) {
                $msg_s_h = "Show";
                $status = '<span class="btn btn-danger">Hide</span>';
            } else {
                $msg_s_h = "Hide";
                $status = '<span class="btn btn-primary">Show</span>';
            }
            $ac1 = " <a href='" . $base_url . "petty_cash_member/show_hide/" . $customers->id . "/" . $customers->show . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'>$msg_s_h</a>";
            
            $edit = "<a href='" . $base_url . "petty_cash_member/update/" . $customers->id . "/" . $extra . " '><i class='fa fa-edit'></i></a>  
			<a href='" . $base_url . "petty_cash_member/delete/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a> $ac1";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $customers->name;
            $row[] = $customers->mobile;
            $row[] = $customers->l_name;
            $row[] = $status;
			if(in_array("petty_cash_member_action",$this->data['user_permission_list'])){
            $row[] = $edit;
			}
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->petty_cash_member_model->count_all($extra, $id),
            "recordsFiltered" => $this->petty_cash_member_model->count_all($extra, $id),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function show_hide() {
        ini_set('display_errors', '-1');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('reset_pump');
        }
     $this->load->model('petty_cash_member_model');
        $id = $this->uri->segment('3');
        $show = $this->uri->segment('4');
        $lid = $this->uri->segment('5');
        $data = array();
        if ($show == '1') {

            $sting = "hide";
            $data = array('show' => 0);
        } else {
            $sting = "show";
            $data = array('show' => 1);
        }

        $update = $this->petty_cash_member_model->update($id, $data);

//        echo $this->db->last_query();
        $this->session->set_flashdata('success', 'Data ' . $sting . ' Successfully..');
        redirect('petty_cash_member/index/' . $lid);
    }

    public function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('reset_pump');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('petty_cash_member_model');
        $data['r'] = $this->petty_cash_member_model->select_location($id1);
        $this->load->view('web/petty_cash_member_insert', $data);
    }

    public function insert() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('reset_pump');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        if ($this->form_validation->run() == true) {
            date_default_timezone_set('Asia/Kolkata');
            $data = array(
                'name' => $this->input->post('name'),
                'mobile' => $this->input->post('mobile'),
                'location_id' => $this->input->post('location'),
                'created_at' => date("Y-m-d H:i:sa"),
                'company_id' => $_SESSION['logged_company']['id'],
            );
            $this->db->insert('petty_cash_member', $data);
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect('petty_cash_member');
        } else {
            $this->add();
        }
    }

    function delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('reset_pump');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('petty_cash_member_model');
        $id = $this->uri->segment('3');
        $sess_id = $_SESSION['logged_company']['id'];
        date_default_timezone_set('Asia/Kolkata');
        $data = array(
            'delete_at' => date("Y-m-d H:i:sa"),
            'status' => '0'
        );
        $this->petty_cash_member_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'Data Deleted Successfully..');
        redirect('petty_cash_member/index/' . $this->uri->segment('4'));
    }

    function update() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('reset_pump');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('petty_cash_member_model');
        $id = $this->uri->segment('3');
        $data["id"] = $this->uri->segment('3');
        $data["lid"] = $this->uri->segment('4');
        $data["pump"] = $this->petty_cash_member_model->select_pumpby_id($id);
        // echo $this->db->last_query();die();
        // print_r($data["pump"]);die(); 
        $this->form_validation->set_rules('name', 'name', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array(
                'location_id' => $this->input->post('location'),
                'name' => $this->input->post('name'),
                'update_at' => date('Y-m-d H:i:sa'),
                'mobile' => $this->input->post('mobile')
            );
            $update = $this->petty_cash_member_model->update($id, $data);
//            echo $this->db->last_query();
//            die();
            $this->session->set_flashdata('success_update', 'Data Updated Successfully..');
            redirect('petty_cash_member/index/' . $this->uri->segment('4'));
        } else {
            $id = $this->uri->segment('3');
            if ($id == "") {
                $id = $this->input->post('id');
            }
            $query = $this->db->get_where("shpump", array("id" => $id));
            $data['r'] = $query->row();
            $this->load->model('admin_model');
            $id1 = $_SESSION['logged_company']['id'];
            $data['r'] = $this->petty_cash_member_model->select_location($id1);
            $data['petty_cash_member'] = $this->petty_cash_member_model->get_tbl_list('petty_cash_member', array('status' => '1', 'id' => $id,), array('id', 'asc'));
//			print_r($data['petty_cash_member']);
//                        die();
            $this->load->view('web/petty_cash_member_edit', $data);
        }
    }

    function upd_pump() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('reset_pump');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('petty_cash_member_model');
        $id = $this->uri->segment('3');
        $data["id"] = $this->uri->segment('3');
        $data["pump"] = $this->petty_cash_member_model->select_pumpby_id($id);
        // echo $this->db->last_query();die();
        // print_r($data["pump"]);die(); 
        $this->form_validation->set_rules('pump', 'pump', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array(
                'location_id' => $this->input->post('sel_loc'),
                'name' => $this->input->post('pump'),
                'update_at' => date('Y-m-d H:i:sa'),
                'type' => $this->input->post('pump_type'),
                'tank_id' => $this->input->post('tank_list')
            );
            $update = $this->petty_cash_member_model->update($id, $data);
            $this->session->set_flashdata('success_update', 'Data Updated Successfully..');
            redirect('reset_pump/index');
        } else {
            $id = $this->uri->segment('3');
            if ($id == "") {
                $id = $this->input->post('id');
            }
            $query = $this->db->get_where("shpump", array("id" => $id));
            $data['r'] = $query->row();
            $this->load->model('admin_model');
            $id1 = $_SESSION['logged_company']['id'];
            $data['r1'] = $this->admin_model->select_location($id1);
            $data['tanklist'] = $this->petty_cash_member_model->get_tbl_list('sh_tank_list', array('status' => '1', 'location_id' => $data['r']->location_id, 'fuel_type' => $data['r']->type), array('tank_name', 'asc'));
            $this->load->view('web/pump_edit', $data);
        }
    }

    function pump_list() {
        $location = $this->input->post('lid');
        $this->load->model('petty_cash_member_model');
        $list = $this->petty_cash_member_model->get_tbl_list('shpump', array('type !=' => 'o', 'status' => '1', 'location_id' => $location), array('name', 'asc'));
        $html = '<option value="">Select Pump</option>';
        foreach ($list as $tank) {

            if ($tank->type == 'p') {
                $type = 'Petrol';
            } else {
                $type = 'Diesel';
            }
            $html .= '<option value="' . $tank->id . '">' . $tank->name . '(' . $type . ')</option>';
        }
        echo $html;
    }

}

?>