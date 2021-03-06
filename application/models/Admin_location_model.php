<?php 
  class Admin_location_model extends CI_Model
  {
    var $table = 'sh_location';
    var $column_order = array(null,'l_name','phone_no','address','show_hide'); //set column field database for datatable orderable
   var $column_search = array('l_name','phone_no','address','show_hide'); //set column field database for datatable searchable
   var $order = array('l_name' => 'asc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

  private function _get_datatables_query()
    {
       
    $this->db->select('l_id,l_name,phone_no,address,show_hide');
    $this->db->from($this->table);

    
    $this->db->where(array('status'=>1)); 

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
        
        $this->db->where('status', 1);
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

   function get_datatables($extra="",$id="")
   {
       $this->_get_datatables_query();
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
    if($extra != "")
    {
      $this->db->where("Type",$extra);
    }
    if($id != "")
    {
      $this->db->where("company_id",$id);
    }
       $query = $this->db->get();
       return $query->result();
   }

   function count_filtered($extra="",$id="")
   {
       $this->_get_datatables_query();
    if($extra != "")
    {
      $this->db->where("Type",$extra);
    }
	if($id != "")
    {
      $this->db->where("company_id",$id);
    }
       $query = $this->db->get();
       return $query->num_rows();
   }

   public function count_all($extra="",$id="")
    {
        $this->db->from($this->table);
    if($extra != ""){
      $this->db->where("Type",$extra);
    }
	if($id != "")
    {
      $this->db->where("company_id",$id);
    }
    $this->db->where("status","1");
        return $this->db->count_all_results();
    }

    function delete($id,$data)
  {
    $this->db->where('l_id',$id);
    $this->db->update('sh_location',$data);
  }

  function update($id,$data)
    {
      $this->db->where('l_id',$id);
      $this->db->update('sh_location',$data);
    }
}
?>