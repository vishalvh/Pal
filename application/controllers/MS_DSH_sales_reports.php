<?php

class MS_DSH_sales_reports extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_company')) {
            $this->load->model('user_login');
            if ($this->session->userdata('logged_company')['type'] == 'c') {
                $sesid = $this->session->userdata('logged_company')['id'];
                $this->data['all_location_list'] = $this->user_login->get_all_location($sesid);
            } else {
                $sesid = $this->session->userdata('logged_company')['u_id'];
                $this->data['all_location_list'] = $this->user_login->get_location($sesid);
            }
            $this->load->library('Web_log');
			$this->load->helper("amount"); 
            $p = new Web_log;
            $this->allper = $p->Add_data();
        }
    }

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->database();
       
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location_list'] = $this->admin_model->select_location($id1);
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['location_list'] = $this->admin_model->get_location($u_id);
        }
        if ($this->input->get_post('sdate') == "") {
            $sdate = date('Y-m-d');
        } else {
            $sdate = date('Y-m-d', strtotime($this->input->get_post('sdate')));
        }
        if ($this->input->get_post('edate') == "") {
            $edate = date('Y-m-d');
        } else {
            $edate = date('Y-m-d', strtotime($this->input->get_post('edate')));
        }
        $location_id = $this->input->get_post('location');
		$type = $this->input->get_post('fueltype');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['location'] = $location_id;
		$data['type'] = $type;
        if ($location_id != "" && $type != "" && $sdate != "" && $edate != "") {
			
			$this->load->model('MS_DSH_sales_model');
			$this->load->model('Daily_reports_model_new');
			$this->load->model('Daily_reports_model_new_jun');
			$data['location_tank_list'] = $this->MS_DSH_sales_model->select_all_with_order('id,tank_name,tank_type,fuel_type', 'sh_tank_list', array('location_id' => $location_id, "status" => '1'), array('tank_name', 'asc'));
			$data['stock_list'] = $this->MS_DSH_sales_model->select_all_with_order('id,DATE,d_tank_reading,p_tank_reading,d_testing,p_testing,d_total_selling,p_total_selling', 'shdailyreadingdetails', array('location_id' => $location_id, "date >=" => $sdate,"date <=" =>$edate), array('date', 'asc'));
			$purches_stock_list = $this->MS_DSH_sales_model->select_all_with_order('id,fuel_type,d_quantity,p_quantity,date', 'sh_inventory', array('location_id' => $location_id, "date >=" => $sdate,"date <=" =>$edate,"fuel_type !="=>'o'), array('date', 'asc'));
			$get_tank_readin = $this->Daily_reports_model_new->get_tank_readin($location_id, $sdate, $edate);
			$finaltank = array();
            foreach ($get_tank_readin as $tank) {
                $finaltank[$tank->date][$tank->fuel_type][$tank->tank_id] = $tank->volume;
            }
			$purches_stock = array();
            foreach ($purches_stock_list as $stock_list) {
				if($stock_list->fuel_type == 'p'){
					$purches = $stock_list->p_quantity;
				}
				if($stock_list->fuel_type == 'd'){
					$purches = $stock_list->d_quantity;
				}
                $purches_stock[$stock_list->date][$stock_list->fuel_type] = $purches;
            }
			
            $data['finaltank'] = $finaltank;
            $data['purches_stock_list'] = $purches_stock;
			$reading_data_list = $this->MS_DSH_sales_model->get_reading_data($location_id,$sdate,$edate);
			$reading_data = array();
			foreach ($reading_data_list as $stock_list) {
				$reading_data[$stock_list->date][$stock_list->id] = $stock_list->Reading;
            }
			$data['reading_data'] = $reading_data;
			$data['pump_list'] = $this->MS_DSH_sales_model->select_all_with_order('id,name,type', 'shpump', array('location_id' => $location_id,'status'=>'1','type !='=>'o'), array('name', 'asc'));
			$data['tank_list'] = $this->MS_DSH_sales_model->select_all_with_order('id,tank_name,tank_type,fuel_type', 'sh_tank_list', array('location_id' => $location_id,'status'=>'1'), array('tank_name', 'asc'));
			
			//echo "<pre>"; print_r($data['tank_list']);
			
			$data['location_tank_list'] = $this->Daily_reports_model_new_jun->select_all_with_order('id,tank_name,tank_type,fuel_type,start_to,end_to,mobile_show,web_show', 'sh_tank_list', array('location_id' => $location_id, "status" => '1'), array('tank_name', 'asc'));
			$location_tank_list = $data['location_tank_list'];
			$vishaltanklist = array();
			foreach($location_tank_list as $list){
				if($list->start_to == NULL && $list->end_to == NULL){
					$vishaltanklist[] = $list;
				}else{
					// $data['sdate'] = $sdate;
					// $data['edate'] = $edate;
					//echo $sdate." >= ".$list->start_to;
					if($list->web_show == '0'){
				if(((strtotime($edate) >= strtotime($list->start_to)) && (strtotime($sdate) <= strtotime($list->start_to))) || (strtotime($sdate) <= strtotime($list->start_to)) ){
					
						$vishaltanklist[] = $list;
					}
					}else{
						$vishaltanklist[] = $list;
					}
					
				}
			}
			//echo "<pre>"; print_r($vishaltanklist); print_r($data['location_tank_list']); die();
			$data['location_tank_list'] = $vishaltanklist;
			
			$data['tank_list'] = $data['location_tank_list'];
			///print_r($data['location_tank_list']); die();
			
        } else {
            $data['report'] = "";
        }
        $this->load->view('web/MS_DSH_sales_reports', $data);
    }

    function print_pdf() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->database();
       
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location_list'] = $this->admin_model->select_location($id1);
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['location_list'] = $this->admin_model->get_location($u_id);
        }
        if ($this->input->get_post('sdate') == "") {
            $sdate = date('Y-m-d');
        } else {
            $sdate = date('Y-m-d', strtotime($this->input->get_post('sdate')));
        }
        if ($this->input->get_post('edate') == "") {
            $edate = date('Y-m-d');
        } else {
            $edate = date('Y-m-d', strtotime($this->input->get_post('edate')));
        }
        $location_id = $this->input->get_post('location');
		$this->load->model('daily_reports_model');
		$type = $this->input->get_post('fueltype');
		$data['location_detail'] = $this->daily_reports_model->location_detail($location_id);
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['location'] = $location_id;
		$data['type'] = $type;
        if ($location_id != "" && $type != "" && $sdate != "" && $edate != "") {
			
			$this->load->model('MS_DSH_sales_model');
			$this->load->model('Daily_reports_model_new');
			$data['location_tank_list'] = $this->MS_DSH_sales_model->select_all_with_order('id,tank_name,tank_type,fuel_type', 'sh_tank_list', array('location_id' => $location_id, "status" => '1'), array('tank_name', 'asc'));
			$data['stock_list'] = $this->MS_DSH_sales_model->select_all_with_order('id,DATE,d_tank_reading,p_tank_reading,d_testing,p_testing,d_total_selling,p_total_selling', 'shdailyreadingdetails', array('location_id' => $location_id, "date >=" => $sdate,"date <=" =>$edate), array('date', 'asc'));
			$purches_stock_list = $this->MS_DSH_sales_model->select_all_with_order('id,fuel_type,d_quantity,p_quantity,date', 'sh_inventory', array('location_id' => $location_id, "date >=" => $sdate,"date <=" =>$edate,"fuel_type !="=>'o'), array('date', 'asc'));
			$get_tank_readin = $this->Daily_reports_model_new->get_tank_readin($location_id, $sdate, $edate);
			$finaltank = array();
            foreach ($get_tank_readin as $tank) {
                $finaltank[$tank->date][$tank->fuel_type][$tank->tank_id] = $tank->volume;
            }
			$purches_stock = array();
            foreach ($purches_stock_list as $stock_list) {
				if($stock_list->fuel_type == 'p'){
					$purches = $stock_list->p_quantity;
				}
				if($stock_list->fuel_type == 'd'){
					$purches = $stock_list->d_quantity;
				}
                $purches_stock[$stock_list->date][$stock_list->fuel_type] = $purches;
            }
			
            $data['finaltank'] = $finaltank;
            $data['purches_stock_list'] = $purches_stock;
			$reading_data_list = $this->MS_DSH_sales_model->get_reading_data($location_id,$sdate,$edate);
			$reading_data = array();
			foreach ($reading_data_list as $stock_list) {
				$reading_data[$stock_list->date][$stock_list->id] = $stock_list->Reading;
            }
			$data['reading_data'] = $reading_data;
			$data['pump_list'] = $this->MS_DSH_sales_model->select_all_with_order('id,name,type', 'shpump', array('location_id' => $location_id,'status'=>'1','type !='=>'o'), array('name', 'asc'));
			$data['tank_list'] = $this->MS_DSH_sales_model->select_all_with_order('id,tank_name,tank_type,fuel_type', 'sh_tank_list', array('location_id' => $location_id,'status'=>'1'), array('tank_name', 'asc'));
        }
        $this->load->library('m_pdf');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $html = $this->load->view('web/pdfMS_DSH_sales_reports.php', $data, true);
        $pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "salesreport.pdf";
        $lorem = utf8_encode($html); // render the view into HTML
        $pdf = $this->m_pdf->load();
        $pdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', '5', // margin_left
                '5', // margin right
                '5', // margin top
                '0', // margin bottom
                '0', // margin header
                '0'); // margin footer
        $pdf->SetDisplayMode('fullpage');
        $pdf->h2toc = array('H2' => 0);
        $html = '';
        $pdf->WriteHTML($lorem);
        $pdf->debug = true;
        $pdf->Output($pdfFilePath, "I");
    }

}

?>