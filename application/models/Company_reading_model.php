<?php class Company_reading_model extends CI_Model {

    var $table = 'shdailyreadingdetails as drd';
   	var $column_order = array(null, 'location.l_name','user.UserFName','user.shift','drd.Date','drd.PatrolReading','drd.`DieselReading`','drd.`meterReading`','drd.`TotalCash`','drd.`TotalCredit`','drd.`TotalExpenses`','drd.`TotalAmount`','drd.disel_deep_reding','drd.petrol_deep_reding'); //set column field database for datatable orderable
   var $column_search = array('location.l_name','user.UserFName','user.shift','drd.Date','drd.PatrolReading','drd.`DieselReading`','drd.`meterReading`','drd.`TotalCash`','drd.`TotalCredit`','drd.`TotalExpenses`','drd.`TotalAmount`','drd.disel_deep_reding','drd.petrol_deep_reding'); //set column field database for datatable searchable
   var $order = array('drd.id' => 'desc'); // default order

   public function __construct() 
   {
       $this->load->database();
   }

	private function _get_datatables_query()
   	{
       
    $this->db->select(' `drd`.`id`,drd.disel_deep_reding,drd.petrol_deep_reding,
	drd.Date,
  	drd.`date`,
  drd.`PatrolReading`
  ,drd.`DieselReading`
  ,drd.`meterReading`,
  drd.`TotalCash`,
  drd.`TotalCredit`,
  drd.`TotalExpenses`,
  user.UserFName,
  user.shift,
  location.l_name,
  drd.`TotalAmount`');
		$this->db->from($this->table);
    
    $this->db->join('shusermaster user','user.id=drd.UserId');
    $this->db->join('sh_location location','location.l_id=user.l_id');


		$this->db->where(array('drd.status'=>1));	

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
        $this->db->where('drd.status', 1);
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

   function get_datatables($employeename ="",$fdate = "",$tdate = "",$id="",$location="",$current_date="")
   {
       $this->_get_datatables_query();
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
		if($employeename != "")
		{
			$this->db->where("user.id",$employeename);
		}if ($fdate != "") {
		$newfdate =	date('Y-m-d', strtotime($fdate));
         $this->db->where('drd.date >=', $newfdate);
        }if ($tdate != "") {
			$newtdate =	date('Y-m-d', strtotime($tdate));
         $this->db->where('drd.date <=', $newtdate);
        }
    if($id != "")
    {
      $this->db->where("user.company_id",$id);
    }
    if ($location != "") 
    {
      $this->db->where('user.l_id',$location);
    }
    if ($fdate =="" && $tdate =="") 
    {
      $this->db->where('date',$current_date);
    }
    
       $query = $this->db->get();
       return $query->result();
   }

   function count_filtered($employeename ="",$fdate = "",$tdate = "",$id="")
   {
       $this->_get_datatables_query();
		if($employeename != "")
		{
			$this->db->where("user.id",$employeename);
		}if ($fdate != "") {
         $this->db->where('drd.date >=', $fdate);
        }if ($tdate != "") {
         $this->db->where('drd.date <=', $tdate);
        }
    if($id != "")
    {
      $this->db->where("user.company_id",$id);
    }
       $query = $this->db->get();
       return $query->num_rows();
   }

   public function count_all($employeename ="",$fdate = "",$tdate = "",$id="")
    {	 $this->_get_datatables_query();
        
		if($employeename != "")
		{
			$this->db->where("user.id",$employeename);
		}if ($fdate != "") {
         $this->db->where('drd.date >=', $fdate);
        }if ($tdate != "") {
         $this->db->where('drd.date <=', $tdate);
        }
    if($id != "")
    {
      $this->db->where("user.company_id",$id);
    }
		$this->db->where("drd.status","1");
        return $this->db->count_all_results();
    }   
    function get_val($query1){
	$query = $this->db->query($query1);
	$data['user'] = $query->result_array();
	return $data['user'];
	
}
public function get_one($dtatabase, $condition) {
        $query = $this->db->get_where($dtatabase, $condition);
        $result = $query->row();
        return $result;
    }
	function query_list(){
		$query = $this->db->query("SELECT demo_query.id,demo_query.`title`,demo_query.created_at,demo_query.`description`,AdgUserMaster.`UserFName`,AdgUserMaster.`UserLName` FROM  demo_query
JOIN AdgUserMaster ON AdgUserMaster.id = demo_query.`user_id` where demo_query.status ='1'");   

		return $query->result_array();
	}
public function select_user($field,$condition){
        $this->db->select($field);
        $query = $this->db->get_where('AdgUserMaster', $condition);
        $data['user'] = $query->result();
        return $data['user'];
    }
	public function select_all($field,$condition){
        
        $query = $this->db->get_where($field, $condition);
        $data['user'] = $query->result();
        return $data['user'];
    }
	public function master_select_all($field,$dtatabase, $condition, $order) {
        $this->db->select($field);
        $this->db->order_by($order[0], $order[1]);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result();
        return $data['user'];
    }
	public function master_insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    public function master_update($tablename, $condition, $data) {
        $this->db->where($condition);
        $this->db->update($tablename, $data);
        return 1;
    }
    public function master_num_rows($table, $condition) {
        $query1 = $this->db->get_where($table, $condition);
        return $query1->num_rows();
    }

    public function master_select_one($field, $tbl, $cnd) {
        $this->db->select($field);
        $query = $this->db->get_where($tbl, $cnd);
        return $query->row();
    }
	public function master_select_one1($field, $tbl, $cnd) {
        $this->db->select($field);
        $query = $this->db->get_where($tbl, $cnd);
        return $query->result_array();
    }
    function create_unique_slug($string, $table, $field = 'slug', $key = NULL, $value = NULL) {
        $t = & get_instance();
        $slug = url_title($string);
        $slug = strtolower($slug);
        $i = 0;
        $params = array();
        $params[$field] = $slug;

        if ($key)
            $params["$key !="] = $value;

        while ($t->db->where($params)->get($table)->num_rows()) {
            if (!preg_match('/-{1}[0-9]+$/', $slug))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);

            $params [$field] = $slug;
        }
        return $slug;
    }
    public function master_fun_get_tbl_val($dtatabase, $condition, $order) {
       
//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
	public function master_fun_get_tbl_val1($dtatabase, $condition) {
        $this->db->select('UserFName, id');
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_location($dtatabase, $condition) {
        $this->db->select('l_name, l_id');
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
	public function master_fun_get_tbl_val_1($dtatabase, $condition, $order) {
        $this->db->order_by($order[0], $order[1]);
//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
	public function master_fun_get_tbl_val_2($dtatabase, $condition, $order) {
		 $this->db->select('id,AdminName,AdminEmail,profile_pic,AdminGender,AdminMNumber');
        $this->db->order_by($order[0], $order[1]);
//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
	public function master_fun_update_UserEmail($tablename, $cid, $data) {
       $this->db->where('AdminEmail', $cid);
       $this->db->update($tablename, $data);
       return 1;
   }
	function manufacture_get_active_record(){
        $query = $this->db->query("SELECT co.*, ql.`qualification_name`,sl.`specialist_name`,al.`area_name`,ca.category_name AS catename,lo.city_name city FROM company_master AS co 
JOIN location_master lo ON lo.id=co.location
JOIN category_master ca ON ca.id=co.category
JOIN specialist_list sl ON sl.id = co.`specialist_name`
JOIN qualification_list ql ON ql.id = co.qualification_name
JOIN area_list al ON al.id = co.area
WHERE co.status='1' AND lo.status='1' AND ca.status='1'");
		$query = $this->db->get_where($dtatabase, $condition);
		
        return $query->result_array();
    }
	function manufacture_get_active_record1($dtatabase, $condition, $order){
       
		$query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
		
		
        return $query->result_array();
    }
	function manufacture_get_record($dtatabase, $condition){
        $this->db->select('Reading,id');
		$query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
		
		
        return $query->result_array();
    }
	
	function manufactures_get_active_record($condition){
        
		$query = $this->db->query("SELECT co.`id`,co.`address`,co.`category`,co.`certified`,co.`active`,co.`companyname`,co.`contectperson`,co.`email`,co.`location`,co.`logo`,co.`member_type`,co.`mobile`,co.`note`,co.`phone`,co.`pincode`,co.`srno`,co.`subcategory`,co.`weburl`, ql.`qualification_name`,sl.`specialist_name`,al.`area_name`,ca.category_name AS catename,lo.city_name city FROM company_master AS co 
JOIN location_master lo ON lo.id=co.location
JOIN category_master ca ON ca.id=co.category
JOIN specialist_list sl ON sl.id = co.`specialist_name`
JOIN qualification_list ql ON ql.id = co.qualification_name
JOIN area_list al ON al.id = co.area
WHERE co.status='1' AND lo.status='1' AND ca.status='1' and co.id='".$condition."'");     
        return $query->result_array();
    }
		function manufactures($condition){
        $query = $this->db->SELECT(" company_master.* ,location_master.*,qualification_list.* ");
		$query = $this->db->form('company_master ');
		$query = $this->db->get_where("company_master", $condition);
		$query = $this->db->join('location_master ','location_master.id = co.location','left');
		$query = $this->db->join('qualification_list ','qualification_list.id = co.qualification_name','left');
		
        return $query->result_array();
    }
    public function master_get_tbl_val_id($dtatabase, $condition, $order) {
        $this->db->order_by($order[0], $order[1]);
//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->row();
        return $data['user'];
    }	
    public function master_fun_insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
}
    public function master_fun_update($tablename, $cid, $data) {
    $this->db->where('id', $cid);
    $this->db->update($tablename, $data);
    return 1;
}
    
    public function get_server_time() {
        $query = $this->db->query("SELECT UTC_TIMESTAMP()");
        $data['user'] = $query->result_array();
        return $data['user'][0];
    }
    function get_active_record(){
        $query = $this->db->query("SELECT * FROM `shadminmaster` WHERE type='1' AND `status`='1' ORDER BY id ASC");
        return $query->result_array();
    }
	function get_active_record_Pump(){
        $query = $this->db->query("SELECT id,name,type FROM `shpump` WHERE `status`='1' ORDER BY id ASC");
        return $query->result_array();
    }
    function get_active_record1($one,$two){
       
    $query = $this->db->query("SELECT * FROM `shadminmaster` WHERE `status`='1' ORDER BY id ASC LIMIT $two,$one ");
       
        return $query->result_array();
    }
	function get_active_record_AdgUserMaster(){
       
   $this->db->select('*');
   $this->db->from('AdgAboutUs');
    $query = $this->db->get(); 
       if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_data($query){
		 $query1 = $this->db->query($query." ORDER BY id DESC");
        $data['user'] = $query1->result_array();
        return $data['user'];
	}
    function get_active_record3($query,$one,$two){
    $query = $this->db->query($query." ORDER BY id DESC  limit ". $two.",".$one);   
        return $query->result_array();
    }
    public function search_data($query)	{
		 $query1 = $this->db->query($query." ORDER BY id DESC");
        $data['user'] = $query1->result_array();
        return $data['user'];
	}
	public function search_data_reading($query)	{
		 $query1 = $this->db->query($query." ORDER BY shdailyreadingdetails.id DESC");
        $data['user'] = $query1->result_array();
        return $data['user'];
	}
	public function search_data_reading_service($query)	{
		 $query1 = $this->db->query($query." ORDER BY drd.id DESC");
        $data['user'] = $query1->result_array();
        return $data['user'];
	}public function search_data_reading_service_1($date1,$date2)	{
		 $query="SELECT drd.`DieselReading`,drd.`meterReading`,drd.`PatrolReading`,drd.`TotalAmount`,drd.`TotalCash`,drd.`TotalCredit`,drd.`TotalExpenses` FROM `shdailyreadingdetails` AS drd 
LEFT JOIN `shadminmaster` ON shadminmaster.`id` = drd.`UserId`
 JOIN shreadinghistory ON shreadinghistory.`RDRId` = drd.`id`
LEFT JOIN shpump ON shpump.`id` = shreadinghistory.`PumpId`
WHERE drd.`status`='1' ";
				 if ($date1 != NULL) {
                $query.=" and '$date1'  <= drd.created_at ";
            } if ($date2 != NULL) {
                $query.=" and drd.created_at  <= '$date2' ";
            }
        $data['user'] = $query1->result_array();
        return $data['user'];
	}
public function search_data_num($query)	{
		 $query1 = $this->db->query($query." ORDER BY id DESC");
        $data['user'] = $query1->num_rows();
        return $data['user'];
	}
	public function search_data_num1($query)	{
		 $query1 = $this->db->query($query." ORDER BY id DESC");
        $data['user'] = $query1->num_rows();
        return $data['user'];
	}
	
	
    function search_active_record3($query,$one,$two){
    $query = $this->db->query($query." ORDER BY id DESC  limit ". $two.",".$one);   
        return $query->result_array();
    }
	 function shdailyreadingdetails_search_active_record($query,$one,$two){
    $query = $this->db->query($query." ORDER BY shdailyreadingdetails.id DESC  limit ". $two.",".$one);   
        return $query->result_array();
    }
	function search_active_record_4($query,$one,$two){
    $query = $this->db->query($query." ORDER BY id DESC  limit ". $two.",".$one);   
        return $query->result_array();
    }
    function location_active_record(){
        $query = $this->db->query("SELECT * FROM `location_master` WHERE `status`='1' ORDER BY id DESC");     
        return $query->result_array();
    }
    function location_active_record1($one,$two){
       
    $query = $this->db->query("SELECT * FROM `location_master` WHERE `status`='1' ORDER BY id DESC LIMIT $two,$one ");
       
        return $query->result_array();
    }
    public function master_fun_update1($tablename,$id, $cid, $data) {
        $this->db->where($id, $cid);
        $this->db->update($tablename, $data);
        return 1;
    }
	 public function master_area_update1($tablename,$id, $cid, $data) {
        $this->db->where($id, $cid);
        $this->db->update($tablename, $data);
        return 1;
    }

	function userlist_active_record($id){
     		 $this->db->select('*');
		$this->db->from('shadminmaster');
		$this->db->where('id', $id); 
		$query = $this->db->get();
//		print_r($query->result_array());
        return $query->result_array();
		
    }
	public function get_terms($term){
    $this->db->select('*');
    $this->db->from('AdminMaster')->where('rs',$term);
     $this->db->limit(1);
        $query = $this->db->get();
        // print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
}
	
	function shdailyreadingdetails_active_record(){
		$date = date("Y-m-d");
        $query = $this->db->query("SELECT DATE_FORMAT(drd.created_at, '%d-%m-%Y') AS DATE, drd.id,drd.`DieselReading`,drd.`meterReading`,drd.`PatrolReading`,drd.`TotalAmount`,drd.`TotalCash`,drd.`TotalCredit`,drd.`TotalExpenses` FROM `shdailyreadingdetails` AS drd WHERE `status`='1' AND created_at = '$date' ORDER BY id DESC");     
        return $query->result_array();
    }
	function shdailyreadingdetails_reading_list_details(){
        $query = $this->db->query("SELECT * FROM shpump
WHERE STATUS = 1 ORDER BY id ASC ");     
        return $query->result_array();
    }
	function shdailyreadingdetails_reading_list_details_id($id,$company_id){
        $query = $this->db->query("SELECT srh.id as pid, sp.`id`,sp.`name`, srh.`Reading`,srh.`PumpId`,sp.`type` FROM `shdailyreadingdetails` AS drd LEFT JOIN `shusermaster` ON shusermaster.`id` = drd.`UserId` LEFT JOIN shreadinghistory AS srh ON srh.`RDRId` = drd.`id` LEFT JOIN shpump AS sp ON sp.`id` = srh.`PumpId` WHERE drd.`status`='1' AND drd.id = '$id' AND `sp`.company_id = $company_id ORDER BY drd.id DESC ");     
        return $query->result_array();
    }
		function shdailyreadingdetails_reading_list_details2($id){
        $query = $this->db->query("SELECT srh.id as pid, sp.`id`,sp.`name`, srh.`Reading`,sp.`type` FROM `shdailyreadingdetails` AS drd LEFT JOIN `shusermaster` ON shusermaster.`id` = drd.`UserId` LEFT JOIN shreadinghistory AS srh ON srh.`RDRId` = drd.`id` LEFT JOIN shpump AS sp ON sp.`id` = srh.`PumpId` WHERE drd.`status`='1' AND drd.id = '$id' ORDER BY drd.id DESC ");     
        return $query->result_array();
    }
	function shdailyreadingdetails_active_record_service(){
		$date = date("Y-m-d");
        $query = $this->db->query("SELECT DATE_FORMAT(drd.created_at, '%d-%m-%Y') AS DATE, drd.id,drd.`DieselReading`,drd.`meterReading`,drd.`PatrolReading`,drd.`TotalAmount`,drd.`TotalCash`,drd.`TotalCredit`,drd.`TotalExpenses` FROM `shdailyreadingdetails` AS drd WHERE `status`='1' AND created_at = '$date' ORDER BY id DESC");     
        return $query->result_array();
    }
	function shdailyreadingdetails_active_service(){
		$date = date("Y-m-d");
        $query = $this->db->query("SELECT drd.`id`,rh.`Reading`FROM `shdailyreadingdetails` AS drd
LEFT JOIN `shadminmaster` ON shadminmaster.`id` = drd.`UserId`
JOIN  shreadinghistory AS rh  ON rh.`RDRId` = drd.`id`
LEFT JOIN shpump  ON shpump.`id` = rh.`PumpId`
 WHERE drd.`status`='1' AND drd.created_at = '$date' ORDER BY drd.id DESC");     
        return $query->result_array();
    }

	function shdailyreadingdetails_active_record2($id){
		$date = date("Y-m-d");
        $query = $this->db->query("SELECT DATE_FORMAT(drd.created_at, '%d-%m-%Y') AS DATE,drd.disel_deep_reding,petrol_deep_reding, drd.id,drd.`DieselReading`,drd.`meterReading`,drd.`PatrolReading`,drd.`TotalAmount`,drd.`TotalCash`,drd.`TotalCredit`,drd.`TotalExpenses`,drd.`date`,`sh`.UserFName,`sh`.shift,`shl`.l_name FROM `shdailyreadingdetails` AS drd join shusermaster as sh on `sh`.id=`drd`.UserId join sh_location as shl on `shl`.l_id=`drd`.location_id 
WHERE drd.`status`='1' AND drd.id = '$id' ");
        return $query->result_array();
    }function shdailyreadingdetails_active_record1(){
		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y-m-d");
        $query = $this->db->query("SELECT DATE_FORMAT(drd.created_at, '%d-%m-%Y') AS DATE, drd.id,drd.`DieselReading`,drd.`meterReading`,drd.`PatrolReading`,drd.`TotalAmount`,drd.`TotalCash`,drd.`TotalCredit`,drd.`TotalExpenses` FROM `shdailyreadingdetails` AS drd
WHERE drd.`status`='1' AND drd.created_at = '$date' ORDER BY drd.id DESC ");
        return $query->result_array();
    }
	function area_active_record_qualification($one,$two){
		date_default_timezone_set('Asia/Kolkata');
		$date = date("Y-m-d");
        $query = $this->db->query("SELECT * FROM `qualification_list` WHERE `status`='1' ORDER BY id DESC LIMIT $two,$one ");
        return $query->result_array();
    }
    function subcategory_active_record(){
        $query = $this->db->query("SELECT subcategory_master.*,category_master.category_name,category_master.status FROM `subcategory_master` join `category_master` on subcategory_master.category_id=category_master.id WHERE category_master.status='1' AND subcategory_master.status='1' ORDER BY subcategory_master.id DESC");     
        return $query->result_array();
    }
    function subcategory_active_record1($one,$two){
        $query = $this->db->query("SELECT subcategory_master.*,category_master.category_name,category_master.status FROM `subcategory_master` join `category_master` on subcategory_master.category_id=category_master.id WHERE category_master.status='1' AND subcategory_master.status='1' ORDER BY subcategory_master.id DESC LIMIT $two,$one ");
        return $query->result_array();
    }
    function category_list(){

$query = $this->db->query("SELECT * FROM `category_master` WHERE `status`='1'");   
    return $query->result_array();
}
	function company_list(){

$query = $this->db->query("SELECT * FROM `shadminmaster` WHERE type = '2' AND `status`='1'");   
    return $query->result_array();
}
	function Pump_list(){
$query = $this->db->query("SELECT * FROM `shpump` WHERE  `status`='1'");   
    return $query->result_array();
}
	  function area_list(){

$query = $this->db->query("SELECT * FROM `area_list` WHERE `status`='1'");   
    return $query->result_array();
}
    function getuniq($table,$data) {
            $query = $this->db->get_where($table, $data);
            return $query->num_rows();
    }
    function getsubuniq($table,$data) {
    $this->db->select('*');
    $this->db->from('subcategory_master s');
    $this->db->join('category_master c', 'c.id=s.category_id');
    $this->db->where('c.status', 1);
    $this->db->where('s.status', 1);
    $this->db->where('s.ca', 1);
    $this->db->where('s.status', 1);
    $query = $this->db->get();
    return $query->num_rows();
    }
    function select_company($id){
        $this->db->select('cm.id,cm.email,cm.pincode,cm.phone,cm.companyname,cm.mobile,cm.address,cm.area,cm.certified,cm.note,cm.logo,cm.weburl,cm.logo,l.city_name,c.category_name,cm.contectperson,cm.member_type');
        $this->db->from("company_master cm");
        $this->db->join('`location_master` l', 'l.id=cm.location', 'left');
        $this->db->join('`category_master` c', 'c.id=cm.category', 'left');
        $this->db->where('cm.id', $id);
        $this->db->where('cm.status', '1');
        $query = $this->db->get();
        return $query->row();
        }
    function getid($table,$data) {
		$query = $this->db->get_where($table, $data);
		return $query->row()->id;
	}
	function select_reading_list($date1,$date2){
		$this->db->select(" DATE_FORMAT(drd.created_at, '%d-%m-%Y') AS DATE , drd.id,`drd`.`DieselReading`, `drd`.`meterReading`, `drd`.`PatrolReading`, `drd`.`TotalAmount`, `drd`.`TotalCash`, `drd`.`TotalCredit`, `drd`.`TotalExpenses`");
		 $this->db->from("shdailyreadingdetails drd");
		    $this->db->join('shadminmaster', 'shadminmaster.id=drd.UserId', 'left');
		    $this->db->join('`shreadinghistory` rh ', 'rh.RDRId = drd.id', 'left');
		    $this->db->join('`shpump` sp ', 'sp.id = rh.PumpId', 'left');
		 $this->db->where('drd.`status`', 1);
		if($date1 != ""){
		 $this->db->where('drd.created_at >=', $date1);
		}if($date2 != ""){
		 $this->db->where('drd.created_at <=', $date2);
		}
		$query = $this->db->get();
		 return $query->result_array();
	}
	function select_reading_list_web_count($date1,$date2,$Employeename){
		$this->db->select("count(drd.id) as total");
		 $this->db->from("shdailyreadingdetails drd");
		    $this->db->join('shusermaster', 'shusermaster.id=drd.UserId', 'left');
		   // $this->db->join('`shreadinghistory` rh ', 'rh.RDRId = drd.id', 'left');
		    //$this->db->join('`shpump` sp ', 'sp.id = rh.PumpId', 'left');
		 $this->db->where('drd.`status`', 1);
		if($date1 != ""){
		 $this->db->where('drd.created_at >=', $date1);
		}if($date2 != ""){
		 $this->db->where('drd.created_at <=', $date2);
		}
		if($Employeename != ""){
		
			$this->db->where('shusermaster.id', $Employeename);
		}
		$query = $this->db->get();
		 return $query->result_array();
	}
	function select_reading_list_web($date1,$date2,$Employeename,$two,$one){
		$this->db->select(" DATE_FORMAT(drd.created_at, '%d-%m-%Y') AS DATE , drd.id,`drd`.`DieselReading`, `drd`.`meterReading`, `drd`.`PatrolReading`, `drd`.`TotalAmount`, `drd`.`TotalCash`, `drd`.`TotalCredit`, `drd`.`TotalExpenses` ");
		 $this->db->from("shdailyreadingdetails drd");
		    $this->db->join('shadminmaster', 'shadminmaster.id=drd.UserId', 'left');
		 $this->db->where('drd.`status`', 1);
		if($date1 != ""){
		 $this->db->where('drd.created_at >=', $date1);
		}if($date2 != ""){
		 $this->db->where('drd.created_at <=', $date2);
		}
		if($Employeename != ""){
		 $this->db->where('shusermaster.id', $Employeename);
		}
		 $this->db->limit($two, $one);
		$query = $this->db->get();
		 return $query->result_array();
	}
    function getlist($table,$field) {
            $this->db->order_by($field);
            $this->db->select('*');
    		$this->db->from($table);
            $this->db->where('status', '1');
            $query = $this->db->get();
            return $query->result();
    }
	function getlist1($table,$field,$id) {
            $this->db->order_by($field);
            $this->db->select('*');
    		$this->db->from($table);
		
            $this->db->where('status', '1');
            $this->db->where('UserId',$id);
            $query = $this->db->get();
            return $query->result_array();
    }
    public function check_email1($email){ 
        $sql = "SELECT email FROM company_master WHERE email='$email' AND status ='1'";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }
    public function check_srno($email)    { 
        $sql = "SELECT email FROM company_master WHERE srno='$email' AND status ='1'";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }
    public function check_name($email)    { 
        $sql = "SELECT email FROM company_master WHERE companyname='$email' AND status ='1'";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }
    function getlistbyid($table,$field,$id) {
            $this->db->order_by($field);
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('category_id', $id);
            $this->db->where('status', '1');
            $query = $this->db->get();
            return $query->result();
    }
    function getcompanylist($cid,$field){
            $this->db->order_by("cm.member_type");
            $this->db->select('cm.id,cm.companyname,cm.mobile,cm.address,cm.area,cm.certified,cm.note,cm.weburl,cm.logo,l.city_name');
            $this->db->from("company_master cm");
            $this->db->join('`location_master` l', 'l.id=cm.location', 'left');
            $this->db->where($field, $cid);
            $this->db->where('cm.status', '1');
            $this->db->where('cm.active', '2');
            $this->db->limit(10);
            $query = $this->db->get();
            return $query->result();
    }
    function getcompanylistwithcity($cid,$field,$ctid){
            $this->db->order_by("member_type");
            $this->db->select('*');
            $this->db->from("company_master");
            $this->db->where($field, $cid);
            $this->db->where("location", $ctid);
            $this->db->where('status', '1');
            $this->db->where('active', '2');
            $this->db->limit(10);
            $query = $this->db->get();
            return $query->result();
    }
    function getcompanylistwithproduct($name){	
            $sql = "SELECT * FROM `company_master` as cm
JOIN `company_product_master` as cpm on cm.id=cpm.company_id
where cpm.product_name = '$name' And cm.status='1' limit 10";
            $result = $this->db->query($sql)->result();
            return $result;
    }
    public function next_companylist_product($name,$start,$limit){
        $sql = "SELECT * FROM `company_master` as cm
JOIN `company_product_master` as cpm on cm.id=cpm.company_id
where cpm.product_name = '$name' And cm.status='1' LIMIT $start, $limit";
        $result = $this->db->query($sql)->result();
        return $result;
    }
    public function selectbyid($table,$id,$field,$order) {
            $this->db->order_by($order);
            $this->db->from($table);
            $this->db->where($field, $id);
            $this->db->where('status', '1');
            $query = $this->db->get(); 
            return $query->result();
    }
    public function selectregadd($table) {
            $this->db->order_by('id','RANDOM');
            $this->db->from($table);
            $this->db->where('status', '1');
            $this->db->limit(2);
            $query = $this->db->get(); 
            return $query->result();
    }
public function selectbyidrowadd($table,$id,$field) {
$this->db->order_by('id','RANDOM');
    $this->db->from($table);
    $this->db->where($field, $id);
    $query = $this->db->get(); 
    return $query->row();
    }
    public function selectbyidrow($table,$id,$field) {
            $this->db->from($table);
            $this->db->where($field, $id);
            $query = $this->db->get(); 
            return $query->row();
    }
    public function gettableval($table,$field) {
            $this->db->order_by($field);
            $this->db->from($table);
            $this->db->where('status', '1');
            $query = $this->db->get(); 
            return $query->result();
    }
    function search_company($name){
            $query = $this->db->query("SELECT c.*,l.city_name FROM `company_master` c join location_master l ON l.id=c.location WHERE c.status='1' AND (c.companyname like '$name%' or c.area like '$name%')");   
            return $query->result_array();
    }
    function search_category($name){
            $query = $this->db->query("SELECT * FROM `productdetail`  WHERE status='1' and UserId='$name'  ");   
            return $query->result_array();
    }
    function search_product($name){
            $query = $this->db->query("SELECT * FROM `company_product_master`  WHERE product_name like '$name%' GROUP BY product_name");   
            return $query->result_array();
    }
    public function search_companylist($cid,$location){ 
            $sql = "SELECT * FROM company_master WHERE category='$cid' AND location IN ($location) AND status ='1' AND active ='2' ORDER BY member_type  LIMIT 0, 10";
            $result = $this->db->query($sql)->result();
            return $result;
    }
    public function search_companylist_sub($cid,$location)    { 
            $sql = "SELECT * FROM company_master WHERE subcategory='$cid' AND location IN ($location) AND status ='1' AND active ='2' ORDER BY member_type  LIMIT 0, 10";
            $result = $this->db->query($sql)->result();
            return $result;
    }
    public function next_companylist_sub($id,$field,$start,$limit,$location=null){
            $temp ="";
            if($location != ""){
                    $temp = "AND location IN ($location)";		
            }
            $sql = "SELECT * FROM company_master WHERE $field='$id' $temp AND status ='1' AND active ='2' ORDER BY member_type  LIMIT $start, $limit"; 
            $result = $this->db->query($sql)->result();
            return $result;
    }
    public function getnewcompany() {
            $this->db->order_by("id", "desc"); 
            $this->db->from("company_master");
            $this->db->where('status', '1');
            $this->db->where('active', '2');
            $this->db->limit(8);
            $query = $this->db->get(); 
            return $query->result();
    }
    public function getpopularcompany() {
            $this->db->order_by("id","RANDOM"); 
            $this->db->group_by("companyname"); 
            $this->db->from("company_master");
            $this->db->where('status', '1');
            $this->db->where('active', '2');
            $this->db->where('member_type', '1');
            $this->db->limit(8);
            $query = $this->db->get(); 
            return $query->result();
    }
    function getcompanytotal($cid,$field,$location=null){
            $this->db->order_by("companyname");
            $this->db->select('*');
            $this->db->from("company_master");
            $this->db->where($field, $cid);
            $this->db->where('status', '1');
            $this->db->where('active', '2');
            if($location != null){
            $this->db->where_in('location', $location);
            }
            $query = $this->db->get();
            return $query->num_rows();
    }
    function getcompanytotalwithcity($cid,$field,$ctid){
            $this->db->order_by("companyname");
            $this->db->select('*');
            $this->db->from("company_master");
            $this->db->where($field, $cid);
            $this->db->where("location", $ctid);
            $this->db->where('status', '1');
            $this->db->where('active', '2');
            $query = $this->db->get();
            return $query->num_rows();
    }
    function getcompanytotalwithproduct($name){
        $sql = "SELECT * FROM `company_master` as cm
JOIN `company_product_master` as cpm on cm.id=cpm.company_id
where cpm.product_name = '$name' And cm.status='1'";
        $result = $this->db->query($sql)->num_rows();
        return $result;   
    }
    function loc_name($id)    {

    $this->db->select('city_name');
    $this->db->from("location_master");
    $this->db->where('id', $id);
    $query = $this->db->get();
    return $query->result();
    }
    public function remove_data_table($tbl) {
    $this->db->truncate($tbl);
    echo "truncate";
    return 1;    
    }
    function count_active_record($tbl){
    $this->db->from($tbl);
    $this->db->where('status', '1');
    $query = $this->db->get();
    return $query->num_rows();
    }
    public function selectbyidarray($table,$id,$field) {
    $this->db->from($table);
    $this->db->where($field, $id);
    $query = $this->db->get(); 
    return $query->result();
}
    public function deletedata($table,$condiation){
    $this->db->delete($table, $condiation);
    return 1;
}
public function selectall($tbl,$field){
    $this->db->order_by($field);
    $this->db->from($tbl);
    $this->db->where('status', '1');
    $this->db->limit('7000');
    $query = $this->db->get(); 
    return $query->result();
}
}
?>