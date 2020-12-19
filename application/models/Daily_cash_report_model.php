<?php
class daily_cash_report_model extends CI_Model
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
        public function get_cash_on_hand($fdate, $tdate, $location){
            $query = $this->db->query("SELECT 
  dr.date,
  dr.cash_on_hand
FROM
  shdailyreadingdetails dr  
WHERE dr.`date` >= '$fdate'  
  AND dr.`date` <= '$tdate' 
  AND dr.location_id = '$location' 
GROUP BY dr.date ");
		return $query->result();
            
        }
        public function get_bank_deposit($fdate, $tdate, $location){
            $query = $this->db->query("SELECT  sh_bankdeposit.`date`,SUM(sh_bankdeposit.`deposit_amount`) as deposit_amount,SUM(sh_bankdeposit.`amount`) as amount FROM `sh_bankdeposit`  
WHERE sh_bankdeposit.`date` >= '$fdate'  
  AND sh_bankdeposit.`date` <= '$tdate' 
  AND sh_bankdeposit.location_id = '$location' 
GROUP BY sh_bankdeposit.date ");
		return $query->result();
            
        }
        public function get_petty_cash_in($fdate, $tdate, $location){
            $query = $this->db->query("SELECT pct.`date`, SUM(pct.`amount`) AS petty_cash_in FROM `petty_cash_transaction` AS pct   
WHERE pct.`date` >= '$fdate'  
  AND pct.`date` <= '$tdate' 
  AND pct.location_id = '$location' 
  AND pct.`status` = 1 AND pct.type = 'd' AND pct.`transaction_type` = 'cs'
GROUP BY pct.date ");
		return $query->result();
            
        }
		public function get_petty_cash_out($fdate, $tdate, $location){
            $query = $this->db->query("SELECT pct.`date`, SUM(pct.`amount`) AS petty_cash_in FROM `petty_cash_transaction` AS pct   
WHERE pct.`date` >= '$fdate'  
  AND pct.`date` <= '$tdate' 
  AND pct.location_id = '$location' 
  AND pct.`status` = 1 AND pct.type = 'c' AND pct.`transaction_type` = 'cs'
GROUP BY pct.date ");
		return $query->result();
            
        }
        public function get_customer_cash_in($fdate, $tdate, $location){
            $query = $this->db->query("SELECT cd.date , SUM(cd.`amount`) AS customer_cash_in   FROM `sh_credit_debit` AS cd   
WHERE cd.`status` = 1
 AND cd.`payment_type` = 'd'
 AND cd.`transaction_type` = 'cs'
 AND cd.`date` >= '$fdate'  
  AND cd.`date` <= '$tdate' 
  AND cd.location_id = '$location' 
GROUP BY cd.date ");
		return $query->result();
            
        }
}
?>