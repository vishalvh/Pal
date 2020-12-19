<?php

class Bank_deposit extends CI_Controller {

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
        }
		$this->load->helper("amount"); 
    }

    function index() {
        $this->load->model('bank_deposit_model');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $_SESSION['logged_company']['id'];
        $data['Employee'] = $this->bank_deposit_model->master_fun_get_tbl_val1('shusermaster', array('status' => 1, 'company_id' => $c_id));

        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location'] = $this->bank_deposit_model->master_fun_get_tbl_val_location('sh_location', array('status' => 1,'show_hide' => 'show', 'company_id' => $c_id));
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['location'] = $this->bank_deposit_model->get_location($u_id);
        }
        $this->load->view('web/bank_deposit_report', $data);
    }

    public function reportlist() {


        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('bank_deposit_model');
        $this->load->model('daily_reports_model');
        $fdate = date("Y-m-d", strtotime($this->input->post('sdate')));
        $tdate = date("Y-m-d", strtotime($this->input->post('edate')));
        $location = $this->input->post('lid');
        $id = $_SESSION['logged_company']['id'];
        $list = $this->bank_deposit_model->bankdeposit_list($fdate, $tdate, $location);
        //$listnew = $this->bank_deposit_model->bankdeposit_list_new($location, $fdate, $tdate);
        //echo $this->db->last_query();
        $onlinelist = $this->bank_deposit_model->online_list($fdate, $tdate, $location);
        //$creadit_dabit_list = $this->bank_deposit_model->creadit_dabit_list($fdate, $tdate, $location);
        $creadit_dabit_list = $this->bank_deposit_model->creadit_dabit_list(date('Y-m-d', strtotime($fdate . ' -1 day')), $tdate, $location);
        $wallet_list = $this->bank_deposit_model->wallet_list($fdate, $tdate, $location);
        $wallet_list = $this->bank_deposit_model->wallet_list(date('Y-m-d', strtotime($fdate . ' -1 day')), $tdate, $location);

        $pre_deposit_amount = $this->daily_reports_model->pre_deposit_amount($location, $fdate);
        $pre_cheq_deposit_amount = $this->bank_deposit_model->pre_cheq_deposit_amount($location, $fdate);
        $pre_deposit_wallet_amount = $this->daily_reports_model->pre_deposit_wallet_amount($location, date('Y-m-d', strtotime($fdate . ' -1 day')));
        $pre_onlinetransaction = $this->daily_reports_model->pre_onlinetransaction($location, $fdate);
        $prev_card_depost = $this->daily_reports_model->prev_card_depost($location, date('Y-m-d', strtotime($fdate . ' -1 day')));

        $prev_petty_cash_deposit = $this->daily_reports_model->prev_petty_cash_deposit($location, $fdate);
        $prev_petty_cash_withdrawal = $this->daily_reports_model->prev_petty_cash_withdrawal($location, $fdate);
        $petty_cash_deposit_list = $this->bank_deposit_model->petty_cash_deposit_list($fdate, $tdate, $location);
		

        $petty_cash_withdrawal_list = $this->bank_deposit_model->petty_cash_withdrawal_list($fdate, $tdate, $location);
        // echo "<pre>";
        $fianlarray = array();
        foreach ($list as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['deposit_amount'] = $bankdetail->deposit_amount;
        }
		$listnew = $this->bank_deposit_model->bankdeposit_list_new($location, $fdate, $tdate);
		
		foreach ($listnew as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['depositamonut'] = $bankdetail->cs_total;
        }
        foreach ($onlinelist as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['amount'] = $bankdetail->amount;
        }
        foreach ($creadit_dabit_list as $bankdetail) {
            $fianlarray[date('Y-m-d', strtotime($bankdetail->date . ' +1 day'))]['date'] = date('Y-m-d', strtotime($bankdetail->date . ' +1 day'));
            $fianlarray[date('Y-m-d', strtotime($bankdetail->date . ' +1 day'))]['card_amount'] = $bankdetail->card_amount;
        }
        foreach ($wallet_list as $bankdetail) {
            $fianlarray[date('Y-m-d', strtotime($bankdetail->date . ' +1 day'))]['date'] = date('Y-m-d', strtotime($bankdetail->date . ' +1 day'));
            $fianlarray[date('Y-m-d', strtotime($bankdetail->date . ' +1 day'))]['wallet_list'] = $bankdetail->card_amount;
        }
        foreach ($petty_cash_deposit_list as $bankdetail) {

            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['petty_cash_deposit'] = $bankdetail->total;
        }
        foreach ($petty_cash_withdrawal_list as $bankdetail) {
            $fianlarray[$bankdetail->date]['date'] = $bankdetail->date;
            $fianlarray[$bankdetail->date]['petty_cash_withdrawal'] = $bankdetail->total;
        }

        // print_r($fianlarray);
//                  foreach ($fianlarray as $as){
//                    echo '<pre>';  print_r($as); 
//                  }
//                  die();
//                      
        function sortByName($a, $b) {
            $a = $a['date'];
            $b = $b['date'];

            if ($a == $b)
                return 0;
            return ($a < $b) ? -1 : 1;
        }

        $base_url = base_url();
        $html = "";
        $msg = '"Are you sure you want to remove this data?"';
        $deposit = 0;
        $onlinetrasectin = 0;
        $withdraw = 0;
        $extra = 0;
        $petty_cash_deposit = 0;
        $petty_cash_withdrawal = 0;
        $list1 = array_merge($list, $onlinelist);
        $list2 = array_merge($list1, $creadit_dabit_list);
        //    print_r($list1);
        // array_multisort($list1,SORT_ASC,SORT_NUMERIC);
        $count = count($list2);
// Print array elements before sorting
        usort($fianlarray, 'sortByName');
        //echo $pre_deposit_amount->cash_total."+".$pre_cheq_deposit_amount->cheque_total."+".$pre_deposit_wallet_amount->wallet_extra_total."+".$prev_card_depost->total."-".$pre_onlinetransaction->total_onlinetransaction."<br>";
		$opnamontstr = $pre_deposit_amount->cash_total ."+". $pre_cheq_deposit_amount->cheque_total ."+". $pre_deposit_wallet_amount->wallet_extra_total ."+". $prev_card_depost->total ."+". $prev_petty_cash_deposit->total ."-". $pre_onlinetransaction->total_onlinetransaction ."-". $prev_petty_cash_withdrawal->total."<br><br>";
        $opnamont = $pre_deposit_amount->cash_total + $pre_cheq_deposit_amount->cheque_total + $pre_deposit_wallet_amount->wallet_extra_total + $prev_card_depost->total + $prev_petty_cash_deposit->total - $pre_onlinetransaction->total_onlinetransaction - $prev_petty_cash_withdrawal->total;
        $html .= '<tr><td>Opening Balance</td><td></td><td style="text-align: right">' . amountfun($opnamont) . '</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
        foreach ($fianlarray as $customers) {
			
			if(strtotime($customers['date']) <= strtotime($tdate)){
			
            $html .= "<tr>";

            $no++;
            $edit = "<a href='" . $base_url . "bank_deposit/bankdonlineeposit_view?date=" . date('d-m-Y', strtotime($customers['date'])) . "&l_id=" . $location . "&sdate=" . $this->input->post('sdate') . "&edate=" . $this->input->post('edate') . "'><i class='fa fa-eye'></i></a> ";
            $dep = $customers['deposit_amount'] + $customers['depositamonut'];
            $html .= "<td>" . $no . "</td>";
            $html .= "<td>" . date('d-m-Y', strtotime($customers['date'])) . "</td>";
            $html .= "<td style='text-align: right'>" . amountfun($customers['deposit_amount']) . "</td>";
            $html .= "<td style='text-align: right'><a onclick='customer_amount_data_model(".$no.",".$location.",".date('Y-m-d',strtotime($customers['date'])).")'>" . amountfun($customers['depositamonut']) . "</a></td>";
            
           $html .= "<td style='text-align: right'><a onclick='open_sales_data_model(".$no.",".$location.",".date('Y-m-d',strtotime($customers['date'])).")'><input type='hidden' id='sales_on_card".$no."' value='".date('Y-m-d',strtotime($customers['date']))."'>" . amountfun($customers['card_amount']) . "</a></td>";
           // $html .= "<td>" . number_format($customers['card_amount'], 2) . "</td>";
            $html .= "<td style='text-align: right'>" . amountfun($customers['wallet_list']) . "</td>";
            $html .= "<td style='text-align: right'>" . amountfun($customers['petty_cash_deposit']) . "</td>";
            $html .= "<td style='text-align: right'>" . amountfun($customers['petty_cash_withdrawal']) . "</td>";
			$html .= "<td style='text-align: right'><a onclick='withdraw_amount_data_model(".$no.",".$location.",".date('Y-m-d',strtotime($customers['date'])).")'>" . amountfun($customers['amount']) . "</a></td>";
            //$html .= "<td>".number_format(($customers['deposit_amount']+$customers['depositamonut']+$customers['card_amount']+$opnamont)-($customers['amount']), 2)."</td>";
            if(in_array("bank_report_action",$this->data['user_permission_list'])){
			$html .= "<td>" . $edit . "</td>";
			}
            $html .= "</tr>";
            $deposit = $deposit + $customers['deposit_amount'];
            $card_amount = $card_amount + $customers['card_amount'];
            $withdraw = $withdraw + $customers['depositamonut'];
            $onlinetrasectin = $onlinetrasectin + $customers['amount'];
            $extra = $extra + $customers['wallet_list'];
            $petty_cash_deposit = $petty_cash_deposit + $customers['petty_cash_deposit'];
            $petty_cash_withdrawal = $petty_cash_withdrawal + $customers['petty_cash_withdrawal'];
			}
        }
        $html .= "<tr><td colspan='2'>Total</td><td style='text-align: right'>" . amountfun($deposit) . "</td><td style='text-align: right'>" . amountfun($withdraw) . "</td><td style='text-align: right'>" . amountfun($card_amount) . "</td><td style='text-align: right'>" . amountfun($extra) . "</td><td style='text-align: right'>" . amountfun($petty_cash_deposit) . "</td><td style='text-align: right'>" . amountfun($petty_cash_withdrawal) . "</td><td style='text-align: right'>" . amountfun($onlinetrasectin) . "</td><td></td></tr>";
		
		$html .= "<tr><td colspan='2'>Month End Total</td><td colspan='4' style='text-align: right'>" . amountfun($deposit+$withdraw+$card_amount+$petty_cash_deposit+$extra) . "</td><td colspan='2' style='text-align: right'>" . amountfun($onlinetrasectin+$petty_cash_withdrawal) . "</td><td  style='text-align: right'>".amountfun(($deposit+$withdraw+$card_amount+$petty_cash_deposit+$extra)-($onlinetrasectin+$petty_cash_withdrawal))."</td></tr>";
		
		$monthclosingbalance = ($deposit+$withdraw+$card_amount+$petty_cash_deposit+$extra)-($onlinetrasectin+$petty_cash_withdrawal);
        //$temp = "<br>totaldipostcash=".$deposit."<br>totaldipostcheque=".$withdraw."<br>totalsales on card =".$card_amount."<br>pretotaldipostcash=".$pre_deposit_amount->cash_total."<br>pretotaldipostcheque=".$pre_deposit_amount->cheque_total."<br>pretotal saleson card=".$prev_card_depost->total."<br>pretotalextra=".$pre_deposit_wallet_amount->wallet_extra_total."<br>totalextra=".$extra."<br>totalonline =".$onlinetrasectin."<br>pretotalonline=".$pre_onlinetransaction->total_onlinetransaction;
        //$html .= "<tr><td colspan='2'>Ending Balance</td><td>".$wallet_list[0]->card_amount."+".$deposit."+".$withdraw."+".$card_amount."+".$opnamont."-".$onlinetrasectin."<br>".number_format(($wallet_list[0]->card_amount+$deposit+$withdraw+$card_amount+$opnamont)-$onlinetrasectin, 2)."</td><td></td><td></td><td></td><td>".$temp."</td></tr>";
        $html .= "<tr><td colspan='2'>Ending Balance</td><td style='text-align: right'>" . amountfun($opnamont + $monthclosingbalance) . "</td><td></td><td></td><td></td><td>" . $temp . "</td></tr>";
        echo $html;
    }

    function bankdonlineeposit_view() {
        $date = date("Y-m-d", strtotime($this->input->get('date')));
        $location = $this->input->get('l_id');
        $id = $_SESSION['logged_company']['id'];
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('bank_deposit_model');
        $data['list'] = $this->bank_deposit_model->bankdeposit_list_view($date, $location);
        $data['list2'] = $this->bank_deposit_model->bankdeposit_list_view_new($date, $location);
        if ($_GET['d_id'] == 1) {
            echo $this->db->last_query();
            ;
            echo "<pre>";
            print_r($data['list']);
            die();
        }
        $data['onlinelist'] = $this->bank_deposit_model->online_list_view($date, $location);
		//echo $this->db->last_query(); die;
        $data['online_bank_expance'] = $this->bank_deposit_model->online_bank_expance($date, $location);
//		echo $this->db->last_query();
//                die();
        $data['creadit_dabit_list'] = $this->bank_deposit_model->creadit_dabit_list_view($date, $location);
        $data['wallet_list'] = $this->bank_deposit_model->wallet_list_view($date, $location);
        $data['get_petty_cash_tasection_list'] = $this->bank_deposit_model->get_petty_cash_tasection_list($date, $location);
        $this->load->view('web/bank_deposit_report_view', $data);
    }

    function wallet_payment_edit() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('bank_deposit');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('bank_deposit_model');
        $data['id'] = $id = $this->input->get('id');
        $data['bd'] = $this->bank_deposit_model->wallet_info($id);
        $lid = $this->input->get('l_id');
        $data['extras'] = $this->bank_deposit_model->ptypebylocation($lid);
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));

        $this->form_validation->set_rules('card_amount', 'Card Amount', 'trim|required');
        $this->form_validation->set_rules('extra_id', 'Payment Type', 'trim|required');
        if ($this->form_validation->run() != FALSE) {
            $data = array(
                'amount' => $this->input->post('card_amount'),
                'extra_id' => $this->input->post('extra_id'),
                'batch' => $this->input->post('batch'),
            );
            $update = $this->bank_deposit_model->update_card_details($id, $data);
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
            redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $lid);
        } else {
            $this->load->view('web/bankwalletpayment_edit', $data);
        }
    }

    function sortFunction($a, $b) {
        return strtotime($a["date"]) - strtotime($b["date"]);
    }

    function bankdeposit_info() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('bank_deposit_model');
        $id = $this->uri->segment('3');
        $data['bd'] = $this->bank_deposit_model->bankdeposit_info($id);
        $this->load->view('web/bankdeposit_info', $data);
    }

    function bankdonlineeposit_edit() {

        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('bank_deposit');
        }
        //print_r($_POST);
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('bank_deposit_model');
        $data['id'] = $id = $this->input->get('id');

        $data['bd'] = $this->bank_deposit_model->online_info($id);
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        //echo $this->db->last_query();
        //die();
        $this->form_validation->set_rules('invoice_no', 'Deposit Amount', 'trim|required');
        $this->form_validation->set_rules('amount', 'Withdraw Amount', 'trim|required');
        $this->form_validation->set_rules('deposited_by', 'Deposited By', 'trim|required');
        $this->form_validation->set_rules('cheque_tras_no', 'Cheque Tras No', 'trim|required');
        //$this->form_validation->set_rules('bank_name', 'bank name ', 'trim|required');

        if ($this->form_validation->run() != FALSE) {
            $deposited_by = $this->input->post('deposited_by');

            if ($deposited_by == 'n') {
                $bank_name = "";
            } else {
                $bank_name = $this->input->post('bank_name');
            }
            $data = array(
                'invoice_no' => $this->input->post('invoice_no'),
                'amount' => $this->input->post('amount'),
                'paid_by' => $this->input->post('deposited_by'),
                'cheque_tras_no' => $this->input->post('cheque_tras_no'),
                'bank_name' => $bank_name
            );

            $update = $this->bank_deposit_model->update2($id, $data);
            //	echo $this->db->last_query();
            //die();
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
            //redirect('bank_deposit/bankdonlineeposit_view?date='.$date."&l_id=".$lid);
            redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $this->input->get('l_id'));
        } else {
            $this->load->view('web/bankdonlineeposit_edit', $data);
        }
    }

    function bankdonlineeposit_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('bank_deposit');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $this->load->model('bank_deposit_model');
        $id = $this->input->get('id');
        $data['bd'] = $this->bank_deposit_model->online_info($id);
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->bank_deposit_model->delete2($id, $data);
        $this->session->set_flashdata('fail', 'User Deleted Successfully..');
        redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $this->input->get('l_id'));
    }

    function bank_card_payment_edit() {

        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('bank_deposit');
        }
        //print_r($_POST);
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('bank_deposit_model');
        $data['id'] = $id = $this->input->get('id');
        $data['bd'] = $this->bank_deposit_model->card_info($id);
        //echo $this->db->last_query(); die();
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $this->form_validation->set_rules('card_amount', 'Card Amount', 'trim|required');
        $this->form_validation->set_rules('batch_no', 'Batch No', 'trim|required');
        if ($this->form_validation->run() != FALSE) {
            $data = array(
                'amount' => $this->input->post('card_amount'),
                'batch_no' => $this->input->post('batch_no'),
            );

            $update = $this->bank_deposit_model->update_card_details($id, $data);
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
            redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $lid);
        } else {
            $this->load->view('web/bankcardpayment_edit', $data);
        }
    }

    function bank_card_payment_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('bank_deposit');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $this->load->model('bank_deposit_model');
        $id = $this->input->get('id');
        $data['bd'] = $this->bank_deposit_model->card_info($id);
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->bank_deposit_model->update_card_details($id, $data);
        $this->session->set_flashdata('fail', 'Deleted Successfully..');
        redirect('bank_deposit?sdate=' . $this->input->get("sdate") . '&edate=' . $this->input->get("edate") . '&l_id=' . $lid);
    }

    function wallet_payment_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('bank_deposit');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $this->load->model('bank_deposit_model');
        $id = $this->input->get('id');
        $data['bd'] = $this->bank_deposit_model->wallet_info($id);
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->bank_deposit_model->update_card_details($id, $data);
        $this->session->set_flashdata('fail', 'Deleted Successfully..');
        redirect('bank_deposit?sdate=' . $this->input->get("sdate") . '&edate=' . $this->input->get("edate") . '&l_id=' . $lid);
    }

    function bankdeposit_edit() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        //print_r($_POST);
        //die();
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $data["logged_company"]['id'];
        $this->load->model('bank_deposit_model');
        $data['id'] = $id = $this->input->get('id');

        $data['bd'] = $this->bank_deposit_model->bankdeposit_info($id);
        $location_id = $data['bd'][0]->location_id;
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        // $bank_id = $data['bd']->id;
        $data['d_amount'] = $this->bank_deposit_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id, 'status' => '1', 'amount!=' => "", 'transaction_type !=' => ""));
        $data['user_list'] = $this->bank_deposit_model->select_all('sh_userdetail', array('company_id' => $c_id, 'location_id' => $location_id));
        //echo $this->db->last_query();
        //die();
        $this->form_validation->set_rules('deposit_amount', 'Deposit Amount', 'trim|required');
        // $this->form_validation->set_rules('withdraw_amount', 'Withdraw Amount', 'trim|required');
        // $this->form_validation->set_rules('deposited_by', 'Deposited By', 'trim|required');

        if ($this->form_validation->run() != FALSE) {

            $deposited_by = $this->input->post('deposited_by');
            if ($deposited_by == 'n') {
                $deposited_by = "";
            } else {
                $deposited_by = $this->input->post('cheque_no');
            }
            $data2 = array(
                'deposit_amount' => $this->input->post('deposit_amount'),
                'amount' => $this->input->post('total_amount'),
                    //'deposited_by' => $this->input->post('deposited_by'),
                    //'cheque_no' => $deposited_by
            );
            $update = $this->bank_deposit_model->update($this->input->get('id'), $data2);
            $damount = $this->bank_deposit_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id));
            $amount = 0;
            foreach ($damount as $d_amount) {
                if ($this->input->post("transaction_type$d_amount->id") == 'cs') {
                    $bankname = "";
                    $cheque = "";
                } else {
                    $bankname = $this->input->post("bank_name_$d_amount->id");
                    $cheque = $this->input->post("cheque_no_$d_amount->id");
                    $amount = $amount + $this->input->post("cheque_no_$d_amount->id");
                }

                $data = array(
                    'customer_id' => $this->input->post("c_name_$d_amount->id"),
                    'amount' => $this->input->post("amount_$d_amount->id"),
                    'bank_name' => $bankname,
                    'transaction_number' => $cheque,
                    'transaction_type' => $this->input->post("transaction_type$d_amount->id")
                );

                $this->bank_deposit_model->update_cardit_info($d_amount->id, $data);
            }
            $this->bank_deposit_model->update($this->input->get('id'), array('amount' => $amount));
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
            redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $lid);
        } else {
            $this->load->view('web/bankdeposit_edit', $data);
        }
    }

    function bankdeposit_edit_online() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        //print_r($_POST);
        //die();
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $data["logged_company"]['id'];
        $this->load->model('bank_deposit_model');
        $data['id'] = $id = $this->input->get('id');

        $data['bd'] = $this->bank_deposit_model->bankdeposit_info($id);
        $location_id = $data['bd'][0]->location_id;
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        // $bank_id = $data['bd']->id;
        $data['d_amount'] = $this->bank_deposit_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id, 'status' => '1', 'amount!=' => "", 'transaction_type !=' => ""));
        $data['user_list'] = $this->bank_deposit_model->select_all('sh_userdetail', array('company_id' => $c_id, 'location_id' => $location_id));
        //echo $this->db->last_query();
        //die();
        $this->form_validation->set_rules('deposit_amount', 'Deposit Amount', 'trim|required');
        // $this->form_validation->set_rules('withdraw_amount', 'Withdraw Amount', 'trim|required');
        // $this->form_validation->set_rules('deposited_by', 'Deposited By', 'trim|required');

        if ($this->form_validation->run() != FALSE) {

            $deposited_by = $this->input->post('deposited_by');
            if ($deposited_by == 'n') {
                $deposited_by = "";
            } else {
                $deposited_by = $this->input->post('cheque_no');
            }
            $data2 = array(
                'deposit_amount' => $this->input->post('deposit_amount'),
                'amount' => $this->input->post('total_amount'),
                    //'deposited_by' => $this->input->post('deposited_by'),
                    //'cheque_no' => $deposited_by
            );
            $update = $this->bank_deposit_model->update($this->input->get('id'), $data2);
            $damount = $this->bank_deposit_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id));
            //$amount = 0;
