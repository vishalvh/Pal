<?php
class Daily_reports extends CI_Controller{
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
	function index(){
		if(!$this->session->userdata('logged_company')){
			redirect('company_login');
		}
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->database();
		$this->load->model('daily_reports_model');
		if(!$this->session->userdata('logged_company')){
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
		if($this->input->get_post('sdate') == ""){
				$sdate = date('Y-m-d');
		}else{
				$sdate = date('Y-m-d',strtotime($this->input->get_post('sdate')));
		}
		if($this->input->get_post('edate') == ""){
			$edate = date('Y-m-d');
		}else{
			$edate = date('Y-m-d',strtotime($this->input->get_post('edate')));
		}
		$location_id = $this->input->get_post('location');
		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['location'] = $location_id;
					
		if($location_id != ""){
			$sdate1 = date("Y-m-d",strtotime('-1 day',strtotime($sdate)));
			$report = $this->daily_reports_model->report($location_id,$sdate1,$edate);
			if($_GET['dub'] == 1){
			echo "<pre>";
                            echo $this->db->last_query();
			echo "<br>";
die();			
			}
			//if($this->input->get_post('id') == "1"){
			$data['report'] = array();
			foreach($report as $d){
			$p_data = 	$this->daily_reports_model->report_data($location_id,$d['date']);

			//
			if(!empty($p_data)){
				
			//	print_r($p_data);
			$creshcrdittotal = $p_data[0]['creshcrdit'];
			$d['petty_cash_credit_total'] = $creshcrdittotal;
			}else{
				$d['petty_cash_credit_total'] = 0;
			}
			
			$data['report'][] = $d;
		}
		
			
	//}
			
			
			
			$data['salary'] = $this->daily_reports_model->worker_salary_remening($location_id,$sdate,$edate);
			$data['loansalary'] = $this->daily_reports_model->worker_salary_loan($location_id,$edate);
            $data['salary'] = $this->daily_reports_model->worker_salary_remening($location_id,$sdate,$edate);
			$data['lastday'] = $this->daily_reports_model->last_day_entry($location_id,$sdate,$edate);
			$data['monthly_expence'] = $this->daily_reports_model->monthly_expence($location_id,$sdate,$edate);
			$data['ioc_balence'] = $this->daily_reports_model->ioc_balence($location_id,$sdate,$edate);
			$data['ioc_balence'] = $this->daily_reports_model->ioc_balence($location_id,$sdate,$edate);
			$data['deposit_amount'] = $this->daily_reports_model->deposit_amount($location_id,$sdate,$edate);
			$data['prev_extra_depost'] = $this->daily_reports_model->prev_extra_depost($location_id,$sdate);
			$data['onlinetransaction'] = $this->daily_reports_model->onlinetransaction($location_id,$sdate,$edate);
			$data['get_customer_credit'] = $this->daily_reports_model->get_customer_credit($location_id,$sdate,$edate);
			$data['get_credit'] = $this->daily_reports_model->get_credit($location_id,$edate);
			$data['get_debit'] = $this->daily_reports_model->get_debit($location_id,$edate);
			$data['get_customer_debit'] = $this->daily_reports_model->get_customer_debit($location_id,$sdate,$edate);
			$newdate = date('Y-m-d', strtotime($edate. ' + 1 days'));
			$this->load->model('company_report_model');
			$this->load->model('bank_deposit_model');
			$data['pre_onlinetransaction'] = $this->daily_reports_model->pre_onlinetransaction($location_id,$newdate);
			$data['pre_deposit_amount'] = $this->daily_reports_model->pre_deposit_amount($location_id,$newdate);
			$data['prev_card_depost'] = $this->daily_reports_model->prev_card_depost($location_id,$newdate);
			$data['pre_onlinetransaction'] = $this->daily_reports_model->pre_onlinetransaction($location_id,$newdate);
			$data['pre_cheq_deposit_amount'] = $this->bank_deposit_model->pre_cheq_deposit_amount($location_id,$newdate);
			$data['pre_deposit_wallet_amount'] = $this->daily_reports_model->pre_deposit_wallet_amount($location_id,$newdate);
			$data['prv_ioc_total'] = $this->company_report_model->get_pre_ioc_total($location_id,$newdate);
			$data['prv_transection_total'] = $this->company_report_model->get_pre_transection_total($location_id,$newdate);
			$data['prv_purchase_total'] = $this->company_report_model->get_pre_purchase_total($location_id,$newdate);
			
			$data['petty_cash_deposit_list'] = $this->daily_reports_model->prev_petty_cash_deposit($location_id,$newdate);
			$data['prev_petty_cash_withdrawal'] = $this->daily_reports_model->prev_petty_cash_withdrawal($location_id,$newdate);
			
			$data['petty_cash_deposit_list_cash'] = $this->daily_reports_model->prev_petty_cash_deposit_cash($location_id,$newdate);

			$data['prev_petty_cash_withdrawal_cash'] = $this->daily_reports_model->prev_petty_cash_withdrawal_cash($location_id,$newdate);
			$total_balance = $this->daily_reports_model->total_balance($location_id, $sdate, $edate);
                         $cashdebit =  $total_balance[0]->cashdebit;
                        $creshcrdit =  $total_balance[0]->creshcrdit;
                        $cash_balance = $creshcrdit - $cashdebit;
                        $data['personal_debite_credit'] = $cash_balance;
			$get_tank_readin = $this->daily_reports_model->get_tank_readin($location_id,$sdate,$edate); 
			$get_oil_detail = $this->daily_reports_model->get_oil_detail($location_id,$sdate,$edate); 
			$oil_final_array = array();
			foreach($get_oil_detail as $oil_detail){
				$oil_final_array[$oil_detail->date]['buy'] = $oil_final_array[$oil_detail->date]['buy']+($oil_detail->Reading*$oil_detail->buyprice);
				$oil_final_array[$oil_detail->date]['sell'] = $oil_final_array[$oil_detail->date]['sell']+($oil_detail->Reading*$oil_detail->salesprice);
			}
			$data['oil_final_array'] = $oil_final_array;
			if($_GET['dub'] == 1){
				$get_oil_detail_price = $this->daily_reports_model->get_oil_detail_price($location_id,$sdate,$edate);
			//echo $this->db->last_query();
			//echo "<pre>";
			$oil_detail_price = array();
			foreach($get_oil_detail_price as $d){
				$oil_detail_price[$d->date]['bay_price'] = $d->bay_price;
				$oil_detail_price[$d->date]['sel_price'] = $d->sel_price;
				
				if($d->packet_type == "ml"){
					$s = $d->stock;
					$f_s = $s*100;
					$oil_detail_price[$d->date]['stock'] = $f_s;
				}else{
					$oil_detail_price[$d->date]['stock'] = $d->stock;
				}
			}
			//print_r($oil_detail_price);
			//$data['oil_detail_price'] = $oil_detail_price;
		//	die();			
			}
			$finaltank =array();
			foreach($get_tank_readin as $tank){
				$finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['name'] = $tank->tank_name;
				$finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['deepreading'] = $tank->deepreading;
			}
			$data['finaltank'] = $finaltank;
			$data['location_tank_list'] = $this->daily_reports_model->select_all_with_order('id,tank_name,tank_type,fuel_type', 'sh_tank_list', array('location_id'=>$location_id,"status"=>'1'), array('tank_name','asc'));
		}
		$this->load->view('web/daily_report',$data);
	}
	function print_pdf(){
		$data["logged_company"] = $_SESSION['logged_company'];
		$this->load->database();
		$this->load->model('daily_reports_model');
		$this->load->model('daily_reports_model_new');
		$id1 =  $_SESSION['logged_company']['id'];
		$this->load->model('admin_model');
		$data['location_list'] = $this->admin_model->select_location($id1);
		if($this->input->get_post('sdate') == ""){
			$sdate = date('Y-m-d');
		}else{
			$sdate = date('Y-m-d',strtotime($this->input->get_post('sdate')));
		}
		if($this->input->get_post('edate') == ""){
			$edate = date('Y-m-d');
		}else{
			$edate = date('Y-m-d',strtotime($this->input->get_post('edate')));
		}
		$location_id = $this->input->get_post('location');
		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['location'] = $location_id;
		if($location_id != ""){
			$sdate1 = date("Y-m-d",strtotime('-1 day',strtotime($sdate)));
			$data['location_detail'] = $this->daily_reports_model->location_detail($location_id);
			$data['report'] = $this->daily_reports_model->report($location_id,$sdate1,$edate);
			$vatList = $this->Daily_reports_model_new_jun->vatList($sdate1, $edate);
			$data['vatList'] = array();
			foreach($vatList as $Vat){
				$data['vatList'][$Vat->date] = $Vat->vat_per;
			}
			print_r($vatList); die();
			$data['salary'] = $this->daily_reports_model->worker_salary_remening($location_id,$sdate,$edate);
			$data['loansalary'] = $this->daily_reports_model->worker_salary_loan($location_id,$edate);
			$data['lastday'] = $this->daily_reports_model->last_day_entry($location_id,$sdate,$edate);
			$data['monthly_expence'] = $this->daily_reports_model->monthly_expence($location_id,$sdate,$edate);
			$data['ioc_balence'] = $this->daily_reports_model->ioc_balence($location_id,$sdate,$edate);
			$data['deposit_amount'] = $this->daily_reports_model->deposit_amount($location_id,$sdate,$edate);
			$data['onlinetransaction'] = $this->daily_reports_model->onlinetransaction($location_id,$sdate,$edate);
			$data['get_customer_credit'] = $this->daily_reports_model->get_customer_credit($location_id,$sdate,$edate);
			$data['get_customer_debit'] = $this->daily_reports_model->get_customer_debit($location_id,$sdate,$edate);
			$data['pre_deposit_amount'] = $this->daily_reports_model->pre_deposit_amount($location_id,$sdate);
			$data['get_credit'] = $this->daily_reports_model->get_credit($location_id,$edate);
			$data['get_debit'] = $this->daily_reports_model->get_debit($location_id,$edate);
			$data['prev_card_depost'] = $this->daily_reports_model->prev_card_depost($location_id,$sdate);
			$data['pre_onlinetransaction'] = $this->daily_reports_model->pre_onlinetransaction($location_id,$sdate);
			$newdate = date('Y-m-d', strtotime('+1 day', strtotime($edate)));
			$this->load->model('company_report_model');
			$data['prv_ioc_total'] = $this->company_report_model->get_pre_ioc_total($location_id,$edate);
			$data['prv_transection_total'] = $this->company_report_model->get_pre_transection_total($location_id,$edate);
			$data['prv_purchase_total'] = $this->company_report_model->get_pre_purchase_total($location_id,$edate);
			}
			$this->load->library('m_pdf');
		 	$html = $this->load->view('web/pdfdaily_report', $data, true); 
			$pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "invoice.pdf";
			$lorem = utf8_encode($html); // render the view into HTML
            $pdf = $this->m_pdf->load();
            $pdf->AddPage('l', // L - landscape, P - portrait
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
		function edit(){
			if(!$this->session->userdata('logged_company')){
            	redirect('company_login');
      		}
        	$data["logged_company"] = $_SESSION['logged_company'];
			$location_id = $this->input->get_post('location');
			$sdate = $this->input->get_post('sdate');
			$edate = $this->input->get_post('edate');
			$date = $this->input->get_post('date');
			if($location_id != "" && $date != ""){
				$data['location'] = $location_id;
				$data['date'] = $date;
				$data['edate'] = $edate;
				$data['sdate'] = $sdate;
				$this->load->database();
				$this->load->model('daily_reports_model');
				$data['Petrol_inventory'] = $this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'fuel_type'=>'p','status != '=>'0'));
				$data['daily_price'] = $this->daily_reports_model->get_one_data('sh_dailyprice',array('user_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
				$data['diesel_inventory'] = $this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'fuel_type'=>'d','status != '=>'0'));
				$data['oil_inventory'] = $this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'fuel_type'=>'o','status != '=>'0'));
				$data['oil_inventory_Detail'] = $this->daily_reports_model->oil_inventory_Detail($location_id,date('Y-m-d',strtotime($date)));
				$data['readingdetails'] = $this->daily_reports_model->get_one_data('shdailyreadingdetails',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
				$data['meter_details'] = $this->daily_reports_model->meter_details($location_id,date('Y-m-d',strtotime($date)));
				$data['get_tank_reading_sales'] = $this->daily_reports_model->get_tank_reading_sales($data['readingdetails']->id);
				$this->load->view('web/daily_report_edit',$data);
			}
		}
		function last_day_entry(){
			$this->load->model('daily_reports_model');
			$data['location'] = $location_id = $this->input->get_post('location');
			$data['sdate'] = $sdate = $this->input->get_post('sdate');
			$data['edate'] = $edate = $this->input->get_post('edate');
			$data['lastday'] = $this->daily_reports_model->last_day_entry($location_id,$sdate,$edate);
			$this->form_validation->set_rules('credit', 'Credit' ,'required');
			$this->form_validation->set_rules('debit','Debit','required');
			$this->form_validation->set_rules('budget', 'Budget', 'required');
			$this->form_validation->set_rules('cash_on_hand', 'cash_on_hand', 'required');
			if($this->form_validation->run() == true){
				$credit = $this->input->get_post('credit');
				$debit = $this->input->get_post('debit');
				$budget = $this->input->get_post('budget');
				$id = $this->input->get_post('id');
				$cash_on_hand  = $this->input->get_post('cash_on_hand');
				$update_data = array( "credit" => $credit,
				"debit" => $debit,
				"budget" => $budget,
				"ioc_amount" => $this->input->get_post('ioc'),
				"cash_on_hand" => $cash_on_hand);
				$this->daily_reports_model->update_data('sh_last_day_entry',array("id"=> $id),$update_data);
				redirect('daily_reports/index?sdate='.$sdate.'&edate='.$edate.'&location='.$location_id.'');
			}
			 $this->load->view('web/last_day_entry',$data);
		}
		function update(){
			//die('Your Developer working for new futcher so please try again');
			$this->load->database();
			$this->load->model('daily_reports_model');
			$tank_wies_reading = $this->input->post('tank_deep_reading');
			$sid = $this->input->post('id');
			$date = $this->input->get_post('date');
	
			$sdate = date('d-m-Y',strtotime($this->input->get_post('sdate')));
			$edate = date('d-m-Y',strtotime($this->input->get_post('edate')));
			$location_id = $this->input->get_post('location');
			$total_p_selling = 0;
			$total_d_selling = 0;
			foreach($tank_wies_reading as $key => $tankreading){
				$getcuuurrentstok = $this->daily_reports_model->get_reading_tank($key,$tankreading);
				if($getcuuurrentstok){
					if($getcuuurrentstok->fuel_type == 'p'){
						$total_p_selling = $total_p_selling + $getcuuurrentstok->volume;
						$this->daily_reports_model->update_data('sh_tank_wies_reading_sales',array('sales_id'=>$sid,'tank_id'=>$key,'status'=>'1'),array('deepreading'=>$getcuuurrentstok->volume,'volume'=>$getcuuurrentstok->reading,'type'=>'p'));
					}
					if($getcuuurrentstok->fuel_type == 'd'){
						$total_d_selling = $total_d_selling + $getcuuurrentstok->volume;
						$this->daily_reports_model->update_data('sh_tank_wies_reading_sales',array('sales_id'=>$sid,'tank_id'=>$key,'status'=>'1'),array('deepreading'=>$getcuuurrentstok->volume,'volume'=>$getcuuurrentstok->reading,'type'=>'d'));
					}
				}else{
					
					$this->session->set_flashdata('fail','Deep reading not found.');
					redirect('daily_reports/edit?date='.$date.'&location='.$location_id);
				}
				$this->daily_reports_model->update_data('shdailyreadingdetails',array('id'=>$sid),array('p_tank_reading'=>$total_p_selling,'d_tank_reading'=>$total_d_selling));
			}
			$oilcgst = $this->input->post('oilcgst');
			$oilsgst = $this->input->post('oilsgst');
			$location_detail = $this->daily_reports_model->master_fun_get_tbl_val("sh_location", array("status" => 1,"l_id"=>$location_id), array("id", "asc"));
			$this->load->model('service_model_6');
			$newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
			$creent_seling = $this->daily_reports_model->get_one_data('shdailyreadingdetails',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
			$this->daily_reports_model->update_data('shreadinghistory',array('RDRId'=>$creent_seling->id,'status != '=>'0'),array('status'=>'0'));
			$pqty = 0;
			$time=date("Y-m-d H:i:s");
			foreach($this->input->get_post('petrol_reading') as $key=>$value){
				$predayreading = $this->daily_reports_model->get_one_data('shreadinghistory',array('Type'=>'p','PumpId'=>$key,'date'=>date('Y-m-d',$newdate),'status != '=>'0'));
				$get_reset_detail = $this->daily_reports_model->get_one_data('sh_reset_pump',array('pump_id'=>$key,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
				if($get_reset_detail){
					$resetvalue = $get_reset_detail->reading-$predayreading->Reading;
					$qty = $resetvalue+$value;
				}else{
					$qty = $value-$predayreading->Reading;
				}
				$pqty = $pqty + $qty;
				$pdata = array('RDRId'=>$creent_seling->id,'PumpId'=>$key,'Type'=>'p','Reading'=>$value,'date'=>date('Y-m-d',strtotime($date)),'qty'=>$qty,"created_at"=>$time);				
				$this->daily_reports_model->master_insert("shreadinghistory",$pdata);
				
			}
			$dqty = 0;
			foreach($this->input->get_post('diesel_reading') as $key=>$value){
				$predayreading = $this->daily_reports_model->get_one_data('shreadinghistory',array('Type'=>'d','PumpId'=>$key,'date'=>date('Y-m-d',$newdate),'status != '=>'0'));
				$get_reset_detail = $this->daily_reports_model->get_one_data('sh_reset_pump',array('pump_id'=>$key,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
				if($get_reset_detail){
					$resetvalue = $get_reset_detail->reading-$predayreading->Reading;
					$qty = $resetvalue+$value;
				}else{
					$qty = $value-$predayreading->Reading;
				}
				$dqty = $dqty + $qty;
				$pdata = array('RDRId'=>$creent_seling->id,'PumpId'=>$key,'Type'=>'d','Reading'=>$value,'date'=>date('Y-m-d',strtotime($date)),'qty'=>$qty,"created_at"=>$time);
				$this->daily_reports_model->master_insert("shreadinghistory",$pdata);
				
			}
			foreach($this->input->get_post('oil_reading') as $key=>$value){
				$predayreading = $this->daily_reports_model->get_one_data('shpump',array('id'=>$key));
				if($predayreading->p_type=='ml'){
					$qty = ($value*$predayreading->p_qty)/1000;
				}
				if($predayreading->p_type=='ltr'){
					$qty = ($value*$predayreading->p_qty);
				}
				if($predayreading->p_type=='kg'){
					$qty = ($value*$predayreading->p_qty);
				}
				if($predayreading->p_type=='ml'){
					$qty = ($value*$predayreading->p_qty)/1000;
				}
				$pdata = array('RDRId'=>$creent_seling->id,'PumpId'=>$key,'Type'=>'o','Reading'=>$value,'date'=>date('Y-m-d',strtotime($date)),'qty'=>$qty,"created_at"=>$time);
				$this->daily_reports_model->master_insert("shreadinghistory",$pdata);
			}
			$this->daily_reports_model->update_data('sh_dailyprice',array('date'=>date('Y-m-d',strtotime($date)),'user_id'=>$location_id,'status'=>'1'),array('pet_price'=>$this->input->get_post('p_price_per_l'),'dis_price'=>$this->input->get_post('d_price_per_l')));
			$daily_price = $this->daily_reports_model->get_one_data('sh_dailyprice',array('user_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
			$data1 = array(
                    "oil_reading" => $this->input->get_post('oil_sales'),
					"p_total_selling" => $pqty-$this->input->get_post('petrol_testing'),
					"d_total_selling" => $dqty-$this->input->get_post('Diesal_testing'),
					"p_sales_vat" => (($pqty-$this->input->get_post('petrol_testing'))*$daily_price->pet_price*20)/120,
					"d_sales_vat" => (($dqty-$this->input->get_post('Diesal_testing'))*$daily_price->dis_price*20)/120,
					"oil_pure_benefit" => (($this->input->get_post('oil_sales'))*5)/100,
					"p_testing"=>$this->input->get_post('petrol_testing'),
					"d_testing"=>$this->input->get_post('Diesal_testing'),
					"created_at"=>date("Y-m-d"),
					"cash_on_hand"=>$this->input->get_post('cash_on_hand')
                );
			$this->daily_reports_model->update_data('sh_dailyprice',array('date'=>date('Y-m-d',strtotime($date)),'user_id'=>$location_id,'status'=>'1'),array('pet_price'=>$this->input->get_post('p_price_per_l'),'dis_price'=>$this->input->get_post('d_price_per_l')));
			$this->daily_reports_model->update_data('shdailyreadingdetails',array('id'=>$creent_seling->id),$data1);
			$Petrol_pre_inventory = $this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',$newdate),'fuel_type'=>'p','status != '=>'0'));
			$diesel_pre_inventory = $this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',$newdate),'fuel_type'=>'d','status != '=>'0'));
			$oil_pre_inventory = $this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',$newdate),'fuel_type'=>'o','status != '=>'0'));
			$pre_seling = $this->daily_reports_model->get_one_data('shdailyreadingdetails',array('location_id'=>$location_id,'date'=>date('Y-m-d',$newdate),'status != '=>'0'));
			if($this->input->post('petrolpurchase') > 0){
				$buyprice = ($this->input->post('petrolpurchaseamount')+$this->input->post('petrolpurchasevatamount')+$this->input->post('petrolpurchasecesstaxamount'))/$this->input->post('petrolpurchase');
			}else{
				$buyprice = $Petrol_pre_inventory->p_new_price;
			}
			$data = array(
				'user_id' => $Petrol_pre_inventory->user_id,
				'date' => date('Y-m-d',strtotime($date)),
				'location_id' => $Petrol_pre_inventory->location_id,
				'invoice_no' => $this->input->post('petrolinvoice'),
				'fuel_type' => 'p',
				'p_quantity' => $this->input->post('petrolpurchase'),
				'p_fuelamount' => $this->input->post('petrolpurchaseamount'),
				'pv_taxamount' => $this->input->post('petrolpurchasevatamount'),
				'prev_p_stock' => $Petrol_pre_inventory->p_stock,
				'prev_p_price' => $Petrol_pre_inventory->p_new_price,
				'p_ev' => $Petrol_pre_inventory->p_stock-$pre_seling->p_total_selling-$this->input->post('petrolstock')+$Petrol_pre_inventory->p_quantity,
				'p_cess_tax'=>$this->input->post('petrolpurchasecesstaxamount'),
				'p_price' => $Petrol_pre_inventory->p_new_price,
				"p_new_price"=>$buyprice,
				"p_total_amount"=>$this->input->post('petrolpurchaseamount')+$this->input->post('petrolpurchasevatamount')+$this->input->post('petrolpurchasecesstaxamount'),
				'created_date' => date("Y-m-d H:i:s"),
			);
			$this->daily_reports_model->update_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'fuel_type'=>'p','status != '=>'0'),$data);
			if($this->input->post('dieselpurchase') > 0){
					$buyprice = ($this->input->post('dieselpurchaseamount')+$this->input->post('dieselpurchasevatamount')+$this->input->post('dieselpurchasecesstaxamount'))/$this->input->post('dieselpurchase');
			}else{
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
				'd_ev' => $diesel_pre_inventory->d_stock-$pre_seling->d_total_selling-$this->input->post('dieselstock')+$diesel_pre_inventory->d_quantity,
				'd_cess_tax'=>$this->input->post('dieselpurchasecesstaxamount'),
				'd_price' => $diesel_pre_inventory->d_new_price,
				"d_new_price"=>$buyprice,
				"d_total_amount"=>$this->input->post('dieselpurchaseamount')+$this->input->post('dieselpurchasevatamount')+$this->input->post('dieselpurchasecesstaxamount'),
				'created_date' => date("Y-m-d H:i:s") );
			$this->daily_reports_model->update_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'fuel_type'=>'d','status != '=>'0'),$ddata);
			$odata = array(
				'date' => date('Y-m-d',strtotime($date)),
				'invoice_no' => $this->input->post('oilinvoice'),
				'oil_sgst' => $this->input->post('oilsgst'),
				'oil_cgst' => $this->input->post('oilcgst'),
				'o_quantity' => '',
				'fuel_type' => 'o',
				'o_amount'=> $this->input->post('oilamount'),
				'o_stock' =>'',
				'oil_total_amount'=> $this->input->post('oilamountstock'),
				'prev_o_stock' => '',
				"p_new_price"=>'',
				"d_new_price"=>$buyprice,
				"d_total_amount"=>$this->input->post('petrolpurchaseamount')+$this->input->post('petrolpurchasevatamount')+$this->input->post('petrolpurchasecesstaxamount'),
				"p_total_amount"=>'',
				'created_date' => date("Y-m-d H:i:s") ); 
			$getoilinventoryid = $this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'fuel_type'=>'o','status != '=>'0'));
			$oildffrentstok = $getoilinventoryid->oil_total_amount - $this->input->post('oilamountstock');
			if($oildffrentstok != 0){
				$this->daily_reports_model->updatealloilstock($location_id,date('Y-m-d',strtotime($date)),$oildffrentstok);
			}
			$this->daily_reports_model->update_data('sh_inventory',array('id'=>$getoilinventoryid->id,'status != '=>'0'),$odata);
			$this->daily_reports_model->update_data('sh_oil_inventory',array('inv_id'=>$getoilinventoryid->id,'status != '=>'0'),array('status'=>0));
			$this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'fuel_type'=>'o','status != '=>'0'),$odata); 
			foreach ($this->input->post('oilinventory[]') as $key => $oillist){
				$data1 = array(
					"inv_id" => $getoilinventoryid->id,
					"oil_id" =>  $key,
					"qty"=> $oillist,
					"ltr" => '',
					"created_at"=>date("Y-m-d H:i:s") );
				$this->daily_reports_model->master_insert("sh_oil_inventory",$data1);
			}
			$this->update_next($this->input->get_post('date'),$this->input->get_post('location'));
			//$this->set_stock($this->input->get_post('date'),$this->input->get_post('location'));
			$this->session->set_flashdata('success','Data Update Success fully.');
			redirect('daily_reports/index?sdate='.$sdate.'&location='.$location_id.'&edate='.$edate);
		}
		function update_next($date,$location_id){
			$this->load->database();
			$this->load->model('daily_reports_model');
			$next_newdate = date("Y-m-d",strtotime ( '1 day' , strtotime ( $date ) ) );
			$newdate = strtotime($date);
			$date = $date;
			$creent_seling = $this->daily_reports_model->get_one_data('shdailyreadingdetails',array('location_id'=>$location_id,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
			$next_seling = $this->daily_reports_model->get_one_data('shdailyreadingdetails',array('location_id'=>$location_id,'date'=>$next_newdate,'status != '=>'0'));
			if($next_seling){
				$currentsellid = $creent_seling->id; 
				$nextsellid = $next_seling->id;
				$pqty = 0;
				$currentpreading = $this->daily_reports_model->get_all('shreadinghistory',array('Type'=>'p','RDRId'=>$currentsellid,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
				foreach($currentpreading as $currentreading){
					$predayreading = $this->daily_reports_model->get_one_data('shreadinghistory',array('Type'=>'p','PumpId'=>$currentreading->PumpId,'date'=>$next_newdate,'status != '=>'0'));
					$get_reset_detail = $this->daily_reports_model->get_one_data('sh_reset_pump',array('pump_id'=>$currentreading->PumpId,'date'=>$next_newdate,'status != '=>'0'));
					if($get_reset_detail){
						$predayreading1 = $this->daily_reports_model->get_one_data('shreadinghistory',array('Type'=>'p','PumpId'=>$currentreading->PumpId,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
						$resetvalue = $get_reset_detail->reading-$predayreading1->Reading;
						$qty = $resetvalue+$predayreading->Reading;
					}else{
						$qty = $predayreading->Reading-$currentreading->Reading;
					}
					$pqty = $pqty + $qty;
					$this->daily_reports_model->update_data('shreadinghistory',array('id'=>$predayreading->id),array("qty"=>$qty));
				}
				$dqty = 0;
				$currentdreading = $this->daily_reports_model->get_all('shreadinghistory',array('Type'=>'d','RDRId'=>$currentsellid,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
				foreach($currentdreading as $currentreading){
					$predayreading = $this->daily_reports_model->get_one_data('shreadinghistory',array('Type'=>'d','PumpId'=>$currentreading->PumpId,'date'=>$next_newdate,'status != '=>'0'));
					$get_reset_detail = $this->daily_reports_model->get_one_data('sh_reset_pump',array('pump_id'=>$currentreading->PumpId,'date'=>$next_newdate,'status != '=>'0'));
					if($get_reset_detail){
						$predayreading1 = $this->daily_reports_model->get_one_data('shreadinghistory',array('Type'=>'d','PumpId'=>$currentreading->PumpId,'date'=>date('Y-m-d',strtotime($date)),'status != '=>'0'));
						$resetvalue = $get_reset_detail->reading-$predayreading1->Reading;
						$qty = $resetvalue+$predayreading->Reading;
					}else{
						$qty = $predayreading->Reading-$currentreading->Reading;
					}
					$dqty = $dqty + $qty;
					$this->daily_reports_model->update_data('shreadinghistory',array('id'=>$predayreading->id),array("qty"=>$qty));
				}
 				$daily_price = $this->daily_reports_model->get_one_data('sh_dailyprice',array('user_id'=>$location_id,'date'=>$next_newdate,'status != '=>'0'));
				$data1 = array(
					"p_total_selling" => $pqty-$next_seling->p_testing,
					"d_total_selling" => $dqty-$next_seling->d_testing,
					"p_sales_vat" => (($pqty-$next_seling->p_testing)*$daily_price->pet_price*20)/120,
					"d_sales_vat" => (($dqty-$next_seling->d_testing)*$daily_price->dis_price*20)/120,
					"created_at"=>date("Y-m-d")
                );
				$this->daily_reports_model->update_data('shdailyreadingdetails',array('id'=>$next_seling->id),$data1);
			}
		}
function thumbnail() {
	$url = 'https://stackoverflow.com/';
	$client_id = 'urrjr7894784'; // your client ID
	$signature = 'kjhh35h4j5'; // the signature you entered @ girafa
	$concatenated = $signature.$url;
	$MD5_Hash = md5($concatenated);
	$signature = substr($MD5_Hash, 16, 16);
	$url = urlencode($url);
	$str = 'http://scst.srv.girafa.com/srv/i?i=';
	$str .= $client_id .'&r='. $url .'&s='. $signature;
	print_r($str);
}   

function update_all(){
	$this->load->model('daily_reports_model');
	$lists = $this->daily_reports_model->get_all('shdailyreadingdetails',array('location_id'=>'39','status != '=>'0'));
	$tanklists = $this->daily_reports_model->get_deep("15kl");
	echo "<pre>";
	foreach($lists as $list){		
		foreach($tanklists as $key => $tanklist){
			if($tanklist->cm > $list->p_deep_reading){
				break;
			}
			
		}
		$prvdeepdata = $tanklists[$key-1];
		$dieselstock = $list->p_deep_reading; 
		$pdetailstock = (explode(".",$dieselstock));
		if(isset($pdetailstock[1])){
			if($pdetailstock[1][0] > 0){
				if($pdetailstock[1][0] == '1' || $pdetailstock[1][0] == '6') { $temp = 1; }
				if($pdetailstock[1][0] == '2' || $pdetailstock[1][0] == '7') { $temp = 2; }
				if($pdetailstock[1][0] == '3' || $pdetailstock[1][0] == '8') { $temp = 3; }
				if($pdetailstock[1][0] == '4' || $pdetailstock[1][0] == '9') { $temp = 4; }
				$dstocqty = $prvdeepdata->Ltrs +( $tanklist->extra_col * $temp );
				
			}else{
				$dstocqty = $prvdeepdata->Ltrs;
			}
		}else{
			$dstocqty = $dstocqty->Ltrs;
		}
		//echo $list->id." ".$dstocqty."<br>";
		$this->daily_reports_model->update_data('shdailyreadingdetails',array('id'=>$list->id),array("p_tank_reading"=>$dstocqty));
		echo $this->db->last_query(); echo "<br>";
	}
	foreach($lists as $list){		
		foreach($tanklists as $key => $tanklist){
			if($tanklist->cm > $list->d_deep_reading){
				break;
			}
		}
		$prvdeepdata = $tanklists[$key-1];
		$dieselstock = $list->d_deep_reading; 
		$pdetailstock = (explode(".",$dieselstock));
		if(isset($pdetailstock[1])){
			if($pdetailstock[1][0] > 0){
				if($pdetailstock[1][0] == '1' || $pdetailstock[1][0] == '6') { $temp = 1; }
				if($pdetailstock[1][0] == '2' || $pdetailstock[1][0] == '7') { $temp = 2; }
				if($pdetailstock[1][0] == '3' || $pdetailstock[1][0] == '8') { $temp = 3; }
				if($pdetailstock[1][0] == '4' || $pdetailstock[1][0] == '9') { $temp = 4; }
				$dstocqty = $prvdeepdata->Ltrs +( $tanklist->extra_col * $temp );
			}else{
				$dstocqty = $prvdeepdata->Ltrs;
			}
		}else{
			$dstocqty = $dstocqty->Ltrs;
		}
		//echo $list->id." ".$dstocqty."<br>";
		$this->daily_reports_model->update_data('shdailyreadingdetails',array('id'=>$list->id),array("d_tank_reading"=>$dstocqty));
		echo $this->db->last_query(); echo "<br>";
	}
}     
function setoilstock(){
	$this->load->model('daily_reports_model');
	$list = $this->daily_reports_model->get_all_oil_stok();
	echo $this->db->last_query();
	echo "<pre>";
	$ostock = 163873.7;
	foreach($list as $oil){
		echo $oil->id;
		echo "<br>";
		
		$this->daily_reports_model->update_data('sh_inventory',array('id'=>$oil->id),array("oil_total_amount"=>$ostock));
		echo $ostock = $ostock - $oil->sel;
		echo "<br>";
	}
} 
function set_stock($date,$lid){
	$date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
	//$date = $date;
	$date2 = '2018-12-01';
	if(strtotime($date) < strtotime($date2)){
		return 1;
	}else{
	$this->load->model('daily_reports_model');
	$list = $this->daily_reports_model->get_all_order('shdailyreadingdetails',array('status'=>'1','location_id'=>$lid,'date >='=>$date),array('date','asc'));
	$p_original_stock = $list[0]->p_opening_original_stock;
	$d_original_stock = $list[0]->d_opening_original_stock;
	$cnt = 0;
	foreach($list as $detail){		
	//echo "<br><br>";
	//echo $detail->date."<br>";
	//echo $p_original_stock."<br>";
	//echo $d_original_stock."<br>";
	
		if($cnt != 0){			
			$this->daily_reports_model->update_data('shdailyreadingdetails',array('id'=>$detail->id),array("p_opening_original_stock"=>$p_original_stock));
			$this->daily_reports_model->update_data('shdailyreadingdetails',array('id'=>$detail->id),array("d_opening_original_stock"=>$d_original_stock));
		}
		$Petrol_inventory = $this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$lid,'date'=>$detail->date,'fuel_type'=>'p','status != '=>'0'));
		
		$Dieasl_inventory = $this->daily_reports_model->get_one_data('sh_inventory',array('location_id'=>$lid,'date'=>$detail->date,'fuel_type'=>'d','status != '=>'0'));
		//echo $p_original_stock ."+". $Petrol_inventory->p_quantity ."-". $detail->p_total_selling."-".$pshort."<br>";
		//echo $d_original_stock ."+". $Dieasl_inventory->d_quantity ."-". $detail->d_total_selling."-".$dshort."<br>"; 
		$pshort = round(($detail->p_total_selling*0.75)/100,2);
		$dshort = round(($detail->d_total_selling*0.20)/100,2);
		$p_original_stock = $p_original_stock + $Petrol_inventory->p_quantity - $detail->p_total_selling-$pshort;
		$d_original_stock = $d_original_stock + $Dieasl_inventory->d_quantity - $detail->d_total_selling-$dshort;
		
		//echo $p_original_stock."<br>";
		//echo $d_original_stock."<br>";
		$this->daily_reports_model->update_data('shdailyreadingdetails',array('id'=>$detail->id),array("p_closing_original_stock"=>$p_original_stock,"d_closing_original_stock"=>$d_original_stock,'dshort'=>$dshort,'pshort'=>$pshort));
		//echo $this->db->last_query()."<br>";
		$cnt++;
	}
}
}
}
?>