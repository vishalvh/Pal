<?php
	class user_login extends CI_Model
	{
		function __construct()
		{
			parent ::__construct();
		}

		// login code
		function login($email,$password)
		{
			$this->db->from('sh_com_registration');
			$this->db->where('email' ,$email);
			$this->db->where('password', $password);
			$this->db->where('type', '1');
			$this->db->where('status', '1');
			// $this->db->limit(1);
			$query = $this->db->get();
			// return $query->num_rows();

			if($query->num_rows() == 1)
			{

				return $query->result();
			}
			else
			{
				return false;
			}
		}

		// email exist or not
		// function email_validation()
		// {
		// 	$this->db->from('signup');
		// 	$this->	
		// }


	}
?>