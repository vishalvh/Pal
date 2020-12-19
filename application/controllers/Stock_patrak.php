<?php

class Stock_patrak extends CI_Controller {

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
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->database();
        $this->load->model('stock_patrak_reports_model');
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
        $fueltype = $this->input->get_post('fueltype');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['location'] = $location_id;
        $data['fueltype'] = $fueltype;
        if ($location_id != "") {
            $sdate1 = date("Y-m-d", strtotime('-1 day', strtotime($sdate)));
            $data['report'] = $this->stock_patrak_reports_model->report($location_id, $sdate1, $edate);
            $get_tank_readin = $this->stock_patrak_reports_model->get_tank_readin($location_id, $sdate, $edate);
            $data['location_tank_list'] = $this->stock_patrak_reports_model->select_all_with_order('id,tank_name,tank_type,fuel_type', 'sh_tank_list', array('location_id' => $location_id, "status" => '1', "fuel_type" => $fueltype), array('tank_name', 'asc'));
            $finaltank = array();
            foreach ($get_tank_readin as $tank) {
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['name'] = $tank->tank_name;
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['deepreading'] = $tank->deepreading;
            } 
            $data['finaltank'] = $finaltank;
           // echo "<pre>";
           // print_r($data['report']);
           // die();
        }
        $this->load->view('web/stock_report', $data);
    }

    function print_pdf() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->database();
        $this->load->model('stock_patrak_reports_model');
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
        $fueltype = $this->input->get_post('fueltype');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['location'] = $location_id;
        $data['fueltype'] = $fueltype;
        if ($location_id != "") {
            $sdate1 = date("Y-m-d", strtotime('-1 day', strtotime($sdate)));
            $data['report'] = $this->stock_patrak_reports_model->report($location_id, $sdate1, $edate);
            $get_tank_readin = $this->stock_patrak_reports_model->get_tank_readin($location_id, $sdate, $edate);
            $data['location_tank_list'] = $this->stock_patrak_reports_model->select_all_with_order('id,tank_name,tank_type,fuel_type', 'sh_tank_list', array('location_id' => $location_id, "status" => '1', "fuel_type" => $fueltype), array('tank_name', 'asc'));
            $finaltank = array();
            foreach ($get_tank_readin as $tank) {
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['name'] = $tank->tank_name;
                $finaltank[$tank->date][$tank->sales_id][$tank->fuel_type][$tank->tank_id]['deepreading'] = $tank->deepreading;
            }
            $data['finaltank'] = $finaltank;
            
            $data['location_detail'] = $this->stock_patrak_reports_model->location_detail($location_id);
            $data['salary'] = $this->stock_patrak_reports_model->worker_salary_remening($location_id, $sdate, $edate);
            $data['loansalary'] = $this->stock_patrak_reports_model->worker_salary_loan($location_id, $edate);
//echo $this->db->last_query();			
//echo "<pre>"; print_r($data['report']); echo "</pre>";
            $data['lastday'] = $this->stock_patrak_reports_model->last_day_entry($location_id, $sdate, $edate);
//                        echo $this->db->last_query();
//                        die();
            $data['monthly_expence'] = $this->stock_patrak_reports_model->monthly_expence($location_id, $sdate, $edate);
            $data['ioc_balence'] = $this->stock_patrak_reports_model->ioc_balence($location_id, $sdate, $edate);
            $data['deposit_amount'] = $this->stock_patrak_reports_model->deposit_amount($location_id, $sdate, $edate);

            $data['onlinetransaction'] = $this->stock_patrak_reports_model->onlinetransaction($location_id, $sdate, $edate);
            $data['get_customer_credit'] = $this->stock_patrak_reports_model->get_customer_credit($location_id, $sdate, $edate);
            //echo $this->db->last_query();
            $data['get_customer_debit'] = $this->stock_patrak_reports_model->get_customer_debit($location_id, $sdate, $edate);
            $data['pre_deposit_amount'] = $this->stock_patrak_reports_model->pre_deposit_amount($location_id, $sdate);

            $data['get_credit'] = $this->stock_patrak_reports_model->get_credit($location_id, $edate);
            $data['get_debit'] = $this->stock_patrak_reports_model->get_debit($location_id, $edate);

            $data['prev_card_depost'] = $this->stock_patrak_reports_model->prev_card_depost($location_id, $sdate);
            $data['pre_onlinetransaction'] = $this->stock_patrak_reports_model->pre_onlinetransaction($location_id, $sdate);
            $newdate = date('Y-m-d', strtotime('+1 day', strtotime($edate)));
            $this->load->model('company_report_model');
            $data['prv_ioc_total'] = $this->company_report_model->get_pre_ioc_total($location_id, $edate);
            $data['prv_transection_total'] = $this->company_report_model->get_pre_transection_total($location_id, $edate);
            $data['prv_purchase_total'] = $this->company_report_model->get_pre_purchase_total($location_id, $edate);
        }
        $this->load->library('m_pdf');
        $html = $this->load->view('web/pdfstock_report', $data, true);
        $pdfFilePath = "uploads/" . date('d-m-Y-H-i-s') . "invoice.pdf";

        $lorem = utf8_encode($html); // render the view into HTML
        $pdf = $this->m_pdf->load();
        $pdf->AddPage('p', // L - landscape, P - portrait
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