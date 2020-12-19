<?php

class expense extends CI_Controller {
function __construct() {
	parent::__construct();
	if ($this->session->userdata('logged_company')) {
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
		$this->load->library('Web_log');
		$this->load->helper("amount");
		$p = new Web_log;
		$this->allper = $p->Add_data();

	}
}
    function index() {
        $this->load->model('expense_model');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $_SESSION['logged_company']['id'];
        $data['Employee'] = $this->expense_model->master_fun_get_tbl_val1('shusermaster', array('status' => 1, 'company_id' => $c_id));

        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location'] = $this->expense_model->master_fun_get_tbl_val_location('sh_location', array('status' => 1,'show_hide' => 'show', 'company_id' => $c_id));
        } else {
            $u_id = $_SESSION['logged_company']['u_id'];
            $data['location'] = $this->expense_model->get_location($u_id);
        }
		$data['date1'] = "";
		if($this->input->get('sdate') != ""){
			$data['date1'] = $this->input->get('sdate');
		}
		$data['date2'] = "";
		if($this->input->get('edate') != ""){
			$data['date2'] = $this->input->get('edate');
		}
		$data['list'] = array();
		$data['lid']="";
		if($this->input->get('l_id') != ""){
			$data['lid'] = $this->input->get('l_id');
			$data['list'] = $this->expense_model->get_tbl_data_order('sh_expensein_types',array("status"=>'1',"location_id"=>$data['lid']),array('exps_name','asc'));
		}
		
