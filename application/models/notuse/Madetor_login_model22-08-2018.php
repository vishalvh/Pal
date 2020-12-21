<?php

class Madetor_login_model extends CI_Model {

    function __construct() {
        parent ::__construct();
    }

    function login($email, $password) {
        $this->db->from('sh_madetor');
        $this->db->where('email_id', $email);
        $this->db->where('password', $password);
        $this->db->where('status', '1');
        $query = $this->db->get();
        if ($query->num_rows() == 1) {

            return $query->result();
        } else {
            return false;
        }
    }

    function update_profile($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('sh_madetor', $data);
    }

    function check_email1($email, $id) {
        $this->db->from('sh_madetor');
        $this->db->where('id !=', $id);
        $this->db->where('email_id', $email);
        $this->db->where('status', '1');
        $this->db->limit(1);
        $query = $this->db->get();
        //echo $query->num_rows();die();

        return $query->num_rows();
    }
    public function select($id)
    {
      $this->db->where('id',$id);
      $this->db->where('status','1');
	  $this->db->from('sh_madetor');
      $query = $this->db->get();
		return $query->row();
    }
     function check_password($old_password)
    {
        $this->db->where('id',  $_SESSION['logged_company']['u_id']);
        $query = $this->db->get('sh_madetor');
        $row    = $query->row();
        // echo "Old Password : ".$old_password."<br>";
        // echo "From DB : ".$row->password."<br>";
        

        if($query->num_rows() > 0){
          $row = $query->row();
          if($old_password == $row->password)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

    }
    function update_pass($data)
    {
      $this->db->where('id', $_SESSION['logged_company']['u_id']);
      $this->db->update('sh_madetor',$data);
    }

}

?>