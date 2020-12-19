<?php
class Tank_dia_modal extends CI_Model{

	public function insert($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	public function update($table,$data,$where){
		$this->db->update($table,$data,$where);
		return $this->db->affected_rows();
	}
	
	 public function selectchartData($tid,$main_id)
    {
		$this->db->select('*');
		$this->db->from('sh_tank_chart');
		$this->db->where('tank_id',$tid);
		$this->db->where('status','1');
		//$this->db->where('chart_main_id',$main_id);
		$this->db->order_by("id","asc");
		$q = $this->db->get();
		return $q->result();
    }
	public function selecttanks($tid)
    {
		$this->db->select('tank_dia_chart_main.*,stl.tank_name');
		$this->db->from('tank_dia_chart_main');
		$this->db->join('sh_tank_list as stl','stl.id = tank_dia_chart_main.tank_id', 'inner');
		$this->db->where(array('stl.status'=>1,'tank_dia_chart_main.deleted_flag'=>"N","tank_dia_chart_main.tank_id"=>$tid,""));
		$this->db->order_by("tank_dia_chart_main.id","desc");
		$q = $this->db->get();
		return $q->row();
		//return $q->result_array();
    }
	
	public function tank_data($id){
		$this->db->select('*');
		$this->db->from('sh_tank_list');
		$this->db->where('id',$id);
		$this->db->where('status','1');
		$q = $this->db->get();
		return $q->row();
	}

}