
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Shri Hari</title>
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
							<p><span>Change Password</span></p>
						</div>
						<div class="signin">
							
							<form method="post" action="<?php echo base_url();?>forgot_password/set_password/<?php echo $code; ?>" onsubmit="return validate()" name="savingdata">

							<?php if ($this->session->flashdata('fail')) { ?>
		                       <div class="alert alert-danger alert-dismissable">
		                           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		                           <?php echo $this->session->flashdata('fail'); ?>
		                       </div>
		                    <?php } ?>
		                    
		                    <?php if ($this->session->flashdata('unsuccess')) { ?>
		                       <div class="alert alert-danger alert-dismissable">
		                           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		                           <?php echo $this->session->flashdata('unsuccess'); ?>
		                       </div>
		                    <?php } ?>
							<div class="log-input">
								<div class="log-input-center">
								   <input placeholder="New Password" type="password" class="user" name="np" id="np" />
								   <?php echo form_error('np', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
								   <div class="invalid-feedback" id="passworderror" style="color: red;"></div>
								</div>

								<div class="log-input-center">
								   <input placeholder="Confirm Password" type="password" class="user" name="cp" id="cpass" />
								   <?php echo form_error('cp', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
								   <div class="invalid-feedback" id="cpasserror" style="color: red;"></div>
								</div>
								
							</div>
							
							<input type="submit" name="submit" value="Update Your Password" class="center-block">
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

	$("#np").blur(function(){
		 var np = $("#np").val();
                            if(np == ""){
         $("#passworderror").html("Password  is required.");
                      }else{
                                   //alert(email.length);    
										if(np.length >= 6) {
                                              $("#passworderror").html('');
                                         }else{
                                            
											  $("#passworderror").html('Password length minimum is 6.');
                                         }
					  }
    }
					);
	$("#cpass").blur(function(){
		 var np = $("#np").val();
		 var cpass = $("#cpass").val();
                            if(np == ""){
         $("#cpasserror").html("Confirm Password is required.");
                      }else{
                                   //alert(email.length);    
										if(np == cpass) {
                                              $("#cpasserror").html('');
                                         }else{
                                            
											  $("#cpasserror").html('Confirm Password is not match.');
                                         }
					  }
    }
					);
});	
function validate(){
         var np = document.forms["savingdata"]["np"].value;
         var cpass = document.forms["savingdata"]["cpass"].value;
       
        var temp = 0;
       
        if(np == ""){
            $("#passworderror").html("Password  is required.");
            temp++;
        }
	if(cpass == ""){
            $("#cpasserror").html("Confirm Password is required.");
            temp++;
        }
	if(cpass != np){
           $("#cpasserror").html("Confirm Password is not match.");
            temp++;
        }
			
		
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	</script>
