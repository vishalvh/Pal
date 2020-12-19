<?php

class Admin_expenses extends CI_Controller
{
	function index()
	{
		if ($_SESSION['logged_in'] == "") 
			{
            	redirect('login');
        	}
        	$data["logged_in"] = $_SESSION['logged_in'];
          
			$this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
			$this->load->view('Admin/admin_expenses');
            $this->load->view('Admin/footer');
	}

	public function ajax_list()
   	{
   		$this->load->model('Admin_expenses_model');
   		
       	$list = $this->Admin_expenses_model->get_datatables();
       	$data = array();
		$base_url = base_url();
       	$msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) 
       	{
       		$no++;
			$edit = "<a href='".$base_url."admin_expenses/edit/".$customers->id."' ><i class='fa fa-edit'></i></a>
			<a href='".$base_url."admin_expenses/delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			
           $row = array();
           $row[] = $no;
           $row[] = $customers->exps_name;
		   $row[] = $edit;
           $data[] = $row;
       
	}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->Admin_expenses_model->count_all(),
                       "recordsFiltered" => $this->Admin_expenses_model->count_filtered(),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }

   function add()   {
      if ($_SESSION['logged_in'] == "") 
      {
              redirect('login');
      }
		$data["logged_in"] = $_SESSION['logged_in'];
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav',$data);
		$this->load->view('Admin/admin_add_expenses',$data);
		$this->load->view('Admin/footer');
   }
	public function insert(){
		$this->form_validation->set_rules('name','Name','required');
		if($this->form_validation->run()){
			$data = array(
				'exps_id' =>'1',
				'exps_name' => $this->input->post('name')
				);
			$this->db->insert('sh_expensein_types',$data);
			$this->session->set_flashdata('success','Expenses Added Successfully..');
			redirect('admin_expenses');
		}else{
			$this->add();	
		}
	} 
	function delete(){
      $this->load->model('Admin_expenses_model');
      $id = $this->uri->segment('3');
      $data = array(
              'status' => '0'
            );
      $this->Admin_expenses_model->delete($id,$data);
	  
      $this->session->set_flashdata('fail','Expenses Deleted Successfully..');
      redirect('admin_expenses');
    }
}

?>