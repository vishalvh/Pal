<?php

class Petty_cash_report extends CI_Controller {

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
			$this->load->helper("amount"); 
            $this->load->library('Web_log');
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
        if ($this->input->get('sdate') != "") {
            $data['date1'] = $this->input->get('sdate');
        }
        $data['date2'] = "";
        if ($this->input->get('edate') != "") {
            $data['date2'] = $this->input->get('edate');
        }
        $data['lid'] = "";
        if ($this->input->get('l_id') != "") {
            $data['lid'] = $this->input->get('l_id');
        }
        $data['member_id'] = $this->input->get_post('member_id');
        $this->load->view('web/petty_cash_report', $data);
    }

    function petty_cash_report_view() {
        $this->load->model('expense_model');
        $data = array();
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('Petty_cash_member_model');
        $lid = $this->input->get('l_id');
        $date = $this->input->get('date');
        $member_id = $this->input->get('member_id');
        $current_date = date('Y-m-d');
        $data['cedit_list'] = $this->Petty_cash_member_model->get_tasection_list_credit_date($lid, date("Y-m-d", strtotime($date)), $member_id);
        //echo $this->db->last_query();     echo "<br>";     
        $data['debit_list'] = $this->Petty_cash_member_model->get_tasection_list_debit_date($lid, date("Y-m-d", strtotime($date)), $member_id);
        //echo $this->db->last_query();die();
        $this->load->view('web/petty_cash_report_view', $data);
    }

    function reportlist() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('Petty_cash_member_model');
        $data['lid'] = $lid = $this->input->post('lid');
        $data['sdate'] = $sdate = $this->input->post('sdate');
        $data['edate'] = $edate = $this->input->post('edate');
        $member_id = $this->input->post('member_id');
        $current_date = date('Y-m-d');
        $this->load->model('Petty_cash_member_model');
        $report_data = $this->Petty_cash_member_model->report_data($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);

        $customercedit_list = $this->Petty_cash_member_model->get_tasection_list_Credit($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);       
        $customerdebit_list = $this->Petty_cash_member_model->get_tasection_list_Debit($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
        $total_balance = $this->Petty_cash_member_model->total_balance($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
      
        // echo $this->db->last_query();
        // die();
        $cashdebit = $total_balance[0]->cashdebit;
        $creshcrdit = $total_balance[0]->creshcrdit;
        $checkcrdit = $total_balance[0]->checkcrdit;
        $checkdebit = $total_balance[0]->checkdebit;
        $netcrdit = $total_balance[0]->netcrdit;
        $netdebit = $total_balance[0]->netdebit;
        $totalcreadit = $checkcrdit + $netcrdit;
        $totalnetdebit = $netdebit + $checkdebit;

        $cash_balance = $creshcrdit - $cashdebit;
        $bank_balance = $totalcreadit - $totalnetdebit;
        $total_balance1 = $this->Petty_cash_member_model->total_balance_n($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
        $cashdebit_n = $total_balance1[0]->cashdebit;
        $creshcrdit_n = $total_balance1[0]->creshcrdit;
        $checkcrdit_n = $total_balance1[0]->checkcrdit;
        $checkdebit_n = $total_balance1[0]->checkdebit;
        $netcrdit_n = $total_balance1[0]->netcrdit;
        $netdebit_n = $total_balance1[0]->netdebit;
        $totalcreadit_n = $checkcrdit_n + $netcrdit_n;
        $totalnetdebit_n = $netdebit_n + $checkdebit_n;

        $cash_balance_n = $creshcrdit_n - $cashdebit_n;
        $bank_balance_n = $totalcreadit_n - $totalnetdebit_n;

        $total_cash_balance = $cash_balance_n + $cash_balance;
        $total_bank_balance = $bank_balance + $bank_balance_n;
        $date2 = "";
        $fianlarray = array();

        foreach ($customercedit_list as $cedit) {

            $fianlarray[$cedit->date]['date'] = $cedit->date;
            $fianlarray[$cedit->date]['amount'] = $cedit->amount;
            $fianlarray[$cedit->date]['name'] = $cedit->name;
            $fianlarray[$cedit->date]['id'] = $cedit->id;
            $fianlarray[$cedit->date]['remark'] = $cedit->remark;
            $fianlarray[$cedit->date]['count_status'] = $cedit->count_status;
        }
        foreach ($customerdebit_list as $cedit) {

            $fianlarray[$cedit->date]['date'] = $cedit->date;
            $fianlarray[$cedit->date]['name'] = $cedit->name;
            $fianlarray[$cedit->date]['id'] = $cedit->id;
            $fianlarray[$cedit->date]['remark'] = $cedit->remark;
            $fianlarray[$cedit->date]['d_amount'] = $cedit->amount;
            $fianlarray[$cedit->date]['count_status'] = "";
        }

        //    print_r($fianlarray);

        function sortByName($a, $b) {
            $a = $a['date'];
            $b = $b['date'];

            if ($a == $b)
                return 0;
            return ($a < $b) ? -1 : 1;
        }

        usort($fianlarray, 'sortByName');

        $base_url = base_url();
        $ctotal = 0;
        $dtotal = 0;
        $cnt = 1;
        $html = '';
        $html .= '<tr><td><b>Prevous cash balance</b> </td><td><b>' . amountfun($cash_balance) . '</b></td><td><b>Prevous Bank balance</b></td><td><b>' . amountfun($bank_balance) . '</b></td><td></td></tr>';
        $qty = 0;
        $amount = 0;
        $prevbalence = 0;
        $tcredit = 0;
        $debit = 0;
        $cashdebittotal = 0;
        $creshcrdittotal = 0;
        $bank_cradittotal = 0;
        $bank_debittotal = 0;
        //print_r($report_data);
        foreach ($report_data as $credit) {

            $tamount1 = 0;
            $tamount2 = 0;
            $date = $credit['date'];
            $debittotal = '';
            $credittotal = '';
            $cashdebit = '';
            $creshcrdit = '';
            $bank_cradit = '';
            $bank_debit = '';

            $type = '';

            $cashdebittotal = $credit['cashdebit'] + $cashdebittotal;
            $creshcrdittotal = $credit['creshcrdit'] + $creshcrdittotal;
            $bank_cradittotal = $credit['bank_cradit'] + $bank_cradittotal;
            $bank_debittotal = $credit['bank_debit'] + $bank_debittotal;

            $cashdebit = $credit['cashdebit'];
            $creshcrdit = $credit['creshcrdit'];
            $bank_cradit = $credit['bank_cradit'];
            $bank_debit = $credit['bank_debit'];


            $dtotal = $credit['d_amount'] + $dtotal;
            $debittotal = $credit['d_amount'];

            // $name = $credit['name'];
            // $remark = $credit['remark'];
            $paymentfor = '';
            $msg = '"Are you sure you want to remove this data?"';
            if(in_array("petty_cash_report_action",$this->data['user_permission_list'])){
                $edit = "<a href='" . $base_url . "petty_cash_report/petty_cash_report_view?date=" . $credit['date'] . "&sdate=" . $sdate . "&edate=" . $edate . "&l_id=" . $lid . "&member_id=" . $member_id . "'><i class='fa fa-eye'></i></a>  
						 ";
            } else {
                $edit = "";
            }
            $dates = "'".$date."'";
            $html .= '<tr><td>' . $cnt . '</td><td>' . date('d/m/Y', strtotime($date)) . '</td><td onclick="credittotal('.$dates.')">' . amountfun($creshcrdit) . '</td><td onclick="cashtotal('.$dates.')">' . amountfun($cashdebit) . '</td><td onclick="bankcredittotal('.$dates.')">' . amountfun($bank_cradit) . '</td><td onclick="bankdebittotal('.$dates.')">' . amountfun($bank_debit) . '</td>';
			if(in_array("petty_cash_report_action",$this->data['user_permission_list'])){
				$html .= '<td>
							' . $edit . '
						</td>';
			}
					$html .= '</tr>';
            $cnt++;
        }

        if ($cnt == 0) {
            $html .= '<tr><td colspan="2">No Data avalieble</td></tr>';
        }
        $temp = $total_cash_balance + $total_bank_balance;
        $f_cresh_total = $creshcrdittotal - $cashdebittotal;
        $f_bank_total = $bank_cradittotal - $bank_debittotal;

        $html .= '<tr><td colspan="2">Total</td><td>' . amountfun($creshcrdittotal) . '</td><td>' . amountfun($cashdebittotal) . '</td><td>' . amountfun($bank_cradittotal) . '</td><td>' . amountfun($bank_debittotal) . '</td></tr>';
        $html .= '<tr><td colspan="2"><b>Final Total</b></td><td><b>' . amountfun($f_cresh_total) . '</b></td><td></td><td><b>' . amountfun($f_bank_total) . '</b></td><td></td></tr>';
        $html .= '<tr><td><b>Total cash balance</b> </td><td><b>' . amountfun($total_cash_balance) . '</b></td><td><b>Total Bank balance</b></td><td><b>' . amountfun($total_bank_balance) . '</b></td><td></td></tr>';
        $html .= '<tr><td><b>Final balance</b> </td><td>' . amountfun($temp) . '</td></tr>';
        echo $html;
    }

    function reportlist_mobile() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('Petty_cash_member_model');
        $lid = $this->input->post('lid');
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
        $member_id = $this->input->post('member_id');
        $current_date = date('Y-m-d');
        $customerceditlist = $this->Petty_cash_member_model->get_tasection_list($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);

        $base_url = base_url();
        $ctotal = 0;
        $dtotal = 0;
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
            $debittotal = '';
            $credittotal = '';
            if ($credit->type == 'c') {
                $ctotal = $credit->amount + $ctotal;
                $credittotal = $credit->amount;
            } else {
                $dtotal = $credit->amount + $dtotal;
                $debittotal = $credit->amount;
            }
            $name = $credit->name;
            $remark = $credit->remark;
            $html .= '<div class="ui-grid-a">
						<div class="ui-block-a"><a href="tryjqmob_default.htm#calendar" data-rel="dialog" data-icon="calendar" class="ui-link ui-btn ui-icon-calendar ui-btn-icon-top">Calendar</a>' . $name . '</div>
						<div class="ui-block-b">' . date('d/m/Y', strtotime($date)) . '</div>
					</div>
					<div class="ui-grid-a">
						<div class="ui-block-a">' . $credittotal . '</div>
						<div class="ui-block-b">' . $debittotal . '</div>
					</div><hr>';
            $cnt++;
        }
        if ($cnt == 0) {
            //$html .= '<tr><td colspan="6">No Data avalieble</td></tr>';
        }

        //$html .= '<tr><td colspan="4">Total</td><td>' . $ctotal . '</td><td>' . $dtotal . '</td></tr>';

        echo $html;
    }

    function print_pdf() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $data['lid'] = $lid = $this->input->get_post('lid');
        $data['sdate'] = $sdate = $this->input->get_post('sdate');
        $edate = $this->input->get_post('edate');
        $data['edate'] = $edate = $this->input->get_post('date2');
        $data['sdate'] = $sdate = $this->input->get_post('date1');
        $lid = $this->input->get_post('location');
        $member_id = $this->input->get_post('Employeename');
        $data['member_id'] = $member_id;
        $current_date = date('Y-m-d');
        $data['current_date'] =$current_date;

        $this->load->model('Petty_cash_member_model');
		$data['memberdetail'] = array();
		if($member_id!= ""){
			$data['memberdetail'] = $this->Petty_cash_member_model->get_tbl_one("petty_cash_member",array("id"=>$member_id),"");
			//print_r($data['memberdetail']); die();
		}
        $data['report_data'] = $this->Petty_cash_member_model->report_data($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
        $data['customercedit_list'] = $this->Petty_cash_member_model->get_tasection_list_Credit($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
        $data['customerdebit_list'] = $this->Petty_cash_member_model->get_tasection_list_Debit($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
        $data['total_balance'] = $this->Petty_cash_member_model->total_balance($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
        $data['total_balance1'] = $this->Petty_cash_member_model->total_balance_n($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
        $data['location_detail'] = $this->Petty_cash_member_model->location_detail($lid);   
        $this->load->library('m_pdf');
        $html = $this->load->view('web/pdf_petty_cash_report', $data, true);
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

    function info() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('Petty_cash_member_model');
        $id = $this->input->get_post('id');
        $lidid = $this->input->get_post('l_id');
        $data['id'] = $id;
        $c_id = $_SESSION['logged_company']['id'];
        $data['member_list'] = $this->Petty_cash_member_model->get_tbl_list('petty_cash_member', array('status' => 1, 'company_id' => $c_id,'location_id'=>$lidid), array('name', 'asc'));
        $data['petty_cash_detail'] = $this->Petty_cash_member_model->get_tbl_one('petty_cash_transaction', array('status' => 1, 'id' => $id));


        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('paymenttype', 'Transection Type', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('memberid', 'Member', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $date = $this->input->post('date');
            if ($this->input->get_post('type') == 'c') {
                $count_status = $this->input->get_post('count_status');
            } else {
                $count_status = 0;
            }
            $data = array(
                'member_id' => $this->input->get_post('memberid'),
                'date' => date('Y-m-d', strtotime($this->input->get_post('date'))),
                'type' => $this->input->get_post('type'),
                'remark' => $this->input->get_post('remark'),
                'amount' => $this->input->get_post('amount'),
                'transaction_type' => $this->input->get_post('paymenttype'),
                'count_status' => $count_status,
                'transaction_no' => $this->input->get_post('chequenumber'),
                'bank_name' => $this->input->get_post('bank_name')
            );
            $update = $this->Petty_cash_member_model->update_record($id, $data);
            $lid = $this->input->get_post('l_id');
            $sdate = $this->input->get_post('sdate');
            $edate = $this->input->get_post('edate');
            $member_id = $this->input->get_post('member_id');
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
            redirect('petty_cash_report?l_id=' . $lid . '&sdate=' . $sdate . '&edate=' . $edate . '&member_id=' . $member_id);
        } else {
            $this->load->view('web/petty_cash_member_info', $data);
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


        $this->load->model('Petty_cash_member_model');
        $id = $this->input->get('id');
        $lid = $this->input->get('l_id');
        $sdate = $this->input->get('sdate');
        $edate = $this->input->get('edate');
        $member_id = $this->input->get_post('member_id');
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->Petty_cash_member_model->transaction_delete($id, $data);
        $lid = $this->input->get('l_id');
        $sdate = $this->input->get('sdate');
        $edate = $this->input->get('edate');
        $this->session->set_flashdata('fail', 'Trasaction Deleted Successfully..');
        redirect('petty_cash_report?l_id=' . $lid . '&sdate=' . $sdate . '&edate=' . $edate . '&member_id=' . $member_id);
    }

    function member_list() {
        $customer_id = $this->uri->segment(3);
        $lid = $this->input->post('lid');
        $this->load->model('Petty_cash_member_model');
        $customerlist = $this->Petty_cash_member_model->get_tbl_list('petty_cash_member', array('status' => 1, 'location_id' => $lid), array('name', 'asc'));
        $html = '<option value="">Select Member </option>';
        foreach ($customerlist as $customer) {
            $selected = "";
            if ($customer_id == $customer->id) {
                $selected = "selected";
            }
            $html .= '<option value="' . $customer->id . '" ' . $selected . '>' . $customer->name . '</option>';
        }
        echo $html;
    }
    function credittotal(){
        $this->load->model('Petty_cash_member_model');
        $location = $this->input->post('location');
        $Employeename = $this->input->post('Employeename');
        $selectdate = $this->input->post('selectdate');
        $report_data = $this->Petty_cash_member_model->report_data_list($location,$Employeename,$selectdate);
		$cnt = 1;
		foreach($report_data as $data){
        echo '<tr><td>'.$cnt++.'</td><td>'.$data->creshcrdit.'</td><td>'.$data->remark.'</td></tr>';
		}
    }
	function cashtotal(){
        $this->load->model('Petty_cash_member_model');
        $location = $this->input->post('location');
        $Employeename = $this->input->post('Employeename');
        $selectdate = $this->input->post('selectdate');
        $report_data = $this->Petty_cash_member_model->report_data_cashtotal_list($location,$Employeename,$selectdate);
		$cnt = 1;
		foreach($report_data as $data){
        echo '<tr><td>'.$cnt++.'</td><td>'.$data->creshcrdit.'</td><td>'.$data->remark.'</td></tr>';
		}
    }
	function bankcredittotal(){
        $this->load->model('Petty_cash_member_model');
        $location = $this->input->post('location');
        $Employeename = $this->input->post('Employeename');
        $selectdate = $this->input->post('selectdate');
        $report_data = $this->Petty_cash_member_model->report_data_bankcredittotal_list($location,$Employeename,$selectdate);
		$cnt = 1;
		foreach($report_data as $data){
        echo '<tr><td>'.$cnt++.'</td><td>'.$data->creshcrdit.'</td><td>'.$data->remark.'</td></tr>';
		}
    }
	function bankdebittotal(){
        $this->load->model('Petty_cash_member_model');
        $location = $this->input->post('location');
        $Employeename = $this->input->post('Employeename');
        $selectdate = $this->input->post('selectdate');
        $report_data = $this->Petty_cash_member_model->report_data_bankdebittotal_list($location,$Employeename,$selectdate);
		$cnt = 1;
		foreach($report_data as $data){
        echo '<tr><td>'.$cnt++.'</td><td>'.$data->creshcrdit.'</td><td>'.$data->remark.'</td></tr>';
		}
    }

}

?>