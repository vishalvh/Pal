<?php
class Company_report_model extends CI_Model
{
	public function __construct() {
       $this->load->database();
	}
	function get_ioc_list($lid,$sdate,$edate){
		$query = $this->db->query("SELECT date,sum(amount) as amount  FROM sh_credit_debit WHERE payment_type='ioc' and location_id='$lid' and status='1' AND date <= '$edate' and date >= '$sdate' and batch_no is not null and customer_id is null group by date ORDER BY date ASC ");
		return $query->result();	
	}
	function get_credit_by_customer_ioc($lid,$sdate,$edate){
		$query = $this->db->query("SELECT date,sum(amount) as amount  FROM sh_credit_debit WHERE transaction_type = 'ccard' and location_id='$lid' and status='1' AND date <= '$edate' and date >= '$sdate' and batch_no is null and customer_id is not null group by date ORDER BY date ASC ");
		return $query->result();	
	}
	function get_prv_ioc_credit_by_customer($lid,$sdate){
		$query = $this->db->query("SELECT sum(amount) as totalamount FROM sh_credit_debit WHERE transaction_type='ccard' and location_id='$lid' and status='1' and date < '$sdate' and batch_no is null and customer_id is not null ");
		return $query->row();	
	}
	function get_purchase_list($lid,$sdate,$edate){
		$query = $this->db->query("SELECT si.date,SUM(si.`d_total_amount`) AS d_total_amount,SUM(si.`p_total_amount`) AS p_total_amount
 FROM sh_inventory si WHERE si.status = '1' AND si.location_id ='$lid' AND (si.fuel_type = 'p' OR si.fuel_type = 'd') AND (si.`p_quantity` > 0 OR si.`d_quantity` > 0) AND si.date <= '$edate' AND si.date >= '$sdate'
 GROUP BY si.date ORDER BY si.date asc");
		return $query->result();	
	}
	function get_pre_purchase_total($lid,$sdate){
		$query = $this->db->query("SELECT SUM(si.`d_total_amount`) AS d_total_amount,SUM(si.`p_total_amount`) AS p_total_amount
 FROM sh_inventory si WHERE si.status = '1' AND si.location_id ='$lid' AND (si.fuel_type = 'p' OR si.fuel_type = 'd') AND (si.`p_quantity` > 0 OR si.`d_quantity` > 0) AND si.date < '$sdate'");
		return $query->row();	
	}
	function get_pre_ioc_total($lid,$sdate){
		$query = $this->db->query("SELECT sum(amount) as totalamount FROM sh_credit_debit WHERE payment_type='ioc' and location_id='$lid' and status='1' and date < '$sdate' and batch_no is not null and customer_id is null ");
		return $query->row();	
	}
	function get_online_transection_list($lid,$sdate,$edate){
		$query = $this->db->query("SELECT 
  sum(so.amount) as oamount,so.date
FROM
  sh_location sl
  JOIN sh_creditors sc ON sc.location_id = sl.l_id
  JOIN sh_onlinetransaction so ON so.customer_name = sc.`id`
WHERE sl.l_id = '$lid' AND sc.`type`='2' AND sl.`status`='1' AND sc.`status`='1' AND so.`status`='1' AND so.`date` >= '$sdate' AND so.`date` <= '$edate' group by so.date
ORDER BY so.date ASC ");
		return $query->result();	
	}
	function get_pre_transection_total($lid,$sdate){
		$query = $this->db->query("SELECT sum(amount) as totalamount FROM
  sh_location sl
  JOIN sh_creditors sc ON sc.location_id = sl.l_id
  JOIN sh_onlinetransaction so ON so.customer_name = sc.`id`
WHERE sl.l_id = '$lid' AND sc.`type`='2' AND sl.`status`='1' AND sc.`status`='1' AND so.`status`='1' AND so.`date` < '$sdate' ");
		return $query->row();	
	}
	function depositbycard_list_view($date,$lid){
		$query = $this->db->query("SELECT date,id,
		amount,batch_no
		FROM sh_credit_debit
		WHERE payment_type='ioc' and location_id='$lid' and status='1' AND date = '$date' and batch_no is not null and customer_id is null 
		ORDER BY date ASC ");
		return $query->result();
	}
	function transonline_list_view($date,$lid){
		$query = $this->db->query("SELECT 
  so.amount,so.date,so.cheque_tras_no,so.id
FROM
  sh_location sl
  JOIN sh_creditors sc ON sc.location_id = sl.l_id
  JOIN sh_onlinetransaction so ON so.customer_name = sc.`id`
WHERE sl.l_id = '$lid' AND sc.`type`='2' AND sl.`status`='1' AND sc.`status`='1' AND so.`status`='1' AND so.`date` = '$date'
ORDER BY so.date ASC ");
		return $query->result();
	}
	function purchaseamount_list_view($date,$lid){
		$query = $this->db->query("SELECT si.date,si.`d_total_amount`,si.`p_total_amount`,si.id
 FROM sh_inventory si WHERE si.status = '1' AND si.location_id ='$lid' AND (si.fuel_type = 'p' OR si.fuel_type = 'd') AND (si.`p_quantity` > 0 OR si.`d_quantity` > 0) AND si.date = '$date'
 ORDER BY si.date asc");
		return $query->result();	
	}
	function get_one($dtatabase, $condition) {
        $query = $this->db->get_where($dtatabase, $condition);
        $result = $query->row();
        return $result;
    }
	function update($tbl,$condition,$data)
    {
      $this->db->where($condition);
      $this->db->update($tbl,$data);
    }
	function company_credit_debit($sdate,$lid){
		$query = $this->db->query("SELECT * FROM sh_company_credit_debit WHERE status = '1' AND location_id='$lid' AND date='$sdate' order by date  asc");
		return $query->result();	
	}
	function company_credit_by_customer($sdate,$lid){
		$query = $this->db->query("SELECT * FROM sh_credit_debit WHERE transaction_type = 'ccard' and  status = '1' AND location_id='$lid' AND date='$sdate' order by date  asc");
		return $query->result();	
	}
} ?>