//                        foreach ($damount as $d_amount){
//                          if($this->input->post("transaction_type$d_amount->id") == 'cs'){
//                              $bankname = "";
//                              $cheque= "";
//                          }else{
//                              $bankname = $this->input->post("bank_name_$d_amount->id");
//                              $cheque = $this->input->post("cheque_no_$d_amount->id");
//							  $amount = $amount + $this->input->post("cheque_no_$d_amount->id");
//                          }
//                            
//                            $data = array(
//							'customer_id' => $this->input->post("c_name_$d_amount->id"), 
//			 				'amount' => $this->input->post("amount_$d_amount->id"),
//				 			'bank_name' => $bankname,
//				 			'transaction_number' => $cheque,
//                                                        'transaction_type' =>$this->input->post("transaction_type$d_amount->id")
//			 			);
//                                                 
//                            $this->bank_deposit_model->update_cardit_info($d_amount->id,$data);
//                           
//                        }
            //$this->bank_deposit_model->update($this->input->get('id'),array('amount'=>$amount));
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
            redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $lid);
        } else {
            $this->load->view('web/bankdeposit_edit2', $data);
        }
    }

    function bankdeposit_edit_cradit() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        //print_r($_POST);
        //die();
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $data["logged_company"]['id'];
        $this->load->model('bank_deposit_model');
        $data['id'] = $id = $this->input->get('id');

        $data['bd'] = $this->bank_deposit_model->bankdeposit_info($id);
        $location_id = $data['bd'][0]->location_id;
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        // $bank_id = $data['bd']->id;
        $data['d_amount'] = $this->bank_deposit_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id, 'status' => '1', 'amount!=' => "", 'transaction_type !=' => ""));
        $data['user_list'] = $this->bank_deposit_model->select_all('sh_userdetail', array('company_id' => $c_id, 'location_id' => $location_id));
        //echo $this->db->last_query();
        //die();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        // $this->form_validation->set_rules('withdraw_amount', 'Withdraw Amount', 'trim|required');
        // $this->form_validation->set_rules('deposited_by', 'Deposited By', 'trim|required');

        if ($this->form_validation->run() != FALSE) {

            $deposited_by = $this->input->post('deposited_by');
            if ($deposited_by == 'n') {
                $deposited_by = "";
            } else {
                $deposited_by = $this->input->post('cheque_no');
            }
//			$data2 = array(
//							'deposit_amount' => $this->input->post('deposit_amount'), 
//			 				'amount' => $this->input->post('total_amount'),
//				 			//'deposited_by' => $this->input->post('deposited_by'),
//				 			//'cheque_no' => $deposited_by
//			 			);
//                         $update = $this->bank_deposit_model->update($this->input->get('id'),$data2);
            $damount = $this->bank_deposit_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id));
            $amount = 0;
            foreach ($damount as $d_amount) {
                if ($this->input->post("transaction_type$d_amount->id") == 'cs') {
                    $bankname = "";
                    $cheque = "";
                } else {
                    $bankname = $this->input->post("bank_name_$d_amount->id");
                    $cheque = $this->input->post("cheque_no_$d_amount->id");
                    $amount = $amount + $this->input->post("cheque_no_$d_amount->id");
                }

                $data = array(
                    'customer_id' => $this->input->post("c_name_$d_amount->id"),
                    'amount' => $this->input->post("amount_$d_amount->id"),
                    'bank_name' => $bankname,
                    'transaction_number' => $cheque,
                    'transaction_type' => $this->input->post("transaction_type$d_amount->id")
                );

                $this->bank_deposit_model->update_cardit_info($d_amount->id, $data);
            }
            $this->bank_deposit_model->update($this->input->get('id'), array('amount' => $amount));
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
            redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $lid);
        } else {
            $this->load->view('web/bankdeposit_edit3', $data);
        }
    }

    function bankdeposit_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $this->load->model('bank_deposit_model');
        $id = $this->input->get('id');
        $sess_id = $_SESSION['logged_company']['id'];
        $data['bd'] = $this->bank_deposit_model->bankdeposit_info($id);
        $location_id = $data['bd'][0]->location_id;
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $data = array(
            'status' => '0'
        );
        $this->bank_deposit_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'User Deleted Successfully..');
        redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $lid);
    }

    function print_report() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('bank_deposit_model');
        $this->load->model('daily_reports_model');
        $fdate = date("Y-m-d", strtotime($this->input->get('sdate')));
        $tdate = date("Y-m-d", strtotime($this->input->get('edate')));
        $data['location'] = $location = $this->input->get('lid');
        $id = $_SESSION['logged_company']['id'];
        $data['list'] = $this->bank_deposit_model->bankdeposit_list($fdate, $tdate, $location);
        //echo $this->db->last_query();
        $data['onlinelist'] = $this->bank_deposit_model->online_list($fdate, $tdate, $location);
        $data['creadit_dabit_list'] = $this->bank_deposit_model->creadit_dabit_list($fdate, $tdate, $location);
        $data['wallet_list'] = $this->bank_deposit_model->wallet_list($fdate, $tdate, $location);
