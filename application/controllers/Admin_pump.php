<?php

class Admin_pump extends CI_Controller
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
    if(!$this->session->userdata('logged_company'))
    {
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
        $this->load->view('web/view_pump',$data);
	}

	public function ajax_list()
   	{
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
          
    $data["logged_company"] = $_SESSION['logged_company'];

   		$this->load->model('Adminpump_model');
      $id = $_SESSION['logged_company']['id'];
		  $extra = $this->input->get('extra');
      $list = $this->Adminpump_model->get_datatables($extra,$id);

      $data = array();
		  $base_url = base_url();
      $no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) 
       	{
			if ($customers->show == 0) {
                $msg_s_h = "Show";
                $status = '<span class="btn btn-danger">Hide</span>';
            } else {
                $msg_s_h = "Hide";
                $status = '<span class="btn btn-primary">Show</span>';
            }
          if ($customers->type == "d") {
            $type = "Disel";
          }
          else if ($customers->type == "p") {
            $type = "Petrol";
          }

        	$no++;
			$ac1 = " <a href='" . $base_url . "admin_pump/show_hide?id=" . $customers->id . "&type=" . $customers->show . "&lid=" . $extra . "' >$msg_s_h</a>";
			$edit = "<a href='".$base_url."admin_pump/upd_pump/".$customers->id."/" . $extra . "'><i class='fa fa-edit'></i></a>  
			<a href='".$base_url."index.php/admin_pump/pump_delete/".$customers->id."/" . $extra . "' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a> ".$ac1;
			// $name = $customers->company_name;
			// $name1 = ucfirst($name);
           $row = array();
           $row[] = $no;
           // $row[] = $name1;
           $row[] = $customers->name;
           $row[] = $customers->l_name;
           $row[] = $type;
		   $row[] = $customers->nozzel_code;
		   $row[] = $status;
           if(in_array("pump_action",$this->data['user_permission_list'])){
                    	 $row[] = $edit;
                }
           $data[] = $row;
       
	}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->Adminpump_model->count_all($extra,$id),
                       "recordsFiltered" => $this->Adminpump_model->count_all($extra,$id),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }

   // Instert Page

   public function add()
   {
      if(!$this->session->userdata('logged_company'))
      {
        redirect('company_login');
      }
         if($this->session->userdata('logged_company')['type'] != 'c'){
                    	//redirect('admin_pump');
                }      
      $data["logged_company"] = $_SESSION['logged_company'];
      $id1 =  $_SESSION['logged_company']['id'];
      $this->load->model('Adminpump_model');
      $data['r'] = $this->Adminpump_model->select_location($id1);
      //echo $this->db->last_Query();

   		$this->load->view('web/pump_insert',$data);
   }

   public function insert()
    {
      if(!$this->session->userdata('logged_company'))
      {
        redirect('company_login');
      }
        if($this->session->userdata('logged_company')['type'] != 'c'){
                    	//redirect('admin_pump');
                } 
      $data["logged_company"] = $_SESSION['logged_company'];
      
      $this->form_validation->set_rules('pump','Pump Name','required');
      
      if($this->form_validation->run() == true)
      {
        date_default_timezone_set('Asia/Kolkata');
		$xp_type = 'No';
if($this->input->post('xtrapremium') == "Yes"){
	$xp_type = 'Yes';
}
        $data = array(
              'location_id' => $this->input->post('sel_loc'),
              'company_id' => $_SESSION['logged_company']['id'],  
              'name' => $this->input->post('pump'), 
              'type' => $this->input->post('pump_type'),
              'nozzel_code' => $this->input->post('nozzel_code'),
              'created_at' => date("Y-m-d H:i:sa"),
              'tank_id' => $this->input->post('tank_list'),
			  'xp_type' => $xp_type
            );

        $this->db->insert('shpump',$data);
        // echo $this->db->last_query();die();
        $this->session->set_flashdata('success','Data Added Successfully');
        
        redirect('admin_pump');
      }
      else
      {
        $this->add(); 
      }

    }
    function pump_delete()
    {
      if(!$this->session->userdata('logged_company'))
      {
        redirect('company_login');
      }
        if($this->session->userdata('logged_company')['type'] != 'c'){
                    	//redirect('admin_pump');
                } 
      $data["logged_company"] = $_SESSION['logged_company'];

      $this->load->model('Adminpump_model');
      $id = $this->uri->segment('3');
      $lid = $this->uri->segment('4');
      $sess_id = $_SESSION['logged_company']['id'];
      date_default_timezone_set('Asia/Kolkata');
      $data = array(
              'delete_at' => date("Y-m-d H:i:sa"),
              'status' => '0'
            );
      $this->Adminpump_model->delete($id,$data);
      $this->session->set_flashdata('fail','Data Deleted Successfully..');
      redirect('admin_pump/index/'.$lid);
    }

    function upd_pump()
    {
      if(!$this->session->userdata('logged_company'))
      {
        redirect('company_login');
      }
       $lid = $this->uri->segment('4');
        if($this->session->userdata('logged_company')['type'] != 'c'){
                    	//redirect('admin_pump');
                } 
      $data["logged_company"] = $_SESSION['logged_company'];

      $this->load->model('Adminpump_model');
      $id = $this->uri->segment('3');
      $data["id"] = $this->uri->segment('3');
      $data["pump"] =  $this->Adminpump_model->select_pumpby_id($id);
	  
      // echo $this->db->last_query();die();
      // print_r($data["pump"]);die(); 
      $this->form_validation->set_rules('pump','pump','required');

      date_default_timezone_set('Asia/Kolkata');
      if($this->form_validation->run() == true)
      {
		  $xp_type = 'No';
if($this->input->post('xtrapremium') == "Yes"){
	$xp_type = 'Yes';
}
            $data = array(
              'location_id' => $this->input->post('sel_loc'),
              'name' => $this->input->post('pump'),
              'update_at' => date('Y-m-d H:i:sa'),
              'type' => $this->input->post('pump_type'),
			  'nozzel_code' => $this->input->post('nozzel_code'),
              'tank_id' => $this->input->post('tank_list'),
			  'xp_type' => $xp_type
            );
              
        $update = $this->Adminpump_model->update($id,$data);
		
        $this->session->set_flashdata('success_update','Data Updated Successfully..');
        redirect('admin_pump/index/'.$this->uri->segment('4'));
      }
      else
      {
        
      $id = $this->uri->segment('3');
      if($id == "")
      {
        $id = $this->input->post('id');
      }
      
      $query = $this->db->get_where("shpump",array("id"=>$id));
      $data['r'] = $query->row();
      $this->load->model('admin_model');
      $id1 =  $_SESSION['logged_company']['id'];
      $data['r1'] = $this->admin_model->select_location($id1);
		$data['tanklist'] = $this->Adminpump_model->get_tbl_list('sh_tank_list',array('status'=>'1','location_id'=>$data['r']->location_id,'fuel_type'=>$data['r']->type),array('tank_name','asc'));
		
      $this->load->view('web/pump_edit',$data);
      }

      // $this->load->view('web/edit_location.php');
    }
	function tank_list(){
		$location = $this->input->post('lid');
		$type = $this->input->post('type');
		$stank = $this->input->post('tank');
		$this->load->model('Adminpump_model');
		$list = $this->Adminpump_model->get_tbl_list('sh_tank_list',array('status'=>'1','location_id'=>$location,'fuel_type'=>$type),array('tank_name','asc'));
		$html = '<option value="">Select Tank</option>';
		foreach($list as $tank){
			if($tank->show == '1'){
			$selected = "";
			if($stank == $tank->id){
			$selected = "selected";
			}
			$html .= '<option value="'.$tank->id.'" '.$selected.'>'.$tank->tank_name.'</option>';
			}
		}
		echo $html;
	}
	public function show_hide() {
        ini_set('display_errors', '-1');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('admin_pump');
        }
        $id = $this->input->get('id');
        $show = $this->input->get('type');
        $lid = $this->input->get('lid');
        $data = array();
		if($this->input->get('date') != "" || $show == '0'){
        if ($show == '1') {
            $sting = "hide";
            $data = array('show' => 0,'hide_date'=>date('Y-m-d',strtotime($this->input->get('date'))));
        } else {
            $sting = "show";
            $data = array('show' => 1,'hide_date'=>NULL);
        }
      $this->load->model('Adminpump_model');
        $update = $this->Adminpump_model->update($id, $data);
  //      echo $this->db->last_query();
        $this->session->set_flashdata('success', 'Data ' . $sting . ' Successfully..');
        redirect('admin_pump/index/' . $lid);
		}else{
			$data['id'] = $id;
			$data['type'] = $show;
			$data['lid'] = $lid;
			$data['date'] = date('d-m-Y');
			$this->load->view('web/pump_hide',$data);
		}
    }
}

?>