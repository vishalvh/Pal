<?php

class Reset_pump extends CI_Controller
{
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
	function index()
	{
		if(!$this->session->userdata('logged_company')){
			redirect('company_login');
		}
                $this->load->model('admin_model');
          if ($this->session->userdata('logged_company')['type'] == 'c') {
            $sesid = $this->session->userdata('logged_company')['id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        } else {
            $sesid = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        }
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->view('web/reset_pump',$data);
	}

	public function ajax_list(){
		if(!$this->session->userdata('logged_company')){
			redirect('company_login');
		}
		$data["logged_company"] = $_SESSION['logged_company'];
   		$this->load->model('reset_pump_model');
		$id = $_SESSION['logged_company']['id'];
		$extra = $this->input->get('extra');
		$list = $this->reset_pump_model->get_datatables($extra,$id);
		$data = array();
		$base_url = base_url();
		$no = $_POST['start'];
		$msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) {
			if ($customers->type == "d") {
				$type = "Disel";
			}else if ($customers->type == "p") {
				$type = "Petrol";
			}
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $customers->date;
			$row[] = $customers->name;
			$row[] = $customers->reading;
			$row[] = $customers->l_name;
			$row[] = $type;
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->reset_pump_model->count_all($extra,$id),
			"recordsFiltered" => $this->reset_pump_model->count_all($extra,$id),
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function add(){
		if(!$this->session->userdata('logged_company')){
			redirect('company_login');
		}
		if($this->session->userdata('logged_company')['type'] != 'c'){
			//redirect('reset_pump');
		}      
		$data["logged_company"] = $_SESSION['logged_company'];
		$id1 =  $_SESSION['logged_company']['id'];
		$this->load->model('reset_pump_model');
		$data['r'] = $this->reset_pump_model->select_location($id1);
   		$this->load->view('web/reset_pump_insert',$data);
	}
	public function insert(){
		if(!$this->session->userdata('logged_company')){
			redirect('company_login');
		}
        if($this->session->userdata('logged_company')['type'] != 'c'){
			//redirect('reset_pump');
		} 
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->form_validation->set_rules('date','Date Name','required');
		$this->form_validation->set_rules('pumplist','Pump Name','required');
		$this->form_validation->set_rules('reading','reading Name','required');
		if($this->form_validation->run() == true){
			date_default_timezone_set('Asia/Kolkata');
			$data = array(
				'date' => date('Y-m-d',strtotime($this->input->post('date'))),  
				'pump_id' => $this->input->post('pumplist'), 
				'user_id' => $_SESSION['logged_company']['id'],
				'created_at' => date("Y-m-d H:i:sa"),
				'company_id' => $_SESSION['logged_company']['id'],
				'reading' => $this->input->post('reading')
            );
			$this->db->insert('sh_reset_pump',$data);
			// echo $this->db->last_query();die();
			$this->session->set_flashdata('success','Data Added Successfully');
			redirect('reset_pump');
      }else{
		$this->add(); 
      }
	}
    function pump_delete(){
		if(!$this->session->userdata('logged_company')){
			redirect('company_login');
		}
		if($this->session->userdata('logged_company')['type'] != 'c'){
			//redirect('reset_pump');
		} 
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->model('reset_pump_model');
		$id = $this->uri->segment('3');
		$sess_id = $_SESSION['logged_company']['id'];
		date_default_timezone_set('Asia/Kolkata');
		$data = array(
			'delete_at' => date("Y-m-d H:i:sa"),
			'status' => '0'
            );
		$this->reset_pump_model->delete($id,$data);
		$this->session->set_flashdata('fail','Data Deleted Successfully..');
		redirect('reset_pump');
    }
    function upd_pump(){
		if(!$this->session->userdata('logged_company')){
			redirect('company_login');
		}
        if($this->session->userdata('logged_company')['type'] != 'c'){
			//redirect('reset_pump');
		} 
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->model('reset_pump_model');
		$id = $this->uri->segment('3');
		$data["id"] = $this->uri->segment('3');
		$data["pump"] =  $this->reset_pump_model->select_pumpby_id($id);
		// echo $this->db->last_query();die();
		// print_r($data["pump"]);die(); 
		$this->form_validation->set_rules('pump','pump','required');
		date_default_timezone_set('Asia/Kolkata');
		if($this->form_validation->run() == true){
			$data = array(
				'location_id' => $this->input->post('sel_loc'),
				'name' => $this->input->post('pump'),
				'update_at' => date('Y-m-d H:i:sa'),
				'type' => $this->input->post('pump_type'),
				'tank_id' => $this->input->post('tank_list')
            );
            $update = $this->reset_pump_model->update($id,$data);
			$this->session->set_flashdata('success_update','Data Updated Successfully..');
			redirect('reset_pump/index');
		}else{
			$id = $this->uri->segment('3');
			if($id == ""){
				$id = $this->input->post('id');
			}
			$query = $this->db->get_where("shpump",array("id"=>$id));
			$data['r'] = $query->row();
			$this->load->model('admin_model');
			$id1 =  $_SESSION['logged_company']['id'];
			$data['r1'] = $this->admin_model->select_location($id1);
			$data['tanklist'] = $this->reset_pump_model->get_tbl_list('sh_tank_list',array('status'=>'1','location_id'=>$data['r']->location_id,'fuel_type'=>$data['r']->type),array('tank_name','asc'));
			$this->load->view('web/pump_edit',$data);
		}
    }
	function pump_list(){
		$location = $this->input->post('lid');
		$this->load->model('reset_pump_model');
		$list = $this->reset_pump_model->get_tbl_list('shpump',array('type !='=>'o','status'=>'1','location_id'=>$location),array('name','asc'));
		$html = '<option value="">Select Pump</option>';
		foreach($list as $tank){
			
			if($tank->type == 'p'){
				$type = 'Petrol';
			}else{
				$type = 'Diesel';
			}
			$html .= '<option value="'.$tank->id.'">'.$tank->name.'('.$type.')</option>';
		}
		echo $html;
	}
}

?>