        $this->load->view('web/expense_report', $data);
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('expense_model');
        $employeename = $this->input->get('employeename');
        $fdate = $this->input->get('fdate');
        $tdate = $this->input->get('tdate');
        $location = $this->input->get('location');
        $id = $_SESSION['logged_company']['id'];
        $current_date = date('Y-m-d');
        $extra = $this->input->get('extra');
        $list = $this->expense_model->get_datatables($extra, $id, $employeename, $fdate, $tdate, $location, $current_date);

        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {


            $no++;
            $edit = "<a href='" . $base_url . "expense/expense_info/" . $customers->id . " '><i class='fa fa-edit'></i></a>  
			<a href='" . $base_url . "expense/bankdeposit_delete/" . $customers->id . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a>";
            // $name = $customers->UserFName;
            // $name1 = ucfirst($name);
            $row = array();
            $row[] = $no;

            // $row[] = $name1;
            $name1 = $customers->UserFName;
            $row[] = date('d-m-Y', strtotime($customers->date));
            $row[] = ucfirst($name1);
            $row[] = $customers->l_name;
            $row[] = $customers->total;
            $row[] = $customers->exps_name;
            $row[] = $customers->reson;
			if(in_array("expense_report_action",$this->data['user_permission_list'])){
                $row[] = $edit;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->expense_model->count_filtered($extra, $id, $employeename, $fdate, $tdate, $location, $current_date),
            "recordsFiltered" => $this->expense_model->count_filtered($extra, $id, $employeename, $fdate, $tdate, $location, $current_date),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function reportlist() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('expense_model');
        $lid = $this->input->post('lid');
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
        $current_date = date('Y-m-d');
		$exp_name = $this->input->post('exp_name');
        $customerceditlist = $this->expense_model->get_customer_expense_list($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date,$exp_name);
		
        // echo $this->db->last_query();
        // $html = $this->db->last_query();
        //	print_r($customerceditlist);
        $base_url = base_url();
        $ftotal = 0;
        $cnt = 1;
        $html = '';
        $qty = 0;
        $amount = 0;
        $prevbalence = 0;
        $tcredit = 0;
        $debit = 0;
        foreach ($customerceditlist as $credit) {
            $tamount1 = 0;
            $tamount2 = 0;
            $date = $credit->date;
            $l_name = $credit->l_name;
            $ftotal = $credit->total + $ftotal;
            $total = amountfun($credit->total);
            $exps_name = $credit->exps_name;
            $reson = $credit->reson;
            $paymentfor = '';
            /* if($credit->payment_type == 'c'){
              $type = 'Debit';
              $debit = $debit + $credit->amount;
              $tamount1 = $credit->amount;
              $paymentfor = $credit->bill_no;
              }else{
              $type = 'Credit';
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
              } */

            $msg = '"Are you sure you want to remove this data?"';
            if ($this->session->userdata('logged_company')['type'] == 'c') {
                $edit = "<a href='" . $base_url . "expense/expense_info?id=" . $credit->id . "&sdate=".$sdate."&edate=".$edate."&l_id=".$lid."&exp_name=".$exp_name."'><i class='fa fa-edit'></i></a>  
						 <a href='" . $base_url . "expense/delete?id=" . $credit->id . "&sdate=".$sdate."&edate=".$edate."&l_id=".$lid."&exp_name=".$exp_name."' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a>";
                $html .= '<tr><td>' . $cnt . '</td><td>' . date('d/m/Y', strtotime($date)) . '</td><td>' . $total . '</td><td>' . $exps_name . '</td><td>' . $reson . '</td>
						<td>
							' . $edit . '
						</td>
					</tr>';
            } else {
                $edit = "";
                $html .= '<tr><td>' . $cnt . '</td><td>' . date('d/m/Y', strtotime($date)) . '</td><td>' . $total . '</td><td>' . $exps_name . '</td><td>' . $reson . '</td>
						
					</tr>';
            }
            $cnt++;
        }
        if ($cnt == 0) {
            $html .= '<tr><td colspan="6">No Data avalieble</td></tr>';
        }

        $html .= '<tr><td colspan="2">Total</td><td>' . amountfun($ftotal) . '</td></tr>';

        echo $html;
    }

    function print_pdf() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('expense_model');
        $lid = $this->input->get_post('lid');
        $data['sdate'] = $sdate = $this->input->get_post('sdate');
        $edate = $this->input->get_post('edate');
        $data['edate'] = $edate = $this->input->get_post('date2');
        $data['sdate'] = $sdate = $this->input->get_post('date1');
		$exp_name = $this->input->get_post('exp_name');
        $lid = $this->input->get_post('location');

        $current_date = date('Y-m-d');

        $data['customerceditlist'] = $this->expense_model->get_customer_expense_list($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date,$exp_name);
        $data['location_detail'] = $this->expense_model->location_detail($lid);
        //echo $this->	db->last_query();
        //die();
//print_r($data['location_detail']);
        $this->load->library('m_pdf');
        $html = $this->load->view('web/pdfexpense', $data, true);
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

    function expense_info() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('expense_model');
        $id = $this->input->get('id');
        $data['id'] = $id;
        $c_id = $_SESSION['logged_company']['id'];
        $data['type_list'] = $this->expense_model->master_fun_get_tbl_val2('sh_expensein_types', array('status' => 1, 'comapny_id' => $c_id));
        //echo $this->db->last_query();
        $data['expense'] = $this->expense_model->expense_info($id);
		//echo "<pre>"; print_r($data['expense']); die();
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('reson', 'Reson', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
			
			$this->load->model('master_model');
			$expensetype = $this->input->post('expensetype');
			$oldexpense = $data['expense'];
			$oldexpensetype = $data['expense'][0]->expense_type;
			$date = $this->input->post('date');
			$fdate = date('Y-m-d', strtotime($date));
			$data = array(
                'date' => $fdate,
                'expense_id' => $this->input->post('type'),
                'amount' => $this->input->post('amount'),
                'reson' => $this->input->post('reson'),
                'expense_type' => $this->input->post('expensetype')
            );
			$bankdata = array();
			if($expensetype == $oldexpensetype){
				if($expensetype == 'bank'){
					$bankdata = array('amount'=>$this->input->post('amount'),
					'bank_name' => $this->input->post('reson'));
					$update = $this->expense_model->updatebankexpence($id,$bankdata);
				}else{
					$update = $this->expense_model->updatebankexpence($id,array('status'=>'0'));
				}
			}
			if($expensetype != $oldexpensetype){
				$update = $this->expense_model->updatebankexpence($id,array('status'=>'0'));
				if($expensetype == 'bank'){
					$bankdata = array(
					'user_id'=>$oldexpense[0]->user_id,
					'location_id'=>$oldexpense[0]->location_id,
					'date'=>$oldexpense[0]->date,
					'invoice_no'=>'Expense entry auto at update expense time',
					'amount'=>$this->input->post('amount'),
					'paid_by'=>'c',
					'cheque_tras_no'=>'Expense entry auto at update expense time',
					'bank_name' => $this->input->post('reson'),
					'expence_id'=>$id);
					$update = $this->master_model->master_insert('sh_onlinetransaction',$bankdata);
				}
			}
            
            
            $update = $this->expense_model->updatefun($id, $data);
		$lid = $this->input->get('l_id');
		$sdate = $this->input->get('sdate');
		$edate = $this->input->get('edate');
		$exp_name = $this->input->get('exp_name');
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
			redirect('expense?l_id='.$lid.'&sdate='.$sdate.'&edate='.$edate.'&exp_name='.$exp_name);
        } else {
            $this->load->view('web/expense_info', $data);
        }
    }
	
	function delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('expense');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $this->load->model('expense_model');
        $id = $this->input->get('id');
		$lid = $this->input->get('l_id');
		$sdate = $this->input->get('sdate');
		$edate = $this->input->get('edate');
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->expense_model->delete($id, $data);
		$this->expense_model->updatebankexpence($id,array('status'=>'0'));
		$lid = $this->input->get('l_id');
		$sdate = $this->input->get('sdate');
		$edate = $this->input->get('edate');
        $this->session->set_flashdata('fail', 'Expense Deleted Successfully..');
		$exp_name = $this->input->get('exp_name');
        redirect('expense?l_id='.$lid.'&sdate='.$sdate.'&edate='.$edate.'&exp_name='.$exp_name);
    }
		
    function bankdeposit_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('expense');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $this->load->model('expense_model');
        $id = $this->uri->segment('3');
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->expense_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'Expense Deleted Successfully..');
        redirect('expense');
    }
	function get_exp_typ(){
		$lid = $this->input->post('lid');
		$this->load->model('expense_model');
		$list = $this->expense_model->get_tbl_data_order('sh_expensein_types',array("status"=>'1',"location_id"=>$lid),array('exps_name','asc'));
		foreach($list as $detail){
			echo "<option value='".$detail['id']."'>".$detail['exps_name']."</option>";
		}
	}
}

?>