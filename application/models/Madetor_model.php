<?php
  class Madetor_model extends CI_Model
  {
    // search with ajax
  var $table = 'sh_com_registration as m';
    var $column_order = array(null, 'm.name','m.email','m.mobile'); //set column field database for datatable orderable
   var $column_search = array('m.name','m.email_id','m.mobile_no'); //set column field database for datatable searchable
   var $order = array('m.name' => 'ASC'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

  private function _get_datatables_query()
    {
       
    $this->db->select('m.show,m.id,m.name,m.email,m.mobile');
    $this->db->join('sh_madetor_l_id as lid','lid.m_id = m.id');
    $this->db->from($this->table);
//     $this->db->join('sh_location location','location.l_id=cr.location_id');
    $this->db->where(array('m.status'=>1,'type' => 'm','lid.status'=>1)); 
    $this->db->group_by('m.id'); 
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

   function get_datatables($id,$lid = "")
   {
		$this->_get_datatables_query();
                
		if($_POST['length'] != -1)
			if($id != "")
    {
      $this->db->where("m.company_id",$id);
    }
    if($lid != "")
    {
      $this->db->where("lid.l_id",$lid);
    }
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
   }
   public function insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
}
   function count_filtered($id = "")
   {
		$this->_get_datatables_query();
		$this->db->where("m.status","1");
		if($id != "")
    {
      $this->db->where("m.company_id",$id);
    }
		$query = $this->db->get();
		return $query->num_rows();
   }

   public function count_all($id = "")
    {
        $this->db->from($this->table);
		$this->db->where("status","1");
		
		if($id != "")
    {
      $this->db->where("m.company_id",$id);
    }
        return $this->db->count_all_results();
    }
    public function select_all($field,$condition){
        
        $query = $this->db->get_where($field, $condition);
        $data['user'] = $query->result();
        return $data['user'];
    }

    public function select($id)
    {
      $this->db->where('id',$id);
      $this->db->where('status','1');
      $this->db->where('type','m');
	  $this->db->from('sh_com_registration');
      $query = $this->db->get();
		return $query->row();
    }
    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_com_registration',$data);
    }

    function update($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_com_registration',$data);
    }
     function update_madetor($id,$data)
    {
      $this->db->where('m_id',$id);
      $this->db->update('sh_madetor_l_id',$data);
    }
     function check_email($email)
    {
      $this->db->from('sh_com_registration');
      $this->db->where('email', $email);
      $this->db->where('status', '1');
      $this->db->limit(1);
      $query = $this->db->get();
      //echo $query->num_rows();die();
      if($query->num_rows() == 1)
      {
        return false;
      }
      else
      {
        return $query->result();
      }
    }
    function check_email1($email,$id)
    {
      $this->db->from('sh_com_registration');
      $this->db->where('id !=', $id);
      $this->db->where('email',$email);
      $this->db->where('status', '1');
      $this->db->limit(1);
      $query = $this->db->get();
      //echo $query->num_rows();die();
      
        return $query->num_rows();
      
    }
    public function select_location2($id1)
    {
                $this->db->select("*");
		$this->db->where('company_id',$id1);
		$this->db->where('status','1');
		$this->db->order_by("l_name", "asc");
		$q = $this->db->get('sh_location');
		return $q->result();
    }
  }
?>