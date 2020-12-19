<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . 'libraries/swift_mailer/swift_required.php';

class Querys extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master_model');
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    
    function index() {
        if($_SESSION['logged_in'] == ""){
            redirect('login');
        }
		$data["logged_in"] = $_SESSION['logged_in']; 
        $data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
        $userid = $data["logged_in"]["id"];
        $data["query"] = $this->master_model->query_list();
        $this->load->view('header');
        $this->load->view('nav', $data);
        $this->load->view('query_view', $data);
        $this->load->view('footer');
    }

    function company_delete() {
        if($_SESSION['logged_in'] == ""){
            redirect('login');
        }
        $data["logged_in"] = $_SESSION['logged_in']; 
        $data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
        $userid = $data["logged_in"]["id"];
        $cid = $this->uri->segment('3');
        $data = array(
            "status" => '0'
        );
        //$delete=$this->admin_model->delete($cid,$data);
        $delete = $this->master_model->master_fun_update1("AdgUserMaster", 'id', $this->uri->segment('3'), $data);
        if ($delete) {
            $ses = array("Company Successfully Deleted!");
            $this->session->set_userdata('success', $ses);
            redirect('company_master/company_list', 'refresh');
        }
    }

    function company_edit() {
        if($_SESSION['logged_in'] == ""){
            redirect('login');
        }
        $data["logged_in"] = $_SESSION['logged_in']; 
        $data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
        $data["id"] = $this->uri->segment('3');
        if ($this->session->userdata('unsuccess') != null) {
            $data['unsuccess'] = $this->session->userdata("unsuccess");
            $this->session->unset_userdata('unsuccess');
        }
        $data['query'] = $this->master_model->master_get_tbl_val_id("adgusermaster", array("id" => $this->uri->segment('3')), array("id", "desc"));
        $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('contactname', 'Contact Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
        if ($this->form_validation->run() != FALSE) {
            $companyname = $this->input->post("companyname");
            $address = $this->input->post("address");
            $category = $this->input->post("category");
            $qualification_name = $this->input->post("qualification_name");
            $specialist_name = $this->input->post("specialist_name");
            $contactname = $this->input->post("contactname");
            $mobile = $this->input->post("mobile");
            $phone = $this->input->post("phone");
            $email = $this->input->post("email");
            $area = $this->input->post("area");
            $certified = $this->input->post("certified");
            $pincode = $this->input->post("pincode");
            $note = $this->input->post("message");
            $weburl = $this->input->post("website");
            $member = $this->input->post("member");
            $product = $this->input->post("mytext");
            $time = $this->master_model->get_server_time();

            $data1 = array(
                "srno" => $srno,
                "companyname" => $companyname,
                "contectperson" => $contactname,
                "mobile" => $mobile,
                "phone" => $phone,
                "email" => $email,
                "address" => $address,
				"qualification_name" => $qualification_name,				
                "specialist_name" => $specialist_name,	
                "location" => '1',
                "category" => $category,
                "subcategory" => $subcategory,
                "area" => $area,
                "certified" => $certified,
                "pincode" => $pincode,
                "note" => $note,
                "weburl" => $weburl,
                "member_type" => $member
            );
            $update = $this->master_model->master_fun_update1("company_master", 'id', $this->uri->segment('3'), $data1);


            if ($update) {
                $ses = "Company Successfully Updated!";
                $this->session->set_flashdata('success', $ses);
                redirect('company_master/view_company/'.$this->uri->segment('3'));
            }
        } else {
            
        }
        $data['country_list'] = $this->master_model->get_val("select * from demo_country where status='1'");
        if($data['query']->UserCountry != ""){
            $cntid = $data['query']->UserCountry;
            $data['state_list'] = $this->master_model->get_val("select * from demo_state where status='1' and country_fk='$cntid'");
        }
        
        $this->load->view('header');
        $this->load->view('nav', $data);
        $this->load->view('company_edit', $data);
        $this->load->view('footer');
    }
    function updategellart(){
        $id = $this->input->post("id");
        $list = $this->input->post("list");
        $data1 = array(
                    "images" => $list
                );
        $update = $this->master_model->master_fun_update1("gallery_master", 'company_id', $id, $data1);
        echo "1";
    }
    function company_gellary_edit($id) {
        
        if ($_FILES["userfile"]["name"][0] != "") {
            if ($_FILES["userfile"]["name"]) {
				$date = md5(uniqid(rand($_FILES['logo']), true));
                $this->load->library('upload');
                $files = $_FILES;
                $cpt = count($_FILES['userfile']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['userfile']['name'] =  $date.$files['userfile']['name'][$i];
                    $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                    $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
                    $_FILES['userfile']['size'] = $files['userfile']['size'][$i];
                    $this->upload->initialize($this->set_upload_options());
                    $this->upload->do_upload();
                    $fileName = str_replace(' ', '_', $_FILES['userfile']['name']);
                    $images[] = $fileName;
                }

                $image = implode(',', $images);
            }
        }
        $imglist = $this->input->post("imglist");
        if ($image == "") {
            $image = $imglist;
        } else {
            $image = $image . "," . $imglist;
        }
        $data1 = array(
                    "images" => $image
                );
        $update = $this->master_model->master_fun_update1("gallery_master", 'company_id', $id, $data1);
        //    if ($update) {
        $ses = "Company Gellary Successfully Updated!";
        $this->session->set_flashdata('success', $ses);
        redirect('company_master/view_company/'.$id);
        //}
    }
    function company_product_edit($id) {
        $productlist = $this->input->post("mytext");
        $this->master_model->deletedata("company_product_master", array('company_id' => $this->uri->segment('3')));
$product = (explode(",",$productlist));

            foreach ($product as $products) {
                if ($products != "") {
                    $data1 = array(
                        "company_id" => $this->uri->segment('3'),
                        "product_name" => $products
                    );
//echo $insert."<pre> product <br>"; print_r($data1);
                    $this->master_model->master_fun_insert('company_product_master', $data1);
                }
            }
            /*foreach ($product as $products) {
                if ($products != "") {
                    $data1 = array(
                        "company_id" => $this->uri->segment('3'),
                        "product_name" => $products
                    );
                    $this->master_model->master_fun_insert('company_product_master', $data1);
                }
            }*/
        //    if ($update) {
        $ses = "Company Product Successfully Updated!";
        $this->session->set_flashdata('success', $ses);
        redirect('company_master/view_company/'.$id);
        //}
    }
    function company_logo_edit($id) {
        
        if ($_FILES["logo"]["type"]) {
			$time_now=mktime(date('h')+5,date('i')+30,date('s'));
$date = md5(uniqid(rand($_FILES['logo']), true));
			
            $_FILES["logo"]["type"];
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] =  $date.$_FILES['logo']['name'];
            $config['file_name'] = str_replace(' ', '_', $config['file_name']);
            $_FILES['logo']['name'];
            $file1 = $config['file_name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('logo')) {
                $data['error'] = $this->upload->display_errors();
                $ses= $data['error'];
                $ses = "Company Product Successfully Updated!";
                $this->session->set_flashdata('fail', $ses);
                redirect('company_master/view_company/'.$id);
            } else {
                $file_data = $this->upload->data();
                $data1=array("logo" => $config['file_name']);
                $update = $this->master_model->master_fun_update1("productdetail", 'id', $id, $data1);
                $ses = "Company Logo Successfully Updated!";
                $this->session->set_flashdata('success', $ses);
                redirect('company_master/view_company/'.$id);
            }
            
        }else{
            $ses = "The Logo field is required.!";
            $this->session->set_flashdata('fail', $ses);
            redirect('company_master/view_company/'.$id);
        }
    }
    function view_company() {
        if($_SESSION['logged_in'] == ""){
            redirect('login');
        } 
		$id = $this->uri->segment('3');
		//print_r($id);
        $data["logged_in"] = $_SESSION['logged_in']; 
        $data["user"] = $this->user_model->getUser_all($id);
		//echo $this->db->last_query();
		// print_r($data["user"]); die();
        $this->load->view('header');
        $this->load->view('nav', $data);
        $this->load->view('customer_view', $data);
        $this->load->view('footer');
    }

    function verification($id) {
        $data1 = array(
            "active" => '2'
        );
        $query = $this->master_model->master_get_tbl_val_id("company_master", array("id" => $id), array("id", "desc"));

        $update = $this->master_model->master_fun_update1("company_master", 'id', $id, $data1);
        if ($update) {
            $message = "Thank you for verifying your email.<br>You'r Comapny now been Active.";
            $transport = Swift_SmtpTransport::newInstance('mail.website-demo.co.in', 25)
                    ->setUsername('developer@website-demo.co.in')
                    ->setPassword('web30india#');
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance('Company Activation')
                    ->setFrom(array('info@virtualheight.com' => 'Gujrat info'))
                    ->setTo(array($query->email))
                    ->setBody($message, 'text/html');
            $result = $mailer->send($message);
            redirect('manufacture');
        }
    }

    function active($id) {
//echo $id; die();
        $data1 = array(
            "active" => '1'
        );
        $query = $this->master_model->master_get_tbl_val_id("company_master", array("id" => $id), array("id", "desc"));

        $update = $this->master_model->master_fun_update1("company_master", 'id', $id, $data1);
        if ($update) {
            $message = "Dear " . ucwords($query->contectperson) . " <br> You'r Company  registration request approval please <a href='" . base_url() . "company_master/verification/" . $id . "'>click</a>here to verify your company";
            $transport = Swift_SmtpTransport::newInstance('mail.website-demo.co.in', 25)
                    ->setUsername('developer@website-demo.co.in')
                    ->setPassword('web30india#');
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance('Company Verification')
                    ->setFrom(array('info@virtualheight.com' => 'Gujrat info'))
                    ->setTo(array($query->email))
                    ->setBody($message, 'text/html');
            $result = $mailer->send($message);
            $ses = array("Company Successfully Updated!");
            $this->session->set_userdata('success', $ses);
            redirect('company_master/company_list');
        }
    }

    function company_csv() {
	if($_SESSION['logged_in'] == ""){
            redirect('login');
        }
   /*     $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "Company.csv";
        $query = "select 
    co.companyname as COMPANYNAME,
    co.address as ADDRESS,
	co.area as AREA,
    co.pincode as PINCODE,
    co.weburl as WEBURL,
    co.note as NOTE,
    ca.category_name as CATEGORYNAME,
	mt.name as MEMBER,
    co.contectperson as CONTACTPERSON,
    co.mobile as MOBILE,
    co.phone as PHONE,
    co.email as EMAIL,
    co.logo as LOGO,
    (SELECT GROUP_CONCAT(product_name) FROM company_product_master where company_id = co.id) as PRODUCT
FROM
    company_master as co
        JOIN
    category_master ca ON ca.id = co.category

        JOIN
    member_type mt ON mt.id = co.member_type
where
    co.status = '1' AND ca.status = '1'
limit 900";
//$query ="select * from csv_company";
        $result = $this->db->query($query);
//echo "<pre>"; print_r($result);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data); */



	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Company.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, array('COMPANYNAME', 'ADDRESS','AREA', 'PINCODE', 'WEBURL', 'NOTE', 'CATEGORYNAME', 'MEMBER', 'CONTACTPERSON', 'MOBILE', 'PHONE', 'EMAIL','LOGO','PRODUCT'));

	$company= $this->master_model->selectall('company_master','companyname');

	$category= $this->master_model->selectall('category_master','category_name');
	$final=array();
	foreach($company as $companys){
		foreach($category as $categorys){
			if($categorys->id == $companys->category){
				$temcategory = $categorys->category_name;	
			}
		}
	$address = $companys->address;
	if($companys->member_type == '1'){ $type= 'Silver'; }
	if($companys->member_type == '2'){ $type= 'Bronze'; }
	if($companys->member_type == '3'){ $type= 'Gold'; }
	if($companys->member_type == '4'){ $type= 'Platinum'; }
	if($companys->member_type == '5'){ $type= 'Free LIst'; }
	$data1 = Array($companys->companyname,str_replace(",","  ",$address), $companys->area, $companys->pincode, $companys->weburl, $companys->note, $temcategory, $type, $companys->contectperson, $companys->mobile, $companys->phone, $companys->email, $companys->logo, '');
		$this->getcsv($data1);
	}


    }

    function importcompany() {
        if($_SESSION['logged_in'] == ""){
            redirect('login');
        }

        if (empty($_FILES['company_file']['name'])) {
            $this->form_validation->set_rules('company_file', 'Upload', 'required');
        }
        if ($this->form_validation->run() == FALSE) {

            $_FILES["company_file"]["type"];
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'text/x-csv|csv';
            $config['file_name'] = time() . $_FILES['company_file']['name'];
            $config['file_name'] = str_replace(' ', '_', $config['file_name']);
            $_FILES['company_file']['name'];
            $file1 = $config['file_name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('company_file')) {
                $data['error'] = $this->upload->display_errors();
                $ses = array($data['error']);
                $this->session->set_userdata('successadd', $ses);
                redirect('location_master/location_list', 'refresh');
            } else {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];
                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);
                    $cnt = 0;
//echo "<pre>"; print_r($csv_array); die();	
                    foreach ($csv_array as $row) {
                        if (!empty($row['COMPANYNAME'])) {
//				echo"here"; die();							
                            $companyname = $row['COMPANYNAME'];
                            $address = $row['ADDRESS'];
                            $area = $row['AREA'];
                            $weburl = $row['WEBURL'];
                            $note = $row['NOTE'];
                        //    $location = $row['LOCATION'];
                            $category = $row['CATEGORYNAME'];
//                            $subcategory = $row['SUBCATEGORYNAME'];
                            $member = $row['MEMBER'];
                            $contactname = $row['CONTACTPERSON'];
                            $mobile = $row['MOBILE'];
                            $phone = $row['PHONE'];
                            $email = $row['EMAIL'];
                            $product = $row['PRODUCT'];
                            $logo = str_replace(' ', '_', $row['LOGO']);

                            if ($member == 'PLATINUM') {
                                $membertype = '1';
                            } else {
                                if ($member == 'DIAMOND') {
                                    $membertype = '2';
                                } else {
                                    if ($member == 'GOLD') {
                                        $membertype = '3';
                                    } else {
                                        if ($member == 'SILVER') {
                                            $membertype = '4';
                                        } else {
                                            $membertype = '5';
                                        }
                                    }
                                }
                            }
                            $name1 = "0";
                            //$email1 = $this->master_model->getuniq('company_master',array('email' => $email,'status ' => '1'));


                            if ($name1 == "0") {

                                $cateid = $this->master_model->getid('category_master', array('category_name' => $category, 'status ' => '1'));
                               // $subcateid = $this->master_model->getid('subcategory_master', array('subcategory_name' => $subcategory, 'status ' => '1'));
                               // $locid = $this->master_model->getid('location_master', array('city_name' => $location, 'status ' => '1'));

                                if ($cateid) {

                               //     if ($locid) {
//                                        if ($subcateid) {
                                            $time = $this->master_model->get_server_time();
                                            $data1 = array(
                                                "companyname" => $companyname,
                                                "address" => $address,
                                                "area" => $area,
                                                "weburl" => $weburl,
                                                "note" => $note,
                                                "location" => '1',
                                                "category" => $cateid,
//                                                "subcategory" => $subcateid,
                                                "contectperson" => $contactname,
                                                "mobile" => $mobile,
                                                "phone" => $phone,
                                                "email" => $email,
                                                "status" => "1",
                                                "logo" => $logo,
                                                "active" => "2",
                                                "member_type" => $membertype
                                            );
                                            $insert = $this->master_model->master_fun_insert('company_master', $data1);
                                            $data1 = array(
                                                "company_id" => $insert,
                                                "images" => ""
                                            );
                                            $this->master_model->master_fun_insert('gallery_master', $data1);
//echo "<pre>";
                                            if($product != ""){
                                                $productlist = explode(',', $product);
                                                //print_r($productlist); die();    
                                                ;
                                                foreach ($productlist as $products) {
                                                    
                                                    $data1 = array(
                                                        "company_id" => $insert,
                                                        "product_name" => $products
                                                    );
                                                   // print_r($data1); 
                                                    $this->master_model->master_fun_insert('company_product_master', $data1);
                                                }
//                                                die();
                                            }
                                       $data["logged_in"] = $_SESSION['logged_in']; 
                                            $data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
                                            $cnt++;
//                                        }
                                    }
                                //}
                            }
                        }
                    }
                    if ($cnt == 0) {
                        $ses = "Please check your file";
                    } else {
                        $ses = $cnt . " City Added Successfully";
                    }
                    $this->session->set_flashdata('successf', $ses);
                    redirect('company_master/company_list', 'refresh');
                } else {
                    $this->session->set_flashdata('failf', "Pleas check your file");
                    redirect('company_master/company_list', 'refresh');
                }
            }
        } else {

            $this->session->set_flashdata('failf', "Pleas Select file");
            redirect('company_master/company_list', 'refresh');
        }
    }

    function getsub() {
        $id = $this->input->post("id");
        $area = $this->master_model->selectbyid('subcategory_master', $id, 'category_id', 'subcategory_name');
        $temp = "<option value=''>Select</option>";
        foreach ($area as $areas) {
            $temp = $temp . "<option value='" . $areas->id . "'>" . $areas->subcategory_name . "</option>";
        }
        echo $temp;
    }

    function importcompanylogo() {
        $config = array();
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;

        if ($_FILES["userfile"]["name"]) {
            $this->load->library('upload');
            $files = $_FILES;
            $cpt = count($_FILES['userfile']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
                $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
                $_FILES['userfile']['size'] = $files['userfile']['size'][$i];
                $this->upload->initialize($config);
                $this->upload->do_upload();
                $fileName = str_replace(' ', '_', $_FILES['userfile']['name']);
                $images[] = $fileName;
            }
        }
        $this->session->set_flashdata('successf', $i . " Logo Upload");
        redirect('company_master/company_list', 'refresh');
    }

    function importsalon() {
        if($_SESSION['logged_in'] == ""){
            redirect('login');
        }

        if (empty($_FILES['company_file']['name'])) {
            $this->form_validation->set_rules('company_file', 'Upload', 'required');
        }
        if ($this->form_validation->run() == FALSE) {

            $_FILES["company_file"]["type"];
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'text/x-csv|csv';
            $config['file_name'] = time() . $_FILES['company_file']['name'];
            $config['file_name'] = str_replace(' ', '_', $config['file_name']);
            $_FILES['company_file']['name'];
            $file1 = $config['file_name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('company_file')) {
                $data['error'] = $this->upload->display_errors();
                $ses = array($data['error']);
                $this->session->set_userdata('successadd', $ses);
                redirect('location_master/location_list', 'refresh');
            } else {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];
                if ($this->csvimport->get_array($file_path)) {


                    $csv_array = $this->csvimport->get_array($file_path);
                    $cnt = 0;
                    $data['csv_array'] = $csv_array;
                    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" />  ';
                    phpinfo();
                    print_R($csv_array);
                    die();
                    foreach ($csv_array as $row) {
                        if (!empty($row['SalonName'])) {

                            $name = $row['SalonName'];
                            $aname = $row['SalonNameArabic'];

                            $aAddress = $row['AddressArabic'];
                            $aAddressinfo = $row['arabicaddressinfo'];
                            $adress = $row['AddressEnglish'];
                            $addressinfo = $row['AdditionalAddressInfo'];
                            $city = $row['City'];
                            $area = $row['Area'];
                            $phone = $row['Telephonenumber'];
                            $sun = $row['Sunday'];
                            $mon = $row['Monday'];
                            $tue = $row['Tuesday'];
                            $wed = $row['Wednesday'];
                            $thu = $row['Thursday'];
                            $fri = $row['Friday'];
                            $sat = $row['Saturday'];
                            $m = $row['Majirel'];
                            $i = $row['INOA'];
                            $x = $row['Xtenso'];
                            $p = $row['Pro Fiber'];


                            $data1 = array(
                                "name" => $name,
                                "aeabicaddress" => $aAddress,
                                "arabicname" => $aname,
                                "arabicaddressinfo" => $aAddressinfo,
                                "address" => $adress,
                                "address_info" => $addressinfo,
                                "city" => $city,
                                "area" => $area,
                                "phone" => $phone,
                                "majirel" => $m,
                                "inoa" => $i,
                                "xtenso" => $x,
                                "profiber" => $p,
                                "sun" => $sun,
                                "mon" => $mon,
                                "tue" => $tue,
                                "wen" => $wen,
                                "thu" => $thu,
                                "fri" => $fri,
                                "sat" => $sat
                            );


                            $insert = $this->master_model->master_fun_insert('salon', $data1);
                           $data["logged_in"] = $_SESSION['logged_in']; 
                            $data["user"] = $this->user_model->getUser($data["logged_in"]["id"]);
                            $cnt++;
                        }
                    }
                    if ($cnt == 0) {
                        $ses = "Please check your file";
                    } else {
                        $ses = $cnt . " City Added Successfully";
                    }
                    $this->session->set_flashdata('successf', $ses);
                    redirect('company_master/company_list', 'refresh');
                } else {
                    $this->session->set_flashdata('failf', "Pleas check your file");
                    redirect('company_master/company_list', 'refresh');
                }
            }
        } else {

            $this->session->set_flashdata('failf', "Pleas Select file");
            redirect('company_master/company_list', 'refresh');
        }
    }
