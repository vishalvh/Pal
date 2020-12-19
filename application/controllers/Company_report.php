<?php
	class Company_report extends CI_Controller
	{
function __construct() {
	parent::__construct();
	$this->load->model('user_login');
	if ($this->session->userdata('logged_company')) {
		$sesid = $this->session->userdata('logged_company')['id'];
		
		$this->data['all_location_list'] = $this->user_login->get_all_location($sesid);
	}
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
			$this->load->helper("amount");
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
			$this->load->view('web/company_report',$data);
		}
		
		function report()
		{
			if(!$this->session->userdata('logged_company'))
			{
            	redirect('company_login');
      		}
        	$data["logged_company"] = $_SESSION['logged_company'];

			$this->load->database();
			$this->load->model('daily_reports_model');
			if(!$this->session->userdata('logged_company'))
			{
            	redirect('company_login');
      		}
        	$data["logged_company"] = $_SESSION['logged_company'];
        	
        	if ($this->input->get() != "") 
        	{
        		$lid = $this->input->get('location_id');
				$this->load->model('daily_reports_model');
				$data['customerlist'] = $customerlist = $this->daily_reports_model->customer_list($lid);

        	}
        	

			$id1 =  $_SESSION['logged_company']['id'];
			$this->load->model('admin_model');
			$data['location_list'] = $this->admin_model->select_location($id1);
			$this->load->view('web/credit_debit_report',$data);
		}
		
		function company_report_list(){
			$lid = $this->input->post('lid');
			$sdate = $this->input->post('sdate');
			$edate = $this->input->post('edate');
			$this->load->model('company_report_model');
			$ioc_list = $this->company_report_model->get_ioc_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$get_credit_by_customer_ioc = $this->company_report_model->get_credit_by_customer_ioc($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$this->load->model('Daily_reports_model_new_jun');
			$company_credit = $this->Daily_reports_model_new_jun->company_credit($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$company_debit = $this->Daily_reports_model_new_jun->company_debit($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$total_company_credit = $this->Daily_reports_model_new_jun->total_company_credit($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$total_company_debit = $this->Daily_reports_model_new_jun->total_company_debit($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			
			$data['company_credit_debit'] = array();
			foreach($company_credit as $companycredit){
				$data['company_credit_debit']['c'][$companycredit->date] = $companycredit->totalamount;
			}
			foreach($company_debit as $companycredit){
				$data['company_credit_debit']['d'][$companycredit->date] = $companycredit->totalamount;
			}
			//
                        //echo $this->db->last_query();
			$prv_ioc_total = $this->company_report_model->get_pre_ioc_total($lid,date("Y-m-d",strtotime($sdate)));
			$get_prv_ioc_credit_by_customer = $this->company_report_model->get_prv_ioc_credit_by_customer($lid,date("Y-m-d",strtotime($sdate)));
			$transection_list = $this->company_report_model->get_online_transection_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			
                        $prv_transection_total = $this->company_report_model->get_pre_transection_total($lid,date("Y-m-d",strtotime($sdate)));
			$purchase_list = $this->company_report_model->get_purchase_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			//echo $this->db->last_query();
                        $prv_purchase_total = $this->company_report_model->get_pre_purchase_total($lid,date("Y-m-d",strtotime($sdate)));

			$fianlarray = array();
			$amount = 0;
			$custamount = 0;
			$wamount = 0;
			$pamount = 0;
			foreach($ioc_list as $ioc){
				$fianlarray[$ioc->date]['date'] = $ioc->date;
				$fianlarray[$ioc->date]['amount'] = $ioc->amount;
				$amount = $amount + $ioc->amount;
			}
			foreach($get_credit_by_customer_ioc as $coustomerioc){
				$fianlarray[$coustomerioc->date]['date'] = $coustomerioc->date;
				$fianlarray[$coustomerioc->date]['custamount'] = $coustomerioc->amount;
				$custamount = $custamount + $coustomerioc->amount;
			}
			foreach($transection_list as $ioc){
				$fianlarray[$ioc->date]['date'] = $ioc->date;
				$fianlarray[$ioc->date]['wamount'] = $ioc->oamount;
				$wamount = $wamount + $ioc->oamount;
			}
			foreach($purchase_list as $ioc){
				$fianlarray[$ioc->date]['date'] = $ioc->date;
				$fianlarray[$ioc->date]['pamount'] = $ioc->d_total_amount+$ioc->p_total_amount;
				$pamount = $pamount + $ioc->d_total_amount+$ioc->p_total_amount;
			}
			function sortByName($a, $b)
			{
				$a = $a['date'];
				$b = $b['date'];

				if ($a == $b) return 0;
				return ($a < $b) ? -1 : 1;
			}
			usort($fianlarray, 'sortByName');
			//print_r($data['company_credit_debit']);
			//echo "<pre>"; print_r($fianlarray); die();
			$cnt=1;
			$html = '';
			$company_credit = 0;
			$company_debit = 0;
			
			$openingstock = ($get_prv_ioc_credit_by_customer->totalamount+$prv_ioc_total->totalamount+$prv_transection_total->totalamount+$total_company_credit->totalamount)-($prv_purchase_total->d_total_amount+$prv_purchase_total->p_total_amount+$total_company_debit->totalamount);
			$html .= '<tr><td colspan ="2">Opening Balance</td><td>'.amountfun(($prv_ioc_total->totalamount+$prv_transection_total->totalamount+$total_company_credit->totalamount)-($prv_purchase_total->d_total_amount+$prv_purchase_total->p_total_amount+$total_company_debit->totalamount)).'</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
			foreach($fianlarray as $creditdetail){
				$cdate = date("d-m-Y",strtotime($creditdetail["date"]));
				$company_credit = $company_credit + $data['company_credit_debit']['c'][$creditdetail["date"]];
				$company_debit = $company_debit + $data['company_credit_debit']['d'][$creditdetail["date"]];
				$html .= '<tr>
					<td>'.$cnt.'</td>
					<td>'.$cdate.'</td>
					<td>'.amountfun($creditdetail["amount"]).'</td>
					<td>'.amountfun($creditdetail["wamount"]).'</td>
					<td>'.amountfun($creditdetail["pamount"]).'</td>
					<td>'.amountfun($data['company_credit_debit']['c'][$creditdetail["date"]]).'</td>
					<td>'.amountfun($data['company_credit_debit']['d'][$creditdetail["date"]]).'</td>
					<td>'.amountfun($creditdetail["custamount"]).'</td>';
					if(in_array("company_report_action",$this->data['user_permission_list'])){
					$html .= '<td><a href="'.base_url().'company_report/company_report_details?date='.$cdate.'&l_id='.$lid.'&sdate='.$sdate.'&edate='.$edate.'">
						<i class="fa fa-eye"></i></a>
					</td>';
					}
				$html .= '</tr>';
				$cnt++;
			}
			if($cnt == 0){
				$html .= '<tr><td colspan="8">No Data avalieble</td></tr>';
			}
			
			$html .= '<tr><td colspan="2">Balance</td><td>'.amountfun($amount).'</td><td>'.amountfun($wamount).'</td><td>'.amountfun($pamount).'</td><td>'.amountfun($company_credit).'</td><td>'.amountfun($company_debit).'</td><td>'.amountfun($custamount).'</td></tr>';
			
			$html .= '<tr><td colspan="2">Closing Balance</td><td colspan = "4">'.amountfun((($openingstock)+$amount+$wamount+$company_credit+$custamount)-($pamount+$company_debit)).'</td></tr>';

			echo $html;
		}
		
		function company_report_details(){
			$date = date("Y-m-d",strtotime($this->input->get('date')));
			$location = $this->input->get('l_id');
			$id = $_SESSION['logged_company']['id'];
			$data["logged_company"] = $_SESSION['logged_company'];
			$this->load->model('company_report_model');
			$data['depositbycard'] = $this->company_report_model->depositbycard_list_view($date,$location);
			$data['transonline'] = $this->company_report_model->transonline_list_view($date,$location);
			$data['purchaseamount'] = $this->company_report_model->purchaseamount_list_view($date,$location);
			$data['company_credit_debit'] = $this->company_report_model->company_credit_debit($date,$location);
			$data['company_credit_by_customer'] = $this->company_report_model->company_credit_by_customer($date,$location);
			// print_r($data['transonline']);
			// print_r($data['purchaseamount']);
			// die();
			$this->load->view('web/company_report_view',$data);  
		}
		
		function company_credit_by_customer_edit(){
			if(!$this->session->userdata('logged_company')){
				redirect('company_login');
			}
			$id= $this->input->get('id');
			$this->load->model('company_report_model');
			$this->load->model('daily_reports_model');
			$data["logged_company"] = $this->session->userdata('logged_company');
			$data['detail'] = $this->company_report_model->get_one('sh_credit_debit',array('id'=>$id));
			$data['customerlist'] = $this->daily_reports_model->customer_list($data['detail']->location_id);
			$date = date('d-m-Y',strtotime($data['detail']->date));
			$lid = $data['detail']->location_id;
			$this->form_validation->set_rules('deposit_amount', 'Amount', 'trim|required');
			$data['id'] = $id;
			$data['sdate'] = $sdate = $this->input->get('sdate');
			$data['edate'] = $edate = $this->input->get('edate');
			if ($this->form_validation->run() != FALSE) {
				
				$data = array(
					'amount' => $this->input->post('deposit_amount'), 
					'customer_id' => $this->input->post('coustomerid'), 
				);
				$update = $this->company_report_model->update('sh_credit_debit',array('id'=>$id),$data);
				$this->session->set_flashdata('success_update','Updated Successfully..');
				
				redirect('company_report?sdate='.$sdate."&edate=".$edate."&location=".$lid);
			}
			$this->load->view('web/company_credit_by_customer',$data);
		}
		function company_credit_by_customer_delete(){
			if(!$this->session->userdata('logged_company')){
				redirect('company_login');
			}
			$id= $this->input->get('id');
			$this->load->model('company_report_model');
			$data['sdate'] = $sdate = $this->input->get('sdate');
			$data['edate'] = $edate = $this->input->get('edate');
			$data['detail'] = $this->company_report_model->get_one('sh_credit_debit',array('id'=>$id));
			$lid = $data['detail']->location_id;
			$data = array(
				'status' => '0'
			);
			$update = $this->company_report_model->update('sh_credit_debit',array('id'=>$id),$data);
			$this->session->set_flashdata('success_update','Delete Successfully..');
			redirect('company_report?sdate='.$sdate."&edate=".$edate."&location=".$lid);
		}
		
		
		function print_report_pdf() {
			
			$lid = $this->input->get('location');
			$sdate = $this->input->get('sdate');
			$edate = $this->input->get('edate');
			$data['sdate'] = $sdate;
			$data['edate'] = $edate;
			$this->load->model('company_report_model');
			$ioc_list = $this->company_report_model->get_ioc_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$data['prv_ioc_total'] = $this->company_report_model->get_pre_ioc_total($lid,date("Y-m-d",strtotime($sdate)));
			$transection_list = $this->company_report_model->get_online_transection_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$data['prv_transection_total'] = $this->company_report_model->get_pre_transection_total($lid,date("Y-m-d",strtotime($sdate)));
			$purchase_list = $this->company_report_model->get_purchase_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$data['prv_purchase_total'] = $this->company_report_model->get_pre_purchase_total($lid,date("Y-m-d",strtotime($sdate)));
			$this->load->model('Daily_reports_model_new_jun');
			$company_debit = $this->Daily_reports_model_new_jun->company_debit($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$company_credit = $this->Daily_reports_model_new_jun->company_credit($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$data['total_company_credit'] = $this->Daily_reports_model_new_jun->total_company_credit($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$data['total_company_debit'] = $this->Daily_reports_model_new_jun->total_company_debit($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$fianlarray = array();
			$data['amount'] = 0;
			$data['wamount'] = 0;
			$data['pamount'] = 0;
			foreach($ioc_list as $ioc){
				$fianlarray[$ioc->date]['date'] = $ioc->date;
				$fianlarray[$ioc->date]['amount'] = $ioc->amount;
				$data['amount'] = $data['amount'] + $ioc->amount;
			}
			foreach($transection_list as $ioc){
				$fianlarray[$ioc->date]['date'] = $ioc->date;
				$fianlarray[$ioc->date]['wamount'] = $ioc->oamount;
				$data['wamount'] = $data['wamount'] + $ioc->oamount;
			}
			foreach($purchase_list as $ioc){
				$fianlarray[$ioc->date]['date'] = $ioc->date;
				$fianlarray[$ioc->date]['pamount'] = $ioc->d_total_amount+$ioc->p_total_amount;
				$data['pamount'] = $data['pamount'] + $ioc->d_total_amount+$ioc->p_total_amount;
			}
			$data['company_credit_debit'] = array();
			foreach($company_credit as $companycredit){
				$data['company_credit_debit']['c'][$companycredit->date] = $companycredit->totalamount;
			}
			foreach($company_debit as $companycredit){
				$data['company_credit_debit']['d'][$companycredit->date] = $companycredit->totalamount;
			}
			//print_r($data['company_credit_debit']); die();
			function sortByName($a, $b)
			{
				$a = $a['date'];
				$b = $b['date'];

				if ($a == $b) return 0;
				return ($a < $b) ? -1 : 1;
			}
			usort($fianlarray, 'sortByName');
			$data['fianlarray'] = $fianlarray;
			$this->load->model('daily_reports_model');
			$data['location_detail'] = $this->daily_reports_model->location_detail($lid);
			$this->load->library('m_pdf');
			$html = $this->load->view('web/pdfcompanyreport.php', $data, true); 
			
			$pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "invoice.pdf";
		
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
	function card_deposit_edit($id){
		if(!$this->session->userdata('logged_company'))
		{
			redirect('company_login');
		}
		$this->load->model('company_report_model');
		$data["logged_company"] = $this->session->userdata('logged_company');
		$data['detail'] = $this->company_report_model->get_one('sh_credit_debit',array('id'=>$id));
		$date = date('d-m-Y',strtotime($data['detail']->date));
		$lid = $data['detail']->location_id;
		$this->form_validation->set_rules('deposit_amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('batch_no', 'Batch Number', 'trim|required');
		$data['id'] = $id;
        if ($this->form_validation->run() != FALSE) {
			$data = array(
							'amount' => $this->input->post('deposit_amount'), 
			 				'batch_no' => $this->input->post('batch_no'),
			 			);
				$update = $this->company_report_model->update('sh_credit_debit',array('id'=>$id),$data);
				$this->session->set_flashdata('success_update','Updated Successfully..');
			  redirect('company_report/company_report_details?date='.$date."&l_id=".$lid);
		}
		$this->load->view('web/company_report_card_edit',$data);
	}
	function card_deposit_delete($id){
		if(!$this->session->userdata('logged_company'))
		{
			redirect('company_login');
		}
		$this->load->model('company_report_model');
		$data["logged_company"] = $this->session->userdata('logged_company');
		$data['detail'] = $this->company_report_model->get_one('sh_credit_debit',array('id'=>$id));
		$date = date('d-m-Y',strtotime($data['detail']->date));
		$lid = $data['detail']->location_id;
		$data = array(
					'status' => '0'
				); 
		$update = $this->company_report_model->update('sh_credit_debit',array('id'=>$id),$data);
		$this->session->set_flashdata('success_update','Deleted Successfully..');
		redirect('company_report/company_report_details?date='.$date."&l_id=".$lid);
	}
	function online_transection_edit($id){
		if(!$this->session->userdata('logged_company'))
		{
			redirect('company_login');
		}
		$this->load->model('company_report_model');
		$data["logged_company"] = $this->session->userdata('logged_company');
		$data['detail'] = $this->company_report_model->get_one('sh_onlinetransaction',array('id'=>$id));
		$date = date('d-m-Y',strtotime($data['detail']->date));
		$lid = $data['detail']->location_id;
		$this->form_validation->set_rules('deposit_amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('batch_no', 'Transaction Number', 'trim|required');
		$data['id'] = $id;
        if ($this->form_validation->run() != FALSE) {
			$data = array(
							'amount' => $this->input->post('deposit_amount'), 
			 				'cheque_tras_no' => $this->input->post('batch_no'),
			 			);
				$update = $this->company_report_model->update('sh_onlinetransaction',array('id'=>$id),$data);
				
				$this->session->set_flashdata('success_update','Updated Successfully..');
			  redirect('company_report/company_report_details?date='.$date."&l_id=".$lid);
		}
		$this->load->view('web/company_report_online_transection_edit',$data);
	}
	function online_transection_delete($id){
		if(!$this->session->userdata('logged_company'))
		{
			redirect('company_login');
		}
		$this->load->model('company_report_model');
		$data["logged_company"] = $this->session->userdata('logged_company');
		$data['detail'] = $this->company_report_model->get_one('sh_onlinetransaction',array('id'=>$id));
		$date = date('d-m-Y',strtotime($data['detail']->date));
		$lid = $data['detail']->location_id;
		$data = array(
					'status' => '0'
				); 
		$update = $this->company_report_model->update('sh_onlinetransaction',array('id'=>$id),$data);
		$this->session->set_flashdata('success_update','Deleted Successfully..');
		redirect('company_report/company_report_details?date='.$date."&l_id=".$lid);
	}
	function purches_amount_edit(){
		if(!$this->session->userdata('logged_company'))
		{
			redirect('company_login');
		}
		$id= $this->input->get('id');
		$this->load->model('company_report_model');
		$data["logged_company"] = $this->session->userdata('logged_company');
		$data['detail'] = $this->company_report_model->get_one('sh_inventory',array('id'=>$id));
		$date = date('d-m-Y',strtotime($data['detail']->date));
		$lid = $data['detail']->location_id;
		$this->form_validation->set_rules('deposit_amount', 'Amount', 'trim|required');
		$data['id'] = $id;
        if ($this->form_validation->run() != FALSE) {
			if($data['detail']->fuel_type == "d"){
			$data = array(
				'd_total_amount' => $this->input->post('deposit_amount'), 
			);
			}else{
			$data = array(
				'p_total_amount' => $this->input->post('deposit_amount'), 
			);	
			}
			$update = $this->company_report_model->update('sh_inventory',array('id'=>$id),$data);
			$this->session->set_flashdata('success_update','Updated Successfully..');
			$sdate = $this->input->get('sdate');
			$edate = $this->input->get('edate');
			redirect('company_report?sdate='.$sdate."&edate=".$edate."&location=".$lid);
		}
		$this->load->view('web/company_purches_amount_edit',$data);
	}
	function purches_amount_delete($id){
		if(!$this->session->userdata('logged_company'))
		{
			redirect('company_login');
		}
		$this->load->model('company_report_model');
		$data["logged_company"] = $this->session->userdata('logged_company');
		$data['detail'] = $this->company_report_model->get_one('sh_inventory',array('id'=>$id));
		$date = date('d-m-Y',strtotime($data['detail']->date));
		$lid = $data['detail']->location_id;
		$data = array(
					'status' => '0'
				); 
		$update = $this->company_report_model->update('sh_inventory',array('id'=>$id),$data);
		$this->session->set_flashdata('success_update','Deleted Successfully..');
		redirect('company_report/company_report_details?date='.$date."&l_id=".$lid);
	}
	function edit_credit_debit(){
		if(!$this->session->userdata('logged_company'))
		{
			redirect('company_login');
		}
		$id= $this->input->get('id');
		$this->load->model('company_report_model');
		$data["logged_company"] = $this->session->userdata('logged_company');
		$data['detail'] = $this->company_report_model->get_one('sh_company_credit_debit',array('id'=>$id));
		$date = date('d-m-Y',strtotime($data['detail']->date));
		$lid = $data['detail']->location_id;
		$this->form_validation->set_rules('deposit_amount', 'Amount', 'trim|required');
		$data['id'] = $id;
        if ($this->form_validation->run() != FALSE) {
			
			$data = array(
				'amount' => $this->input->post('deposit_amount'), 
			);
			
			$update = $this->company_report_model->update('sh_company_credit_debit',array('id'=>$id),$data);
			$this->session->set_flashdata('success_update','Updated Successfully..');
			$sdate = $this->input->get('sdate');
			$edate = $this->input->get('edate');
			redirect('company_report?sdate='.$sdate."&edate=".$edate."&location=".$lid);
		}
		$this->load->view('web/company_credit_debit_edit',$data);
	}
	function edit_credit_delete($id){
		if(!$this->session->userdata('logged_company'))
		{
			redirect('company_login');
		}
		$this->load->model('company_report_model');
		$data["logged_company"] = $this->session->userdata('logged_company');
		$data['detail'] = $this->company_report_model->get_one('sh_company_credit_debit',array('id'=>$id));
		$date = date('d-m-Y',strtotime($data['detail']->date));
		$lid = $data['detail']->location_id;
		$data = array(
					'status' => '0'
				); 
				$cdate = date('Y-m-d H:i:s');
				$ddate = '2019-07-02 21:00:00';
				if(strtotime($cdate) < strtotime($ddate)){
		//die();
				}
		$update = $this->company_report_model->update('sh_company_credit_debit',array('id'=>$id),$data);
		$this->session->set_flashdata('success_update','Deleted Successfully..');
		redirect('company_report/company_report_details?date='.$date."&l_id=".$lid);
	}
}
?>