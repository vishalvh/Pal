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
			//$this->db->where('type', '1');
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
                function login_check_bolck($email,$password)
		{
			$this->db->from('sh_com_registration');
			$this->db->where('email' ,$email);
			$this->db->where('password', $password);
			//$this->db->where('type', '1');
			$this->db->where('show', '1');
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
		function get_all_location($id)
		{
			$this->db->from('sh_location');
			$this->db->where('company_id' ,$id);
			$this->db->where('status', '1');
			$this->db->where('show_hide', 'show');
			$this->db->order_by('l_name', 'asc');
			$query = $this->db->get();
			return $query->result();
		}
		public function get_location($id){
            $query = $this->db->query("SELECT l.* FROM sh_madetor_l_id AS  m 
JOIN `sh_location` AS l ON l.`l_id` =m.`l_id`  
WHERE m.`status` = 1 
AND l.`status` = 1
AND l.`show_hide` = 'show'
AND m.`m_id`= '$id' order by l.l_name asc ");
		
            return $query->result();
        }
		public function get_chart_data($l_id){
            $query = $this->db->query("SELECT * FROM monthly_selling WHERE location_id='$l_id' AND STATUS ='1'  ORDER BY MONTH,YEAR  desc LIMIT 0,24");
		
            return $query->result();
        }
        public function get_chart_data_new($l_id,$month,$year){
            $query = $this->db->query("SELECT * FROM monthly_selling WHERE location_id = '$l_id' AND STATUS ='1' AND month=$month AND year = $year ");
		
            return $query->result();
        }
		public function getAllPermission() {
			$permissionList = array();
			$this->db->select('*');
			$query = $this->db->get_where('sh_permission_list',array('status'=>'1'));
			$result = $query->result();
			foreach($result as $res){
				$permissionList[] = $res->key;
			}
			return $permissionList;
		}
		public function getUserPermission($id) {
			$permissionList = array();
			$this->db->select('*');
			$query = $this->db->get_where('sh_user_permission',array('status'=>'1','user_id'=>$id));
			$result = $query->result();
			foreach($result as $res){
				$permissionList[] = $res->permission;
			}
			return $permissionList;
		}
	}
?>