function database_backup() {
	     
            $this->load->dbutil();

// Backup your entire database and assign it to a variable
  $prefs = array( 'format' => 'sql', // gzip, zip, txt 
                               'filename' => 'test_backup'. date('Y-m-d_H-i').'sql', 
                                                      // File name - NEEDED ONLY WITH ZIP FILES 
                                'add_drop' => TRUE,
                                                     // Whether to add DROP TABLE statements to backup file
                               'add_insert'=> TRUE,
                                                    // Whether to add INSERT data to backup file 
                               'newline' => "\n"
                                                   // Newline character used in backup file 
                              ); 
            $backup = $this->dbutil->backup($prefs);

            $this->load->helper('file');
            $path = './uploads/database/database_backup' . date('Y-m-d_H-i') . '.sql';
            $file = write_file($path, $backup);

            $data = array(
                "file_name" => $path,
                "backup_date" => date('Y-m-d'),
                "backup_time" => date('h:i:sa'),
                
            );
			redirect('home','refresh');
       
    }
function trytry(){
//$company= $this->master_model->selectall('company_master','companyname');
$category= $this->master_model->selectall('category_master','category_name');
$final=array();
print_r($category); die();
foreach($company as $companys){
	foreach($category as $categorys){
		if($categorys->id == $companys->category){
			$temcategory = $categorys->category_name;	
		}
	}
	echo $companys->address."<br>";

}

}
function csvtry(){
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Company.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, array('COMPANYNAME', 'ADDRESS','AREA', 'PINCODE', 'WEBURL', 'NOTE', 'CATEGORYNAME', 'MEMBER', 'CONTACTPERSON', 'MOBILE', 'PHONE', 'EMAIL','LOGO','PRODUCT'));

	$company= $this->master_model->selectall('company_master');
	$category= $this->master_model->selectall('category_master');
	$final=array();
	foreach($company as $companys){
		foreach($category as $categorys){
			if($categorys->id == $companys->category){
				$temcategory = $categorys->category_name;	
			}
		}
	$address = $companys->address;
	if($companys->member_type == '1'){ $type= 'Silver'; }
	if($companys->member_type == '2'){ $type= 'Bronze'; }
	if($companys->member_type == '3'){ $type= 'Gold'; }
	if($companys->member_type == '4'){ $type= 'Platinum'; }
	if($companys->member_type == '5'){ $type= 'Free LIst'; }
	$data1 = Array($companys->companyname,str_replace(",","  ",$address), $companys->area, $companys->pincode, $companys->weburl, $companys->note, $temcategory, $type, $companys->contectperson, $companys->mobile, $companys->phone, $companys->email, $companys->logo, '');
		$this->getcsv($data1);
	}

}
function getcsv($no_of_field_names) {
    $separate = '';
    foreach ($no_of_field_names as $field_name) {
        if (preg_match('/\\r|\\n|,|"/', $field_name)) {
            $field_name = '' . str_replace('', $field_name) . '';
        }
        echo $separate . $field_name;
        $separate = ',';
    }
    echo $data;
    echo "\r\n";
}
	function datatest(){
		phpinfo();
	}

}

?>
