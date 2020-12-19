<?php

class Oil_packet extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Adminpump_model');
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
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $sesid = $this->session->userdata('logged_company')['id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        } else {
            $sesid = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        }
        $this->load->view('web/view_oil_packet', $data);
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('Adminpump_model');
        $id = $_SESSION['logged_company']['id'];
        $extra = $this->input->get('extra');
        $list = $this->Adminpump_model->get_datatables_oil($extra, $id);
        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];
        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {
            $no++;
             if ($customers->show == 0) {
                $msg_s_h = "Show";
                $status = '<span class="btn btn-danger">Hide</span>';
            } else {
                $msg_s_h = "Hide";
                $status = '<span class="btn btn-primary">Show</span>';
            }
            $ac1 = " <a href='" . $base_url . "oil_packet/show_hide/" . $customers->id . "/" . $customers->show . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'>$msg_s_h</a>";
            $edit = "<a href='" . $base_url . "oil_packet/upd_packet/" . $customers->id . "/" . $extra . " '><i class='fa fa-edit'></i></a>  
			<a href='" . $base_url . "oil_packet/oil_packet_delete/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a>  $ac1  ";
            $row = array();
            $row[] = $no;
            $row[] = $customers->name;
            $row[] = $customers->l_name;
            $row[] = $customers->packet_type;
            $row[] = $customers->packet_value;
            $row[] = $customers->spacket_value;
            $row[] = $status;
            
            if(in_array("oil_packet_action",$this->data['user_permission_list'])){
                $row[] = $edit;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Adminpump_model->count_all_oil($extra, $id),
            "recordsFiltered" => $this->Adminpump_model->count_filtered_oil($extra, $id),
            "data" => $data,
        );

        echo json_encode($output);
    }
    public function show_hide() {
        ini_set('display_errors', '-1');
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('oil_packet');
        }
        $id = $this->uri->segment('3');
        $show = $this->uri->segment('4');
        $lid = $this->uri->segment('5');
        $data = array();
        if ($show == '1') {

            $sting = "hide";
            $data = array('show' => 0);
        } else {
            $sting = "show";
            $data = array('show' => 1);
        }
      
        $update = $this->Adminpump_model->update($id, $data);
        //echo $this->db->last_query();
        $this->session->set_flashdata('success', 'Data ' . $sting . ' Successfully..');
        redirect('oil_packet/index/' . $lid);
    }

    // Instert Page

    public function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('oil_packet');
        }

        $data["logged_company"] = $_SESSION['logged_company'];
        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('Adminpump_model');
        $data['r'] = $this->Adminpump_model->select_location($id1);

        $this->load->view('web/oil_packet_insert', $data);
    }

    public function insert() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('oil_packet');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->form_validation->set_rules('pump', 'Name', 'required');
        $this->form_validation->set_rules('packet_type', 'Packet type', 'required');
        $this->form_validation->set_rules('packet_value', 'Packet Buy value', 'required');
        $this->form_validation->set_rules('spacket_value', 'Packet Sell value', 'required');

        if ($this->form_validation->run() == true) {
            $data = array(
                'location_id' => $this->input->post('sel_loc'),
                'company_id' => $_SESSION['logged_company']['id'],
                'name' => $this->input->post('pump'),
                'type' => 'O',
                'packet_value' => $this->input->post('packet_value'),
                'spacket_value' => $this->input->post('spacket_value'),
                'packet_type' => $this->input->post('packet_type'),
                'created_at' => date("Y-m-d H:i:sa"),
                'p_type' => $this->input->post('sel_p_type'),
                'p_qty' => $this->input->post('packet_qty'),
                'new_p_qty' => $this->input->post('packet_qty')
            );

            $this->db->insert('shpump', $data);
            // echo $this->db->last_query();die();
            $this->session->set_flashdata('success', 'Data Added Successfully');

            redirect('oil_packet');
        } else {
            $this->add();
        }
    }

    function pump_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('oil_packet');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Adminpump_model');
        $id = $this->uri->segment('3');
        $sess_id = $_SESSION['logged_company']['id'];
        date_default_timezone_set('Asia/Kolkata');
        $data = array(
            'delete_at' => date("Y-m-d H:i:sa"),
            'status' => '0'
        );
        $this->Adminpump_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'Data Deleted Successfully..');
        redirect('oil_packet');
    }

    function oil_packet_delete() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('oil_packet');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Adminpump_model');
        $id = $this->uri->segment('3');
        $sess_id = $_SESSION['logged_company']['id'];
        $data = array(
            'delete_at' => date("Y-m-d H:i:sa"),
            'status' => '0'
        );
        $this->Adminpump_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'Data Deleted Successfully..');
        redirect('oil_packet/index/' . $this->uri->segment('4'));
    }

    function upd_packet() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        } if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('oil_packet');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Adminpump_model');
        $id = $this->uri->segment('3');
        $data["id"] = $this->uri->segment('3');
        $data["pump"] = $this->Adminpump_model->select_pumpby_id($id);
        $this->form_validation->set_rules('pump', 'pump', 'required');
        $this->form_validation->set_rules('packet_type', 'Packet type', 'required');
        $this->form_validation->set_rules('packet_value', 'Packet Buy value', 'required');
        $this->form_validation->set_rules('spacket_value', 'Packet Sell value', 'required');
        if ($this->form_validation->run() == true) {
            $data = array(
                'location_id' => $this->input->post('sel_loc'),
                'company_id' => $_SESSION['logged_company']['id'],
                'name' => $this->input->post('pump'),
                'type' => 'O',
                'packet_value' => $this->input->post('packet_value'),
                'spacket_value' => $this->input->post('spacket_value'),
                'packet_type' => $this->input->post('packet_type'),
                'created_at' => date("Y-m-d H:i:sa"),
                'p_type' => $this->input->post('sel_p_type'),
                'p_qty' => $this->input->post('packet_qty'),
                'new_p_qty' => $this->input->post('packet_qty')
            );
            $update = $this->Adminpump_model->update($id, $data);
            $this->session->set_flashdata('success_update', 'Data Updated Successfully..');
            redirect('oil_packet/index/' . $this->uri->segment('4'));
        } else {
            $id = $this->uri->segment('3');
            if ($id == "") {
                $id = $this->input->post('id');
            }
            $query = $this->db->get_where("shpump", array("id" => $id));
            $data['r'] = $query->row();

            $this->load->model('admin_model');
            $id1 = $_SESSION['logged_company']['id'];
            $data['r1'] = $this->admin_model->select_location($id1);

            $this->load->view('web/oil_packet_edit', $data);
        }

        // $this->load->view('web/edit_location.php');
    }

    function view_stock() {
		if($_GET['test'] != '1'){
			//echo "we are working"; die();
		}
        ini_set('display_errors', -1);
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }

        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $sesid = $this->session->userdata('logged_company')['id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        } else {
            $sesid = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $data['l_id'] = $location_id = $lid = $this->input->get('lid');
        $data['date'] = $sdate = $this->input->get('date');

        $date = date("Y-m-d", strtotime($sdate));
        $get_oil_detail_price = $this->Adminpump_model->get_oil_detail_price($location_id, $sdate);
          //echo $this->db->last_query(); die();
        $oil_detail_price = array();
        foreach ($get_oil_detail_price as $d) {
            $oil_detail_price['bay_price'] = $d->total_bay_price;
            $oil_detail_price['sel_price'] = $d->total_sel_price;
            $oil_detail_price['total'] = $total_result[0]->total;
            $oil_detail_price['stock'] = $d->stock;
        }
        $data['oil_detail_price'] = $oil_detail_price;
        $data['oil_details'] = $this->Adminpump_model->get_oil_detail_separate_price($location_id, $date);
   // echo $this->db->last_query();
   // die();
        if ($_GET['dub'] == 1) {
            echo "<pre>";
            echo $this->db->last_query();

            print_r($data);
            die();
        }
        $this->load->view('web/view_stock/update_view_stock', $data);
    }

