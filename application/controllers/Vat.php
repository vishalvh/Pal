<?php

class Vat extends CI_Controller {

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
            $p = new Web_log;
            $this->allper = $p->Add_data();
//            ini_set('display_errors', '-1');
        }
    }

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->view('web/vat/list', $data);
    }

    public function test_data() {
        $date = "2018-01-01";
        $today = date("Y-m-d");
        $this->load->model('vat_model');
        $dateDiff = $this->dateDiffInDays($date, $today);
        for ($i = 0; $i <= $dateDiff; $i++) {
            $current_date = date('Y-m-d', strtotime($date . '+ ' . $i . ' days'));
            if(strtotime($current_date) < strtotime("19-10-2018") ){
            $data = array("date"=>$current_date,"vat_per"=>20);
            $this->db->insert('vat_list', $data);
           
            }else{
                $data = array("date"=>$current_date,"vat_per"=>17);
            $this->db->insert('vat_list', $data);
            }
            
        }
    }

    function dateDiffInDays($date1, $date2) {
        // Calulating the difference in timestamps 
        $diff = strtotime($date2) - strtotime($date1);

        // 1 day = 24 hours 
        // 24 * 60 * 60 = 86400 seconds 
        return abs(round($diff / 86400));
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('vat_model');
        $id = $_SESSION['logged_company']['id'];
        

        $sdate = $this->input->get_post('sdate');
         $edate = $this->input->get_post('edate');
        if($sdate != "" ){
           $sdate1 =  date("Y-m-d", strtotime($sdate));
        }else{
            $sdate1 = "";
        }
        if($sdate != "" ){
            $edate1 = date("Y-m-d", strtotime($edate));
        }else{
            $edate1 = "";
        }
       
        if($sdate != "" && $edate != ""){
        $list = $this->vat_model->get_datatables($sdate1, $edate1);
        }else{
        $list = $this->vat_model->get_datatables();
        }
//echo $this->db->last_query();
//die();
        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {

            $no++;
            $edit = "<a href='" . $base_url . "vat/update/" . $customers->id . " '><i class='fa fa-edit'></i></a>  
			";
//            /<a href='" . $base_url . "index.php/admin_location/loc_delete/" . $customers->id . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a>
            $row = array();
            $row[] = $no;
            $row[] = date('d/m/Y', strtotime($customers->date));
            $row[] = $customers->vat_per;
            if ($this->session->userdata('logged_company')['type'] == 'c') {
                $row[] = $edit;
            }

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->vat_model->count_all($sdate1, $edate1),
            "recordsFiltered" => $this->vat_model->count_filtered($sdate1, $edate1),
            "data" => $data,
        );
        

        echo json_encode($output);
    }

    function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('admin_location');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->view('web/insert_location', $data);
    }
    function loc_delete() {
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('admin_location');
        }
        $this->load->model('vat_model');
        $id = $this->uri->segment('3');
        $sess_id = $this->session->userdata('id');
        $data = array(
            'deleted_by' => $sess_id,
            'status' => '0'
        );
        $this->vat_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'Data Deleted Successfully..');
        redirect('admin_location/index');
    }

    function update() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
//            redirect('admin_location');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('vat_model');
        $id = $this->input->post('id');
        $data["id"] = $this->uri->segment('3');
        $this->form_validation->set_rules('vat_per', 'Vat', 'required');
        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array(
                'vat_per' => $this->input->post('vat_per'),
               
            );
            $date = $this->input->post('date');
//            print_r($date);
//            die();
            $update = $this->vat_model->update($id, $data,$date);
//echo $this->db->last_query();
//die();
            $this->session->set_flashdata('success_update', 'Data Updated Successfully..');
            redirect('vat/index');
        } else {

            $id = $this->uri->segment('3');
            if ($id == "") {
                $id = $this->input->post('id');
            }
            $query = $this->db->get_where("vat_list", array("id" => $id));
            $data['r'] = $query->row();

            $this->load->view('web/vat/edit', $data);
        }
    }

}

?>