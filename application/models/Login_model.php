<?php 
Class Login_model extends CI_Model {

    // pranjal service for company login 17/04/2018
    function checkcompanylogin($email, $password)
    { 
        $this->db->select('*');
        $this->db->from('sh_com_registration');
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->where('status', '1');

        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() == 1)
        {
            return $query->result();
        }      
        else
        {
            return false;
        }
    }
    // code end pranjal

    function checklogin($email, $password) {
        $this->db->select('*');
        $this->db->from('shadminmaster');
        $this->db->where('AdminEmail', $email);
        $this->db->where('AdminPassword', $password);
        $this->db->where('status', '1');
       
		//$this->db->where('type', '1');
        $this->db->limit(1);
        $query = $this->db->get();
        // print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
	function checkloginuser($email, $password) {
        $this->db->select('*');
        $this->db->from('shusermaster');
        $this->db->where('UserEmail', $email);
        $this->db->where('UserPassword', $password);
        $this->db->where('status', '1');
		///$this->db->where('type', '2');
        $this->db->limit(1);
        $query = $this->db->get();
        // print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    function checklogincompany($email, $password) {
        $this->db->select('*');
        $this->db->from('sh_com_registration');
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->where('status', '1');
        ///$this->db->where('type', '2');
        $this->db->limit(1);
        $query = $this->db->get();
        // print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
	function checklogin1($email, $password) {
        $this->db->select('*');
        $this->db->from('shadminmaster');
        $this->db->where('AdminEmail', $email);
        $this->db->where('AdminPassword', $password);
        $this->db->where('status', '1');
        $this->db->where('Active', '1');
		//$this->db->where('type', '1');
        $this->db->limit(1);
        $query = $this->db->get();
        // print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
	function checkloginAdmin($email, $password) {
        $this->db->select('*');
        $this->db->from('AdgAdminMmaster');
        $this->db->where('AdminEmail', $email);
        $this->db->where('AdminPassword', $password);
        $this->db->where('status', '1');
       
		//$this->db->where('type', '1');
        $this->db->limit(1);
        $query = $this->db->get();
        // print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
	function checklogin1Admin($email, $password) {
        $this->db->select('*');
        $this->db->from('AdgAdminMmaster');
        $this->db->where('AdminEmail', $email);
        $this->db->where('AdminPassword', $password);
        $this->db->where('status', '1');
        $this->db->where('Active', '1');
		//$this->db->where('type', '1');
        $this->db->limit(1);
        $query = $this->db->get();
        // print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
public function master_fun_update_UserEmail($tablename, $cid, $data) {
       $this->db->where('AdminEmail', $cid);
       $this->db->update($tablename, $data);
       return 1;
   }
    public function login_time($did, $data) {
        $this->db->where('id', $did);
        $this->db->update('admin_master', $data);

        return 1;
    }
	function checkemail($email) {
        $this->db->select('*');
        $this->db->from('AdgUserMaster');
        $this->db->where('UserEmail', $email);
        $this->db->where('status', '1');
		//$this->db->where('type', '1');
        $this->db->limit(1);
        $query = $this->db->get();
//         print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
	function checkemailAdmin($email) {
        $this->db->select('*');
        $this->db->from('AdgAdminMmaster');
        $this->db->where('AdminEmail', $email);
        $this->db->where('status', '1');
		//$this->db->where('type', '1');
        $this->db->limit(1);
        $query = $this->db->get();
//         print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
	
	function d(){
		 $this->db->select('*');
        $this->db->from('AdgUserMaster');
		$query = $this->db->get();
		print_r($query->result());
		return $query->result();
		//$query = "select * FROM AdgUserMaster ";
		//print_r($query); die();
		
	}
	public function master_fun_update_1($tablename, $cid, $data) {
       $this->db->where('md5(id)', $cid);
       $this->db->update($tablename, $data);
       return 1;
   }
	public function master_fun_update_2($tablename, $id, $data) {
		//print_r($id) ; die();
       $this->db->where('md5(UserEmail)', $id);
       $this->db->update($tablename, $data);
       return 1;
   }
	public function master_fun_update_Admin($tablename, $id, $data) {
		//print_r($id) ; die();
       $this->db->where('md5(AdminEmail)', $id);
       $this->db->update($tablename, $data);
       return 1;
   }

}
?>