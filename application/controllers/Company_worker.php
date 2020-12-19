<?php

class Company_worker extends CI_Controller {

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
        }
    }

    function index() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->database();
        $this->load->model('company_worker_model');
        $this->load->model('admin_model');
        if ($this->session->userdata('logged_company')['type'] == 'c') {
            $sesid = $this->session->userdata('logged_company')['id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        } else {
            $sesid = $this->session->userdata('logged_company')['u_id'];
            $data['r'] = $this->admin_model->select_location($sesid);
        }
        //$data['h'] = $this->company_worker_model->select();
        $this->load->view('web/company_worker_list', $data);
    }

    function add() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
           // redirect('company_worker');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('company_worker_model');
        $data['r'] = $this->company_worker_model->select_location($id1);

        $this->load->view('web/company_worker_add', $data);
    }

    public function insert() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
           // redirect('company_worker');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->form_validation->set_rules('name', 'Username', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile Numner', 'required');

        if ($this->form_validation->run()) {
			
			
			
			
			

            date_default_timezone_set('Asia/Kolkata');
            $data = array(
                'location_id' => $this->input->post('sel_loc'),
                'company_id' => $_SESSION['logged_company']['id'],
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'adhar_no' => $this->input->post('adharnumber'),
                'mobile' => $this->input->post('mobile'),
                'created_at' => date("Y-m-d H:i:sa"),
                'shift' => $this->input->post('shift'),
                'salary' => $this->input->post('salary'),
                'extra_salary' => $this->input->post('extra_salary'),
                'code' => $this->input->post('code'),
				'join_date' => date('Y-m-d',strtotime($this->input->post('joindate')))
            );
			
			if (!empty($_FILES['img']['name'])) {

                $_FILES['file']['name'] = time() . $_FILES['img']['name'];
                $_FILES['file']['type'] = $_FILES['img']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['img']['error'];
                $_FILES['file']['size'] = $_FILES['img']['size'];
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['upload_path'] = './uploads/';
                $config['name'] = time() . $_FILES['img']['name'];
                $config['file_name'] = time() . $_FILES['img']['name'];
                $config['file_name'] = str_replace(' ', '_', $config['file_name']);
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('img')) {

                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('fail', $error);
                    redirect('company_worker/add', 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $data['img'] = $data2["upload_data"]["file_name"];
                }
            }
			//echo "<pre>"; print_r($data);  die();
            $this->db->insert('sh_workers', $data);
			$worker_id = $this->db->insert_id();
			
			
			
			
			
			
			$time1  = strtotime(date('Y-m-d',strtotime($this->input->post('joindate'))));
		   $time2  = strtotime(date('Y-m-d'));
			   $my     = date('mY', $time2);

			   $months = array(date('Y-m-d', $time1));
			   $f      = '';

			   while($time1 < $time2) {
				  $time1 = strtotime((date('Y-m-d', $time1).' +15days'));
				  if(date('m', $time1) != $f) {
					 $f = date('m', $time1);
					 if(date('mY', $time1) != $my && ($time1 < $time2))
						$months[] = date('Y-m-d', $time1);
				  }
			   }

			   $months[] = date('Y-m-d', $time2);
   
   
   
			
			for($i = 0 ; $i<count($months); $i++){
				$year = date('Y',strtotime($months[$i]));
				$month = date('m',strtotime($months[$i]));
				
				$this->db->insert('sh_workers_monthly_salary',array('workers_id'=>$worker_id,'month'=>$month,'year'=>$year,'salary'=>$this->input->post('salary')));
			
			} 
			
			
			
			
			//$this->db->insert('sh_workers_monthly_salary',array('workers_id'=>$worker_id,'month'=>date('m'),'year'=>date('Y'),'salary'=>$this->input->post('salary')));
//echo $this->db->last_query(); die();			 	
            $this->session->set_flashdata('success', 'Worker Add Successfully..');

            redirect('company_worker');
        } else {
            $this->add();
        }
    }

    public function ajax_list() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('company_worker_model');
        $id = $_SESSION['logged_company']['id'];

        $extra = $this->input->get('extra');
        $list = $this->company_worker_model->get_datatables($id, $extra);

        $data = array();
        $base_url = base_url();
        $no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';
        foreach ($list as $customers) {
            if ($customers->shift == 1) {
                $shift = "Day";
            }
            if ($customers->shift == 2) {
                $shift = "Night";
            }
            if ($customers->shift == 3) {
                $shift = "24 hours";
            }

            if ($customers->active == 0) {
                $msga = "Active";
                $ac = " <a href='" . $base_url . "company_worker/user_active/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msga . ");'><i class='fa fa-toggle-on' aria-hidden='true'></i>Active</a>";
            } else {
                $msga = "Deactive";
                $ac = " <a href='" . $base_url . "company_worker/user_deactive/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msga . ");'><i class='fa fa-toggle-off' aria-hidden='true'></i>Deactive</a>";
            }
            if ($customers->show == 0) {
                $msg_s_h = "Show";
                $ac1 = " <a href='" . $base_url . "company_worker/user_show/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'><i class='fa fa-toggle-on' aria-hidden='true'></i>Show</a>";
            } else {
                $msg_s_h = "Hide";
                $ac1 = " <a href='" . $base_url . "company_worker/user_hide/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'><i class='fa fa-toggle-off' aria-hidden='true'></i>Hide</a>";
            }
            $no++;
            $edit = "<a href='" . $base_url . "company_worker/update/" . $customers->id . "/" . $extra . "'><i class='fa fa-edit'></i></a>  
			<a href='" . $base_url . "company_worker/delete/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg . ");'><i class='fa fa-trash-o'></i></a> $ac" . $ac1 . " <a href='" . $base_url . "company_worker/printid/" . $customers->id . "'>print</a> ";

            $row = array();
            $row[] = $no;
            $row[] = $customers->code;
            $row[] = $customers->name;
            $row[] = $customers->mobile;
            $row[] = $customers->l_name;
            $row[] = $shift;
            if(in_array("worker_action",$this->data['user_permission_list'])){
                $row[] = $edit;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->company_worker_model->count_all($id, $extra),
            "recordsFiltered" => $this->company_worker_model->count_filtered($id, $extra),
            "data" => $data,
        );

        echo json_encode($output);
    }

    // update profile for admin 
    function user_show() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('company_worker_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'show' => '1'
        );
        $this->company_worker_model->delete($id, $data);

        $this->session->set_flashdata('fail', 'Now user can show in mobile.');
        redirect('company_worker/index/' . $this->uri->segment('4'));
    }

    function user_hide() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('company_worker_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'show' => '0'
        );
        $this->company_worker_model->delete($id, $data);
        $this->session->set_flashdata('fail', ' Now user not show in mobile.');
        redirect('company_worker/index/' . $this->uri->segment('4'));
    }
    function user_active() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('company_worker_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'Active' => '1'
        );
        $this->company_worker_model->delete($id, $data);

        $this->session->set_flashdata('fail', 'User Active Successfully.');
        redirect('company_worker/index/' . $this->uri->segment('4'));
    }

    function user_deactive() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('company_worker_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'Active' => '0'
        );
        $this->company_worker_model->delete($id, $data);
        $this->session->set_flashdata('fail', 'User Deactive Successfully.');
        redirect('company_worker/index/' . $this->uri->segment('4'));
    }

    function update($id) {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        } if ($this->session->userdata('logged_company')['type'] != 'c') {
           // redirect('company_worker');
        }

        $data["lid"] = $this->uri->segment('4');
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('company_worker_model');
        $this->form_validation->set_rules('name', 'Username', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile Numner', 'required');

        date_default_timezone_set('Asia/Kolkata');
        if ($this->form_validation->run() == true) {
            $data = array(
                'location_id' => $this->input->post('sel_loc'),
                'company_id' => $_SESSION['logged_company']['id'],
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'adhar_no' => $this->input->post('adharnumber'),
                'mobile' => $this->input->post('mobile'),
                'created_at' => date("Y-m-d H:i:sa"),
                'shift' => $this->input->post('shift'),
                'salary' => $this->input->post('salary'),
                'extra_salary' => $this->input->post('extra_salary'),
                'code' => $this->input->post('code'),
				'join_date' => date('Y-m-d',strtotime($this->input->post('joindate')))
            );

if (!empty($_FILES['img']['name'])) {

                $_FILES['file']['name'] = time() . $_FILES['img']['name'];
                $_FILES['file']['type'] = $_FILES['img']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['img']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['img']['error'];
                $_FILES['file']['size'] = $_FILES['img']['size'];
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['upload_path'] = './uploads/';
                $config['name'] = time() . $_FILES['img']['name'];
                $config['file_name'] = time() . $_FILES['img']['name'];
                $config['file_name'] = str_replace(' ', '_', $config['file_name']);
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('img')) {

                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('fail', $error);
                    redirect('company_worker/add', 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $data['img'] = $data2["upload_data"]["file_name"];
                }
            }
            $update = $this->company_worker_model->update($id, $data);
            // echo $this->db->last_query();die();
            if ($update) {
                $this->session->set_userdata('logged_company', $data);
            }
            $this->session->set_flashdata('success', 'Detail Updated Successfully..');
            redirect('company_worker/index/' . $this->uri->segment('4'));
        } else {
            $data['detail'] = $this->company_worker_model->select($id);
            $id1 = $_SESSION['logged_company']['id'];
            $data['r'] = $this->company_worker_model->select_location($id1);
            $this->load->view('web/company_worker_edit', $data);
        }
    }

    function delete($id) {

        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
           // redirect('company_worker');
        }
        $lid = $this->uri->segment('4');
        $this->load->model('company_worker_model');
        $data = array('status' => '0');
        $update = $this->company_worker_model->update($id, $data);
        $this->session->set_flashdata('success', 'Worker Delete Successfully..');
        redirect('company_worker/index/' . $this->uri->segment('4'));
    }
	function printid($id){
		$this->load->model('company_worker_model');
		$data['detail'] = $this->company_worker_model->select($id);
		
		$data['locationdetail'] = $this->company_worker_model->select_one_by_id($data['detail']->location_id);
		$data['locationwallat'] = $this->company_worker_model->select_location_wallet($data['detail']->location_id);
		//echo "<pre>"; print_r($data['detail']); die();
		$this->load->library('m_pdf');
        $html = $this->load->view('web/pdfworkerprintid', $data, true);
		//echo $html; die();
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
	function selectall(){
		$this->load->model('company_worker_model');
		$workers = $this->company_worker_model->selectall();
		echo "<pre>";
		foreach($workers as $workr){
			$workerjoindate = date('Y-m-d',strtotime($workr->join_date));
			$curnetdate = date('Y-m-d');
			for($i=strtotime($workerjoindate);strtotime($workerjoindate)<=strtotime($curnetdate);$workerjoindate=date("Y-m-d",strtotime(date("Y-m-d", strtotime($workerjoindate)) . " +1 month"))){
				echo $workerjoindate."<br>"; 
				//$this->db->insert('sh_workers_monthly_salary',array('workers_id'=>$workr->id,'month'=>date('m',strtotime($workerjoindate)),'year'=>date('Y',strtotime($workerjoindate)),'salary'=>$workr->salary));
			}
		}
	}
	
	function view_salary(){
		if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        if ($this->session->userdata('logged_company')['type'] != 'c') {
           // redirect('company_worker');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $id1 = $_SESSION['logged_company']['id'];
        $this->load->model('company_worker_model');
        $data['r'] = $this->company_worker_model->select_location($id1);
		$data['l_id'] = $this->input->get('lid');
		$data['date'] = date('Y-m').'-1';
		if($this->input->get('date')){
			$data['date'] = date('Y-m-d',strtotime($this->input->get('date')));
			
			
		}
		if($this->input->get('lid')){
			$month = date('n',strtotime($data['date']));
			$year = date('Y',strtotime($data['date']));
			$data['salarylist'] = $this->company_worker_model->worker_monthly_salary($month,$year,$data['l_id']);
		}
        $this->load->view('web/company_worker_salary_monthly', $data);
	}
	function update_salary(){
		$this->load->model('company_worker_model');
		$alldata = $this->input->post('worker_salary');
		foreach($alldata as $key=>$value){
		//	echo $key ."=>".$value."<br>";
			$update = $this->company_worker_model->update_worker_salary($key,'sh_workers_monthly_salary',array('salary'=>$value));
		}
		$lid = $this->uri->segment('3');
        $date = date('d-m-Y',strtotime($this->uri->segment('4')));
		$this->session->set_flashdata('success', 'Worker Salary update Successfully..');
        redirect('company_worker/view_salary?lid='.$lid.'&date='.$date);
	}
}

?>