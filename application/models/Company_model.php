<?php
	
class Company_model extends CI_Model
{
	var $table = 'sh_com_registration as shr';
   	var $column_order = array(null, 'shr.name','shr.email','shr.mobile'); //set column field database for datatable orderable
   	var $column_search = array('shr.name','shr.email','shr.mobile'); //set column field database for datatable searchable
   	var $order = array('shr.id' => 'desc'); // default order

   	public function __construct() 
   	{
    	$this->load->database();
   	}

	private function _get_datatables_query()
   	{
       
    $this->db->select('shr.id,shr.name,shr.email,shr.mobile');
		$this->db->from($this->table);
    


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
        $this->db->where('shr.status', 1);
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

   function get_datatables($extra="")
   {
       $this->_get_datatables_query();
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
		if($extra != "")
		{
			$this->db->where("Type",$extra);
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

    function check_username($username)
		{
			$this->db->from('sh_com_registration');
			$this->db->where('name', $username);
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

     function check_user($id)
    {
      $this->db->from('sh_com_registration');
      $this->db->where('id', $id);
      $this->db->where('status', '1');
      
      $query = $this->db->get();
      return $query->result();
      //echo $query->num_rows();die();
      // if($query->num_rows() == 1)
      // {
      //   return false;
      // }
      // else
      // {
      //   return $query->result();
      // }
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
}
	
?>