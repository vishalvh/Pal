<?php

class Company_daily_maintain extends CI_Controller {

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
        $this->load->model('company_expense_model');
    }

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
        $this->load->model('Company_daily_maintain_model');
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $sesid = $this->session->userdata('logged_company')['id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        } else {
            $sesid = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        }
        $this->load->view('web/company_daily_maintain_list', $data);
    }

    function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('company_daily_maintain');
        }
        $this->load->model('admin_model');
        $id1 = $_SESSION['logged_company']['id'];
        $data["logged_company"] = $_SESSION['logged_company'];
        $data['r'] = $this->admin_model->select_location($id1);
        $this->load->view('web/company_daily_maintain_add', $data);
    }

    public function insert() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('company_daily_maintain');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->form_validation->set_rules('title', 'Username', 'required');

        if ($this->form_validation->run()) {
            $data = array(
                'comapny_id' => $_SESSION['logged_company']['id'],
                'name' => $this->input->post('title'),
                'location_id' => $this->input->post('sel_loc'),
				'created_at' =>date('Y-m-d H:i:d')
            );
            $this->db->insert('sh_company_daily_maintain', $data);
            $this->session->set_flashdata('success', 'Daily maintain Add Successfully..');
            redirect('company_daily_maintain');
        } else {
            $this->add();
        }
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('company_daily_maintain_model');
        $id = $_SESSION['logged_company']['id'];

        $extra = $this->input->get('extra');
        $list = $this->company_daily_maintain_model->get_datatables($id, $extra);
		
        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {

            $no++;
            if ($customers->show == 0) {
                $msg_s_h = "Show";
                $status = '<span class="btn btn-danger">Hide</span>';
            } else {
                $msg_s_h = "Hide";
                $status = '<span class="btn btn-primary">Show</span>';
            }
           // $ac1 = " <a href='" . $base_url . "company_expense/show_hide/" . $customers->id . "/" . $customers->show . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'>$msg_s_h</a>";
            $edit = "<a href='" . $base_url . "company_daily_maintain/update/" . $customers->id . "/" . $extra . " '><i class='fa fa-edit'></i></a>  
			<a href='" . $base_url . "company_daily_maintain/delete/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i>" . $ac1 . "</a>";

            $row = array();
            $row[] = $no;
            $row[] = $customers->name;
            $row[] = $customers->l_name;
            if(in_array("daily_maintain_action",$this->data['user_permission_list'])){
                $row[] = $edit;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->company_daily_maintain_model->count_all($id),
            "recordsFiltered" => $this->company_daily_maintain_model->count_filtered($id),
            "data" => $data,
        );

        echo json_encode($output);
    }

    /*public function show_hide() {
        ini_set('display_errors', '-1');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('Company_expense');
        }
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
      
        $update = $this->company_expense_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data ' . $sting . ' Successfully..');
        redirect('company_expense/index/' . $lid);
    }*/

    // update profile for admin 

    function update($id) {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('company_daily_maintain');
        }
        $data["lid"] = $this->uri->segment('4');
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Company_daily_maintain_model');
        $this->form_validation->set_rules('title', 'Title', 'required');

        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('title')
            );

            $update = $this->Company_daily_maintain_model->update($id, $data);
            // echo $this->db->last_query();die();
            if ($update) {
                $this->session->set_userdata('logged_company', $data);
            }
            $this->session->set_flashdata('success', 'Expense Updated Successfully..');
            redirect('company_daily_maintain/index/' . $this->uri->segment('4'));
        } else {
            $this->load->model('admin_model');
            $id1 = $_SESSION['logged_company']['id'];
            $data["logged_company"] = $_SESSION['logged_company'];
            $data['r'] = $this->admin_model->select_location($id1);
            $data['detail'] = $this->Company_daily_maintain_model->select($id);
            $this->load->view('web/company_daily_maintain_edit', $data);
        }
    }

    function delete($id) {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            redirect('company_daily_maintain');
        }
        $lid = $this->uri->segment('4');
        $this->load->model('Company_daily_maintain_model');
        $data = array('status' => '0');
        $update = $this->Company_daily_maintain_model->update($id, $data);
        $this->session->set_flashdata('success', 'Daily maintain Delete Successfully..');
        redirect('company_daily_maintain/index/' . $lid);
    }

}

?>