<?php
class Saving_member_model extends CI_Model{
	var $table = 'saving_member as sm';
	var $column_order = array(null,'sm.name','sm.mobile','shl.l_name'); //set column field database for datatable orderable
	var $column_search = array('sm.name','sm.mobile','shl.l_name'); //set column field database for datatable searchable
	var $order = array('sm.name' => 'desc'); // default order
	public function __construct() {
       $this->load->database();
	}
	private function _get_datatables_query(){
		$this->db->select('sm.id,sm.name,sm.mobile,shl.l_name');
		$this->db->from($this->table);
		$this->db->join('sh_location as shl','shl.l_id = sm.location_id', 'inner');
		$this->db->where(array('sm.status'=>1));	
		$i = 0;
		foreach ($this->column_search as $item){ // loop column
           if($_POST['search']['value']){ // if datatable send POST for search               
               if($i===0){ // first loop
                   $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                   $this->db->like($item, $_POST['search']['value']);
               }else{
                   $this->db->or_like($item, $_POST['search']['value']);
               }
               if(count($this->column_search) - 1 == $i) //last loop
                   $this->db->group_end(); //close bracket
           }
           $i++;
		}
		if(isset($_POST['order'])){ // here order processing
           $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	function get_datatables($extra="",$id=""){
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->where("sm.company_id",$id);
                if($extra != ""){
			$this->db->where("sm.location_id",$extra);
		}
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	function count_filtered($extra="",$id=""){
		$this->_get_datatables_query();
		if($id != ""){
			$this->db->where("sm.company_id",$id);
		}
                if($extra != ""){
			$this->db->where("sm.location_id",$extra);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function count_all($extra="",$id=""){
        $this->db->from($this->table);
		if($id != ""){
			$this->db->where("sm.company_id",$id);
		}
                if($extra != ""){
			$this->db->where("sm.location_id",$extra);
		}
		$this->db->where("status","1");
        return $this->db->count_all_results();
    }
	function delete($id,$data){
      $this->db->where('id',$id);
      $this->db->update('saving_member',$data);
    }
	function transaction_delete($id,$data){
      $this->db->where('id',$id);
      $this->db->update('saving_member_transaction',$data);
    }
    function select_pumpby_id($id){
		$this->db->where('status','1');
		$this->db->where('id',$id);
		$q = $this->db->get('saving_member');
		return $q->result();
    }
    function update($id,$data){
      $this->db->where('id',$id);
      $this->db->update('saving_member',$data);
    }
	function update_record($id,$data){
      $this->db->where('id',$id);
      $this->db->update('saving_member',$data);
    }	
	function update_transaction_record($id,$data){
      $this->db->where('id',$id);
      $this->db->update('saving_member_transaction',$data);
    }	
    // pranjal 21/04/2018
    public function select_location($id1){
		$this->db->where('company_id',$id1);
		$this->db->where('status','1');
		$this->db->order_by("l_name", "asc");
		$q = $this->db->get('sh_location');
		return $q;
    }
	function get_tbl_list($tbl,$cond,$order){
		$this->db->where($cond);
		$this->db->order_by($order[0],$order[1]);
		$q = $this->db->get($tbl);
		return $q->result();
    }
	function get_tbl_one($tbl,$cond){
		$this->db->where($cond);
		$q = $this->db->get($tbl);
		return $q->row();
    }
	public function get_tasection_list_Credit($lid,$sdate,$edate,$current_date,$member_id=''){
		$this->db->select('petty_cash_transaction.remark,petty_cash_transaction.`date`,petty_cash_transaction.`count_status`,petty_cash_transaction.id,SUM(petty_cash_transaction.`amount`) as amount,petty_cash_transaction.`type`,petty_cash_transaction.`transaction_type`,petty_cash_transaction.`transaction_no`,saving_member.`name`');
		$this->db->from('petty_cash_transaction');	
		$this->db->join('`saving_member`','`saving_member`.`id` = `petty_cash_transaction`.`member_id`');
		$this->db->where('petty_cash_transaction.status', '1');
                $this->db->where('petty_cash_transaction.type', 'c');
   if ($sdate != "") {
    $newfdate = date('Y-m-d', strtotime($sdate));
         $this->db->where('petty_cash_transaction.`date` >=', $newfdate);
        }if ($edate != "") {
      $newtdate = date('Y-m-d', strtotime($edate));
         $this->db->where('petty_cash_transaction.`date` <=', $newtdate);
        }
    if ($lid != "") 
    {
      $this->db->where('saving_member.`location_id`',$lid);
    }
    if ($sdate =="" && $edate =="") 
    {
      $this->db->where('petty_cash_transaction.`date`',$current_date);
    }
	if($member_id != ''){
		$this->db->where('petty_cash_transaction.`member_id`',$member_id);
	}
          $this->db->group_by('petty_cash_transaction.date');
//          $this->db->group_by('`saving_member`.`name`');
           $this->db->group_by('petty_cash_transaction.type');
          $query = $this->db->order_by('petty_cash_transaction.`date`','asc');
		$query = $this->db->get();
       return $query->result();

	}
	
        public function get_tasection_list_Debit($lid,$sdate,$edate,$current_date,$member_id=''){
		$this->db->select('petty_cash_transaction.remark,petty_cash_transaction.`date`,petty_cash_transaction.id,SUM(petty_cash_transaction.`amount`) as amount,petty_cash_transaction.`type`,petty_cash_transaction.`transaction_type`,petty_cash_transaction.`transaction_no`,saving_member.`name`');
		$this->db->from('petty_cash_transaction');	
		$this->db->join('`saving_member`','`saving_member`.`id` = `petty_cash_transaction`.`member_id`');
		$this->db->where('petty_cash_transaction.status', '1');
                $this->db->where('petty_cash_transaction.type', 'd');
   if ($sdate != "") {
    $newfdate = date('Y-m-d', strtotime($sdate));
         $this->db->where('petty_cash_transaction.`date` >=', $newfdate);
        }if ($edate != "") {
      $newtdate = date('Y-m-d', strtotime($edate));
         $this->db->where('petty_cash_transaction.`date` <=', $newtdate);
        }
    if ($lid != "") 
    {
      $this->db->where('saving_member.`location_id`',$lid);
    }
    if ($sdate =="" && $edate =="") 
    {
      $this->db->where('petty_cash_transaction.`date`',$current_date);
    }
	if($member_id != ''){
		$this->db->where('petty_cash_transaction.`member_id`',$member_id);
	}
          $this->db->group_by('petty_cash_transaction.date');
//          $this->db->group_by('`saving_member`.`name`');
           $this->db->group_by('petty_cash_transaction.type');
          $query = $this->db->order_by('petty_cash_transaction.`date`','asc');
		$query = $this->db->get();
       return $query->result();

	}
        public function get_tasection_list_date($lid,$date,$member_id=''){
		$this->db->select('petty_cash_transaction.remark,petty_cash_transaction.`date`,petty_cash_transaction.id,SUM(petty_cash_transaction.`amount`) as amount,petty_cash_transaction.`type`,petty_cash_transaction.`transaction_type`,petty_cash_transaction.`transaction_no`,saving_member.`name`');
		$this->db->from('petty_cash_transaction');	
		$this->db->join('`saving_member`','`saving_member`.`id` = `petty_cash_transaction`.`member_id`');
		$this->db->where('petty_cash_transaction.status', '1');
   
    if ($lid != "") 
    {
      $this->db->where('saving_member.`location_id`',$lid);
    }
    
      $this->db->where('petty_cash_transaction.`date`',$date);
    
	if($member_id != ''){
		$this->db->where('petty_cash_transaction.`member_id`',$member_id);
	}
          $this->db->group_by('petty_cash_transaction.date');
          $this->db->group_by('`saving_member`.`name`');
           $this->db->group_by('petty_cash_transaction.type');
          $query = $this->db->order_by('petty_cash_transaction.`date`','asc');
		$query = $this->db->get();
       return $query->result();

	}
        public function get_tasection_list_debit_date($lid,$date,$member_id=''){
		$this->db->select('petty_cash_transaction.remark,petty_cash_transaction.`date`,petty_cash_transaction.id,petty_cash_transaction.`amount` ,petty_cash_transaction.`type`,petty_cash_transaction.`transaction_type`,petty_cash_transaction.`transaction_no`,saving_member.`name`');
		$this->db->from('petty_cash_transaction');	
		$this->db->join('`saving_member`','`saving_member`.`id` = `petty_cash_transaction`.`member_id`');
		$this->db->where('petty_cash_transaction.status', '1');
                 $this->db->where('petty_cash_transaction.type', 'd');
   
    if ($lid != "") 
    {
      $this->db->where('saving_member.`location_id`',$lid);
    }
    
      $this->db->where('petty_cash_transaction.`date`',$date);
    
	if($member_id != ''){
		$this->db->where('petty_cash_transaction.`member_id`',$member_id);
	}
//          $this->db->group_by('petty_cash_transaction.date');
//          $this->db->group_by('`saving_member`.`name`');
//           $this->db->group_by('petty_cash_transaction.type');
          $query = $this->db->order_by('petty_cash_transaction.`date`','asc');
		$query = $this->db->get();
       return $query->result();

	}
        public function get_report_data_date($lid,$date,$member_id=''){
		$this->db->select('smt.`amount`,smt.`date`,saving_member.`name`, smt.`id`');
		$this->db->from('`saving_member_transaction` AS smt');	
		$this->db->join('`saving_member` ','smt.`member_id` = saving_member.`id`');
		$this->db->where('smt.status', '1');
    if ($lid != "") 
    {
      $this->db->where('smt.`location_id`',$lid);
    }
    
      $this->db->where('smt.`date`',$date);
    
	if($member_id != ''){
		$this->db->where('smt.`member_id`',$member_id);
	}
//          $this->db->group_by('petty_cash_transaction.date');
//          $this->db->group_by('`saving_member`.`name`');
//           $this->db->group_by('petty_cash_transaction.type');
          $query = $this->db->order_by('smt.`date`','asc');
		$query = $this->db->get();
       return $query->result();

	}
        
        public function total_balance($lid,$sdate,$edate,$current_date,$member_id=''){
            $where = "";
            if($lid != ""){
                $where.= " AND c.`location_id` = $lid";
            }
            if($sdate != ""){
              $where.=  " AND c.date < '$sdate'";
            }
            if($member_id != ""){
              $where.= " AND c.member_id = '$member_id'";
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
		public function total_balance_n($lid,$sdate,$edate,$current_date,$member_id=''){
            $where = "";
            if($lid != ""){
                $where.= " AND c.`location_id` = $lid";
            }
            if($sdate != ""){
              $where.=  " AND c.date >= '$sdate'";
            }
			if($edate != ""){
              $where.=  " AND c.date <= '$edate'";
            }
            if($member_id != ""){
              $where.= " AND c.member_id = '$member_id'";
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
		public function report_data($lid,$sdate,$edate,$current_date,$member_id=''){
            $where = "";
            if($lid != ""){
                $where.= " AND smt.`location_id` = $lid";
            }
            if($sdate != ""){
              $where.=  " AND smt.date >= '$sdate'";
            }
			if($edate != ""){
              $where.=  " AND smt.date <= '$edate'";
            }
            if($member_id != ""){
              $where.= " AND smt.member_id = '$member_id'";
            }
            $query = $this->db->query("SELECT  smt.`member_id`,SUM(smt.`amount`) AS total_amount,smt.`date` ,saving_member.`name` FROM `saving_member_transaction` AS smt
JOIN `saving_member` 
ON smt.`member_id` = saving_member.`id` where 
smt.status = 1 $where
   GROUP BY smt.`date` ,smt.`member_id` ORDER BY smt.date ASC
");
            
            
		 return $query->result();
            
        }
}
?>