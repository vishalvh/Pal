<?php
class expense_model extends CI_Model
{
	var $table = 'sh_expensein_details as shi';
   	var $column_order = array(null, 'shi.date','user.UserFName','shi.amount','location.l_name','shi.reson','typ.exps_name'); //set column field database for datatable orderable
   var $column_search = array('shi.date','user.UserFName','shi.amount','location.l_name','shi.reson','typ.exps_name'); //set column field database for datatable searchable
   var $order = array('shi.id' => 'desc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

	private function _get_datatables_query()
   	{
       
    $this->db->select('shi.amount AS total ,location.l_name,user.UserFName,shi.id,shi.date,shi.reson,typ.exps_name');
		
    $this->db->join('shusermaster user','user.id=shi.user_id');
    $this->db->join('sh_location location','location.l_id=user.l_id');
	$this->db->join('sh_expensein_types typ','typ.id=shi.expense_id');
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
    
       $query = $this->db->get();
       return $query->result();
   }

   function count_filtered($extra="",$id = "",$employeename ="",$fdate = "",$tdate = "",$location="",$current_date="")
   {
       $this->_get_datatables_query();
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
       $query = $this->db->get();
       return $query->num_rows();
   }

   public function count_all($extra="",$id = "",$employeename ="",$fdate = "",$tdate = "",$location="",$current_date="")
    {
        $this->db->from($this->table);
		
		if($extra != ""){
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
		$this->db->where("status","1");
        return $this->db->count_all_results();
    }
	public function get_customer_expense_list($lid,$sdate,$edate,$current_date,$exp_name=""){
		$this->db->select('shi.amount AS total ,location.l_name,user.UserFName,shi.id,shi.date,shi.reson,typ.exps_name');
		$this->db->from('sh_expensein_details as shi');	
		$this->db->join('shusermaster user','user.id=shi.user_id');
		$this->db->join('sh_location location','location.l_id=user.l_id');
		$this->db->join('sh_expensein_types typ','typ.id=shi.expense_id');
		$this->db->where('shi.status ', '1');
   if ($sdate != "") {
    $newfdate = date('Y-m-d', strtotime($sdate));
         $this->db->where('shi.date >=', $newfdate);
        }if ($edate != "") {
      $newtdate = date('Y-m-d', strtotime($edate));
         $this->db->where('shi.date <=', $newtdate);
        }
    if ($lid != "") 
    {
      //$this->db->where('user.l_id',$lid);
	  $this->db->where('shi.location_id',$lid);
    }
    if ($sdate =="" && $edate =="") 
    {
      $this->db->where('date',$current_date);
    }
	if ($exp_name != "") 
    {
      $this->db->where('shi.expense_id',$exp_name);
    }
    $query = $this->db->order_by('date','asc');
		$query = $this->db->get();
       return $query->result();

	}


    public function expense_info($id)
    {
      $query = $this->db->query("SELECT * FROM sh_expensein_details  WHERE id = '$id'  "); 
    
   
        return $query->result();
    }


    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_expensein_details',$data);
    }
    public function master_fun_get_tbl_val1($dtatabase, $condition) {
        $this->db->select('UserFName, id');
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_location($dtatabase, $condition) {
        $this->db->select('l_name, l_id');
         $this->db->order_by("l_name", "asc");
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
	public function master_fun_get_tbl_val($dtatabase, $condition) {
      
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
	public function master_fun_get_tbl_val2($dtatabase, $condition) {
      $this->db->select('*');
         $this->db->order_by("exps_name", "asc");
        $query = $this->db->get_where($dtatabase, $condition);
		
        $data['user'] = $query->result_array();
        return $data['user'];
    }
	 function updatefun($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_expensein_details',$data);
    }
	function updatebankexpence($id,$data)
    { 
      $this->db->where('expence_id',$id);
      $this->db->where('status','1');
      $this->db->update('sh_onlinetransaction',$data);
    }
	public function location_detail($lid){		
		$query = $this->db->query("SELECT * FROM sh_location WHERE  status='1' and l_id='$lid' ");
		return $query->row();	
	}
        public function get_location($id){
            $query = $this->db->query("SELECT l.* FROM sh_madetor_l_id AS  m 
JOIN `sh_location` AS l ON l.`l_id` =m.`l_id`  
WHERE m.`status` = 1 
AND l.`status` = 1
AND l.`show_hide` = 'show'
AND m.`m_id`= '$id'
ORDER BY  l.l_name ASC  ");
		return $query->result_array();
            
        }
	public function get_tbl_data_order($dtatabase, $condition,$order) {
		$this->db->select('*');
         $this->db->order_by($order[0], $order[1]);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
}
?>