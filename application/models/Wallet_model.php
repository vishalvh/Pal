<?php
class Wallet_model extends CI_Model{
	var $table = 'sh_wallet_list as stl';
	var $column_order = array(null, 'stl.name','shl.l_name');
	var $column_search = array('stl.name','shl.l_name');
	var $order = array('stl.name' => 'asc');

	public function __construct(){
		$this->load->database();
	}

	private function _get_datatables_query(){
		$this->db->select('stl.show,stl.id,stl.name,shl.l_name');
		$this->db->from($this->table);
		$this->db->join('sh_location as shl','shl.l_id = stl.location_id', 'inner');
		$this->db->where(array('stl.status'=>1,'shl.status'=>1)); 
        $i = 0;
		foreach ($this->column_search as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif(isset($this->order))
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
		if($id != "")
		{
			$this->db->where("stl.company_id",$id);
		}
                if($extra != "")
		{
			$this->db->where("stl.location_id",$extra);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($extra="",$id=""){
		$this->_get_datatables_query();
		if($id != "")
		{
			$this->db->where("stl.company_id",$id);
		}
                if($extra != "")
		{
			$this->db->where("stl.location_id",$extra);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($extra="",$id=""){
        $this->db->from($this->table);
		if($id != "")
		{
			$this->db->where("stl.company_id",$id);
		}
                if($extra != "")
		{
			$this->db->where("stl.location_id",$extra);
		}
		$this->db->where("status","1");
        return $this->db->count_all_results();
    }
	
	public function insert($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	
	public function update($table,$data,$where){
		$this->db->where($where);
		$this->db->update($table,$data);
		return $this->db->affected_rows();
	}
	
	public function select($select,$table,$where,$order){
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order);
		$q = $this->db->get();
		return $q->result();
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
		$this->db->update('shusermaster',$data);
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