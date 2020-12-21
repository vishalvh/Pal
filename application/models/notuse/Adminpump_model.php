<?php

class Adminpump_model extends CI_Model
{

	var $table = 'shpump as shr';
   var $column_order = array(null,'shr.name','shr.type','shl.l_name','shr.packet_value','shr.spacket_value','shr.packet_type','shr.nozzel_code'); //set column field database for datatable orderable
   var $column_search = array('shr.name','shr.type','shl.l_name','shr.packet_value','shr.spacket_value','shr.packet_type','shr.nozzel_code'); //set column field database for datatable searchable
   var $order = array('shr.order' => 'asc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

	private function _get_datatables_query()
   	{
       
    $this->db->select('shr.show,shr.id,shr.name,shr.type,shl.l_name,shr.packet_value,shr.spacket_value,shr.packet_type,shr.nozzel_code'); 
		$this->db->from($this->table);
    $this->db->join('sh_location as shl','shl.l_id = shr.location_id', 'inner');


		$this->db->where(array('shr.status'=>1));	

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
       	
        $this->db->where('shr.status', 1);
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

   function get_datatables($extra="",$id="")
   {
       $this->_get_datatables_query();
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
		if($extra != "")
		{
			$this->db->where("shr.location_id",$extra);
		}
		$this->db->where("Type !=","O");
    if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
       $query = $this->db->get();
       return $query->result();
   }
   function get_datatables_oil($extra="",$id="")
   {
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where("Type","O");
    if($extra != "")
		{
			$this->db->where("shr.location_id",$extra);
		}
		if($id != ""){
			$this->db->where("shr.company_id",$id);
		}
		$query = $this->db->get();
		return $query->result();
   }

   function count_filtered($extra="",$id="")
   {
       $this->_get_datatables_query();
		if($extra != "")
		{
			$this->db->where("shr.location_id",$extra);
		}
		 if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
       $query = $this->db->get();
       return $query->num_rows();
   }
   
   
   function count_filtered_oil($extra="",$id="")
   {
		$this->_get_datatables_query();
		$this->db->where("Type","O");
                if($extra != "")
		{
			$this->db->where("shr.location_id",$extra);
		}
		if($id != ""){
			$this->db->where("shr.company_id",$id);
		}
		$query = $this->db->get();
		return $query->num_rows();
   }
   

   public function count_all($extra="",$id="")
    {
        $this->db->from($this->table);
		if($extra != ""){
			$this->db->where("shr.location_id",$extra);
		}
		 if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
		$this->db->where("status","1");
        return $this->db->count_all_results();
    }
	
	
	public function count_all_oil($extra="",$id="")
    {
        $this->db->from($this->table);
		$this->db->where("Type","O");
                if($extra != ""){
			$this->db->where("shr.location_id",$extra);
		}
		if($id != ""){
			$this->db->where("shr.company_id",$id);
		}else{
			$this->db->where("Type != ",'O');
		}
		if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
		$this->db->where("status","1");
        return $this->db->count_all_results();
    }
	

    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('shpump',$data);
    }

    function select_pumpby_id($id)
    {
      $this->db->where('status','1');
      $this->db->where('id',$id);
      
      $q = $this->db->get('shpump');
      return $q->result();
    }

    function update($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('shpump',$data);
    }	

    // pranjal 21/04/2018

    public function select_location($id1)
    {
      $this->db->where('company_id',$id1);
      $this->db->where('status','1');
      $this->db->order_by("l_name", "asc");
      $q = $this->db->get('sh_location');
      
      return $q;
    }
	function get_tbl_list($tbl,$cond,$order)
    {
      
      $this->db->where($cond);
	  $this->db->order_by($order[0],$order[1]);
      $q = $this->db->get($tbl);
      return $q->result();
    }
    public function master_fun_get_tbl_val($dtatabase, $condition, $order) {

//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        //$query = $this->db->order_by('total', 'desc'); 
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function oil_view_details($id){
		$query = $this->db->query("SELECT sh_oil_inventory_data.*,p.p_type,p.`name`,p.`location_id`,p.`packet_type`,p.`new_p_qty`,p.`spacket_value`,p.`stock` FROM `sh_oil_inventory_data` 
JOIN `shpump` AS p ON p.`id` = sh_oil_inventory_data.`p_id` WHERE o_m_id = '$id' ");
        return $query->result();
	}
        function get_oil_detail_price($location_id,$sdate){
		$sql ="SELECT SUM(o.`stock`) AS stock,o.`date`, SUM((o.`bay_price`)* r_history.`Reading`) AS total_bay_price ,SUM(o.`sel_price`*r_history.`Reading`) AS total_sel_price FROM sh_oil_daily_price AS o JOIN shpump AS p ON p.id = o.`o_p_id` JOIN `shreadinghistory` AS r_history ON r_history.`PumpId` = p.`id` AND r_history.`date`= o.`date` AND r_history.`status` = 1 WHERE p.`location_id` = '$location_id' AND  o.date = '$sdate' GROUP BY o.`date` order by  p.order";
		$query = $this->db->query($sql);
		return $query->result();
	}
        function get_oil_detail_separate_price_total($location_id,$date){
		$sql ="SELECT SUM(d_p.`bay_price`*d_p.`stock`) AS total FROM `sh_oil_daily_price` AS d_p 
JOIN `shreadinghistory` AS rh ON rh.`PumpId` = d_p.`o_p_id` AND rh.`date` = '$date' AND rh.`status` = 1
JOIN `shpump` AS p ON p.`id` = d_p.`o_p_id`
 WHERE p.`location_id` = '$location_id' AND d_p.date = '$date' and p.status='1' order by  p.order ";
		$query = $this->db->query($sql);
		return $query->result();
	}
        function get_oil_detail_separate_price($location_id,$date){
		$sql ="SELECT p.id as pump_id,p.`name`,p.`packet_type`,p.`new_p_qty`,p.`p_qty`, d_p.`stock`,d_p.`bay_price`,d_p.`sel_price`,d_p.`date` FROM `sh_oil_daily_price` AS d_p 
JOIN `shreadinghistory` AS rh ON rh.`PumpId` = d_p.`o_p_id` AND rh.`date` = '$date' AND rh.`status` = 1
JOIN `shpump` AS p ON p.`id` = d_p.`o_p_id`
 WHERE p.`location_id` = '$location_id' AND d_p.date = '$date' and p.status='1' ORDER BY p.order  asc ";
		$query = $this->db->query($sql);
		return $query->result();
	}
        function update_main_stock($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('shpump',$data);
    }	
    function update_oil_stock($id,$date,$data)
    {
      $this->db->where('o_p_id',$id);
      $this->db->where('date',$date);
      $this->db->where('status','1');
      $this->db->update('sh_oil_daily_price',$data);
    }
	function update_oil_stock_for_all($id,$date,$data)
    {
      $this->db->where('o_p_id',$id);
      $this->db->where('date >=',$date);
      $this->db->update('sh_oil_daily_price',$data);
    }
    function update_oil_daily_price($id,$stock,$bay_price,$sel_price,$current_date,$lid){
$sql = "update sh_oil_daily_price set stock=stock+$stock  where o_p_id=$id and date > '$current_date' and location_id = $lid";
$this->db->query($sql, array($id));
return 1;

}
    function update_oil_daily_price_all($id,$stock,$bay_price,$sel_price,$current_date,$lid){
$sql = "update sh_oil_daily_price set bay_price=$bay_price,sel_price=$sel_price where o_p_id=$id and date >= '$current_date' and location_id = $lid";
$this->db->query($sql, array($id));
return 1;

}
    function update_oil_daily_price_all2($id,$stock,$bay_price,$sel_price,$current_date,$lid){
$sql = "update sh_oil_daily_price set stock=stock+$stock , bay_price=$bay_price,sel_price=$sel_price where o_p_id=$id and date >= '$current_date' and location_id = $lid";
$this->db->query($sql, array($id));
return 1;

}
function update_oil_daily_stock($id,$stock){
$sql = "update shpump set stock=stock+$stock where id=$id ";
$this->db->query($sql, array($id));
return 1;

}
function select_order_category_list($location_id,$id){
  $this->db->select('shr.show,shr.id,shr.name,shr.type,shl.l_name,shr.packet_value,shr.spacket_value,shr.packet_type');
  $this->db->from('shpump as shr');
  $this->db->join('sh_location as shl','shl.l_id = shr.location_id', 'inner');
    $this->db->where('shl.l_id',$location_id);
  $this->db->where('shr.status',1);
 
  // $this->db->where("shr.company_id",$id);
    $this->db->where("shr.Type",'O');
  
  $this->db->order_by('order','asc');
  $query = $this->db->get();
  return $query->result(); 
}
function order_set($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('shpump',$data);
    }
	function get_oil_stock_selected_date($date,$location_id){
		$sql ="SELECT sp.id,sp.packet_type,odp.stock FROM shpump sp 
JOIN sh_oil_daily_price odp 
ON odp.o_p_id = sp.id AND odp.date='$date'
WHERE sp.status='1' AND sp.`type`='o' AND sp.location_id = '$location_id' AND odp.status = '1' ORDER BY sp.order ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function get_oil_slling_stock_date($sdate,$edate,$location_id){
		$sql ="SELECT rh.PumpId,rh.date,rh.Reading,rh.qty FROM shdailyreadingdetails dr 
JOIN shreadinghistory rh ON rh.RDRId = dr.id 
WHERE dr.date >= '$sdate' AND dr.date <= '$edate' AND dr.location_id = '$location_id' AND rh.Type ='o' AND rh.Reading != '0' AND rh.status = '1'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function get_oil_active_list($location) {
        $query = $this->db->query("SELECT id,name,type,p_qty as packet_value,packet_value as p_price,packet_type,stock FROM shpump WHERE status='1' and type='o' and location_id='$location'  ORDER BY shpump.order ASC");
        return $query->result();
    }
	public function oil_inventory_Detail($lid,$date,$pid){		
		$query = $this->db->query("SELECT 
    sp.`id`,soi.`qty`,si.`date`
  FROM
    sh_inventory si 
    JOIN sh_oil_inventory soi ON soi.`inv_id`=si.`id`
    JOIN shpump sp ON sp.`id`=soi.`oil_id`
  WHERE si.location_id = '$lid' 
    AND si.fuel_type = 'o' 
    AND si.`date` >= '$date' 
    AND sp.`id` = '$pid' 
	And si.status = '1'
	And soi.status = '1'
	and sp.status = '1'
  GROUP BY soi.id");
		return $query->result();	
	}
	
}
?>