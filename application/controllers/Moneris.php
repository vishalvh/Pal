<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Moneris extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

function index() {
	
include_once APPPATH.'/third_party/moneris/mpgClasses.php';
$store_id='gwca014643';
$api_token='D1xaGrGucdtqNMfY6dcx';
//$store_id='store3';
//$api_token='yesguy';

/****************************** Transactional Variables ***************************/
$type='purchase';
$order_id='tutorsaround-ord-'.date("d-m-y-G:i:s");
//$cust_id='CUST887763';
$amount=$_GET['amount'];
$pan=$_GET['card'];
$expiry_date=$_GET['expiry_date'];
//$cavv='AAABBJg0VhI0VniQEjRWAAAAAAA=';
$crypt_type = '7';
//$wallet_indicator = "APP";
//$dynamic_descriptor='123456';
/*************************** Transaction Associative Array ************************/
$txnArray=array(
			'type'=>$type,
	        'order_id'=>$order_id,
			//'cust_id'=>$cust_id,
	        'amount'=>$amount,
	        'pan'=>$pan,
	        'expdate'=>$expiry_date,
			//'cavv'=>$cavv,
			'crypt_type'=>$crypt_type, //mandatory for AMEX only
			//'wallet_indicator'=>$wallet_indicator, //set only for wallet transactions. e.g. APPLE PAY
			//'network'=> "Interac", //set only for Interac e-commerce
			//'data_type'=> "3DSecure", //set only for Interac e-commerce
			//'dynamic_descriptor'=>$dynamic_descriptor
			//,'cm_id' => '8nAK8712sGaAkls56' //set only for usage with Offlinx - Unique max 50 alphanumeric characters transaction id generated by merchant
	           );

/****************************** Transaction Object *******************************/

$mpgTxn = new mpgTransaction($txnArray);
/******************* Credential on File **********************************/
$cof = new CofInfo();
$cof->setPaymentIndicator("U");
$cof->setPaymentInformation("2");
$cof->setIssuerId(time());
$mpgTxn->setCofInfo($cof);
/******************************* Request Object **********************************/
$mpgRequest = new mpgRequest($mpgTxn);
$mpgRequest->setProcCountryCode("CA"); //"US" for sending transaction to US environment
//$mpgRequest->setTestMode(true); //false or comment out this line for production transactions
/****************************** HTTPS Post Object *******************************/
//echo "<pre>"; print_r($mpgRequest);
$mpgHttpPost  =new mpgHttpsPost($store_id,$api_token,$mpgRequest);
/************************************* Response *********************************/
$mpgResponse=$mpgHttpPost->getMpgResponse();
$result['CardType'] = $mpgResponse->getCardType();
$result['TransAmount'] = $mpgResponse->getTransAmount();
$result['TxnNumber'] = $mpgResponse->getTxnNumber();
$result['ReceiptId'] = $mpgResponse->getReceiptId();
$result['TransType'] = $mpgResponse->getTransType();
$result['ReferenceNum'] = $mpgResponse->getReferenceNum();
$result['ResponseCode'] = $mpgResponse->getResponseCode();
$result['ISO'] = $mpgResponse->getISO();
$result['Message'] = $mpgResponse->getMessage();
$result['AuthCode'] = $mpgResponse->getAuthCode();
$result['Complete'] = $mpgResponse->getComplete();
$result['TransDate'] = $mpgResponse->getTransDate();
$result['TransTime'] = $mpgResponse->getTransTime();
$result['Ticket'] = $mpgResponse->getTicket();
$result['TimedOut'] = $mpgResponse->getTimedOut();
$result['CavvResultCode'] = $mpgResponse->getCavvResultCode();
$result['IssuerId'] = $mpgResponse->getIssuerId();
echo json_encode($result);
    }
}
?>