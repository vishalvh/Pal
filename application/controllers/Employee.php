<?php

class Employee extends CI_Controller
{
	function index(){
		if ($_SESSION['logged_in'] == "") 
		{
            	redirect('login');
		}
		$data["logged_in"] = $_SESSION['logged_in'];
		$this->load->model('emp_model');
		$data['company'] = $this->emp_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));
		$data['location'] = $this->emp_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 ));
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav',$data);
		$this->load->view('Admin/employeelist');
		$this->load->view('Admin/footer');
	}
	function edit($id){
		if ($_SESSION['logged_in'] == ""){
			redirect('login');
		}
		$data["logged_in"] = $_SESSION['logged_in'];
		$this->load->model('emp_model');
		
		
		$this->form_validation->set_rules('company','Company','required');
		$this->form_validation->set_rules('location','L`ocation','required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('mobile','Mobile','required');

		date_default_timezone_set('Asia/Kolkata');
		if($this->form_validation->run() == true)
		{
			$dataupd = array("company_id"=>$this->input->post('company'),
				"l_id"=>$this->input->post('location'),
				"UserFName"=>$this->input->post('name'),
				"UserMNumber"=>$this->input->post('mobile')
			);
			$this->emp_model->delete($id,$dataupd);
			$this->session->set_flashdata('success', "Record update successfully.");
			redirect('employee', 'refresh');
		}else{
			$data['empdetail'] = $this->emp_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1,'id'=>$id ));
			$data['company'] = $this->emp_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));
			$data['location'] = $this->emp_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1,'company_id'=>$data['empdetail'][0]['company_id'] ));
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav',$data);
			$this->load->view('Admin/employee_edit');
			$this->load->view('Admin/footer');
		}
	}
	public function ajax_list()   	{
		$this->load->model('emp_model');
   		$company = $this->input->get_post('company');
		$location = $this->input->get('location');
		$extra = $this->input->get('extra');
       	$list = $this->emp_model->get_datatables($extra,$company,$location);
       	$data = array();
		$base_url = base_url();
       	$no = $_POST['start'];
        $msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers)        	{
        	$no++;
			$edit = "  
			<a href='".$base_url."employee/edit/".$customers->id."'><i class='fa fa-edit'></i></a>
			<a href='".$base_url."employee/employee_delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			$name = $customers->UserFName;
			$name1 = ucfirst($name);
            $row = array();
            $row[] = $no;
            $row[] = $customers->name;
            $row[] = $customers->l_name;
            $row[] = $name1;
            $row[] = $customers->UserEmail;
            $row[] = $customers->UserMNumber;
            $row[] =  $edit;
            $data[] = $row;
		}
        $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->emp_model->count_all($extra),
                       "recordsFiltered" => $this->emp_model->count_filtered($extra),
                       "data" => $data,
               );
       echo json_encode($output);
   }
   function employee_delete()
    {
      $this->load->model('emp_model');
      $id = $this->uri->segment('3');
      $data = array(
              'status' => '0'
            );
      $this->emp_model->delete($id,$data);
      $this->session->set_flashdata('fail','Employee Deleted Successfully..');
      redirect('Employee');
    }
}
?>