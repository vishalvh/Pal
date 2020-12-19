<?php
class Inventory extends CI_Controller
{
	function index()
	{
    $this->load->model('Inventory_model');
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
    $c_id = $_SESSION['logged_company']['id'];
    $data['Employee'] = $this->Inventory_model->master_fun_get_tbl_val1('shusermaster', array('status'=>1 , 'company_id'=> $c_id));
        
    $data['location'] = $this->Inventory_model->master_fun_get_tbl_val_location('sh_location', array('status'=>1 , 'company_id'=> $c_id));

		$this->load->view('web/inventory_report',$data);
	}

	public function ajax_list()
   	{
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
   		$this->load->model('Inventory_model');
      $employeename = $this->input->get('employeename');
      $fdate = $this->input->get('fdate');
      $tdate = $this->input->get('tdate');  
      $location = $this->input->get('location');
   		$id = $_SESSION['logged_company']['id'];
      $current_date = date('Y-m-d');
		$extra = $this->input->get('extra');
    $list = $this->Inventory_model->get_datatables($extra,$id,$employeename,$fdate,$tdate,$location,$current_date);
    // echo $this->db->last_query();   
    $data = array();
		$base_url = base_url();
    $no = $_POST['start'];

    $msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) 
       	{

        	$no++;
			$edit = "<a href='".$base_url."inventory/inventory_info/".$customers->id." '><i class='fa fa-info'></i></a>  
			<a href='".$base_url."index.php/Inventory/inventory_delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			// $name = $customers->UserFName;
			// $name1 = ucfirst($name);
           $row = array();
           $row[] = $no;

           // $row[] = $name1;
           $name1 = $customers->UserFName;
           $row[] = date('d-m-Y', strtotime($customers->date));
           $row[] = ucfirst($name1);
           $row[] = $customers->l_name;
           $row[] = $customers->pi_number;
           $row[] = $customers->p_fuelamount;
           $row[] = $customers->pv_taxamount;
           $row[] = $customers->p_paymenttype;
           $row[] = $customers->p_chequenumber;
           $row[] = $customers->p_paidamount;
           $row[] = $customers->p_quantity;
           $row[] = $customers->p_tankerreading;
           $row[] = $customers->di_number;
           $row[] = $customers->d_fuelamount;
           $row[] = $customers->dv_taxamount;
           $row[] = $customers->d_paymenttype;
           $row[] = $customers->d_chequenumber;
           $row[] = $customers->d_paidamount;
           $row[] = $customers->d_quantity;
           $row[] = $customers->d_tankerreading;
           $row[] = $customers->oil_type;
           $row[] = $customers->o_quantity;
           $row[] = $customers->oil_amount;
           $row[] =  $edit;
           $data[] = $row;
       
	}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->Inventory_model->count_all($extra),
                       "recordsFiltered" => $this->Inventory_model->count_filtered($extra),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }

   function inventory_info()
   {
    if(!$this->session->userdata('logged_company'))
    {
        redirect('company_login');
    }
    $data["logged_company"] = $_SESSION['logged_company'];
      $this->load->model('Inventory_model');
      $id = $this->uri->segment('3');
      $data['inventory'] = $this->Inventory_model->inventry_info($id);
      $this->load->view('web/inventory_info',$data);
   }

   function inventory_delete()
   {
          if(!$this->session->userdata('logged_company'))
          {
            redirect('company_login');
          }
          $data["logged_company"] = $_SESSION['logged_company'];


          $this->load->model('Inventory_model');
          $id = $this->uri->segment('3');
          $sess_id = $_SESSION['logged_company']['id'];
          $data = array(
                  
                  'status' => '0'
                );
          $this->Inventory_model->delete($id,$data);
          $this->session->set_flashdata('fail','User Deleted Successfully..');
          redirect('Inventory/index');
   }
}
?>