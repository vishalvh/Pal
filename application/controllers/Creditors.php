<?php

class Creditors extends CI_Controller {
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
	$this->load->model('Creditors_model');

        $this->load->database();
        $this->load->library('form_validation');
}

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
 $this->load->model('admin_model');
          if ($this->session->userdata('logged_company')['type'] == 'c') {
            $sesid = $this->session->userdata('logged_company')['id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        } else {
            $sesid = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        }
        $this->load->view('web/creditors_list', $data);
    }

    function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('creditors');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $data["logged_company"]['id'];
        $data['location_list'] = $this->Creditors_model->select_location2($c_id);

        $this->form_validation->set_rules('l_id', 'Location Id', 'required');
        $this->form_validation->set_rules('creditorsname', 'Creditors Name', 'required');

        if ($this->form_validation->run()) {
            $data = array('company_id' => $_SESSION['logged_company']['id'],
                'location_id' => $this->input->post('l_id'),
                'name' => $this->input->post('creditorsname')
            );
            $this->db->insert('sh_creditors', $data);
            $this->session->set_flashdata('success', 'Creditors Add Successfully..');
            redirect('creditors');
        } else {
            $this->load->view('web/creditors_add', $data);
        }
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $id = $_SESSION['logged_company']['id'];

        $extra = $this->input->get('extra');
        $list = $this->Creditors_model->get_datatables($id,$extra);

        //     print_r($list);       
//      echo  $this->db->last_query();
//               die();
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
            $ac1 = " <a href='" . $base_url . "creditors/show_hide/" . $customers->id . "/" . $customers->show . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'>$msg_s_h</a>";
            
            $edit = "<a href='" . $base_url . "creditors/update/" . $customers->id . "/" . $extra . " '><i class='fa fa-edit'></i></a>  
			<a href='" . $base_url . "creditors/delete/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a> $ac1";

            $row = array();
            $row[] = $no;
            $row[] = $customers->name;
            $row[] = $status;
			if(in_array("creditors_add",$this->data['user_permission_list'])){
                $row[] = $edit;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Creditors_model->count_all($id),
            "recordsFiltered" => $this->Creditors_model->count_all($id),
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
            //redirect('creditors');
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
      
        $update = $this->Creditors_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data ' . $sting . ' Successfully..');
        redirect('creditors/index/' . $lid);
    }
    // update profile for admin 

    function update($id) {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('creditors');
        }
        $data["lid"] = $this->uri->segment('4');
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $data["logged_company"]['id'];
        $data['location_list'] = $this->Creditors_model->select_location2($c_id);
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->form_validation->set_rules('l_id', 'Location Id', 'required');
        $this->form_validation->set_rules('creditorsname', 'Creditors Name', 'required');

        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array('   company_id' => $_SESSION['logged_company']['id'],
                'location_id' => $this->input->post('l_id'),
                'name' => $this->input->post('creditorsname')
            );

            $update = $this->Creditors_model->update($id, $data);
            //echo $this->db->last_query();die();
            if ($update) {
                $this->session->set_userdata('logged_company', $data);
            }
            $this->session->set_flashdata('success', 'Creditors Updated Successfully..');
            redirect('creditors/index/'.$this->uri->segment('4'));
        } else {
            $data['detail'] = $this->Creditors_model->select($id);
            $this->load->view('web/creditors_edit', $data);
        }
    }

    function delete($id) {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $lid = $this->uri->segment('4');
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('creditors');
        }
        $data = array('status' => '0');
        $update = $this->Creditors_model->update($id, $data);
        $this->session->set_flashdata('success', 'Creditors Delete Successfully..');
        redirect('creditors/index/'.$this->uri->segment('4'));
    }

}

?>