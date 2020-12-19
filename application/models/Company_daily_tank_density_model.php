<?php
  class Company_daily_tank_density_model extends CI_Model
  {
    // search with ajax

   public function __construct() 
   {
       $this->load->database();
   }

  
function daily_density_report($sdate,$edate,$location,$type){
	if($type == 'p' || $type == 'd'){
		$temp = ' AND sh_tank_list.xp_type = "No"';
	}else{
		$temp = ' AND sh_tank_list.xp_type = "Yes"';
	}
	$query = $this->db->query("SELECT sh_daily_tank_density.* FROM sh_daily_tank_density JOIN sh_tank_list ON sh_tank_list.id = sh_daily_tank_density.tank_id
WHERE sh_daily_tank_density.location_id ='$location' AND sh_daily_tank_density.status='1' AND sh_daily_tank_density.date >= '$sdate' AND sh_daily_tank_density.date <= '$edate' 
AND sh_daily_tank_density.type = '$type' $temp order by sh_daily_tank_density.date");
		return $query->result();
  }
  function tanklist($location){
	  $query = $this->db->query("SELECT * FROM sh_tank_list
WHERE location_id ='$location'");
		return $query->result();
  }
  function get_daily_density($date,$location){
	  $query = $this->db->query("SELECT * FROM sh_daily_density
WHERE location_id ='$location' and date ='$date'");
		return $query->row();
  }
  function daily_density_report_tank($sdate,$edate,$id){
	
	$query = $this->db->query("SELECT sh_daily_tank_density.* FROM sh_daily_tank_density JOIN sh_tank_list ON sh_tank_list.id = sh_daily_tank_density.tank_id
WHERE sh_daily_tank_density.status='1' AND sh_daily_tank_density.date >= '$sdate' AND sh_daily_tank_density.date <= '$edate' 
AND sh_daily_tank_density.tank_id = '$id' order by sh_daily_tank_density.date");
		return $query->result();
  }
  function update_data($tbl,$cnd,$data){
$this->db->where($cnd);
$this->db->update($tbl, $data);
return 1;
}
public function insert($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
  }
?>