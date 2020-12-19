<?php
class Admin_expense_model extends CI_Model
{
  	var $table = 'sh_expensein_details as shi';
    var $column_order = array(null, 'location.l_name','user.UserFName','shi.date','shi.deposit_amount','shi.withdraw_amount','shi.deposited_by','shi.cheque_no'); //set column field database for datatable orderable
   var $column_search = array( 'location.l_name','user.UserFName','shi.date','shi.deposit_amount','shi.withdraw_amount','shi.deposited_by','shi.cheque_no'); //set column field database for datatable searchable
   var $order = array('shi.id' => 'desc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }


  private function _get_datatables_query()
    {
       
    $this->db->select('(SELECT 
    SUM(`sh_expensein_d_history`.value) 
  FROM
    sh_expensein_d_history 
  WHERE sh_expensein_d_history.`ex_id` = `shi`.id) AS total ,location.l_name,user.UserFName,shi.id,shi.date,shc.name');  
    $this->db->join('shusermaster user','user.id=shi.user_id');
    $this->db->join('sh_location location','location.l_id=user.l_id');
    $this->db->join('sh_com_registration as shc','shc.id=user.company_id');
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

   function get_datatables($extra="",$fdate = "",$tdate = "",$company="",$location="",$employeename="")
   {
       $this->_get_datatables_query();
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
    if($extra != "")
    {
      $this->db->where("Type",$extra);
    }
    
    // if($employeename != "")
    // {
    //   $this->db->where("user.id",$employeename);
    // }
    if ($fdate != "") {
    $newfdate = date('Y-m-d', strtotime($fdate));
         $this->db->where('shi.date >=', $newfdate);
        }if ($tdate != "") {
      $newtdate = date('Y-m-d', strtotime($tdate));
         $this->db->where('shi.date <=', $newtdate);
        }
        if ($company !="" && $company != 0) 
        {
          $this->db->where('shc.id', $company);
        }
        if ($location != "" && $location != 0) 
        {
          $this->db->where('user.l_id',$location);
        }
        if ($employeename != "" && $employeename != 0) 
        {
            $this->db->where('user.id',$employeename);   
        }
    // if($id != "")
    // {
    //   $this->db->where("shr.company_id",$id);
    // }
       $query = $this->db->get();
       return $query->result();
   }

   function count_filtered($extra="")
   {
       $this->_get_datatables_query();
    if($extra != "")
    {
      $this->db->where("Type",$extra);
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


    public function expense_info($id)
    {
      $query = $this->db->query("SELECT 

      `sed`.id,
      `sed`.date,
      `se`.name,
      `sedh`.value,
      `sedh`.comment ,
      `sh_location`.l_name,
      m.`UserFName`
      FROM
      sh_expensein_details AS sed 
      JOIN sh_expensein_d_history AS sedh 
        ON sedh.`ex_id` = sed.`id` 
      JOIN shexpensein AS se 
        ON se.`id` = sedh.`expensein_id` 
      JOIN shusermaster AS m 
        ON m.`id` = sed.`user_id` 
        JOIN `sh_location` 
        ON `sh_location`.`l_id` = `sed`.`location_id` 
        WHERE `sed`.id = '$id'  "); 
    
   
        return $query->result();
    }


    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_expensein_details',$data);
    }
    public function master_fun_get_tbl_val1($dtatabase, $condition) {
        $this->db->select();
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_location($dtatabase, $condition) {
        $this->db->select('l_name, l_id');
        
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_loc($cid) {
        $query = $this->db->query("SELECT sh.`id`,sh.`UserFName`,shl.`l_id`,shl.`l_name` FROM shusermaster AS sh  
JOIN sh_location AS shl ON sh.`l_id`=shl.`l_id`
WHERE sh.company_id='$cid' and sh.status='1'");
        return $query->result();
    }

    public function exportCSV($fdate = "",$tdate = "",$company="",$location="",$employeename=""){
        $response = array();
        $this->db->select(' DATE_FORMAT(shi.date,"%d/%m/%Y") as date,shc.name,user.UserFName,location.l_name,(SELECT 
    SUM(`sh_expensein_d_history`.value) 
  FROM
    sh_expensein_d_history 
  WHERE sh_expensein_d_history.`ex_id` = `shi`.id) AS total,');  
    $this->db->join('shusermaster user','user.id=shi.user_id');
    $this->db->join('sh_location location','location.l_id=user.l_id');
    $this->db->join('sh_com_registration as shc','shc.id=user.company_id');
    $this->db->from('sh_expensein_details as shi');
        // $this->db->join('tg_type','tg_type.id=tg_user.type');
        // $this->db->where('tg_user.type!=',1);
        $this->db->where('shi.status',1);
        if ($fdate !="") 
        {
          $newfdate = date('Y-m-d', strtotime($fdate));
          $this->db->where('shi.date >=', $newfdate);
        }
        if ($tdate !="") 
        {
          $newtdate = date('Y-m-d', strtotime($tdate));
          $this->db->where('shi.date <=', $newtdate);
        }
        if ($company !="" && $company != 0) 
        {
          $this->db->where('shc.id', $company);
        }
        if ($location !="" && $location != 0) 
        {
          $this->db->where('user.l_id', $location);
        }
        if ($employeename !="" && $employeename != 0) 
        {
            $this->db->where('user.id', $employeename);   
        }
        $q = $this->db->get();
        $response = $q->result_array();
        return $response;
    }
}
?>