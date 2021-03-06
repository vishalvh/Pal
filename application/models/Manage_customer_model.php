<?php
class Manage_customer_model extends CI_Model
{
    var $table = 'sh_userdetail as shr';
    var $column_order = array(null, 'shr.name','shr.address','shr.phone_no','shr.cheque_no','shr.bank_name','shr.personal_guarantor','shl.l_id','shl.l_name'); //set column field database for datatable orderable
   var $column_search = array('shr.name','shr.address','shr.phone_no','shr.cheque_no','shr.bank_name','shr.personal_guarantor','shl.l_id','shl.l_name'); //set column field database for datatable searchable
   var $order = array('shr.name' => 'ASC'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

  private function _get_datatables_query()
    {
       
    $this->db->select('shr.`show`,shr.`open_close`,shr.id,shr.name,shr.address,shr.phone_no,shr.cheque_no,shr.bank_name,shr.personal_guarantor,shl.l_id,shl.l_name,shr.block,shr.active_status');
    $this->db->from($this->table);
    $this->db->join('sh_location as shl','shr.location_id = shl.l_id','inner');
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

   function get_datatables($extra="",$id="")
   {
       $this->_get_datatables_query();
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
    if($extra != "")
    {
      $this->db->where("location_id",$extra);
    }
    if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
       $query = $this->db->get();
       return $query->result();
   }

   function count_filtered($extra="",$id="")
   {
       $this->_get_datatables_query();
    if($extra != "")
    {
      $this->db->where("location_id",$extra);
    }
    if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
       $query = $this->db->get();
       return $query->num_rows();
   }

   public function count_all($extra="",$id="")
    {
        $this->db->from($this->table);
    if($extra != ""){
      $this->db->where("location_id",$extra);
    }
    if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
    $this->db->where("status","1");
        return $this->db->count_all_results();
    } 

    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_userdetail',$data);
    }
    function update($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('sh_userdetail',$data);
    }
	function update_contactperson_by_customer_id($id,$data)
    {
      $this->db->where('cust_id',$id);
      $this->db->update('sh_customer_contactperson',$data);
    }
    public function select_location($id1)
    {
      $this->db->where('company_id',$id1);
      $this->db->where('status','1');
       $this->db->order_by("l_name", "asc");
      $q = $this->db->get('sh_location');
      return $q;
    }
	public function get_all_customer(){
      $this->db->where('status','1');
      $query = $this->db->get('sh_userdetail');
       return $query->result();
    }
	public function get_all_location(){
      $this->db->where('status','1');
      $query = $this->db->get('sh_location');
       return $query->result();
    }
	public function get_customer_contact_person($id){
      $this->db->where('status','1');
      $this->db->where('cust_id',$id);
      $query = $this->db->get('sh_customer_contactperson');
       return $query->result();
    }
}
?>