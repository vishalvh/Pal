<?php
	class Company_daily_tank_density_report extends CI_Controller
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
	function index(){ 
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
			$data['smapleCollectionCount'] = 0;
			if($this->input->get('location') != "" && $this->input->get('sdate') && $this->input->get('edate') && $this->input->get('tank')) {
				$data['location'] = $this->input->get('location');
				$data['sdate'] = $this->input->get('sdate');
				$data['edate'] = $this->input->get('edate');
				$data['type'] = $this->input->get('type');
				$data['tank'] = $this->input->get('tank');
				$this->load->model('company_daily_tank_density_model');
				//$report = $this->company_daily_tank_density_model->daily_density_report(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['location'],$data['type']);
				//echo $this->db->last_query(); die;
				$data['tanklist'] = array();
				$data['reports'] = array();
				$this->load->model('Inventory_model');
				$report = $this->Inventory_model->getInvetoryDatesByTankId(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['location'],$data['type'],$data['tank']);
			
				if($report){
					foreach($report as $reports){
						if($reports->p_quantity > 0 || $reports->d_quantity > 0 ){
							$sampleData = $this->Inventory_model->sampleData($reports->id);
							$reports->sampleData = $sampleData;
							if(count($sampleData) > $data['smapleCollectionCount']){
								$data['smapleCollectionCount'] = count($sampleData);
							}
							$data['reports'][] = $reports;
						}
					}
				}
			}
			//echo "<pre>"; print_r($data['reports']); die;
			//echo $data['smapleCollectionCount'];
			//echo "<pre>"; print_r($data['reports']); die;
			$this->load->view('web/company_daily_tank_density_report',$data);
		}
		
		function print_pdf(){
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->database();
		if($this->input->get('location') != "" && $this->input->get('sdate') && $this->input->get('edate')) {
			$data['location'] = $this->input->get('location');
			$data['sdate'] = $this->input->get('sdate');
			$data['edate'] = $this->input->get('edate');
			$this->load->model('company_daily_tank_density_model');
			$this->load->model('daily_reports_model');
			$data['location_detail'] = $this->daily_reports_model->location_detail($data['location']);
			$data['type'] = $this->input->get('type');
			$report = $this->company_daily_tank_density_model->daily_density_report(date('Y-m-d',strtotime($data['sdate'])),date('Y-m-d',strtotime($data['edate'])),$data['location'],$data['type']);
				//echo $this->db->last_query(); die;
				$data['tanklist'] = array();
				$data['reports'] = array();
				if($report){
					$tanklist = $this->company_daily_tank_density_model->tanklist($data['location']);
					foreach($tanklist as $list){
						$data['tanklist'][$list->id] = $list->tank_name;
					}
					$this->load->model('Inventory_model');
					foreach($report as $reports){
						$invtryData = $this->Inventory_model->getInvetory($reports->date,$reports->location_id,$reports->type);
						if($invtryData->p_quantity > 0 || $invtryData->d_quantity > 0 ){
							$reports->inventoryData = $invtryData;
							$sampleData = $this->Inventory_model->sampleData($invtryData->id);
							$reports->sampleData = $sampleData;
							if(count($sampleData) > $data['smapleCollectionCount']){
								$data['smapleCollectionCount'] = count($sampleData);
							}
							$data['reports'][] = $reports;
						}
					}
				}
			$data['userdata'] = '';
			$this->load->model('admin_model');
		}
			$this->load->library('m_pdf');
		 	$html = $this->load->view('web/company_daily_tank_density_pdf', $data, true); 
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
		
		function update(){ 
			if(!$this->session->userdata('logged_company'))
			{
            	redirect('company_login');
      		}
			$id1 =  $_SESSION['logged_company']['id'];
			$data["id"] = $id = $this->uri->segment('3');
			
			$this->load->model('Inventory_model');
			$this->load->model('Admin_inventory_log_model');
			$this->form_validation->set_rules('date','Date','required');
			
			date_default_timezone_set('Asia/Kolkata');
			if($this->form_validation->run() == true)
			{
				$namearray =  array();
				$finalarray =  array();
				$data['type'] = $type =  $this->input->get('type');
				if($type == 'd'){
				foreach($this->input->post('d_sample') as $vsl){
					$namearray['name'] = $vsl;
					$finalarray[] = $namearray;
				}
				}else{
				foreach($this->input->post('p_sample') as $vsl){
					$namearray['name'] = $vsl;
					$finalarray[] = $namearray;
				}	
				}	
				$data['location'] =  $location =$this->input->get('location');
				$data['date'] = $date = $this->input->get('date');
				$data['sdate'] = $sdate = $this->input->get('sdate');
				$data['edate'] = $edate =  $this->input->get('edate');
				$data['tank'] = $tank =  $this->input->get('tank');				
				$reports = $this->Inventory_model->getInvetoryDatesByTankId(date('Y-m-d',strtotime($date)),date('Y-m-d',strtotime($date)),$location,$type,$tank);
				$id = $reports[0]->id;
				if($id == ""){
					redirect('company_daily_tank_density_report?sdate='.$sdate.'&edate='.$edate.'&location='.$location.'&type='.$type.'&tank='.$tank);
				}
				$old_resposne = $this->Inventory_model->getEditById($id);
				$old_array = array($old_resposne);
				$final_array =array('invoice_no'=>$this->input->post('invoice_no'));
				
				if($type == 'd'){
					$final_array['d_quantity'] = $this->input->post('d_quantity');
					$final_array['d_invoice_density'] = $this->input->post('d_invoice_density');
					$final_array['d_observer_density'] = $this->input->post('d_observer_density');
					$final_array['d_vehicle_no'] = $this->input->post('d_vehicle_no');
				}else{
					$final_array['p_quantity'] = $this->input->post('p_quantity');
					$final_array['p_invoice_density'] = $this->input->post('p_invoice_density');
					$final_array['p_observer_density'] = $this->input->post('p_observer_density');
					$final_array['p_vehicle_no'] = $this->input->post('p_vehicle_no');
				}
				//echo "<pre>"; print_r($final_array); die;
				$this->Inventory_model->update($reports[0]->id,$final_array);
				
			
				$new_resposne = $this->Inventory_model->getEditById($id);
				$new_array = array($new_resposne);
				$newarrays = array(
					'inventory_id'=>$id,
					'old_data'=>serialize($old_array),
					'new_data'=>serialize($new_array),
					'created_date'=>date('Y-m-d H:i:s'),
					'created_by'=>$id1
				);
				
				$this->db->insert('sh_inventory_update_log',$newarrays);
				
				$this->session->set_flashdata('success','Company daily tank density report successfully updated.');
			  
			 	//redirect('company_daily_tank_density_report');
				redirect('company_daily_tank_density_report?sdate='.$sdate.'&edate='.$edate.'&location='.$location.'&type='.$type.'&tank='.$tank);
			}else{
				$data['location'] =  $location =$this->input->get('location');
				$data['date'] = $date = $this->input->get('date');
				$data['sdate'] = $sdate = $this->input->get('sdate');
				$data['edate'] = $edate =  $this->input->get('edate');
				$data['type'] = $type =  $this->input->get('type');
				$data['tank'] = $tank =  $this->input->get('tank');	
				
				$data['reports'] = $this->Inventory_model->getInvetoryDatesByTankId(date('Y-m-d',strtotime($date)),date('Y-m-d',strtotime($date)),$location,$type,$tank);
				if($data['reports']){
					foreach($data['reports'] as $reports){
						if($reports->p_quantity > 0 || $reports->d_quantity > 0 ){
							$sampleData = $this->Inventory_model->sampleData($reports->id);
							$reports->sampleData = $sampleData;
						}
					}
				}
				//echo "<pre>"; print_r($data['reports']); die;
				$this->load->view('web/company_daily_tank_density_report_edit',$data);
			}
		}
public function insert($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}		
}
?>