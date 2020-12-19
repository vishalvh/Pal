<?php
class Inventory_model extends CI_Model
{
	var $table = 'sh_inventory as shi';
   	var $column_order = array(null, 'location.l_name','user.UserFName','shi.date', 'shi.pi_number','shi.p_fuelamount','shi.pv_taxamount','shi.p_paymenttype','shi.p_chequenumber','shi.p_paidamount','shi.p_quantity','shi.p_tankerreading','shi.di_number','shi.d_fuelamount','shi.dv_taxamount','shi.d_paymenttype','shi.d_chequenumber','shi.d_paidamount','shi.d_quantity','shi.d_tankerreading','shi.oil_type','shi.o_quantity','shi.oil_amount'); //set column field database for datatable orderable
   var $column_search = array( 'location.l_name','user.UserFName','shi.date','shi.pi_number','shi.p_fuelamount','shi.pv_taxamount','shi.p_paymenttype','shi.p_chequenumber','shi.p_paidamount','shi.p_quantity','shi.p_tankerreading','shi.di_number','shi.d_fuelamount','shi.dv_taxamount','shi.d_paymenttype','shi.d_chequenumber','shi.d_paidamount','shi.d_quantity','shi.d_tankerreading','shi.oil_type','shi.o_quantity','shi.oil_amount'); //set column field database for datatable searchable
   var $order = array('shi.id' => 'desc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

	private function _get_datatables_query()
   	{
       
    $this->db->select('location.l_name,user.UserFName,shi.id,shi.date,shi.pi_number,shi.p_fuelamount,shi.pv_taxamount,shi.p_paymenttype,shi.p_chequenumber,shi.p_paidamount,shi.p_quantity,shi.p_tankerreading,shi.di_number,shi.d_fuelamount,shi.dv_taxamount,shi.d_paymenttype,shi.d_chequenumber,shi.d_paidamount,shi.d_quantity,shi.d_tankerreading,shi.oil_type,shi.o_quantity,shi.oil_amount');
		
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


    public function inventry_info($id)
    {
      $this->db->select('*');
      $this->db->from('sh_inventory as shi');
      $this->db->join('shusermaster as sh','sh.id=shi.user_id','inner');
      $this->db->join('sh_location as shl','shl.l_id=shi.location_id','inner');
      $this->db->where('shi.id',$id);
      $q1 = $this->db->get();

      return $q1->result();
    }


    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_inventory',$data);
    }
    public function master_fun_get_tbl_val1($dtatabase, $condition) {
        $this->db->select('UserFName, id');
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
	public function getInvetory($date,$location,$type) {
		$this->db->select('sh_inventory.*,shusermaster.UserFName,shusermaster.UserLName');
		$this->db->from('sh_inventory');
		$this->db->join('shusermaster','shusermaster.id=sh_inventory.user_id','inner');
		$this->db->where('sh_inventory.location_id',$location);
		$this->db->where('sh_inventory.date',$date);
		$this->db->where('sh_inventory.fuel_type',$type);
		$this->db->where('sh_inventory.status','1');
		$q1 = $this->db->get();
		return $q1->row();
        /*$query = $this->db->get_where('sh_inventory',array('location_id'=>$location,'date'=>$date,'fuel_type'=>$type,'status'=>'1'));
        $data['user'] = $query->row();
        return $data['user'];*/
    }
	public function getInvetoryDates($sdate,$edate,$location,$type) {
		$this->db->select('sh_inventory.*,shusermaster.UserFName,shusermaster.UserLName');
		$this->db->from('sh_inventory');
		$this->db->join('shusermaster','shusermaster.id=sh_inventory.user_id','inner');
		$this->db->where('sh_inventory.location_id',$location);
		$this->db->where('sh_inventory.date >= ',$sdate);
		$this->db->where('sh_inventory.date <= ',$edate);
		$this->db->where('sh_inventory.fuel_type',$type);
		$this->db->where('sh_inventory.status','1');
		$q1 = $this->db->get();
		return $q1->result();
        /*$query = $this->db->get_where('sh_inventory',array('location_id'=>$location,'date'=>$date,'fuel_type'=>$type,'status'=>'1'));
        $data['user'] = $query->row();
        return $data['user'];*/
    }
	public function getInvetoryDatesByTankId($sdate,$edate,$location,$type,$tank) {
		$this->db->select('sh_inventory.*,shusermaster.UserFName,shusermaster.UserLName');
		$this->db->from('sh_inventory');
		$this->db->join('shusermaster','shusermaster.id=sh_inventory.user_id','inner');
		$this->db->join('tank_volume_inventory','tank_volume_inventory.inv_id=sh_inventory.id');
		$this->db->where('sh_inventory.location_id',$location);
		$this->db->where('sh_inventory.date >= ',$sdate);
		$this->db->where('sh_inventory.date <= ',$edate);
		$this->db->where('sh_inventory.fuel_type',$type);
		$this->db->where('sh_inventory.status','1');
		$this->db->where('tank_volume_inventory.volume > ','0');
		$this->db->where('tank_volume_inventory.tank_id',$tank);
		$q1 = $this->db->get();
		return $q1->result();
        /*$query = $this->db->get_where('sh_inventory',array('location_id'=>$location,'date'=>$date,'fuel_type'=>$type,'status'=>'1'));
        $data['user'] = $query->row();
        return $data['user'];*/
    }
	public function sampleData($id) {
        $query = $this->db->get_where('sh_sample_list',array('inv_id'=>$id,'status'=>'1'));
        $data['user'] = $query->result();
        return $data['user'];
    }
	
	public function getEditById($id){
		$query = $this->db->get_where('sh_inventory',array('id'=>$id,'status'=>1));
		$data['user'] = $query->row();
        return $data['user'];
		
	}
	 function update($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_inventory',$data);
    }
}
?>