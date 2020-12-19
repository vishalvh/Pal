<?php
class Saving_card_model extends CI_Model{
	var $table = 'sh_card_list as sc';
	var $column_order = array(null,'sc.name','shl.l_name'); //set column field database for datatable orderable
	var $column_search = array('sc.name','shl.l_name'); //set column field database for datatable searchable
	var $order = array('sc.name' => 'desc'); // default order
	public function __construct() {
       $this->load->database();
	}
	private function _get_datatables_query(){
		$this->db->select('sc.id,sc.name,shl.l_name');
		$this->db->from($this->table);
		$this->db->join('sh_location as shl','shl.l_id = sc.location_id', 'inner');
		$this->db->where(array('sc.status'=>1));	
		$i = 0;
		foreach ($this->column_search as $item){ // loop column
           if($_POST['search']['value']){ // if datatable send POST for search               
               if($i===0){ // first loop
                   $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                   $this->db->like($item, $_POST['search']['value']);
               }else{
                   $this->db->or_like($item, $_POST['search']['value']);
               }
               if(count($this->column_search) - 1 == $i) //last loop
                   $this->db->group_end(); //close bracket
           }
           $i++;
		}
		if(isset($_POST['order'])){ // here order processing
           $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	function get_datatables($extra="",$id=""){
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		
        if($extra != ""){
			$this->db->where("sc.location_id",$extra);
		}
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	function count_filtered($extra="",$id=""){
		$this->_get_datatables_query();
		
       if($extra != ""){
			$this->db->where("sc.location_id",$extra);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function count_all($extra="",$id=""){
        $this->db->from($this->table);
		
        if($extra != ""){
			$this->db->where("sc.location_id",$extra);
		}
		$this->db->where("sc.status","1");
        return $this->db->count_all_results();
    }
	function delete($id,$data){
      $this->db->where('id',$id);
      $this->db->update('sh_card_list',$data);
    }
	
    
    function update($id,$data){
      $this->db->where('id',$id);
      $this->db->update('sh_card_list',$data);
    }
		
		
    // pranjal 21/04/2018
    public function select_location($id1){
		$this->db->where('company_id',$id1);
		$this->db->where('status','1');
		$this->db->order_by("l_name", "asc");
		$q = $this->db->get('sh_location');
		return $q;
    }
	function get_tbl_list($tbl,$cond,$order){
		$this->db->where($cond);
		$this->db->order_by($order[0],$order[1]);
		$q = $this->db->get($tbl);
		return $q->result();
    }
	function get_tbl_one($tbl,$cond,$order){
		$this->db->where($cond);
		$q = $this->db->get($tbl);
		return $q->row();
    }

}
?>