function updatesetall($lid,$date){
	$lists = $this->Adminpump_model->get_tbl_list('sh_oil_daily_price',array('date'=>$date,"location_id"=>$lid),array('id','asc'));
	//echo "<pre>";
	$cdate = date('Y-m-d');
	//$cdate = '2019-06-10';
	$temp=$j=0;
	foreach($lists as $list){
		echo "<br>temp:".$temp."<br>";
		if($list->o_p_id == 278){
		//print_r($list);
		$stock = $list->stock;
		$changedate = $date;
		
		$finaloilselling = array();
		$oilselling = $this->Adminpump_model->get_tbl_list('shreadinghistory',array('PumpId'=>$list->o_p_id,"status"=>'1','Reading !='=>'0','date > '=>$changedate),array('id','asc'));
		//echo $this->db->last_query(); die();
		foreach ($oilselling as $selling){
			$finaloilselling[$selling->PumpId][$selling->date] = $selling->Reading;
		}
		$this->load->model('Daily_reports_model_new');
		$final_oil_inventory_Detail =array();
		$oil_inventory_Detail = $this->Adminpump_model->oil_inventory_Detail($lid, $changedate,$list->o_p_id);
		foreach($oil_inventory_Detail as $inoil){
			$final_oil_inventory_Detail[$inoil->id][$inoil->date] = $inoil->qty;
		}
		$changedate = date('Y-m-d', strtotime($changedate. ' +1 day'));
		//if($list->o_p_id=='268'){
			echo "<br><br>".$list->stock."<br><br>";
		for($i = $changedate ; strtotime($i) <= strtotime($cdate);$j++){
			
			echo "<br>No ".$j." ".$i." sell".$finaloilselling[$list->o_p_id][$i]." inv".$final_oil_inventory_Detail[$list->o_p_id][$i]."<br>";
			if($finaloilselling[$list->o_p_id][$i]){
				$stock = $stock-$finaloilselling[$list->o_p_id][$i];
			}
			if($final_oil_inventory_Detail[$list->o_p_id][$i]){
			$stock = $stock;
			}
			echo $stock."<br>";
			$update = $this->Adminpump_model->update_oil_stock($list->o_p_id, $i, array('stock'=>$stock));
			echo $this->db->last_query(); 
			$i = date('Y-m-d', strtotime($i. ' +1 day'));
			
		}
		//}
		//die();
	}
	$temp++;
	}
	
}

    function update_stock() {
		//echo "<pre>"; print_r($_POST);
		//echo "here"; die();
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', '4096M');
        $sdate = $this->uri->segment(4);
//        print_r($sdate);
//        die();
        $lid = $this->uri->segment(3);
        $date = date("Y-m-d", strtotime($sdate));
        $now = date("Y-m-d");
        $data['oil_details'] = $oil_details = $this->Adminpump_model->get_oil_detail_separate_price($lid, $date);
        //echo "<pre>"; print_r($this->input->post()); die();
        foreach ($oil_details as $oil) {
            $oil_stock = $this->input->post('oil_stock_' . $oil->pump_id);
            $old_oil_stock = $this->input->post('old_oil_stock_' . $oil->pump_id);
            $bay_price = $this->input->post('bay_price_' . $oil->pump_id); 
            $sel_price = $this->input->post('sel_price_' . $oil->pump_id);
            $dateDiff = $this->dateDiffInDays($date, $now);
            $new_stock = $oil_stock - $old_oil_stock;
            if ($dateDiff == 1) {
                $new_data = array("spacket_value" => $bay_price,
                    "packet_value" => $sel_price,
                    "stock" => $new_stock);
                $update = $this->Adminpump_model->update_main_stock($oil->pump_id, $new_data);
            }
			
            //if ($new_stock == 0) {
                $data2 = array("bay_price" => $bay_price,
                    "sel_price" => $sel_price);
                
                $update = $this->Adminpump_model->update_oil_stock_for_all($oil->pump_id, $date, $data2);
				$data2["stock"] = $oil_stock;
				
				$update = $this->Adminpump_model->update_oil_stock($oil->pump_id, $date, $data2);
				if($new_stock != 0){
					$update = $this->Adminpump_model->update_oil_daily_price($oil->pump_id, $new_stock, $bay_price, $sel_price, 	$date, $lid);
				}
				
                //  echo $this->db->last_query();
            //}
            //if ($new_stock != 0) {
//                for ($i = 0; $i <= $dateDiff; $i++) {
//
//                    $current_date = date('Y-m-d', strtotime($date . '+ ' . $i . ' days'));
////                print_r($current_date);
////                    echo "<br>";
////                print_r($date);
////                die();
//                    $update = $this->Adminpump_model->update_oil_daily_price($oil->pump_id, $new_stock, $bay_price, $sel_price, $current_date, $lid);
//                }

             //   $update = $this->Adminpump_model->update_oil_daily_price($oil->pump_id, $new_stock, $bay_price, $sel_price, $date, $lid);
                //$update = $this->Adminpump_model->update_oil_daily_price_all($oil->pump_id, $new_stock, $bay_price, $sel_price, $date, $lid);

              //  $update = $this->Adminpump_model->update_oil_daily_stock($oil->pump_id, $new_stock);
            //}
             
//            $update = $this->Adminpump_model->update_oil_daily_price_all($oil->pump_id, $new_stock, $bay_price, $sel_price, $date, $lid);
        }

//        die();
        redirect('oil_packet/view_stock/?lid='.$lid.'&date='.$sdate);
    }

    function dateDiffInDays($date1, $date2) {
        // Calulating the difference in timestamps 
        $diff = strtotime($date2) - strtotime($date1);

        // 1 day = 24 hours 
        // 24 * 60 * 60 = 86400 seconds 
        return abs(round($diff / 86400));
    }

    function get_data() {

        $lid = $this->input->post('lid');
        $sdate = $this->input->post('sdate');
        $this->load->model('Adminpump_model');
        $date = date("Y-m-d", strtotime($sdate));

        $oil_inventory = $this->Adminpump_model->master_fun_get_tbl_val("sh_oil_inventory_data_master", array("status" => 1, "date" => $date, "location_id" => $lid), array("date", "asc"));
        if (empty($oil_inventory)) {
            $oil_inventory = $this->Adminpump_model->master_fun_get_tbl_val("sh_oil_inventory_data_master", array("status" => 1, "date" => $date), array("date", "asc"));
        }
        $oil_details = $this->Adminpump_model->oil_view_details($oil_inventory[0]["id"]);

        if (!empty($oil_details)) {
            $oil_inventory[0]['oil_details'] = $oil_details;
        }
        die();
        if ($cnt == 0) {
            $html .= '<tr><td colspan="7">No Data avalieble</td></tr>';
        }
        $final = $finalpastdue + $finalcurrentdue;
        $html .= '<tr><td colspan="3">Total</td><td>' . number_format($test2, 2) . '</td><td>' . number_format($test1, 2) . '</td><td>' . number_format($finalpastdue, 2) . '</td><td>' . number_format($final, 2) . '</td></tr>';

        echo $html;
    }
    public function set_order_stock() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $sesid = $this->session->userdata('logged_company')['id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        } else {
            $sesid = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        }
        $id = $_SESSION['logged_company']['id'];
        $location_id= $this->input->get_post('location');
        $this->load->model('Adminpump_model');
        $data['order'] = $this->Adminpump_model->select_order_category_list($location_id,$id);
       // echo"<pre>"; print_r($data['order']); die();
        $this->load->view('web/oil_packet_order', $data);
    }
    function update_order(){
        $position = $this->input->post('position');
        $i=1;
        foreach($position as $k=>$v){
            $data = array(
                'order' => $i
            );
            $this->Adminpump_model->order_set($v, $data);
            $i++;
        }
        
    }
	function check_oil_stock(){
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
            $data['r'] = $this->admin_model->select_location($id1);
        } else {
            $u_id = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->get_location($u_id);
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
        $location_id = $this->input->get_post('lid');
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['l_id'] = $location_id;

        if ($location_id != "") {
			$data['startoilstock'] = $this->Adminpump_model->get_oil_active_list($location_id);
			$startoilstock = $this->Adminpump_model->get_oil_stock_selected_date(date('Y-m-d', strtotime($sdate. ' -1 day')),$location_id);
			$ssoil = array();
			foreach($startoilstock as $oilstock){
				$ssoil[$oilstock->id] = $oilstock->stock;
			}
			$data['ssoil'] = $ssoil;
			//echo $this->db->last_query();
			$allsellindoildata = $this->Adminpump_model->get_oil_slling_stock_date($sdate,$edate,$location_id);
			//echo $this->db->last_query(); die();	
			$oilsellingparday = array();
			foreach($allsellindoildata as $oilselling){
				$oilsellingparday[$oilselling->date][$oilselling->PumpId] = $oilselling->Reading;
				//$oilsellingparday[$oilselling->date][$oilselling->PumpId]['date'] = $oilselling->date;
			}
			$data['oilsellingparday'] = $oilsellingparday;
			$data['endoilstock'] = $this->Adminpump_model->get_oil_stock_selected_date($edate,$location_id);
			
		}
		//print_r($data['oilsellingparday']);
		$this->load->view('web/view_stock/check_oil_stock', $data);
	}
	function pdf_check_oil_stock() {
        $data["logged_company"] = $_SESSION['logged_company'];
        $location_id = $this->input->get_post('lid');
		$edate = $this->input->get_post('edate');
		$sdate = $this->input->get_post('sdate');
        
        if ($location_id != "") {
			 $data['sdate'] = $sdate;
        $data['edate'] = $edate;
			$this->load->model('Daily_reports_model_new_jun');
			$data['location_detail'] = $this->Daily_reports_model_new_jun->location_detail($location_id);
			//$data['startoilstock'] = $this->Adminpump_model->get_oil_stock_selected_date(date('Y-m-d', strtotime($sdate. ' -1 day')),$location_id);
			$data['startoilstock'] = $this->Adminpump_model->get_oil_active_list($location_id);
			$startoilstock = $this->Adminpump_model->get_oil_stock_selected_date(date('Y-m-d', strtotime($sdate. ' -1 day')),$location_id);
			$ssoil = array();
			foreach($startoilstock as $oilstock){
				$ssoil[$oilstock->id] = $oilstock->stock;
			}
			$data['ssoil'] = $ssoil;
			$allsellindoildata = $this->Adminpump_model->get_oil_slling_stock_date($sdate,$edate,$location_id);
			$oilsellingparday = array();
			foreach($allsellindoildata as $oilselling){
				$oilsellingparday[$oilselling->date][$oilselling->PumpId] = $oilselling->Reading;
			}
			$data['oilsellingparday'] = $oilsellingparday;
			$data['endoilstock'] = $this->Adminpump_model->get_oil_stock_selected_date($edate,$location_id);
			
		}
        $this->load->library('m_pdf');
        $html = $this->load->view('web/pdf_check_oil_stock', $data, true);
		//echo $html; die();
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
	public function copy_packets(){
		$oillist = $this->Adminpump_model->select_pumpby_location_id('38');
		echo $this->db->last_query();
		echo "<pre>";
		foreach($oillist as $list){
			if($list->type == 'O'){
				print_r($list);
				$inserArray = array(
				'name'=>$list->name,
				'type'=>$list->type,
				'stock'=>$list->stock,
				'location_id'=>'73',
				'company_id'=>$list->company_id,
				'packet_value'=>$list->packet_value,
				'spacket_value'=>$list->spacket_value,
				'p_qty'=>$list->p_qty,
				'new_p_qty'=>$list->new_p_qty,
				'packet_type'=>$list->packet_type,
				'created_at'=>Date('Y-m-d H:i:s'),
				'p_type'=>$list->p_type,
				'tank_id'=>$list->tank_id,
				'show'=>$list->show,
				'order'=>$list->order,
				'hide_date'=>$list->hide_date
				);
				//$this->db->insert('shpump', $inserArray);
				$newOil = $this->db->insert_id();
				$oilstock = $this->Adminpump_model->select_oilstock($list->id,'2020-06-18');
				if($oilstock){
					$insertOilArray = array(
					"o_p_id"=>$newOil,
					"date"=>"2020-06-18",
					"bay_price"=>$oilstock->bay_price,
					"sel_price"=>$oilstock->sel_price,
					"stock"=>$oilstock->stock,
					"packet_type"=>$oilstock->packet_type,
					"location_id"=>"73",
					"sel_dum"=>$oilstock->sel_dum,
					"buy_dum"=>$oilstock->buy_dum,
					);
				}else{
					$insertOilArray = array(
					"o_p_id"=>$newOil,
					"date"=>"2020-06-18",
					"bay_price"=>"0",
					"sel_price"=>"0",
					"stock"=>"0",
					"packet_type"=>"ml",
					"location_id"=>"73",
					"sel_dum"=>"0",
					"buy_dum"=>"0",
					);
				}
				//$this->db->insert('sh_oil_daily_price', $insertOilArray);
			}
		}
	}
}
?>