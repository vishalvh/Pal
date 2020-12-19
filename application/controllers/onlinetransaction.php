<?php
class onlinetransaction extends CI_Controller
{
	function index()
	{
    $this->load->model('onlinetransaction_model');
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
    $c_id = $_SESSION['logged_company']['id'];
    $data['Employee'] = $this->onlinetransaction_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $c_id));
        
    $data['location'] = $this->onlinetransaction_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $c_id));

		$this->load->view('web/onlinetransaction_report',$data);
	}

	public function ajax_list()
   	{
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
   		$this->load->model('onlinetransaction_model');
      $employeename = $this->input->get('employeename');
      $fdate = $this->input->get('fdate');
      $tdate = $this->input->get('tdate');
      $location = $this->input->get('location');
   		$id = $_SESSION['logged_company']['id'];
      $current_date = date('Y-m-d');
		$extra = $this->input->get('extra');
    $list = $this->onlinetransaction_model->get_datatables($extra,$id,$employeename,$fdate,$tdate,$location,$current_date);
      
    $data = array();
		$base_url = base_url();
    $no = $_POST['start'];

    $msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) 
       	{
       		if ($customers->paid_by == 'n') 
          {
              $paid_by = "Cash";
          }
          if ($customers->paid_by == 'c') 
          {
              $paid_by = "Cheque";
          }

        	$no++;
			$edit = "<a href='".$base_url."onlinetransaction/onlinetransaction_info/".$customers->id." '><i class='fa fa-info'></i></a>  
			<a href='".$base_url."onlinetransaction/onlinetransaction_delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			// $name = $customers->UserFName;
			// $name1 = ucfirst($name);
           $row = array();
           $row[] = $no;

           // $row[] = $name1;
           $name1 = $customers->UserFName;
           $row[] = date('d-m-Y', strtotime($customers->date));
           $row[] = ucfirst($name1);
           $row[] = $customers->l_name;
           $row[] = $customers->invoice_no;
           $row[] = $customers->customer_name;
           $row[] = $customers->amount;
           $row[] = $paid_by; 
           $row[] = $customers->cheque_tras_no;
           $row[] =  $edit;
           $data[] = $row;
       
	}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->onlinetransaction_model->count_all($extra),
                       "recordsFiltered" => $this->onlinetransaction_model->count_filtered($extra),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }

   function onlinetransaction_info()
   {
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
      $this->load->model('onlinetransaction_model');
      $id = $this->uri->segment('3');
      $data['onlinetransaction'] = $this->onlinetransaction_model->onlinetransaction_info($id);
      $this->load->view('web/onlinetransaction_info',$data);
   }

   function onlinetransaction_delete()
   {
          if(!$this->session->userdata('logged_company'))
          {
            redirect('company_login');
          }
          $data["logged_company"] = $_SESSION['logged_company'];


          $this->load->model('onlinetransaction_model');
          $id = $this->uri->segment('3');
          $sess_id = $_SESSION['logged_company']['id'];
          $data = array(
                  
                  'status' => '0'
                );
          $this->onlinetransaction_model->delete($id,$data);

          $this->session->set_flashdata('fail','User Deleted Successfully..');
          redirect('onlinetransaction');
   }
}
?>