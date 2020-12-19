<?php
class Daily_reports_new_jun extends CI_Controller {

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
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
        $this->load->model('Daily_reports_model_new_jun');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location_list'] = $this->admin_model->select_location($id1);
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['location_list'] = $this->admin_model->get_location($u_id);
        }
        if ($this->input->get_post('sdate') == "") {
            $sdate = date('Y-m-d');
        } else {
            $sdate = date('Y-m-d', strtotime($this->input->get_post('sdate')));
        }
        if ($this->input->get_post('edate') == "") {
            $edate = date('Y-m-d');
        } else {
            $edate = date('Y-m-d', strtotime($this->input->get_post('edate')));
        }
        $location_id = $this->input->get_post('location');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['location'] = $location_id;

        if ($location_id != "") {
            $sdate1 = date("Y-m-d", strtotime('-1 day', strtotime($sdate)));
            $report = $this->Daily_reports_model_new_jun->report($location_id, $sdate1, $edate);
			//echo $this->db->last_query(); die;
			$vatList = $this->Daily_reports_model_new_jun->vatList($sdate1, $edate);
			$data['vatList'] = array();
			foreach($vatList as $Vat){
				$data['vatList'][$Vat->date] = $Vat->vat_per;
			}
			$savingList = $this->Daily_reports_model_new_jun->savingList($location_id,$sdate1, $edate);
			$data['savingList'] = array();
			foreach($savingList as $Vat){
				$data['savingList'][$Vat->date] = $Vat->total;
			}
            $data['report'] = array();
            foreach ($report as $d) {
                $p_data = $this->Daily_reports_model_new_jun->report_data($location_id, $d['date']);
			if (!empty($p_data)) {
                    $creshcrdittotal = $p_data[0]['creshcrdit'];
                    $d['petty_cash_credit_total'] = $creshcrdittotal;
                } else {
                    $d['petty_cash_credit_total'] = 0;
                }
                $data['report'][] = $d;
            }
            //$data['salary'] = $this->Daily_reports_model_new_jun->worker_salary_remening($location_id, $sdate, $edate);
            //$data['loansalary'] = $this->Daily_reports_model_new_jun->worker_salary_loan($location_id, $edate);
            //$data['salary'] = $this->Daily_reports_model_new_jun->worker_salary_remening($location_id, $sdate, $edate);
            //$data['lastday'] = $this->Daily_reports_model_new_jun->last_day_entry($location_id, $sdate, $edate);
            //$data['monthly_expence'] = $this->Daily_reports_model_new_jun->monthly_expence($location_id, $sdate, $edate);
            //$data['ioc_balence'] = $this->Daily_reports_model_new_jun->ioc_balence($location_id, $sdate, $edate);
            //$data['deposit_amount'] = $this->Daily_reports_model_new_jun->deposit_amount($location_id, $sdate, $edate);
            //$data['prev_extra_depost'] = $this->Daily_reports_model_new_jun->prev_extra_depost($location_id, $sdate);
            //$data['onlinetransaction'] = $this->Daily_reports_model_new_jun->onlinetransaction($location_id, $sdate, $edate);
            //$data['get_customer_credit'] = $this->Daily_reports_model_new_jun->get_customer_credit($location_id, $sdate, $edate);
            //$data['get_credit'] = $this->Daily_reports_model_new_jun->get_credit($location_id, $edate);
            //$data['get_debit'] = $this->Daily_reports_model_new_jun->get_debit($location_id, $edate);
            //$data['get_customer_debit'] = $this->Daily_reports_model_new_jun->get_customer_debit($location_id, $sdate, $edate);
            $newdate = date('Y-m-d', strtotime($edate . ' + 1 days'));
            $this->load->model('company_report_model');
            $this->load->model('bank_deposit_model');
            //$data['pre_onlinetransaction'] = $this->Daily_reports_model_new_jun->pre_onlinetransaction($location_id, $newdate);
            //$data['pre_deposit_amount'] = $this->Daily_reports_model_new_jun->pre_deposit_amount($location_id, $newdate);
            //$data['prev_card_depost'] = $this->Daily_reports_model_new_jun->prev_card_depost($location_id, $newdate);
            //$data['pre_onlinetransaction'] = $this->Daily_reports_model_new_jun->pre_onlinetransaction($location_id, $newdate);
            //$data['pre_cheq_deposit_amount'] = $this->bank_deposit_model->pre_cheq_deposit_amount($location_id, $newdate);
            //$data['pre_deposit_wallet_amount'] = $this->Daily_reports_model_new_jun->pre_deposit_wallet_amount($location_id, $newdate);
            //$data['prv_ioc_total'] = $this->company_report_model->get_pre_ioc_total($location_id, $newdate);
            //$data['prv_transection_total'] = $this->company_report_model->get_pre_transection_total($location_id, $newdate);
            //$data['prv_purchase_total'] = $this->company_report_model->get_pre_purchase_total($location_id, $newdate);
            //$data['petty_cash_deposit_list'] = $this->Daily_reports_model_new_jun->prev_petty_cash_deposit($location_id, $newdate);
            //$data['prev_petty_cash_withdrawal'] = $this->Daily_reports_model_new_jun->prev_petty_cash_withdrawal($location_id, $newdate);
            //$data['petty_cash_deposit_list_cash'] = $this->Daily_reports_model_new_jun->prev_petty_cash_deposit_cash($location_id, $newdate);
            //$data['prev_petty_cash_withdrawal_cash'] = $this->Daily_reports_model_new_jun->prev_petty_cash_withdrawal_cash($location_id, $newdate);
			$bay_stock_details = $this->Daily_reports_model_new_jun->get_bay_stock_details($location_id, $sdate, $edate);
			$company_credit = $this->Daily_reports_model_new_jun->company_credit($location_id, $sdate, $edate);
			$company_debit = $this->Daily_reports_model_new_jun->company_debit($location_id, $sdate, $edate);
			$bank_expense = $this->Daily_reports_model_new_jun->bank_expense($location_id, $sdate, $edate);
			$onlinetransaction_cs = $this->Daily_reports_model_new_jun->onlinetransaction_cs($location_id, $sdate, $edate);
			//echo $this->db->last_query();
			$data['onlinetransaction_cs'] = array();
			foreach($onlinetransaction_cs as $onlinetransaction){
				$data['onlinetransaction_cs'][$onlinetransaction->date] = $onlinetransaction->totalamount;
			}
		/*print_r($data['onlinetransaction_cs']); die();*/
			$data['bank_expense'] = array();
			foreach($bank_expense as $companycredit){
				$data['bank_expense'][$companycredit->date] = $companycredit->totalamount;
			}
			//echo "<pre>"; print_r($data['bank_expense']); die();
			$data['company_credit_debit'] = array();
			foreach($company_credit as $companycredit){
				$data['company_credit_debit']['c'][$companycredit->date] = $companycredit->totalamount;
			}
			foreach($company_debit as $companycredit){
				$data['company_credit_debit']['d'][$companycredit->date] = $companycredit->totalamount;
			}
			//echo "<pre>"; print_r($data['company_credit_debit']); die();
            $bay_stock_array = array();
            foreach ($bay_stock_details as $oil){
            $bay_stock_array[$oil->date]['total_qty_ltr'] = $oil->total_qty_ltr;    
            $bay_stock_array[$oil->date]['total_qty']    = $oil->total_qty;
            }
            $data['bay_stock_array'] = $bay_stock_array;
            $total_balance = $this->Daily_reports_model_new_jun->total_balance($location_id, $sdate, $edate);
            $data['cashdebit'] = $cashdebit = $total_balance[0]->cashdebit;
            $data['creshcrdit'] = $creshcrdit = $total_balance[0]->creshcrdit;
            $cash_balance = $creshcrdit - $cashdebit;
            $data['personal_debite_credit'] = $cash_balance;
            $get_tank_readin = $this->Daily_reports_model_new_jun->get_tank_readin($location_id, $sdate1, $edate);
			$get_oil_detail = $this->Daily_reports_model_new_jun->get_oil_detail($location_id, $sdate, $edate);

            $oil_final_array = array();
            foreach ($get_oil_detail as $oil_detail) {
                $oil_final_array[$oil_detail->date]['buy'] = $oil_final_array[$oil_detail->date]['buy'] + ($oil_detail->Reading * $oil_detail->buyprice);
                $oil_final_array[$oil_detail->date]['sell'] = $oil_final_array[$oil_detail->date]['sell'] + ($oil_detail->Reading * $oil_detail->salesprice);
            }
            $data['oil_final_array'] = $oil_final_array;
            $get_oil_detail_price = $this->Daily_reports_model_new_jun->get_oil_detail_price($location_id, $sdate, $edate);
            $online_bank_expance_dailyreport = $this->bank_deposit_model->online_bank_expance_dailyreport($location_id, $sdate, $edate);
			$data['online_bank_expance_array'] = array();
			foreach($online_bank_expance_dailyreport as $online_bank_expance_daily){
				$data['online_bank_expance_array'][$online_bank_expance_daily->date] = $online_bank_expance_daily->amount;
			}
            $oil_detail_price = array();
            foreach ($get_oil_detail_price as $d) {
                $stock_in_l = 0;
				$oil_detail_price[$d->date]['bay_price'] = $d->total_bay_price;
                $oil_detail_price[$d->date]['sel_price'] = $d->total_sel_price;
                $oil_detail_price[$d->date]['separate_stock'] = $separate_stock  = $this->Daily_reports_model_new_jun->get_oil_detail_separate_price($location_id, $d->date);
                $total_result = $this->Daily_reports_model_new_jun->get_oil_detail_separate_price_total($location_id, $d->date);
                $oil_detail_price[$d->date]['total'] = $total_result[0]->total;
                foreach ($separate_stock as $s){
                    if($s->p_type == 'kg' || $s->p_type == 'ltr' ){
						$toal =  $s->p_qty*$s->stock;
						$stock_in_l = $stock_in_l+$toal;
				    }else{
                       $st =  ($s->p_qty*$s->stock)/1000;
                        $stock_in_l = $stock_in_l+$st;
				    }
                }
				 $oil_detail_price[$d->date]['total_stock_in_l'] = $stock_in_l;
                $oil_detail_price[$d->date]['stock'] = $d->stock;
            }
            $data['oil_detail_price'] = $oil_detail_price;
            $finaltank = array();
            foreach ($get_tank_readin as $tank) {
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['name'] = $tank->tank_name;
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['deepreading'] = $tank->deepreading;
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['volume'] = $tank->volume;
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['tank_id'] = $tank->tank_id;
            }
			//echo "<pre>"; print_r($finaltank); die;
            $data['finaltank'] = $finaltank;
            $data['location_tank_list'] = $this->Daily_reports_model_new_jun->select_all_with_order('id,tank_name,tank_type,fuel_type,start_to,end_to,mobile_show,web_show,xp_type', 'sh_tank_list', array('location_id' => $location_id, "status" => '1'), array('tank_name', 'asc'));
			$location_tank_list = $data['location_tank_list'];
			$vishaltanklist = array();
			foreach($location_tank_list as $list){
				
				if($list->start_to == NULL && $list->end_to == NULL){
					$vishaltanklist[] = $list;
				}else{
					// $data['sdate'] = $sdate;
					// $data['edate'] = $edate;
					//echo $sdate." >= ".$list->start_to;
					if($list->web_show == '0'){
				if(((strtotime($edate) >= strtotime($list->start_to)) && (strtotime($sdate) <= strtotime($list->start_to))) || (strtotime($sdate) <= strtotime($list->start_to)) ){
					
						$vishaltanklist[] = $list;
					}
					}else{
						$vishaltanklist[] = $list;
					}
					
				}
			}
			
			$tanklistwithdeep = array();
			foreach($vishaltanklist as $vishaltanklists){
				$deeps = $this->Daily_reports_model_new_jun->get_tank_chart($vishaltanklists->id);
				foreach($deeps as $deep){
					$tanklistwithdeep[$vishaltanklists->id][$deep->reading] = $deep->volume;
				}
			}
			$data['tanklistwithdeep'] = $tanklistwithdeep;
			$data['location_tank_list'] = $vishaltanklist;
			//echo "<pre>"; print_r($data); die();
			//echo "<pre>"; print_r($data['location_detail']);
			$data['location_detail'] = $this->Daily_reports_model_new_jun->location_detail($location_id);
			//print_r($data['location_detail']); die;
        }
		if ($this->input->get_post('debug') == "1") {
		$this->load->view('web/daily_report_new_jun_debug', $data);
		}else{
        $this->load->view('web/daily_report_new_jun', $data);
		}
    }
	
	function inventoryreport() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
        $this->load->model('Daily_reports_model_new_jun');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $data['location_list'] = $this->admin_model->select_location($id1);
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['location_list'] = $this->admin_model->get_location($u_id);
        }
        if ($this->input->get_post('sdate') == "") {
            $sdate = date('Y-m-d');
        } else {
            $sdate = date('Y-m-d', strtotime($this->input->get_post('sdate')));
        }
        if ($this->input->get_post('edate') == "") {
            $edate = date('Y-m-d');
        } else {
            $edate = date('Y-m-d', strtotime($this->input->get_post('edate')));
        }
        $location_id = $this->input->get_post('location');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['location'] = $location_id;

        if ($location_id != "") {
            $data['report'] = $this->Daily_reports_model_new_jun->get_inventory_list($location_id, $sdate, $edate);
			$data['location_detail'] = $this->Daily_reports_model_new_jun->location_detail($location_id);
			
        }
		
		//echo $this->db->last_query(); die;
        $this->load->view('web/inventoryreport', $data);
    }
	
	function profit_loss_report(){
		if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
        $this->load->model('Daily_reports_model_new_jun');
		if ($this->input->get_post('sdate') == "") {
            $sdate = date('Y-m-d');
        } else {
            $sdate = date('Y-m-d', strtotime($this->input->get_post('sdate')));
        }
		if ($this->input->get_post('edate') == "") {
            $edate = date('Y-m-d');
        } else {
            $edate = date('Y-m-d', strtotime($this->input->get_post('edate')));
        }
		
        $location_id = $this->input->get_post('location');
        $data['date'] = $date;
        $data['location'] = $location_id;
		$id1 = $_SESSION['logged_company']['id'];
        $this->load->model('admin_model');
            $data['location_list'] = $this->admin_model->select_location($id1);
		if($location_id != ""){
			$this->load->model('company_report_model');
            $this->load->model('bank_deposit_model');
            $this->load->model('Petty_cash_member_model');
			$data['paidsalary'] = $this->Daily_reports_model_new_jun->worker_salary_paid_salary($location_id, $sdate, $edate);
			//print_r($data['paidsalary']); die();
			$data['loansalary'] = $this->Daily_reports_model_new_jun->worker_salary_loan($location_id, $edate);
			$data['pre_deposit_amount'] = $this->Daily_reports_model_new_jun->pre_deposit_amount($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			//echo $this->db->last_query(); die();
			$data['pre_cheq_deposit_amount'] = $this->bank_deposit_model->pre_cheq_deposit_amount($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			$data['pre_deposit_wallet_amount'] = $this->Daily_reports_model_new_jun->pre_deposit_wallet_amount($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			$data['prev_card_depost'] = $this->Daily_reports_model_new_jun->prev_card_depost($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			$data['prev_petty_cash_deposit'] = $this->Daily_reports_model_new_jun->prev_petty_cash_deposit($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			$data['pre_onlinetransaction'] = $this->Daily_reports_model_new_jun->pre_onlinetransaction($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			$data['prev_petty_cash_withdrawal'] = $this->Daily_reports_model_new_jun->prev_petty_cash_withdrawal($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			//$data['prv_ioc_total'] = $this->company_report_model->get_pre_ioc_total($location_id,date('Y-m-d',date('Y-m-d', strtotime($edate . ' + 1 days'))));

			//$data['prv_transection_total'] = $this->company_report_model->get_pre_transection_total($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			//$data['prv_purchase_total'] = $this->company_report_model->get_pre_purchase_total($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			$prv_ioc_total = $this->company_report_model->get_pre_ioc_total($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			$prv_transection_total = $this->company_report_model->get_pre_transection_total($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			$prv_purchase_total = $this->company_report_model->get_pre_purchase_total($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
			
			$total_balance = $this->Petty_cash_member_model->total_balance($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')),$edate,$edate,$member_id);

			
			
			$data['lastday'] = $this->Daily_reports_model_new_jun->last_day_entry($location_id, $sdate, $edate);
			$data['get_credit'] = $this->Daily_reports_model_new_jun->get_credit($location_id, $edate);
			//echo $this->db->last_query();
			$data['get_debit'] = $this->Daily_reports_model_new_jun->get_debit($location_id, $edate);
			$get_oil_detail = $this->Daily_reports_model_new_jun->get_oil_detail($location_id, $sdate, $edate);
			$get_dailyselling_list = $this->Daily_reports_model_new_jun->get_dailyselling_list($sdate,$edate,$location_id);
			
			$get_dailyprice_list = $this->Daily_reports_model_new_jun->get_dailyprice_list($sdate,$edate,$location_id);
			$get_dailyinv_list = $this->Daily_reports_model_new_jun->get_dailyinv_list($sdate,$edate,$location_id);
			$get_expencetotal = $this->Daily_reports_model_new_jun->get_expencetotal($sdate,$edate,$location_id);
			$salary = $this->Daily_reports_model_new_jun->worker_salary_remening($location_id, $sdate, $edate);
			//echo $this->db->last_query(); die();
			//$data['patycashin'] = $this->Daily_reports_model_new_jun->patycashin($location_id, $edate);
			
			//$data['patycashout'] = $this->Daily_reports_model_new_jun->patycashout($location_id, $edate);
			$vatList = $this->Daily_reports_model_new_jun->vatList($sdate1, $edate);
			$company_credit = $this->Daily_reports_model_new_jun->company_credit_total($location_id,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			$company_debit = $this->Daily_reports_model_new_jun->company_debit_total($location_id,date("Y-m-d",strtotime($sdate)),date("Y-m-d",strtotime($edate)));
			
			$data['companybalnce'] = $company_credit->totalamount-$company_debit->totalamount;
			$vatListarray = array();
			foreach($vatList as $Vat){
				$vatListarray[$Vat->date] = $Vat->vat_per;
			}
			$get_dailyselling_list_array = array();
			foreach($get_dailyselling_list as $list){
				$get_dailyselling_list_array[$list->date] = $list;
			}
			$get_dailyprice_list_array = array();
			foreach($get_dailyprice_list as $list){
				$get_dailyprice_list_array[$list->date] = $list;
			}
			$get_dailyinv_list_array = array();
			foreach($get_dailyinv_list as $list){
				$get_dailyinv_list_array[$list->date][$list->fuel_type] = $list;
			}
			
			$finalarray = array();
			$dbenifit = 0;
			$pbenifit = 0;
			$obenifit = 0;
			$dtotaldbuyvat = 0;
			$ptotaldbuyvat = 0;
			$dtotaldsellingvat = 0;
			$ptotaldsellingvat = 0;
			$oil_cgst = 0;
			foreach ($get_oil_detail as $oil_detail) {
                $oil_final_array[$oil_detail->date]['buy'] = $oil_final_array[$oil_detail->date]['buy'] + ($oil_detail->Reading * $oil_detail->buyprice);
                $oil_final_array[$oil_detail->date]['sell'] = $oil_final_array[$oil_detail->date]['sell'] + ($oil_detail->Reading * $oil_detail->salesprice);
				
            }
			for($date = $sdate; strtotime($date) <= strtotime($edate); ){
					$temp =array();
					$temp[$date]['d_total_selling'] = $get_dailyselling_list_array[$date]->d_total_selling;
					$temp[$date]['dis_price'] = $get_dailyprice_list_array[$date]->dis_price;
					$temp[$date]['d_new_price'] = $get_dailyinv_list_array[$date]['d']->d_new_price;
					$temp[$date]['d_quantity'] = $get_dailyinv_list_array[$date]['d']->d_quantity;
					$temp[$date]['d_tank_reading'] = $get_dailyselling_list_array[$date]->d_tank_reading;
					
					$temp[$date]['p_total_selling'] = $get_dailyselling_list_array[$date]->p_total_selling;
					$temp[$date]['pet_price'] = $get_dailyprice_list_array[$date]->pet_price;
					$temp[$date]['p_new_price'] = $get_dailyinv_list_array[$date]['p']->prev_p_price;
					$temp[$date]['p_quantity'] = $get_dailyinv_list_array[$date]['p']->p_quantity;
					$temp[$date]['o_quantity'] = $get_dailyinv_list_array[$date]['o']->oil_total_amount;
					$temp[$date]['oil_cgst'] = $get_dailyinv_list_array[$date]['o']->oil_cgst;
					$temp[$date]['oil_sgst'] = $get_dailyinv_list_array[$date]['o']->oil_sgst;
					$temp[$date]['p_tank_reading'] = $get_dailyselling_list_array[$date]->p_tank_reading;
					
					$temp[$date]['dtotaldbuyvat'] = $get_dailyinv_list_array[$date]['d']->dv_taxamount;
					$temp[$date]['ptotaldbuyvat'] = $get_dailyinv_list_array[$date]['p']->pv_taxamount;
					//echo "(".$temp[$date]['d_total_selling']."*".$temp[$date]['dis_price']." * ".$vatListarray[$date].") / (100+".$vatListarray[$date].")<br>";
					$dtotaldsellingvat = $dtotaldsellingvat + round(((round($temp[$date]['d_total_selling'] * $temp[$date]['dis_price'], 2) * $vatListarray[$date]) / (100+$vatListarray[$date])), 2);
					$ptotaldsellingvat = $ptotaldsellingvat + round(((round($temp[$date]['p_total_selling'] * $temp[$date]['pet_price'], 2) * $vatListarray[$date]) / (100+$vatListarray[$date])), 2);
					
					$oil_cgst = $oil_cgst+$temp[$date]['oil_cgst'];
					$oil_sgst = $oil_cgst+$temp[$date]['oil_sgst'];
					$dtotaldbuyvat = $dtotaldbuyvat+$temp[$date]['dtotaldbuyvat'];
					$ptotaldbuyvat = $ptotaldbuyvat+$temp[$date]['ptotaldbuyvat'];
					$temp[$date]['date'] = $date;
					$dstock = round(($temp[$date]['d_tank_reading']+$temp[$date]['d_quantity']-$temp[$date]['d_total_selling'])*$temp[$date]['d_new_price'],2);
					$pstock = round(($temp[$date]['p_tank_reading']+$temp[$date]['p_quantity']-$temp[$date]['p_total_selling'])*$temp[$date]['p_new_price'],2);
					$dbenifit = $dbenifit+(($temp[$date]['d_total_selling'] * $temp[$date]['dis_price'])-($temp[$date]['d_total_selling'] * $temp[$date]['d_new_price']));
					$pbenifit = $pbenifit+(($temp[$date]['p_total_selling'] * $temp[$date]['pet_price'])-($temp[$date]['p_total_selling'] * $temp[$date]['p_new_price']));
					$obenifit = $obenifit + ($oil_final_array[$date]['sell']-$oil_final_array[$date]['buy']);
					array_push($finalarray,$temp[$date]);
					$date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
			}
			$data['ptxt'] = "(".$pbenifit."+".$dbenifit."+".$obenifit.")-".$get_expencetotal->totlexpence;
			$finalbenifit = ($pbenifit+$dbenifit+$obenifit)-$get_expencetotal->totlexpence;
			$get_oil_detail_price = $this->Daily_reports_model_new_jun->get_oil_detail_price_date($location_id,$edate);
			$get_oil_in_price = $this->Daily_reports_model_new_jun->get_oil_in_price($location_id,$sdate,$edate);
			$report_data = $this->Petty_cash_member_model->report_data($location_id,$sdate,$edate, $current_date, $member_id);
			//echo $this->db->last_query();
			$bank_cradittotal = 0;
			$bank_debittotal = 0;
			foreach ($report_data as $credit) {
				$bank_cradittotal = $credit['bank_cradit'] + $bank_cradittotal;
				$bank_debittotal = $credit['bank_debit'] + $bank_debittotal;
				
			}
			$data['f_bank_total'] = $bank_cradittotal - $bank_debittotal; 
			//print_r($get_oil_in_price); die();
            $oil_detail_price = array();
			$ostock = 0;
            foreach ($get_oil_detail_price as $d) {
				$ostock = $ostock + ($d->stock*$d->bay_price);
                // $oil_detail_price[$d->date]['bay_price'] = $d->total_bay_price;
                // $oil_detail_price[$d->date]['sel_price'] = $d->total_sel_price;
                // $oil_detail_price[$d->date]['separate_stock'] = $separate_stock  = $this->Daily_reports_model_new_jun->get_oil_detail_separate_price($location_id, $d->date);
                // $total_result = $this->Daily_reports_model_new_jun->get_oil_detail_separate_price_total($location_id, $d->date);
                // $oil_detail_price[$d->date]['total'] = $total_result[0]->total;
                // foreach ($separate_stock as $s){
                    // if($s->p_type == 'kg' || $s->p_type == 'ltr' ){
						// $toal =  $s->p_qty*$s->stock;
						// $stock_in_l = $stock_in_l+$toal;
				    // }else{
                       // $st =  ($s->p_qty*$s->stock)/1000;
                        // $stock_in_l = $stock_in_l+$st;
				    // }
                // }
				 // $oil_detail_price[$d->date]['total_stock_in_l'] = $stock_in_l;
                // $oil_detail_price[$d->date]['stock'] = $d->stock;
            }
			if($ostock == 0){
				$ostock = $temp[$edate]['o_quantity'];
			}
			$data['totalsalary'] =0; 
			foreach($salary as $salary_detail){  
				$data['totalsalary'] = $data['totalsalary']+$salary_detail->c_salary; 
			 }  
			 
			 
			 $salarytotal = 0;
        $bonas_amount = 0;
        $extra_amount = 0;
        $totaldebit = 0;
        $paid_loan_amount = 0;
        $advance = 0;
        $past_loan_amount = 0;
        foreach ($salary as $salary_detail) {
            if($salary_detail->salary != 0){
                $salary = $salary_detail->salary;
            }else{
                $salary = $salary_detail->salary;
            }
            if ($salary_detail->active == 1 ) {
                $salarytotal = $salarytotal + $salary;
            }
            if ($salary_detail->active == 1) {
                $bonas_amount = $bonas_amount + $salary_detail->bonas_amount;
            }
            if ($salary_detail->active == 1) {
                $extra_amount = $extra_amount + $salary_detail->extra_amount;
            }
            if ($salary_detail->active == 1) {
                $totaldebit = $totaldebit + $salary_detail->totaldebit;
            }
            if ($salary_detail->active == 1) {
                $paid_loan_amount = $paid_loan_amount + $salary_detail->paid_loan_amount;
            }
			if($salary_detail->active == 1){
				$advance = $advance + $salary_detail->advance;
			}
            $past_loan_amount = $past_loan_amount + $salary_detail->past_loan_amount;
		}
		$rmloan = $past_loan_amount + $advance - $paid_loan_amount;
		$totalloan = $past_loan_amount + $advance;
		$totalsalary = $salarytotal + $bonas_amount + $extra_amount - $paid_loan_amount;
		
		$data['workerloan'] = $rmloan;	 
		$data['totalsalary'] = $salarytotal;
		$total_company_credit = $this->Daily_reports_model_new_jun->total_company_credit($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));
		$total_company_debit = $this->Daily_reports_model_new_jun->total_company_debit($location_id,date('Y-m-d', strtotime($edate . ' + 1 days')));	
		
			 $data['ptotaldbuyvat'] = $ptotaldbuyvat;
			 $data['dtotaldbuyvat'] = $dtotaldbuyvat;
			 $data['dtotaldsellingvat'] = $dtotaldsellingvat;
			 $data['ptotaldsellingvat'] = $ptotaldsellingvat;
			 $data['iocbalnce'] = ($prv_ioc_total->totalamount+$prv_transection_total->totalamount+$total_company_credit->totalamount)-($prv_purchase_total->d_total_amount+$prv_purchase_total->p_total_amount+$total_company_debit->totalamount);
		}
		$cashdebit = $total_balance[0]->cashdebit;
		$creshcrdit = $total_balance[0]->creshcrdit;
		$checkcrdit = $total_balance[0]->checkcrdit;
		$checkdebit = $total_balance[0]->checkdebit;
		$netcrdit = $total_balance[0]->netcrdit;
		$netdebit = $total_balance[0]->netdebit;
		$totalcreadit = $checkcrdit + $netcrdit;
		$totalnetdebit = $netdebit + $checkdebit;

		$data['pattycash_balance'] = $creshcrdit - $cashdebit;
		$data['pattybank_balance'] = $totalcreadit - $totalnetdebit;
		$data['totalprofit'] = $finalbenifit;
		$data['dstock'] = $dstock;
		$data['pstock'] = $pstock;
		$data['ostock'] = $ostock;
		$data['edate'] = $edate;
		$data['sdate'] = $sdate;
		$data['oil_sgst'] = $oil_sgst;
		$data['oil_cgst'] = $oil_cgst;
		$data['sgst'] = round((($get_oil_in_price->price * 18) / 118));
		$this->load->view('web/profit_loss_report', $data);
	}

	function print_pdf_inventoryreport() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
        $this->load->model('Daily_reports_model_new_jun');
        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('admin_model');
        $data['location_list'] = $this->admin_model->select_location($id1);
        if ($this->input->get_post('sdate') == "") {
            $sdate = date('Y-m-d');
        } else {
            $sdate = date('Y-m-d', strtotime($this->input->get_post('sdate')));
        }
        if ($this->input->get_post('edate') == "") {
            $edate = date('Y-m-d');
        } else {
            $edate = date('Y-m-d', strtotime($this->input->get_post('edate')));
        }
        $location_id = $this->input->get_post('location');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['location'] = $location_id;
        if ($location_id != "") {
            $data['location_detail'] = $this->Daily_reports_model_new_jun->location_detail($location_id);
            $data['report'] = $this->Daily_reports_model_new_jun->get_inventory_list($location_id, $sdate, $edate);
        }
        $this->load->library('m_pdf');
        $html = $this->load->view('web/pdfinventoryreport', $data, true);
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


    function print_pdf() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
        $this->load->model('Daily_reports_model_new_jun');
        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('admin_model');
        $data['location_list'] = $this->admin_model->select_location($id1);
        if ($this->input->get_post('sdate') == "") {
            $sdate = date('Y-m-d');
        } else {
            $sdate = date('Y-m-d', strtotime($this->input->get_post('sdate')));
        }
        if ($this->input->get_post('edate') == "") {
            $edate = date('Y-m-d');
        } else {
            $edate = date('Y-m-d', strtotime($this->input->get_post('edate')));
        }
        $location_id = $this->input->get_post('location');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['location'] = $location_id;
        if ($location_id != "") {
			$data['location_detail'] = $this->Daily_reports_model_new_jun->location_detail($location_id);
            $sdate1 = date("Y-m-d", strtotime('-1 day', strtotime($sdate)));
            $report = $this->Daily_reports_model_new_jun->report($location_id, $sdate1, $edate);
			$vatList = $this->Daily_reports_model_new_jun->vatList($sdate1, $edate);
			$data['vatList'] = array();
			foreach($vatList as $Vat){
				$data['vatList'][$Vat->date] = $Vat->vat_per;
			}
			$savingList = $this->Daily_reports_model_new_jun->savingList($location_id,$sdate1, $edate);
			$data['savingList'] = array();
			foreach($savingList as $Vat){
				$data['savingList'][$Vat->date] = $Vat->total;
			}
            $data['report'] = array();
            foreach ($report as $d) {
                $p_data = $this->Daily_reports_model_new_jun->report_data($location_id, $d['date']);
			if (!empty($p_data)) {
                    $creshcrdittotal = $p_data[0]['creshcrdit'];
                    $d['petty_cash_credit_total'] = $creshcrdittotal;
                } else {
                    $d['petty_cash_credit_total'] = 0;
                }
                $data['report'][] = $d;
            }
            $newdate = date('Y-m-d', strtotime($edate . ' + 1 days'));
            $this->load->model('company_report_model');
            $this->load->model('bank_deposit_model');
            $bay_stock_details = $this->Daily_reports_model_new_jun->get_bay_stock_details($location_id, $sdate, $edate);
			$company_credit = $this->Daily_reports_model_new_jun->company_credit($location_id, $sdate, $edate);
			$company_debit = $this->Daily_reports_model_new_jun->company_debit($location_id, $sdate, $edate);
			$bank_expense = $this->Daily_reports_model_new_jun->bank_expense($location_id, $sdate, $edate);
			$onlinetransaction_cs = $this->Daily_reports_model_new_jun->onlinetransaction_cs($location_id, $sdate, $edate);
			$data['onlinetransaction_cs'] = array();
			foreach($onlinetransaction_cs as $onlinetransaction){
				$data['onlinetransaction_cs'][$onlinetransaction->date] = $onlinetransaction->totalamount;
			}
			$data['bank_expense'] = array();
			foreach($bank_expense as $companycredit){
				$data['bank_expense'][$companycredit->date] = $companycredit->totalamount;
			}
			$data['company_credit_debit'] = array();
			foreach($company_credit as $companycredit){
				$data['company_credit_debit']['c'][$companycredit->date] = $companycredit->totalamount;
			}
			foreach($company_debit as $companycredit){
				$data['company_credit_debit']['d'][$companycredit->date] = $companycredit->totalamount;
			}
			$bay_stock_array = array();
            foreach ($bay_stock_details as $oil){
            $bay_stock_array[$oil->date]['total_qty_ltr'] = $oil->total_qty_ltr;    
            $bay_stock_array[$oil->date]['total_qty']    = $oil->total_qty;
            }
            $data['bay_stock_array'] = $bay_stock_array;
            $total_balance = $this->Daily_reports_model_new_jun->total_balance($location_id, $sdate, $edate);
            $data['cashdebit'] = $cashdebit = $total_balance[0]->cashdebit;
            $data['creshcrdit'] = $creshcrdit = $total_balance[0]->creshcrdit;
            $cash_balance = $creshcrdit - $cashdebit;
            $data['personal_debite_credit'] = $cash_balance;
            $get_tank_readin = $this->Daily_reports_model_new_jun->get_tank_readin($location_id, $sdate, $edate);
            $get_oil_detail = $this->Daily_reports_model_new_jun->get_oil_detail($location_id, $sdate, $edate);

            $oil_final_array = array();
            foreach ($get_oil_detail as $oil_detail) {
                $oil_final_array[$oil_detail->date]['buy'] = $oil_final_array[$oil_detail->date]['buy'] + ($oil_detail->Reading * $oil_detail->buyprice);
                $oil_final_array[$oil_detail->date]['sell'] = $oil_final_array[$oil_detail->date]['sell'] + ($oil_detail->Reading * $oil_detail->salesprice);
            }
            $data['oil_final_array'] = $oil_final_array;
            $get_oil_detail_price = $this->Daily_reports_model_new_jun->get_oil_detail_price($location_id, $sdate, $edate);
            $online_bank_expance_dailyreport = $this->bank_deposit_model->online_bank_expance_dailyreport($location_id, $sdate, $edate);
			$data['online_bank_expance_array'] = array();
			foreach($online_bank_expance_dailyreport as $online_bank_expance_daily){
				$data['online_bank_expance_array'][$online_bank_expance_daily->date] = $online_bank_expance_daily->amount;
			}
            $oil_detail_price = array();
            foreach ($get_oil_detail_price as $d) {
                $stock_in_l = 0;
				$oil_detail_price[$d->date]['bay_price'] = $d->total_bay_price;
                $oil_detail_price[$d->date]['sel_price'] = $d->total_sel_price;
                $oil_detail_price[$d->date]['separate_stock'] = $separate_stock  = $this->Daily_reports_model_new_jun->get_oil_detail_separate_price($location_id, $d->date);
                $total_result = $this->Daily_reports_model_new_jun->get_oil_detail_separate_price_total($location_id, $d->date);
                $oil_detail_price[$d->date]['total'] = $total_result[0]->total;
                foreach ($separate_stock as $s){
                    if($s->p_type == 'kg' || $s->p_type == 'ltr' ){
						$toal =  $s->p_qty*$s->stock;
						$stock_in_l = $stock_in_l+$toal;
				    }else{
                       $st =  ($s->p_qty*$s->stock)/1000;
                        $stock_in_l = $stock_in_l+$st;
				    }
                }
				 $oil_detail_price[$d->date]['total_stock_in_l'] = $stock_in_l;
                $oil_detail_price[$d->date]['stock'] = $d->stock;
            }
            $data['oil_detail_price'] = $oil_detail_price;
            $finaltank = array();
            foreach ($get_tank_readin as $tank) {
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['name'] = $tank->tank_name;
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['deepreading'] = $tank->deepreading;
            }
            $data['finaltank'] = $finaltank;
            $data['location_tank_list'] = $this->Daily_reports_model_new_jun->select_all_with_order('id,tank_name,tank_type,fuel_type,start_to,end_to,mobile_show,web_show', 'sh_tank_list', array('location_id' => $location_id, "status" => '1'), array('tank_name', 'asc'));
			$location_tank_list = $data['location_tank_list'];
			$vishaltanklist = array();
			foreach($location_tank_list as $list){
				if($list->start_to == NULL && $list->end_to == NULL){
					$vishaltanklist[] = $list;
				}else{
					if($list->web_show == '0'){
					if(((strtotime($edate) >= strtotime($list->start_to)) && (strtotime($sdate) <= strtotime($list->start_to))) || (strtotime($sdate) <= strtotime($list->start_to)) ){
						$vishaltanklist[] = $list;
					}
					}else{
						$vishaltanklist[] = $list;
					}
				}
			}
			$data['location_tank_list'] = $vishaltanklist;			
        }
        $this->load->library('m_pdf');
        $html = $this->load->view('web/pdfdaily_report', $data, true);
        $pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "invoice.pdf";
        $lorem = utf8_encode($html); // render the view into HTML
        $pdf = $this->m_pdf->load();
        $pdf->AddPage('L', // L - landscape, P - portrait
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
	
	function print_pdf_copy() {
        $this->load->model('saving_member_model');
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('expense_model');
        $lid = $this->input->get_post('lid');
        $data['sdate'] = $sdate = $this->input->get_post('sdate');
        $edate = $this->input->get_post('edate');
        $data['edate'] = $edate = $this->input->get_post('edate');
        $data['sdate'] = $sdate = $this->input->get_post('sdate');
        $lid = $this->input->get_post('location');
        $member_id = $this->input->post('member_id');
        $current_date = date('Y-m-d');
//        print_r($member_id);
        $data['report_data'] = $this->saving_member_model->report_data($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
//        echo $this->db->last_query();
        $data['location_detail'] = $this->expense_model->location_detail($lid);
		$report_data = $this->saving_member_model->report_data($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
		//print_r($data['location_detail']); die();
        // echo $this->	db->last_query();
        // die();
//print_r($data['location_detail']);
        $this->load->library('m_pdf');
         $html = $this->load->view('web/pdfsaving_member_report', $data, true);

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

    function edit() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $location_id = $this->input->get_post('location');
        $sdate = $this->input->get_post('sdate');
        $edate = $this->input->get_post('edate');
        $date = $this->input->get_post('date');
        if ($location_id != "" && $date != "") {
            $data['location'] = $location_id;
            $data['date'] = $date;
            $data['edate'] = $edate;
            $data['sdate'] = $sdate;
            $this->load->database();
            $this->load->model('Daily_reports_model_new_jun');
            $data['Petrol_inventory'] = $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'fuel_type' => 'p', 'status != ' => '0'));
			$data['Petrol_inventory_user_detail'] = $this->Daily_reports_model_new_jun->get_one_data('shusermaster', array('id' => $data['Petrol_inventory']->user_id));
			$data['daily_price'] = $this->Daily_reports_model_new_jun->get_one_data('sh_dailyprice', array('user_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
            $data['diesel_inventory'] = $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'fuel_type' => 'd', 'status != ' => '0'));
			$data['diesel_inventory_user_detail'] = $this->Daily_reports_model_new_jun->get_one_data('shusermaster', array('id' => $data['diesel_inventory']->user_id));
            $data['oil_inventory'] = $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'fuel_type' => 'o', 'status != ' => '0'));
			$data['oil_inventory_user_detail'] = $this->Daily_reports_model_new_jun->get_one_data('shusermaster', array('id' => $data['oil_inventory']->user_id));
            $data['oil_inventory_Detail'] = $this->Daily_reports_model_new_jun->oil_inventory_Detail($location_id, date('Y-m-d', strtotime($date)));
//           if($_GET['gub'] == 1){
//                echo $this->db->last_query();
//            }
            $data['readingdetails'] = $this->Daily_reports_model_new_jun->get_one_data('shdailyreadingdetails', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
			//print_r($data['readingdetails']); die();
			$data['readingdetails_user_detail'] = $this->Daily_reports_model_new_jun->get_one_data('shusermaster', array('id' => $data['readingdetails']->UserId));
            $data['meter_details'] = $this->Daily_reports_model_new_jun->meter_details($location_id, date('Y-m-d', strtotime($date)));
            $data['get_oil_meter_details'] = $this->Daily_reports_model_new_jun->get_oil_meter_details($location_id, date('Y-m-d', strtotime($date)));
			//echo "<pre>"; print_r($data['get_oil_meter_details']); die();
//            
            $data['get_tank_reading_sales'] = $this->Daily_reports_model_new_jun->get_tank_reading_sales($data['readingdetails']->id);
            $this->load->view('web/daily_report_edit_new', $data);
        }
    }

    function last_day_entry() {
        $this->load->model('Daily_reports_model_new_jun');
        $data['location'] = $location_id = $this->input->get_post('location');
        $data['sdate'] = $sdate = $this->input->get_post('sdate');
        $data['edate'] = $edate = $this->input->get_post('edate');
        $data['lastday'] = $this->Daily_reports_model_new_jun->last_day_entry($location_id, $sdate, $edate);
       // echo $this->db->last_query();
        $this->form_validation->set_rules('credit', 'Credit', 'required');
        $this->form_validation->set_rules('debit', 'Debit', 'required');
        $this->form_validation->set_rules('budget', 'Budget', 'required');
        $this->form_validation->set_rules('cash_on_hand', 'cash_on_hand', 'required');
        if ($this->form_validation->run() == true) {
            $credit = $this->input->get_post('credit');
            $debit = $this->input->get_post('debit');
            $budget = $this->input->get_post('budget');
            $salary = $this->input->get_post('salary');
            $company_discount = $this->input->get_post('company_discount');
            $company_charge = $this->input->get_post('company_charge');
            $id = $this->input->get_post('id');
            $cash_on_hand = $this->input->get_post('cash_on_hand');
            $update_data = array("credit" => $credit,
                "debit" => $debit,
                "budget" => $budget,
                "ioc_amount" => $this->input->get_post('ioc'),
                "l_salary" => $this->input->get_post('salary'),
                "company_discount" => $this->input->get_post('company_discount'),
                "company_charge" => $this->input->get_post('company_charge'),
                "cash_on_hand" => $cash_on_hand);
            if($id != ""){
            $this->Daily_reports_model_new_jun->update_data('sh_last_day_entry', array("id" => $id), $update_data);
            }else{
                  $update_data = array("credit" => $credit,
                "debit" => $debit,
                "date" => $sdate,
                "location_id" => $location_id,
                "budget" => $budget,
                "ioc_amount" => $this->input->get_post('ioc'),
                "l_salary" => $this->input->get_post('salary'),
                "company_discount" => $this->input->get_post('company_discount'),
                "company_charge" => $this->input->get_post('company_charge'),
                "cash_on_hand" => $cash_on_hand);
                  $this->Daily_reports_model_new_jun->master_insert("sh_last_day_entry", $update_data);
            }
//            echo $this->db->last_query();
//            die();
            redirect('daily_reports_new/index?sdate=' . $sdate . '&edate=' . $edate . '&location=' . $location_id . '');
        }
        $this->load->view('web/last_day_entry', $data);
    }

    function update() {
        //die('Your Developer working for new futcher so please try again');
        $this->load->database();
        $this->load->model('Daily_reports_model_new_jun');
        $tank_wies_reading = $this->input->post('tank_deep_reading');
        $sid = $this->input->post('id');
         $date = $this->input->get_post('date'); 
        $sdate = date('d-m-Y', strtotime($this->input->get_post('sdate')));
        $edate = date('d-m-Y', strtotime($this->input->get_post('edate')));
        $location_id = $this->input->get_post('location');
        $total_p_selling = 0;
        $total_d_selling = 0;
        foreach ($tank_wies_reading as $key => $tankreading) {
            $getcuuurrentstok = $this->Daily_reports_model_new_jun->get_reading_tank($key, $tankreading);
            if ($getcuuurrentstok) {
                if ($getcuuurrentstok->fuel_type == 'p') {
                    $total_p_selling = $total_p_selling + $getcuuurrentstok->volume;
                    $this->Daily_reports_model_new_jun->update_data('sh_tank_wies_reading_sales', array('sales_id' => $sid, 'tank_id' => $key, 'status' => '1'), array('deepreading' => $getcuuurrentstok->volume, 'volume' => $getcuuurrentstok->reading, 'type' => 'p'));
                }
                if ($getcuuurrentstok->fuel_type == 'd') {
                    $total_d_selling = $total_d_selling + $getcuuurrentstok->volume;
                    $this->Daily_reports_model_new_jun->update_data('sh_tank_wies_reading_sales', array('sales_id' => $sid, 'tank_id' => $key, 'status' => '1'), array('deepreading' => $getcuuurrentstok->volume, 'volume' => $getcuuurrentstok->reading, 'type' => 'd'));
                }
            } else {

                $this->session->set_flashdata('fail', 'Deep reading not found.');
                redirect('daily_reports/edit?date=' . $date . '&location=' . $location_id);
            }
            $this->Daily_reports_model_new_jun->update_data('shdailyreadingdetails', array('id' => $sid), array('p_tank_reading' => $total_p_selling, 'd_tank_reading' => $total_d_selling));
        }
        $oilcgst = $this->input->post('oilcgst');
        $oilsgst = $this->input->post('oilsgst');
        $location_detail = $this->Daily_reports_model_new_jun->master_fun_get_tbl_val("sh_location", array("status" => 1, "l_id" => $location_id), array("id", "asc"));
        $this->load->model('service_model_6');
        $newdate = strtotime('-1 day', strtotime($date));
        $creent_seling = $this->Daily_reports_model_new_jun->get_one_data('shdailyreadingdetails', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
       $readinghistory = $this->Daily_reports_model_new_jun->master_fun_get_tbl_val("shreadinghistory", array("status" => 1, "RDRId" => $creent_seling->id), array("id", "asc"));
       echo "<pre>";
$testtrempdate = strtotime('2019-05-01');
       foreach ($this->input->post('oil_reading') as $key => $value){
		   
		   if ($testtrempdate >= strtotime($date) ){
           $readinghistory = $this->Daily_reports_model_new_jun->master_fun_get_tbl_val("shreadinghistory", array("status" => 1, "RDRId" => $creent_seling->id,"PumpId"=>$key), array("id", "asc"));
                  $new_qty = (float)$value-(float)$readinghistory[0]->Reading;
                  //print_r($new_qty);
           $oldstock = $this->Daily_reports_model_new_jun->master_fun_get_tbl_val("sh_oil_daily_price", array("date" => date('Y-m-d', strtotime($date)),"o_p_id"=>$key), array("id", "asc"));
     //  print_r($oldstock);
       $new_stock =  (float)$oldstock[0]->stock+(float)$new_qty;
       $this->Daily_reports_model_new_jun->update_data('sh_oil_daily_price', array("date" => date('Y-m-d', strtotime($date)),"o_p_id"=>$key), array('stock' => $new_stock));
           }
       }
       //die();
       
    // $this->oil_pumb_daily_price($date, $key, $value);
        $this->Daily_reports_model_new_jun->update_data('shreadinghistory', array('RDRId' => $creent_seling->id, 'status != ' => '0'), array('status' => '0'));
        
         
         $pqty = 0;
        $time = date("Y-m-d H:i:s");
        foreach ($this->input->get_post('petrol_reading') as $key => $value) {
            $predayreading = $this->Daily_reports_model_new_jun->get_one_data('shreadinghistory', array('Type' => 'p', 'PumpId' => $key, 'date' => date('Y-m-d', $newdate), 'status != ' => '0'));
            $get_reset_detail = $this->Daily_reports_model_new_jun->get_one_data('sh_reset_pump', array('pump_id' => $key, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
            if ($get_reset_detail) {
                $resetvalue = $get_reset_detail->reading - $predayreading->Reading;
                $qty = $resetvalue + $value;
            } else {
                $qty = $value - $predayreading->Reading;
            }
            $pqty = $pqty + $qty;
            $pdata = array('RDRId' => $creent_seling->id, 'PumpId' => $key, 'Type' => 'p', 'Reading' => $value, 'date' => date('Y-m-d', strtotime($date)), 'qty' => $qty, "created_at" => $time);
            $this->Daily_reports_model_new_jun->master_insert("shreadinghistory", $pdata);
        }
        $dqty = 0;
        foreach ($this->input->get_post('diesel_reading') as $key => $value) {
            $predayreading = $this->Daily_reports_model_new_jun->get_one_data('shreadinghistory', array('Type' => 'd', 'PumpId' => $key, 'date' => date('Y-m-d', $newdate), 'status != ' => '0'));
            $get_reset_detail = $this->Daily_reports_model_new_jun->get_one_data('sh_reset_pump', array('pump_id' => $key, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
            if ($get_reset_detail) {
                $resetvalue = $get_reset_detail->reading - $predayreading->Reading;
                $qty = $resetvalue + $value;
            } else {
                $qty = $value - $predayreading->Reading;
            }
            $dqty = $dqty + $qty;
            $pdata = array('RDRId' => $creent_seling->id, 'PumpId' => $key, 'Type' => 'd', 'Reading' => $value, 'date' => date('Y-m-d', strtotime($date)), 'qty' => $qty, "created_at" => $time);
            $this->Daily_reports_model_new_jun->master_insert("shreadinghistory", $pdata);
        }
        foreach ($this->input->get_post('oil_reading') as $key => $value) {
            $predayreading = $this->Daily_reports_model_new_jun->get_one_data('shpump', array('id' => $key));
            if ($predayreading->p_type == 'ml') {
                $qty = ($value * $predayreading->p_qty) / 1000;
            }
            if ($predayreading->p_type == 'ltr') {
                $qty = ($value * $predayreading->p_qty);
            }
            if ($predayreading->p_type == 'kg') {
                $qty = ($value * $predayreading->p_qty);
            }
            if ($predayreading->p_type == 'ml') {
                $qty = ($value * $predayreading->p_qty) / 1000;
            }

            $pdata = array('RDRId' => $creent_seling->id, 'PumpId' => $key, 'Type' => 'o', 'Reading' => $value, 'date' => date('Y-m-d', strtotime($date)), 'qty' => $qty, "created_at" => $time);
            $this->Daily_reports_model_new_jun->master_insert("shreadinghistory", $pdata);
//                                $oil_daily_price = $this->Daily_reports_model_new_jun->get_one_data('sh_oil_daily_price',array('o_p_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
//                                print_r($oil_daily_price->stock);
            //$this->Daily_reports_model_new_jun->update_data('sh_oil_daily_price',array('date'=>date('Y-m-d',strtotime($date)),'o_p_id'=>$key),array('stock'=>$value));
            // echo $this->db->last_query(); 
           
        }
        $this->Daily_reports_model_new_jun->update_data('sh_dailyprice', array('date' => date('Y-m-d', strtotime($date)), 'user_id' => $location_id, 'status' => '1'), array('pet_price' => $this->input->get_post('p_price_per_l'), 'dis_price' => $this->input->get_post('d_price_per_l')));
        $daily_price = $this->Daily_reports_model_new_jun->get_one_data('sh_dailyprice', array('user_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
        $data1 = array(
            "oil_reading" => $this->input->get_post('oil_sales'),
            "p_total_selling" => $pqty - $this->input->get_post('petrol_testing'),
            "d_total_selling" => $dqty - $this->input->get_post('Diesal_testing'),
            "p_sales_vat" => (($pqty - $this->input->get_post('petrol_testing')) * $daily_price->pet_price * 20) / 120,
            "d_sales_vat" => (($dqty - $this->input->get_post('Diesal_testing')) * $daily_price->dis_price * 20) / 120,
            "oil_pure_benefit" => (($this->input->get_post('oil_sales')) * 5) / 100,
            "p_testing" => $this->input->get_post('petrol_testing'),
            "d_testing" => $this->input->get_post('Diesal_testing'),
            "created_at" => date("Y-m-d"),
            "cash_on_hand" => $this->input->get_post('cash_on_hand')
        );
        $this->Daily_reports_model_new_jun->update_data('sh_dailyprice', array('date' => date('Y-m-d', strtotime($date)), 'user_id' => $location_id, 'status' => '1'), array('pet_price' => $this->input->get_post('p_price_per_l'), 'dis_price' => $this->input->get_post('d_price_per_l')));
        $this->Daily_reports_model_new_jun->update_data('shdailyreadingdetails', array('id' => $creent_seling->id), $data1);
        $Petrol_pre_inventory = $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', $newdate), 'fuel_type' => 'p', 'status != ' => '0'));
        $diesel_pre_inventory = $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', $newdate), 'fuel_type' => 'd', 'status != ' => '0'));
        $oil_pre_inventory = $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', $newdate), 'fuel_type' => 'o', 'status != ' => '0'));
        $pre_seling = $this->Daily_reports_model_new_jun->get_one_data('shdailyreadingdetails', array('location_id' => $location_id, 'date' => date('Y-m-d', $newdate), 'status != ' => '0'));
        if ($this->input->post('petrolpurchase') > 0) {
            $buyprice = ($this->input->post('petrolpurchaseamount') + $this->input->post('petrolpurchasevatamount') + $this->input->post('petrolpurchasecesstaxamount')) / $this->input->post('petrolpurchase');
        } else {
            $buyprice = $Petrol_pre_inventory->p_new_price;
        }
        $data = array(
            'user_id' => $Petrol_pre_inventory->user_id,
            'date' => date('Y-m-d', strtotime($date)),
            'location_id' => $Petrol_pre_inventory->location_id,
            'invoice_no' => $this->input->post('petrolinvoice'),
            'fuel_type' => 'p',
            'p_quantity' => $this->input->post('petrolpurchase'),
            'p_fuelamount' => $this->input->post('petrolpurchaseamount'),
            'pv_taxamount' => $this->input->post('petrolpurchasevatamount'),
            'prev_p_stock' => $Petrol_pre_inventory->p_stock,
            'prev_p_price' => $Petrol_pre_inventory->p_new_price,
            'p_ev' => $Petrol_pre_inventory->p_stock - $pre_seling->p_total_selling - $this->input->post('petrolstock') + $Petrol_pre_inventory->p_quantity,
            'p_cess_tax' => $this->input->post('petrolpurchasecesstaxamount'),
            'p_price' => $Petrol_pre_inventory->p_new_price,
            "p_new_price" => $buyprice,
            "p_total_amount" => $this->input->post('petrolpurchaseamount') + $this->input->post('petrolpurchasevatamount') + $this->input->post('petrolpurchasecesstaxamount'),
            'created_date' => date("Y-m-d H:i:s"),
        );
        $this->Daily_reports_model_new_jun->update_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'fuel_type' => 'p', 'status != ' => '0'), $data);
        if ($this->input->post('dieselpurchase') > 0) {
            $buyprice = ($this->input->post('dieselpurchaseamount') + $this->input->post('dieselpurchasevatamount') + $this->input->post('dieselpurchasecesstaxamount')) / $this->input->post('dieselpurchase');
        } else {
            $buyprice = $diesel_pre_inventory->d_new_price;
        }
        $ddata = array(
            'invoice_no' => $this->input->post('dieselinvoice'),
            'fuel_type' => 'd',
            'd_quantity' => $this->input->post('dieselpurchase'),
            'd_fuelamount' => $this->input->post('dieselpurchaseamount'),
            'dv_taxamount' => $this->input->post('dieselpurchasevatamount'),
            'prev_d_stock' => $diesel_pre_inventory->d_stock,
            'prev_d_price' => $diesel_pre_inventory->d_new_price,
            'd_ev' => $diesel_pre_inventory->d_stock - $pre_seling->d_total_selling - $this->input->post('dieselstock') + $diesel_pre_inventory->d_quantity,
            'd_cess_tax' => $this->input->post('dieselpurchasecesstaxamount'),
            'd_price' => $diesel_pre_inventory->d_new_price,
            "d_new_price" => $buyprice,
            "d_total_amount" => $this->input->post('dieselpurchaseamount') + $this->input->post('dieselpurchasevatamount') + $this->input->post('dieselpurchasecesstaxamount'),
            'created_date' => date("Y-m-d H:i:s"));
        $this->Daily_reports_model_new_jun->update_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'fuel_type' => 'd', 'status != ' => '0'), $ddata);
        $odata = array(
            'date' => date('Y-m-d', strtotime($date)),
            'invoice_no' => $this->input->post('oilinvoice'),
            'oil_sgst' => $this->input->post('oilsgst'),
            'oil_cgst' => $this->input->post('oilcgst'),
            'o_quantity' => '',
            'fuel_type' => 'o',
            'o_amount' => $this->input->post('oilamount'),
            'o_stock' => '',
            'oil_total_amount' => $this->input->post('oilamountstock'),
            'prev_o_stock' => '',
            "p_new_price" => '',
            "d_new_price" => $buyprice,
            "d_total_amount" => $this->input->post('petrolpurchaseamount') + $this->input->post('petrolpurchasevatamount') + $this->input->post('petrolpurchasecesstaxamount'),
            "p_total_amount" => '',
            'created_date' => date("Y-m-d H:i:s"));
        $getoilinventoryid = $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'fuel_type' => 'o', 'status != ' => '0'));
        $oildffrentstok = $getoilinventoryid->oil_total_amount - $this->input->post('oilamountstock');
        if ($oildffrentstok != 0) {
            $this->Daily_reports_model_new_jun->updatealloilstock($location_id, date('Y-m-d', strtotime($date)), $oildffrentstok);
        }
        $this->Daily_reports_model_new_jun->update_data('sh_inventory', array('id' => $getoilinventoryid->id, 'status != ' => '0'), $odata);
        $this->Daily_reports_model_new_jun->update_data('sh_oil_inventory', array('inv_id' => $getoilinventoryid->id, 'status != ' => '0'), array('status' => 0));
        $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'fuel_type' => 'o', 'status != ' => '0'), $odata);
        foreach ($this->input->post('oilinventory[]') as $key => $oillist) {
            $data1 = array(
                "inv_id" => $getoilinventoryid->id,
                "oil_id" => $key,
                "qty" => $oillist,
                "ltr" => '',
                "created_at" => date("Y-m-d H:i:s"));
            $this->Daily_reports_model_new_jun->master_insert("sh_oil_inventory", $data1);
        }
        $this->update_next($this->input->get_post('date'), $this->input->get_post('location'));
        //$this->set_stock($this->input->get_post('date'),$this->input->get_post('location'));
        $this->session->set_flashdata('success', 'Data Update Success fully.');
        redirect('daily_reports_new/index?sdate=' . $sdate . '&location=' . $location_id . '&edate=' . $edate);
    }

    function update_next($date, $location_id) {
        $this->load->database();
        $this->load->model('Daily_reports_model_new_jun');
        $next_newdate = date("Y-m-d", strtotime('1 day', strtotime($date)));
        $newdate = strtotime($date);
        $date = $date;
        $creent_seling = $this->Daily_reports_model_new_jun->get_one_data('shdailyreadingdetails', array('location_id' => $location_id, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
        $next_seling = $this->Daily_reports_model_new_jun->get_one_data('shdailyreadingdetails', array('location_id' => $location_id, 'date' => $next_newdate, 'status != ' => '0'));

        if ($next_seling) {
            $currentsellid = $creent_seling->id;
            $nextsellid = $next_seling->id;
            $pqty = 0;
            $currentpreading = $this->Daily_reports_model_new_jun->get_all('shreadinghistory', array('Type' => 'p', 'RDRId' => $currentsellid, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
            foreach ($currentpreading as $currentreading) {
                $predayreading = $this->Daily_reports_model_new_jun->get_one_data('shreadinghistory', array('Type' => 'p', 'PumpId' => $currentreading->PumpId, 'date' => $next_newdate, 'status != ' => '0'));
                $get_reset_detail = $this->Daily_reports_model_new_jun->get_one_data('sh_reset_pump', array('pump_id' => $currentreading->PumpId, 'date' => $next_newdate, 'status != ' => '0'));
                if ($get_reset_detail) {
                    $predayreading1 = $this->Daily_reports_model_new_jun->get_one_data('shreadinghistory', array('Type' => 'p', 'PumpId' => $currentreading->PumpId, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
                    $resetvalue = $get_reset_detail->reading - $predayreading1->Reading;
                    $qty = $resetvalue + $predayreading->Reading;
                } else {
                    $qty = $predayreading->Reading - $currentreading->Reading;
                }
                $pqty = $pqty + $qty;
                $this->Daily_reports_model_new_jun->update_data('shreadinghistory', array('id' => $predayreading->id), array("qty" => $qty));
            }
            $dqty = 0;
            $currentdreading = $this->Daily_reports_model_new_jun->get_all('shreadinghistory', array('Type' => 'd', 'RDRId' => $currentsellid, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
            foreach ($currentdreading as $currentreading) {
                $predayreading = $this->Daily_reports_model_new_jun->get_one_data('shreadinghistory', array('Type' => 'd', 'PumpId' => $currentreading->PumpId, 'date' => $next_newdate, 'status != ' => '0'));
                $get_reset_detail = $this->Daily_reports_model_new_jun->get_one_data('sh_reset_pump', array('pump_id' => $currentreading->PumpId, 'date' => $next_newdate, 'status != ' => '0'));
                if ($get_reset_detail) {
                    $predayreading1 = $this->Daily_reports_model_new_jun->get_one_data('shreadinghistory', array('Type' => 'd', 'PumpId' => $currentreading->PumpId, 'date' => date('Y-m-d', strtotime($date)), 'status != ' => '0'));
                    $resetvalue = $get_reset_detail->reading - $predayreading1->Reading;
                    $qty = $resetvalue + $predayreading->Reading;
                } else {
                    $qty = $predayreading->Reading - $currentreading->Reading;
                }
                $dqty = $dqty + $qty;
                //$daily_price = $this->Daily_reports_model_new_jun->get_one_data('sh_oil_daily_price',array('date'=>$date,""$currentreading->PumpId));
                $this->Daily_reports_model_new_jun->update_data('shreadinghistory', array('id' => $predayreading->id), array("qty" => $qty));
            }
            $daily_price = $this->Daily_reports_model_new_jun->get_one_data('sh_dailyprice', array('user_id' => $location_id, 'date' => $next_newdate, 'status != ' => '0'));
            $data1 = array(
                "p_total_selling" => $pqty - $next_seling->p_testing,
                "d_total_selling" => $dqty - $next_seling->d_testing,
                "p_sales_vat" => (($pqty - $next_seling->p_testing) * $daily_price->pet_price * 20) / 120,
                "d_sales_vat" => (($dqty - $next_seling->d_testing) * $daily_price->dis_price * 20) / 120,
                "created_at" => date("Y-m-d")
            );
            $this->Daily_reports_model_new_jun->update_data('shdailyreadingdetails', array('id' => $next_seling->id), $data1);
        }
    }

    public function oil_pumb_daily_price($date, $pump_id, $qty) {
        $list = $this->Daily_reports_model_new_jun->master_fun_get_tbl_val("shpump", array("status" => 1, "id" => $pump_id), array("id", "id"));
        //  print_r($list);
        // $history_data = array();
        
        foreach ($list as $l) {
            if ($l->packet_value == "") {
                $l->packet_value = 0;
            }
            if ($l->spacket_value == "") {
                $l->spacket_value = 0;
            }
            $list2 = $this->Daily_reports_model_new_jun->master_fun_get_tbl_val("sh_oil_daily_price", array("o_p_id" => $l->id, "date" => $date), array("id", "id"));
            echo "<pre>";
            echo $this->db->last_query();
            die();
            if (empty($list2)) {
                $data = array("date" => $date,
                    "o_p_id" => $l['id'],
                    "bay_price" => $l['packet_value'],
                    "sel_price" => $l['spacket_value'],
                    "stock" => $l['stock'],
                    "packet_type" => $l['p_type']);

                //print_r($data);
                $this->Service_model_13->master_insert("sh_oil_daily_price", $data);
            }  else {
//                $data = array("date" => $date,
//                    "o_p_id" => $l['id'],
//                    "bay_price" => $l['packet_value'],
//                    "sel_price" => $l['spacket_value'],
//                    "stock" => $l['stock'],
//                    "packet_type" => $l['p_type']);
                  $this->Daily_reports_model_new_jun->update_data('sh_oil_daily_price', array('id' => $list2->id), array("stock" => $qty));
            }
        }
    }

        function thumbnail() {
            $url = 'https://stackoverflow.com/';
            $client_id = 'urrjr7894784'; // your client ID
            $signature = 'kjhh35h4j5'; // the signature you entered @ girafa
            $concatenated = $signature . $url;
            $MD5_Hash = md5($concatenated);
            $signature = substr($MD5_Hash, 16, 16);
            $url = urlencode($url);
            $str = 'http://scst.srv.girafa.com/srv/i?i=';
            $str .= $client_id . '&r=' . $url . '&s=' . $signature;
            print_r($str);
        }

        function update_all() {
            $this->load->model('Daily_reports_model_new_jun');
            $lists = $this->Daily_reports_model_new_jun->get_all('shdailyreadingdetails', array('location_id' => '39', 'status != ' => '0'));
            $tanklists = $this->Daily_reports_model_new_jun->get_deep("15kl");
            echo "<pre>";
            foreach ($lists as $list) {
                foreach ($tanklists as $key => $tanklist) {
                    if ($tanklist->cm > $list->p_deep_reading) {
                        break;
                    }
                }
                $prvdeepdata = $tanklists[$key - 1];
                $dieselstock = $list->p_deep_reading;
                $pdetailstock = (explode(".", $dieselstock));
                if (isset($pdetailstock[1])) {
                    if ($pdetailstock[1][0] > 0) {
                        if ($pdetailstock[1][0] == '1' || $pdetailstock[1][0] == '6') {
                            $temp = 1;
                        }
                        if ($pdetailstock[1][0] == '2' || $pdetailstock[1][0] == '7') {
                            $temp = 2;
                        }
                        if ($pdetailstock[1][0] == '3' || $pdetailstock[1][0] == '8') {
                            $temp = 3;
                        }
                        if ($pdetailstock[1][0] == '4' || $pdetailstock[1][0] == '9') {
                            $temp = 4;
                        }
                        $dstocqty = $prvdeepdata->Ltrs + ( $tanklist->extra_col * $temp );
                    } else {
                        $dstocqty = $prvdeepdata->Ltrs;
                    }
                } else {
                    $dstocqty = $dstocqty->Ltrs;
                }
                //echo $list->id." ".$dstocqty."<br>";
                $this->Daily_reports_model_new_jun->update_data('shdailyreadingdetails', array('id' => $list->id), array("p_tank_reading" => $dstocqty));
                echo $this->db->last_query();
                echo "<br>";
            }
            foreach ($lists as $list) {
                foreach ($tanklists as $key => $tanklist) {
                    if ($tanklist->cm > $list->d_deep_reading) {
                        break;
                    }
                }
                $prvdeepdata = $tanklists[$key - 1];
                $dieselstock = $list->d_deep_reading;
                $pdetailstock = (explode(".", $dieselstock));
                if (isset($pdetailstock[1])) {
                    if ($pdetailstock[1][0] > 0) {
                        if ($pdetailstock[1][0] == '1' || $pdetailstock[1][0] == '6') {
                            $temp = 1;
                        }
                        if ($pdetailstock[1][0] == '2' || $pdetailstock[1][0] == '7') {
                            $temp = 2;
                        }
                        if ($pdetailstock[1][0] == '3' || $pdetailstock[1][0] == '8') {
                            $temp = 3;
                        }
                        if ($pdetailstock[1][0] == '4' || $pdetailstock[1][0] == '9') {
                            $temp = 4;
                        }
                        $dstocqty = $prvdeepdata->Ltrs + ( $tanklist->extra_col * $temp );
                    } else {
                        $dstocqty = $prvdeepdata->Ltrs;
                    }
                } else {
                    $dstocqty = $dstocqty->Ltrs;
                }
                //echo $list->id." ".$dstocqty."<br>";
                $this->Daily_reports_model_new_jun->update_data('shdailyreadingdetails', array('id' => $list->id), array("d_tank_reading" => $dstocqty));
                echo $this->db->last_query();
                echo "<br>";
            }
        }

        function setoilstock() {
            $this->load->model('Daily_reports_model_new_jun');
            $list = $this->Daily_reports_model_new_jun->get_all_oil_stok();
            echo $this->db->last_query();
            echo "<pre>";
            $ostock = 163873.7;
            foreach ($list as $oil) {
                echo $oil->id;
                echo "<br>";

                $this->Daily_reports_model_new_jun->update_data('sh_inventory', array('id' => $oil->id), array("oil_total_amount" => $ostock));
                echo $ostock = $ostock - $oil->sel;
                echo "<br>";
            }
        }

        function set_stock($date, $lid) {
            $date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
            //$date = $date;
            $date2 = '2018-12-01';
            if (strtotime($date) < strtotime($date2)) {
                return 1;
            } else {
                $this->load->model('Daily_reports_model_new_jun');
                $list = $this->Daily_reports_model_new_jun->get_all_order('shdailyreadingdetails', array('status' => '1', 'location_id' => $lid, 'date >=' => $date), array('date', 'asc'));
                $p_original_stock = $list[0]->p_opening_original_stock;
                $d_original_stock = $list[0]->d_opening_original_stock;
                $cnt = 0;
                foreach ($list as $detail) {
                    //echo "<br><br>";
                    //echo $detail->date."<br>";
                    //echo $p_original_stock."<br>";
                    //echo $d_original_stock."<br>";

                    if ($cnt != 0) {
                        $this->Daily_reports_model_new_jun->update_data('shdailyreadingdetails', array('id' => $detail->id), array("p_opening_original_stock" => $p_original_stock));
                        $this->Daily_reports_model_new_jun->update_data('shdailyreadingdetails', array('id' => $detail->id), array("d_opening_original_stock" => $d_original_stock));
                    }
                    $Petrol_inventory = $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $lid, 'date' => $detail->date, 'fuel_type' => 'p', 'status != ' => '0'));

                    $Dieasl_inventory = $this->Daily_reports_model_new_jun->get_one_data('sh_inventory', array('location_id' => $lid, 'date' => $detail->date, 'fuel_type' => 'd', 'status != ' => '0'));
                    //echo $p_original_stock ."+". $Petrol_inventory->p_quantity ."-". $detail->p_total_selling."-".$pshort."<br>";
                    //echo $d_original_stock ."+". $Dieasl_inventory->d_quantity ."-". $detail->d_total_selling."-".$dshort."<br>"; 
                    $pshort = round(($detail->p_total_selling * 0.75) / 100, 2);
                    $dshort = round(($detail->d_total_selling * 0.20) / 100, 2);
                    $p_original_stock = $p_original_stock + $Petrol_inventory->p_quantity - $detail->p_total_selling - $pshort;
                    $d_original_stock = $d_original_stock + $Dieasl_inventory->d_quantity - $detail->d_total_selling - $dshort;

                    //echo $p_original_stock."<br>";
                    //echo $d_original_stock."<br>";
                    $this->Daily_reports_model_new_jun->update_data('shdailyreadingdetails', array('id' => $detail->id), array("p_closing_original_stock" => $p_original_stock, "d_closing_original_stock" => $d_original_stock, 'dshort' => $dshort, 'pshort' => $pshort));
                    //echo $this->db->last_query()."<br>";
                    $cnt++;
                }
            }
        }
		
	function setoilstockparday($lid,$date){
		$this->load->model('Daily_reports_model_new_jun');
		$cdate = date('Y-m-d');
		$oilstokofdate = $this->Daily_reports_model_new_jun->oilstokofdate($lid,$date);
		$final = array();
		foreach($oilstokofdate as $oilstok){
			$final[$oilstok->o_p_id] = $oilstok->stock;
		}
		echo '';
		echo "<table><tr>";
		for($i=0;strtotime($cdate) >= strtotime($date);$i++ ){
			//echo $date."<br><br>";
			echo "<td><table>";
			//echo date('d-m-Y',strtotime($date));
			$oilsellingofdate = $this->Daily_reports_model_new_jun->oilsellingofdate($lid,$date);
			//echo $this->db->last_query();
			$tepdate = $date;
			$date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
			foreach($oilsellingofdate as $seelinofdate){
				//
				$checkstockenrty = $this->Daily_reports_model_new_jun->get_one_data('sh_oil_daily_price', array('o_p_id' => $seelinofdate->PumpId, 'date' => $date, 'status != ' => '0'));
				
				//
				if($checkstockenrty){
					echo "<tr><td nowrap>".$tepdate."</td><td nowrap>".$seelinofdate->PumpId."  ".$seelinofdate->name."</td nowrap><td>".$final[$seelinofdate->PumpId]."</td>";
					//print_r($checkstockenrty);
					//$checkoil_inventory = $this->Daily_reports_model_new_jun->get_one_data('sh_oil_inventory', array('oil_id' => $seelinofdate->PumpId, 'DATE_FORMAT(sh_oil_inventory.created_at, "%Y-%m-%d") = ' => $tepdate, 'status != ' => '0'));
					//echo $this->db->last_query();
					//print_r($checkoil_inventory);
					//echo "<br>".$final[$seelinofdate->PumpId]."+".$checkoil_inventory->qty."-".$seelinofdate->Reading."<br>";
					echo "<td>".$seelinofdate->Reading."</td><td>".$checkoil_inventory->qty."</td>";
					$thisdatestoxk = ($final[$seelinofdate->PumpId]+0) - $seelinofdate->Reading;
					echo "<td>".$thisdatestoxk."<td></tr>";
					//die(); 
					$final[$seelinofdate->PumpId] = $thisdatestoxk;
					$this->Daily_reports_model_new_jun->update_data('sh_oil_daily_price', array('id' => $checkstockenrty->id), array("stock" => $thisdatestoxk,'o_p_id'=>$seelinofdate->PumpId));
					
				}else{
					echo "<tr><td nowrap>".$tepdate."</td><td nowrap>".$seelinofdate->PumpId."</td><td nowrap>".$final[$seelinofdate->PumpId]."</td><td></td><td></td><td></td></tr>";
				}
			}
			
			echo "</table></td>";
		}
		echo '</tr></table>';
	}
	public function setbuysel(){
		$this->load->model('Daily_reports_model_new_jun');
		$oilsellingofdate = $this->Daily_reports_model_new_jun->setbuysel();
		echo "<pre>";
		foreach($oilsellingofdate as $sellingofdate){
			print_r($sellingofdate);
			$this->Daily_reports_model_new_jun->update_data('shpump', array('id' => $sellingofdate->o_p_id), array("packet_value" => $sellingofdate->sel_price,'spacket_value'=>$sellingofdate->bay_price));
			echo $this->db->last_query();
			
		}
	}
	
	public function setoldoilstock($location_id,$fromdate,$todate){
		//echo "here"; die();
		$this->load->model('Daily_reports_model_new_jun');
		 
		$list = $this->Daily_reports_model_new_jun->get_all_order('shpump', array('status' => '1', 'location_id' => $location_id, 'type' => 'o'), array('id', 'asc'));
		$date = $fromdate;
		$oilprice = $this->Daily_reports_model_new_jun->get_all_order('sh_oil_daily_price', array('status' => '1', 'location_id' => $location_id,'date'=>'2019-04-01'), array('id', 'asc'));
		
		
		echo "<pre>";
		$alloilprice = array();
		foreach($oilprice as $oilp){
			$alloilprice[$oilp->o_p_id]['sell'] = $oilp->sel_price;
			$alloilprice[$oilp->o_p_id]['buy'] = $oilp->bay_price;
		}
		//print_r($alloilprice);
		//die();
		for($i=0;strtotime($todate) > strtotime($date);$i++)
		{
			foreach($list as $oil){
				$checkstockenrty = $this->Daily_reports_model_new_jun->get_one_data('sh_oil_daily_price', array('o_p_id' => $oil->id, 'date' => $date, 'status != ' => '0'));
				if($checkstockenrty){
					print_r($checkstockenrty);
					$insdata = array("o_p_id"=>$oil->id,
					"bay_price"=>$alloilprice[$oil->id]['buy'],
					"sel_price"=>$alloilprice[$oil->id]['sell'],
					"stock"=>'0',
					"packet_type"=>$oil->p_type,
					"location_id"=>$location_id,
					"date"=>$date);
					$this->Daily_reports_model_new_jun->update_data('sh_oil_daily_price', array("id" => $checkstockenrty->id), $insdata);
					
					
					
				}else{
					
					$insdata = array("o_p_id"=>$oil->id,
					"bay_price"=>$alloilprice[$oil->id]['buy'],
					"sel_price"=>$alloilprice[$oil->id]['sell'],
					"stock"=>'0',
					"packet_type"=>$oil->p_type,
					"location_id"=>$location_id,
					"date"=>$date);
					$this->Daily_reports_model_new_jun->master_insert("sh_oil_daily_price",$insdata);
				}
			}
			echo date('Y-m-d',strtotime($date));
			echo "<br>";
			$date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
		}
		
		//
	}
	
	
    }

?>