<?php
class MS_DSH_sales_model extends CI_Model
{

   public function __construct() 
   {
       $this->load->database();
   }
   public function select_all_with_order($field,$dtatabase,$condition,$order) {
        $this->db->select($field);
        $this->db->order_by($order[0], $order[1]);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result();
        return $data['user'];
    }
	public function get_reading_data($location_id,$sdate,$edate){
        $this->db->select('ads.id,ads.`date`,srh.`PumpId`,srh.`Reading`,srh.`qty`,sp.`id`');   
        $this->db->from('shreadinghistory srh');
        $this->db->join('shdailyreadingdetails ads','ads.id = srh.RDRId');
        $this->db->join('shpump sp','sp.id = srh.PumpId');
        $this->db->where('srh.status',1);
        $this->db->where('ads.status',1);
        $this->db->where('ads.location_id',$location_id);
        $this->db->where('ads.date >=',$sdate);
        $this->db->where('srh.Type !=','o');
        $q = $this->db->get();
        $response = $q->result();
        return $response;
    }


  private function _get_datatables_query()
    {
       
    $this->db->select('shc.name,location.l_name,user.UserFName,shi.id,shi.date,shi.deposit_amount,shi.withdraw_amount,shi.deposited_by,shi.cheque_no');   
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


    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_bankdeposit',$data);
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
        $this->db->select('DATE_FORMAT(shi.date,"%d/%m/%Y") as date,shc.name,user.UserFName,location.l_name,shi.deposit_amount,shi.withdraw_amount,shi.deposited_by,shi.cheque_no');   
        $this->db->from('sh_bankdeposit as shi');
        $this->db->join('shusermaster user','user.id=shi.user_id');
        $this->db->join('sh_location location','location.l_id=user.l_id');
        $this->db->join('sh_com_registration as shc','shc.id=user.company_id');
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