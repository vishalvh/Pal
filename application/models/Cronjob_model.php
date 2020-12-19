<?php
class Cronjob_model extends CI_Model{
   public function __construct() 
   {
       $this->load->database();
   }
function get_location_user($location){
	  $query = $this->db->query("SELECT * FROM shusermaster WHERE l_id ='$location' AND status='1' and token is Not null");
		return $query->result();
  }
  function get_last_day_entry($location,$date){
	  $query = $this->db->query("SELECT * FROM shdailyreadingdetails WHERE location_id ='$location' and date = '$date'");
		return $query->result();
  }
  function get_user_device($id){
	  $query = $this->db->query("SELECT * FROM sh_users_device WHERE user_id ='$id' and type = 'employee' and status = '1'");
		return $query->row();
  }
  }
?>