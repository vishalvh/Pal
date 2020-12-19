<?php
class Admin_workes extends CI_Controller
{
	function index()
	{
		if ($_SESSION['logged_in'] == "") 
			{
            	redirect('login');
        	}
        	$data["logged_in"] = $_SESSION['logged_in'];
			$this->load->model('admin_workers_model');
			$data['company'] = $this->admin_workers_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));
			$data['location'] = $this->admin_workers_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 ));
			$this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
			$this->load->view('Admin/admin_worker_list');
            $this->load->view('Admin/footer');
	}

	public function ajax_list()
   	{
   		$this->load->model('admin_workers_model');
   		$company = $this->input->get_post('company');
      $location = $this->input->get('location');

		$extra = $this->input->get('extra');
       	$list = $this->admin_workers_model->get_datatables($extra,$company,$location);
       	
       	$data = array();
		$base_url = base_url();
       	$no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) 
       	{
       		

        	$no++;
			$edit = "
			<a href='".$base_url."admin_workes/delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			$name = $customers->pumpname;
			$name1 = ucfirst($name);
           $row = array();
           $row[] = $no;
           $row[] = $customers->name;
           $row[] = $customers->l_name;
           $row[] = $name1;
           
           $row[] = $customers->mobile;
           $row[] =  $edit;
           $data[] = $row;
       
	}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->admin_workers_model->count_all($extra),
                       "recordsFiltered" => $this->admin_workers_model->count_filtered($extra),
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
          $this->load->model('admin_workers_model');
            $data['company'] = $this->admin_workers_model->get_company();
          $data["logged_in"] = $_SESSION['logged_in'];
      $this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
      $this->load->view('Admin/add_pump',$data);
            $this->load->view('Admin/footer');


   }
    function pump_delete()
    {
      $this->load->model('admin_workers_model');
      $id = $this->uri->segment('3');
      // $sess_id = $this->session->userdata('id');
      $data = array(
              'status' => '0'
            );
      $this->admin_workers_model->delete($id,$data);
      $this->session->set_flashdata('fail','Pump Deleted Successfully..');
      redirect('pumplist_admin');
    }
}

?>