<?php
class Admin_creditdebit extends CI_Controller
{
  function index()
  {
    if ($_SESSION['logged_in'] == "") 
      {
              redirect('login');
      }
        $data["logged_in"] = $_SESSION['logged_in'];

        $c_id = $_SESSION['logged_in']['id'];
        $this->load->model('Admin_creditdebit_model');
        $data['company'] = $this->Admin_creditdebit_model->master_fun_get_tbl_val1('sh_com_registration', array('status'=>1 ));

        $data['Employee'] = $this->Admin_creditdebit_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $c_id));
        
        $data['location'] = $this->Admin_creditdebit_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $c_id));

        $this->load->view('Admin/header',$data);
        $this->load->view('Admin/nav',$data);
        $this->load->view('Admin/admin_creditdebitreport',$data);
        $this->load->view('Admin/footer');

  }
  function location()
  {
    $cid = $this->input->get_post('cid');
    
        $this->load->model('Admin_creditdebit_model');
    $location = $this->Admin_creditdebit_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $cid));
    
    echo json_encode($location);
  }
  function employee()
  {
   $cid = $this->input->get_post('cid');
    
        $this->load->model('Admin_creditdebit_model');
    $location = $this->Admin_creditdebit_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $cid));
    
    echo json_encode($location); 
  }
  function loc_employee()
  {
   $lid = $this->input->get_post('lid');
    
    $this->load->model('Admin_creditdebit_model');
    $location = $this->Admin_creditdebit_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'l_id'=> $lid));
    
    echo json_encode($location); 
  }

  public function ajax_list()
    {
      $this->load->model('Admin_creditdebit_model');
      $company = $this->input->get_post('company');
      $employeename = $this->input->get('employeename');
      $fdate = $this->input->get('fdate');
      $tdate = $this->input->get('tdate');
      $location = $this->input->get('location');
      $id = $_SESSION['logged_in']['id'];
      $extra = $this->input->get('extra');
      $list = $this->Admin_creditdebit_model->get_datatables($extra,$fdate,$tdate,$company,$location,$employeename);
      $data = array();
      $base_url = base_url();
      $no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';  
        foreach ($list as $customers) 
        {
          if($customers->fuel_type == 'p')
          {
            $fuel_type = "Petrol";
          }
          if($customers->fuel_type == 'd')
          {
            $fuel_type = "Disel";
          }
          if($customers->fuel_type == 'o')
          {
            $fuel_type = "Oil";
          }
          if($customers->payment_type == 'c')
          {
            $payment_type = "Credit";
          }
          if($customers->payment_type == 'd')
          {
            $payment_type = "Debit";
          }
          

          $no++;
      $edit = "<a href='".$base_url."Admin_creditdebit/creditdebit_info/".$customers->id." '><i class='fa fa-info'></i></a>  
      <a href='".$base_url."Admin_creditdebit/creditdebit_delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
      // $name = $customers->UserFName;
      // $name1 = ucfirst($name);
           $row = array();
           $row[] = $no;

           // $row[] = $name1;
           $name1 = $customers->UserFName;
           $name2 = $customers->name;
           $row[] = date('d-m-Y', strtotime($customers->date));
           $row[] = $customers->company_name;
           $row[] = ucfirst($name1);
           $row[] = $customers->l_name;
           
           $row[] = ucfirst($name2);
           $row[] = $payment_type;
           $row[] = $customers->bill_no;
           $row[] = $customers->vehicle_no;
           $row[] = $fuel_type;
           $row[] = $customers->amount;
           $row[] = $customers->quantity;
           $row[] =  $edit;
           $data[] = $row;
       
  }
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->Admin_creditdebit_model->count_all($extra),
                       "recordsFiltered" => $this->Admin_creditdebit_model->count_filtered($extra),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }
   function creditdebit_info()
   {
    if(!$this->session->userdata('logged_in'))
    {
        redirect('login');
    }
    $data["logged_in"] = $_SESSION['logged_in'];
      $this->load->model('Admin_creditdebit_model');
      $id = $this->uri->segment('3');
      $data['cd'] = $this->Admin_creditdebit_model->creditdebit_info($id);
      $this->load->view('Admin/header',$data);
      $this->load->view('Admin/nav',$data);
      $this->load->view('Admin/admin_creditdebitreport_info');
      $this->load->view('Admin/footer');
   }
   function creditdebit_delete()
   {
          if(!$this->session->userdata('logged_in'))
          {
            redirect('login');
          }
          $data["logged_in"] = $_SESSION['logged_in'];


          $this->load->model('Admin_creditdebit_model');
          $id = $this->uri->segment('3');
          $sess_id = $_SESSION['logged_in']['id'];
          $data = array(
                  
                  'status' => '0'
                );
          $this->Admin_creditdebit_model->delete($id,$data);
          $this->session->set_flashdata('fail','User Deleted Successfully..');
          $this->index();
   }

   public function exportCSV(){
     $this->load->model('Admin_creditdebit_model');
     
    $company = $this->input->get_post('company');
    $employeename = $this->input->get_post('Employeename');
    $fdate = $this->input->get_post('date1');
    $tdate = $this->input->get_post('date2');
    $location = $this->input->get_post('location');

    $filename = 'creditdebit_'.date('Ymd').'.csv';
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/csv; ");
    $usersData = $this->Admin_creditdebit_model->exportCSV($fdate,$tdate,$company,$location,$employeename);
    $file = fopen('php://output', 'w');
    $header = array("Date","Company_name","Username","location","Customer_name","payment_type","bill_number","vehicle_number","fuel_type","Amount","quantity");
    fputcsv($file, $header);
    foreach ($usersData as $key=>$line){
     fputcsv($file,$line);
    }
    fclose($file);
    exit;
    }
}
?>