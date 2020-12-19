<?php
class Admin_readingreport_model extends CI_Model
{
  	var $table = 'ShDailyReadingDetails as drd';
    var $column_order = array(null, 'location.l_name','user.UserFName','user.shift','drd.Date','drd.PatrolReading','drd.`DieselReading`','drd.`meterReading`','drd.`TotalCash`','drd.`TotalCredit`','drd.`TotalExpenses`','drd.`TotalAmount`','drd.disel_deep_reding','drd.petrol_deep_reding'); //set column field database for datatable orderable
   var $column_search = array('location.l_name','user.UserFName','user.shift','drd.Date','drd.PatrolReading','drd.`DieselReading`','drd.`meterReading`','drd.`TotalCash`','drd.`TotalCredit`','drd.`TotalExpenses`','drd.`TotalAmount`','drd.disel_deep_reding','drd.petrol_deep_reding'); //set column field database for datatable searchable
   var $order = array('drd.id' => 'desc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

  private function _get_datatables_query()
    {
       
    $this->db->select(' `drd`.`id`,drd.disel_deep_reding,drd.petrol_deep_reding,
    drd.Date,
    shc.`name`,
    drd.`date`,
    drd.`PatrolReading`,
    drd.`DieselReading`,
    drd.`meterReading`,
    drd.`TotalCash`,
    drd.`TotalCredit`,
    drd.`TotalExpenses`,
    user.UserFName,
    user.shift,
    location.l_name,
    drd.`TotalAmount`');    
    $this->db->join('shusermaster user','user.id=drd.UserId');
    $this->db->join('sh_location location','location.l_id=user.l_id');
    $this->db->join('sh_com_registration as shc','shc.id=user.company_id');
    $this->db->from($this->table);
    // $this->db->join('sh_location as shl','shl.l_id = shr.l_id', 'inner');


    $this->db->where(array('drd.status'=>1)); 

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
        $this->db->where('drd.status', 1);
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
         $this->db->where('drd.date >=', $newfdate);
        }if ($tdate != "") {
      $newtdate = date('Y-m-d', strtotime($tdate));
         $this->db->where('drd.date <=', $newtdate);
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


    public function reading_info($id)
    {
      $date = date("Y-m-d");
        $query = $this->db->query("SELECT DATE_FORMAT(`drd`.created_at, '%d-%m-%Y') AS DATE,`drd`.disel_deep_reding,petrol_deep_reding, `drd`.id,drd.`DieselReading`,drd.`meterReading`,drd.`PatrolReading`,drd.`TotalAmount`,drd.`TotalCash`,drd.`TotalCredit`,drd.`TotalExpenses`,drd.`date`,`sh`.UserFName,`sh`.shift,`shl`.l_name FROM `ShDailyReadingDetails` AS drd join shusermaster as sh on `sh`.id=`drd`.UserId join sh_location as shl on `shl`.l_id=`drd`.location_id 
WHERE drd.`status`='1' AND `drd`.id = '$id' ");
        return $query->result_array();
    }

    function shdailyreadingdetails_reading_list_details_id($id,$company_id){
        $query = $this->db->query("SELECT srh.id as pid, sp.`id`,sp.`name`, srh.`Reading`,srh.`PumpId`,sp.`type` FROM `ShDailyReadingDetails` AS drd LEFT JOIN `shusermaster` ON shusermaster.`id` = drd.`UserId` LEFT JOIN shreadinghistory AS srh ON srh.`RDRId` = drd.`id` LEFT JOIN shpump AS sp ON sp.`id` = srh.`PumpId` WHERE drd.`status`='1' AND drd.id = '$id' AND `sp`.company_id = $company_id ORDER BY drd.id DESC ");     
        return $query->result_array();
    }

    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('ShDailyReadingDetails',$data);
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
        $this->db->select('DATE_FORMAT(drd.date,"%d/%m/%Y") as date,
          shc.name,
          user.UserFName,
          location.l_name,
          user.shift, 
          drd.`PatrolReading`,
          drd.`DieselReading`,
          drd.`meterReading`,
          drd.`TotalCash`,
          drd.`TotalCredit`,
          drd.`TotalExpenses`,
          drd.`TotalAmount`,
          drd.disel_deep_reding,
          drd.petrol_deep_reding
        ');    
        $this->db->join('shusermaster user','user.id=drd.UserId');
        $this->db->join('sh_location location','location.l_id=user.l_id');
        $this->db->join('sh_com_registration shc','shc.id=user.company_id');
        $this->db->from('ShDailyReadingDetails drd');
        $this->db->where('drd.status',1);
        if ($fdate != "") {
            $newfdate = date('Y-m-d', strtotime($fdate));
            $this->db->where('drd.date >=', $newfdate);
        }if ($tdate != "") {
            $newtdate = date('Y-m-d', strtotime($tdate));
            $this->db->where('drd.date <=', $newtdate);
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
        $query = $this->db->get();
        $response = $query->result_array();
        return $response;
    }
}
?>