<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . 'libraries/swift_mailer/swift_required.php';
class Company_reading extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('master_model');
        $this->load->model('Company_reading_model');
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }
    function add() {
        if ($_SESSION['logged_company'] == "") {
            redirect('login');
        }
        if ($this->session->userdata('success') != null) {
            $data['success'] = $this->session->userdata("success");
            $this->session->unset_userdata('success');
        }
        if ($this->session->userdata('unsuccess') != null) {
            $data['unsuccess'] = $this->session->userdata("unsuccess");
            $this->session->unset_userdata('unsuccess');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $data["user"] = $this->user_model->getUser($data["logged_company"]["id"]);
        $userid = $data["logged_company"]["id"];
        $this->form_validation->set_rules('Adminname', 'Name', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $category = $this->input->post("category");
		 $time = $this->master_model->get_server_time();
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Admin/header');
            $this->load->view('Admin/nav', $data);
			$this->load->view('Admin/pump_add', $data);
            $this->load->view('Admin/footer');
        } else {

            $name = $this->input->post("Adminname");
            $type = $this->input->post("type");
                    
            $data1 = array(
                
                "name" => $name,
                "type" => $type,
                "created_at" =>$time['UTC_TIMESTAMP()']
            );
//echo "<pre> company <br>"; print_r($data1);
            $insert = $this->master_model->master_fun_insert('shpump', $data1);
            $data["logged_company"] = $_SESSION['logged_company'];
            $data["user"] = $this->user_model->getUser($data["logged_company"]["id"]);
            if ($insert) {
                $ses = array("Pump Details Successfully Inserted!");
                $this->session->set_userdata('success', $ses);
                redirect('pump_master/pump_list');
            }
        }
    }

	
    function index() {
			if ($_SESSION['logged_company'] == "") {
            redirect('company_login');
            }
		if ($this->session->userdata('success') != null) {
                $data['success'] = $this->session->userdata("success");
                $this->session->unset_userdata('success');
            }
            if ($this->session->userdata('unsuccess') != null) {
                $data['unsuccess'] = $this->session->userdata("unsuccess");
                $this->session->unset_userdata('unsuccess');
            }
		
	  		
		//print_r($date1);
	  	$c_id = $_SESSION["logged_company"]["id"];
		$data['Employee'] = $this->Company_reading_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $c_id));
        
        $data['location'] = $this->Company_reading_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $c_id));

			//print_r($data['Employee ']); die();
          	 
			
			$data["query"]=$this->Company_reading_model->shdailyreadingdetails_active_record();
            $totalRows = count($data["query"]);
            $config = array();
            $config["base_url"] = base_url() . "Faqs_master/faqs_list/";
            $config["total_rows"] = $totalRows;
            $config["per_page"] = 10;
            $config["uri_segment"] = 3;
            $this->pagination->initialize($config);
            $sort = $this->input->get("sort");
            $by = $this->input->get("by");
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["query"] = $this->Company_reading_model->shdailyreadingdetails_active_record1($config["per_page"], $page);
            
             $data["links"] = $this->pagination->create_links();
			
		$data["logged_company"] = $_SESSION['logged_company']; 
		$data["user"] = $this->user_model->getUser($_SESSION["logged_company"]["id"]);
				//  print_r($data);
	
		
		//print_r($data["query"]);
		$this->load->view('web/reading_list',$data);
		
    	
	}

    function pump_delete() {
        if ($_SESSION['logged_company'] == "") {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $data["user"] = $this->user_model->getUser($data["logged_company"]["id"]);
        $userid = $data["logged_company"]["id"];
        $cid = $this->uri->segment('3');
        $data = array(
            "status" => '0'
        );
        //$delete=$this->admin_model->delete($cid,$data);
        $delete = $this->master_model->master_fun_update1("shpump", 'id', $this->uri->segment('3'), $data);
        if ($delete) {
            $ses = array("Pump Details Successfully Deleted!");
            $this->session->set_userdata('success', $ses);
            redirect('pump_master/pump_list', 'refresh');
        }
    }
	function reading_list_details() {
        if ($_SESSION['logged_company'] == "") {
            redirect('company_login');
        }
//		print_r($_POST); 
	
		//print_r($_SESSION);
		$id = $this->uri->segment('3');
		//print_r($id);
        $data["logged_company"] = $_SESSION['logged_company'];
        $data["user"] = $this->user_model->getUser($data["logged_company"]["id"]);
		//print_r($data["user"]);
        $data["id"] = $this->uri->segment('3');
//		print_r("<pre>");print_r($data);
        if ($this->session->userdata('unsuccess') != null) {
            $data['unsuccess'] = $this->session->userdata("unsuccess");
            $this->session->unset_userdata('unsuccess');
        }
        $company_id = $_SESSION["logged_company"]["id"];
         $data["query"] = $this->Company_reading_model->shdailyreadingdetails_active_record2($id);
         $data["details"] = $this->Company_reading_model->shdailyreadingdetails_reading_list_details_id($id,$company_id);
        // echo $this->db->last_query();die();
		if ($this->form_validation->run() != FALSE) {
			
            $name = $this->input->post("name");
            $type = $this->input->post("type");
            $data1 = array(
                "name" => $name,
                "type" => $type,
                );
	
            $update = $this->master_model->master_fun_update1("shpump", 'id', $this->uri->segment('3'), $data1);
		
            if ($update) {
              $ses = array("Pump Details Successfully Update!");
            $this->session->set_userdata('success', $ses);
            redirect('Pump_master/pump_list', 'refresh');
            }
        } 
        $data["logged_company"] = $_SESSION['logged_company']; 
        $data["user"] = $this->user_model->getUser($_SESSION["logged_company"]["id"]);
        
        $this->load->view('web/reading_view_details', $data);
    
    }
		function update_details() {
        if ($_SESSION['logged_company'] == "") {
            redirect('company_login');
        }
		//print_r($_POST); 
//				die(); 
	
		//print_r($_SESSION);
		$id = $this->uri->segment('3');
		$RDRId = $this->uri->segment('3');
		$id_link = $this->uri->segment('3');
		
		//print_r($id);
        $data["logged_company"] = $_SESSION['logged_company'];
        $data["user"] = $this->user_model->getUser($data["logged_company"]["id"]);
		//print_r($data["user"]);
        $data["id"] = $this->uri->segment('3');
//		print_r("<pre>");print_r($data);
        if ($this->session->userdata('unsuccess') != null) {
            $data['unsuccess'] = $this->session->userdata("unsuccess");
            $this->session->unset_userdata('unsuccess');
        }
         $data["query"] = $this->Company_reading_model->shdailyreadingdetails_active_record2($id);
         $data["details2"] = $this->Company_reading_model->shdailyreadingdetails_reading_list_details();
         $data["details1"] = $this->Company_reading_model->shdailyreadingdetails_reading_list_details_id($id);
		$details2 =  $data['details2'];
		$details1 =  $data['details1'];
	//echo "<pre>";		print_r($details1);
			//print_r($details2);
//			die();
			$cnt = 0;
			$final = array();
			foreach($details2 as $row){
				$pid = $row['id'];
				//echo $pid; 
				$name1 = $row['name'];
				$type = $row['type'];
				$id_q = $details1[$cnt]['id'];	
				if($pid == $id_q){
					$pid2 = $details1[$cnt]['pid'];
				$name = $details1[$cnt]['name'];
				$Reading = $details1[$cnt]['Reading'];
					$data1_test1= array(
					'pid' => $pid2,
					'name' => $name1,
					'Reading' => $Reading,
					'type' => $type,
					'id1' => $id_q,
					'id' => $pid
						);
				}
				if($pid != $id_q){
					$data1_test1 = array(
					'pid' => "",
					'name' => $name1,
					'Reading' => "",
					'type' => $type,
					'id1' => $id_q,
					'id' => $pid
				); 		
				}
				array_push($final,$data1_test1);
				$cnt++;
			}$data["details"] = $final; 
		//	print_r($final);
					
        $this->form_validation->set_rules('DieselReading', 'Email', 'trim|required');
        $this->form_validation->set_rules('PatrolReading', 'type', 'trim|required');
        $this->form_validation->set_rules('meterReading', 'type', 'trim|required');
        $this->form_validation->set_rules('TotalAmount', 'type', 'trim|required');
        $this->form_validation->set_rules('TotalCash', 'type', 'trim|required');
        $this->form_validation->set_rules('TotalCredit', 'type', 'trim|required');
        $this->form_validation->set_rules('TotalExpenses', 'type', 'trim|required');
        //$this->form_validation->set_rules('PatrolReadings', 'type', 'trim|required');
		if ($this->form_validation->run() != FALSE) {
			//print_r($_POST);
            $DieselReading = $this->input->post("DieselReading");
            $PatrolReading = $this->input->post("PatrolReading");
            $meterReading = $this->input->post("meterReading");
            $TotalAmount = $this->input->post("TotalAmount");
            $TotalCash = $this->input->post("TotalCash");
            $TotalCredit = $this->input->post("TotalCredit");
            $TotalExpenses = $this->input->post("TotalExpenses");
			$Pdetails = $this->input->post("Pdetails");
			$id = $this->input->post("id");
			$shp_id = $this->input->post("pid");
			$type = $this->input->post("type");
//			print_r($Pdetails);
//			print_r($id); die();
            $data1 = array(
                "DieselReading" => $DieselReading,
                "PatrolReading" => $PatrolReading,
                "meterReading" => $meterReading,
                "TotalAmount" => $TotalAmount,
                "TotalCredit" => $TotalCredit,
                "TotalExpenses" => $TotalExpenses,
                );
//echo "<pre>";	print_r($data1); 
			//die();
            $update = $this->Company_reading_model->master_fun_update1("shdailyReadingdetails", 'id', $this->uri->segment('3'), $data1);
			$cnt = 0;
			foreach($Pdetails as $row){
				$id_q = $id[$cnt];
			//echo"<pre>";	print_r($id[$cnt]); print_r($row); 
				$shpump_id = $shp_id[$cnt];
				$type_id = $type[$cnt];
				//echo $id;
				if($id_q != ""){
				$data1_test= array(
					'Reading' => $row
				);
				$update = $this->Company_reading_model->master_fun_update1("shreadinghistory", 'id',$id_q, $data1_test);
				}else{
				$uId =	$this->uri->segment('3');
					$data1_test= array(
					'Reading' => $row,
					'RDRId'=> $uId,
					'PumpId'=> $shpump_id,
					'type'=> $type_id
				);
				$this->Company_reading_model->master_fun_insert('shreadinghistory', $data1_test);
				}
				//print_r($data1_test);
				$cnt++;
			}
            if ($update) {
              $ses = array("Reading Details Successfully Update!");
            $this->session->set_flashdata('success', 'Reading Details Successfully Update!');
           redirect('Reading_master/update_details/' . $id_link);
            }
        } 
        $data["logged_company"] = $_SESSION['logged_company']; 
        $data["user"] = $this->user_model->getUser($data["logged_company"]["id"]);
        $this->load->view('Admin/header');
        $this->load->view('Admin/nav', $data);
        $this->load->view('Admin/reading_edit', $data);
        $this->load->view('Admin/footer');
    }
	 public function ajax_list() {
        $employeename = $this->input->get('employeename');
        $pb = $this->input->get('pb');
        $fdate = $this->input->get('fdate');
        $tdate = $this->input->get('tdate');
        $location = $this->input->get('location');
        $Product = $this->input->get('Product');
        $ConeType = $this->input->get('ConeType');
        $Packaging = $this->input->get('Packaging');
		$id = $_SESSION['logged_company']['id'];
        $current_date = date('Y-m-d');
        $list = $this->Company_reading_model->get_datatables($employeename,$fdate,$tdate,$id,$location,$current_date);
     //   echo $this->db->last_query();
        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];
        $msg = '"Are you sure you want to remove this data?"';
		$listcount = 0;
		$cnt = 0;
		
        foreach ($list as $customers) {
            if ($customers->shift == '1') 
            {
                $shift = "Day";
            }
            if ($customers->shift == '2') 
            {
                $shift = "Night";
            }
            if ($customers->shift == '3') 
            {
                $shift = "24 hours";
            }
            $no++;
            $edit = "<a href='" . $base_url . "company_reading/reading_list_details/" . $customers->id . " '><i class='fa fa-info'></i></a>  
					<a href='" . $base_url . "purchase_booking/delete/" . $customers->id ." ' onclick='return confirm(".$msg.");' ><i class='fa fa-trash-o'></i></a>";
//			$edit= "<a href=\".$base_url."parameter/edit/".$customers->id.\">12</a>";
            $row = array();

            $name1 = $customers->UserFName;
            $row[] = $no;
            $row[] = date('d-m-Y', strtotime($customers->Date));
            $row[] = ucfirst($name1);
            $row[] = $customers->l_name;
            $row[] = $shift;
			 $row[] = $customers->PatrolReading;
            $row[] = $customers->DieselReading;
			 $row[] = $customers->meterReading;
			 $row[] = $customers->TotalCash;
			 $row[] = $customers->TotalCredit;
			 $row[] = $customers->TotalExpenses;
			 $row[] = $customers->TotalAmount;
			 $row[] = $customers->disel_deep_reding;
			 $row[] = $customers->petrol_deep_reding;
            $row[] =  $edit;
            $data[] = $row;
			$listcount++;
        }
//		echo $this->db->last_query();
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Company_reading_model->count_all($employeename,$fdate,$tdate,$id),
            "recordsFiltered" => $this->Company_reading_model->count_filtered($employeename,$fdate,$tdate,$id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}
?>