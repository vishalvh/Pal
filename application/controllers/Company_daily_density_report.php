<?php
	class Company_daily_density_report extends CI_Controller
	{
function __construct() {
	parent::__construct();
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
			$data['edate'] = date('d-m-Y');
			$data['type'] = '';
			if($this->input->get('location') != "" && $this->input->get('sdate') && $this->input->get('edate') && $this->input->get('tank')) {
				$data['type'] = $type = $this->input->get('type');
				$data['location'] = $this->input->get('location');
				$data['sdate'] = $this->input->get('sdate');
				$data['edate'] = $this->input->get('edate');
				$data['tank'] = $this->input->get('tank');
				$this->load->model('company_daily_density_model');
				$this->load->model('Inventory_model');
				$this->load->model('company_daily_tank_density_model');
				$data['reports'] = $this->company_daily_tank_density_model->daily_density_report_tank(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['tank']);
				//echo "<pre>"; echo $this->db->last_query();	 die;
				//$report = $this->company_daily_tank_density_model->daily_density_report(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['location'],$type);
				$data['morgdencity'] = array();
				/*foreach($report as $reports){
					$data['morningdencity'][$reports->date] = $reports;
				}*/
				//$data['reports'] = $this->company_daily_density_model->daily_density_report(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['location']);
				//echo $this->db->last_query(); echo "<pre>"; print_r($report); die;
				foreach($data['reports'] as $reports){
					$reports->inventoryData = $this->Inventory_model->getInvetory($reports->date,$reports->location_id,$type);
					$reports->daily_density = $this->company_daily_tank_density_model->get_daily_density($reports->date,$reports->location_id);
					//echo $this->db->last_query(); die;
				}
				//echo "<pre>"; print_r($data['reports']);die;
			}
			$this->load->view('web/company_daily_density_report',$data);
		}
		function edit(){
			$data['type'] = $type = $this->input->get('type');
			$data['location'] = $this->input->get('location');
			$data['sdate'] = $this->input->get('sdate');
			$data['edate'] = $this->input->get('edate');
			$data['tank'] = $this->input->get('tank');
			$data['date'] = $this->input->get('date');
			$this->load->model('company_daily_tank_density_model');
			$this->load->model('Inventory_model');
			$data['reports'] = $this->company_daily_tank_density_model->daily_density_report_tank($data['date'],$data['date'],$data['tank']);
			foreach($data['reports'] as $reports){
				$reports->inventoryData = $this->Inventory_model->getInvetory($reports->date,$reports->location_id,$type);
				$reports->daily_density = $this->company_daily_tank_density_model->get_daily_density($reports->date,$reports->location_id);
			}
			//echo "<pre>"; print_r($data['reports']);
			$this->load->view('web/densityrecordrepor_edit',$data);
		}
		function update(){
			$data['type'] = $type = $this->input->get('type');
			$data['location'] = $this->input->get('location');
			$data['sdate'] = $this->input->get('sdate');
			$data['edate'] = $this->input->get('edate');
			$data['tank'] = $this->input->get('tank');
			$data['date'] = $this->input->get('date');
			$this->load->model('company_daily_tank_density_model');
			$this->load->model('Inventory_model');
			$data['reports'] = $this->company_daily_tank_density_model->daily_density_report_tank($data['date'],$data['date'],$data['tank']);
			foreach($data['reports'] as $reports){
				$reports->inventoryData = $this->Inventory_model->getInvetory($reports->date,$reports->location_id,$type);
				$reports->daily_density = $this->company_daily_tank_density_model->get_daily_density($reports->date,$reports->location_id);
			}
			$detail = $data['reports'][0];
			
			$fUpdateArray = array("hydro_reading"=>$this->input->post('hydro_reading'),
			"temp"=>$this->input->post('hydro_reading_temp'),
			"density"=>$this->input->post('hydro_reading_converted'));
			$this->company_daily_tank_density_model->update_data('sh_daily_tank_density', array('id' => $detail->id), $fUpdateArray);
			$invdetail = $detail->inventoryData;
			
			$sUpdateArray = array("invoice_no"=>$this->input->post('challan_no'));
			
			if($data['type'] == "p"){
				$sUpdateArray['p_quantity'] = $this->input->post('quantity');
				$sUpdateArray['p_invoice_density'] = $this->input->post('density_per_challan');
				$sUpdateArray['p_observer_density'] = $this->input->post('observed_density_in_tank_truck');
			}else{
				$sUpdateArray['d_quantity'] = $this->input->post('quantity');
				$sUpdateArray['d_invoice_density'] = $this->input->post('density_per_challan');
				$sUpdateArray['d_observer_density'] = $this->input->post('observed_density_in_tank_truck');
			}
			$this->company_daily_tank_density_model->update_data('sh_inventory', array('id' => $invdetail->id), $sUpdateArray);
			
			$dailydensitydetail = $detail->daily_density;
			$tUpdateArray = array();
			if($data['type'] == "p"){
				$tUpdateArray['p_decant_hydro_reading'] = $this->input->post('hydrometer_reading');
				$tUpdateArray['p_decant_temp'] = $this->input->post('hydrometer_reading_temp');
				$tUpdateArray['p_decant_density'] = $this->input->post('hydrometer_reading_converted');
			}else{
				$tUpdateArray['d_decant_hydro_reading'] = $this->input->post('hydrometer_reading');
				$tUpdateArray['d_decant_temp'] = $this->input->post('hydrometer_reading_temp');
				$tUpdateArray['d_decant_density'] = $this->input->post('hydrometer_reading_converted');
			}
			if($dailydensitydetail){
				$this->company_daily_tank_density_model->update_data('sh_daily_density', array('id' => $dailydensitydetail->id), $tUpdateArray);
			}else{
				$tUpdateArray['date'] = $data['date'];
				$tUpdateArray['location_id'] = $data['location'];
				$this->company_daily_tank_density_model->insert('sh_daily_density',$tUpdateArray);
			}
			redirect('company_daily_density_report?sdate='.date("d-m-Y",strtotime($data['sdate'])).'&edate='.date("d-m-Y",strtotime($data['edate'])).'&location='.$data["location"].'&type='.$data["type"].'&tank='.$data["tank"]);

		}
		
		function print_pdf(){
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->database();
		if($this->input->get('location_id') != "" && $this->input->get('sdate') && $this->input->get('edate')) {
			$data['location'] = $this->input->get('location_id');
			$data['sdate'] = $this->input->get('sdate');
			$data['edate'] = $this->input->get('edate');
			$data['tank'] = $this->input->get('tank');
			$this->load->model('company_daily_density_model');
			$this->load->model('daily_reports_model');
			$data['location_detail'] = $this->daily_reports_model->location_detail($data['location']);
			//$data['reports'] = $this->company_daily_density_model->daily_density_report(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['location']);
			$data['userdata'] = '';
			$this->load->model('admin_model');
			$this->load->model('Inventory_model');
			//$data['reports'] = $this->company_daily_density_model->daily_density_report(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['location']);
			$data['type'] = $type = $this->input->get('type');
			$this->load->model('company_daily_tank_density_model');
			/*$report = $this->company_daily_tank_density_model->daily_density_report(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['location'],$type);
			$data['morgdencity'] = array();
			foreach($report as $reports){
				$data['morningdencity'][$reports->date] = $reports;
			}
			foreach($data['reports'] as $reports){
					$reports->inventoryData = $this->Inventory_model->getInvetory($reports->date,$reports->location_id,$type);
				}*/
			$data['reports'] = $this->company_daily_tank_density_model->daily_density_report_tank(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['tank']);
			foreach($data['reports'] as $reports){
				$reports->inventoryData = $this->Inventory_model->getInvetory($reports->date,$reports->location_id,$type);
				$reports->daily_density = $this->company_daily_tank_density_model->get_daily_density($reports->date,$reports->location_id);
				//echo $this->db->last_query(); die;
			}
		}else{
			
		}
			$this->load->library('m_pdf');
		 	$html = $this->load->view('web/company_daily_density_pdf', $data, true); 
			$pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "density.pdf";
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