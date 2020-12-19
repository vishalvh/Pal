<?php
	class manage_customer extends CI_Controller
	{
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
		function index($id="")
		{
			if(!$this->session->userdata('logged_company'))
			{
            	redirect('company_login');
      		}
			$data['l_id'] = $id;
        	$data["logged_company"] = $_SESSION['logged_company'];
			$id1 =  $_SESSION['logged_company']['id'];
			$this->load->model('Manage_customer_model');
			$data['r'] = $this->data['all_location_list'];
			$this->load->view('web/customer',$data);
		}

		public function ajax_list()
   		{
		if(!$this->session->userdata('logged_company'))
		{
        	redirect('company_login');
  		}
    	$data["logged_company"] = $_SESSION['logged_company'];
   		
   		$this->load->model('Manage_customer_model');
   		$id = $_SESSION['logged_company']['id'];

		$extra = $this->input->get('extra');
       	$list = $this->Manage_customer_model->get_datatables($extra,$id);
//       	echo $this->db->last_query();
       	$data = array();
		$base_url = base_url();
       	$no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) 
       	{

        	$no++;
                if ($customers->show == 0) {
                $msg_s_h = "Show";
                $ac1 = " <a href='" . $base_url . "manage_customer/show/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'>Show</a>";
            } else {
                $msg_s_h = "Hide";
                $ac1 = " <a href='" . $base_url . "manage_customer/hide/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg_s_h . ");'>Hide</a>";
            }
			
			

			if ($customers->open_close == 1) {
                $msg_open = "Close";
                $ac2 = " <a href='" . $base_url . "manage_customer/close/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg_open . ");' data-toggle='tooltip' title='click to close'>Open</a>";
            } else {
                $msg_open = "Open";
                $ac2 = " <a href='" . $base_url . "manage_customer/open/" . $customers->id . "/" . $extra . "' onclick='return confirm(" . $msg_open . ");' data-toggle='tooltip' title='click to open'>Close</a>";
            }
			
			$edit = "<a href='".$base_url."manage_customer/customer_update/".$customers->id."/" . $extra . " '><i class='fa fa-edit'></i></a>  
			<a href='".$base_url."manage_customer/customer_delete/".$customers->id."/" . $extra . "' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>".$ac1."".$ac2;
			$name = $customers->name;
			$name1 = ucfirst($name);
           $row = array();
           $row[] = $no;
           $row[] = $name1;
           $row[] = $customers->address;
           $row[] = $customers->phone_no;
           $row[] = $customers->cheque_no;
           $row[] = $customers->bank_name;
           $row[] = $customers->personal_guarantor;
		   
		   if ($customers->active_status == 'Active') {
				$link = "#";
				$onclick = "";
				
				if($this->session->userdata('logged_company')['type'] == 'c'){
				$link = $base_url . "manage_customer/deactive/" . $customers->id . "/" . $extra;
                $msg_s_h = "Are you sure you want to Deactive?";
				$row[] = "<a class='btn btn-xs btn-warning' href='" . $link . "'>Active</a>";
				}else{
					$row[] = "<a class='btn btn-xs btn-warning' href='" . $link . "'>Active</a>";
				}
            } else {
				$link = "#";
				if($this->session->userdata('logged_company')['type'] == 'c'){
				$link = $base_url . "manage_customer/active/" . $customers->id . "/" . $extra;
                $msg_s_h = "Are you sure you want to Active?";
				$onclick = "onclick='return confirm(" . $msg_s_h . ");";
				}
                $row[] = "<a class='btn btn-xs btn-danger' href='" . $link . "'>Deactive</a>";
            }
		   
		   
			if($customers->block == 0){
				$row[] = '<a href = "'.$base_url.'manage_customer/unblock/'.$customers->id.'/'.$extra.'" class="btn btn-xs btn-danger">Block</a>';
			}else{
				$row[] = '<a href = "'.$base_url.'manage_customer/block/'.$customers->id.'/'.$extra.'" class="btn btn-xs btn-warning">UnBlock</a>';
			}
           //$row[] = $customers->l_name;
        if(in_array("customer_add",$this->data['user_permission_list'])){
                    	 $row[] = $edit;
                }
           $data[] = $row;
       
		}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->Manage_customer_model->count_all($extra,$id),
                       "recordsFiltered" => $this->Manage_customer_model->count_filtered($extra,$id),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }
   
   function open(){
	   if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
		
		 $this->load->model('Manage_customer_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'open_close' => '1'
        );
		
		
      $update = $this->Manage_customer_model->update($id,$data);

        $this->session->set_flashdata('fail', 'Now user open.');
        redirect('manage_customer/index/' . $this->uri->segment('4'));
		
   }
   function close(){
	   
	   if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];
		
		 $this->load->model('Manage_customer_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'open_close' => '0'
        );
		
		
      $update = $this->Manage_customer_model->update($id,$data);

        $this->session->set_flashdata('fail', 'Now user closed.');
        redirect('manage_customer/index/' . $this->uri->segment('4'));
		
   }
   
   function show() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Manage_customer_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'show' => '1'
        );
      $update = $this->Manage_customer_model->update($id,$data);

        $this->session->set_flashdata('fail', 'Now user can show in mobile.');
        redirect('manage_customer/index/' . $this->uri->segment('4'));
    }
    function hide() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Manage_customer_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'show' => '0'
        );
       $update = $this->Manage_customer_model->update($id,$data);
        $this->session->set_flashdata('fail', ' Now user not show in mobile.');
        redirect('manage_customer/index/' . $this->uri->segment('4'));
    }
	function active() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Manage_customer_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'active_status' => 'Active'
        );
       $update = $this->Manage_customer_model->update($id,$data);
        $this->session->set_flashdata('fail', 'Active user.');
        redirect('manage_customer/index/' . $this->uri->segment('4'));
    }
	function deactive() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Manage_customer_model');
        $id = $this->uri->segment('3');
        $lid = $this->uri->segment('4');

        $data = array(
            'active_status' => 'Deactive'
        );
       $update = $this->Manage_customer_model->update($id,$data);
        $this->session->set_flashdata('fail', 'Deactive user.');
        redirect('manage_customer/index/' . $this->uri->segment('4'));
    }

   	function add()
	{	
		if(!$this->session->userdata('logged_company'))
		{
        	redirect('company_login');
  		}
                  if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('manage_customer');
        }
    	$data["logged_company"] = $_SESSION['logged_company'];
		
		$id1 =  $_SESSION['logged_company']['id'];
		$this->load->model('Manage_customer_model');
		$data['r'] = $this->Manage_customer_model->select_location($id1);

		$this->load->view('web/add_customer',$data);

	}

	public function insert()
		{
		if(!$this->session->userdata('logged_company'))
		{
        	redirect('company_login');
  		}
                if ($this->session->userdata('logged_company')['type'] != 'c') {
           // redirect('manage_customer');
        }
    	$data["logged_company"] = $_SESSION['logged_company'];
			$this->form_validation->set_rules('username','customer name','required');
			$this->form_validation->set_rules('address','Address','required');
			$this->form_validation->set_rules('phone','Phone Number','required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('cheque','Cheque Number','required');
			$this->form_validation->set_rules('bank','Bank Name','required');
			$this->form_validation->set_rules('personal_guarantor','Personal Guarantor Name','required');
			$this->form_validation->set_rules('location','location','required');
			
			
			if($this->form_validation->run())
			{
				date_default_timezone_set('Asia/Kolkata');
				$data = array(
							
								
			 				'company_id' => $_SESSION['logged_company']['id'],
			 				'name' => $this->input->post('username'),
			 				'address' => $this->input->post('address'),
			 				'phone_no' => $this->input->post('phone'),
			 				'cheque_no' => $this->input->post('cheque'),
			 				'bank_name' => $this->input->post('bank'),
			 				'personal_guarantor' => $this->input->post('personal_guarantor'),
			 				'location_id' => $this->input->post('location'),
							'gst_number' => $this->input->post('gst_number'),
							'pan_number' => $this->input->post('pan_number'),
			 				'created_by' => date("Y-m-d H:i:sa")
			 			);
if($this->session->userdata('logged_company')['type'] != 'c'){
$data['active_status'] = 'Deactive';
}


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
                    redirect('manage_customer/add', 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $data['img'] = $data2["upload_data"]["file_name"];
                }
            }
			if (!empty($_FILES['panimg']['name'])) {

                $_FILES['file']['name'] = time() . $_FILES['panimg']['name'];
                $_FILES['file']['type'] = $_FILES['panimg']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['panimg']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['panimg']['error'];
                $_FILES['file']['size'] = $_FILES['panimg']['size'];
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['upload_path'] = './uploads/';
                $config['name'] = time() . $_FILES['panimg']['name'];
                $config['file_name'] = time() . $_FILES['panimg']['name'];
                $config['file_name'] = str_replace(' ', '_', $config['file_name']);
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('panimg')) {

                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('fail', $error);
                    redirect('manage_customer/add', 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $data['panimg'] = $data2["upload_data"]["file_name"];
                }
            }
			if (!empty($_FILES['gstimg']['name'])) {

                $_FILES['file']['name'] = time() . $_FILES['gstimg']['name'];
                $_FILES['file']['type'] = $_FILES['gstimg']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['gstimg']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['gstimg']['error'];
                $_FILES['file']['size'] = $_FILES['gstimg']['size'];
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['upload_path'] = './uploads/';
                $config['name'] = time() . $_FILES['gstimg']['name'];
                $config['file_name'] = time() . $_FILES['gstimg']['name'];
                $config['file_name'] = str_replace(' ', '_', $config['file_name']);
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('gstimg')) {

                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('fail', $error);
                    redirect('manage_customer/add', 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $data['gstimg'] = $data2["upload_data"]["file_name"];
                }
            }

			 	$this->db->insert('sh_userdetail',$data);
			 	$insert_id = $this->db->insert_id();
				//echo $this->db->last_query(); die;
				if($insert_id){
					if($this->input->post('contactpersonname1') != ''){
						$data = array(
			 				'cust_id' => $insert_id,
			 				'name' => $this->input->post('contactpersonname1'),
			 				'phone' => $this->input->post('contactpersonphone1'),
			 				'created_date' => date("Y-m-d H:i:s"),
							'created_by' => $_SESSION['logged_company']['id'],
							'status'=>'1'
			 			);
						$this->db->insert('sh_customer_contactperson',$data);
					}
					if($this->input->post('contactpersonname2') != ''){
						$data = array(
			 				'cust_id' => $insert_id,
			 				'name' => $this->input->post('contactpersonname2'),
			 				'phone' => $this->input->post('contactpersonphone2'),
			 				'created_date' => date("Y-m-d H:i:s"),
							'created_by' => $_SESSION['logged_company']['id'],
							'status'=>'1'
			 			);
						$this->db->insert('sh_customer_contactperson',$data);
					}
					
				}
			 	$this->session->set_flashdata('success','You Are Registers Successfully..');
			  
			 	redirect('manage_customer');
			}
			else
			{
				$this->add();	
			}

		}

		function customer_delete()
		{
		if(!$this->session->userdata('logged_company'))
		{
        	redirect('company_login');
  		}
                if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('manage_customer');
        }
        $lid = $this->uri->segment('4');
    	$data["logged_company"] = $_SESSION['logged_company'];
			$this->load->model('Manage_customer_model');
			$id = $this->uri->segment('3');
			$sess_id = $_SESSION['logged_company']['id'];
			$data = array(
							'status' => '0'
						);
			$this->Manage_customer_model->delete($id,$data);
			$this->session->set_flashdata('fail','User Deleted Successfully..');
			redirect('manage_customer/index/'.$lid);
		}

		function customer_update()
		{
		if(!$this->session->userdata('logged_company'))
		{
        	redirect('company_login');
  		}
                if ($this->session->userdata('logged_company')['type'] != 'c') {
            //redirect('manage_customer');
        }
$data["lid"] = $this->uri->segment('4');	
    	$data["logged_company"] = $_SESSION['logged_company'];
			$this->load->model('Manage_customer_model');
			$id = $this->input->post('id');
			
			$data["id"] = $this->uri->segment('3');		
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('address','Address','required');
			$this->form_validation->set_rules('phone','Phone Number','required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('cheque','Cheque Number','required');
			$this->form_validation->set_rules('bank','Bank Name','required');
			$this->form_validation->set_rules('personal_guarantor','Personal Guarantor Name','required');
			$this->form_validation->set_rules('location','location','required');
			date_default_timezone_set('Asia/Kolkata');
			if($this->form_validation->run() == true)
			{

						$data = array(
							
			 				'name' => $this->input->post('username'),
			 				'address' => $this->input->post('address'),
			 				'phone_no' => $this->input->post('phone'),
			 				'cheque_no' => $this->input->post('cheque'),
			 				'bank_name' => $this->input->post('bank'),
			 				'personal_guarantor' => $this->input->post('personal_guarantor'),
			 				'location_id' => $this->input->post('location'), 
							'gst_number' => $this->input->post('gst_number'),
							'pan_number' => $this->input->post('pan_number'),
			 				'update_at' => date('Y-m-d H:i:sa')

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
                    redirect('manage_customer/customer_update/'.$id, 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $data['img'] = $data2["upload_data"]["file_name"];
                }
            }
			if (!empty($_FILES['panimg']['name'])) {

                $_FILES['file']['name'] = time() . $_FILES['panimg']['name'];
                $_FILES['file']['type'] = $_FILES['panimg']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['panimg']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['panimg']['error'];
                $_FILES['file']['size'] = $_FILES['panimg']['size'];
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['upload_path'] = './uploads/';
                $config['name'] = time() . $_FILES['panimg']['name'];
                $config['file_name'] = time() . $_FILES['panimg']['name'];
                $config['file_name'] = str_replace(' ', '_', $config['file_name']);
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('panimg')) {

                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('fail', $error);
                     redirect('manage_customer/customer_update/'.$id, 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $data['panimg'] = $data2["upload_data"]["file_name"];
                }
            }
			if (!empty($_FILES['gstimg']['name'])) {

                $_FILES['file']['name'] = time() . $_FILES['gstimg']['name'];
                $_FILES['file']['type'] = $_FILES['gstimg']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['gstimg']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['gstimg']['error'];
                $_FILES['file']['size'] = $_FILES['gstimg']['size'];
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['upload_path'] = './uploads/';
                $config['name'] = time() . $_FILES['gstimg']['name'];
                $config['file_name'] = time() . $_FILES['gstimg']['name'];
                $config['file_name'] = str_replace(' ', '_', $config['file_name']);
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('gstimg')) {

                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('fail', $error);
                     redirect('manage_customer/customer_update/'.$id, 'refresh');
                } else {

                    $data2 = array('upload_data' => $this->upload->data());
                    $data['gstimg'] = $data2["upload_data"]["file_name"];
                }
            }
				$update = $this->Manage_customer_model->update($id,$data);
				
				$update = $this->Manage_customer_model->update_contactperson_by_customer_id($id,array('status'=>'0'));
				if($this->input->post('contactpersonname1') != ''){
						$data = array(
			 				'cust_id' => $id,
			 				'name' => $this->input->post('contactpersonname1'),
			 				'phone' => $this->input->post('contactpersonphone1'),
			 				'created_date' => date("Y-m-d H:i:s"),
							'created_by' => $_SESSION['logged_company']['id'],
							'status'=>'1'
			 			);
						$this->db->insert('sh_customer_contactperson',$data);
					}
					if($this->input->post('contactpersonname2') != ''){
						$data = array(
			 				'cust_id' => $id,
			 				'name' => $this->input->post('contactpersonname2'),
			 				'phone' => $this->input->post('contactpersonphone2'),
			 				'created_date' => date("Y-m-d H:i:s"),
							'created_by' => $_SESSION['logged_company']['id'],
							'status'=>'1'
			 			);
						$this->db->insert('sh_customer_contactperson',$data);
					}
				
				
				
				$this->session->set_flashdata('success_update','User Data Updated Successfully..');
				redirect('manage_customer/index/'.$this->uri->segment('4'));
			}
			else
			{
				
			$id = $this->uri->segment('3');
			if($id == "")
			{
				$id = $this->input->post('id');
			}
			$query = $this->db->get_where("sh_userdetail",array("id"=>$id));
			$data['r'] = $query->result();
			$query = $this->db->get_where("sh_customer_contactperson",array("cust_id"=>$id,'status'=>'1'));
			$data['contactperson'] = $query->result();
			

			$this->load->model('Manage_customer_model');
			$id1 = $_SESSION['logged_company']['id'];
			$data['r1'] = $this->data['all_location_list'];
			
			$this->load->view('web/edit_customer',$data);
			}
		}
		function block($id,$lid=""){
			$this->load->model('Manage_customer_model');
			$update = $this->Manage_customer_model->update($id,array('block'=>'0'));
				$this->session->set_flashdata('success_update','User is block Successfully..');
				redirect('manage_customer/index/'.$lid);
		}
		function unblock($id,$lid=""){
			$this->load->model('Manage_customer_model');
			$update = $this->Manage_customer_model->update($id,array('block'=>'1'));
				$this->session->set_flashdata('success_update','User is unblock Successfully..');
				redirect('manage_customer/index/'.$lid);
		}
}
?>