<?php
class Admin_readingreport extends CI_Controller
{
	function index()
	{
		if ($_SESSION['logged_in'] == "") 
			{
            	redirect('login');
      }
        $data["logged_in"] = $_SESSION['logged_in'];

        $c_id = $_SESSION['logged_in']['id'];
        $this->load->model('Admin_readingreport_model');
        $data['company'] = $this->Admin_readingreport_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));

        $data['Employee'] = $this->Admin_readingreport_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $c_id));
        
        $data['location'] = $this->Admin_readingreport_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $c_id));

			  $this->load->view('Admin/header',$data);
        $this->load->view('Admin/nav',$data);
			  $this->load->view('Admin/admin_readingreport',$data);
        $this->load->view('Admin/footer');

	}
  function location()
  {
    $cid = $this->input->get_post('cid');
    
        $this->load->model('Admin_readingreport_model');
    $location = $this->Admin_readingreport_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $cid));
    
    echo json_encode($location);
  }
  function employee()
  {
   $cid = $this->input->get_post('cid');
    
        $this->load->model('Admin_readingreport_model');
    $location = $this->Admin_readingreport_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $cid));
    
    echo json_encode($location); 
  }
  function loc_employee()
  {
   $lid = $this->input->get_post('lid');
    
    $this->load->model('Admin_readingreport_model');
    $location = $this->Admin_readingreport_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'l_id'=> $lid));
    
    echo json_encode($location); 
  }

	public function ajax_list()
   	{
   		$this->load->model('Admin_readingreport_model');
   		$company = $this->input->get_post('company');
      $employeename = $this->input->get('employeename');
      $fdate = $this->input->get('fdate');
      $tdate = $this->input->get('tdate');
      $location = $this->input->get('location');
      $id = $_SESSION['logged_in']['id'];
		  $extra = $this->input->get('extra');
      $list = $this->Admin_readingreport_model->get_datatables($extra,$fdate,$tdate,$company,$location,$employeename);
      $data = array();
		  $base_url = base_url();
      $no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) 
       	{
          if ($customers->shift == '1') 
            {
                $shift = "Day";
            }
            if ($customers->shift == '2') 
            {
                $shift = "Night";
            }
            if ($customers->shift == '3') 
            {
                $shift = "24 hours";
            }

        	$no++;
			$edit = "<a href='".$base_url."Admin_readingreport/reading_info/".$customers->id." '><i class='fa fa-info'></i></a>  
			<a href='".$base_url."Admin_readingreport/reading_delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			// $name = $customers->UserFName;
			// $name1 = ucfirst($name);
           $row = array();
           $row[] = $no;

           // $row[] = $name1;
           $row[] = date('d-m-Y', strtotime($customers->date));
           $row[] = $customers->name;
           $row[] = $customers->UserFName;
           $row[] = $customers->l_name;
           $row[] = $shift;
           $row[] = $customers->PatrolReading;
           $row[] = $customers->DieselReading;
           $row[] = $customers->meterReading;
           $row[] = $customers->TotalCash;
           $row[] = $customers->TotalCredit;
           $row[] = $customers->TotalExpenses;
           $row[] = $customers->TotalAmount;
           $row[] = $customers->disel_deep_reding;
           $row[] = $customers->petrol_deep_reding;
           $row[] =  $edit;
           $data[] = $row;
       
	}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->Admin_readingreport_model->count_all($extra),
                       "recordsFiltered" => $this->Admin_readingreport_model->count_filtered($extra),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }
   function reading_info()
   {
    if(!$this->session->userdata('logged_in'))
    {
        redirect('login');
    }
    $data["logged_in"] = $_SESSION['logged_in'];
    $company_id = $_SESSION["logged_in"]["id"];
      $this->load->model('Admin_readingreport_model');
      $id = $this->uri->segment('3');
      $data['query'] = $this->Admin_readingreport_model->reading_info($id);
      $data["details"] = $this->Admin_readingreport_model->shdailyreadingdetails_reading_list_details_id($id,$company_id);
      $this->load->view('Admin/header',$data);
      $this->load->view('Admin/nav',$data);
      $this->load->view('Admin/admin_readingreport_info');
      $this->load->view('Admin/footer');
   }
    function reading_delete()
   {
          if(!$this->session->userdata('logged_in'))
          {
            redirect('login');
          }
          $data["logged_in"] = $_SESSION['logged_in'];


          $this->load->model('Admin_readingreport_model');
          $id = $this->uri->segment('3');
          $sess_id = $_SESSION['logged_in']['id'];
          $data = array(
                  
                  'status' => '0'
                );
          $this->Admin_readingreport_model->delete($id,$data);
          
          $this->session->set_flashdata('fail','User Deleted Successfully..');
          $this->index();
   }
   public function exportCSV(){

     $this->load->model('Admin_readingreport_model');
     
    $company = $this->input->get_post('company');
    $employeename = $this->input->get_post('Employeename');
    $fdate = $this->input->get_post('date1');
    $tdate = $this->input->get_post('date2');
    $location = $this->input->get_post('location');

    $filename = 'reading_'.date('Ymd').'.csv';
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/csv; ");
    $usersData = $this->Admin_readingreport_model->exportCSV($fdate,$tdate,$company,$location,$employeename);
    

    $file = fopen('php://output', 'w');
    
    $header = array("Date","Company_name","Username","location","shift","Petrol_Reading","Disel_reading","Meter_Reading","Total_cash","Total_credit","Total_Expenses","Total_amount","disel_deep_reding","petrol_deep_reding");
    fputcsv($file, $header);
    foreach ($usersData as $key=>$line){
     fputcsv($file,$line);
    }
    fclose($file);
    exit;
    }
}
?>