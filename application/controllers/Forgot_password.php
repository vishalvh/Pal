<?php
	class forgot_password extends CI_Controller
	{
		function index()
		{
			$this->load->view('web/forgot_email');
		}
		function change_pass($data)
		{
			$data['email'] = $this->input->post('email');
			$this->load->view('change_forgot_pass',$data);
		}

		function check_email()
		{
			$email = $this->input->post('email');
			$data['email'] = $this->input->post('email');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			if ($this->form_validation->run()) 
			{
				$this->load->model('forgot_password_model');
				$chk_em = $this->forgot_password_model->email_chk($email);
			// print_r($chk_em);die();	
				if ($chk_em == 1) 
				{
					$this->session->set_flashdata('email_correct','Link Sent In your Mail successfully');
					$this->change_pass($data);
					// redirect('forgot_password/change_pass',$data);
				}
				else
				{
					$this->session->set_flashdata('email_wrong','Please check your mail id');
					$this->load->view('web/forgot_email',$data);
				}
			}
			else
			{
				$this->load->view('web/forgot_email');
			}
		}

		function change_password()
		{
			$email = $this->input->post('email');
			$this->form_validation->set_rules('new_pass', 'New Password', 'required');
			$this->form_validation->set_rules('con_pass', 'New Password', 'required');
			if($this->form_validation->run() == true)
			{
				$this->load->model('forgot_password_model');
				$cp = $this->forgot_password_model->email_chk($email);
				if ($cp == 1) 
				{
					$n_p = $this->input->post('new_pass');
					$c_p = $this->input->post('con_pass');
					if ($n_p == $c_p)
					{
						$data = array(
									'password' => $n_p 
								);	
						$this->forgot_password_model->change_password($email,$data);
						$this->session->set_flashdata('succ_pass', 'Your password changed successfully');
						$this->index();
					}
					else
					{
						$data = array();
						$this->session->set_flashdata('not_match', 'password does not match');
						$this->change_pass($data);	
					}
					
				}
				else
				{
					$this->index();
				}
			}
			else
			{
				$data = array();
				$this->change_pass($data);
			}
		}

		// function forgot_password()
		// {
  //       	$this->load->view('web/forgot_email');
  //   	}
    	function forgot_pass_data() 
    	{
    		$this->load->model('master_model');
            $email = $this->input->post('email');
	        $check_email = $this->master_model->get_one("sh_com_registration", array("email" => $email, 'status' => '1'));
            
            if (empty($check_email)) {
                $this->session->set_flashdata('fail', "This Mail id Not Found");
               $this->load->view('web/forgot_email');
            }else
            {
            $this->load->helper('string');
            $rs = random_string('alnum', 5);
            $data = array(
                'RS' => $rs
            );
            
            $update = $this->master_model->master_update("sh_com_registration", array("email" => $email, 'status' => '1'),$data);
            $this->load->helper(array('swift'));
            $subject = "Rest Password Link";
            $link=base_url(). "administrator/get_password/index/" . $rs;
            $message = "Dear ".ucwords($check_email->name);

            $message .= "You recently requested to reset your password for your Shree Hari. Click the button below to reset it.<br/><br/>";
            $message .= "<a href='" . base_url() . "forgot_password/get_password/" . $rs . "' style='background-color:#dc4d2f;color:#ffffff;display:inline-block;font-size:15px;line-height:45px;text-align:center;width:200px;border-radius:3px;text-decoration:none;'>Reset your password</a><br/><br/>";
            $message .= "If you did not request a password reset, please ignore this email or reply to let us know.<br/><br/>";
            $message .= "Thanks <br/> Shree Hari";
            send_mail($email,'Shri Hari Pal Reset your forgotten Password',$message);
            $this->session->set_flashdata('success', "We have Sent you a link to change your password Please Check It!");
              $this->load->view('web/login'); 
    	}
    }
    public function get_password($code) {
    	   $this->load->model('master_model');
           $data['code'] = $code;
            $query = $this->master_model->get_one("sh_com_registration", array("RS" => $code, 'status' => '1'));
             if ($query == "") {
				  $this->session->set_flashdata('fail',"You Have Already Updated Password!");
                redirect('company_login');
            }else{
				  $this->load->view('web/gp_form',$data);
			 }   
           
    }
    public function get_company_password($code) {
           $data['code'] = $code;
            $query = $this->master_model->get_one("sh_com_registration", array("RS" => $code, 'status' => '1'));
             if ($query == "") {
                  $this->session->set_flashdata('fail',"You Have Already Updated Password!");
                redirect('company_login');
            }else{
                  $this->load->view('web/gp_form',$data);
             }   
           
    }
        public function set_password($rs = FALSE) {
            $code = $rs;
			//print_r($_POST);
			$data['code'] = $code;
            $query = $this->db->get_where('sh_com_registration', array('RS' => $code, 'status' => '1'), 1);
			//print_r($query);
            if ($query->num_rows() == 0) {
				  $this->session->set_flashdata('unsuccess',"You Have Already Updated Password!");
                redirect('company_login');
            } else {
                $pass = $this->input->post('np');
                $cpass = $this->input->post('cp');
                if ($pass == $cpass) {
                    $data = array(
                        'password' => $this->input->post('np'),
                        'RS' => ''
                    );
                    $where = $this->db->where('status', '1');
                    $where = $this->db->where('RS', $code);
                    $where->update('sh_com_registration', $data);
                    $this->session->set_flashdata('success', "Congratulation!! Your Password Changed Successfully!");
                     redirect('company_login');
                } else {
                    $this->session->set_flashdata('fail', "Password Do Not Match!");
                      $this->load->view('web/gp_form',$data);
                }
            }
        }
	}
?>