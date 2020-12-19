<?php

class Dip_chart extends CI_Controller {
function __construct() {
	parent::__construct();
	if ($this->session->userdata('logged_company')) {
		$this->load->model('user_login');
		if($this->session->userdata('logged_company')['type'] == 'c'){
			$sesid = $this->session->userdata('logged_company')['id'];
			$this->data['all_location_list'] = $this->user_login->get_all_location($sesid);
			$this->data['user_permission_list'] = $this->user_login->getAllPermission();
		}else{
			$sesid = $this->session->userdata('logged_company')['u_id'];
			$this->data['all_location_list'] = $this->user_login->get_location($sesid);
			$this->data['user_permission_list'] = $this->user_login->getUserPermission($sesid);
		}
		$this->load->library('Web_log');
		$p = new Web_log;
		$this->allper = $p->Add_data();
	}
}
    function index() {
	$this->load->model('tank_dia_modal');
	$finalarray = array();
	$data["id"] = $this->uri->segment('3');
	$this->form_validation->set_rules('dia', 'dia', 'required');
	$this->form_validation->set_rules('dchange', 'dchange','required');
	$this->form_validation->set_rules('length', 'length', 'required');
	$this->form_validation->set_rules('dchangeend', 'dchangeend', 'required');
		$data["logged_company"] = $_SESSION['logged_company'];
	//date_default_timezone_set('Asia/Kolkata');
	if ($this->form_validation->run() == true) {
		
		
	//if ($this->input->get('dia')) {
	$c_id = $_SESSION['logged_company']['id'];
	$data['dia'] = $dia = $this->input->post('dia');
	$data['dchange'] = $dchange = $this->input->post('dchange');
	
	
	$data['length'] = $length = $this->input->post('length'); 
	$data['dchangeend'] = $dchangeend = $this->input->post('dchangeend'); 
	$data['Preview'] = $Preview = $this->input->post('Preview'); 
	$save = $this->input->post('save'); 
	
	$delete_data = array('deleted_at'=>date('Y-m-d H:i:s'),'deleted_flag'=>'Y');
	$where = array('tank_id'=>$data["id"],'deleted_flag'=>'N');
	
	$delete_data_old = array('deleted_on'=>date('Y-m-d H:i:s'),'status'=>'0');
	$where_old = array('tank_id'=>$data["id"],'status'=>'1');
	if($save){
		$this->tank_dia_modal->update('tank_dia_chart_main',$delete_data,$where); 
		$this->tank_dia_modal->update('sh_tank_chart',$delete_data_old,$where_old); 
	}
	
	$main_data = array('tank_id'=>$data["id"],
						'dia'=>$dia,
						'length'=>$length,
						'dip_change_start'=>$dchange,
						'dip_change_end'=>$dchangeend,
	);
	 	$main_insert_id = "";
		if($save){
		$main_insert_id = $this->tank_dia_modal->insert('tank_dia_chart_main',$main_data); 
		}
	$r = $dia/2;
	$h = "";
	$h1 = "";
	$tablearray = array();
	$totallength = $dchangeend - $dchange;
	for($i = 0; $i<=$totallength; $i++){
		/*if($h == ""){
			$h = $dchange;
				echo $h . 'if'; 
		}else{		
			$h = $dchange + 1;
				echo $h . 'else'; 
		}
		*/
	
		
		/*for($j1 = 0; $j1 <= 3; $j1++){
			echo $j1;
		}*/
	
	//$insert_data = array();
	$h = $i;
			for($j = 0; $j <= 4; $j++){
				
				
			$newh = "";
			$qty = "";
			
			
			if($h1 == ""){
				$h1 = $dchange;
			}else{ 
				$h1 = $h1 + 0.2;
			}
			
			
			
			$newh =  $r - $h1; 
			
			$qty = $this->calculatedata($newh,$dia,$dchange,$length);
			
			$tablearray[] = $qty; 
			
								
			$insert_data = array('tank_id'=>$data["id"],
								'chart_main_id'=>$main_insert_id,
								'reading'=>number_format($h,1),
								'volume'=>$qty,
								'created_on'=>date('Y-m-d H:i:s')
								);
			
			
			if($save){
				$insert = $this->tank_dia_modal->insert('sh_tank_chart',$insert_data); 
			}
			$finalarray[] = (object) $insert_data;
			
			$h = $h + 0.1;
				
			}			
			
	}
	}
	
	$data['get_tank_data'] = $this->tank_dia_modal->tank_data($data["id"]);
	
	$data['get_main_data'] = $this->tank_dia_modal->selecttanks($data["id"]);
	//if($data['get_main_data']){
		$data['get_all_data'] = $this->tank_dia_modal->selectchartData($data["id"],$data['get_main_data']->id);
		/*echo "<pre>";
	print_r($data['get_all_data']); die;*/
		
	//}
	/*echo "<pre>";
	print_r($get_main_data); 
	print_r($get_all_data); die;*/
	
	if($Preview){
		$data['get_all_data'] =   $finalarray;
	}
	if($save){
		redirect('tank_list');
	}
	
	$this->load->view('web/dipchart', $data);
	}
	
	
	function calculatedata($newh,$dia,$dchange,$length){
	/*
	$dia = $_GET['dia'];
	$dchange = $_GET['dchange'];
	$length = $_GET['length'];*/
	$r = $dia/2;
	$rhr = $newh / $r;
	$accosnum = acos($rhr)*180/3.141592654*2;
	$abcdnum = $accosnum/360*PI()* pow($r,2);
	$a = SQRT(pow($r,2) - pow($newh,2));
	$abd = 0.5*(2*$a)*$newh;
	$bcd = $abcdnum-$abd;
	$qty = $bcd*$length/1000 ;
	return round($qty);
}
}	
?>