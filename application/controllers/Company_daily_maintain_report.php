<?php
	class Company_daily_maintain_report extends CI_Controller
	{
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
		function index()
		{
			if(!$this->session->userdata('logged_company'))
			{
            	redirect('company_login');
      		}
        	$data["logged_company"] = $_SESSION['logged_company'];
			$this->load->database();
			$this->load->model('admin_model');
			$id1 =  $_SESSION['logged_company']['id'];
			if ($this->session->userdata('logged_company')['type'] == 'c') {
				$data['location_list'] = $this->admin_model->select_location($id1);
			} else {
				$u_id = $this->session->userdata('logged_company')['u_id'];
				$data['location_list'] = $this->admin_model->get_location($u_id);
			}
			$id1 =  $_SESSION['logged_company']['id'];
			$data['location'] = "";
			$data['sdate'] = date('d-m-Y');
			if($this->input->get('location') != "" && $this->input->get('sdate')) {
				$data['location'] = $this->input->get('location');
				$data['sdate'] = $this->input->get('sdate');
				$this->load->model('company_daily_maintain_model');
				$data['reports'] = $this->company_daily_maintain_model->daily_maintain_report(date('Y-m-d',strtotime($data['sdate'])),$data['location']);
			}
			$this->load->view('web/company_daily_maintain_report',$data);
		}
		
		function print_pdf(){
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->database();
		if($this->input->get('location_id') != "" && $this->input->get('date')) {
			$data['location'] = $this->input->get('location_id');
			$data['sdate'] = $this->input->get('date');
			$this->load->model('company_daily_maintain_model');
			$this->load->model('daily_reports_model');
			$data['location_detail'] = $this->daily_reports_model->location_detail($data['location']);
			$data['reports'] = $this->company_daily_maintain_model->daily_maintain_report(date('Y-m-d',strtotime($data['sdate'])),$data['location']);
			$data['userdata'] = '';
			$this->load->model('admin_model');
			foreach($data['reports'] as $report){
				if($report->user_id != ""){
					$userdata = $this->admin_model->user_detail($report->user_id);
					if($userdata){
						$data['userdata'] = $userdata->UserFName." ".$userdata->UserLName;
					}
				}
			}
		}else{
			
		}
			$this->load->library('m_pdf');
		 	$html = $this->load->view('web/company_daily_maintain_pdf', $data, true); 
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