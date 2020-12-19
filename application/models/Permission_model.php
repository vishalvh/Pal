<?php
class Permission_model extends CI_Model{
   public function __construct() 
   {
       $this->load->database();
   }
	public function getAllPermission() {
        $this->db->select('*');
        $query = $this->db->get_where('sh_permission_list',array('status'=>'1'));
        return $query->result();
    }
	public function getUserPermission($id) {
        $this->db->select('*');
        $query = $this->db->get_where('sh_user_permission',array('status'=>'1','user_id'=>$id));
        return $query->result();
    }
	public function deleteAllpermissionByUser($id) {
      $this->db->where('user_id',$id);
      $this->db->where('status','1');
      $this->db->update('sh_user_permission',array('status'=>'0'));
	  return true;
    }
	public function insertUserPerminssion($data){
        $this->db->insert('sh_user_permission', $data);
        return $this->db->insert_id();
	}
}
?>