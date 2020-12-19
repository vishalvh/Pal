<?php
class Admin_onlinetransaction extends CI_Controller
{
	function index()
	{
		if ($_SESSION['logged_in'] == "") 
			{
            	redirect('login');
      }
        $data["logged_in"] = $_SESSION['logged_in'];

        $c_id = $_SESSION['logged_in']['id'];
        $this->load->model('Admin_onlinetransaction_model');
        $data['company'] = $this->Admin_onlinetransaction_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));

        $data['Employee'] = $this->Admin_onlinetransaction_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $c_id));
        
        $data['location'] = $this->Admin_onlinetransaction_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $c_id));

			  $this->load->view('Admin/header',$data);
        $this->load->view('Admin/nav',$data);
			  $this->load->view('Admin/admin_onlinetransactionreport',$data);
        $this->load->view('Admin/footer');

	}
  function location()
  {
    $cid = $this->input->get_post('cid');
    
        $this->load->model('Admin_onlinetransaction_model');
    $location = $this->Admin_onlinetransaction_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $cid));
    
    echo json_encode($location);
  }
  function employee()
  {
   $cid = $this->input->get_post('cid');
    
        $this->load->model('Admin_onlinetransaction_model');
    $location = $this->Admin_onlinetransaction_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $cid));
    
    echo json_encode($location); 
  }
  function loc_employee()
  {
   $lid = $this->input->get_post('lid');
    
    $this->load->model('Admin_onlinetransaction_model');
    $location = $this->Admin_onlinetransaction_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'l_id'=> $lid));
    
    echo json_encode($location); 
  }

	public function ajax_list()
   	{
   		$this->load->model('Admin_onlinetransaction_model');
   		$company = $this->input->get_post('company');
      $employeename = $this->input->get('employeename');
      $fdate = $this->input->get('fdate');
      $tdate = $this->input->get('tdate');
      $location = $this->input->get('location');
      $id = $_SESSION['logged_in']['id'];
		  $extra = $this->input->get('extra');
      $list = $this->Admin_onlinetransaction_model->get_datatables($extra,$fdate,$tdate,$company,$location,$employeename);

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
			$edit = "<a href='".$base_url."Admin_onlinetransaction/onlinetransaction_info/".$customers->id." '><i class='fa fa-info'></i></a>  
			<a href='".$base_url."Admin_onlinetransaction/onlinetransaction_delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			// $name = $customers->UserFName;
			// $name1 = ucfirst($name);
           $row = array();
           $row[] = $no;

           // $row[] = $name1;
           $row[] = date('d-m-Y', strtotime($customers->date));
           $row[] = $customers->name;
           $row[] = $customers->UserFName;
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
                       "recordsTotal" => $this->Admin_onlinetransaction_model->count_all($extra),
                       "recordsFiltered" => $this->Admin_onlinetransaction_model->count_filtered($extra),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }
   function onlinetransaction_info()
   {
    if(!$this->session->userdata('logged_in'))
    {
        redirect('login');
    }
    $data["logged_in"] = $_SESSION['logged_in'];
      $this->load->model('Admin_onlinetransaction_model');
      $id = $this->uri->segment('3');
      $data['onlinetransaction'] = $this->Admin_onlinetransaction_model->onlinetransaction_info($id);
      $this->load->view('Admin/header',$data);
      $this->load->view('Admin/nav',$data);
      $this->load->view('Admin/admin_onlinetransactionreport_info');
      $this->load->view('Admin/footer');
   }
   function onlinetransaction_delete()
   {
          if(!$this->session->userdata('logged_in'))
          {
            redirect('login');
          }
          $data["logged_in"] = $_SESSION['logged_in'];


          $this->load->model('Admin_onlinetransaction_model');
          $id = $this->uri->segment('3');
          $sess_id = $_SESSION['logged_in']['id'];
          $data = array(
                  
                  'status' => '0'
                );
          $this->Admin_onlinetransaction_model->delete($id,$data);
          $this->session->set_flashdata('fail','User Deleted Successfully..');
          $this->index();
   }

   public function exportCSV(){
     $this->load->model('Admin_onlinetransaction_model');

    $company = $this->input->get_post('company');
    $employeename = $this->input->get_post('Employeename');
    $fdate = $this->input->get_post('date1');
    $tdate = $this->input->get_post('date2');
    $location = $this->input->get_post('location');

    $filename = 'onlinetransaction_'.date('Ymd').'.csv';
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/csv; ");
    $usersData = $this->Admin_onlinetransaction_model->exportCSV($fdate,$tdate,$company,$location,$employeename);
    $file = fopen('php://output', 'w');
    $header = array("Date","Company_name","Username","location","Invoice_Number","Customer_name","Amount","Paid_by","Cheque_Transaction_number");
    fputcsv($file, $header);
    foreach ($usersData as $key=>$line){
     fputcsv($file,$line);
    }
    fclose($file);
    exit;
    }
}
?>