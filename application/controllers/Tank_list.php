<?php

class Tank_list extends CI_Controller {
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
        }$this->load->model('admin_model');
        $data["logged_company"] = $_SESSION['logged_company'];
		$this->load->model('tank_model');
                 $data['h'] = $this->admin_model->select();
        $data["logged_company"] = $_SESSION['logged_company'];

        $id1 = $_SESSION['logged_company']['id'];
        
       
        $data['r'] = $this->admin_model->select_location($id1);
		// $data["tanks"] = $this->tank_model->selectetanks();
        $this->load->view('web/tank_list', $data);
    }

    public function ajax_list(){
        if(!$this->session->userdata('logged_company')){
            redirect('company_login');
        }
		$this->load->model('tank_model');
        $logged_company = $data["logged_company"] = $_SESSION['logged_company'];
        $id = $_SESSION['logged_company']['id'];
        $extra = $this->input->get('extra');
        $list = $this->tank_model->get_datatables($extra, $id);
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
			$ac1 = " <a href='" . $base_url . "tank_list/show_hide?id=" . $customers->id . "&type=" . $customers->show . "&lid=" . $extra . "' >$msg_s_h</a>";
            $edit = "<a href='".$base_url."tank_list/edit/".$customers->id."/" . $extra . "'><i class='fa fa-edit'></i></a>
			<a href='".$base_url."tank_list/delete/".$customers->id."/" . $extra . "' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>".$ac1;
			//$tank_name = "<a href='".$base_url."tank_list/chart/".$customers->id."'>".ucfirst($customers->tank_name)."</a>";
			$tank_name = "<a href='".$base_url."dip_chart/index/".$customers->id."'>".ucfirst($customers->tank_name)."</a>";
            $row = array();
            $row[] = $no;
            $row[] = $tank_name;
            $row[] = $customers->tank_type;
            $row[] = $customers->l_name;
			
			if($customers->fuel_type == "p"){
				$row[] = "Petrol";
			}else if($customers->fuel_type == "d"){
				$row[] = "Diesel";
			}else{
				$row[] = "";
			}
			$row[] = $status;
            if(in_array("tank_action",$this->data['user_permission_list'])){
                $row[] = $edit;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tank_model->count_all($extra, $id),
            "recordsFiltered" => $this->tank_model->count_filtered($extra, $id),
            "data" => $data,
        );
        echo json_encode($output);
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
		$this->load->model('tank_model');
		$data['r'] = $this->tank_model->select_location2($id1);
		$this->load->view('web/tank_add', $data);
	}

	public function edit(){
		if (!$this->session->userdata('logged_company')) {
			redirect('company_login');
		}
		if ($this->session->userdata('logged_company')['type'] != 'c') {
			//redirect('admin');
		}
		$data["logged_company"] = $_SESSION['logged_company'];
                $data["lid"] = $this->uri->segment('4');
		$id1 = $_SESSION['logged_company']['id'];
		$this->load->model('tank_model');
		$data['r'] = $this->tank_model->select_location2($id1);
		$data['tank'] = $this->tank_model->select('*',"sh_tank_list",array('id'=>$this->uri->segment(3),'status'=>'1'),'');
		$this->load->view('web/tank_edit', $data);
	}

    public function add_tank(){
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('tank_model');
        if($this->session->userdata('logged_company')['type'] == 'c'){
			$id = $this->session->userdata('logged_company')['id'];
        }
        if($this->session->userdata('logged_company')['type'] == 'm'){
			$id = $this->session->userdata('logged_company')['u_id'];
		}       
        $this->form_validation->set_rules('tank_name', 'Tank Name', 'required');
        $this->form_validation->set_rules('tank_type', 'Tank Type', 'required');
        $this->form_validation->set_rules('tank_location', 'Tank Location', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
			$xp_type = 'No';
if($this->input->post('xtrapremium') == "Yes"){
	$xp_type = 'Yes';
}
            $data = array(
                'company_id' => $id,
				'tank_name' => $this->input->post('tank_name'),
                'tank_type' => $this->input->post('tank_type'),
                'location_id' => $this->input->post('tank_location'),
				'fuel_type' => $this->input->post('pump_type'),
                'created_on' => date('Y-m-d H:i:sa'),
				'xp_type' => $xp_type
            );
            $insert_id = $this->tank_model->insert("sh_tank_list",$data);
            $this->session->set_flashdata('success', 'Your Tank Added Successfully.');      
            redirect('tank_list/index');
        }else{
            $this->load->view('web/tank_add', $data);
        }
    }

    public function update_tank(){
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('tank_model');
        if($this->session->userdata('logged_company')['type'] == 'c'){
			$id = $this->session->userdata('logged_company')['id'];
        }
        if($this->session->userdata('logged_company')['type'] == 'm'){
			$id = $this->session->userdata('logged_company')['u_id'];
		}       
        $this->form_validation->set_rules('tank_name', 'Tank Name', 'required');
        $this->form_validation->set_rules('tank_type', 'Tank Type', 'required');
        $this->form_validation->set_rules('tank_location', 'Tank Location', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
			$xp_type = 'No';
if($this->input->post('xtrapremium') == "Yes"){
	$xp_type = 'Yes';
}
            $data = array(
                'tank_name' => $this->input->post('tank_name'),
                'tank_type' => $this->input->post('tank_type'),
                'location_id' => $this->input->post('tank_location'),
				'fuel_type' => $this->input->post('pump_type'),
                'updated_on' => date('Y-m-d H:i:sa'),
				'xp_type' => $xp_type
            );
            $insert_id = $this->tank_model->update("sh_tank_list",$data,array("id"=>$this->input->post('id'),"status"=>1));
            $this->session->set_flashdata('success', 'Your Tank updated Successfully.');      
            redirect('tank_list/index/'.$this->uri->segment(3));
        }else{
			$data['r'] = $this->tank_model->select('*',"sh_location",array('company_id'=>$id,'status'=>'1'),'"l_name","asc"');
			$data['tank'] = $this->tank_model->select('*',"sh_tank_list",array('id'=>$this->uri->segment(3),'status'=>'1'),'');
            $this->load->view('web/tank_edit', $data);
        }
    }

	public function delete(){
		if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('tank_model');
        $id = $this->uri->segment(4);
        date_default_timezone_set('Asia/Kolkata');
		$this->tank_model->update("sh_tank_list",array("status"=>0,"deleted_on"=>date("Y-m-d H:i:s")),array("id"=>$this->uri->segment(3)));
		$this->tank_model->update("sh_tank_chart",array("status"=>0,"deleted_on"=>date("Y-m-d H:i:s")),array("tank_id"=>$this->uri->segment(3)));
		$this->session->set_flashdata('success', "Your Tank and it's charts Deleted Successfully.");
		redirect('tank_list/index/'.$id);
	}

	public function chart(){
		$tank_id = $this->uri->segment(3);
		if(!$this->session->userdata('logged_company')){
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
		$this->load->model('tank_chart_model');
		$data['chart'] = $this->tank_chart_model->selecttanks($tank_id);
		//echo $this->db->last_query(); die();
		$data['id'] = $this->uri->segment(3);
        $this->load->view('web/tank_chart_list', $data);
	}

    public function ajax_list1(){
        if(!$this->session->userdata('logged_company')){
            redirect('company_login');
        }
		$this->load->model('tank_chart_model');
        $logged_company = $data["logged_company"] = $_SESSION['logged_company'];
        $id = $_SESSION['logged_company']['id'];
		$tid = $this->uri->segment(3);
        $extra = $this->input->get('extra');
        $list = $this->tank_chart_model->get_datatables($tid,$extra, $id);
        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];
        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {
            $no++;
            $edit = "<a href='#' onclick='edit(".$customers->id.",".$customers->reading.",".$customers->volume.")'><i class='fa fa-edit'></i></a>
			<a href='".$base_url."tank_list/chartdelete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($customers->tank_name);
            $row[] = $customers->reading;
            $row[] = $customers->volume;
            if ($logged_company['type'] == 'c') {
                $row[] = $edit;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tank_chart_model->count_all($tid,$extra, $id),
            "recordsFiltered" => $this->tank_chart_model->count_filtered($tid,$extra, $id),
            "data" => $data,
        );
        echo json_encode($output);
    }

	public function add_update_chart(){
		if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('tank_model');
		$this->load->model('tank_chart_model');
        $this->form_validation->set_rules('reading', 'Tank Reading', 'required');
        $this->form_validation->set_rules('volume', 'Tank Volume', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if($this->form_validation->run() == true){
			if($this->uri->segment(4) != ""){
				$data = array(
					'tank_id' => $this->uri->segment(3),
					'reading' => $this->input->post('reading'),
					'volume' => $this->input->post('volume'),
					'updated_on' => date('Y-m-d H:i:sa')
				);
				$insert_id = $this->tank_model->update("sh_tank_chart",$data,array("id"=>$this->uri->segment(4)));
				$this->session->set_flashdata('success', 'Your Tank Chart Updated Successfully.');      
				// redirect('tank_list/chart/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
			}else{
				$data = array(
					'tank_id' => $this->uri->segment(3),
					'reading' => $this->input->post('reading'),
					'volume' => $this->input->post('volume'),
					'created_on' => date('Y-m-d H:i:sa')
				);
				$insert_id = $this->tank_model->insert("sh_tank_chart",$data);
				$this->session->set_flashdata('success', 'Your Tank Chart Added Successfully.');
				// redirect('tank_list/chart/'.$this->uri->segment(3));
			}
			$data['chart'] = $this->tank_chart_model->selecttanks($this->uri->segment(3));
			$data['id'] = $this->uri->segment(3);
			return $this->load->view('web/append',$data);
        }else{
            redirect('tank_list/chart/'.$this->uri->segment(3));
        }
	}

	public function chartdelete(){
		if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('tank_model');
        date_default_timezone_set('Asia/Kolkata');
		$this->tank_model->update("sh_tank_chart",array("status"=>0,"deleted_on"=>date("Y-m-d H:i:s")),array("id"=>$this->uri->segment(3)));
		$this->session->set_flashdata('success', 'Your Tank Chart Deleted Successfully.');      
		//redirect('tank_list/chart/'.$this->uri->segment(4));
		redirect('dip_chart/index/'.$this->uri->segment(4));
	}

	public function demo(){
		$this->load->model('tank_model');
		$dip_reading = $this->tank_model->select('*',"sh_tank_chart",array('tank_id'=>"30",'status'=>'1'),array('reading','asc'));
		echo "<pre>";
		//print_r($dip_reading); die();
		foreach($dip_reading as $d){
			
			$data = array(
					'tank_id' => 32,
					'reading' => $d->reading,
					'volume' => $d->volume,
					'created_on' => date('Y-m-d H:i:s')
				);
				print_r($data); 
				$insert_id = $this->tank_model->insert("sh_tank_chart",$data);
				echo $this->db->last_query();
		}
			/*$id = $d->id+1;
			$dip = $this->tank_model->select('*',"sh_tank_dep_reding",array('tanktype'=>"15",'status'=>'1','id'=>$id),'');
			for($i=0;$i<5;$i++){
				$extracol = $dip[0]->extra_col*$i;
				echo $dip[0]->extracol;
				$reading = $d->cm+($i/10);
				$volume = $d->Ltrs+$extracol;
				$data = array(
					'tank_id' => 1,
					'reading' => $reading,
					'volume' => $volume,
					'created_on' => date('Y-m-d H:i:sa')
				);
				print_r($data);
				$insert_id = $this->tank_model->insert("sh_tank_chart_copy_01-09",$data);
				if($reading == 200){
					break;
				}
			}
			
				if($reading == 200){
					exit;
				}
		}*/
	}
	public function show_hide() {
        ini_set('display_errors', '-1');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('tank_list');
        }
        $id = $this->input->get('id');
        $show = $this->input->get('type');
        $lid = $this->input->get('lid');
        $data = array();
		if($this->input->get('sdate') != "" || $this->input->get('edate') != "" || $show == '0'){
        if ($show == '1') {
            $sting = "hide";
			$mobile = NULL;
			$web = NULL;
			if($this->input->get('mobilehide') == '0'){ $mobile = '0'; }
			if($this->input->get('webhide') == '0'){ $web = '0'; }
            $data = array('show' => 0,'start_to'=>date('Y-m-d',strtotime($this->input->get('sdate'))),'end_to'=>date('Y-m-d',strtotime($this->input->get('edate'))),'mobile_show'=>$mobile,'web_show'=>$web);
        } else {
            $sting = "show";
            $data = array('show' => 1,'start_to'=>NULL,'end_to'=>NULL,'mobile_show'=>NULL,'web_show'=>NULL);
        }
		$this->load->model('tank_model');
		
        $insert_id = $this->tank_model->update("sh_tank_list",$data,array("id"=>$this->input->get('id')));
        //echo $this->db->last_query();
		//print_r($data); die();
        $this->session->set_flashdata('success', 'Data ' . $sting . ' Successfully..');
        redirect('tank_list/index/' . $lid);
		}else{
			$data['id'] = $id;
			$data['type'] = $show;
			$data['lid'] = $lid;
			$data['date'] = date('d-m-Y');
			$this->load->view('web/tank_hide',$data);
		}
    }
	
}
?>