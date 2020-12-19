<?php

class Saving_member_report extends CI_Controller {

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
            $data['location'] = $this->expense_model->master_fun_get_tbl_val_location('sh_location', array('status' => 1,'show_hide' =>'show', 'company_id' => $c_id));
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
        $this->load->view('web/saving_member_report', $data);
    }

    function saving_member_report_view() {
        $this->load->model('expense_model');
        $data = array();
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('saving_member_model');
        $lid = $this->input->get('l_id');
        $date = $this->input->get('date');
        $member_id = $this->input->get('member_id');
        $current_date = date('Y-m-d');
        $data['report_data'] = $this->saving_member_model->get_report_data_date($lid, date("Y-m-d", strtotime($date)), $member_id);
//        print_r($data['report_data']);
        //echo $this->db->last_query();     echo "<br>";     
        //echo $this->db->last_query();die();
        $this->load->view('web/saving_member_report_view', $data);
    }

    function reportlist() {
        //ini_set('display_errors', -1);
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('saving_member_model');
        $lid = $this->input->post('lid');
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
        $member_id = $this->input->post('member_id');
        $current_date = date('Y-m-d');
        $report_data = $this->saving_member_model->report_data($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);
        // echo $this->db->last_query(); 
        $fianlarray = array();

        foreach ($report_data as $report) {

            $n_array = array("date" => $report->date,
                "amount" => $report->total_amount,
                "name" => $report->name,
                "member_id" => $report->member_id);
            $fianlarray[] = $n_array;
        }

        function sortByName($a, $b) {
            $a = $a['date'];
            $b = $b['date'];

            if ($a == $b)
                return 0;
            return ($a < $b) ? -1 : 1;
        }

//        usort($fianlarray, 'sortByName');

        $base_url = base_url();
        $cnt = 1;
        $html = '';
//        print_r($fianlarray);
        foreach ($fianlarray as $credit) {

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
            $total_saving_amount = $total_saving_amount + $credit['amount'];

            $cashdebit = $credit['cashdebit'];
            $creshcrdit = $credit['creshcrdit'];
            $bank_cradit = $credit['bank_cradit'];
            $bank_debit = $credit['bank_debit'];

            $member_id = $credit['member_id'];
            $dtotal = $credit['d_amount'] + $dtotal;
            $debittotal = $credit['d_amount'];

            // $name = $credit['name'];
            // $remark = $credit['remark'];
            $paymentfor = '';
            $msg = '"Are you sure you want to remove this data?"';
            if(in_array("saving_member_report_action",$this->data['user_permission_list'])){
                $edit = "<td><a href='" . $base_url . "saving_member_report/saving_member_report_view?date=" . $credit['date'] . "&sdate=" . $sdate . "&edate=" . $edate . "&l_id=" . $lid . "&member_id=" . $credit['member_id'] . "'><i class='fa fa-eye'></i></a></td>";
            } else {
                $edit = "";
            }
            $html .= '<tr><td>' . $cnt . '</td><td>' . ucfirst($credit['name']) . '</td><td>' . date('d/m/Y', strtotime($date)) . '</td><td>' . amountfun($credit['amount']) . '</td>' . $edit . '</tr>';
            $cnt++;
        }

        if ($cnt == 0) {
            $html .= '<tr><td colspan="2">No Data avalieble</td></tr>';
        }

        $html .= '<tr><td colspan="2">Total</td><td></td><td>' . amountfun($total_saving_amount) . '</td><td></tr>';

//        $html .= '<tr><td colspan="2"><b>Final Total</b></td><td><b>' . $f_cresh_total . '</b></td><td></td><td><b>' . $f_bank_total . '</b></td><td></td></tr>';
//        $html .= '<tr><td><b>Total cash balance</b> </td><td><b>' . $total_cash_balance . '</b></td><td><b>Total Bank balance</b></td><td><b>' . $total_bank_balance . '</b></td><td></td></tr>';
//        $html .= '<tr><td><b>Final balance</b> </td><td>' . $temp . '</td></tr>';
        echo $html;
//         echo $this->session->userdata('logged_company')['type'];
    }

    function reportlist_mobile() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('saving_member_model');
        $lid = $this->input->post('lid');
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
        $member_id = $this->input->post('member_id');
        $current_date = date('Y-m-d');
        $customerceditlist = $this->saving_member_model->get_tasection_list($lid, date("Y-m-d", strtotime($sdate)), date("Y-m-d", strtotime($edate)), $current_date, $member_id);

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
        $this->load->model('saving_member_model');
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('expense_model');
        $lid = $this->input->get_post('lid');
        $data['sdate'] = $sdate = $this->input->get_post('sdate');
        $edate = $this->input->get_post('edate');
        $data['edate'] = $edate = $this->input->get_post('date2');
        $data['sdate'] = $sdate = $this->input->get_post('date1');
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

    function info() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('saving_member_model');
        $id = $this->input->get_post('id');
        $data['id'] = $id;
        $c_id = $_SESSION['logged_company']['id'];
        $data['member_list'] = $this->saving_member_model->get_tbl_list('saving_member', array('status' => 1, 'company_id' => $c_id), array('name', 'asc'));
        $data['transaction_detail'] = $this->saving_member_model->get_tbl_one('saving_member_transaction', array('status' => 1, 'id' => $id));

//        print_r($data['transaction_detail']);
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('memberid', 'Member', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $date = $this->input->post('date');
            $data = array(
                'member_id' => $this->input->get_post('memberid'),
                'date' => date('Y-m-d', strtotime($this->input->get_post('date'))),
                'remark' => $this->input->get_post('remark'),
                'amount' => $this->input->get_post('amount')
            );
            $update = $this->saving_member_model->update_transaction_record($id, $data);
            $lid = $this->input->get_post('l_id');
            $sdate = $this->input->get_post('sdate');
            $edate = $this->input->get_post('edate');
            $member_id = $this->input->get_post('member_id');
            $this->session->set_flashdata('success_update', 'Updated Successfully..');
            redirect('saving_member_report?l_id=' . $lid . '&sdate=' . $sdate . '&edate=' . $edate . '&member_id=' . $member_id);
        } else {
            $this->load->view('web/saving_member_info', $data);
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


        $this->load->model('saving_member_model');
        $id = $this->input->get('id');
        $lid = $this->input->get('l_id');
        $sdate = $this->input->get('sdate');
        $edate = $this->input->get('edate');
        $member_id = $this->input->get_post('member_id');
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'status' => '0'
        );
        $this->saving_member_model->transaction_delete($id, $data);
        $lid = $this->input->get('l_id');
        $sdate = $this->input->get('sdate');
        $edate = $this->input->get('edate');
        $this->session->set_flashdata('fail', 'Trasaction Deleted Successfully..');
        redirect('saving_member_report?l_id=' . $lid . '&sdate=' . $sdate . '&edate=' . $edate . '&member_id=' . $member_id);
    }

    function member_list() {
        $customer_id = $this->uri->segment(3);
        $lid = $this->input->post('lid');
        $this->load->model('saving_member_model');
        $customerlist = $this->saving_member_model->get_tbl_list('saving_member', array('status' => 1, 'location_id' => $lid), array('name', 'asc'));
        $html = '<option value="">Select Member </option>';
        foreach ($customerlist as $customer) {
            $selected = "";
            if ($customer_id == $customer->id) {
                $selected = "selected";
            }
            $html .= '<option value="' . $customer->id . '" ' . $selected . '>' . ucfirst($customer->name) . '</option>';
        }
        echo $html;
    }

}?>