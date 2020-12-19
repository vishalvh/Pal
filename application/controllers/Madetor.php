<?php

class Madetor extends CI_Controller {

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
            $this->load->model('admin_model');
          if ($this->session->userdata('logged_company')['type'] == 'c') {
            $sesid = $this->session->userdata('logged_company')['id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        } else {
            $sesid = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        }
        $this->load->view('web/madetor/madetor_list', $data);
    }

    function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $data["logged_company"]['id'];
        $data['location_list'] = $this->Madetor_model->select_location2($c_id);
//print_r($data['location_list']);
//die();
        $this->form_validation->set_rules('madetorname', 'Madetor Name', 'required');
        $this->form_validation->set_rules('emailid', 'Email Name', 'required|callback_email_validation');
        $this->form_validation->set_rules('mobileno', 'Mobile No', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {
            //print_r($this->input->post('location'));

            $data = array('company_id' => $_SESSION['logged_company']['id'],
                'name' => $this->input->post('madetorname'),
                'email' => $this->input->post('emailid'),
                'mobile' => $this->input->post('mobileno'),
                'password' => $this->input->post('password'),
                'type' => 'm'
            );
            $insert_id = $this->Madetor_model->insert('sh_com_registration', $data);
            foreach ($this->input->post('location') as $location) {
//                print_r($location);
                $l_data = array("m_id" => $insert_id,
                    "l_id" => $location,
                );
                $this->db->insert('sh_madetor_l_id', $l_data);
            }
//           print_r($l_data);
//           die();
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
        $list = $this->Madetor_model->get_datatables($id,$extra);
//       echo $this->db->last_query();
        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];
        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {
            $no++;
            if ($customers->show == 0) {
                $msg_s_h = "Unblock";
                $status = '<span class="btn btn-danger">Block</span>';
            } else {
                $msg_s_h = "Block";
                $status = '<span class="btn btn-primary">Unblock</span>';
            }
            $ac1 = " <a href='" . $base_url . "madetor/show_hide/" . $customers->id . "/" . $customers->show . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'>$msg_s_h</a>";
            
            $edit = "<a class='luid' href='" . $base_url . "madetor/update/" . $customers->id . "/" . $extra. "'><i class='fa fa-edit'></i></a>  
			<a class='luid' href='" . $base_url . "madetor/delete/" . $customers->id . "/" . $extra. "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a> $ac1";
            $row = array();
            $row[] = $no;
            $row[] = $customers->name;
            $row[] = $customers->email;
            $row[] = $customers->mobile;
            $row[] = $status;
			if(in_array("moderator_action",$this->data['user_permission_list'])){
            $row[] = $edit;
			}
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Madetor_model->count_all($id,$extra),
            "recordsFiltered" => $this->Madetor_model->count_all($id,$extra),
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
            //redirect('oil_packet');
        }
        $this->load->model('wallet_model');
        $id = $this->uri->segment('3');
        $show = $this->uri->segment('4');
        $lid = $this->uri->segment('5');
        $data = array();
        if ($show == '1') {

            $sting = "Block";
            $data = array('show' => 0);
        } else {
            $sting = "Unblock";
            $data = array('show' => 1);
        }
      
        $update = $this->Madetor_model->update($id,$data);
      
//        echo $this->db->last_query();
        $this->session->set_flashdata('success', 'Madetor ' . $sting . ' Successfully..');
        redirect('madetor/index/' . $lid);
    }

