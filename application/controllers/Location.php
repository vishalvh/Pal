<?php

class Location extends CI_Controller
{
	function index()
	{
		if ($_SESSION['logged_in'] == "") 
			{
            	redirect('login');
        	}
        	$data["logged_in"] = $_SESSION['logged_in'];
          $this->load->model('Location_model');
          $data['company'] = $this->Location_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));
			$this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
			$this->load->view('Admin/location_list');
            $this->load->view('Admin/footer');
	}
	public function edit($id){
		if ($_SESSION['logged_in'] == ""){
			redirect('login');
		}
		$data["logged_in"] = $_SESSION['logged_in'];
		
		$this->load->model('Location_model');
		$this->form_validation->set_rules('company','Company','required');
		$this->form_validation->set_rules('name','Location','required');
		if($this->form_validation->run() == true)
		{
			$dataupd = array("company_id"=>$this->input->post('company'),
				"l_name"=>$this->input->post('name')
			);
			$this->Location_model->delete($id,$dataupd);
			$this->session->set_flashdata('success', "Record update successfully.");
			redirect('location', 'refresh');
		}else{
			$data['company'] = $this->Location_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));
			$data['locationdetail'] = $this->Location_model->master_fun_get_tbl_val1('sh_location', array('status'=>1,'l_id'=>$id ));
			print_r($data['locationdetail']);
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav',$data);
			$this->load->view('Admin/location_edit');
			$this->load->view('Admin/footer');
		}
	}
	public function ajax_list()
   	{
   		$this->load->model('Location_model');
      $company = $this->input->get_post('company');
   		// $id = $this->session->userdata('id');

		$extra = $this->input->get('extra');
       	$list = $this->Location_model->get_datatables($extra,$company);
       	
       	$data = array();
		$base_url = base_url();
       	$no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) 
       	{
       		$no++;
			$edit = "<a href='".$base_url."Location/edit/".$customers->l_id."' ><i class='fa fa-edit'></i></a>
			<a href='".$base_url."Location/location_delete/".$customers->l_id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			
           $row = array();
           $row[] = $no;
           $row[] = $customers->name;
           $row[] = $customers->l_name;
           $row[] =  $edit;
           $data[] = $row;
       
	}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->Location_model->count_all($extra),
                       "recordsFiltered" => $this->Location_model->count_filtered($extra),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }

       function location_delete()
    {
      $this->load->model('Location_model');
      $id = $this->uri->segment('3');
      $data = array(
              'status' => '0'
            );
      $this->Location_model->delete($id,$data);	
      $this->session->set_flashdata('fail','location Deleted Successfully..');
      redirect('location');
    }
}

?>