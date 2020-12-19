<?php
class Wallet extends CI_Controller {
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
    public function index() {
        if(!$this->session->userdata('logged_company')){
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
        $this->load->view('web/wallet_list', $data);
    }
    public function ajax_list(){
        
		$this->load->model('wallet_model');
        $logged_company = $data["logged_company"] = $_SESSION['logged_company'];
        $id = $_SESSION['logged_company']['id'];
        $extra = $this->input->get('extra');
        $list = $this->wallet_model->get_datatables($extra, $id);
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
            $ac1 = " <a href='" . $base_url . "wallet/show_hide/" . $customers->id . "/" . $customers->show . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'>$msg_s_h</a>";
            $edit = "<a href='".$base_url."wallet/edit/".$customers->id."/" . $extra . "'><i class='fa fa-edit'></i></a>
			<a href='".$base_url."wallet/delete/".$customers->id."/" . $extra . "' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a> $ac1";
			$tank_name = ucfirst($customers->name);
            $row = array();
            $row[] = $no;
            $row[] = $tank_name;
            $row[] = $customers->l_name;
            $row[] = $status;
			if(in_array("wallet_action",$this->data['user_permission_list'])){
			$row[] = $edit;
			}
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->wallet_model->count_all($extra, $id),
            "recordsFiltered" => $this->wallet_model->count_filtered($extra, $id),
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

            $sting = "hide";
            $data = array('show' => 0);
        } else {
            $sting = "show";
            $data = array('show' => 1);
        }
      
        $update = $this->wallet_model->update("sh_wallet_list" ,$data, array("id"=>$id));
      
//        echo $this->db->last_query();
        $this->session->set_flashdata('success', 'Data ' . $sting . ' Successfully..');
        redirect('wallet/index/' . $lid);
    }
        
	public function add() {
		if (!$this->session->userdata('logged_company')) {
			redirect('company_login');
		}
		if ($this->session->userdata('logged_company')['type'] != 'c') {
			//redirect('admin');
		}
		$data["logged_company"] = $_SESSION['logged_company'];
		$id1 = $_SESSION['logged_company']['id'];
		$this->load->model('wallet_model');
		$data['r'] = $this->wallet_model->select_location2($id1);
		$this->load->view('web/wallet_add', $data);
	}

	public function edit(){
		if (!$this->session->userdata('logged_company')) {
			redirect('company_login');
		}
		if ($this->session->userdata('logged_company')['type'] != 'c') {
			//redirect('admin');
		}
		$data["logged_company"] = $_SESSION['logged_company'];
		$id1 = $_SESSION['logged_company']['id'];
		$this->load->model('wallet_model');
		$data['r'] = $this->wallet_model->select_location2($id1);
		$data['tank'] = $this->wallet_model->select('*',"sh_wallet_list",array('id'=>$this->uri->segment(3),'status'=>'1'),'');
		$this->load->view('web/wallet_edit', $data);
	}

    public function add_wallet(){
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('wallet_model');
        if($this->session->userdata('logged_company')['type'] == 'c'){
			$id = $this->session->userdata('logged_company')['id'];
        }
        if($this->session->userdata('logged_company')['type'] == 'm'){
			$id = $this->session->userdata('logged_company')['u_id'];
		}       
        $this->form_validation->set_rules('tank_name', 'Name', 'required');
        $this->form_validation->set_rules('tank_location', 'Location', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array(
                'company_id' => $id,
				'name' => $this->input->post('tank_name'),
                'location_id' => $this->input->post('tank_location'),
				'created_on' => date('Y-m-d H:i:sa')
            );
			
			if (!empty($_FILES['img']['name'])) {
                $_FILES['file']['name'] = time() . $_FILES['img']['name'];
                $_FILES['file']['type'] = $_FILES['img']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['img']['error'];
                $_FILES['file']['size'] = $_FILES['img']['size'];
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['upload_path'] = './uploads/';
                $config['name'] = time() . $_FILES['img']['name'];
                $config['file_name'] = time() . $_FILES['img']['name'];
                $config['file_name'] = str_replace(' ', '_', $config['file_name']);
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('img')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('fail', $error);
                    redirect('wallet/add', 'refresh');
                } else {
                    $data2 = array('upload_data' => $this->upload->data());
                    $data['img'] = $data2["upload_data"]["file_name"];
                }
            }
			//print_r($data); die();
            $insert_id = $this->wallet_model->insert("sh_wallet_list",$data);
            $this->session->set_flashdata('success', 'Your Wallet Added Successfully.');      
            redirect('wallet');
        }else{
            $this->load->view('web/wallet_add', $data);
        }
    }

    public function update_wallet(){
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["lid"] = $this->uri->segment('3');
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('wallet_model');
        if($this->session->userdata('logged_company')['type'] == 'c'){
			$id = $this->session->userdata('logged_company')['id'];
        }
        if($this->session->userdata('logged_company')['type'] == 'm'){
			$id = $this->session->userdata('logged_company')['u_id'];
		}       
        $this->form_validation->set_rules('tank_name', 'Tank Name', 'required');
        $this->form_validation->set_rules('tank_location', 'Tank Location', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('tank_name'),
                'location_id' => $this->input->post('tank_location')
            );
			if (!empty($_FILES['img']['name'])) {
                $_FILES['file']['name'] = time() . $_FILES['img']['name'];
                $_FILES['file']['type'] = $_FILES['img']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['img']['error'];
                $_FILES['file']['size'] = $_FILES['img']['size'];
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['upload_path'] = './uploads/';
                $config['name'] = time() . $_FILES['img']['name'];
                $config['file_name'] = time() . $_FILES['img']['name'];
                $config['file_name'] = str_replace(' ', '_', $config['file_name']);
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('img')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('fail', $error);
                    redirect('wallet/add', 'refresh');
                } else {
                    $data2 = array('upload_data' => $this->upload->data());
                    $data['img'] = $data2["upload_data"]["file_name"];
                }
            }
            $insert_id = $this->wallet_model->update("sh_wallet_list",$data,array("id"=>$this->input->post('id'),"status"=>1));
			
            $this->session->set_flashdata('success', 'Your Wallet updated Successfully.');      
			
            redirect('wallet/index/'.$this->uri->segment('3'));
        }else{
			$data['r'] = $this->wallet_model->select('*',"sh_location",array('company_id'=>$id,'status'=>'1'),'"l_name","asc"');
			$data['tank'] = $this->wallet_model->select('*',"sh_wallet_list",array('id'=>$this->uri->segment(3),'status'=>'1'),'');
            $this->load->view('web/wallet_edit', $data);
        }
    }

	public function delete(){
		if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('wallet_model');
        date_default_timezone_set('Asia/Kolkata');
		$this->wallet_model->update("sh_wallet_list",array("status"=>0),array("id"=>$this->uri->segment(3)));
		$this->session->set_flashdata('success', "Your Wallet Deleted Successfully.");
		redirect('wallet/index/'.$this->uri->segment('4'));
	}
}
?>