<?php

class Admin_location extends CI_Controller {
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

        $this->load->view('web/add_location', $data);
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('admin_location_model');
        $id = $_SESSION['logged_company']['id'];

        $extra = $this->input->get('extra');
        $list = $this->admin_location_model->get_datatables($extra, $id);

        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {

            $no++;
            $edit = "<a href='" . $base_url . "admin_location/upd_location/" . $customers->l_id . " '><i class='fa fa-edit'></i></a>  
			<a href='" . $base_url . "index.php/admin_location/loc_delete/" . $customers->l_id . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a>";
            $name = $customers->l_name;
            $name1 = ucfirst($name);
            $row = array();
            $row[] = $no;
            $row[] = $name1;
            $row[] = $customers->phone_no;
            $row[] = $customers->address;
            $row[] = ucwords($customers->show_hide);
            if(in_array("location_action",$this->data['user_permission_list'])){
                    	 $row[] = $edit;
                }  
           
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin_location_model->count_all($extra, $id),
            "recordsFiltered" => $this->admin_location_model->count_filtered($extra, $id),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
           // redirect('admin_location');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->view('web/insert_location', $data);
    }

    public function insert() {
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('admin_location');
        }
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        //$this->form_validation->set_rules('mobile','Phone Number','required');

        if ($this->form_validation->run()) {

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
                    $this->session->set_flashdata('fail', $error);
                    redirect('admin_location/add', 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $logo = $data2["upload_data"]["file_name"];
                }
            }
$xp_type = 'No';
if($this->input->post('xtrapremium') == "Yes"){
	$xp_type = 'Yes';
}
$xpp_type = 'No';
$xpd_type = 'No';
if($xp_type == 'Yes'){
	if($this->input->post('xpp_type') == "Yes"){
		$xpp_type = 'Yes';
	}
	if($this->input->post('xpD_type') == "Yes"){
		$xpd_type = 'Yes';
	}
}
            $data = array(
                'company_id' => $_SESSION['logged_company']['id'],
                'l_name' => $this->input->post('location'),
                'address' => $this->input->post('address'),
                'phone_no' => $this->input->post('mobile'),
                'dealar' => $this->input->post('dealar'),
                'gst' => $this->input->post('gst'),
                'logo' => $logo,
                'created_by' => date("Y-m-d H:i:sa"),
                'tin' => $this->input->post('tin'),
                'tank_type' => $this->input->post('tank_type'),
				'acno' => $this->input->post('acno'),
                'acname' => $this->input->post('acname'),
                'branchname' => $this->input->post('branchname'),
                'ifsccode' => $this->input->post('ifsccode'),
                'fcharge' => $this->input->post('fcharge'),
				'bankname' => $this->input->post('bankname'),
				'xp_type' => $xp_type,
				'xpd_type' => $xpd_type,
				'xpp_type' => $xpp_type
            );
            //print_r($data); die();
             $this->db->insert('sh_location', $data);
			$insid = $this->db->insert_id();
			$this->db->insert('sh_creditors', array('name'=>$this->input->post('dealar'),'location_id'=>$insid,'company_id'=>$_SESSION['logged_company']['id'],'type'=>'2'));
            $this->session->set_flashdata('success', 'Location Added Successfully..');

            redirect('admin_location/index');
        } else {
            $this->add();
        }
    }

    function loc_delete() {
         if($this->session->userdata('logged_company')['type'] != 'c'){
                    	//redirect('admin_location');
                }  
        $this->load->model('admin_location_model');
        $id = $this->uri->segment('3');
        $sess_id = $this->session->userdata('id');
        $data = array(
            'deleted_by' => $sess_id,
            'status' => '0'
        );
        $this->admin_location_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'Data Deleted Successfully..');
        redirect('admin_location/index');
    }

    function upd_location() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
            if($this->session->userdata('logged_company')['type'] != 'c'){
                    	//redirect('admin_location');
                }  
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('admin_location_model');
        $id = $this->input->post('id');

        $data["id"] = $this->uri->segment('3');
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('mobile', 'Phone Number', 'required');


        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
			$xp_type = 'No';
if($this->input->post('xtrapremium') == "Yes"){
	$xp_type = 'Yes';
}
$xpp_type = 'No';
$xpd_type = 'No';
if($xp_type == 'Yes'){
	if($this->input->post('xpp_type') == "Yes"){
		$xpp_type = 'Yes';
	}
	if($this->input->post('xpd_type') == "Yes"){
		$xpd_type = 'Yes';
	}
}
            $data = array(
                'l_name' => $this->input->post('location'),
                'address' => $this->input->post('address'),
                'phone_no' => $this->input->post('mobile'),
                'updated_by' => date('Y-m-d H:i:sa'),
                'dealar' => $this->input->post('dealar'),
                'gst' => $this->input->post('gst'),
                'tin' => $this->input->post('tin'),
                'tank_type' => $this->input->post('tank_type'),
				'acno' => $this->input->post('acno'),
                'acname' => $this->input->post('acname'),
                'branchname' => $this->input->post('branchname'),
                'ifsccode' => $this->input->post('ifsccode'),
                'fcharge' => $this->input->post('fcharge'),
				'bankname' => $this->input->post('bankname'),
				'show_hide' => $this->input->post('show_hide'),
				'xp_type' => $xp_type,
				'xpd_type' => $xpd_type,
				'xpp_type' => $xpp_type
            );
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
                    $this->session->set_flashdata('fail', $error);
                    redirect('admin_location/add', 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $data['logo'] = $data2["upload_data"]["file_name"];
                }
            }
			
			
            $update = $this->admin_location_model->update($id, $data);
			
            $this->session->set_flashdata('success_update', 'Data Updated Successfully..');
            redirect('admin_location/index');
        } else {

            $id = $this->uri->segment('3');
            if ($id == "") {
                $id = $this->input->post('id');
            }
            $query = $this->db->get_where("sh_location", array("l_id" => $id));
            $data['r'] = $query->row();

            $this->load->view('web/edit_location', $data);
        }

        // $this->load->view('web/edit_location.php');
    }

}

?>