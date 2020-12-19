<?php
  class Message_master_model extends CI_Model
  {
    // search with ajax
  var $table = 'message_list as shr';
    var $column_order = array(null, 'shr.mobile_number', 'shr.type', 'l.l_name', 'shr.msg_status', 'shr.message', 'shr.created_date_time', 'shr.sending_date_time'); //set column field database for datatable orderable
   var $column_search = array('shr.id','shr.mobile_number', 'shr.type', 'l.l_name', 'shr.msg_status', 'shr.message', 'shr.created_date_time', 'shr.sending_date_time'); //set column field database for datatable searchable
   var $order = array('shr.id' => 'DESC'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

  private function _get_datatables_query(){
		$this->db->select('shr.id,shr.mobile_number,shr.type,l.l_name as location,shr.msg_status,shr.message,shr.created_date_time,shr.sending_date_time');
		$this->db->from($this->table);
		$this->db->join('sh_location as l','l.l_id = shr.location_id', 'inner');
		$this->db->where(array('shr.status'=>1,'l.status'=>1)); 
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

   function get_datatables($id,$lid="",$type="",$mobile_number="")
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
	if($mobile_number != "")
    {
      $this->db->where("shr.mobile_number",$mobile_number);
    }
	if($type != "")
    {
      $this->db->where("shr.type",$type);
    }
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
   }
   function count_filtered($id,$lid="",$type="",$mobile_number="")
   {
       
		$this->_get_datatables_query($id);
                if($lid != "")
    {
      $this->db->where("shr.location_id",$lid);
    }
	if($mobile_number != "")
    {
      $this->db->where("shr.mobile_number",$mobile_number);
    }
	if($type != "")
    {
      $this->db->where("shr.type",$type);
    }
		$this->db->where("shr.status","1");
		if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
		$query = $this->db->get();
		return $query->num_rows();
   }

   public function count_all($id,$lid="",$type="",$mobile_number="")
    {
        $this->db->from($this->table);
		$this->db->where("status","1");
		if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
    if($lid != "")
    {
      $this->db->where("shr.location_id",$lid);
    }
	if($mobile_number != "")
    {
      $this->db->where("shr.mobile_number",$mobile_number);
    }
	if($type != "")
    {
      $this->db->where("shr.type",$type);
    }
        return $this->db->count_all_results();
    }
	public function insert($data) {
        $this->db->insert('message_list', $data);
        return $this->db->insert_id();
    }
	function sendemployeemessage($location){
		$query = $this->db->query("SELECT * FROM shusermaster WHERE l_id = '$location' AND STATUS= '1' AND Active = '1'");
		return $query->result();
	}
	function sendworkermessage($location){
		$query = $this->db->query("SELECT * FROM sh_workers WHERE location_id = '$location' AND status= '1' AND sh_workers.show = '1' AND active = '1'");
		return $query->result();
	}
	function sendcustomermessage($location){
		$query = $this->db->query("SELECT * FROM sh_userdetail WHERE location_id = '$location' AND status= '1' AND block = '1' AND sh_userdetail.show = '1' AND active_status = 'Active'");
		return $query->result();
	}
	function getpendingmessage(){
		$query = $this->db->query("SELECT * FROM message_list WHERE msg_status = 'Pending' limit 0,10");
		return $query->result();
	}
	function updatestatussend($id){
		$this->db->where('id', $id);
        $this->db->update('message_list',array('msg_status'=>'Send','sending_date_time'=>date('Y-m-d H:i:s')));
        return 1;
	}
  }
?>