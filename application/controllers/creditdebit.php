<?php
class creditdebit extends CI_Controller
{
	function index()
	{
    $this->load->model('creditdebit_model');
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
    $c_id = $_SESSION['logged_company']['id'];
    $data['Employee'] = $this->creditdebit_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $c_id));
        
    $data['location'] = $this->creditdebit_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $c_id));

		$this->load->view('web/creditdebit_report',$data);
	}

	public function ajax_list()
   	{
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
   		$this->load->model('creditdebit_model');
      $employeename = $this->input->get('employeename');
      $fdate = $this->input->get('fdate');
      $tdate = $this->input->get('tdate');
      $location = $this->input->get('location');
   		$id = $_SESSION['logged_company']['id'];
      $current_date = date('Y-m-d');

		$extra = $this->input->get('extra');
    $list = $this->creditdebit_model->get_datatables($extra,$id,$employeename,$fdate,$tdate,$location,$current_date);
    
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

        	$no++;
			$edit = "<a href='".$base_url."creditdebit/creditdebit_info/".$customers->id." '><i class='fa fa-info'></i></a>  
			<a href='".$base_url."bank_deposit/bankdeposit_delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			// $name = $customers->UserFName;
			// $name1 = ucfirst($name);
           $row = array();
           $row[] = $no;

           // $row[] = $name1;
           $name1 = $customers->UserFName;
           $name2 = $customers->name;
           $row[] = date('d-m-Y', strtotime($customers->date));
           $row[] = ucfirst($name1);
           $row[] = $customers->l_name;
 		   $row[] = ucfirst($name2);
           $row[] = $customers->payment_type;
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
                       "recordsTotal" => $this->creditdebit_model->count_all($extra),
                       "recordsFiltered" => $this->creditdebit_model->count_filtered($extra),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }

   function creditdebit_info()
   {
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
      $this->load->model('creditdebit_model');
      $id = $this->uri->segment('3');
      $data['cd'] = $this->creditdebit_model->creditdebit_info($id);
      // echo $this->db->last_query();die();	
      $this->load->view('web/creditdebit_info',$data);
   }

   function creditdebit_delete()
   {
          if(!$this->session->userdata('logged_company'))
          {
            redirect('company_login');
          }
          $data["logged_company"] = $_SESSION['logged_company'];


          $this->load->model('creditdebit_model');
          $id = $this->uri->segment('3');
          $sess_id = $_SESSION['logged_company']['id'];
          $data = array(
                  
                  'status' => '0'
                );
          $this->creditdebit_model->delete($id,$data);
          $this->session->set_flashdata('fail','User Deleted Successfully..');
          redirect('creditdebit');
   }
}
?>