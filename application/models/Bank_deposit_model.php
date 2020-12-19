<?php
class bank_deposit_model extends CI_Model
{
	var $table = 'sh_bankdeposit as shi';
   	var $column_order = array(null, 'location.l_name','user.UserFName','shi.date','shi.deposit_amount','shi.withdraw_amount','shi.deposited_by','shi.cheque_no'); //set column field database for datatable orderable
   var $column_search = array( 'location.l_name','user.UserFName','shi.date','shi.deposit_amount','shi.withdraw_amount','shi.deposited_by','shi.cheque_no'); //set column field database for datatable searchable
   var $order = array('shi.id' => 'desc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

	private function _get_datatables_query()
   	{
       
    $this->db->select('location.l_name,user.UserFName,shi.id,shi.date,shi.deposit_amount,shi.withdraw_amount,shi.deposited_by,shi.cheque_no');
		
    $this->db->join('shusermaster user','user.id=shi.user_id');
    $this->db->join('sh_location location','location.l_id=user.l_id');

    $this->db->from($this->table);
    // $this->db->join('sh_location as shl','shl.l_id = shr.l_id', 'inner');


		$this->db->where(array('shi.status'=>1));	

   	    $i = 0;
   
    	foreach ($this->column_search as $item) // loop column
       	{
           if($_POST['search']['value']) // if datatable send POST for search
           {
               
               if($i===0) // first loop
               {
                   $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                   $this->db->like($item, $_POST['search']['value']);
               }
               else
               {
                   $this->db->or_like($item, $_POST['search']['value']);
               }

               if(count($this->column_search) - 1 == $i) //last loop
                   $this->db->group_end(); //close bracket
           }
           $i++;
       }
       	// $this->db->where('shr.type', '2');
        $this->db->where('shi.status', 1);
       if(isset($_POST['order'])) // here order processing
       {
           $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
       }
       else if(isset($this->order))
       {
           $order = $this->order;
           $this->db->order_by(key($order), $order[key($order)]);
       }
   }

   function get_datatables($extra="",$id = "",$employeename ="",$fdate = "",$tdate = "",$location="",$current_date="")
   {
       $this->_get_datatables_query();
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
		if($extra != "")
		{
			$this->db->where("Type",$extra);
		}
    if($id != "")
    {
      $this->db->where("user.company_id",$id);
    }
    if($employeename != "")
    {
      $this->db->where("user.id",$employeename);
    }if ($fdate != "") {
    $newfdate = date('Y-m-d', strtotime($fdate));
         $this->db->where('shi.date >=', $newfdate);
        }if ($tdate != "") {
      $newtdate = date('Y-m-d', strtotime($tdate));
         $this->db->where('shi.date <=', $newtdate);
        }
    if ($location != "") 
    {
      $this->db->where('user.l_id',$location);
    }
    if ($fdate =="" && $tdate =="") 
    {
      $this->db->where('date',$current_date);
    }
    // if($id != "")
    // {
    //   $this->db->where("shr.company_id",$id);
    // }
       $query = $this->db->get();
       return $query->result();
   }

   function count_filtered($extra="",$id = "",$employeename ="",$fdate = "",$tdate = "",$location="",$current_date="")
   {
       $this->_get_datatables_query();
		if($id != "")
    {
      $this->db->where("user.company_id",$id);
    }
    if($employeename != "")
    {
      $this->db->where("user.id",$employeename);
    }if ($fdate != "") {
    $newfdate = date('Y-m-d', strtotime($fdate));
         $this->db->where('shi.date >=', $newfdate);
        }if ($tdate != "") {
      $newtdate = date('Y-m-d', strtotime($tdate));
         $this->db->where('shi.date <=', $newtdate);
        }
    if ($location != "") 
    {
      $this->db->where('user.l_id',$location);
    }
    if ($fdate =="" && $tdate =="") 
    {
      $this->db->where('date',$current_date);
    }
       $query = $this->db->get();
       return $query->num_rows();
   }

   public function count_all($extra="")
    {
        $this->db->from($this->table);
		if($extra != ""){
			$this->db->where("Type",$extra);
		}
		$this->db->where("status","1");
        return $this->db->count_all_results();
    }
	public function pre_cheq_deposit_amount($lid,$sdate){
$query = $this->db->query('SELECT SUM(amount) as cheque_total FROM `sh_credit_debit` WHERE STATUS = 1 AND location_id = "'.$lid.'" AND DATE < "'.$sdate.'" AND (transaction_type = "c" OR transaction_type = "n")');       
		return $query->ROW();	
	}
	public function bankdeposit_list_new($lid,$sdate,$edate){
$query = $this->db->query('SELECT SUM(amount) as cs_total,date FROM `sh_credit_debit` WHERE STATUS = 1 AND location_id = "'.$lid.'" AND DATE >= "'.$sdate.'" AND DATE <= "'.$edate.'" AND (transaction_type = "c" OR transaction_type = "n") group by date');       
		return $query->result();	
	}
	public function bankdeposit_list($sdate,$edate,$lid)
    {
      $this->db->select('id,sh_bankdeposit.date,SUM(deposit_amount) as deposit_amount,SUM(withdraw_amount) as withdraw_amount,SUM(amount) as depositamonut, cheque_no,bank_name, 1 as flage,
	  (SELECT SUM(amount) FROM `sh_credit_debit` WHERE STATUS = 1 AND location_id = "'.$lid.'"AND date = sh_bankdeposit.date
 AND (transaction_type = "c" or transaction_type = "n")) as cs_total');
      $this->db->from('sh_bankdeposit');
      $this->db->where('status','1');
	  $this->db->where('date <= ',$edate);
	  $this->db->where('date >=',$sdate);
	  $this->db->where('location_id',$lid);
	  $this->db->order_by('date','ASC');
          $this->db->group_by('date');
      $q1 = $this->db->get();
      return $q1->result();
    }
	
   
	public function online_list($sdate,$edate,$lid)
    {
      $this->db->select('id,SUM(sh_onlinetransaction.amount) as amount,sh_onlinetransaction.cheque_tras_no,sh_onlinetransaction.date, 2 as flage');
      $this->db->from('sh_onlinetransaction');
      $this->db->where('status','1');
	  $this->db->where('date <= ',$edate);
	  $this->db->where('date >=',$sdate);
	  $this->db->where('location_id',$lid);
	  $this->db->order_by('date','ASC');
            $this->db->group_by('date');
      $q1 = $this->db->get();
      return $q1->result();
    }
	public function online_lists($date,$lid)
    {
      $this->db->select('id,sh_onlinetransaction.amount as amount,sh_onlinetransaction.cheque_tras_no,sh_onlinetransaction.date, 2 as flage');
      $this->db->from('sh_onlinetransaction');
      $this->db->where('status','1');
	  $this->db->where('date',$date);
	  //$this->db->where('date >=',$sdate);
	  $this->db->where('location_id',$lid);
	  $q1 = $this->db->get();
      return $q1->result();
    }
    public function select_all($field,$condition){
        
        $query = $this->db->get_where($field, $condition);
        $data['user'] = $query->result();
        return $data['user'];
    }

    public function bankdeposit_info($id)
    {
      $this->db->select('*');
      $this->db->from('sh_bankdeposit as shi');
      $this->db->join('shusermaster as sh','sh.id=shi.user_id','inner');
      $this->db->join('sh_location as shl','shl.l_id=shi.location_id','inner');
      $this->db->where('shi.id',$id);
      $q1 = $this->db->get();
      return $q1->result();
    }
	  public function online_info($id)
    {
      $this->db->select('shi.*,sh.*,u.`name` as cus_name');
      $this->db->from('sh_onlinetransaction as shi');
      $this->db->join('shusermaster as sh','sh.id=shi.user_id','inner');
      $this->db->join('sh_location as shl','shl.l_id=shi.location_id','inner');
      $this->db->join('sh_userdetail as u','shi.`customer_name` =  u.`id`','inner');
      $this->db->where('shi.id',$id);
      $q1 = $this->db->get();
      return $q1->result();
    }


    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_bankdeposit',$data);
    }
	function delete2($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_onlinetransaction',$data);
    }
	function upadte_expance_detail($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_expensein_details',$data);
    }
	 function update($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_bankdeposit',$data);
    }
    
     function updatesalay($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_workers_salary',$data);
    }
     function update_cardit_info($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_credit_debit',$data);
    }
	function update2($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_onlinetransaction',$data);
    }
     public function creadit_dabit_list($fdate,$edate,$id){		
		$query = $this->db->query("SELECT SUM(amount) AS card_amount,id,location_id,date,batch_no, 3 as flage FROM `sh_credit_debit` 
WHERE STATUS = 1 AND payment_type = 'd'  
AND date <= '$edate'
AND date >= '$fdate'
and location_id = '$id' AND batch_no IS NOT NULL GROUP BY DATE");       
		return $query->result();	
	}
	public function creadit_dabit_lists($date,$lid){
$this->db->select('`sh`.`name` AS name,amount,1 AS `flage` ,c.*');
      $this->db->from('sh_credit_debit as c');
      $this->db->join('`sh_userdetail` AS `sh`' ,'sh.`id` = c.`customer_id`');
      $this->db->where('c.status','1');
      $this->db->where('c.date',$date);
      $this->db->where('c.location_id',$lid);
      $where = '(c.transaction_type = "c" 
      OR c.transaction_type = "n")';
      $this->db->where($where);
      $this->db->order_by('c.date','ASC');
       $q1 = $this->db->get();		
		return $q1->result();
	}
	public function wallet_list($fdate,$edate,$id){		
		$query = $this->db->query("SELECT SUM(amount) AS card_amount,id,location_id,date,batch_no, 4 as flage FROM `sh_credit_debit` 
WHERE STATUS = 1 AND payment_type = 'extra'  
AND date <= '$edate'
AND date >= '$fdate'
and location_id = '$id' AND batch_no IS NOT NULL GROUP BY DATE");       
		return $query->result();	
	}
    public function master_fun_get_tbl_val1($dtatabase, $condition) {
        $this->db->select('UserFName, id');
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_location($dtatabase, $condition) {
        $this->db->select('l_name, l_id');
		$this->db->order_by('l_name','ASC');
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array(); 
        return $data['user'];
    }
	public function master_fun_get_tbl_val_location_new($cid)
    { 
	$query = $this->db->query("SELECT `l_name`, `l_id` FROM `sh_location` WHERE `status` = 1 AND `show_hide` = 'show' AND `company_id` = '$cid' ORDER BY `l_name` ASC");
		return $query->result_array();
    }
    public function master_fun_get_tbl_val_workers($dtatabase, $condition) {
        $this->db->select('name, id');
		$this->db->order_by('name','ASC');
		$query = $this->db->get_where($dtatabase, $condition); 
        $data['user'] = $query->result_array();
        return $data['user'];
    }
     public function bankdeposit_list_view($date,$lid)
    {
      $this->db->select('id,sh_bankdeposit.date,deposit_amount as deposit_amount,withdraw_amount as withdraw_amount,amount as depositamonut, cheque_no,bank_name, 1 as flage');
      $this->db->from('sh_bankdeposit');
      $this->db->where('status','1');
	  $this->db->where('date = ',$date);
	  $this->db->where('location_id',$lid);
	  $this->db->order_by('date','ASC');
      $q1 = $this->db->get();
      return $q1->result();
    } 
     public function bankdeposit_list_view_new($date,$lid)
    {
      $this->db->select('GROUP_CONCAT(DISTINCT `sh`.`name`) AS name,SUM(amount) AS famount,1 AS `flage` ,c.*');
      $this->db->from('sh_credit_debit as c');
      $this->db->join('`sh_userdetail` AS `sh`' ,'sh.`id` = c.`customer_id`');
      $this->db->where('c.status','1');
      $this->db->where('c.date = ',$date);
      $this->db->where('c.location_id',$lid);
      $where = '(c.transaction_type = "c" 
      OR c.transaction_type = "n")';
      $this->db->where($where);
      $this->db->order_by('c.date','ASC');
       $this->db->group_by(' c.`date`');
       $this->db->group_by(' c.`bankdeposit_id`');
      $q1 = $this->db->get();
      
      return $q1->result();
    }
    public function online_list_view($date,$lid)
    {
        $this->db->select('sh_onlinetransaction.id,sh_onlinetransaction.bank_name,sh_onlinetransaction.amount,sh_onlinetransaction.paid_by,sh_onlinetransaction.cheque_tras_no,sh_onlinetransaction.date, 2 as flage,sh.name as user_name');
      $this->db->from('sh_onlinetransaction');
        $this->db->join('sh_creditors as sh','sh.id=sh_onlinetransaction.customer_name','left');
      $this->db->where('sh_onlinetransaction.status','1');
	  $this->db->where('sh_onlinetransaction.date = ',$date);
	  $this->db->where('sh_onlinetransaction.location_id',$lid);
	  $this->db->where('sh_onlinetransaction.paid_by !=','cs');
	  $this->db->order_by('sh_onlinetransaction.date','ASC');
	  
      $q1 = $this->db->get();
      return $q1->result();
    }
    public function creadit_dabit_list_view($date,$id){		
		$query = $this->db->query("SELECT amount AS card_amount,id,location_id,date,batch_no, 3 as flage FROM `sh_credit_debit` 
WHERE STATUS = 1 AND payment_type = 'd'  
AND date = '$date'
and location_id = '$id' AND batch_no IS NOT NULL ");       
		return $query->result();	
	}
	public function wallet_list_view($date,$id){		
		$query = $this->db->query("SELECT amount,id,location_id,date,batch_no FROM `sh_credit_debit` 
WHERE STATUS = 1 AND payment_type = 'extra'  
AND date = '$date'
and location_id = '$id' AND batch_no IS NOT NULL ");       
		return $query->result();	
	}
    public function card_info($id)
    {
      $query = $this->db->query("SELECT ch.amount AS card_amount,ch.id,ch.location_id,ch.date,l.`l_name`,ch.batch_no,ch.extra_id,sh.`UserFName`,3 AS flage FROM `sh_credit_debit`  AS ch JOIN shusermaster AS sh ON sh.`id` = ch.`user_id` JOIN sh_location AS l ON l.`l_id` = ch.`location_id` WHERE ch.STATUS = 1  AND ch.payment_type = 'd' AND ch.id = '$id' AND ch.batch_no IS NOT NULL ");       
		return $query->result();
    }
    public function wallet_info($id)
    {
      $query = $this->db->query("SELECT ch.amount AS card_amount,ch.id,ch.location_id,ch.date,l.`l_name`,ch.batch_no,ch.extra_id,ch.batch_no,sh.`UserFName`,3 AS flage FROM `sh_credit_debit`  AS ch JOIN shusermaster AS sh ON sh.`id` = ch.`user_id` JOIN sh_location AS l ON l.`l_id` = ch.`location_id` WHERE ch.STATUS = 1  AND ch.payment_type = 'extra' AND ch.id = '$id' AND ch.batch_no IS NOT NULL ");       
		return $query->result();
    }
	public function ptypebylocation($id){
		$query = $this->db->query("SELECT * FROM sh_wallet_list WHERE STATUS = 1 AND location_id = '$id' ");       
		return $query->result();
	}
    function update_card_details($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_credit_debit',$data);
    }
     public function get_location($id){
            $query = $this->db->query("SELECT l.* FROM sh_madetor_l_id AS  m 
JOIN `sh_location` AS l ON l.`l_id` =m.`l_id`  
WHERE m.`status` = 1 
AND l.`status` = 1
AND l.`show_hide` = 'show'
AND m.`m_id`= '$id'
ORDER BY  l.l_name ASC ");
		return $query->result_array();
            
        }
		
	public function petty_cash_deposit_list($sdate,$edate,$lid)
    {
      $this->db->select('id,petty_cash_transaction.date,SUM(amount) as total');
      $this->db->from('petty_cash_transaction');
      $this->db->where('status','1');
	  $this->db->where('type','d');
	  $this->db->where('transaction_type != ','cs');
	  $this->db->where('date <= ',$edate);
	  $this->db->where('date >=',$sdate);
	  $this->db->where('location_id',$lid);
	  $this->db->order_by('date','ASC');
	  $this->db->group_by('date');
      $q1 = $this->db->get();
      return $q1->result();
    }
	public function petty_cash_withdrawal_list($sdate,$edate,$lid)
    {
      $this->db->select('id,petty_cash_transaction.date,SUM(amount) as total');
      $this->db->from('petty_cash_transaction');
      $this->db->where('status','1');
	  $this->db->where('type','c');
	  $this->db->where('transaction_type != ','cs');
	  $this->db->where('date <= ',$edate);
	  $this->db->where('date >=',$sdate);
	  $this->db->where('location_id',$lid);
	  $this->db->order_by('date','ASC');
	  $this->db->group_by('date');
      $q1 = $this->db->get();
      return $q1->result();
    }
	public function get_petty_cash_tasection_list($date,$lid){
		$this->db->select('petty_cash_transaction.remark,petty_cash_transaction.`date`,petty_cash_transaction.id,petty_cash_transaction.`amount`,petty_cash_transaction.`type`,petty_cash_transaction.`transaction_type`,petty_cash_transaction.`transaction_no`,petty_cash_member.`name`');
		$this->db->from('petty_cash_transaction');	
		$this->db->join('`petty_cash_member`','`petty_cash_member`.`id` = `petty_cash_transaction`.`member_id`');
		$this->db->where('petty_cash_transaction.status', '1');
		$this->db->where('petty_cash_transaction.transaction_type != ', 'cs');
		if ($lid != ""){
			$this->db->where('petty_cash_member.`location_id`',$lid);
		}
		if ($date){
			$this->db->where('petty_cash_transaction.`date`',$date);
		}
		$query = $this->db->order_by('petty_cash_transaction.`date`','asc');
		$query = $this->db->get();
		return $query->result();
	}
  // 01-05-2019 mehul code start
  public function get_report_type($id,$date){
  $where = array('sh_credit_debit.status' =>'1',
                  'sh_credit_debit.payment_type' =>'d',
                  'sh_credit_debit.date' =>$date,
                  'sh_credit_debit.location_id' =>$id
                  //'sh_credit_debit.batch_no'=> NOT NULL
              );    
  $this->db->SELECT(',sh_credit_debit.amount,sh_credit_debit.location_id,date,batch_no,3 as flage');
  $this->db->FROM('sh_credit_debit');
 //$this->db->JOIN('sh_card_list','sh_card_list.id  = sh_credit_debit.type','inner'); 
$this->db->WHERE($where);
$this->db->WHERE('batch_no is NOT NULL', NULL, FALSE);  
$query = $this->db->get();     
    return $query->result_array();  
  }
  public function online_bank_expance($date,$lid){
            /*$query = $this->db->query("SELECT * from sh_onlinetransaction where status = '1' and location_id ='$lid' and  date = '$date'");*/
			$this->db->select('sh_onlinetransaction.id,sh_onlinetransaction.amount,sh_onlinetransaction.paid_by,sh_onlinetransaction.cheque_tras_no,sh_onlinetransaction.date, 2 as flage,sh.name as user_name');
      $this->db->from('sh_onlinetransaction');
        $this->db->join('sh_creditors as sh','sh.id=sh_onlinetransaction.customer_name','inner');
      $this->db->where('sh_onlinetransaction.status','1');
	  $this->db->where('sh_onlinetransaction.date = ',$date);
	  $this->db->where('sh_onlinetransaction.location_id',$lid);
	  $this->db->where('sh_onlinetransaction.paid_by','cs');
	  $this->db->order_by('sh_onlinetransaction.date','ASC');
      $q1 = $this->db->get();
      return $q1->result();
		//return $query->result();
            
        }
		
		public function online_bank_expance_dailyreport($lid,$sdate,$edate){
			$this->db->select('SUM(sh_onlinetransaction.amount) as amount ,sh_onlinetransaction.date');
			$this->db->from('sh_onlinetransaction');
			$this->db->where('sh_onlinetransaction.status','1');
			$this->db->where('sh_onlinetransaction.date >= ',$sdate);
			$this->db->where('sh_onlinetransaction.date <= ',$edate);
			$this->db->where('sh_onlinetransaction.location_id',$lid);
			$this->db->where('sh_onlinetransaction.paid_by','cs');
			$this->db->order_by('sh_onlinetransaction.date','ASC');
			$q1 = $this->db->get();
			return $q1->result();
		//return $query->result();
            
        }
		
	public function expanses_online($id){
		$query = $this->db->query("SELECT * from sh_onlinetransaction where status = '1' and id ='$id'");
		return $query->row();
	}
  //01-05-2019 mehul code end
}
?>