<?php
class Tankor_entory_report extends CI_Controller{
	function __construct() {
		parent::__construct();
		if ($this->session->userdata('logged_company')) {
			$sesid = $this->session->userdata('logged_company')['id'];
			$this->load->model('user_login');
			$this->data['all_location_list'] = $this->user_login->get_all_location($sesid);
		}
		$this->load->helper("amount");
		$this->load->library('Web_log');
		$p = new Web_log;
		$this->allper = $p->Add_data();
	}		
	function index(){
		if(!$this->session->userdata('logged_company')){
			redirect('company_login');
		}
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->database();
		$this->load->model('admin_model');
		$this->load->model('Service_model_15');
		$id1 =  $_SESSION['logged_company']['id'];
		$c_id = $_SESSION['logged_company']['id'];
		$this->load->model('expense_model');
		if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location_list'] = $this->expense_model->master_fun_get_tbl_val_location('sh_location', array('status' => 1,'show_hide' =>'show', 'company_id' => $c_id));
        } else {
            $u_id = $_SESSION['logged_company']['u_id'];
            $data['location_list'] = $this->expense_model->get_location($u_id);
        }
		$id1 =  $_SESSION['logged_company']['id'];
		$data['location'] = "";
		$data['sdate'] = "";
		$data['edate'] = "";
		if($this->input->get('location') != "" && $this->input->get('sdate') && $this->input->get('edate')) {
		$data['location'] = $this->input->get('location');
		$data['sdate'] = $sdate = $this->input->get('sdate');
		$data['edate'] = $edate = $this->input->get('edate');
		$finalArray = array();
		$inventoryList = $this->Service_model_15->tankInventoryList($data['location'],date('Y-m-d',strtotime($sdate)),date('Y-m-d',strtotime($edate)));
		if(count($inventoryList) > 0){
			foreach($inventoryList as $list){
				$list->tankdetail = $this->Service_model_15->tankInventorydetail($list->id);
				$list->meterdetail = $this->Service_model_15->meterInventorydetail($list->id);
			}
			
		}
		$data['result'] = $inventoryList;
		}
		$this->load->view('web/tankor_entory_report_view',$data);
	}

	function pdf(){
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->database();
		if($this->input->get('location') != "" && $this->input->get('sdate') && $this->input->get('edate')) {
			
			$data['location'] = $this->input->get('location');
			$data['sdate'] = $sdate = $this->input->get('sdate');
			$data['edate'] = $edate = $this->input->get('edate');
					$this->load->model('daily_reports_model');
		$this->load->model('Service_model_15');
			$data['location_detail'] = $this->daily_reports_model->location_detail($data['location']);
			$finalArray = array();
			$inventoryList = $this->Service_model_15->tankInventoryList($data['location'],date('Y-m-d',strtotime($sdate)),date('Y-m-d',strtotime($edate)));
			if(count($inventoryList) > 0){
				foreach($inventoryList as $list){
					$list->tankdetail = $this->Service_model_15->tankInventorydetail($list->id);
					$list->meterdetail = $this->Service_model_15->meterInventorydetail($list->id);
				}
				
			}
			$data['result'] = $inventoryList;
			//echo "<pre>"; print_r($inventoryList); die();
		}
		$this->load->library('m_pdf');
		$html = $this->load->view('web/tankor_entory_report_pdf', $data, true); 
		$pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "invoice.pdf";
		$lorem = utf8_encode($html); // render the view into HTML
		$pdf = $this->m_pdf->load();
		$pdf->AddPage('p', // L - landscape, P - portrait
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