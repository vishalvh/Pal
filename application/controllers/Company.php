<?php

class company extends CI_Controller
{
	
	function company_list()
	{
			if ($_SESSION['logged_in'] == "") 
			{
            	redirect('login');
        	}
        	$data["logged_in"] = $_SESSION['logged_in'];
			$this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
			$this->load->view('Admin/company_list');
            $this->load->view('Admin/footer');
	}
	// view data of company ajax
	public function ajax_list()
   	{
   		$this->load->model('Company_model');
   		$id = $this->session->userdata('id');

		$extra = $this->input->get('extra');
       	$list = $this->Company_model->get_datatables($extra,$id);
       	
       	$data = array();
		$base_url = base_url();
       	$no = $_POST['start'];

        $msg = '"Are you sure you want to remove this data?"';	
       	foreach ($list as $customers) 
       	{

        	$no++;
			$edit = "<a href='".$base_url."Company/company_update/".$customers->id." '><i class='fa fa-edit'></i></a>  
			<a href='".$base_url."Company/company_delete/".$customers->id."' onclick='return confirm(".$msg.");'><i class='fa fa-trash-o'></i></a>";
			$name = $customers->name;
			$name1 = ucfirst($name);
           $row = array();
           $row[] = $no;
           $row[] = $name1;
           $row[] = $customers->email;
           $row[] = $customers->mobile;
           
           $row[] =  $edit;
           $data[] = $row;
       
	}
       $output = array(
                       "draw" => $_POST['draw'],
                       "recordsTotal" => $this->Company_model->count_all($extra),
                       "recordsFiltered" => $this->Company_model->count_filtered($extra),
                       "data" => $data,
               );
    
       echo json_encode($output);
   }
   //  Add company form
   function company_add()
	{
			if ($_SESSION['logged_in'] == "") 
			{
            	redirect('login');
        	}
        	$data["logged_in"] = $_SESSION['logged_in'];
			$this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
			$this->load->view('Admin/company_add');
            $this->load->view('Admin/footer');
	}

	function company_insert()
	{
			$this->form_validation->set_rules('companyname','Company Name','required|callback_regvalidation');
			$this->form_validation->set_rules('email', 'Email' , 'required|callback_email_validation');
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('mobile', 'Mobile Numner', 'required|regex_match[/^[0-9]{10}$/]');
			
			if($this->form_validation->run())
			{
				date_default_timezone_set('Asia/Kolkata');
				$data = array(
										 				
			 				'name' => $this->input->post('companyname'), 
			 				'email' => $this->input->post('email'),
				 			'password' => $this->input->post('password'),
				 			'mobile' =>$this->input->post('mobile'),
				 			'created_by' => date("Y-m-d H:i:s")
			 			);


			 	$this->db->insert('sh_com_registration',$data);
			 	$this->session->set_flashdata('success','Company Registerd Successfully..');
			  
			 	redirect('Company/company_list');
			}
			else
			{
				$this->company_add();	
			}
	}
	// company name exist or not validation
		function regvalidation($username)
		{
			
			$this->load->model('Company_model');
			$check = $this->Company_model->check_username($username);
			if($check == "")
			{
				$this->form_validation->set_message('regvalidation', 'Company name already exist');
				return false;

			}
			else
			{
				return true;				
			}
		}
		// company Email exist or not validation
		function email_validation($email)
		{
			
			$this->load->model('admin_model');
			$check = $this->Company_model->check_email($email);
			if($check == "")
			{
				$this->form_validation->set_message('email_validation', 'Email Address already exist');
				return false;
			}
			else
			{
				return true;				
			}
		}

		// company delete

		function company_delete()
		{
			$this->load->model('Company_model');
			$id = $this->uri->segment('3');
			$sess_id = $this->session->userdata('id');
			$data = array(
							'deleted_by' => $sess_id,
							'status' => '0'
						);
			$this->Company_model->delete($id,$data);
			$this->session->set_flashdata('fail','Company Deleted Successfully..');
			redirect('Company/company_list');
		}

		function company_update()
		{
			//print_r($_POST);
			$this->load->model('company_model');
			$id = $this->input->post('id');
			
			$data["id"] = $this->uri->segment('3');		
			$this->form_validation->set_rules('companyname','Company name','required|callback_updvalidation');
			$this->form_validation->set_rules('email', 'Email' ,'required|callback_upd_email_validation');
			$this->form_validation->set_rules('password','Password','required|min_length[4]|max_length[8]');
			$this->form_validation->set_rules('mobile', 'Mobile Numner', 'required|regex_match[/^[0-9]{10}$/]');

			date_default_timezone_set('Asia/Kolkata');
			if($this->form_validation->run() == true)
			{
						$data = array(
							
			 				'name' => $this->input->post('companyname'), 
			 				'email' => $this->input->post('email'),
				 			'password' => $this->input->post('password'),
				 			'mobile'=>$this->input->post('mobile'),
				 			'updated_by' => date('Y-m-d H:i:s')

			 			);
						
				$update = $this->company_model->update($id,$data);
				
				$this->session->set_flashdata('success','Company Data Updated Successfully..');
				redirect('company/company_list');
			}
			else
			{
				
			$id = $this->uri->segment('3');
			if($id == "")
			{
				$id = $this->input->post('id');
			}
			$query = $this->db->get_where("sh_com_registration",array("id"=>$id));
			$data['company'] = $query->result();
			
			if ($_SESSION['logged_in'] == "") 
			{
            	redirect('login');
        	}
        	$data["logged_in"] = $_SESSION['logged_in'];
			$this->load->view('Admin/header',$data);
            $this->load->view('Admin/nav',$data);
			$this->load->view('Admin/company_edit',$data);
            $this->load->view('Admin/footer');
			
			}
		}

		function updvalidation($username)
		{
			$id = $this->input->post('id');
			$this->load->model('Company_model');
			$user = $this->Company_model->check_user($id);

			$username1 = $user[0]->name;

			if ($username == $username1) 
			{
				return true;
			}
			else
			{
				$check = $this->Company_model->check_username($username);
				if($check == "")
				{
					$this->form_validation->set_message('updvalidation', 'Company name already exist');
					return false;

				}
				else
				{
					return true;				
				}
			}
		}
		function upd_email_validation($email)
		{
			$id = $this->input->post('id');
			$this->load->model('Company_model');
			$user = $this->Company_model->check_user($id);

			$email1 = $user[0]->email;

			if ($email == $email1) 
			{
				return true;
			}
			else
			{
				$check = $this->Company_model->check_email($email);
				if($check == "")
				{
					$this->form_validation->set_message('upd_email_validation', 'Email already exist');
					return false;

				}
				else
				{
					return true;				
				}
			}
		}
}

?>