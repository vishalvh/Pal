<?php

class Pumplist_admin extends CI_Controller
{
	function index()
	{
		if ($_SESSION['logged_in'] == "") 
			{
            	redirect('login');
        	}
        	$data["logged_in"] = $_SESSION['logged_in'];
          $this->load->model('pumplist_admin_model');
           $data['company'] = $this->pumplist_admin_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));
          $data['location'] = $this->pumplist_admin_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 ));
			$this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
			$this->load->view('Admin/pumplist');
            $this->load->view('Admin/footer');
	}

	public function ajax_list()
   	{
   		$this->load->model('Pumplist_admin_model');
   		$company = $this->input->get_post('company');
      $location = $this->input->get('location');

		$extra = $this->input->get('extra');
       	$list = $this->Pumplist_admin_model->get_datatables($extra,$company,$location);
       	
       	$data = array();
		$base_url = base_url();
       	$no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';	
		
       	foreach ($list as $customers) 
       	{$type = "";
       		if ($customers->type == "d") {
            $type = "Disel";
          }
          else if ($customers->type == "p") {
            $type = "Petrol";
          }

        	$no++;
			$edit = "<a href='".$base_url."Pumplist_admin/edit/".$customers->id."' ><i class='fa fa-edit'></i></a>
			<a href='".$base_url."Pumplist_admin/pump_delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			$name = $customers->pumpname;
			$name1 = ucfirst($name);
           $row = array();
           $row[] = $no;
           $row[] = $customers->name;
           $row[] = $customers->l_name;
           $row[] = $name1;
           
           $row[] = $type;
           $row[] =  $edit;
           $data[] = $row;
       
	}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->Pumplist_admin_model->count_all($extra),
                       "recordsFiltered" => $this->Pumplist_admin_model->count_filtered($extra),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }

   function add_pump()
   {
      if ($_SESSION['logged_in'] == "") 
      {
              redirect('login');
          }
          $this->load->model('Pumplist_admin_model');
            $data['company'] = $this->Pumplist_admin_model->get_company();
          $data["logged_in"] = $_SESSION['logged_in'];
      $this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
      $this->load->view('Admin/add_pump',$data);
            $this->load->view('Admin/footer');


   }
    function pump_delete()
    {
      $this->load->model('Pumplist_admin_model');
      $id = $this->uri->segment('3');
      // $sess_id = $this->session->userdata('id');
      $data = array(
              'status' => '0'
            );
      $this->Pumplist_admin_model->delete($id,$data);
      $this->session->set_flashdata('fail','Pump Deleted Successfully..');
      redirect('pumplist_admin');
    }
	function edit($id){
		if ($_SESSION['logged_in'] == ""){
			redirect('login');
		}
		$data["logged_in"] = $_SESSION['logged_in'];
		
		$this->load->model('Pumplist_admin_model');
		$this->form_validation->set_rules('company','Company','required');
		$this->form_validation->set_rules('location','Location','required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('type','type','required');
		date_default_timezone_set('Asia/Kolkata');
		if($this->form_validation->run() == true)
		{
			$dataupd = array("company_id"=>$this->input->post('company'),
				"location_id"=>$this->input->post('location'),
				"name"=>$this->input->post('name'),
				"type"=>$this->input->post('type')
			);
			$this->Pumplist_admin_model->delete($id,$dataupd);
			$this->session->set_flashdata('success', "Record update successfully.");
			redirect('pumplist_admin', 'refresh');
		}else{
			$data['pumpdetail'] = $this->Pumplist_admin_model->master_fun_get_tbl_val1('shpump', array('status'=>1,'id'=>$id ));
			$data['company'] = $this->Pumplist_admin_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));
			$data['location'] = $this->Pumplist_admin_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1,'company_id'=>$data['pumpdetail'][0]['company_id'] ));
			print_r($data['pumpdetail']); 
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav',$data);
			$this->load->view('Admin/pump_edit');
			$this->load->view('Admin/footer');
		}
	}
	
	}

?>