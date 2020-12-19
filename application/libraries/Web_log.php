<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Web_log {

    public function __construct() {
        $this->CI =& get_instance(); 
    }
    
    public function Add_data($rid = null){
		$this->CI->load->model("service_model_1");
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $page = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
        if (!empty($_SERVER['QUERY_STRING'])) {
            $page = $_SERVER['QUERY_STRING'];
        } else {
            $page = "";
        }
        if (!empty($_POST)) {
            $user_post_data = $_POST;
        } else {
            $user_post_data = array();
        }
        $user_post_data = json_encode($user_post_data);
		$sessiondata = json_encode($this->CI->session->all_userdata());
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $remotehost = @getHostByAddr($ipaddress);
        $user_info = json_encode(array("Ip" => $ipaddress, "Page" => $page, "UserAgent" => $useragent, "RemoteHost" => $remotehost));
        $user_track_data = array("url" => $actual_link, "user_details" => $user_info, "data" => $user_post_data, "createddate" => date("Y-m-d H:i:s"),"sessiondata"=>$sessiondata,"type"=>"Web");
        //print_R($user_track_data);
        $app_info = $this->CI->service_model_1->master_insert("alldata", $user_track_data);
    }
}
