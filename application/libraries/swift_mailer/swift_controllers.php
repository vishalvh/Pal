<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class swift_controller extends CI_Controller {

    function __construct() {

        parent::__construct();
        
    }

    
  function swiftmail() {

        $this->load->helper(array('swift'));
		$email="rahul@virtualheight.com";	
		
     $message='<div style="background:#fff; border:1px solid #ccc; padding:2px 30px"><img alt="" src="http://ec2-52-62-23-230.ap-southeast-2.compute.amazonaws.com/user_assets/images/logo.png" /></div>

<div style="background:#fff; border:1px solid #ccc; padding:30px">
<h1>Dear {{name}} ,</h1>

<h3>Welcome to TenderSeek, please see below your login and password details. TenderSeek provides daily updates of tender advertisments from over 2500 media channels across Australia. Your business email profile selected by you can be updated at any time by logging into your account, we suggest you monitor and make adjustments in the initial few months to ensure all opportunties matching your business expertise is captured. &nbsp; &nbsp;</h3>

<table cellpadding="10">
	<tbody>
		<tr>
			<th>Username :</th>
			<td>{{username}}</td>
		</tr>
		<tr>
			<th>Password :</th>
			<td>{{password}}</td>
		</tr>
		<tr>
			<td colspan="2">
			<p><a href="http://ec2-52-62-23-230.ap-southeast-2.compute.amazonaws.com/user_master/index">Login</a></p>

			<p>&nbsp;</p>

			<p>Kind Regards</p>

			<p>TenderSeek&nbsp;</p>

			<p>&nbsp;</p>
			</td>
		</tr>
	</tbody>
</table>
</div>
';    
			
	  send_mail($email,'test mail tender',$message);
echo $message;
        
    }	
    

}

?>
