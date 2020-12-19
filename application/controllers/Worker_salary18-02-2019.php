<?php
class Worker_salary extends CI_Controller
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
		$this->load->model('bank_deposit_model');
		if(!$this->session->userdata('logged_company'))
		{
			redirect('company_login');
		}
		$data['sdate'] = "";
		$data['edate'] = "";
		$data['l_id'] = "";
		$data['worker_id'] = "";
		if($this->input->get('sdate') != ""){ $data['sdate'] = date('d-m-Y',strtotime($this->input->get('sdate'))); }
		if($this->input->get('edate') != ""){ $data['edate'] = date('d-m-Y',strtotime($this->input->get('edate'))); }
		$data['worker_list'] = array();
		if($this->input->get('l_id') != ""){ 
			$data['l_id'] = $this->input->get('l_id'); 
			$data['worker_list'] = $this->bank_deposit_model->master_fun_get_tbl_val_workers('sh_workers', array('status'=>1 ,'location_id'=> $data['l_id'])); 
		}
		if($this->input->get('worker_id')){  $data['worker_id'] = $this->input->get('worker_id'); }
		$data["logged_company"] = $_SESSION['logged_company'];
		$c_id = $_SESSION['logged_company']['id'];
		if ($this->session->userdata('logged_company')['type'] == 'c') {
			
			//$data['location'] = $this->bank_deposit_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $c_id));
			$data['location'] = $this->bank_deposit_model->master_fun_get_tbl_val_location_new($c_id);
			
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['location'] = $this->bank_deposit_model->get_location($u_id);
        }
		$this->load->view('web/worker_salary_report',$data);
	}
        public function  worker_list(){
            $this->load->model('bank_deposit_model');
             $id = $this->input->post('where');
		 $uid = $id['id']; 
                 $c_id = $_SESSION['logged_company']['id'];
                 $data = $this->bank_deposit_model->master_fun_get_tbl_val_workers('sh_workers', array('status'=>1 ,'location_id'=> $uid, 'company_id'=> $c_id));
        echo json_encode($data);
            
        }

        public function reportlist()
  {

$data["logged_company"] = $_SESSION['logged_company'];
  $this->load->model('daily_reports_model');
$fdate = date("Y-m-d",strtotime($this->input->post('sdate')));
$tdate = date("Y-m-d",strtotime($this->input->post('edate')));
$location = $this->input->post('lid');
$worker_id = $this->input->post('worker_id');
$id = $_SESSION['logged_company']['id'];
$salary = $this->daily_reports_model->worker_salary_remening($location,$fdate,$tdate,$worker_id);
//echo $this->db->last_query();

    $base_url = base_url();
$html = "";
$msg = '"Are you sure you want to remove this data?"';	
$salarytotal = 0;
$bonas_amount = 0;
$extra_amount = 0;
$totaldebit = 0;
$paid_loan_amount = 0;
$advance = 0;
$past_loan_amount = 0;
      foreach($salary as $salary_detail){
$html .= "<tr>";
      
$no++;
                       
$edit = "<a href='".$base_url."worker_salary/worker_salary_list/".$salary_detail->id."/".$fdate."/".$tdate."/".$location."/".$worker_id." '>View</a>   
";
$html .= "<td>".$salary_detail->code."</td>";
$html .= "<td>".$salary_detail->name."</td>";
$html .= "<td>".round($salary_detail->salary,2)."</td>";
$html .= "<td>".round($salary_detail->bonas_amount,2)."</td>";
$html .= "<td>".round($salary_detail->extra_amount,2)."</td>";
$html .= "<td>".round($salary_detail->totaldebit,2)."</td>";
$html .= "<td>".round($salary_detail->paid_loan_amount,2)."</td>";
$html .= "<td>".round($salary_detail->salary+$salary_detail->bonas_amount+$salary_detail->extra_amount-$salary_detail->paid_loan_amount,2)."</td>";
$html .= "<td>".round($salary_detail->advance,2)."</td>";
$html .= "<td>".round($salary_detail->past_loan_amount,2)."</td>";
$html .= "<td>".round($salary_detail->past_loan_amount+$salary_detail->advance,2)."</td>";
$html .= "<td>".round($salary_detail->past_loan_amount+$salary_detail->advance-$salary_detail->paid_loan_amount,2)."</td>";
$html .="<td>".$edit."</td>";
                       $html .= "</tr>";
$salarytotal = $salarytotal+$salary_detail->salary;
$bonas_amount = $bonas_amount+$salary_detail->bonas_amount;
$extra_amount = $extra_amount+$salary_detail->extra_amount;
$totaldebit = $totaldebit+$salary_detail->totaldebit;
$paid_loan_amount = $paid_loan_amount+$salary_detail->paid_loan_amount;
$advance = $advance+$salary_detail->advance;
$past_loan_amount = $past_loan_amount+$salary_detail->past_loan_amount;
      }
	$rmloan = $past_loan_amount+$advance-$paid_loan_amount;
	$totalloan = $past_loan_amount+$advance;
	$totalsalary = $salarytotal+$bonas_amount+$extra_amount-$paid_loan_amount;
	$html .= "<tr><td colspan='2'>Total</td><td>$salarytotal</td><td>$bonas_amount</td><td>$extra_amount</td><td>$totaldebit</td><td>$paid_loan_amount</td><td>$totalsalary</td><td>$advance</td><td>$past_loan_amount</td><td>$totalloan</td><td>$rmloan</td></tr>"; 
	echo $html;
   }

   function bankdeposit_info()
   {
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
      $this->load->model('bank_deposit_model');
      $id = $this->uri->segment('3');
      $data['bd'] = $this->bank_deposit_model->bankdeposit_info($id);
      $this->load->view('web/bankdeposit_info',$data);
   }
   function worker_salary_list(){
        if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
      $this->load->model('daily_reports_model');
       $id = $this->uri->segment('3');
       $fdate = $this->uri->segment('4');
   $data['fdate'] =    date("d-m-Y",strtotime($fdate));
     $edate = $this->uri->segment('5');
     $data['edate'] =    date("d-m-Y",strtotime($edate));
      $data['bd'] = $this->daily_reports_model->worker_salary_list($fdate,$edate,$id);
     // echo $this->db->last_query();
   // die(); 
      $this->load->view('web/worker_salary_list',$data);
   }
           function worker_salary_edit(){
       if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
	//print_r($_POST);
	$data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('daily_reports_model');
      $this->load->model('bank_deposit_model');
      $data['id'] = $id = $this->input->get('id');
	$data['salary_details'] = $this->daily_reports_model->worker_salary_edit($id); 
       
//              $data['bd'] = $this->bank_deposit_model->bankdeposit_info($id);
        $this->form_validation->set_rules('loan_amount', 'Deposit Amount', 'trim|required');
        $this->form_validation->set_rules('paid_loan_amount', 'Withdraw Amount', 'trim|required');
        $this->form_validation->set_rules('extra_amount', 'Deposited By', 'trim|required');
        $this->form_validation->set_rules('bonas_amount', 'Deposited By', 'trim|required');
        $this->form_validation->set_rules('amount', 'Deposited By', 'trim|required');
        
        if ($this->form_validation->run() != FALSE) {
         //   print_r($_POST);
           // die();
			$deposited_by =  $this->input->post('deposited_by');
			if($deposited_by == 'n'){
				$deposited_by = "";
			}else{
				$deposited_by = $this->input->post('cheque_no');
			}
			$data = array(
							'amount' => $this->input->post('amount'), 
			 				'loan_amount' => $this->input->post('loan_amount'),
				 			'paid_loan_amount' => $this->input->post('paid_loan_amount'),
                                                        'extra_amount' => $this->input->post('extra_amount'),
                                                         'bonas_amount' => $this->input->post('bonas_amount')
			 			);
						
				$update = $this->bank_deposit_model->updatesalay($id,$data);
			$this->session->set_flashdata('success_update','Updated Successfully..');
			 redirect('worker_salary?sdate='.$this->input->get("sdate").'&edate='.$this->input->get("edate").'&l_id='.$this->input->get("l_id").'&worker_id='.$this->input->get("worker_id"));
			 
		}
		else{
			$this->load->view('web/salary_details_edit',$data);
			
		}
       
   }
   
