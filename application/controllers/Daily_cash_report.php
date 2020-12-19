<?php

class Daily_cash_report extends CI_Controller {

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
            ini_set('display_errors', -1);
    }

    function index() {
        $this->load->model('daily_cash_report_model');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $c_id = $_SESSION['logged_company']['id'];
        $data['Employee'] = $this->daily_cash_report_model->master_fun_get_tbl_val1('shusermaster', array('status' => 1, 'company_id' => $c_id));

        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location'] = $this->daily_cash_report_model->master_fun_get_tbl_val_location('sh_location', array('status' => 1,'show_hide' =>'show','company_id' => $c_id));
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['location'] = $this->daily_cash_report_model->get_location($u_id);
        }
        $this->load->view('web/daily_cash_report', $data);
    }

    public function reportlist() {


        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('daily_cash_report_model');
        $this->load->model('daily_reports_model');
        $fdate = date("Y-m-d", strtotime($this->input->post('sdate')));
        $tdate = date("Y-m-d", strtotime($this->input->post('edate')));
        $location = $this->input->post('lid');
        $id = $_SESSION['logged_company']['id'];
        $cash_on_hand_list = $this->daily_cash_report_model->get_cash_on_hand($fdate, $tdate, $location);
//        echo $this->db->last_query();
        //$onlinelist = $this->daily_cash_report_model->get_bank_deposit($fdate, $tdate, $location); 
        $onlinelist = $this->daily_cash_report_model->get_bank_deposit(date('Y-m-d', strtotime($fdate . ' -2 day')), $tdate, $location); 
        
        
        $petty_cash_in = $this->daily_cash_report_model->get_petty_cash_in($fdate, $tdate, $location);
        $petty_cash_out = $this->daily_cash_report_model->get_petty_cash_out($fdate, $tdate, $location);
//        
//        echo $this->db->last_query();
        
        $customer_cash_in = $this->daily_cash_report_model->get_customer_cash_in($fdate, $tdate, $location);
         
        //
        $fianlarray = array();
        foreach ($cash_on_hand_list as $cash_on_hand) {
            $fianlarray[$cash_on_hand->date]['date'] = $cash_on_hand->date;
            $fianlarray[$cash_on_hand->date]['deposit_amount'] = $cash_on_hand->cash_on_hand;
            
        }
     
        foreach ($onlinelist as $bankdetail) {
			if(strtotime(date('Y-m-d', strtotime($bankdetail->date . ' -1 day'))) >= strtotime($fdate)){
            $fianlarray[date('Y-m-d', strtotime($bankdetail->date . ' -1 day'))]['date'] = date('Y-m-d', strtotime($bankdetail->date . ' -1 day'));
            //$fianlarray[$bankdetail->date]['bank_deposit_amount'] = $bankdetail->deposit_amount;
            $fianlarray[date('Y-m-d', strtotime($bankdetail->date . ' -1 day'))]['bank_deposit_amount'] = $bankdetail->deposit_amount;
            $fianlarray[date('Y-m-d', strtotime($bankdetail->date . ' -1 day'))]['user_deposit_amount'] = $bankdetail->amount;
			}
			
        }
		
		//die();
        foreach ($petty_cash_in as $cash_in) {
            $fianlarray[$cash_in->date]['date'] = $cash_in->date;
            $fianlarray[$cash_in->date]['petty_cash_in'] = $cash_in->petty_cash_in;
        }
		foreach ($petty_cash_out as $cash_out) {
            $fianlarray[$cash_out->date]['date'] = $cash_out->date;
            $fianlarray[$cash_out->date]['petty_cash_out'] = $cash_out->petty_cash_in;
        }
        foreach ($customer_cash_in as $cash_in) {
            $fianlarray[$cash_in->date]['date'] = $cash_in->date;
            $fianlarray[$cash_in->date]['customer_cash_in'] = $cash_in->customer_cash_in;
        }
//           echo "<pre>";
//        print_r($fianlarray);
//        die();
        function sortByName($a, $b) {
            $a = $a['date'];
            $b = $b['date'];

            if ($a == $b)
                return 0;
            return ($a < $b) ? -1 : 1;
        }

        $base_url = base_url();
        $html = "";
        usort($fianlarray, 'sortByName');
        $no = 0;
        $deposit_amount_total = 0;
        $bank_deposit_amount_total = 0;
        $user_deposit_amount = 0;
        $petty_cash_in_total = 0;
        $customer_cash_in_total = 0;
        $f_total = 0;
		       /*   echo "<pre>";
       print_r($fianlarray);
       die();*/
	   $pre = 0;
        foreach ($fianlarray as $customers) {
			if(isset($customers['date'])){
            $html .= "<tr>";
            $no++;
            $total = 0;
            $deposit_amount_total = $deposit_amount_total+$customers['deposit_amount'];
            if($customers['bank_deposit_amount'] != ""){
            $bank_deposit_amount_total = $bank_deposit_amount_total+$customers['bank_deposit_amount'];
            }
            $user_deposit_amount = $user_deposit_amount+$customers['user_deposit_amount'];
            $petty_cash_in_total = $petty_cash_in_total+$customers['petty_cash_in'];
            $customer_cash_in_total = $customer_cash_in_total+$customers['customer_cash_in'];
           
            $html .= "<td>" . $no . "</td>";
            $html .= "<td>" . date('d-m-Y', strtotime($customers['date'])) . "</td>";
            $html .= "<td>" . amountfun($pre) . "</td>";
            $html .= "<td>" . $deposit_amount =  amountfun($customers['deposit_amount']) . "</td>";
            
            $html .= "<td>" . $petty_cash_in = amountfun($customers['petty_cash_in']) . "</td>";
			$html .= "<td>" . $petty_cash_out = amountfun($customers['petty_cash_out']) . "</td>";
            $html .= "<td>" .$customer_cash_in = amountfun($customers['customer_cash_in']) . "</td>";
            $html .= "<td>" . $bank_deposit_amount = amountfun($customers['bank_deposit_amount']) . "</td>";
             $total = ($customers['bank_deposit_amount']+$customers['petty_cash_out'])-($customers['deposit_amount']+$pre+$customers['petty_cash_in']+$customers['customer_cash_in']);
            $html .= "<td>" . amountfun($total) . "</td>";
			$pre = ($customers['deposit_amount']+$pre+$customers['petty_cash_in']+$customers['customer_cash_in'])-($customers['bank_deposit_amount']+$customers['petty_cash_out']);
            $f_total = $f_total+$total;
//            $html .= "<td>" . number_format($customers['user_deposit_amount'], 2) . "</td>";
            $html .= "</tr>";
		}
        }
        $html .= "<tr><td colspan='3'>Total</td><td>" . amountfun($deposit_amount_total) . "</td><td>" . amountfun($petty_cash_in_total) . "</td><td>" . amountfun($customer_cash_in_total) . "</td><td></td><td>" . amountfun($bank_deposit_amount_total) . "</td><td>" . amountfun($f_total) . "</td></tr>";
		
		
		 $html .= "<tr><td colspan='3'>Final total</td><td>" . amountfun($deposit_amount_total+$petty_cash_in_total+$customer_cash_in_total) . "</td><td></td><td></td><td></td><td>" . amountfun($bank_deposit_amount_total) . "</td><td>" . amountfun(($bank_deposit_amount_total)-($deposit_amount_total+$petty_cash_in_total+$customer_cash_in_total)) . "</td></tr>";
		
		
        echo $html;
    }

    function bankdonlineeposit_view() {
        $date = date("Y-m-d", strtotime($this->input->get('date')));
        $location = $this->input->get('l_id');
        $id = $_SESSION['logged_company']['id'];
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('daily_cash_report_model');
        $data['list'] = $this->daily_cash_report_model->bankdeposit_list_view($date, $location);
        $data['list2'] = $this->daily_cash_report_model->bankdeposit_list_view_new($date, $location);
        if ($_GET['d_id'] == 1) {
            echo $this->db->last_query();
            ;
            echo "<pre>";
            print_r($data['list']);
            die();
        }
        $data['onlinelist'] = $this->daily_cash_report_model->online_list_view($date, $location);
//		echo $this->db->last_query();
//                die();
        $data['creadit_dabit_list'] = $this->daily_cash_report_model->creadit_dabit_list_view($date, $location);
        $data['wallet_list'] = $this->daily_cash_report_model->wallet_list_view($date, $location);
        $data['get_petty_cash_tasection_list'] = $this->daily_cash_report_model->get_petty_cash_tasection_list($date, $location);
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
        $this->load->model('daily_cash_report_model');
        $data['id'] = $id = $this->input->get('id');
        $data['bd'] = $this->daily_cash_report_model->wallet_info($id);
        $lid = $this->input->get('l_id');
        $data['extras'] = $this->daily_cash_report_model->ptypebylocation($lid);
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));

        $this->form_validation->set_rules('card_amount', 'Card Amount', 'trim|required');
        $this->form_validation->set_rules('extra_id', 'Payment Type', 'trim|required');
        if ($this->form_validation->run() != FALSE) {
            $data = array(
                'amount' => $this->input->post('card_amount'),
                'extra_id' => $this->input->post('extra_id'),
                'batch' => $this->input->post('batch'),
            );
            $update = $this->daily_cash_report_model->update_card_details($id, $data);
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
        $this->load->model('daily_cash_report_model');
        $id = $this->uri->segment('3');
        $data['bd'] = $this->daily_cash_report_model->bankdeposit_info($id);
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
        $this->load->model('daily_cash_report_model');
        $data['id'] = $id = $this->input->get('id');

        $data['bd'] = $this->daily_cash_report_model->online_info($id);
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

            $update = $this->daily_cash_report_model->update2($id, $data);
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


        $this->load->model('daily_cash_report_model');
        $id = $this->input->get('id');
        $data['bd'] = $this->daily_cash_report_model->online_info($id);
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->daily_cash_report_model->delete2($id, $data);
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
        $this->load->model('daily_cash_report_model');
        $data['id'] = $id = $this->input->get('id');
        $data['bd'] = $this->daily_cash_report_model->card_info($id);
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

            $update = $this->daily_cash_report_model->update_card_details($id, $data);
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


        $this->load->model('daily_cash_report_model');
        $id = $this->input->get('id');
        $data['bd'] = $this->daily_cash_report_model->card_info($id);
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->daily_cash_report_model->update_card_details($id, $data);
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


        $this->load->model('daily_cash_report_model');
        $id = $this->input->get('id');
        $data['bd'] = $this->daily_cash_report_model->wallet_info($id);
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->daily_cash_report_model->update_card_details($id, $data);
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
        $this->load->model('daily_cash_report_model');
        $data['id'] = $id = $this->input->get('id');

        $data['bd'] = $this->daily_cash_report_model->bankdeposit_info($id);
        $location_id = $data['bd'][0]->location_id;
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        // $bank_id = $data['bd']->id;
        $data['d_amount'] = $this->daily_cash_report_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id, 'status' => '1', 'amount!=' => "", 'transaction_type !=' => ""));
        $data['user_list'] = $this->daily_cash_report_model->select_all('sh_userdetail', array('company_id' => $c_id, 'location_id' => $location_id));
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
            $update = $this->daily_cash_report_model->update($this->input->get('id'), $data2);
            $damount = $this->daily_cash_report_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id));
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

                $this->daily_cash_report_model->update_cardit_info($d_amount->id, $data);
            }
            $this->daily_cash_report_model->update($this->input->get('id'), array('amount' => $amount));
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
        $this->load->model('daily_cash_report_model');
        $data['id'] = $id = $this->input->get('id');

        $data['bd'] = $this->daily_cash_report_model->bankdeposit_info($id);
        $location_id = $data['bd'][0]->location_id;
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        // $bank_id = $data['bd']->id;
        $data['d_amount'] = $this->daily_cash_report_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id, 'status' => '1', 'amount!=' => "", 'transaction_type !=' => ""));
        $data['user_list'] = $this->daily_cash_report_model->select_all('sh_userdetail', array('company_id' => $c_id, 'location_id' => $location_id));
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
            $update = $this->daily_cash_report_model->update($this->input->get('id'), $data2);
            $damount = $this->daily_cash_report_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id));
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
//                            $this->daily_cash_report_model->update_cardit_info($d_amount->id,$data);
//                           
//                        }
            //$this->daily_cash_report_model->update($this->input->get('id'),array('amount'=>$amount));
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
        $this->load->model('daily_cash_report_model');
        $data['id'] = $id = $this->input->get('id');

        $data['bd'] = $this->daily_cash_report_model->bankdeposit_info($id);
        $location_id = $data['bd'][0]->location_id;
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        // $bank_id = $data['bd']->id;
        $data['d_amount'] = $this->daily_cash_report_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id, 'status' => '1', 'amount!=' => "", 'transaction_type !=' => ""));
        $data['user_list'] = $this->daily_cash_report_model->select_all('sh_userdetail', array('company_id' => $c_id, 'location_id' => $location_id));
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
//                         $update = $this->daily_cash_report_model->update($this->input->get('id'),$data2);
            $damount = $this->daily_cash_report_model->select_all('sh_credit_debit', array('bankdeposit_id' => $id));
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

                $this->daily_cash_report_model->update_cardit_info($d_amount->id, $data);
            }
            $this->daily_cash_report_model->update($this->input->get('id'), array('amount' => $amount));
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


        $this->load->model('daily_cash_report_model');
        $id = $this->input->get('id');
        $sess_id = $_SESSION['logged_company']['id'];
        $data['bd'] = $this->daily_cash_report_model->bankdeposit_info($id);
        $location_id = $data['bd'][0]->location_id;
        $lid = $data['bd'][0]->location_id;
        $date = date('d-m-Y', strtotime($data['bd'][0]->date));
        $data = array(
            'status' => '0'
        );
        $this->daily_cash_report_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'User Deleted Successfully..');
        redirect('bank_deposit?sdate=' . $this->input->get('sdate') . "&edate=" . $this->input->get('edate') . "&l_id=" . $lid);
    }

    function print_report() {
		error_reporting(0);
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('daily_cash_report_model');
        $this->load->model('daily_reports_model');
        $fdate = date("Y-m-d", strtotime($this->input->get('sdate')));
        $tdate = date("Y-m-d", strtotime($this->input->get('edate')));
        $data['location'] = $location = $this->input->get('lid');
        $id = $_SESSION['logged_company']['id'];
      $id = $_SESSION['logged_company']['id'];
      $data['location_detail'] = $this->daily_reports_model->location_detail($location);
        $data['cash_on_hand_list'] = $this->daily_cash_report_model->get_cash_on_hand($fdate, $tdate, $location);
        $data['onlinelist'] = $this->daily_cash_report_model->get_bank_deposit($fdate, $tdate, $location); 
        $data['petty_cash_in'] = $this->daily_cash_report_model->get_petty_cash_in($fdate, $tdate, $location);
        $data['customer_cash_in'] = $this->daily_cash_report_model->get_customer_cash_in($fdate, $tdate, $location);
        $this->load->library('m_pdf');
        $data['sdate'] = $fdate;
        $data['edate'] = $tdate;
        $html = $this->load->view('web/pdfdaily_cash_report.php', $data, true);

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

        $this->load->model('daily_cash_report_model');
        $data['list'] = $this->daily_cash_report_model->bankdeposit_list($fdate, $tdate, $location);
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
        $this->load->model('daily_cash_report_model');
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

}

?>