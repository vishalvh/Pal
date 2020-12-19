<?php
class Daily_invoice_model extends CI_Model
{
	public function __construct() {
       $this->load->database();
	}
	function daily_invoice_data($location,$date){
    $query = $this->db->query("SELECT 
su.name,
(SELECT SUM(scd.amount) FROM sh_credit_debit scd WHERE scd.status = '1' AND scd.customer_id = su.id AND scd.date='$date' AND scd.payment_type ='d') AS current_debit,
(SELECT SUM(scd.amount) FROM sh_credit_debit scd WHERE scd.status = '1' AND scd.customer_id = su.id AND scd.date='$date' AND scd.payment_type ='c') AS current_credit,
(SELECT SUM(scd.amount) FROM sh_credit_debit scd WHERE scd.status = '1' AND scd.customer_id = su.id AND scd.date<'$date' AND scd.payment_type ='d') AS past_debit,
(SELECT SUM(scd.amount) FROM sh_credit_debit scd WHERE scd.status = '1' AND scd.customer_id = su.id AND scd.date<'$date' AND scd.payment_type ='c') AS past_credit
 FROM sh_userdetail su WHERE  su.location_id = '$location' AND su.`status` = 1 AND su.open_close = 1
 ORDER BY su.name ASC");   
    return $query->result();
  }
  function dailyprice($lid,$date){
	  $query = $this->db->query("SELECT * FROM sh_dailyprice WHERE user_id = '$lid' AND date='$date' AND status = 1");   
    return $query->row();
  }
} ?>