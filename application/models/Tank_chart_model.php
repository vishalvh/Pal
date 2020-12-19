<?php
class Tank_chart_model extends CI_Model{
	var $table = 'sh_tank_chart as stc';
	var $column_order = array(null, 'stl.tank_name','stc.reading','stc.volume');
	var $column_search = array('stl.tank_name','stc.reading','stc.volume');
	var $order = array('stc.reading' => 'asc');

	public function __construct(){
		$this->load->database();
	}

	private function _get_datatables_query(){
		$this->db->select('stc.id,stl.tank_name,stc.reading,stc.volume');
		$this->db->from($this->table);
		$this->db->join('sh_tank_list as stl','stl.id = stc.tank_id', 'inner');
		$this->db->where(array('stl.status'=>1,'stc.status'=>1)); 
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

	function get_datatables($tid,$extra="")
	{
		$this->_get_datatables_query();
		$this->db->where("stc.tank_id",$tid);
		if($extra != "")
		{
			$this->db->where("stl.tank_name",$extra);
		}
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($tid,$extra=""){
		$this->_get_datatables_query();
		$this->db->where("stc.tank_id",$tid);
		if($extra != "")
		{
			$this->db->where("stl.tank_name",$extra);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($tid,$extra=""){
        $this->db->from($this->table);
		if($extra != ""){
			$this->db->where("stl.tank_name",$extra);
		}
		$this->db->where("status","1");
        return $this->db->count_all_results();
    }
	
	public function insert($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	
	public function update($table,$data,$where){
		$this->db->update($table,$data);
		$this->db->where($where);
		return $this->db->affected_rows();
	}
	
	public function select($select,$table,$where,$order){
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order);
		return $this->db->get();
	}
	
    public function selecttanks($tid)
    {
		$this->db->select('stc.id,stl.tank_name,stc.reading,stc.volume');
		$this->db->from($this->table);
		$this->db->join('sh_tank_list as stl','stl.id = stc.tank_id', 'inner');
		$this->db->where(array('stl.status'=>1,'stc.status'=>1,"stc.tank_id"=>$tid));
		$this->db->order_by("stc.reading","asc");
		$q = $this->db->get();
		return $q->result();
    }


	

    // public function select()
    // {
		// $this->db->where('type','2');
		// $this->db->where('status','1');
		// $q = $this->db->get('sh_com_registration');
		// return $q;
    // }
	public function select2($id = ""){
		$this->db->from('sh_com_registration');
		$this->db->where('status','1');
		if($id != ""){
			$this->db->where('id',$id);
		}
		$query = $this->db->get();
		return $query->row();
    }
    public function get_location($id){
		$query = $this->db->query("SELECT l.* FROM sh_madetor_l_id AS  m 
		JOIN `sh_location` AS l ON l.`l_id` =m.`l_id`  
		WHERE m.`status` = 1 
		AND l.`status` = 1
		AND m.`m_id`= '$id' ");
		return $query;
	}

    function delete($id,$data)
    {
		$this->db->where('id',$id);
		$this->db->update('shusermaster',$data);
    }

    // function update($id,$data)
    // {
      // $this->db->where('id',$id);
      // $this->db->update('shusermaster',$data);
    // }

    function update_profile($id,$data)
    {
      $this->db->where('id', $id);
      $this->db->update('sh_com_registration', $data);
    }

    function check_username($username)
    {
      $this->db->from('shusermaster');
      $this->db->where('UserFName', $username);
      $this->db->where('status', '1');
      $this->db->limit(1);
      $query = $this->db->get();
      if($query->num_rows() == 1)
      {
        return false;
      }
      else
      {
        return $query->result();
      }
    }
    
    function check_email($email)
    {
      $this->db->from('shusermaster');
      $this->db->where('UserEmail', $email);
      $this->db->where('status', '1');
      $this->db->limit(1);
      $query = $this->db->get();
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
      if($query->num_rows() == 1)
      {
        return false;
      }
      else
      {
        return $query->result();
      }
    }

    function check_user($id)
    {
      $this->db->from('shusermaster');
      $this->db->where('id', $id);
      $this->db->where('status', '1');
      $query = $this->db->get();
      return $query->result();
    }
    function check_user1($id)
    {
      $this->db->from('sh_com_registration');
      $this->db->where('id', $id);
      $this->db->where('status', '1');
      $query = $this->db->get();
      return $query->result();
    }

    function check_password($id,$old_password)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('sh_com_registration');
        $row    = $query->row();
        if($query->num_rows() > 0){
          $row = $query->row();
          if($old_password == $row->password)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
    }
    function update_pass($id,$data)
    {
      $this->db->where('id', $id);
      $this->db->update('sh_com_registration',$data);
    }
    function select_shiftby_id($id)
    {
      $this->db->where('status','1');
      $this->db->where('id',$id);
      $q = $this->db->get('shusermaster');
      return $q->result();
    }
  }
?>