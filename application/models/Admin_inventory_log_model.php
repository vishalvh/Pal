<?php
class Admin_inventory_log_model extends CI_Model
{
  	var $table = 'sh_inventory_update_log';
  
   public function __construct() 
   {
       $this->load->database();
   }



}
?>