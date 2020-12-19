<?php
	class Daily_invoice extends CI_Controller
	{
		function __construct() {
	parent::__construct();
	if ($this->session->userdata('logged_company')) {
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

	} 
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
			$this->load->view('web/daily_invoice',$data);
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
		
		function invocelist(){
			$lid = $this->input->post('lid');
			$sdate = $this->input->post('sdate');
			$this->load->model('daily_invoice_model');
			$totalprev_credit = $this->daily_invoice_model->daily_invoice_data($lid,date("Y-m-d",strtotime($sdate)));
			
			$dailyprice = $this->daily_invoice_model->dailyprice($lid,date("Y-m-d",strtotime($sdate)));
			
		//	echo json_encode(array("list"=>$totalprev_credit,"price"=>$dailyprice)); die();
			//echo $this->db->last_query(); die();
			$cnt=1;
			$html = '';
			$finalcurrentdue = 0;
			$finalpastdue = 0;
			$test1 = 0;
			$test2 = 0;
			$totalquantity = 0;
			foreach($totalprev_credit as $creditdetail){
				$currentdue = number_format($creditdetail->current_credit-$creditdetail->current_debit,2);
				$pastdue = number_format($creditdetail->past_credit-$creditdetail->past_debit,2);
				$quantity = number_format($creditdetail->current_credit/$dailyprice->dis_price,2);
				$totalquantity = $totalquantity+$quantity;
				$due = number_format(($creditdetail->current_credit-$creditdetail->current_debit) + ($creditdetail->past_credit-$creditdetail->past_debit),2);
				$test1 = $test1 + $creditdetail->current_credit;
				$test2 = $test2 + $creditdetail->current_debit;
				$html .= '<tr><td>'.$cnt.'</td><td>'.$sdate.'</td><td>'.$creditdetail->name.'</td><td>'.$quantity.'</td><td>'.number_format($creditdetail->current_debit,2).'</td><td>'.number_format($creditdetail->current_credit,2).'</td><td>'.$pastdue.'</td><td>'.$due.'</td></tr>';
				$finalcurrentdue = $finalcurrentdue + ($creditdetail->current_credit-$creditdetail->current_debit);
				$finalpastdue = $finalpastdue + ($creditdetail->past_credit-$creditdetail->past_debit);
				$cnt++;
			}
			if($cnt == 0){
				$html .= '<tr><td colspan="8">No Data avalieble</td></tr>';
			}
			$final = $finalpastdue+$finalcurrentdue;
			$html .= '<tr><td colspan="3">Total</td><td>'.number_format($totalquantity,2).'</td><td>'.number_format($test2,2).'</td><td>'.number_format($test1,2).'</td><td>'.number_format($finalpastdue,2).'</td><td>'.number_format($final,2).'</td></tr>';
			
			echo $html;
		}
		function print_invoice_pdf() {
			
			$lid = $this->input->get('lid');
			$sdate = $this->input->get('sdate');
			$this->load->model('daily_invoice_model');
			$data['totalprev_credit'] = $this->daily_invoice_model->daily_invoice_data($lid,date("Y-m-d",strtotime($sdate)));
			$data['dailyprice'] = $this->daily_invoice_model->dailyprice($lid,date("Y-m-d",strtotime($sdate)));
			$data['sdate'] = $sdate;
			$this->load->model('daily_reports_model');
			$data['location_detail'] = $this->daily_reports_model->location_detail($lid);
			$this->load->library('m_pdf');
			$html = $this->load->view('web/pdfdailyinvoice.php', $data, true); 
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
}
?>