    // update profile for admin 
	function updatepermission($id) {
		if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
		$this->load->model('Permission_model');
		$allpermissionlist = $this->Permission_model->getAllPermission();
		$getUserPermission = $this->Permission_model->getUserPermission($id);
		$data['getUserPermission'] = array();
		$data['allpermissionlist'] = array();
		foreach($allpermissionlist as $list){
			$data['allpermissionlist'][$list->type][] = $list;
		}
		foreach($getUserPermission as $permission){
			$data['getUserPermission'][] = $permission->permission;
		}
		/*echo "<pre>"; print_r($data['getUserPermission']); print_r($data['allpermissionlist']);*/
 		$data['id'] = $id;
		$this->load->view('web/madetor/madetor_permission', $data);
	}
	function savepermission($id){
		if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
		$this->load->model('Permission_model');
		$this->Permission_model->deleteAllpermissionByUser($id);
		$permission = $this->input->post('permission');
		foreach($permission as $data){
			$insertArray = array("permission"=>$data,"user_id"=>$id,"created_date_time"=>date('Y-m-d H:i:s'));
			$this->Permission_model->insertUserPerminssion($insertArray);
		}
		redirect('madetor/update/'.$id);
	}
    function update($id) {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $data["logged_company"]['id'];
        $data["lid"] = $this->uri->segment('4');
        $data["logged_company"] = $_SESSION['logged_company'];
        $data['location_list'] = $this->Madetor_model->select_location2($c_id);
        $data['slected_list'] = $this->Madetor_model->select_all('sh_madetor_l_id', array('status' => '1', 'm_id' => $id));
        $this->form_validation->set_rules('madetorname', 'Madetor Name', 'required');
        $this->form_validation->set_rules('emailid', 'Email id', 'required|callback_email_validation2');
        $this->form_validation->set_rules('mobileno', 'Mobile No', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == true) {
            $data = array('company_id' => $_SESSION['logged_company']['id'],
                'name' => $this->input->post('madetorname'),
                'email' => $this->input->post('emailid'),
                'mobile' => $this->input->post('mobileno'),
                'password' => $this->input->post('password')
            );

            $update = $this->Madetor_model->update($id, $data);
            $update_madetor = array("status" => 0);
            $update = $this->Madetor_model->update_madetor($id, $update_madetor);
            //echo $this->db->last_query();die();

            foreach ($this->input->post('location') as $location) {
//                print_r($location);
                $l_data = array("m_id" => $id,
                    "l_id" => $location,
                );
                $this->db->insert('sh_madetor_l_id', $l_data);
            }
            if ($update) {
                $this->session->set_userdata('logged_company', $data);
            }
            $this->session->set_flashdata('success', 'Updated Successfully..');
            redirect('madetor/index/'.$this->uri->segment('4'));
        } else {
            $data['detail'] = $this->Madetor_model->select($id);
            $this->load->view('web/madetor/madetor_edit', $data);
        }
    }

    function email_validation2($email) {

        $id = $this->input->post('id');

        $user = $this->Madetor_model->check_email1($email, $id);
//        echo $this->db->last_query();

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
        redirect('madetor/index/'.$this->uri->segment('4'));
    }

    function profile2() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->view('web/profile_madetor', $data);
    }

    function profile() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Madetor_login_model');
        $id = $_SESSION['logged_company']['u_id'];
//        print_r($id);
//        die();
        $c_id = $_SESSION['logged_company']['id'];
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

            $update = $this->Madetor_login_model->update_profile($id, $data);
//             echo $this->db->last_query();die();
            $data = $this->Madetor_login_model->select($id);
            $session_data = array(
                'id' => $data->company_id,
                'name' => $data->name,
                'email' => $data->email_id,
                'mobile' => $data->mobile_no,
                'type' => $data->type,
                'u_id' => $data->id
            );
            $this->session->set_userdata('logged_company', $session_data);


            $this->session->set_flashdata('update_profile', 'Your Profile Updated Successfully..');
            redirect('madetor/profile');
        } else {

            $this->load->view('web/profile', $data);
        }
    }

    function pro_email($email) {
        $this->load->model('Madetor_login_model');
        $id = $_SESSION['logged_company']['id'];
        $check = $this->Madetor_login_model->check_email1($email, $id);
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

        $this->load->model('Madetor_login_model');
        $this->form_validation->set_rules('old_pass', 'Password', 'required');
        $this->form_validation->set_rules('new_pass', 'New Password', 'required');
        $this->form_validation->set_rules('con_pass', 'Confirm Password', 'required');
        if ($this->form_validation->run() == true) {

            $ds = $this->Madetor_login_model->check_password($old_pass);

            if ($ds == 1) {
                $n_pass = $this->input->post('new_pass');
                $cpass = $this->input->post('con_pass');
                if ($n_pass == $cpass) {
                    $data = array(
                        'password' => $n_pass
                    );
                    $this->Madetor_login_model->update_pass($data);

                    $this->session->set_flashdata('update_pass', 'Password Changed successfully');
                    redirect('madetor_login/change_pass');
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