<?php
  class Admin_model extends CI_Model
  {
    // search with ajax
  var $table = 'shusermaster as shr';
    var $column_order = array(null, 'shr.UserFName','shr.UserEmail','shr.UserMNumber','shl.l_name','shr.shift'); //set column field database for datatable orderable
   var $column_search = array('shr.UserFName','shr.UserEmail','shr.UserMNumber','shl.l_name','shr.shift'); //set column field database for datatable searchable
   var $order = array('shr.UserFName' => 'asc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

  private function _get_datatables_query()
    {
       
    $this->db->select('shr.Active,shr.id,shr.UserFName,shr.UserEmail,shr.UserMNumber,shl.l_name,shr.shift');
    $this->db->from($this->table);
    $this->db->join('sh_location as shl','shl.l_id = shr.l_id', 'inner');


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
      $this->db->where("shr.l_id",$extra);
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
      $this->db->where("shr.l_id",$extra);
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
      $this->db->where("shr.l_id",$extra);
    }
	if($id != "")
    {
      $this->db->where("shr.company_id",$id);
    }
    $this->db->where("status","1");
        return $this->db->count_all_results();
    }

    // function __construct()
    // {
    //  parent ::__construct();
    // }
    public function select()
    {
      $this->db->where('type','2');
      $this->db->where('status','1');
      $q = $this->db->get('sh_com_registration');
      return $q;
    }
      public function select2($id = "")
    {
    $this->db->from('sh_com_registration');
      //$this->db->where('type','');
      $this->db->where('status','1');
      if($id != ""){
          $this->db->where('id',$id);
      }
      $query = $this->db->get();
       return $query->row();
    }
    public function select_location($id1)
    {
      $this->db->where('company_id',$id1);
      $this->db->where('status','1');
      $this->db->where('show_hide','show');
      $this->db->order_by("l_name", "asc");
      $q = $this->db->get('sh_location');
      return $q;
    }
    public function get_location($id){
            $query = $this->db->query("SELECT l.* FROM sh_madetor_l_id AS  m 
JOIN `sh_location` AS l ON l.`l_id` =m.`l_id`  
WHERE m.`status` = 1 
AND l.`status` = 1
AND l.`show_hide` = 'show'
AND m.`m_id`= '$id' 
ORDER BY  l.l_name ASC ");
		return $query;
            
        }

    function delete($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('shusermaster',$data);
    }

    function update($id,$data)
    {
      $this->db->where('id',$id);
      $this->db->update('shusermaster',$data);
    }

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
      $this->db->from('shusermaster');
      $this->db->where('UserEmail', $email);
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
        // echo "Old Password : ".$old_password."<br>";
        // echo "From DB : ".$row->password."<br>";
        

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
		
	function user_detail($id)
    {
      $this->db->from('shusermaster');
      $this->db->where('id', $id);
      $query = $this->db->get();
      return $query->row();
      
    }
  }
?>