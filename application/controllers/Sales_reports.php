<?php

class Sales_reports extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_company')) {
            $this->load->model('user_login');
            if ($this->session->userdata('logged_company')['type'] == 'c') {
                $sesid = $this->session->userdata('logged_company')['id'];
                $this->data['all_location_list'] = $this->user_login->get_all_location($sesid);
            } else {
                $sesid = $this->session->userdata('logged_company')['u_id'];
                $this->data['all_location_list'] = $this->user_login->get_location($sesid);
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
        $this->load->model('daily_reports_model');
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
            $report = $this->daily_reports_model->report($location_id, $sdate, $edate);
//                        echo $this->db->last_query();
//                        if($_GET['dub'] == 1){
//                            ini_set('display_errors', -1);
            $f_array = array();
            foreach ($report as $d) {
                $r_data = $this->daily_reports_model->sales_on_card_data($d['date'], $location_id);
//               print_r($d['sales_on_card_data']);
                $h = "";
                foreach ($r_data as $r) {
                    $h.= "<tr><td>" . date('d/m/Y', strtotime($r['date'])) . "</td><td>" . $r['amount'] . "</td><td>" . $r['remark'] . "</td></tr>";
                }
                $d['sales_on_card_data'] = $h;
                $f_array[] = $d;
            }
//            echo "<pre>";
//            print_r($f_array);
//            print_r($data['report']);
//                        die();
//                        
//            }
            $data['report'] = $f_array;
            $oil_report = $this->daily_reports_model->oil_report($location_id, $sdate, $edate);
            $data['final_oil_report'] = array();
            foreach ($oil_report as $oil_detail) {
                $data['final_oil_report'][$oil_detail->date][$oil_detail->id] = $oil_detail;
            }
            //echo "<pre>"; print_r($final_oil_report); die();
        } else {
            $data['report'] = "";
        }
        $this->load->view('web/sales_reports', $data);
    }

    function print_report() {
        $lid = $this->input->get('location_id');
        $sdate = $this->input->get('sdate');
        $edate = $this->input->get('edate');
        $this->load->model('daily_reports_model');
        $data['location_detail'] = $this->daily_reports_model->location_detail($lid);
        $data['report'] = $this->daily_reports_model->report($lid, $sdate, $edate);
        $oil_report = $this->daily_reports_model->oil_report($lid, $sdate, $edate);
        $data['final_oil_report'] = array();
        foreach ($oil_report as $oil_detail) {
            $data['final_oil_report'][$oil_detail->date][$oil_detail->id] = $oil_detail;
        }
        $this->load->library('m_pdf');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $html = $this->load->view('web/pdfsalesreport.php', $data, true);
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