$data['listnew'] = $this->bank_deposit_model->bankdeposit_list_new($location, $fdate, $tdate);
		
        $data['pre_deposit_amount'] = $this->daily_reports_model->pre_deposit_amount($location, $fdate);
        $data['pre_cheq_deposit_amount'] = $this->bank_deposit_model->pre_cheq_deposit_amount($location, $fdate);
        $data['pre_deposit_wallet_amount'] = $this->daily_reports_model->pre_deposit_wallet_amount($location, $fdate);
        $data['pre_onlinetransaction'] = $this->daily_reports_model->pre_onlinetransaction($location, $fdate);
        $data['prev_card_depost'] = $this->daily_reports_model->prev_card_depost($location, $fdate);
        $data['prev_petty_cash_deposit'] = $this->daily_reports_model->prev_petty_cash_deposit($location, $fdate);
        $data['prev_petty_cash_withdrawal'] = $this->daily_reports_model->prev_petty_cash_withdrawal($location, $fdate);
        $data['petty_cash_deposit_list'] = $this->bank_deposit_model->petty_cash_deposit_list($fdate, $tdate, $location);
        $data['petty_cash_withdrawal_list'] = $this->bank_deposit_model->petty_cash_withdrawal_list($fdate, $tdate, $location);
        $data['location_detail'] = $this->daily_reports_model->location_detail($location);
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

    function print_report_tst() {
        $this->load->model('daily_reports_model');
        $location = $this->input->get('lid');
        $fdate = date("Y-m-d", strtotime($this->input->get('sdate')));
        $tdate = date("Y-m-d", strtotime($this->input->get('edate')));
        $data['location_detail'] = $this->daily_reports_model->location_detail($location);

        $this->load->model('bank_deposit_model');
        $data['list'] = $this->bank_deposit_model->bankdeposit_list($fdate, $tdate, $location);
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

    function petty_cash_edit() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('bank_deposit');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('bank_deposit_model');
        $data['id'] = $id = $this->input->get('id');
        $this->load->model('Petty_cash_member_model');
        $id = $this->input->get_post('id');
        $data['id'] = $id;
        $c_id = $_SESSION['logged_company']['id'];
        $data['member_list'] = $this->Petty_cash_member_model->get_tbl_list('petty_cash_member', array('status' => 1, 'company_id' => $c_id), array('name', 'asc'));
        $data['petty_cash_detail'] = $this->Petty_cash_member_model->get_tbl_one('petty_cash_transaction', array('status' => 1, 'id' => $id));
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('paymenttype', 'Transection Type', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('memberid', 'Member', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $date = $this->input->post('date');
            $data = array(
                'member_id' => $this->input->get_post('memberid'),
                'date' => date('Y-m-d', strtotime($this->input->get_post('date'))),
                'type' => $this->input->get_post('type'),
                'remark' => $this->input->get_post('remark'),
                'amount' => $this->input->get_post('amount'),
                'transaction_type' => $this->input->get_post('paymenttype'),
                'transaction_no' => $this->input->get_post('chequenumber'),
                'bank_name' => $this->input->get_post('bank_name')
            );

            $update = $this->Petty_cash_member_model->update_record($id, $data);
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
            redirect('bank_deposit/bankdonlineeposit_view?date=' . $this->input->get_post('date') . "&sdate=" . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $this->input->get('l_id'));
        } else {
            //$this->load->view('web/petty_cash_member_info', $data);
            $this->load->view('web/petty_cash_edit', $data);
        }
    }
    function petty_cash_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $this->load->model('Petty_cash_member_model');
        $this->load->model('bank_deposit_model');
        $id = $this->input->get('id');
        $data['bd'] = $this->bank_deposit_model->bankdeposit_info($id);
        $location_id = $data['bd'][0]->location_id;
        $lid = $data['bd'][0]->location_id;
        $sess_id = $_SESSION['logged_company']['id'];
        
        $data = array(
            'status' => '0'
        );
        //$this->bank_deposit_model->delete($id, $data);
        $update = $this->Petty_cash_member_model->update_record($id, $data);
        $this->session->set_flashdata('fail', 'Data Deleted Successfully..');
//        redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $lid);
//        redirect('bank_deposit/bankdonlineeposit_view?date=' . $this->input->get_post('date') . "&sdate=" . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $this->input->get('l_id'));
        redirect("bank_deposit?sdate=" . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $this->input->get('l_id'));
    }
    //01-05-2019 mehul code start 
     public function reportlist2()
    {
         $html = "";
        $location = $this->input->post('lid');
        $date1 = date("Y-m-d", strtotime($this->input->post('date')));
        $this->load->model('bank_deposit_model');
       $data = $this->bank_deposit_model->get_report_type($location,$date1);
      $no = 1; 
      $total = 0;
    if($data != ""){   
    foreach ($data as $key) {

       $html .="<tr>";
            $html .= "<td>" . $no++ . "</td>";
            $html .= "<td>" . date('d-m-Y', strtotime($key['date'])) . "</td>";
            $html .= "<td>" . number_format($key['amount'], 2) . "</td>";
            $html .= "<td>" . $key['batch_no'] . "</td>";
            $html .= "</tr>";   
            $total = $total + $key['amount'];      
    }
    
    $html .= "<tr><td></td><td><B>Total Balance</b></td><td>" .number_format($total, 2). "</td></tr>";
        echo $html;
            
        }else{
            echo $html = "";
        }
    }
	
	
	public function withdraw_amount()
    {
		
         $html = "";
        $location = $this->input->post('lid');
        $date1 = date("Y-m-d", strtotime($this->input->post('date')));
        $this->load->model('bank_deposit_model');
		$data = $this->bank_deposit_model->online_lists($date1, $location);
		//echo "<pre>"; print_r($data); die;
      $no = 1; 
      $total = 0;
    if($data != ""){   
    foreach ($data as $key) {

       $html .="<tr>";
            $html .= "<td>" . $no++ . "</td>";
            $html .= "<td>" . date('d-m-Y', strtotime($key->date)) . "</td>";
            $html .= "<td>" . number_format($key->amount, 2) . "</td>";
            $html .= "<td>" . $key->cheque_tras_no . "</td>";
            $html .= "</tr>";   
            $total = $total + $key->amount;      
    }
    
    $html .= "<tr><td></td><td><B>Total Balance</b></td><td>" .number_format($total, 2). "</td></tr>";
        echo $html;
            
        }else{
            echo $html = "";
        }
    }
	
	
	public function customer_amount()
    {
		
         $html = "";
        $location = $this->input->post('lid');
        $date1 = date("Y-m-d", strtotime($this->input->post('date')));
        $this->load->model('bank_deposit_model');
		$data = $this->bank_deposit_model->creadit_dabit_lists($date1, $location);
		$no = 1; 
      $total = 0;
    if($data != ""){   
    foreach ($data as $key) {

       $html .="<tr>";
            $html .= "<td>" . $no++ . "</td>";
            $html .= "<td>" . date('d-m-Y', strtotime($key->date)) . "</td>";
            $html .= "<td>" . number_format($key->amount, 2) . "</td>";
            $html .= "<td>" . $key->name . "</td>";
            $html .= "</tr>";   
            $total = $total + $key->amount;      
    }
    
    $html .= "<tr><td></td><td><B>Total Balance</b></td><td>" .number_format($total, 2). "</td></tr>";
        echo $html;
            
        }else{
            echo $html = "";
        }
    }
    //01-05-2019 mehul code end
	public function expanses_online_edit(){
		
		if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
		$data["logged_company"] = $_SESSION['logged_company'];
		$id = $this->input->get('id');
        $data['id'] = $id;
        $c_id = $_SESSION['logged_company']['id'];
		$this->load->model('bank_deposit_model');
		$data['expanses_online'] = $this->bank_deposit_model->expanses_online($id);
		$this->form_validation->set_rules('amount', 'Amount', 'required');
		date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
			$date = $this->input->post('date');
			$date = date('Y-m-d', strtotime($date));
			$updatedate = array(
			'date'=>$date,
			'amount'=>$this->input->post('amount'),
			'bank_name'=>$this->input->post('bank_name')
			);
			$this->bank_deposit_model->delete2($id,$updatedate);
			$updatedate = array(
			'date'=>$date,
			'amount'=>$this->input->post('amount'),
			'reson'=>$this->input->post('bank_name')
			);
			$this->bank_deposit_model->upadte_expance_detail($data['expanses_online']->expence_id,$updatedate);
			$this->session->set_flashdata('success_update', 'Updated Successfully..');
			redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $this->input->get('l_id'));
		}else{
			$this->load->view('web/expanses_online_edit', $data);
		}
	}
	function expanses_online_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];


        $this->load->model('bank_deposit_model');
        $id = $this->input->get('id');
        $sess_id = $_SESSION['logged_company']['id'];
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $data = array(
            'status' => '0'
        );
		$expanses_online = $this->bank_deposit_model->expanses_online($id);
        $this->bank_deposit_model->delete2($id, $data);
		$this->bank_deposit_model->upadte_expance_detail($expanses_online->expence_id,$data);
        $this->session->set_flashdata('fail', 'Entry Deleted Successfully..');
        redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $this->input->get('l_id'));
    }

}

?>