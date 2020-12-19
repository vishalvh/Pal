<?php

Class User_model extends CI_Model {
	function getUser($user_id){
		$query = $this->db->get_where("shadminmaster",array("id"=>$user_id,"status"=>"1"));
		return $query->row();
	}
	
	function update_user($data,$user_id){
			$this->db->update("shadminmaster",$data,array("id"=>$user_id));
			return 1;
	}
	function getUser_all($id){
		$query = $this->db->query("SELECT shadminmaster.`AdminName`,shadminmaster.id,shadminmaster.Active,shadminmaster.`AdminEmail`,shadminmaster.`AdminGender`,shadminmaster.`AdminMNumber`  FROM `shadminmaster` 
 where shadminmaster.id='$id'");   

		return $query->result_array();
	}
}

?>