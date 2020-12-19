<?php
  class Company_daily_density_model extends CI_Model
  {
    // search with ajax

   public function __construct() 
   {
       $this->load->database();
   }

  
function daily_density_report($sdate,$edate,$location){
	  $query = $this->db->query("SELECT * FROM sh_daily_density
WHERE location_id ='$location' AND status='1' AND date >= '$sdate' AND date <= '$edate'");
		return $query->result();
  }
  }
?>