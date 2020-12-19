<?php class Service_model extends CI_Model {

    public function __construct() {
        $this->load->database();
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
    $query = $this->db->query("SELECT demo_query.id,demo_query.title,demo_query.created_at,demo_query.description,AdgUserMaster.UserFName,AdgUserMaster.UserLName FROM  demo_query
JOIN AdgUserMaster ON AdgUserMaster.id = demo_query.user_id where demo_query.status ='1'");   

    return $query->result_array();
  }
  public function master_fun_updatforid($tablename, $cid, $data) {
    $this->db->where('id', $cid);
    $this->db->update($tablename, $data);
    return 1;
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
    public function master_fun_get_tbl_val_company_location($dtatabase, $condition, $order) {
       
        $this->db->select('*');
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_company_pump($dtatabase, $condition, $order) {
       
        $this->db->select('shpump.id,shpump.name,shpump.type,shl.l_id,shl.l_name,shpump.status');
        $this->db->join('sh_location as shl','shl.l_id = shpump.location_id','inner');
        $query = $this->db->get_where($dtatabase, $condition);
        
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_company_customer($dtatabase, $condition, $order,$location_id="") {
       
        $this->db->select('sh_userdetail.id,sh_userdetail.name,shl.l_id,shl.l_name,sh_userdetail.phone_no,sh_userdetail.cheque_no,sh_userdetail.bank_name,sh_userdetail.personal_guarantor,sh_userdetail.address,sh_userdetail.status');
        $this->db->join('sh_location as shl','shl.l_id = sh_userdetail.location_id','inner');
        if($location_id){
            $this->db->where('shl.l_id',$location_id);
        }
        $query = $this->db->get_where($dtatabase, $condition);
        
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_company_employee($dtatabase, $condition, $order,$location_id="") {
       
        $this->db->select('shusermaster.id,shusermaster.UserFName,shusermaster.UserEmail,shusermaster.UserMNumber,shusermaster.shift,shusermaster.UserPassword,shl.l_id,shl.l_name,shusermaster.status');
        $this->db->join('sh_location as shl','shl.l_id = shusermaster.l_id','inner');
        if($location_id){
            $this->db->where('shl.l_id',$location_id);
        }
        $query = $this->db->get_where($dtatabase, $condition);
        
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_company_inventory($dtatabase, $condition, $order) {
       
        $this->db->select('user.UserFName,location.l_name,sh_inventory.date,sh_inventory.pi_number,sh_inventory.p_fuelamount,sh_inventory.pv_taxamount,sh_inventory.p_paymenttype,sh_inventory.p_chequenumber,sh_inventory.p_paidamount,sh_inventory.p_quantity,sh_inventory.p_tankerreading,sh_inventory.di_number,sh_inventory.d_fuelamount,sh_inventory.dv_taxamount,sh_inventory.d_paymenttype,sh_inventory.d_chequenumber,sh_inventory.d_paidamount,sh_inventory.d_quantity,sh_inventory.d_tankerreading,sh_inventory.oil_type,sh_inventory.o_quantity,sh_inventory.oil_amount');
        
        $this->db->join('shusermaster user','user.id=sh_inventory.user_id');
        $this->db->join('sh_location location','location.l_id=user.l_id');
        // $this->db->join('sh_location as shl','shl.l_id = shusermaster.l_id','inner');
        $query = $this->db->get_where($dtatabase, $condition);
        
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_company_inventory_1($user_id="",$date_to="",$date_from="",$current_date="",$company_id="",$location_id="") {

    if($location_id != "")
    {
        $q3 = " AND si.location_id = '$location_id'";
        
    }
    else{
       $q3 = ""; 
    }
   if($user_id != "")
    {
        $q = " AND si.user_id = '$user_id'";
        
    }
    else{
       $q = ""; 
    }
    if($date_from != "")
    {
        $q1 = "AND si.date >= '$date_from'";
    }
    else{
       $q1 = " AND si.date = '$current_date'"; 
    }
    if($date_to != "")
    {
        $q2 = "AND si.date <= '$date_to'";
    }
    else{
       $q2 = " AND si.date = '$current_date'"; 
    }
    
    
    $query = $this->db->query("SELECT
    SUM(si.`oil_total_amount`) AS ostock,
    SUM(si.`d_stock`) AS dstock,
    SUM(si.`p_stock`) AS pstock,
    -- SUM(si.p_price) AS bpprice,
    -- SUM(si.d_price) AS bdprice,
    -- SUM(si.d_quantity) AS d_quantity,
    -- SUM(si.p_quantity) AS p_quantity,
    -- SUM(si.dv_taxamount) AS dv_taxamount,
    -- SUM(si.pv_taxamount) AS pv_taxamount,
    -- SUM(si.d_ev) AS d_ev,
    -- SUM(si.p_ev) AS p_ev,
    -- SUM(si.prev_d_price) AS d_new_price,
    -- SUM(si.prev_p_price) AS p_new_price,
    -- SUM(si.oil_total_amount) AS oil_total_amount,
    -- SUM(si.p_fuelamount) AS p_fuelamount,
    -- SUM(si.d_fuelamount) AS d_fuelamount,
    -- SUM(si.p_tankerreading) AS p_tankerreading,
    -- SUM(si.d_tankerreading) AS d_tankerreading,
    -- SUM(si.paidamount) AS paidamount,
    -- shusermaster.UserFName,
    -- sh_location.l_name,
    -- si.paymenttype,
    -- si.chequenumber,
    -- si.o_type,
    -- si.o_quantity,
    si.date
FROM
    sh_inventory si 
    JOIN shusermaster
            ON shusermaster.id = si.user_id
        JOIN sh_location
            ON sh_location.l_id = shusermaster.l_id
    WHERE shusermaster.company_id = '$company_id'
        AND si.status = '1' $q $q1 $q2 $q3
GROUP BY si.`date` ");
    
    // if($tdate != "")
    // {
    //     $query.= "AND m.Date <= '$tdate'";
    // }
        return $query->result();
        // return $data['user'];

    }

    public function master_fun_get_tbl_val_meter_reading_data($date,$company_id,$location_id) {
        $query = $this->db->query("SELECT
                    shdrd.*,
                    (SELECT
                        shrh.RDRId,
                        shpump.*
                    FROM
                        shreadinghistory shrh 
                    JOIN shpump
                        ON shpump.id = shrh.PumpId
                    WHERE shpump.company_id = '$company_id'
                    ORDER BY shrh.`Type` )
                FROM shdailyreadingdetails shdrd 
                JOIN shreadinghistory 
                    ON shreadinghistory.UserId = shdrd.UserId
                WHERE shdrd.location_id = '$location_id' 
                    AND shdrd.status = '1' 
                    AND shdrd.date = '$date'");
        return $query->result();
    }

    public function master_fun_get_tbl_val_company_dailyprice($user_id="",$date_to="",$date_from="",$current_date="",$company_id="",$location_id="") {

    
   if($user_id != "")
    {
        $q = " AND sd.user_id = '$user_id'";
        
    }
    else{
       $q = ""; 
    }
    if($date_from != "")
    {
        $q1 = "AND sd.date >= '$date_from'";
    }
    else{
       $q1 = " AND sd.date = '$current_date'"; 
    }
    if($date_to != "")
    {
        $q2 = "AND sd.date <= '$date_to'";
    }
    else{
       $q2 = " AND sd.date = '$current_date'"; 
    }
    
    
    $query = $this->db->query("SELECT 
  sd.`date`,sd.`pet_price`,sd.`dis_price` 
FROM
  sh_dailyprice AS sd 
  JOIN shusermaster ON shusermaster.`id`=sd.`user_id`
WHERE shusermaster.`company_id` = '$company_id'
AND sd.`status`='1'".$q.$q1.$q2); 
    
    // if($tdate != "")
    // {
    //     $query.= "AND m.Date <= '$tdate'";
    // }
        return $query->result();
        // return $data['user'];

    }

    public function master_fun_get_tbl_val_company_reading($user_id="",$date_to="",$date_from="",$company_id="",$location_id="") {

   if($location_id != "")
    {
		//echo $location_id;
        $q3 = " AND shdailyreadingdetails.location_id = '$location_id'";
        
    }
    else{
       $q3 = ""; 
    }
   if($user_id != "")
    {
        $q = " AND shdailyreadingdetails.UserId = '$user_id'";
        
    }
    else{
       $q = ""; 
    }
    if($date_from != "")
    {
        $q1 = "AND shdailyreadingdetails.date >= '$date_from'";
    }
    else{
		$date = date('Y-m-d');
       $q1 = " AND shdailyreadingdetails.date = '$date'"; 
    }
    if($date_to != "")
    {
        $q2 = "AND shdailyreadingdetails.date <= '$date_to'";
    }
    else{
		$date = date('Y-m-d');
       $q2 = " AND shdailyreadingdetails.date = '$date'"; 
    }
    
    
    $query = $this->db->query("SELECT 
  shusermaster.UserFName,
  sh_location.l_name,
  shdailyreadingdetails.date,
  shdailyreadingdetails.data,
  shdailyreadingdetails.oil_reading,
  shdailyreadingdetails.PatrolReading,
  shdailyreadingdetails.DieselReading,
  shdailyreadingdetails.meterReading,
  shdailyreadingdetails.TotalCash,
  shdailyreadingdetails.TotalCredit,
  shdailyreadingdetails.TotalExpenses,
  shdailyreadingdetails.TotalAmount,
  shdailyreadingdetails.p_total_selling,
  shdailyreadingdetails.d_selling_price,
  shdailyreadingdetails.disel_deep_reding,
  shdailyreadingdetails.petrol_deep_reding 
FROM
  shdailyreadingdetails 
  JOIN shusermaster
    ON shusermaster.id = shdailyreadingdetails.UserId 
  JOIN sh_location
    ON sh_location.l_id = shusermaster.l_id 
WHERE shusermaster.company_id = '$company_id' 
  AND shdailyreadingdetails.status = '1' ".$q.$q1.$q2.$q3); 
    
   
        return $query->result();
    }

  public function master_fun_get_tbl_val_service($dtatabase, $condition, $order) {
       $this->db->select('token,company_id,UserFName,UserEmail,UserMNumber');
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_service_1($dtatabase, $condition, $order) {
       $this->db->select('token,name,email,mobile');
//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
  function chack_master_fun_get_tbl_val($email, $password) {
        $this->db->select('*');
        $this->db->from('shadminmaster');
        $this->db->where('AdminEmail', $email);
        $this->db->where('AdminPassword', $password);
        $this->db->where('status', '1');
    ///$this->db->where('type', '2');
        $this->db->limit(1);
        $query = $this->db->get();
        // print_R($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
  public function master_fun_get_tbl_val_1($dtatabase, $condition, $order) {
        $this->db->order_by($order[0], $order[1]);
//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
  public function employee_detail($dtatabase, $condition, $order) {
     $this->db->select('id,UserFName');
        $this->db->order_by($order[0], $order[1]);
//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
  public function master_fun_get_tbl_val_2($dtatabase, $condition, $order) {
     $this->db->select('token,AdminName,AdminEmail,AdminGender,AdminMNumber');
        $this->db->order_by($order[0], $order[1]);
//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }
    public function master_fun_get_tbl_val_3($dtatabase, $condition, $order) {
         $this->db->select('token,UserFName,UserEmail,UserMNumber,l_id,company_id');
        $this->db->order_by($order[0], $order[1]);
//        $this->db->where_not_in('id', $id);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }

    public function master_fun_get_tbl_val_company($dtatabase, $condition, $order) {
         $this->db->select('token,name,email,mobile');
        $this->db->order_by($order[0], $order[1]);
        $query = $this->db->get_where($dtatabase, $condition);
        $data['user'] = $query->result_array();
        return $data['user'];
    }

  public function master_fun_update_UserEmail($tablename, $cid, $data) {
       $this->db->where('AdminEmail', $cid);
       $this->db->update($tablename, $data);
       return 1;
   }
   public function master_fun_update_UserEmail1($tablename, $cid, $data) {
       $this->db->where('UserEmail', $cid);
       $this->db->update($tablename, $data);
       return 1;
   }
   public function master_fun_update_companyEmail($tablename, $cid, $data) {
       $this->db->where('email', $cid);
       $this->db->update($tablename, $data);
       return 1;
   }

  function manufacture_get_active_record(){
        $query = $this->db->query("SELECT co.*, ql.qualification_name,sl.specialist_name,al.area_name,ca.category_name AS catename,lo.city_name city FROM company_master AS co 
JOIN location_master lo ON lo.id=co.location
JOIN category_master ca ON ca.id=co.category
JOIN specialist_list sl ON sl.id = co.specialist_name
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
        
    $query = $this->db->query("SELECT co.id,co.address,co.category,co.certified,co.active,co.companyname,co.contectperson,co.email,co.location,co.logo,co.member_type,co.mobile,co.note,co.phone,co.pincode,co.srno,co.subcategory,co.weburl, ql.qualification_name,sl.specialist_name,al.area_name,ca.category_name AS catename,lo.city_name city FROM company_master AS co 
JOIN location_master lo ON lo.id=co.location
JOIN category_master ca ON ca.id=co.category
JOIN specialist_list sl ON sl.id = co.specialist_name
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
    $this->db->where('token', $cid);
    $this->db->update($tablename, $data);
    return 1;
}
public function master_fun_update_location($tablename, $cid, $data) {
    $this->db->where('l_id', $cid);
    $this->db->update($tablename, $data);
    return 1;
}
public function master_fun_update_customer($tablename, $cid, $data) {
    $this->db->where('id', $cid);
    $this->db->update($tablename, $data);
    return 1;
}
public function master_fun_update_employee($tablename, $cid, $data) {
    $this->db->where('id', $cid);
    $this->db->update($tablename, $data);
    return 1;
}
 public function master_fun_updateid($tablename, $cid, $data) {
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
        $query = $this->db->query("SELECT * FROM shadminmaster WHERE type='1' AND status='1' ORDER BY id ASC");
        return $query->result_array();
    }
  function get_active_record_Pump(){
        $query = $this->db->query("SELECT id,name,type FROM shpump WHERE status='1' ORDER BY id ASC");
        return $query->result_array();
    }
    function get_active_record1($one,$two){
       
    $query = $this->db->query("SELECT * FROM shadminmaster WHERE status='1' ORDER BY id ASC LIMIT $two,$one ");
       
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
    public function search_data($query) {
     $query1 = $this->db->query($query." ORDER BY id DESC");
        $data['user'] = $query1->result_array();
        return $data['user'];
  }
  public function search_data_reading($query) {
     $query1 = $this->db->query($query." ORDER BY shdailyreadingdetails.id DESC");
        $data['user'] = $query1->result_array();
        return $data['user'];
  }
  public function search_data_reading_service($query) {
     $query1 = $this->db->query($query." ORDER BY drd.id DESC");
        $data['user'] = $query1->result_array();
        return $data['user'];
  }public function search_data_reading_service_1($date1,$date2) {
     $query="SELECT drd.DieselReading,drd.meterReading,drd.PatrolReading,drd.TotalAmount,drd.TotalCash,drd.TotalCredit,drd.TotalExpenses FROM shdailyreadingdetails AS drd 
LEFT JOIN shadminmaster ON shadminmaster.id = drd.UserId
 JOIN shreadinghistory ON shreadinghistory.RDRId = drd.id
LEFT JOIN shpump ON shpump.id = shreadinghistory.PumpId
WHERE drd.status='1' ";
         if ($date1 != NULL) {
                $query.=" and '$date1'  <= drd.created_at ";
            } if ($date2 != NULL) {
                $query.=" and drd.created_at  <= '$date2' ";
            }
        $data['user'] = $query1->result_array();
        return $data['user'];
  }
public function search_data_num($query) {
     $query1 = $this->db->query($query." ORDER BY id DESC");
        $data['user'] = $query1->num_rows();
        return $data['user'];
  }
  public function search_data_num1($query)  {
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
        $query = $this->db->query("SELECT * FROM location_master WHERE status='1' ORDER BY id DESC");     
        return $query->result_array();
    }
    function location_active_record1($one,$two){
       
    $query = $this->db->query("SELECT * FROM location_master WHERE status='1' ORDER BY id DESC LIMIT $two,$one ");
       
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
    function category_active_record(){
        $query = $this->db->query("SELECT * FROM AdgAboutus WHERE status='1' ORDER BY id DESC");     
        return $query->result_array();
    }
  function AdgBanner_active_record(){
        $query = $this->db->query("SELECT * FROM AdgBanner WHERE status='1' ORDER BY id DESC");     
        return $query->result_array();
    }
  function AdgAboutUs_active_record(){
        $query = $this->db->query("SELECT * FROM AdgAboutUs");   
//    print_r($query->result_array());
        return $query->result_array();
    
    }
  function userlist_active_record($id){
         $this->db->select('*');
    $this->db->from('shusermaster');
    $this->db->where('token', $id); 
    $query = $this->db->get();
//    print_r($query->result_array());
        return $query->result_array();
    
    }
    function companylist_active_record($id){
         $this->db->select('*');
    $this->db->from('sh_com_registration');
    $this->db->where('token', $id); 
    $query = $this->db->get();
//    print_r($query->result_array());
        return $query->result_array();
    
    }
    function userlist_active_record_1($id){
             $this->db->select('*');
        $this->db->from('shusermaster');
        $this->db->where('id', $id); 
        $query = $this->db->get();
//      print_r($query->result_array());
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
  function qualification_active_record(){
        $query = $this->db->query("SELECT * FROM qualification_list WHERE status='1' ORDER BY id DESC");     
        return $query->result_array();
    }
  function shdailyreadingdetails_active_record(){
    $date = date("Y-m-d");
        $query = $this->db->query("SELECT * FROM shdailyreadingdetails WHERE status='1' AND created_at = '$date' ORDER BY id DESC");     
        return $query->result_array();
    }
  function shdailyreadingdetails_active_record_service(){
    $date = date("Y-m-d");
        $query = $this->db->query("SELECT DATE_FORMAT(drd.created_at, '%d-%m-%Y') AS DATE, drd.id,drd.DieselReading,drd.meterReading,drd.PatrolReading,drd.TotalAmount,drd.TotalCash,drd.TotalCredit,drd.TotalExpenses FROM shdailyreadingdetails AS drd WHERE status='1' AND created_at = '$date' ORDER BY id DESC");     
        return $query->result_array();
    }
  function shdailyreadingdetails_active_service(){
    $date = date("Y-m-d");
        $query = $this->db->query("SELECT drd.id,rh.ReadingFROM shdailyreadingdetails AS drd
LEFT JOIN shadminmaster ON shadminmaster.id = drd.UserId
JOIN  shreadinghistory AS rh  ON rh.RDRId = drd.id
LEFT JOIN shpump  ON shpump.id = rh.PumpId
 WHERE drd.status='1' AND drd.created_at = '$date' ORDER BY drd.id DESC");     
        return $query->result_array();
    }
  function contact_us_active_record(){
        $query = $this->db->query("SELECT * FROM contact_us WHERE status='1' ORDER BY id DESC");     
        return $query->result_array();
    }
  function contact_us_active_record1($one,$two){
        $query = $this->db->query("SELECT * FROM contact_us WHERE status='1' ORDER BY id DESC LIMIT $two,$one ");
        return $query->result_array();
    }
  function specialist_active_record(){
        $query = $this->db->query("SELECT * FROM specialist_list WHERE status='1' ORDER BY id DESC");     
        return $query->result_array();
    }
    function category_active_record1($one,$two){
        $query = $this->db->query("SELECT * FROM AdgAboutus WHERE status='1' ORDER BY id DESC LIMIT $two,$one ");
        return $query->result_array();
    }
  function AdgBanner_active_record1($one,$two){
        $query = $this->db->query("SELECT * FROM AdgBanner WHERE status='1' ORDER BY id DESC LIMIT $two,$one ");
        return $query->result_array();
    }
  
  function specialist_active_record1($one,$two){
        $query = $this->db->query("SELECT * FROM specialist_list WHERE status='1' ORDER BY id DESC LIMIT $two,$one ");
        return $query->result_array();
    }
  function shdailyreadingdetails_active_record1($one,$two){
    $date = date("Y-m-d");
        $query = $this->db->query("SELECT * FROM shdailyreadingdetails 
LEFT JOIN shadminmaster ON shadminmaster.id = shdailyreadingdetails.UserId
LEFT JOIN shreadinghistory ON shreadinghistory.RDRId = shdailyreadingdetails.id
LEFT JOIN shpump ON shpump.id = shreadinghistory.PumpId
WHERE shdailyreadingdetails.status='1' AND shdailyreadingdetails.created_at = '$date' ORDER BY shdailyreadingdetails.id DESC LIMIT $two,$one ");
        return $query->result_array();
    }
  function area_active_record_qualification($one,$two){
    $date = date("Y-m-d");
        $query = $this->db->query("SELECT * FROM qualification_list WHERE status='1' ORDER BY id DESC LIMIT $two,$one ");
        return $query->result_array();
    }
    function subcategory_active_record(){
        $query = $this->db->query("SELECT subcategory_master.*,category_master.category_name,category_master.status FROM subcategory_master join category_master on subcategory_master.category_id=category_master.id WHERE category_master.status='1' AND subcategory_master.status='1' ORDER BY subcategory_master.id DESC");     
        return $query->result_array();
    }
    function subcategory_active_record1($one,$two){
        $query = $this->db->query("SELECT subcategory_master.*,category_master.category_name,category_master.status FROM subcategory_master join category_master on subcategory_master.category_id=category_master.id WHERE category_master.status='1' AND subcategory_master.status='1' ORDER BY subcategory_master.id DESC LIMIT $two,$one ");
        return $query->result_array();
    }
    function category_list(){

$query = $this->db->query("SELECT * FROM category_master WHERE status='1'");   
    return $query->result_array();
}
  function company_list(){

$query = $this->db->query("SELECT * FROM shadminmaster WHERE type = '2' AND status='1'");   
    return $query->result_array();
}
  function Pump_list(){
$query = $this->db->query("SELECT * FROM shpump WHERE  status='1'");   
    return $query->result_array();
}
    function area_list(){

$query = $this->db->query("SELECT * FROM area_list WHERE status='1'");   
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
        $this->db->join('location_master l', 'l.id=cm.location', 'left');
        $this->db->join('category_master c', 'c.id=cm.category', 'left');
        $this->db->where('cm.id', $id);
        $this->db->where('cm.status', '1');
        $query = $this->db->get();
        return $query->row();
        }
    function getid($table,$data) {
    $query = $this->db->get_where($table, $data);
    return $query->row()->id;
  }
  function select_reading_list($date1,$date2,$Employeename){
    $this->db->select(" DATE_FORMAT(drd.created_at, '%d-%m-%Y') AS DATE , drd.id,drd.DieselReading, drd.meterReading, drd.PatrolReading, drd.TotalAmount, drd.TotalCash, drd.TotalCredit, drd.TotalExpenses");
     $this->db->from("shdailyreadingdetails drd");
        $this->db->join('shadminmaster', 'shadminmaster.id=drd.UserId', 'left');
        $this->db->join('shreadinghistory rh ', 'rh.RDRId = drd.id', 'left');
        $this->db->join('shpump sp ', 'sp.id = rh.PumpId', 'left');
     $this->db->where('drd.status', 1);
    if($date1 != ""){
     $this->db->where('drd.created_at >=', $date1);
    }if($date2 != ""){
     $this->db->where('drd.created_at <=', $date2);
    }
    if($Employeename != ""){
     $this->db->where('shadminmaster.id', $Employeename);
    }
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
            $this->db->join('location_master l', 'l.id=cm.location', 'left');
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
            $sql = "SELECT * FROM company_master as cm
JOIN company_product_master as cpm on cm.id=cpm.company_id
where cpm.product_name = '$name' And cm.status='1' limit 10";
            $result = $this->db->query($sql)->result();
            return $result;
    }
    public function next_companylist_product($name,$start,$limit){
        $sql = "SELECT * FROM company_master as cm
JOIN company_product_master as cpm on cm.id=cpm.company_id
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
            $query = $this->db->query("SELECT c.*,l.city_name FROM company_master c join location_master l ON l.id=c.location WHERE c.status='1' AND (c.companyname like '$name%' or c.area like '$name%')");   
            return $query->result_array();
    }
    function search_category($name){
            $query = $this->db->query("SELECT * FROM productdetail  WHERE status='1' and UserId='$name'  ");   
            return $query->result_array();
    }
    function search_product($name){
            $query = $this->db->query("SELECT * FROM company_product_master  WHERE product_name like '$name%' GROUP BY product_name");   
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
        $sql = "SELECT * FROM company_master as cm
JOIN company_product_master as cpm on cm.id=cpm.company_id
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
	$this->db->where('status','1');
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
/////////////////////////////////////////////////vishal 11-4 strat
function get_pump_list($type,$location){
        $query = $this->db->query("SELECT id,name,type,p_qty as packet_value,packet_value as p_price,p_type as packet_type,packet_type as description FROM shpump WHERE status='1' and type='$type' and location_id='$location' ORDER BY name ASC");
        return $query->result_array();
    }
  function oil_type_list(){
    $query = $this->db->query("SELECT * FROM shoil_type WHERE status='1' ORDER BY name ASC");
        return $query->result_array();
  }
  function expensein_type_list(){
    $query = $this->db->query("SELECT * FROM shexpensein WHERE status='1' ORDER BY id ASC");
        return $query->result_array();
  }
////////////////////////////////////////////////vishal 11-4 end
    
    function get_user_list($id="",$lid=""){
		$cnd = "";
		if($id != ""){
			$cnd = " and company_id = '$id' ";
		}
		if($id != ""){
			$cnd = " and location_id = '$lid' ";
		}
        $query = $this->db->query("SELECT * FROM sh_userdetail WHERE status='1' $cnd ORDER BY name ASC");
        return $query->result_array();
    }
// pranjal works start 26/4/18
    public function master_fun_get_tbl_val_company_expense($user_id="",$date_to="",$date_from="",$current_date="",$company_id="",$location_id) {
    
      if($location_id != "")
    {
        $q3 = " AND sh_expensein_details.location_id = '$location_id'";
        
    }
    else{
       $q3 = ""; 
    }
   if($user_id != "")
    {
        $q = " AND sh_expensein_details.user_id = '$user_id'";
        
    }
    else{
       $q = ""; 
    }
    if($date_from != "")
    {
        $q1 = "AND sh_expensein_details.date >= '$date_from'";
    }
    else{
       $q1 = " AND sh_expensein_details.date = '$current_date'"; 
    }
    if($date_to != "")
    {
        $q2 = "AND sh_expensein_details.date <= '$date_to'";
    }
    else{
       $q2 = " AND sh_expensein_details.date = '$current_date'"; 
    }
    $query = $this->db->query("SELECT
               sh_expensein_details.user_id,sh_expensein_details.all_data,sh_expensein_details.date,shusermaster.UserFName,sh_location.l_name,
               (SELECT
                 SUM(sh_expensein_d_history.value)
                FROM
                 sh_expensein_d_history
               WHERE sh_expensein_d_history.ex_id = sh_expensein_details.id) AS total
                FROM
               sh_expensein_details  
                JOIN shusermaster
                  ON shusermaster.id = sh_expensein_details.user_id 
                JOIN sh_location
                  ON sh_location.l_id = shusermaster.l_id 
                WHERE shusermaster.company_id = '$company_id' 
                AND sh_expensein_details.status = '1' ".$q.$q1.$q2.$q3); 
                 
            return $query->result();
    }

    public function master_fun_get_tbl_val_expense_detail($company_id,$ex_id="") {

    
  $query = $this->db->query("SELECT sh_expensein_types.id as type_id,shexpensein.id as exp_id,sh_expensein_d_history.id,sh_expensein_d_history.value,sh_expensein_d_history.comment,shexpensein.name,sh_expensein_types.exps_name FROM sh_expensein_details
JOIN sh_expensein_d_history ON sh_expensein_d_history.ex_id = sh_expensein_details.id
JOIN sh_expensein_types ON sh_expensein_types.exps_id = sh_expensein_d_history.expensein_id
JOIN shexpensein ON shexpensein.id = sh_expensein_types.exps_id WHERE sh_expensein_details.id='$ex_id'  "); 
    
   
        return $query->result();
    }

  public function master_fun_get_tbl_val_company_bankdeposit($user_id="",$date_to="",$date_from="",$current_date="",$company_id="",$location_id) {

    if($location_id != "")
    {
        $q3 = " AND sb.location_id = '$location_id'";
        
    }
    else{
       $q3 = ""; 
    }
   if($user_id != "")
    {
        $q = " AND sb.user_id = '$user_id'";
        
    }
    else{
       $q = ""; 
    }
    if($date_from != "")
    {
        $q1 = "AND sb.date >= '$date_from'";
    }
    else{
       $q1 = " AND sb.date = '$current_date'"; 
    }
    if($date_to != "")
    {
        $q2 = "AND sb.date <= '$date_to'";
    }
    else{
       $q2 = " AND sb.date = '$current_date'"; 
    }

  $query = $this->db->query("SELECT 
  sh.UserFName,
  shl.l_name,
  sb.date,
  sb.deposit_amount,
  sb.withdraw_amount,
  sb.deposited_by,
  sb.cheque_no 
FROM
  sh_bankdeposit AS sb 
  JOIN shusermaster AS sh 
    ON sh.id = sb.user_id 
  JOIN sh_location AS shl 
    ON shl.l_id = sh.l_id 
WHERE sh.company_id = '$company_id' 
  AND sb.status = '1'".$q.$q1.$q2.$q3); 
    
   
        return $query->result();
    }

    public function master_fun_get_tbl_val_company_onlinetrans($user_id="",$date_to="",$date_from="",$current_date="",$company_id="",$location_id) {

    if($location_id != "")
    {
        $q3 = " AND so.location_id = '$location_id'";
        
    }
    else{
       $q3 = ""; 
    }
   if($user_id != "")
    {
        $q = " AND so.user_id = '$user_id'";
        
    }
    else{
       $q = ""; 
    }
    if($date_from != "")
    {
        $q1 = "AND so.date >= '$date_from'";
    }
    else{
       $q1 = " AND so.date = '$current_date'"; 
    }
    if($date_to != "")
    {
        $q2 = "AND so.date <= '$date_to'";
    }
    else{
       $q2 = " AND so.date = '$current_date'"; 
    }

  $query = $this->db->query("SELECT 
  sh.UserFName,
  shl.l_name,
  so.date,
  so.invoice_no,
  so.customer_name,
  so.amount,
  so.paid_by,
  so.cheque_tras_no
FROM
  sh_onlinetransaction AS so 
  JOIN shusermaster AS sh 
    ON sh.id = so.user_id 
  JOIN sh_location AS shl 
    ON shl.l_id = sh.l_id 
WHERE sh.company_id = '$company_id' 
  AND so.status = '1'".$q.$q1.$q2.$q3); 
    
   
        return $query->result();
    }

    public function master_fun_get_tbl_val_company_credit_debit($user_id="",$date_to="",$date_from="",$current_date="",$company_id="",$location_id) {

    if($location_id != "")
    {
        $q3 = " AND scd.location_id = '$location_id'";
        
    }
    else{
       $q3 = ""; 
    }
   if($user_id != "")
    {
        $q = " AND scd.user_id = '$user_id'";
        
    }
    else{
       $q = ""; 
    }
    if($date_from != "")
    {
        $q1 = "AND scd.date >= '$date_from'";
    }
    else{
       $q1 = " AND scd.date = '$current_date'"; 
    }
    if($date_to != "")
    {
        $q2 = "AND scd.date <= '$date_to'";
    }
    else{
       $q2 = " AND scd.date = '$current_date'"; 
    }

  $query = $this->db->query("SELECT 
  sh.UserFName,
  shl.l_name,
  shu.name,
  scd.date,
  scd.payment_type,
  
  scd.bill_no,
  scd.vehicle_no,
  scd.fuel_type,
  scd.amount,
  scd.quantity
  
FROM
  sh_credit_debit AS scd 
  JOIN shusermaster AS sh 
    ON sh.id = scd.user_id 
  JOIN sh_location AS shl 
    ON shl.l_id = sh.l_id
  left JOIN sh_userdetail AS shu 
   ON shu.id = scd.customer_id 
WHERE sh.company_id = '$company_id' 
  AND scd.status = '1'".$q.$q1.$q2.$q3); 
    
   
        return $query->result();
    }

    public function company_user_detail($company_id="") 
    {
      $query = $this->db->query("SELECT sh.id,sh.name,sh.email,sh.mobile FROM sh_com_registration as sh WHERE id='$company_id'"); 
      return $query->result();
    }
	public function company_worker_list($company_id="",$location_id="") 
    {
        $query = "SELECT 
                sh_workers.*,sh_location.`l_name`
            FROM
                `sh_workers` 
            JOIN sh_location ON sh_location.`l_id`=sh_workers.`location_id`
            WHERE sh_workers.company_id = '$company_id' ";
        if($location_id){
            $query .= "AND sh_workers.location_id = '$location_id'";
        }
        $query .= "AND sh_workers.status = 1 ORDER BY sh_workers.`name` ASC "; 
        $q = $this->db->query($query);
      return $q->result();
    }
	public function emp_worker_list($company_id="") 
    {
      $query = $this->db->query("SELECT 
            sh_workers.*,sh_location.`l_name` 
            FROM
            `sh_workers` 
            JOIN sh_location ON sh_location.`l_id`=sh_workers.`location_id`
            WHERE sh_workers.location_id = '$company_id' 
            AND sh_workers.status = 1 ORDER BY sh_workers.`name` ASC "); 
      return $query->result();
    }
	public function company_creditors_list($company_id="",$location_id="") 
    {
        $query = "SELECT 
                sh_creditors.*,sh_location.`l_name` 
                FROM
                `sh_creditors` 
                JOIN sh_location ON sh_location.`l_id`=sh_creditors.`location_id`
                WHERE sh_creditors.company_id = '$company_id'";
        if($location_id != ""){
            $query .= "AND sh_location.l_id = '$location_id'";
        }
        $query .= "AND sh_creditors.status = 1 ORDER BY sh_creditors.`name` ASC "; 
        $q = $this->db->query($query);
        return $q->result();
    }
	public function worker_salary_remening($worker_id,$month,$year){
		$query = $this->db->query("SELECT IFNULL(extra_salary,0) as extra_salary,salary,IFNULL(( SELECT SUM(amount) FROM sh_workers_salary WHERE  STATUS='1' AND MONTH(DATE) = '$month' AND YEAR(DATE) ='$year' AND sh_workers_salary.`worker_id` = sh_workers .id ),0) totaldebit  FROM sh_workers WHERE  id='$worker_id'"); 
      return $query->row();
	}
	public function inventory_detail_for_add($locationid,$date,$fule){
		$query = $this->db->query("SELECT oil_total_amount,IFNULL(o_stock,0) AS o_stock,d_stock,p_stock,p_new_price as p_price,d_new_price as d_price,d_quantity,p_quantity FROM `sh_inventory` WHERE `location_id` = '$locationid' AND `date` = '$date' And fuel_type ='$fule' AND `status` = '1'"); 
      return $query->row();
	}
	public function sels_detail_for_add($locationid,$date){
		$query = $this->db->query("SELECT oil_reading,p_total_selling as p_tank_reading,d_total_selling as d_tank_reading FROM `shdailyreadingdetails` WHERE `location_id` = '$locationid' AND `date` = '$date' AND `status` = '1'"); 
      return $query->row();
	}
	public function total_salary($company_id){
		$query = $this->db->query("SELECT SUM(sw.salary) AS totalsalary FROM sh_workers sw 
WHERE sw.status='1'
AND sw.company_id='$company_id'"); 
      return $query->row();
	}
	public function total_paid_salary($company_id,$mont,$year){
		$query = $this->db->query("SELECT SUM(sws.amount) AS totalpaidsalary FROM sh_workers_salary sws 
JOIN sh_workers sw ON sw.id = sws.worker_id
WHERE sw.status ='1' AND  sws.status ='1' AND sw.company_id='$company_id' AND  MONTH(sws.date) = '$mont' AND YEAR(sws.date) ='$year'"); 
      return $query->row();
	}
	public function total_credit($company_id,$mont,$year,$type){
		$query = $this->db->query("SELECT SUM(sws.amount) AS total FROM sh_credit_debit sws 
WHERE  sws.status ='1' AND sws.location_id='$company_id' AND  MONTH(sws.date) = '$mont' AND YEAR(sws.date) ='$year' AND sws.payment_type ='$type' "); 
      return $query->row();
	}
	public function total_onlinetransaction($company_id,$mont,$year){
		$query = $this->db->query("SELECT SUM(sws.amount) AS total FROM sh_onlinetransaction sws WHERE  sws.status ='1' AND sws.location_id='$company_id' AND  MONTH(sws.date) = '$mont' AND YEAR(sws.date) ='$year' "); 
      return $query->row();
	}
	public function total_bankdeposit($company_id,$mont,$year){
		$query = $this->db->query("SELECT SUM(sws.deposit_amount) AS deposit_amount,SUM(sws.withdraw_amount) AS withdraw_amount FROM sh_bankdeposit sws WHERE  sws.status ='1' AND sws.location_id='$company_id' AND  MONTH(sws.date) = '$mont' AND YEAR(sws.date) ='$year' "); 
      return $query->row();
	}
	function get_inventory_detail($type,$location,$date){
        $query = $this->db->query("SELECT id FROM sh_inventory WHERE status='1' and fuel_type='$type' and location_id='$location' and date= '$date'");
        return $query->row();
    }
    function get_oil_pckg_list($id,$location_id=""){
        $this->db->select('shr.*,shl.l_name');
        $this->db->from('shpump as shr');
        $this->db->join('sh_location as shl','shl.l_id = shr.location_id', 'inner');
        $this->db->where("shr.Type","O");
        $this->db->where("shr.company_id",$id);
        if($location_id){
            $this->db->where("shr.location_id",$location_id);
        }
		$this->db->where("shr.status",1);
        $query = $this->db->get();
        return $query->result();
    }
    function add_oil_pckg($data){
        $this->db->insert('shpump', $data);
        return $this->db->insert_id();
    }
    function update_oil_pckg($id,$data){
        $this->db->where('id', $id);
        $this->db->update('shpump', $data);
        return 1;
    }
}
?>