<?php

class Madetor_login extends CI_Controller {

    function index() {

        $this->load->view('web/login_madetor');
    }

    function login_validation() {
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $this->load->model('Madetor_login_model');
            $login = $this->Madetor_login_model->login($email, $password);
            // echo $this->db->last_Query();die();
            // print_r($login[0]->email);
            // die();
            $id = $login[0]->company_id;
            $username = $login[0]->name;
            $email = $login[0]->email_id;
            $mobile = $login[0]->mobile_no;
            $password = $login[0]->password;
            $u_id = $login[0]->id;
            $type = 'm';
            if ($login != "") {
                // echo "hi";die();
                $session_data = array(
                    'id' => $id,
                    'name' => $username,
                    'email' => $email,
                    'mobile' => $mobile,
                    'type' => $type,
                    'u_id' => $u_id
                );
                $this->session->set_userdata('logged_company', $session_data);
                redirect(base_url() . 'main/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid Username Or password');
                redirect(base_url() . 'madetor_login/index');
            }
        } else {
            $this->index();
        }
    }

    function profile() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->view('web/profile_madetor', $data);
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'madetor_login/index');
    }

    function change_pass() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->view('web/change_password_madetor', $data);
    }

    function update_profile() {
        if (!$this->session->userdata('logged_company')) {
            redirect('company_login');
        }
        $data["logged_company"] = $_SESSION['logged_company'];

        $this->load->model('Madetor_login_model');
        $id = $_SESSION['logged_company']['u_id'];
        $c_id = $_SESSION['logged_company']['id'];
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_pro_email');
        $this->form_validation->set_rules('mobile', 'Mobile Numner', 'required|regex_match[/^[0-9]{10}$/]');

        date_default_timezone_set('Asia/Kolkata');

        $type = 'm';
        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('username'),
                'email_id' => $this->input->post('email'),
                'mobile_no' => $this->input->post('mobile'),
                'updated_by' => date('Y-m-d H:i:sa')
            );

            $update = $this->Madetor_login_model->update_profile($id, $data);
//             echo $this->db->last_query();die();
            $data = $this->Madetor_login_model->select($id);
            $session_data = array(
                'id' => $data->company_id,
                'name' => $data->name,
                'email' => $data->email_id,
                'mobile' => $data->mobile_no,
                'type' => $data->type,
                'u_id' => $data->id
            );
            $this->session->set_userdata('logged_company', $session_data);


            $this->session->set_flashdata('update_profile', 'Your Profile Updated Successfully..');
				redirect('madetor_login/profile');
        } else {

            $this->load->view('web/profile', $data);
        }
    }

    function pro_email($email) {
        $this->load->model('Madetor_login_model');
        $id = $_SESSION['logged_company']['id'];
        $check = $this->Madetor_login_model->check_email1($email, $id);
        if ($check == "") {
            $this->form_validation->set_message('pro_email', 'Email Address already exist');
            return false;
        } else {
            return true;
        }
    }
     function change_password()
   {
   		if(!$this->session->userdata('logged_company'))
			{
            	redirect('company_login');
      		}
        	$data["logged_company"] = $_SESSION['logged_company'];

   		$old_pass = $this->input->post('old_pass');
   		
   		$this->load->model('Madetor_login_model');
  		$this->form_validation->set_rules('old_pass','Password','required');
  		$this->form_validation->set_rules('new_pass', 'New Password', 'required');
  		$this->form_validation->set_rules('con_pass', 'Confirm Password', 'required');
  		if ($this->form_validation->run() == true) 
  		{
  			
  			$ds = $this->Madetor_login_model->check_password($old_pass);
                      
  			if($ds == 1)
  			{
  				$n_pass = $this->input->post('new_pass');
  				$cpass = $this->input->post('con_pass');
  				if($n_pass == $cpass)
  				{
	  				$data = array(
	  							'password' => $n_pass 
	  						);		
	  				$this->Madetor_login_model->update_pass($data);

	  				$this->session->set_flashdata('update_pass','Password Changed successfully');
	  				redirect('madetor_login/change_pass');	
  				}
  				else
  				{
	  				$this->session->set_flashdata('chk_pass','Please check new password and confirm password');
	  				$this->change_pass();
  				}
  			}
  			else
  			{
  				$this->session->set_flashdata('upd_fail','Old Password Does Not Match');
  				// $this->form_validation->set_message('old_pass', 'password doesnt match');
  				$this->change_pass();
  			}
  			
  		}
  		else
  		{
  			$this->form_validation->set_message('old_pass', 'password doesnt match');
  			$this->change_pass();
  		}
   }

}

?>