function worker_salary_delete(){
       if(!$this->session->userdata('logged_company'))
   {
       redirect('company_login');
   }
   $data["logged_company"] = $_SESSION['logged_company'];
     $this->load->model('bank_deposit_model');
     $data['id'] = $id = $this->uri->segment('3');
     $data = array("status" => 0);	
$update = $this->bank_deposit_model->updatesalay($id,$data);
       $this->session->set_flashdata('success_update','Updated Successfully..');
       redirect('worker_salary');
      
  }
   function print_report(){
			$this->load->model('daily_reports_model');
            $fdate = date("Y-m-d",strtotime($this->input->get('sdate')));
			$tdate = date("Y-m-d",strtotime($this->input->get('edate')));
			$location = $this->input->get('lid');
			$id = $_SESSION['logged_company']['id'];
                        $worker_id = $this->input->get('worker_id');
			$data['location_detail'] = $this->daily_reports_model->location_detail($location);
			$data['salary'] = $this->daily_reports_model->worker_salary_remening($location,$fdate,$tdate,$worker_id);
			$this->load->library('m_pdf');
			$data['sdate'] = $fdate; 
			$data['edate'] = $tdate;
			
                        $html = $this->load->view('web/pdfsalartyreport.php', $data, true); 
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
	function print_report_tst(){
			$this->load->model('daily_reports_model');
			$location = $this->input->get('lid');
			$fdate = date("Y-m-d",strtotime($this->input->get('sdate')));
			$tdate = date("Y-m-d",strtotime($this->input->get('edate')));
			$data['location_detail'] = $this->daily_reports_model->location_detail($location);
			
			$this->load->model('bank_deposit_model');
			$data['list'] = $this->bank_deposit_model->bankdeposit_list($fdate,$tdate,$location);
			$this->load->library('m_pdf');
			$data['sdate'] = $fdate;
			$data['edate'] = $tdate;
			$html = $this->load->view('web/pdfbankdepost.php', $data, true); 
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