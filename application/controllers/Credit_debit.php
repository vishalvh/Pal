<?php
	class Credit_debit extends CI_Controller
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
	/*if ($this->session->userdata('logged_company')) {
		$this->load->model('user_login');
		if($this->session->userdata('logged_company')['type'] == 'c'){
			$sesid = $this->session->userdata('logged_company')['id'];
			$this->data['all_location_list'] = $this->user_login->get_all_location($sesid);
		}else{
			$sesid = $this->session->userdata('logged_company')['u_id'];
			$this->data['all_location_list'] = $this->user_login->get_location($sesid);
		}
		
				$this->load->library('Web_log');
		$p = new Web_log;
		$this->allper = $p->Add_data();

	}*/
	$this->load->helper("amount");
}
		function index()
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

			$id1 =  $_SESSION['logged_company']['id'];
			$this->load->model('admin_model');
			if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location_list'] = $this->admin_model->select_location($id1);
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['location_list'] = $this->admin_model->get_location($u_id);
        }
			if($this->input->get_post('month') == ""){
				$month = date('m');
			}else{
				$month = $this->input->get_post('month');
			}
			if($this->input->get_post('month') == ""){
			$year = date('Y');
			}else{
				$year = $this->input->get_post('year');
			}
			$location_id = $this->input->get_post('location');
			$data['month'] = $month;
			$data['year'] = $year;
			$data['location'] = $location_id;
			if($location_id != ""){
			$data['report'] = $this->daily_reports_model->report($location_id,$month,$year);			
			$data['salary'] = $this->daily_reports_model->worker_salary_remening($location_id,$month,$year);			
			$data['lastday'] = $this->daily_reports_model->last_day_entry($location_id,$month,$year);			
			$data['monthly_expence'] = $this->daily_reports_model->monthly_expence($location_id,$month,$year);
			}
			$this->load->view('web/credit_debit',$data);
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
				$data['customerlist'] =  $this->daily_reports_model->customer_list($lid);
				

        	}
        	

			$id1 =  $_SESSION['logged_company']['id'];
			$this->load->model('admin_model');
			if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location_list'] = $this->admin_model->select_location($id1);
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['location_list'] = $this->admin_model->get_location($u_id);
        }
			$this->load->view('web/credit_debit_report',$data);
		}
		
		function reportlist(){
			$lid = $this->input->post('lid');
			$sdate = $this->input->post('sdate');
			$edate = $this->input->post('edate');
			$custid = $this->input->post('custid');
			$this->load->model('daily_reports_model');
			$customerceditlist = $this->daily_reports_model->get_customer_credit_debit_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)),$custid);
			// echo $this->db->last_query();
			// print_r($customerceditlist);
			$cnt=1;
			$html = '';
			$qty = 0;
			$amount = 0;
			$prevbalence = $totalprev_credit->totalamount-$totalprev_debit->totalamount;
			$tcredit = 0;
			$debit = 0;
			foreach($customerceditlist as $credit){
				$tamount1 = 0;
				$tamount2 = 0;
				$date = $credit->date;
				$paymentfor = '';
				if($credit->payment_type == 'c'){
					$type = 'Credit';
					$debit = $debit + $credit->amount;
					$tamount1 = $credit->amount;
					$paymentfor = $credit->bill_no;
				}else{
					$type = 'Debit';
					$tamount2 = $credit->amount;
					$tcredit = $tcredit + $credit->amount;
					if($credit->transaction_type == 'cs'){
						$paymentfor = 'Cash';
					}
					if($credit->transaction_type == 'c'){
						$paymentfor = 'Cheque';
					}
					if($credit->transaction_type == 'n'){
						$paymentfor = 'Netbanking';
					}
				}

				$msg = '"Are you sure you want to remove this data?"';
                  //               if($this->session->userdata('logged_company')['type'] == 'c'){
                    	$edit = "<a href='".$base_url."edit/".$credit->id."/".$sdate."/".$edate."/".$lid."/".$custid." '><i class='fa fa-edit'></i></a>  
						 <a href='".$base_url."delete/".$credit->id."/".$sdate."/".$edate."/".$lid."/".$custid."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
						 
						 if($type == 'Debit'){
							 $edit .=  "&nbsp;&nbsp;<a target='_blank' href='".$base_url."print_credit_debit_report_by_pdf?id=".$credit->id."&date=".$sdate."&credit=".$type."&lib=".$lid."&customer_id=".$custid."'><i class='fa fa-print'></i></a>";
						 }
							
				$html .= '<tr><td>'.$cnt.'</td><td>'.date('d/m/Y',strtotime($date)).'</td><td>'.$type.'</td><td>'.amountfun($tamount1).'</td><td>'.amountfun($tamount2).'</td><td>'.$paymentfor.'</td>';
if(in_array("credit_debit_report_action",$this->data['user_permission_list'])){
	
						$html .= '<td>
							'.$edit.'
						</td>';
}
					$html .= '</tr>';
                /*}  else{ 
				if($type == 'Debit'){
					$edit =  "&nbsp;&nbsp;<a target='_blank' href='".$base_url."print_credit_debit_report_by_pdf?id=".$credit->id."&date=".$sdate."&credit=".$type."&lib=".$lid."&customer_id=".$custid."'><i class='fa fa-print'></i></a>";
                    $html .= '<tr><td>'.$cnt.'</td><td>'.date('d/m/Y',strtotime($date)).'</td><td>'.$type.'</td><td>'.amountfun($tamount1).'</td><td>'.amountfun($tamount2).'</td><td>'.$paymentfor.'</td><td>'.$edit.'</td>
					</tr>';
				}else{
					$html .= '<tr><td>'.$cnt.'</td><td>'.date('d/m/Y',strtotime($date)).'</td><td>'.$type.'</td><td>'.amountfun($tamount1).'</td><td>'.amountfun($tamount2).'</td><td>'.$paymentfor.'</td><td></td>
					</tr>';
				}
                }*/
				
				$cnt++;
			}
			if($cnt == 0){
				$html .= '<tr><td colspan="6">No Data avalieble</td></tr>';
			}
			
			$html .= '<tr><td colspan="3">Total</td><td>'.amountfun($debit).'</td><td>'.amountfun($tcredit).'</td><td></td><td></td></tr>';
			$html .= '<tr><center><td colspan="3">Final Total</td><td colspan="2">'.amountfun($debit -$tcredit).'</td><td></td><td></td></center></tr>';

			
			echo $html;
		}
		
		
		function customer_list(){
			$customer_id = $this->uri->segment(3);

			$lid = $this->input->post('lid');
			$this->load->model('daily_reports_model');
			$customerlist = $this->daily_reports_model->customer_list($lid);
			$html = '<option value="">Select Customer </option>';
			foreach ($customerlist as $customer){

				$selected = "";
				if($customer_id == $customer->id) { $selected = "selected"; }
				$html .= '<option value="'.$customer->id.'" '.$selected.'>'.$customer->name.'</option>';
			}
			echo $html;
		}
		function invocelist(){
			$lid = $this->input->post('lid');
			$sdate = $this->input->post('sdate');
			$edate = $this->input->post('edate');
			$custid = $this->input->post('custid');
			$this->load->model('daily_reports_model');
			$customerceditlist = $this->daily_reports_model->get_customer_credit_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)),$custid);
			//echo $this->db->last_query();
			$totaldebit = $this->daily_reports_model->get_customer_debit_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)),$custid);
			$totalprev_debit = $this->daily_reports_model->totalprev_credit_debit($lid,date("Y-m-d",strtotime($sdate)),$custid,'d');
			$totalprev_credit = $this->daily_reports_model->totalprev_credit_debit($lid,date("Y-m-d",strtotime($sdate)),$custid,'c');
			
			$cnt=1;
			$html = '';
			$qty = 0;
			$amount = 0;
			$prevbalence = $totalprev_debit->totalamount-$totalprev_credit->totalamount;
			foreach($customerceditlist as $credit){
				$html .= '<tr><td>'.$cnt.'</td><td>'.date('d/m/Y',strtotime($credit->date)).'</td><td>'.$credit->vehicle_no.'</td><td>'.$credit->bill_no.'</td>';
				if($credit->fuel_type == 'Diesel'){
					$html .= '<td>'.$credit->dis_pri.'</td>';
				}else if($credit->fuel_type == 'Petrol'){
					$html .= '<td>'.amountfun($credit->pet_pri).'</td>';
				}else{
					$html .= '<td></td>';
				}
				$html .= '<td>'.amountfun($credit->quantity).'</td><td>'.amountfun($credit->amount).'</td></tr>';
				$amount = $amount+$credit->amount;
				$qty = $qty + $credit->quantity;
				$cnt++;
			}
			if($cnt == 0){
				$html .= '<tr><td colspan="6">No Data avalieble</td></tr>';
			}
			$final = $amount-$totaldebit->totalamount-$prevbalence;
			$html .= '<tr><td colspan="5">Total</td><td>'.$qty.'</td><td>'.amountfun($amount).'</td></tr>';
			$html .= '<tr><td colspan="6">Total Paid Amount </td><td>'.amountfun($totaldebit->totalamount).'</td></tr>';
			$html .= '<tr><td colspan="6">Previous Balance</td><td>'.amountfun($prevbalence).'</td></tr>';
			$html .= '<tr><td colspan="6">Final Total Due Amount</td><td>'.amountfun($final).'</td></tr>';
			echo $html;
		}
		function print_invoice_pdf() {
			
			$lid = $this->input->get('lid');
			$sdate = $this->input->get('sdate');
			$edate = $this->input->get('edate');
			$custid = $this->input->get('Employeename');
			$this->load->model('daily_reports_model');
			$data['customerceditlist'] = $this->daily_reports_model->get_customer_credit_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)),$custid);
			$data['totaldebit'] = $this->daily_reports_model->get_customer_debit_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)),$custid);
			$data['custdetail'] = $this->daily_reports_model->custdetail($custid);
			$data['location_detail'] = $this->daily_reports_model->location_detail($lid);
			$data['totalprev_debit'] = $this->daily_reports_model->totalprev_credit_debit($lid,date("Y-m-d",strtotime($sdate)),$custid,'d');
			$data['totalprev_credit'] = $this->daily_reports_model->totalprev_credit_debit($lid,date("Y-m-d",strtotime($sdate)),$custid,'c');
			
			$data['bildate'] =  date('d/m/Y');
			if($_GET['bildate'] != ''){
				$data['bildate'] = date('d/m/Y',strtotime($_GET['bildate']));
			}
			$this->load->library('m_pdf');
			$html = $this->load->view('web/pdfinvoice.php', $data, true); 
			$pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "invoice.pdf";
		
			$lorem = utf8_encode($html); // render the view into HTML
            $pdf = $this->m_pdf->load();
            $pdf->AddPage('P', // L - landscape, P - portrait
                    '', '', '', '', '5', // margin_left
                    '5', // margin right
                    '5', // margin top
                    '5', // margin bottom
                    '0', // margin header
                    '0'); // margin footer
            $pdf->SetDisplayMode('fullpage');
            $pdf->h2toc = array('H2' => 0);
            $html = '';
			$pdf->setFooter('{PAGENO}');
            $pdf->WriteHTML($lorem);
            $pdf->debug = true;
            $pdf->Output($pdfFilePath, "I");
           
    }
    
    
    
    function print_credit_debit_report_pdf() {
			
			$lid = $this->input->get('lid');
			$data['sdate'] = $sdate = $this->input->get('sdate');
			$data['edate'] = $edate = $this->input->get('edate');
			$custid = $this->input->get('Employeename');
			$this->load->model('daily_reports_model');
			$data['location_detail'] = $this->daily_reports_model->location_detail($lid);
			$data['custdetail'] = $this->daily_reports_model->custdetail($custid);
			//print_r($data['custdetail']); die();
			$data['customerceditlist'] = $this->daily_reports_model->get_customer_credit_debit_list($lid,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)),$custid);
			$this->load->library('m_pdf');

			$html = $this->load->view('web/credit_debit_report_pdf.php', $data, true); 
			$pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "invoice.pdf";
		
			$lorem = utf8_encode($html); // render the view into HTML
            $pdf = $this->m_pdf->load();
            $pdf->AddPage('P', // L - landscape, P - portrait
                    '', '', '', '', '5', // margin_left
                    '5', // margin right
                    '5', // margin top
                    '5', // margin bottom
                    '0', // margin header
                    '0'); // margin footer
            $pdf->SetDisplayMode('fullpage');
            $pdf->h2toc = array('H2' => 0);
            $html = '';
			$pdf->setFooter('{PAGENO}');
            $pdf->WriteHTML($lorem);
            $pdf->debug = true;
            $pdf->Output($pdfFilePath, "I");
           
    }
	/* vishal d patel code start 01-05-2019*/
	function print_credit_debit_report_by_pdf() {
			$seg1 = $this->input->get('id');
			$data['sdate']=$seg2 = $this->input->get('date');
			$data['credit']=$seg3 = $this->input->get('credit');
			$seg4 = $this->input->get('lib');
			$seg5 = $this->input->get('customer_id');
			
			$this->load->model('daily_reports_model');
			$data['location_detail'] = $this->daily_reports_model->location_detail($seg4);
			
			$data['customerceditlist'] = $this->daily_reports_model->get_customer_credit_debit_listbyid($seg1);
			
			$data['custdetail'] = $this->daily_reports_model->custdetail($data['customerceditlist'][0]->customer_id);
			$data['empdetail'] = $this->daily_reports_model->empdetail($data['customerceditlist'][0]->user_id);
			$this->load->library('m_pdf');
			$html = $this->load->view('web/credit_debit_report_pdf_byid.php', $data, true); 
			$pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "invoice.pdf";
		
			$lorem = utf8_encode($html); // render the view into HTML
            $pdf = $this->m_pdf->load();
            $pdf->AddPage('P', // L - landscape, P - portrait
                    '', '', '', '', '5', // margin_left
                    '5', // margin right
                    '5', // margin top
                    '5', // margin bottom
                    '0', // margin header
                    '0'); // margin footer
            $pdf->SetDisplayMode('fullpage');
            $pdf->h2toc = array('H2' => 0);
            $html = '';
			$pdf->setFooter('{PAGENO}');
            $pdf->WriteHTML($lorem);
            $pdf->debug = true;
            $pdf->Output($pdfFilePath, "I");
           
    }
	/*vishal d patel code end 01-05-2019*/
    // pranjal code start 24-7-18
    function delete()
    {
        
    		if(!$this->session->userdata('logged_company'))
			{
            	redirect('company_login');
      		}
                 if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('credit_debit/report');
        }
    		$this->load->model('Daily_reports_model');
			$id = $this->uri->segment('3');
			
			$start_date = $this->uri->segment('4');
			$end_date = $this->uri->segment('5');
			$location_id = $this->uri->segment('6');
			$customer_id = $this->uri->segment('7');

			$data['flag'] = 1;
                         $credit_debit_data = $this->Daily_reports_model->get_creditdebitdata($id);
        $t_id = $credit_debit_data[0]->bankdeposit_id;
         $t_sub_amount = $credit_debit_data[0]->amount;
         $creditdebit_total = $this->Daily_reports_model->get_creditdebit_total($t_id);
         $t_amount =  $creditdebit_total[0]->amount;
         $t2_amount = ($t_amount)-($t_sub_amount);
			$data1 = array(
							
							'status' => '0'
						);
			$this->Daily_reports_model->delete($id,$data1);
                        $data2 = array('amount'=> $t2_amount);
                    $this->Daily_reports_model->update_bankdeposit($t_id,$data2);
			$this->session->set_flashdata('success','Deleted Successfully.');
			redirect('credit_debit/report?start_date='.$start_date.'&end_date='.$end_date.'&location_id='.$location_id.'&customer_id='.$customer_id.'&flag=1');
    }

    function edit()
    {

    	if(!$this->session->userdata('logged_company'))
		{
        	redirect('company_login');
  		}
                if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('credit_debit/report');
        }
    	$data["logged_company"] = $_SESSION['logged_company'];
    	$id = $this->uri->segment(3);
    	$start_date = $this->uri->segment('4');
		$end_date = $this->uri->segment('5');
		$location_id = $this->uri->segment('6');
		$customer_id = $this->uri->segment('7');

		$this->load->model('Daily_reports_model');
		$data['query'] = $this->Daily_reports_model->get_creditdebitdata($id);
		//echo $this->db->last_query();
		//die();
		
		$this->load->view('web/credit_debit_edit_report',$data);
    }
    function update()
    { 
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('credit_debit/report');
        }
    	$this->load->model('Daily_reports_model');
    	$id = $this->uri->segment(3);
    	$date = date('Y-m-d',strtotime($this->input->post('date')));
    	$fuel_type = $this->input->post('fuel_type');
    	$ptype = $this->input->post('type');
    	$amount = $this->input->post('amount');
    	$bill_no = $this->input->post('bill_no');
    	$vehicle_no = $this->input->post('vehicle_no');
    	$quantity = $this->input->post('quantity');
    	$remark = $this->input->post('remark');
        $credit_debit_data = $this->Daily_reports_model->get_creditdebitdata($id);
        $t_id = $credit_debit_data[0]->bankdeposit_id;
         $t_sub_amount = $credit_debit_data[0]->amount;
         $creditdebit_total = $this->Daily_reports_model->get_creditdebit_total($t_id);
         $t_amount =  $creditdebit_total[0]->amount;
         $t2_amount = ($t_amount)-($t_sub_amount);
    	
    	if ($ptype == 'c') 
    	{
  			$ttype = $this->input->post('ptype');
    	}
    	else
    	{
    		$ttype = $this->input->post('ptype');
    	}
	$ttype = 	$this->input->post('ptype');
		if($ttype == 'n' || $ttype == 'c'){
			$chequeno = $this->input->post('chequeno');
			$bank_name = $this->input->post('bank_name');
			
		}else{
			$chequeno = "";
			$bank_name = "";
		}
		

    	$start_date = $this->uri->segment('4');
		$end_date = $this->uri->segment('5');
		$location_id = $this->uri->segment('6');
		$customer_id = $this->uri->segment('7');
    	$data = array(
    		'date' => $date,
    		'payment_type' => $ptype, 
    		'amount' => $amount,
    		'bill_no' => $bill_no,
			'vehicle_no'=> $vehicle_no,
			'quantity'=> $quantity,
			'fuel_type'=> $fuel_type,
			'remark'=>$remark

    	);
		if($ttype == 'n' || $ttype == 'c'){
		$data['transaction_number'] = $chequeno;
		$data['bank_name'] = $bank_name;
		
		}
		if($data['payment_type'] == 'd'){
			$data['transaction_type'] = $this->input->post('ptype');
		}else{
			$data['transaction_type'] = '';
		}
		
		// echo "<pre>";
		 // print_r($data);
		 
    	$this->Daily_reports_model->update($id,$data);
        $famount = $t2_amount+$amount;
        $data2 = array('amount'=> $famount);
        $this->Daily_reports_model->update_bankdeposit($t_id,$data2);
               
    	
		$this->session->set_flashdata('success','Updated Successfully.');
		redirect('credit_debit/report?start_date='.$start_date.'&end_date='.$end_date.'&location_id='.$location_id.'&customer_id='.$customer_id.'&flag=1');
    }

}
?>