
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Easy Admin Panel an Admin Panel Category Flat Bootstrap Responsive Website Template | Sign In :: w3layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="<?php echo base_url();?>assets1/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo base_url();?>assets1/css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="<?php echo base_url();?>assets1/css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<!-- lined-icons -->
<link rel="stylesheet" href="<?php echo base_url();?>assets1/css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
<!-- chart -->
<script src="<?php echo base_url();?>assets/js/Chart.js"></script>
<!-- //chart -->
<!--animate-->
<link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="<?php echo base_url();?>assets/js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!----webfonts--->
<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<!---//webfonts---> 
 <!-- Meters graphs -->
<script src="<?php echo base_url();?>assets1/js/jquery-1.10.2.min.js"></script>
<!-- Placed js at the end of the document so the pages load faster -->

</head> 
   
 <body class="sign-in-up">
    <section>
			<div id="page-wrapper" class="sign-in-wrapper">
				<div class="graphs">
					<div class="sign-in-form">
						<div class="sign-in-form-top">
							<p><span>Check Email address</span></p>
						</div>
						<div class="signin">
							
							<form method="post" action="<?php echo base_url();?>forgot_password/forgot_pass_data" onsubmit="return validate()" name="savingdata">

							<?php if ($this->session->flashdata('succ_pass')) { ?>
		                       <div class="alert alert-success alert-dismissable" style="max-width: 88%;">
		                           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		                           <?php echo $this->session->flashdata('succ_pass'); ?>
		                       </div>
		                    <?php } ?>
		                    
		                    <?php if ($this->session->flashdata('fail')) { ?>
		                       <div class="alert alert-danger alert-dismissable" style="max-width: 88%;">
		                           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		                           <?php echo $this->session->flashdata('fail'); ?>
		                       </div>
		                    <?php } ?>
							
		                    <?php if ($this->session->flashdata('email_wrong')) { ?>
		                       <div class="alert alert-danger alert-dismissable" style="max-width: 88%;">
		                           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		                           <?php echo $this->session->flashdata('email_wrong'); ?>
		                       </div>
		                    <?php } ?>

							<div class="log-input">
								<div class="log-input-left">
								   <input placeholder="Email Address" type="text" class="user" name="email" id="email" />
								   <?php echo form_error('email', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
								   <div class="invalid-feedback" id="emailerror" style="color: red;"></div>
								</div>
								<a class='pull-left' href="<?php echo base_url(); ?>company_login">I already have a membership</a><br><br><br><br>
							</div>
							
							<input type="submit" name="submit" value="Check Your Email ">
							<div class="sub_home">
							
							
							
						</div>
						</form>	 
						</div>
						
					</div>
				</div>
			</div>
		
	</section>
	
<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
</body>
</html>

<script>
			
$(document).ready(function(){ 

	$("#email").blur(function(){
		 var email = $("#email").val();
                            if(email == ""){
         $("#emailerror").html("Email Id is required.");
                      }else{
                                        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
										if (filter.test(email)) {
                                              $("#emailerror").html('');
                                         }else{
                                            
											  $("#emailerror").html('Email is not valid.');
                                         }
					  }
    }
					);
	
});	
function validate(){
         
		var email = document.forms["savingdata"]["email"].value;
        var temp = 0;
       	if(email == ""){
            $("#emailerror").html("Email id  is required.");
            temp++;
        }
	    if(temp != 0){
        			 return false;     
        }
    }
	</script>