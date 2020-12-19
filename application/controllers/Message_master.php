<?php

class Message_master extends CI_Controller {

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
        }else{
			redirect('company_login');
		}
			$this->load->model('message_master_model');
    }

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
        $this->load->view('web/send_messages_list', $data);
    }

    function add() {
        $id1 = $_SESSION['logged_company']['id'];
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->view('web/send_messages_add', $data);
    }
	public function sendcustomermessage($locationId){
		$message = $this->input->post('message');
		$lists = $this->message_master_model->sendcustomermessage($locationId);
		foreach($lists as $list){
			$inserArray = array("company_id"=>$list->company_id,
			"mobile_number"=>$list->phone_no,
			"type"=>"Customer",
			"message"=>$message,
			"location_id"=>$locationId,
			"created_date_time"=>date('Y-m-d H:i:d')
			);
			$this->message_master_model->insert($inserArray);
		}
	}
	public function sendworkermessage($locationId){
		$message = $this->input->post('message');
		$lists = $this->message_master_model->sendworkermessage($locationId);
		foreach($lists as $list){
			$inserArray = array("company_id"=>$list->company_id,
			"mobile_number"=>$list->mobile,
			"type"=>"Worker",
			"message"=>$message,
			"location_id"=>$locationId,
			"created_date_time"=>date('Y-m-d H:i:d')
			);
			$this->message_master_model->insert($inserArray);
		}
		
	}
	public function sendemployeemessage($locationId){
		$message = $this->input->post('message');
		$lists = $this->message_master_model->sendemployeemessage($locationId);
		foreach($lists as $list){
			$inserArray = array("company_id"=>$list->company_id,
			"mobile_number"=>$list->UserMNumber,
			"type"=>"Employee",
			"message"=>$message,
			"location_id"=>$locationId,
			"created_date_time"=>date('Y-m-d H:i:d')
			);
			$this->message_master_model->insert($inserArray);
		}
	}
    public function insert() {
		date_default_timezone_set('Asia/Kolkata');
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('user', 'User Type', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        if ($this->form_validation->run()) {
			if($this->input->post('user') == "Customer"){
				$this->sendcustomermessage($this->input->post('location'));
			}
			if($this->input->post('user') == "Worker"){
				$this->sendworkermessage($this->input->post('location'));
			}
			if($this->input->post('user') == "Employee"){
				$this->sendemployeemessage($this->input->post('location'));
			}
			redirect('message_master');
        }else{
			 $this->add();
		}
    }

    public function ajax_list() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $id = $_SESSION['logged_company']['id'];
		
		$location = $this->input->get('location');
		$type = $this->input->get('type');
		$mobile = $this->input->get('mobile');
		
        $list = $this->message_master_model->get_datatables($id,$location,$type,$mobile);
		$data = array();
        $base_url = base_url();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            $row = array();
            $row[] = ++$no;
            $row[] = $customers->mobile_number;
            $row[] = $customers->location;
            $row[] = $customers->type;
            $row[] = $customers->msg_status;
           // $row[] = $customers->message;
			
            $row[] = date('d-m-Y h:i A',strtotime($customers->created_date_time));
			if($customers->sending_date_time != ""){
				$row[] = date('d-m-Y h:i A',strtotime($customers->sending_date_time));
			}else{
				$row[] = "";
			}
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->message_master_model->count_all($id,$location,$type,$mobile),
            "recordsFiltered" => $this->message_master_model->count_filtered($id,$location,$type,$mobile),
            "data" => $data,
        );
        echo json_encode($output);
    }
}

?>