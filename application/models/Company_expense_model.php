<?php
  class Company_expense_model extends CI_Model
  {
    // search with ajax
  var $table = 'sh_expensein_types as shr';
    var $column_order = array(null, 'shr.exps_name'); //set column field database for datatable orderable
   var $column_search = array('shr.id','shr.exps_name'); //set column field database for datatable searchable
   var $order = array('shr.exps_name' => 'ASC'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

  private function _get_datatables_query(){
		$this->db->select('shr.show,shr.id,shr.exps_name,shl.l_name');
		$this->db->from($this->table);
		$this->db->join('sh_location as shl','shl.l_id = shr.location_id', 'inner');
		$this->db->where(array('shr.status'=>1,'shl.status'=>1,'exps_id'=>1)); 
		$i = 0;
		foreach ($this->column_search as $item) // loop column
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}   else{
					$this->db->or_like($item, $_POST['search']['value']);
			}
			if(count($this->column_search) - 1 == $i) //last loop
				$this->db->group_end(); //close bracket
			}
			$i++;
		}
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
}

   function get_datatables($id,$lid="")
   {
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
			if($id != "")
    {
      $this->db->where("shr.comapny_id",$id);
    }
    if($lid != "")
    {
      $this->db->where("shr.location_id",$lid);
    }
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
   }
   function count_filtered($id,$lid="")
   {
       
		$this->_get_datatables_query($id);
                if($lid != "")
    {
      $this->db->where("shr.location_id",$lid);
    }
		$this->db->where("shr.status","1");
		$this->db->where("shr.exps_id","1");
		if($id != "")
    {
      $this->db->where("shr.comapny_id",$id);
    }
		$query = $this->db->get();
		return $query->num_rows();
   }

   public function count_all($id,$lid="")
    {
        $this->db->from($this->table);
		$this->db->where("status","1");
		$this->db->where("exps_id","1");
		if($id != "")
    {
      $this->db->where("shr.comapny_id",$id);
    }
    if($lid != "")
    {
      $this->db->where("shr.location_id",$lid);
    }
        return $this->db->count_all_results();
    }

    public function select($id)
    {
      $this->db->where('id',$id);
      $this->db->where('status','1');
	  $this->db->from('sh_expensein_types');
      $query = $this->db->get();
		return $query->row();
    }
    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_expensein_types',$data);
    }

    function update($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_expensein_types',$data);
    }
  }
?>