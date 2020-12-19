<?php

Class Home_model extends CI_Model 
{
	function getadmin(){
		$query = $this->db->get_where("shadminmaster",array("status"=>'1'));	
		return $query->num_rows();
	}
	function getcust(){
		$query = $this->db->get_where("AdgUserMaster",array("status"=>'1'));	
		return $query->num_rows();
	}
	function getquery(){
		$query = $this->db->get_where("demo_query",array("status"=>'1'));	
		return $query->num_rows();
	}
	function getcategory(){
		$query = $this->db->get_where("demo_query",array("status"=>'1'));	
		return $query->num_rows();
	}
	function graph(){
		$query = $this->db->query("SELECT COUNT(id) as num,DATE_FORMAT(created_at, '%d %b') as dates FROM demo_query WHERE STATUS='1' GROUP BY DATE_FORMAT(created_at, '%M %d %Y') ORDER BY DATE_FORMAT(created_at, '%M %d %Y') DESC");
		return $query->result() ;

	}

	/*--------------------------to search-----------------------------*/
	function get_category()
	{
		
		 $query = $this->db->query("SELECT category_name,logo,id FROM `category_master` WHERE `status`='1' ORDER BY id DESC");
		
		return $query->result() ;
    }
    function get_area()
	{
		$this->db->select('area_name,id ');
		$this->db->where('status',1);
		$query=$this->db->get("area_list");
		return $query->result() ;
    }
    function get_gender()
	{
		$this->db->select('gender');
		$query=$this->db->get("company_master");
		return $query->result() ;
    }
    function get_search_results($customword,$area_name,$category_name,$gender)
    {
		
    	/*$this->db->select("count(company_master.id) as count");
    	$this->db->from("company_master");
		$this->db->join('area_list', 'area_list.id = company_master.area');
		$this->db->join('category_master', 'category_master.id = company_master.category');*/
		$sql = "SELECT count(company_master.id) as count FROM `company_master` JOIN `area_list` ON `area_list`.`id` = `company_master`.`area` JOIN `category_master` ON `category_master`.`id` = `company_master`.`category` WHERE company_master.status = '1'";
		if($area_name != ""){
			$sql .=" and  `area_list`.`id` IN('$area_name')";
		}
		if($gender != ""){
			$sql .=" and  company_master.gender ='$gender'";
		}
		$query = $this->db->query($sql);
        
        
		return $query->row();
    }
    function get_search_results_data($customword,$area_name,$category_name,$gender,$one,$two)
    {
		$sql = "SELECT 
  `company_master`.`companyname`,
  `company_master`.`address`,
  `company_master`.`logo`,
  `company_master`.`contectperson`,
  `company_master`.`logo`,
  `company_master`.`weburl`,
  area_list.`area_name`,
  gallery_master.`images` 
FROM
  `company_master` 
  JOIN `area_list` 
    ON `area_list`.`id` = `company_master`.`area` 
  JOIN `category_master` 
    ON `category_master`.`id` = `company_master`.`category`
    JOIN `gallery_master`
    ON `gallery_master`.`company_id` = `company_master`.`id` 
WHERE company_master.status = '1' ";
		if($area_name != ""){
			$sql .= " and area_list.id IN ('$area_name')";
		}if($category_name != ""){
			$sql .= " and category_master.id ='".$category_name."'";
		}if($gender != ""){
			$sql .= " and company_master.gender ='".$gender."'";
		}
		$sql .= " ORDER BY company_master.id DESC  limit ". $two.",".$one; 
		$query = $this->db->query($sql);
        return $query->result();
    }
   

/*-------------------------to add contactus details------------------------*/
	
	function add_contactus_detail(){
		$data = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'email' => $this->input->post('email'),
            'subject' => $this->input->post('subject'),
            'comment' => $this->input->post('comment'),
            'contact_created_date' => date('Y-m-d')
        );
        $this->db->insert('contact_us',$data);
	}
	function getsubcategory(){
		$this->db->join("category_master","category_master.id=subcategory_master.category_id");
		$query = $this->db->get_where("subcategory_master",array("category_master.status"=>'1',"subcategory_master.status"=>'1'));	
		return $query->num_rows();
	}
	
}

?>