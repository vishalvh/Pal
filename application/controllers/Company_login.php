<?php

class Company_login extends CI_Controller
{
	function index()
	{
		 
		$this->load->view('web/login');
	}
        function signup()
	{
		 
		$this->load->view('web/signup');
	}
}
?>