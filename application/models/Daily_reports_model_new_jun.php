<?php class Daily_reports_model_new_jun extends CI_Model {

    public function __construct() 
    {
        $this->load->database();
    }

    public function report($location,$sdate,$edate){
        $query = $this->db->query("
        SELECT 
		si.created_date,
		su.UserFName,
            dr.date,
            dr.`id`,
            dr.`oil_reading`,
            dr.`oil_pure_benefit`,
            dr.`d_deep_reading`,
            dr.`d_sales_vat`,
            dr.`d_selling_price`,
            dr.`d_tank_reading`,
            dr.`d_total_selling`,
            dr.`xpd_total_selling`,
            dr.`p_deep_reading`,
            dr.`p_sales_vat`,
            dr.`p_selling_price`,
            dr.`p_tank_reading`,
            dr.`p_total_selling`,
            dr.`xpp_total_selling`,
			dr.p_testing,
			dr.d_testing,
			dr.xpd_testing,
			dr.xpp_testing,
			dr.cash_on_hand,
			dr.`d_tank_reading` AS dstock,
			dr.`xpd_tank_reading` AS xpdstock,
            dr.`p_tank_reading` AS pstock,
            dr.`xpp_tank_reading` AS xppstock,
            SUM(si.`oil_total_amount`) AS ostok,
            SUM(si.oil_cgst) AS oil_cgst,
			SUM(si.oil_sgst) AS oil_sgst,
			SUM(si.d_price) AS bdprice,
			SUM(IF(si.fuel_type = 'd',si.d_quantity,0)) AS d_quantity,
			SUM(IF(si.fuel_type = 'xpd',si.d_quantity,0)) AS xpd_quantity,
			SUM(IF(si.fuel_type = 'p',si.p_quantity,0)) AS p_quantity,
			SUM(IF(si.fuel_type = 'xpp',si.p_quantity,0)) AS xpp_quantity,
			SUM(IF(si.fuel_type = 'd',si.dv_taxamount,0)) AS dv_taxamount,
			SUM(IF(si.fuel_type = 'xpd',si.dv_taxamount,0)) AS xpdv_taxamount,
			SUM(IF(si.fuel_type = 'p',si.pv_taxamount,0)) AS pv_taxamount,
			SUM(IF(si.fuel_type = 'xpp',si.pv_taxamount,0)) AS xppv_taxamount,
			SUM(IF(si.fuel_type = 'd',si.d_ev,0)) AS d_ev,
  SUM(IF(si.fuel_type = 'xpd',si.d_ev,0)) AS xpd_ev,
			SUM(IF(si.fuel_type = 'p',si.p_ev,0)) AS p_ev,
  SUM(IF(si.fuel_type = 'xpp',si.p_ev,0)) AS xpp_ev,
			SUM(IF(si.fuel_type = 'd',si.prev_d_price,0)) AS d_new_price,
			SUM(IF(si.fuel_type = 'xpd',si.prev_d_price,0)) AS xpd_new_price,
			SUM(IF(si.fuel_type = 'p',si.prev_p_price,0)) AS p_new_price,
			SUM(IF(si.fuel_type = 'xpp',si.prev_p_price,0)) AS xpp_new_price,
			
			(SELECT SUM(petty_cash_transaction.amount) FROM `petty_cash_transaction`  WHERE petty_cash_transaction.date=dr.date and petty_cash_transaction.status='1' and petty_cash_transaction.location_id = '$location' and petty_cash_transaction.count_status = '1') as petty_cash_transaction_amount,
			(SELECT SUM(sh_expensein_details.amount) FROM `sh_expensein_details`  WHERE sh_expensein_details.date=dr.date and sh_expensein_details.status='1' and sh_expensein_details.location_id = '$location') as expence,
			(SELECT SUM(sh_credit_debit.amount) FROM `sh_credit_debit`  WHERE sh_credit_debit.date=dr.date and sh_credit_debit.payment_type='d' and sh_credit_debit.customer_id is null and sh_credit_debit.location_id ='$location' and sh_credit_debit.status='1' ) as totalcard_fule,
			(SELECT SUM(sh_credit_debit.amount) FROM `sh_credit_debit`  WHERE sh_credit_debit.date=dr.date and sh_credit_debit.payment_type='ioc' and sh_credit_debit.customer_id is null and sh_credit_debit.location_id ='$location' and sh_credit_debit.status='1') as totalioc_fule,
			(SELECT SUM(sh_credit_debit.amount) FROM `sh_credit_debit`  WHERE sh_credit_debit.date=dr.date and sh_credit_debit.payment_type='c' and sh_credit_debit.customer_id is not null and sh_credit_debit.location_id ='$location' and sh_credit_debit.status='1') as totalcredit_fule,
			(SELECT SUM(sh_credit_debit.amount) FROM `sh_credit_debit`  WHERE sh_credit_debit.date=dr.date and sh_credit_debit.payment_type='d' and  sh_credit_debit.customer_id is not null  and sh_credit_debit.location_id ='$location' and sh_credit_debit.status='1') as totalcreditcash_fule,
			(SELECT SUM(sh_credit_debit.amount) FROM `sh_credit_debit`  WHERE sh_credit_debit.date=dr.date and sh_credit_debit.payment_type='extra' and  sh_credit_debit.customer_id is null  and sh_credit_debit.location_id ='$location' and sh_credit_debit.status='1') as totalextracash_fule,
			(SELECT sh_dailyprice.pet_price FROM `sh_dailyprice`  WHERE sh_dailyprice.date=dr.date and user_id='$location' and sh_dailyprice.status='1') as pet_price,
			(SELECT sh_dailyprice.dis_price FROM `sh_dailyprice`  WHERE sh_dailyprice.date=dr.date and user_id='$location' and sh_dailyprice.status='1') as dis_price,
    (SELECT 
    sh_dailyprice.xp_pet_price 
  FROM
    `sh_dailyprice` 
  WHERE sh_dailyprice.date = dr.date 
    AND user_id = '48' 
    AND sh_dailyprice.status = '1') AS xppet_price,
  (SELECT 
    sh_dailyprice.xp_dis_price 
  FROM
    `sh_dailyprice` 
  WHERE sh_dailyprice.date = dr.date 
    AND user_id = '48' 
    AND sh_dailyprice.status = '1') AS xpdis_price,
			(SELECT SUM(amount) FROM `sh_workers_salary` JOIN sh_workers ON sh_workers.`id` = sh_workers_salary.`worker_id` WHERE `sh_workers_salary`.`date`=dr.date AND sh_workers.`location_id`='$location' AND sh_workers_salary.`status`='1') AS salary_admount,
			(SELECT SUM(extra_amount) FROM `sh_workers_salary` JOIN sh_workers ON sh_workers.`id` = sh_workers_salary.`worker_id` WHERE `sh_workers_salary`.`date`=dr.date AND sh_workers.`location_id`='$location' AND sh_workers_salary.`status`='1') AS extra_amount,
			(SELECT SUM(loan_amount) FROM `sh_workers_salary` JOIN sh_workers ON sh_workers.`id` = sh_workers_salary.`worker_id` WHERE `sh_workers_salary`.`date`=dr.date AND sh_workers.`location_id`='$location' AND sh_workers_salary.`status`='1') AS loan_amount,
			(SELECT SUM(extra_salary) FROM `sh_workers_salary` JOIN sh_workers ON sh_workers.`id` = sh_workers_salary.`worker_id` WHERE `sh_workers_salary`.`date`=dr.date AND sh_workers.`location_id`='$location' AND sh_workers_salary.`status`='1') AS extra_salary
        FROM
            shdailyreadingdetails dr 
        JOIN sh_inventory si 
            ON si.`date` = dr.`date`
		left join shusermaster as su on su.id = si.user_id
        WHERE dr.`date` >= '$sdate'
        AND si.`date` >= '$sdate'
        AND dr.`date` <= '$edate'
        AND si.`date` <= '$edate'
		AND dr.location_id = '$location'
		AND si.location_id = '$location'
		And si.status = '1'
        GROUP BY dr.date 
        ");
        return $query->result_array();
    }	
	
	 public function report_new($location,$month,$year){
        $query = $this->db->query("
        SELECT 
            dr.*,
            SUM(si.`o_stock`) AS ostok,
            SUM(si.`d_stock`) AS dstock,
            SUM(si.`p_stock`) AS pstock,
			SUM(si.p_price) AS bpprice,
			SUM(si.d_price) AS bdprice,
			SUM(si.d_quantity) AS d_quantity,
			SUM(si.p_quantity) AS p_quantity,
			SUM(si.dv_taxamount) AS dv_taxamount,
			SUM(si.pv_taxamount) AS pv_taxamount,
			SUM(si.d_ev) AS d_ev,
			SUM(si.p_ev) AS p_ev,
			SUM(si.prev_d_price) AS d_new_price,
			SUM(si.prev_p_price) AS p_new_price,
			(SELECT SUM(sh_expensein_details.amount) FROM `sh_expensein_details`  WHERE sh_expensein_details.date=dr.date) as expence
        FROM
            shdailyreadingdetails dr 
        JOIN sh_inventory si 
            ON si.`date` = dr.`date` 
        WHERE MONTH(dr.`date`) = '".$month."'
        AND MONTH(si.`date`) = '".$month."'
        AND YEAR(dr.`date`) = '".$year."'
        AND YEAR(si.`date`) = '".$year."'
		AND dr.location_id = '$location'
		AND si.location_id = '$location'
        GROUP BY dr.id 
        ");
        
        return $query->result_array();
    }
	
	public function worker_salary_remening($cid,$month,$year,$worker_id = ""){
            $y = date("Y", strtotime($month)); 
            $mo = date("m", strtotime($month));
            $query2 = "SELECT sh_workers.id, sh_workers.code,sh_workers.name,sh_workers.`salary` AS c_salary,sh_workers.`active`,
		IFNULL((SELECT SUM(amount) FROM sh_workers_salary WHERE  STATUS='1' AND date >= '$month' AND date <='$year' AND worker_id=sh_workers.id),0) as totaldebit,
		IFNULL((SELECT SUM(bonas_amount) FROM sh_workers_salary WHERE  STATUS='1' AND date >= '$month' AND date <='$year' AND worker_id=sh_workers.id),0) bonas_amount,
		IFNULL((SELECT SUM(extra_amount) FROM sh_workers_salary WHERE  STATUS='1' AND date >= '$month' AND date <='$year' AND worker_id=sh_workers.id),0) extra_amount,
		IFNULL((SELECT SUM(paid_loan_amount) FROM sh_workers_salary WHERE STATUS = '1' AND date >= '$month' AND date <= '$year' AND worker_id = sh_workers.id),0 ) AS paid_loan_amount,
		IFNULL( (SELECT IFNULL(SUM(loan_amount),0) - IFNULL(SUM(paid_loan_amount),0) FROM sh_workers_salary WHERE STATUS = '1' AND date <= '$month' AND worker_id = sh_workers.id), 0 ) AS past_loan_amount,
		IFNULL( (SELECT  SUM(loan_amount) FROM sh_workers_salary  WHERE STATUS = '1' AND DATE >= '$month'  AND DATE <= '$year' AND worker_id = sh_workers.id), 0 ) AS advance,
                 IFNULL( (SELECT  sum(salary) FROM sh_workers_monthly_salary  WHERE  month = '$mo'  AND year = '$y' AND workers_id = sh_workers.id), 0 ) AS salary   
FROM sh_workers 
                
                WHERE  sh_workers.status='1' and sh_workers.location_id = $cid AND sh_workers.join_date <= '$month'"; 
		
                if($worker_id != ""){
                    $query2 .= " and sh_workers.id = $worker_id";
                }
                $query = $this->db->query($query2);
		return $query->result();	
	}
        public function worker_salary_list($fdate,$edate,$id){		
		$query = $this->db->query("SELECT w.`name` as worker_name ,ws.* FROM sh_workers  AS w
JOIN sh_workers_salary  AS ws ON w.`id` = ws.`worker_id`
WHERE ws.`status` = 1
AND w.`status` = 1
AND ws.date <= '$edate'
AND ws.date >= '$fdate'
and w.id = '$id'");       
		return $query->result();	
	}
	
	public function worker_salary_paid_salary($lid,$sdate,$edate){
            $query = $this->db->query("SELECT SUM(sws.amount) AS amount FROM sh_workers sw 
JOIN sh_workers_salary sws ON sws.worker_id = sw.id
WHERE sw.status='1' AND sw.location_id = '$lid' AND sws.date >='$sdate' and sws.date <= '$edate'");
            return $query->row();
        }
       
	   
        public function worker_salary_loan($lid,$date){
            $query = $this->db->query("SELECT SUM(sws.loan_amount) AS loanamont,SUM(sws.paid_loan_amount) AS paid_loan_amount FROM sh_workers sw 
JOIN sh_workers_salary sws ON sws.worker_id = sw.id
WHERE sw.status='1' AND sw.location_id = '$lid' AND sws.date <='$date'");
            return $query->row();
        }
        public function worker_salary_edit($id){
            $query = $this->db->query("SELECT * FROM sh_workers_salary WHERE STATUS = 1 AND id  = $id");
            return $query->result();
        }

        public function last_day_entry($cid,$month,$year){		
		$query = $this->db->query("SELECT   * FROM sh_last_day_entry WHERE location_id = '$cid'   AND date >= '$month'   AND date <= '$year' and status='1' ");       
		return $query->row();	
	}	
	public function monthly_expence($cid,$month,$year){		
		$query = $this->db->query("SELECT * FROM sh_expensein_details WHERE  status='1' AND date >= '$month' AND date <='$year' ");
		return $query->result();	
	}
	public function ioc_balence($cid,$month,$year){		
		$query = $this->db->query("SELECT SUM(amount) as total FROM sh_credit_debit WHERE payment_type='ioc' and location_id='$cid' and status='1' AND date >= '$month' AND date <='$year' ");       return $query->row();	
	}
	public function deposit_amount($cid,$month,$year){		
		$query = $this->db->query("SELECT SUM(deposit_amount) as cash_total,SUM(amount) as cheque_total FROM sh_bankdeposit WHERE  location_id='$cid' and status='1' AND date >= '$month' AND date <='$year' ");       
		return $query->row();	
	}
	public function pre_deposit_amount($cid,$month){		
		$query = $this->db->query("SELECT SUM(deposit_amount) as cash_total,SUM(amount) as cheque_total FROM sh_bankdeposit WHERE  location_id='$cid' and status='1' AND date < '$month' ");       
		return $query->row();	
	}
	public function pre_deposit_wallet_amount($cid,$month){		
		$query = $this->db->query("SELECT SUM(amount) as wallet_extra_total FROM sh_credit_debit WHERE location_id='$cid' and status='1' AND date < '$month' and payment_type='extra' ");       
		return $query->row();	
	}
	public function prev_card_depost($cid,$month){		
		$query = $this->db->query("SELECT SUM(amount) as total FROM sh_credit_debit WHERE payment_type='d' and location_id='$cid' and status='1' AND date < '$month' and batch_no is not null and customer_id is null ");       return $query->row();	
	}
public function prev_extra_depost($cid,$month){		
		$query = $this->db->query("SELECT SUM(amount) as total FROM sh_credit_debit WHERE payment_type='extra' and location_id='$cid' and status='1' AND date < '$month' and customer_id is null ");       return $query->row();	
	}
	public function onlinetransaction($cid,$month,$year){		
		$query = $this->db->query("SELECT SUM(amount) as total_onlinetransaction FROM sh_onlinetransaction WHERE  location_id='$cid' and status='1' AND date >= '$month' AND date <='$year' ");       return $query->row();	
	}
	public function pre_onlinetransaction($cid,$month){		
		$query = $this->db->query("SELECT SUM(amount) as total_onlinetransaction FROM sh_onlinetransaction WHERE  location_id='$cid' and status='1' AND date < '$month' ");       return $query->row();	
	}
	public function customer_list($lid){		
		$query = $this->db->query("SELECT * FROM sh_userdetail WHERE  status='1' AND location_id ='$lid' order by name asc ");
		return $query->result();	
	}
	public function get_customer_credit_list($lid,$sdate,$edate,$custid){		
		$query = $this->db->query("SELECT *,(SELECT pet_price FROM `sh_dailyprice` WHERE user_id ='$lid' AND DATE = sh_credit_debit.date AND STATUS = '1') AS pet_pri,
  (SELECT dis_price FROM `sh_dailyprice` WHERE user_id ='$lid' AND DATE = sh_credit_debit.date AND STATUS = '1') AS dis_pri FROM sh_credit_debit WHERE  status='1' AND payment_type='c' and date >= '$sdate' and date <=' $edate' and customer_id='$custid' and  location_id ='$lid' ORDER BY date ");
		return $query->result();	
	}
	public function get_customer_credit_debit_list($lid,$sdate,$edate,$custid){		
		$query = $this->db->query("SELECT * FROM sh_credit_debit WHERE  status='1' and date >= '$sdate' and date <=' $edate' and customer_id='$custid' and  location_id ='$lid' order by date asc ");
		return $query->result();	
	}
	public function get_customer_debit_list($lid,$sdate,$edate,$custid){		
		$query = $this->db->query("SELECT SUM(amount) as totalamount FROM sh_credit_debit WHERE  status='1' AND payment_type='d' and date >= '$sdate' and date <= '$edate' and customer_id='$custid' and  location_id ='$lid' ");
		return $query->row();	
	}
	
	public function totalprev_credit_debit($lid,$edate,$custid,$type){		
		$query = $this->db->query("SELECT SUM(amount) as totalamount FROM sh_credit_debit WHERE  status='1' AND payment_type='$type' and date < '$edate' and customer_id='$custid' and  location_id ='$lid' ");
		return $query->row();	
	}
	
	public function get_customer_credit($lid,$sdate,$edate){		
		$query = $this->db->query("SELECT SUM(amount) as totalamount FROM sh_credit_debit WHERE  status='1' AND payment_type='c' and date >= '$sdate' and date <= '$edate' and location_id ='$lid' ");
		return $query->row();	
	}
	public function get_customer_debit($lid,$sdate,$edate){		
		$query = $this->db->query("SELECT SUM(amount) as totalamount FROM sh_credit_debit WHERE  status='1' AND payment_type='d' and date >= '$sdate' and date <= '$edate' and location_id ='$lid' ");
		return $query->row();	
	}
	public function custdetail($custid){		
		$query = $this->db->query("SELECT * FROM sh_userdetail WHERE  status='1' and id='$custid' ");
		return $query->row();	
	}
	public function location_detail($lid){		
		$query = $this->db->query("SELECT * FROM sh_location WHERE  status='1' and l_id='$lid' ");
		return $query->row();	
	}
	public function get_one_data($tbl,$cnd){		
		$this->db->select('*');
		$this->db->from($tbl);
		$this->db->where($cnd);
		$q1 = $this->db->get();
		return $q1->row();
	}
	public function get_all($tbl,$cnd){		
		$this->db->select('*');
		$this->db->from($tbl);
		$this->db->where($cnd);
		$q1 = $this->db->get();
		return $q1->result();
	}
	public function get_all_order($tbl,$cnd,$order){		
		$this->db->select('*');
		$this->db->from($tbl);
		$this->db->where($cnd);
		$this->db->order_by($order[0], $order[1]);
		$q1 = $this->db->get();
		
		return $q1->result();
	}
	public function oil_inventory_Detail($lid,$date){		
		$query = $this->db->query("SELECT 
    sp.`id`,sp.`name`,sp.`packet_type`,sp.`packet_value`,sp.`p_qty`,sp.`p_qty`,soi.`ltr`,soi.`qty`
  FROM
    sh_inventory si 
    JOIN sh_oil_inventory soi ON soi.`inv_id`=si.`id`
    JOIN shpump sp ON sp.`id`=soi.`oil_id`
  WHERE si.location_id = '$lid' 
    AND si.fuel_type = 'o' 
    AND si.`date` = '$date' 
	And si.status = '1'
	And soi.status = '1'
	and sp.status = '1'
  GROUP BY soi.id");
		return $query->result();	
	}
//public function meter_details($lid,$date){
//		$query = $this->db->query("SELECT 
//    sp.id,sp.`name`,sp.`type`,sp.`packet_type`,sp.`packet_value`,sp.`p_qty`,sp.`p_type`,srh.`qty`,srh.`Reading`
//  FROM
//    shdailyreadingdetails dr 
//    JOIN shreadinghistory srh 
//      ON srh.RDRId=dr.id 
//    JOIN shpump sp 
//      ON sp.`id` = srh.PumpId 
//  WHERE dr.location_id = '$lid' 
//    AND dr.`date` = '$date' 
//	And dr.status = '1'
//	And srh.status = '1'
//	and sp.status = '1'
//  GROUP BY srh.id
//  ORDER BY sp.type,sp.name ASC ");
//		return $query->result();	
//	}
public function meter_details($lid,$date){
		$query = $this->db->query("SELECT 
    sp.id,sp.`name`,sp.`type`,sp.`packet_type`,sp.`packet_value`,sp.`p_qty`,sp.`p_type`,srh.`qty`,srh.`Reading`, d_price.`bay_price`,d_price.`sel_price`
  FROM
    shdailyreadingdetails dr 
    JOIN shreadinghistory srh 
      ON srh.RDRId=dr.id 
    JOIN shpump sp 
      ON sp.`id` = srh.PumpId 
   LEFT  JOIN  sh_oil_daily_price AS d_price
     ON d_price.`o_p_id` = sp.`id` AND d_price.`date` = '$date'
  WHERE dr.location_id = '$lid' 
    AND dr.`date` = '$date' 
	AND dr.status = '1'
	AND srh.status = '1'
	AND sp.status = '1'
  GROUP BY srh.id
  ORDER BY sp.order ASC");
		return $query->result();	
	}
public function get_oil_meter_details($lid,$date){
		$query = $this->db->query("SELECT sp.`location_id`,sp.id,sp.`name`,sp.`type`,sp.`packet_type`,sp.`packet_value`,sp.`p_qty`,sp.`p_type`,d_price.`bay_price`,d_price.`sel_price`
  FROM shpump sp
    JOIN  sh_oil_daily_price AS d_price
	ON d_price.`o_p_id` = sp.`id` AND d_price.`date` = '$date'
  WHERE sp.`status` = '1' AND sp.`location_id` = '$lid' order by sp.order asc");
		return $query->result();	
	}
	function update_data($tbl,$cnd,$data){
$this->db->where($cnd);
$this->db->update($tbl, $data);
return 1;
}
public function master_insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_credit_debit',$data);
    } 

    function update($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_credit_debit',$data);
    }
    function update_bankdeposit($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_bankdeposit',$data);
    }
    function get_creditdebitdata($id)
    {
    	$query = $this->db->query("select * from sh_credit_debit where status='1' and id='$id'");
    	return $query->result();	
    }
      function get_creditdebit_total($id)
    {
    	$query = $this->db->query("select * from sh_bankdeposit where status='1' and id='$id'");
    	return $query->result();	
    }
	 public function master_fun_get_tbl_val($dtatabase, $condition, $order) {
        $query = $this->db->get_where($dtatabase, $condition);
        return $query->result();
    }
	function get_credit($id,$date)
    {
    	$query = $this->db->query("SELECT SUM(scd.amount) as total FROM sh_credit_debit scd JOIN sh_userdetail su ON su.id = scd.customer_id WHERE scd.status = '1' AND scd.date <= '$date' AND scd.payment_type ='c' AND scd.`customer_id` IS NOT NULL AND su.`location_id`='$id' AND su.status = '1'");
    	return $query->row();	
    }
	function get_debit($id,$date)
    {
    	$query = $this->db->query("SELECT SUM(scd.amount) as total FROM sh_credit_debit scd JOIN sh_userdetail su ON su.id = scd.customer_id WHERE scd.status = '1' AND scd.date <= '$date' AND scd.payment_type ='d' AND scd.`customer_id` IS NOT NULL AND su.`location_id`='$id' AND su.status = '1'");
    	return $query->row();	
    }
	public function report_date($location,$date){
        $query = $this->db->query("
        SELECT 
		si.created_date,
		su.UserFName,
            dr.date,
            dr.`id`,
            dr.`oil_reading`,
            dr.`oil_pure_benefit`,
            dr.`d_deep_reading`,
            dr.`d_sales_vat`,
            dr.`d_selling_price`,
            dr.`d_tank_reading`,
            dr.`d_total_selling`,
            dr.`p_deep_reading`,
            dr.`p_sales_vat`,
            dr.`p_selling_price`,
            dr.`p_tank_reading`,
            dr.`p_total_selling`,
			dr.p_testing,
			dr.d_testing,
			dr.cash_on_hand,
			dr.`d_tank_reading` AS dstock,
            dr.`p_tank_reading` AS pstock,
            SUM(si.`oil_total_amount`) AS ostok,
            SUM(si.oil_cgst) AS oil_cgst,
			SUM(si.oil_sgst) AS oil_sgst,
			SUM(si.d_price) AS bdprice,
			SUM(si.d_quantity) AS d_quantity,
			SUM(si.p_quantity) AS p_quantity,
			SUM(si.dv_taxamount) AS dv_taxamount,
			SUM(si.pv_taxamount) AS pv_taxamount,
			SUM(si.d_ev) AS d_ev,
			SUM(si.p_ev) AS p_ev,
			SUM(si.prev_d_price) AS d_new_price,
			SUM(si.prev_p_price) AS p_new_price,
			SUM(si.d_fuelamount) AS d_fuelamount,
			SUM(si.d_cess_tax) AS d_cess_tax,
			SUM(si.p_fuelamount) AS p_fuelamount,
			SUM(si.p_cess_tax) AS p_cess_tax,
			(SELECT SUM(sh_expensein_details.amount) FROM `sh_expensein_details`  WHERE sh_expensein_details.date=dr.date and sh_expensein_details.status='1') as expence,
			(SELECT SUM(sh_credit_debit.amount) FROM `sh_credit_debit`  WHERE sh_credit_debit.date=dr.date and sh_credit_debit.payment_type='d' and sh_credit_debit.customer_id is null and sh_credit_debit.location_id ='$location' and sh_credit_debit.status='1' ) as totalcard_fule,
			(SELECT SUM(sh_credit_debit.amount) FROM `sh_credit_debit`  WHERE sh_credit_debit.date=dr.date and sh_credit_debit.payment_type='ioc' and sh_credit_debit.customer_id is null and sh_credit_debit.location_id ='$location' and sh_credit_debit.status='1') as totalioc_fule,
			(SELECT SUM(sh_credit_debit.amount) FROM `sh_credit_debit`  JOIN shusermaster ON sh_credit_debit.`user_id` =  shusermaster.`id`   WHERE sh_credit_debit.date=dr.date and sh_credit_debit.payment_type='c' and sh_credit_debit.customer_id is not null and sh_credit_debit.location_id ='$location' and sh_credit_debit.status='1' AND shusermaster.`status` = 1) as totalcredit_fule,
			(SELECT SUM(sh_credit_debit.amount) FROM `sh_credit_debit`  WHERE sh_credit_debit.date=dr.date and sh_credit_debit.payment_type='d' and  sh_credit_debit.customer_id is not null  and sh_credit_debit.location_id ='$location' and sh_credit_debit.status='1') as totalcreditcash_fule,
			(SELECT sh_dailyprice.pet_price FROM `sh_dailyprice`  WHERE sh_dailyprice.date=dr.date and user_id='$location' and sh_dailyprice.status='1') as pet_price,
			(SELECT sh_dailyprice.dis_price FROM `sh_dailyprice`  WHERE sh_dailyprice.date=dr.date and user_id='$location' and sh_dailyprice.status='1') as dis_price
        FROM
            shdailyreadingdetails dr 
        JOIN sh_inventory si 
            ON si.`date` = dr.`date` 
			join shusermaster as su on su.id = si.user_id
        WHERE dr.`date` >= '$date'
        AND si.`date` <= '$date'
		AND dr.location_id = '$location'
		AND si.location_id = '$location'
        GROUP BY dr.date 
        ");
        
        return $query->row();
    }
	function get_deep($type)
    {
    	$query = $this->db->query("SELECT * FROM `sh_tank_dep_reding` WHERE `status` = 1 and tanktype='$type' order by cm asc");
    	return $query->result();	
    }
	function get_all_oil_stok(){
    	$query = $this->db->query("SELECT 
  sh.date,
  sh.id,
  sh.`oil_total_amount`,
  (SELECT sr.oil_reading FROM shdailyreadingdetails sr WHERE sr.status ='1' AND sr.location_id='53' AND sr.date = sh.date) AS sel 
FROM
  sh_inventory sh 
WHERE sh.fuel_type = 'o' 
  AND sh.`location_id` = '53' 
  AND sh.status = '1' 
  AND sh.date > '2018-08-31' 
ORDER BY sh.date ASC ");
    	return $query->result();	
    }
	function get_tank_readin($location_id,$sdate,$edate){
		$sql = "SELECT sts.id,sts.date,sts.`sales_id`,sts.`tank_id`,sts.`deepreading`,sts.`volume`,sts.`tank_name`,stl.`fuel_type` FROM `sh_tank_wies_reading_sales` sts  JOIN `sh_tank_list` stl ON stl.`id` = sts.`tank_id` WHERE sts.`status` = 1
AND sts.`location_id`='$location_id' AND sts.`date` >= '$sdate' AND sts.`date` <= '$edate'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function select_all_with_order($field, $dtatabase, $condition, $order) {
        $this->db->select($field);
        $this->db->order_by($order[0], $order[1]);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result();
        return $data['user'];
    }
	function get_tank_reading_sales($id){
		$sql ="SELECT stwr.`date`,stwr.`deepreading`,stwr.`tank_id`,stwr.`id`,stwr.`sales_id`,stwr.`volume`,stl.`fuel_type`,stl.`tank_name`,stl.`id` FROM `sh_tank_wies_reading_sales` stwr 
		JOIN sh_tank_list stl ON stl.`id` = stwr.`tank_id`
		WHERE stwr.`sales_id` = '$id' AND stl.`status` = '1' AND stwr.`status`='1'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function get_reading_tank($tank_id,$reading){
		$sql ="SELECT 
  sh_tank_chart.`id`,sh_tank_chart.`reading`,sh_tank_chart.`tank_id`,sh_tank_chart.`volume`,sh_tank_list.`fuel_type`
FROM
  `sh_tank_chart` 
  JOIN sh_tank_list ON sh_tank_list.`id` =  sh_tank_chart.`tank_id`
WHERE sh_tank_chart.`reading` = $reading
  AND sh_tank_chart.`tank_id` = '$tank_id'
  AND sh_tank_chart.`status` != '0' ";
		$query = $this->db->query($sql);
		return $query->row();
	}
	function updatealloilstock($location,$date,$stock){
		$sql ="UPDATE `sh_inventory` SET oil_total_amount = oil_total_amount+$stock  WHERE location_id= '$location' AND fuel_type='o' AND STATUS ='1' and date > '$date' ";
		$query = $this->db->query($sql);
		return '1';
	}
	function get_oil_detail($location_id,$sdate,$edate){
		$sql ="SELECT sp.packet_type,dr.date,rh.Reading,sp.spacket_value AS buyprice,sp.packet_value AS salesprice FROM shdailyreadingdetails dr 
JOIN shreadinghistory rh ON rh.RDRId = dr.id
JOIN shpump sp ON sp.id = rh.PumpId
WHERE dr.status = '1' AND dr.date >= '$sdate' AND dr.date <= '$edate' AND sp.type='O' AND rh.status='1' and dr.location_id = '$location_id'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function get_oil_detail_price($location_id,$sdate,$edate){
		$sql ="SELECT SUM(o.`stock`) AS stock,o.`date`, SUM((o.`bay_price`)* r_history.`Reading`) AS total_bay_price ,SUM(o.`sel_price`*r_history.`Reading`) AS total_sel_price FROM sh_oil_daily_price AS o JOIN shpump AS p ON p.id = o.`o_p_id` JOIN `shreadinghistory` AS r_history ON r_history.`PumpId` = p.`id` AND r_history.`date`= o.`date` AND r_history.`status` = 1 WHERE p.`location_id` = '$location_id' AND  o.date >= '$sdate' AND  o.date <= '$edate' and p.status='1' and r_history.`Reading` != 0 GROUP BY o.`date` ";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function get_oil_detail_price_date($location_id,$date){
		$sql ="SELECT o.*,p.`new_p_qty`,p.`p_type` FROM sh_oil_daily_price AS o 
  JOIN shpump AS p ON p.id = o.`o_p_id` 
  WHERE p.`location_id` = '$location_id' 
  AND o.date = '$date' 
  AND p.status = '1' 
  AND o.`status`='1'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function get_oil_detail_separate_price($location_id,$date){
		$sql ="SELECT p.`p_type`,p.`name`,p.`packet_type`,p.new_p_qty as p_qty, d_p.`stock`,d_p.`date` FROM `sh_oil_daily_price` AS d_p 
JOIN `shreadinghistory` AS rh ON rh.`PumpId` = d_p.`o_p_id` AND rh.`date` = '$date' AND rh.`status` = 1
JOIN `shpump` AS p ON p.`id` = d_p.`o_p_id`
 WHERE p.`location_id` = '$location_id' AND d_p.date = '$date'  ";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function get_oil_detail_separate_price_total($location_id,$date){
		$sql ="SELECT SUM(d_p.`bay_price`*d_p.`stock`) AS total FROM `sh_oil_daily_price` AS d_p 
JOIN `shreadinghistory` AS rh ON rh.`PumpId` = d_p.`o_p_id` AND rh.`date` = '$date' AND rh.`status` = 1
JOIN `shpump` AS p ON p.`id` = d_p.`o_p_id`
 WHERE p.`location_id` = '$location_id' AND d_p.date = '$date' and p.status='1' ";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function prev_petty_cash_deposit($cid,$month){		
		$query = $this->db->query("SELECT SUM(amount) as total FROM petty_cash_transaction WHERE type='d' and location_id='$cid' and status='1' AND date < '$month' and transaction_type != 'cs' ");   
                return $query->row();	
	}
	public function prev_petty_cash_withdrawal($cid,$month){		
		$query = $this->db->query("SELECT SUM(amount) as total FROM petty_cash_transaction WHERE type='c' and location_id='$cid' and status='1' AND date < '$month' and transaction_type != 'cs' ");    
                return $query->row();	
	}
	public function prev_petty_cash_deposit_cash($cid,$month){		
		$query = $this->db->query("SELECT SUM(amount) as total FROM petty_cash_transaction WHERE type='d' and location_id='$cid' and status='1' AND date < '$month' and transaction_type = 'cs' "); 
                return $query->row();	
	}
	public function prev_petty_cash_withdrawal_cash($cid,$month){		
		$query = $this->db->query("SELECT SUM(amount) as total FROM petty_cash_transaction WHERE type='c' and location_id='$cid' and status='1' AND date < '$month' and transaction_type = 'cs'  "); 
                return $query->row();	
	}
        public function total_balance($lid,$sdate,$edate){
            $where = "";
            if($lid != ""){
                $where.= " AND c.`location_id` = $lid";
            }
            if($edate != ""){
              $where.=  " AND c.date <= '$edate'";
            }
			 if($sdate != ""){
              $where.=  " AND c.date >= '$sdate'";
            }
            
            $query = $this->db->query("SELECT 
  SUM(IF(c.`transaction_type`= 'cs' AND c.`type` = 'd', amount, 0)) AS cashdebit,
  SUM(IF(c.`transaction_type`= 'cs' AND c.`type` = 'c', amount, 0)) AS creshcrdit,
  SUM(IF(c.`transaction_type`= 'c' AND c.`type` = 'c', amount, 0)) AS checkcrdit,
  SUM(IF(c.`transaction_type`= 'c' AND c.`type` = 'd', amount, 0)) AS checkdebit,
  SUM(IF(c.`transaction_type`= 'n' AND c.`type` = 'c', amount, 0)) AS netcrdit,
  SUM(IF(c.`transaction_type`= 'n' AND c.`type` = 'd', amount, 0)) AS netdebit
  FROM
  `petty_cash_transaction` AS c 
WHERE  c.`status` = 1  $where
");
            
            
		 return $query->result();
            
        }
		
		public function report_data($lid,$sdate){
            $where = "";
            if($lid != ""){
                $where.= " AND c.`location_id` = $lid";
            }
            if($sdate != ""){
              $where.=  " AND c.date = '$sdate'";
            }
            $query = $this->db->query("SELECT c.`date`,
SUM(IF(c.`transaction_type` = 'cs' AND c.`type` = 'd',amount,0)) AS cashdebit,
SUM(IF( c.`transaction_type` = 'cs' AND c.`type` = 'c',amount,0)) AS creshcrdit,
 SUM(IF(c.`transaction_type` = 'c' AND c.`type` = 'c',amount,0)) + SUM(IF(c.`transaction_type` = 'n' AND c.`type` = 'c',amount,0)) AS bank_cradit,
 SUM(IF(c.`transaction_type` = 'c' AND c.`type` = 'd',amount,0)) + SUM(IF(c.`transaction_type` = 'n' AND c.`type` = 'd',amount,0)) AS bank_debit 
FROM
  `petty_cash_transaction` AS c 
WHERE c.`status` = 1  $where  GROUP BY c.date ORDER BY c.date ASC
");
            
            
		 return $query->result_array();
            
        }
		
		public function oil_report($location,$sdate,$edate){
        $query = $this->db->query("SELECT rh.id,rh.`date`,rh.`qty`,rh.`RDRId`,rh.`Reading`,sp.id AS o_id,sp.`name`,sp.`packet_type`,sp.`packet_value`,sp.`p_qty`,sp.`p_type`,sp.`spacket_value`
FROM
    shdailyreadingdetails dr 
JOIN shreadinghistory rh ON rh.`RDRId` = dr.`id`
JOIN shpump sp ON sp.id = rh.`PumpId`
WHERE dr.`date` >= '$sdate'
AND dr.`date` <= '$edate'
AND dr.location_id = '$location'
AND dr.status = '1'
AND rh.`Type`='o'
AND rh.`status`='1'
ORDER BY dr.date ASC");
        return $query->result();
    }
    public function oil_data($location,$date){
        $query = $this->db->query("SELECT * FROM sh_oil_inventory_data_master  WHERE location_id = '$location' AND DATE = '$date'");
        return $query->result();
    }
    public function all_oil_data($main_id){
        $query = $this->db->query("SELECT sh_oil_inventory_data.*,shpump.`name`,shpump.`packet_type`  FROM sh_oil_inventory_data  JOIN `shpump` ON shpump.`id` = sh_oil_inventory_data.`p_id` WHERE sh_oil_inventory_data.`o_m_id` = '$main_id'");
        return $query->result();
    }
    public function get_bay_stock_details($location_id, $sdate, $edate){
        $query = $this->db->query("SELECT 
si.`date`,
  SUM(soi.`ltr`) AS total_qty_ltr,
  SUM(soi.`qty`) AS total_qty
FROM
  sh_inventory si 
  JOIN sh_oil_inventory soi 
    ON soi.`inv_id` = si.`id` 
  JOIN shpump sp 
    ON sp.`id` = soi.`oil_id` 
WHERE si.location_id = '$location_id' 
  AND si.fuel_type = 'o' 
  AND si.`date` <= '$edate' 
  AND si.`date` >= '$sdate' 
  AND si.status = '1' 
  AND soi.status = '1' 
  AND sp.status = '1' 
GROUP BY si.`date`");
        return $query->result();
    }
	public function vatList( $sdate, $edate){
        $query = $this->db->query("SELECT * FROM vat_list WHERE `date` <= '$edate' AND `date` >= '$sdate' ");
        return $query->result();
    }
	public function savingList( $lid,$sdate, $edate){
        $query = $this->db->query("SELECT SUM(amount) as total,date FROM saving_member_transaction WHERE `date` <= '$edate' AND `date` >= '$sdate' and location_id='$lid' and status='1' GROUP BY DATE ");
        return $query->result();
    }
	public function oilstokofdate($lid,$date){
        $query = $this->db->query("SELECT sh_oil_daily_price.o_p_id,sh_oil_daily_price.`stock` FROM sh_oil_daily_price WHERE sh_oil_daily_price.`date`='$date' AND sh_oil_daily_price.`location_id`='$lid' 
ORDER BY sh_oil_daily_price.`o_p_id` ASC");
        return $query->result();
    }
	public function oilsellingofdate($lid,$date){
        $query = $this->db->query("SELECT shreadinghistory.`PumpId`,shreadinghistory.`Reading`,shpump.packet_type as name FROM `shreadinghistory` JOIN shpump ON shpump.`id` = shreadinghistory.`PumpId` 
WHERE shreadinghistory.type = 'o' AND  shreadinghistory.date = '$date' AND shreadinghistory.`status`='1' AND shpump.`location_id`='$lid' 
ORDER BY shpump.id ASC");
        return $query->result();
    }	
	
	public function setbuysel(){
        $query = $this->db->query("SELECT * FROM sh_oil_daily_price WHERE `date` = '2019-04-01' AND `location_id` = '53'");
        return $query->result();
    }
	public function get_dailyselling_list($sdate,$edate,$location_id){
        $query = $this->db->query("SELECT * FROM shdailyreadingdetails sdd WHERE sdd.date >= '$sdate' AND sdd.date <= '$edate' AND sdd.`location_id` = '$location_id' AND sdd.`status`='1'");
        return $query->result();
    }
	public function get_dailyprice_list($sdate,$edate,$location_id){
        $query = $this->db->query("SELECT * FROM `sh_dailyprice`  WHERE sh_dailyprice.date >= '$sdate' AND sh_dailyprice.date <= '$edate' AND sh_dailyprice.user_id='$location_id' AND sh_dailyprice.status='1'");
        return $query->result();
    }
	public function get_dailyinv_list($sdate,$edate,$location_id){
        $query = $this->db->query("SELECT * FROM sh_inventory WHERE sh_inventory.`status`='1' AND sh_inventory.`date` >= '$sdate' AND sh_inventory.`date` <= '$edate' AND sh_inventory.`location_id` ='$location_id'");
        return $query->result();
    }
	public function get_expencetotal($sdate,$edate,$location_id){
        $query = $this->db->query("SELECT SUM(sh_expensein_details.amount) as totlexpence FROM `sh_expensein_details`  WHERE sh_expensein_details.`date` >= '$sdate' AND sh_expensein_details.`date` <= '$edate' AND sh_expensein_details.status='1' AND sh_expensein_details.location_id = '$location_id'");
        return $query->row();
    }
	public function patycashin($location_id, $edate){
        $query = $this->db->query("SELECT 
SUM(amount) AS totalamount
FROM
  `petty_cash_transaction` 
WHERE `status` = '1' 
  AND `type` = 'd' 
  AND `date` <= '$edate' 
  AND `location_id` = '$location_id' 
AND status ='1'");
        return $query->row();
    }
	public function patycashout($location_id, $edate){
        $query = $this->db->query("SELECT 
SUM(amount) AS totalamount
FROM
  `petty_cash_transaction` 
WHERE `status` = '1' 
  AND `type` = 'c' 
  AND `date` <= '$edate' 
  AND `location_id` = '$location_id' 
AND status ='1'");
        return $query->row();
    }
	public function get_oil_in_price($location_id, $sdate, $edate){
        $query = $this->db->query("SELECT SUM(odp.`sel_price`* srd.`Reading`) AS price FROM shdailyreadingdetails sdr 
JOIN `shreadinghistory` srd ON srd.`RDRId` = sdr.`id` AND srd.`status`='1' AND  srd.`Type`='o' AND srd.`Reading` != '0'
JOIN sh_oil_daily_price odp ON odp.`o_p_id` = srd.`PumpId` AND  odp.date = sdr.date
WHERE sdr.`status`='1' AND sdr.`location_id`='$location_id' AND sdr.date >= '$sdate' AND sdr.`date` <= '$edate'");
        return $query->row();
    }
	public function get_inventory_list($location_id, $sdate, $edate){
        $query = $this->db->query("SELECT si.*,soidm.benefits,soidm.charges FROM sh_inventory si 
		LEFT JOIN sh_oil_inventory_data_master soidm ON soidm.date = si.date AND soidm.location_id = '$location_id' AND si.fuel_type='o' and soidm.status='1'
		WHERE si.status = '1' AND si.location_id = '$location_id' AND  si.date >= '$sdate' AND si.date <= '$edate' order by date,fuel_type asc");
        return $query->result();
    }
	public function company_credit($location_id, $sdate, $edate){
        $query = $this->db->query("SELECT SUM(amount) AS totalamount,date,location_id FROM sh_company_credit_debit WHERE DATE >= '$sdate' AND DATE <= '$edate' AND location_id = '$location_id' and type='c' and status='1' GROUP BY DATE");
        return $query->result();
    }
	public function company_debit($location_id, $sdate, $edate){
        $query = $this->db->query("SELECT SUM(amount) AS totalamount,date,location_id FROM sh_company_credit_debit WHERE DATE >= '$sdate' AND DATE <= '$edate' AND location_id = '$location_id' and type='d' and status='1' GROUP BY DATE");
        return $query->result();
    }
	public function company_credit_total($location_id, $sdate, $edate){
        $query = $this->db->query("SELECT SUM(amount) AS totalamount,date,location_id FROM sh_company_credit_debit WHERE DATE >= '$sdate' AND DATE <= '$edate' AND location_id = '$location_id' and type='c' and status='1' ");
        return $query->row();
    }
	public function company_debit_total($location_id, $sdate, $edate){
        $query = $this->db->query("SELECT SUM(amount) AS totalamount,date,location_id FROM sh_company_credit_debit WHERE DATE >= '$sdate' AND DATE <= '$edate' AND location_id = '$location_id' and type='d' and status='1'");
        return $query->row();
    }
	public function bank_expense($location_id, $sdate, $edate){
        $query = $this->db->query("SELECT SUM(amount) AS totalamount,date,location_id FROM sh_expensein_details WHERE DATE >= '$sdate' AND DATE <= '$edate' AND location_id = '$location_id' and expense_type='bank' and status ='1' GROUP BY DATE");
        return $query->result();
    }
	public function onlinetransaction_cs($location_id, $sdate, $edate){
        $query = $this->db->query("SELECT SUM(amount) AS totalamount,date,location_id FROM sh_onlinetransaction WHERE DATE >= '$sdate' AND DATE <= '$edate' AND location_id = '$location_id' and paid_by='cs' and status ='1' GROUP BY DATE");
        return $query->result();
    }
	public function total_company_debit($location_id, $sdate){
        $query = $this->db->query("SELECT SUM(amount) AS totalamount,date,location_id FROM sh_company_credit_debit WHERE DATE < '$sdate'  AND location_id = '$location_id' and type='d' and status ='1' ");
        return $query->row();
    }
	public function total_company_credit($location_id, $sdate){
        $query = $this->db->query("SELECT SUM(amount) AS totalamount,date,location_id FROM sh_company_credit_debit WHERE DATE < '$sdate'  AND location_id = '$location_id' and type='c' and status ='1' ");
        return $query->row();
    }
	public function get_tank_chart($id){
        $query = $this->db->query("SELECT reading,volume FROM `sh_tank_chart` WHERE tank_id='$id' AND STATUS = '1'");
        return $query->result();
    }
	}