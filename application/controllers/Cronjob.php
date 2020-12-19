<?php
class Cronjob extends CI_Controller {
function __construct() {
	parent::__construct();
}
function index() {
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d');
	// if($date == '2020-02-03'){
		// $date = '2020-02-01';
	// }
	$debug=$_REQUEST['debug'];
	if(('16' == date('d',strtotime($date)) || '01' == date('d',strtotime($date))) && ('18:00' == date('H:i'))){
		$bdate = $date;
		$this->load->model('Manage_customer_model');
		$this->load->model('daily_reports_model');
		$this->load->model("service_model_1");
		$getAllLocationList = $this->Manage_customer_model->get_all_location();
		$locationArray = array();
		$locationnameArray = array();
		foreach($getAllLocationList as $locationList){
			if($locationList->l_id != '39'){
			$locationArray[] = $locationList->l_id;
			$locationnameArray[$locationList->l_id] = $locationList->l_name;
			}
		}
		$getAllCustomerList = $this->Manage_customer_model->get_all_customer();
		if('16' == date('d',strtotime($date))){
			$date = date('Y-m-').'15';
			$sdate = date('Y-m-').'01';
		}
		if('01' == date('d',strtotime($date))){
			$date = date('Y-m-d', strtotime('last day of previous month'));
			$sdate = date('Y-m-', strtotime('last day of previous month')).'15';
		}
		$commanMsg = 'Your {{locationname}} bill is due {{rs}}. Pay instantly. Please ignore if already paid.';
		$arrContextOptions=array(
							"ssl"=>array(
							  "verify_peer"=>false,
							  "verify_peer_name"=>false,
							),
						  );
		foreach($getAllCustomerList as $customerList){
			if(in_array($customerList->location_id,$locationArray)){
				$SelectedContact = array();
				$SelectedContactMobile = array();
				if('0000000000' != $customerList->phone_no){
				$SelectedContact[] = array("Name"=>$customerList->name,"Phone"=>$customerList->phone_no);
				$SelectedContactMobile[] = $customerList->phone_no;
				}
				$totalprev_debit = $this->daily_reports_model->totalprev_credit_debit($customerList->location_id,$date,$customerList->id,'d');
				$totalprev_credit = $this->daily_reports_model->totalprev_credit_debit($customerList->location_id,$date,$customerList->id,'c');
				$prevbalence = $totalprev_credit->totalamount-$totalprev_debit->totalamount;
				if($prevbalence > 500){
					$url = base_url().'credit_debit/print_invoice_pdf?sdate='.$sdate.'&edate='.$date.'&lid='.$customerList->location_id.'&Employeename='.$customerList->id;
					//echo "<br>".$prevbalence."<br>".$url;
					$getAllCustomerContactPersonList = $this->Manage_customer_model->get_customer_contact_person($customerList->id);
					if(count($getAllCustomerContactPersonList) > 0){
						foreach($getAllCustomerContactPersonList as $ContactPersonList){
							if(!in_array($ContactPersonList->phone,$SelectedContactMobile) && '0000000000' != $ContactPersonList->phone && $ContactPersonList->phone != ''){
								$SelectedContactMobile[] = $ContactPersonList->phone;
								$SelectedContact[] = array("Name"=>$ContactPersonList->name,"Phone"=>$ContactPersonList->phone);
							}
						}
					}
					if(count($SelectedContact) > 0){
						$data = array(
						'cust_fk' => $customerList->id,
						'sdate' => $sdate,
						'edate' => $date,
						'location_fk' => $customerList->location_id,
						'bill_date' => $bdate
			 			);

						$insert_id = $this->service_model_1->master_insert("sh_cutomer_invoce", $data);
						$url = 'paloilapp.com/i/'.$insert_id;
				
						$message = str_replace("{{rs}}",$prevbalence,$commanMsg);
						$message = str_replace("{{locationname}}",$locationnameArray[$customerList->location_id],$message);
						$message .= ' '.$url;
						$message = urlencode($message);
						foreach($SelectedContact as $contct){
						echo $mobile = $contct['Phone'];
						//$mobile = '9638625505';
						/*echo $message;
						die();*/
						file_get_contents("https://gateway.leewaysoftech.com/xml-transconnectunicode-api.php?username=paloil&password=Nik@65L&mobile=".$mobile."&message=".$message."&senderid=ALRTSM",false, stream_context_create($arrContextOptions));
					
						}
					/*code for message*/
					}
				}
			}
		}
	}
	
	if(('09:00' == date('H:i')) || ('12:00' == date('H:i')) || ('16:00' == date('H:i'))){
		$this->sedNotification();
	}
	$this->sendmailtouser();
	file_get_contents('http://empowerlogix.com/?cronjob=1&debug=1');
}
function sedNotification(){
	
	$this->load->model('Manage_customer_model');
	$this->load->model('cronjob_model');
	$date = date('Y-m-d');
	$date = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
	$getAllLocationList = $this->Manage_customer_model->get_all_location();
	$deviceList = array();
	foreach($getAllLocationList as $location){
		$getLastDayEntry = $this->cronjob_model->get_last_day_entry($location->l_id,$date);
		if(count($getLastDayEntry) == 0){
			$getAllUserList = $this->cronjob_model->get_location_user($location->l_id);
			foreach($getAllUserList as $user){
				$getAllUserList = $this->cronjob_model->get_user_device($user->id);
				if($getAllUserList){
					$deviceList[] = $getAllUserList->device_id;
				}
			}
		}
	}
	if(count($deviceList) > 0){
	$this->load->library('PushServer');
	$pushServer = new PushServer();
	$test = $pushServer->pushToGoogle($deviceList, 'Pal Oil App', 'Add Entry for Date '.date('d-m-Y',strtotime($date)), '','');
	}
	
}



function indexbydate() {
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d');
	 if($date == '2020-10-03'){
		 $date = '2020-10-01';
	 }
	$debug=$_REQUEST['debug'];
		$bdate = $date;
		$this->load->model('Manage_customer_model');
		$this->load->model('daily_reports_model');
		$this->load->model("service_model_1");
		$getAllLocationList = $this->Manage_customer_model->get_all_location();
		$locationArray = array();
		$locationnameArray = array();
		foreach($getAllLocationList as $locationList){
			if($locationList->l_id != '39'){
			$locationArray[] = $locationList->l_id;
			$locationnameArray[$locationList->l_id] = $locationList->l_name;
			}
		}
		$getAllCustomerList = $this->Manage_customer_model->get_all_customer();
		if('16' == date('d',strtotime($date))){
			$date = date('Y-m-').'15';
			$sdate = date('Y-m-').'01';
		}
		if('01' == date('d',strtotime($date))){
			$date = date('Y-m-d', strtotime('last day of previous month'));
			$sdate = date('Y-m-', strtotime('last day of previous month')).'15';
		}
		//$date = '2020-09-30';
		//$sdate = '2020-09-15';
		//echo $sdate ." == ". $date; die;
		$commanMsg = 'Your {{locationname}} bill is due {{rs}}. Pay instantly. Please ignore if already paid.';
		$arrContextOptions=array(
							"ssl"=>array(
							  "verify_peer"=>false,
							  "verify_peer_name"=>false,
							),
						  );
		foreach($getAllCustomerList as $customerList){
			if(in_array($customerList->location_id,$locationArray) && $customerList->id > 287){
				$SelectedContact = array();
				$SelectedContactMobile = array();
				if('0000000000' != $customerList->phone_no){
				$SelectedContact[] = array("Name"=>$customerList->name,"Phone"=>$customerList->phone_no);
				$SelectedContactMobile[] = $customerList->phone_no;
				}
				$totalprev_debit = $this->daily_reports_model->totalprev_credit_debit($customerList->location_id,$date,$customerList->id,'d');
				$totalprev_credit = $this->daily_reports_model->totalprev_credit_debit($customerList->location_id,$date,$customerList->id,'c');
				$prevbalence = $totalprev_credit->totalamount-$totalprev_debit->totalamount;
				if($prevbalence > 500){
					$url = base_url().'credit_debit/print_invoice_pdf?sdate='.$sdate.'&edate='.$date.'&lid='.$customerList->location_id.'&Employeename='.$customerList->id;
					//echo "<br>".$prevbalence."<br>".$url;
					$getAllCustomerContactPersonList = $this->Manage_customer_model->get_customer_contact_person($customerList->id);
					if(count($getAllCustomerContactPersonList) > 0){
						foreach($getAllCustomerContactPersonList as $ContactPersonList){
							if(!in_array($ContactPersonList->phone,$SelectedContactMobile) && '0000000000' != $ContactPersonList->phone && $ContactPersonList->phone != ''){
								$SelectedContactMobile[] = $ContactPersonList->phone;
								$SelectedContact[] = array("Name"=>$ContactPersonList->name,"Phone"=>$ContactPersonList->phone);
							}
						}
					}
					if(count($SelectedContact) > 0){
						$data = array(
						'cust_fk' => $customerList->id,
						'sdate' => $sdate,
						'edate' => $date,
						'location_fk' => $customerList->location_id,
						'bill_date' => $bdate
			 			);

						$insert_id = $this->service_model_1->master_insert("sh_cutomer_invoce", $data);
						$url = 'paloilapp.com/i/'.$insert_id;
				
						$message = str_replace("{{rs}}",$prevbalence,$commanMsg);
						$message = str_replace("{{locationname}}",$locationnameArray[$customerList->location_id],$message);
						$message .= ' '.$url;
						$message = urlencode($message);
						foreach($SelectedContact as $contct){
					
						$mobile = $contct['Phone'];
						/*echo $mobile = '9725567516';
						echo "<br>";
						
						echo "https://gateway.leewaysoftech.com/xml-transconnectunicode-api.php?username=paloil&password=Nik@65L&mobile=".$mobile."&message=".$message."&senderid=ALRTSM"; 
						*/
						file_get_contents("https://gateway.leewaysoftech.com/xml-transconnectunicode-api.php?username=paloil&password=Nik@65L&mobile=".$mobile."&message=".$message."&senderid=ALRTSM",false, stream_context_create($arrContextOptions));
					
						}
					/*code for message*/
					}
				}
			}
		}
	
	if(('09:00' == date('H:i')) || ('12:00' == date('H:i')) || ('16:00' == date('H:i'))){
		$this->sedNotification();
	}
}


function indexfornotification() {
	$arrContextOptions=array(
		"ssl"=>array(
		  "verify_peer"=>false,
		  "verify_peer_name"=>false,
		),
	  );
						  
		$bdate = $date;
		$this->load->model('Manage_customer_model');
		$this->load->model('daily_reports_model');
		$this->load->model("service_model_1");
		$getAllLocationList = $this->Manage_customer_model->get_all_location();
		$locationArray = array();
		$locationnameArray = array();
		foreach($getAllLocationList as $locationList){
			if($locationList->l_id != '39' && $locationList->l_id != '69' && $locationList->l_id != '31' && $locationList->l_id != '9' && $locationList->l_id != '48' && $locationList->l_id != '70' && $locationList->l_id != '37'){
			$locationArray[] = $locationList->l_id;
			$locationnameArray[$locationList->l_id] = $locationList->l_name;
			}
		}		
		$getAllCustomerList = $this->Manage_customer_model->get_all_customer();
		$commanMsg = 'Your {{locationname}} bill is due {{rs}}. Pay instantly. Please ignore if already paid.';
		$arrContextOptions=array(
							"ssl"=>array(
							  "verify_peer"=>false,
							  "verify_peer_name"=>false,
							),
						  );
		
echo "<pre>"; 
$cnt = 0;
		foreach($getAllCustomerList as $customerList){
			if(in_array($customerList->location_id,$locationArray) && $cnt >=301 && $cnt <= 350){
				$SelectedContact = array();
				$SelectedContactMobile = array();
				if('0000000000' != $customerList->phone_no){
				$SelectedContact[] = array("Name"=>$customerList->name,"Phone"=>$customerList->phone_no);
				$SelectedContactMobile[] = $customerList->phone_no;
				}
		
					$url = base_url().'credit_debit/print_invoice_pdf?sdate='.$sdate.'&edate='.$date.'&lid='.$customerList->location_id.'&Employeename='.$customerList->id;
					//echo "<br>".$prevbalence."<br>".$url;
					$getAllCustomerContactPersonList = $this->Manage_customer_model->get_customer_contact_person($customerList->id);
					if(count($getAllCustomerContactPersonList) > 0){
						foreach($getAllCustomerContactPersonList as $ContactPersonList){
							if(!in_array($ContactPersonList->phone,$SelectedContactMobile) && '0000000000' != $ContactPersonList->phone && $ContactPersonList->phone != ''){
								$SelectedContactMobile[] = $ContactPersonList->phone;
								$SelectedContact[] = array("Name"=>$ContactPersonList->name,"Phone"=>$ContactPersonList->phone);
							}
						}
					}
					if(count($SelectedContact) > 0){
				$message = "આ વિનંતી છે કે કૃપા કરીને તાત્કાલિક તમારી બાકી ડીઝલ બિલ ની રકમ ચૂકવો. હવે તમામ બેંકિંગ સેવાઓ ખુલી છે. કોવિડ -19 ને કારણે અમે સમજીએ છીએ કે તમારા વ્યવસાયને અસર થઈ શકે. પરંતુ આશા છે કે તમારો વ્યવસાય હવે ખુલ્લો છે અને કૃપા કરીને તાત્કાલિક તમારી બાકી રકમ ચૂકવો અને પેનલ્ટીને ટાળો.
જો તમે પહેલેથી જ ચૂકવણી કરી હોય તો આ સંદેશને અવગણો.\r\n\r\nRegards\r\nNikhil Chaudhari";
						echo $message = str_replace("{{locationname}}",$locationnameArray[$customerList->location_id],$message);
						echo "<br>"; 
						$message = urlencode($message);
						
						foreach($SelectedContact as $contct){
						echo $mobile = $contct['Phone'];
						echo "<br>";
						//$mobile = '9725567516';
						/*echo $message;
						die();*/
						//echo "https://gateway.leewaysoftech.com/xml-transconnectunicode-api.php?username=paloil&password=Nik@65L&mobile=".$mobile."&message=".$message."&senderid=ALRTSM";
						file_get_contents("https://gateway.leewaysoftech.com/xml-transconnectunicode-api.php?username=paloil&password=Nik@65L&mobile=".$mobile."&message=".$message."&senderid=ALRTSM",false, stream_context_create($arrContextOptions));
					
						}
					/*code for message*/
					}
					echo "<br>";
					echo "<br> Number ".$cnt."<br>";
					echo "<br>";
			}
			$cnt++;
		}
}

function sendmailtouser(){
	$arrContextOptions=array(
		"ssl"=>array(
		  "verify_peer"=>false,
		  "verify_peer_name"=>false,
		),
	  );
	$this->load->model('message_master_model');
	$lists = $this->message_master_model->getpendingmessage();
	foreach($lists as $list){
		$message = $list->message;
		$message = urlencode($message);
		$mobile = $list->mobile_number;
		$this->message_master_model->updatestatussend($list->id);
		file_get_contents("https://gateway.leewaysoftech.com/xml-transconnectunicode-api.php?username=paloil&password=Nik@65L&mobile=".$mobile."&message=".$message."&senderid=ALRTSM",false, stream_context_create($arrContextOptions));
	}
}

}
?>