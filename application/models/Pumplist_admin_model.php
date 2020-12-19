<?php
	
class Pumplist_admin_model extends CI_Model
{
	var $table = 'shpump as shp';
   	var $column_order = array(null, 'shp.name','shp.type','shl.l_name','shc.name'); //set column field database for datatable orderable
   var $column_search = array('shp.name','shp.type','shl.l_name','shc.name'); //set column field database for datatable searchable
   var $order = array('shp.id' => 'desc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

	private function _get_datatables_query()
   	{
       
    $this->db->select('shp.id,shp.name as pumpname,shp.type,shl.l_name,shc.name');
		$this->db->from($this->table);
    $this->db->join('sh_location as shl','shl.l_id = shp.location_id', 'inner');
    $this->db->join('sh_com_registration as shc','shc.id = shp.company_id','inner' );

		$this->db->where(array('shp.status'=>1));	

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
        $this->db->where('shp.status', 1);
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

   function get_datatables($extra="",$company="",$location="")
   {
       $this->_get_datatables_query();
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
		if($extra != "")
		{
			$this->db->where("shp.Type",$extra);
		}
		$this->db->where("shp.Type !=","o");
    if ($company !="" && $company != 0) 
        {
          $this->db->where('shc.id', $company);
        }
        if ($location != "" && $location != 0) 
        {
          $this->db->where('shl.l_id',$location);
        }
    
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

    public function get_company()
    {
      $this->db->where('status' , 1);
      $query = $this->db->get('sh_com_registration');
      return $query->result();
    }

    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('shpump',$data);
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
}
?>