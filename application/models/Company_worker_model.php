<?php
  class Company_worker_model extends CI_Model
  {
    // search with ajax
  var $table = 'sh_workers as shr';
    var $column_order = array(null, 'shr.name','shr.mobile','shr.shift','shl.l_name'); //set column field database for datatable orderable
   var $column_search = array('shr.id','shr.name','shr.mobile','shr.shift','shl.l_name'); //set column field database for datatable searchable
   var $order = array('shr.code' => 'ASC'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

  private function _get_datatables_query()
    {
       
    $this->db->select('shr.show,shr.active,shr.code,shr.id,shr.name,shr.mobile,shl.l_name,shr.shift');
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
		   }   else{
				$this->db->or_like($item, $_POST['search']['value']);
		   }
		   if(count($this->column_search) - 1 == $i) //last loop
			   $this->db->group_end(); //close bracket
	   }
	   $i++;
   }
	// $this->db->where('shr.type', '2');
	$this->db->where('shr.status', 1);
	if(isset($_POST['order'])) // here order processing
	{
		$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
   }else if(isset($this->order)){
		$order = $this->order;
		$this->db->order_by(key($order), $order[key($order)]);
   }
}

   function get_datatables($id="",$lid="")
   {
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
			if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
    if($lid != "")
    {
      $this->db->where("shr.location_id",$lid);
    }
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
   }
   function count_filtered($id="",$lid="")
   {
		$this->_get_datatables_query();
                if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
                if($lid != "")
    {
      $this->db->where("shr.location_id",$lid);
    }
		$query = $this->db->get();
		return $query->num_rows();
   }

   public function count_all($id="",$lid="")
    {
        $this->db->from($this->table);
        if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
                if($lid != "")
    {
      $this->db->where("shr.location_id",$lid);
    }
		$this->db->where("status","1");
		$this->db->where("company_id",$id);
        return $this->db->count_all_results();
    }

    public function select($id)
    {
      $this->db->where('id',$id);
      $this->db->where('status','1');
	  $this->db->from('sh_workers');
      $query = $this->db->get();
		return $query->row();
    }
    public function select_location($id1)
    {
      $this->db->where('company_id',$id1);
      $this->db->where('status','1');
      $this->db->order_by("l_name", "asc");
      $q = $this->db->get('sh_location');
      return $q;
    }

    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_workers',$data);
    }

    function update($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_workers',$data);
    }
	function update_worker_salary($id,$tbl,$data)
    {
      $this->db->where('id',$id);
      $this->db->update($tbl,$data);
    }
	function select_one_by_id($id)
    {
      $this->db->where('l_id',$id);
	  $this->db->from('sh_location');
      $query = $this->db->get();
		return $query->row();
    }
	function select_location_wallet($id)
    {
      $this->db->where('location_id',$id);
      $this->db->where('status','1');
      $this->db->where('show','1');
	  $this->db->from('sh_wallet_list');
      $query = $this->db->get();
		return $query->result();
    }
	function selectall()
    {
      $this->db->where('status','1');
	  $this->db->from('sh_workers');
      $query = $this->db->get();
		return $query->result();
    }
	function worker_monthly_salary($month,$year,$lid){
		$query = $this->db->query("SELECT sh_workers.name,sh_workers.salary,sh_workers_monthly_salary.salary AS workermonthlysalary,sh_workers_monthly_salary.id FROM sh_workers_monthly_salary 
JOIN sh_workers ON sh_workers.id = sh_workers_monthly_salary.workers_id
WHERE sh_workers_monthly_salary.month = '$month' AND  sh_workers_monthly_salary.year = '$year' AND sh_workers.location_id = '$lid'");
		return $query->result();	
	}
  }
?>