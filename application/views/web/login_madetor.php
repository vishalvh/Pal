
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
<script src="<?php echo base_url();?>assets1/js/Chart.js"></script>
<!-- //chart -->
<!--animate-->
<link href="<?php echo base_url();?>assets1/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="<?php echo base_url();?>assets1/js/wow.min.js"></script>
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
							<p><span>Sign In to</span> <a href="">Company</a></p>
						</div>
						<div class="signin">
							
							<form method="post" action="<?php echo base_url();?>madetor_login/login_validation" onsubmit="return validate()" name="savingdata">
							<?php if ($this->session->flashdata('success')) { ?>
		                       <div class="alert alert-success alert-dismissable" style="">
		                           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		                           <?php echo $this->session->flashdata('success'); ?>
		                       </div>
		                    <?php } ?>
							<?php if ($this->session->flashdata('error')) { ?>
		                       <div class="alert alert-danger alert-dismissable" style="">
		                           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		                           <?php echo $this->session->flashdata('error'); ?>
		                       </div>
		                    <?php } ?>

							<div class="log-input">
								<div class="log-input-center">
								   <input placeholder="Email" id="AdminEmail" type="text" class="user" name="email" value="<?php echo set_value('email');?>" /><?php echo form_error('email', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
								   <div class="invalid-feedback" id="AdminEmailerror" style="color: red;"></div>
								</div>
								
							</div>
							<div class="log-input">
								<div class="log-input-center">
								   <input placeholder="Password" id="password" type="password" class="lock" name="password" value="<?php echo set_value('password');?>" /><?php echo form_error('password', '<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
								   <div class="invalid-feedback" id="cpasserror" style="color: red;"></div>
								</div>
								<a class='pull-left' href="<?php echo base_url(); ?>forgot_password">I forgot my password</a><br><br>
								
							</div>
							<input class="center-block" type="submit" name="submit" value="Login to your account">
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

	$("#AdminEmail").blur(function(){
		 var email = $("#AdminEmail").val();
                            if(email == ""){
         $("#AdminEmailerror").html("Email Id is required.");
                      }else{
                                        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
										if (filter.test(email)) {
                                              $("#AdminEmailerror").html('');
                                         }else{
                                            
											  $("#AdminEmailerror").html('Email is not valid.');
                                         }
					  }
    }
					);
	$("#password").blur(function(){
		 var email = $("#password").val();
		
                            if(email == ""){
         $("#cpasserror").html(" Password is required.");
                      }else{
										
                                              $("#cpasserror").html('');
                                         
					  }
    }
					);
});	
function validate(){
         var AdminEmail = document.forms["savingdata"]["AdminEmail"].value;
         var cpass = document.forms["savingdata"]["password"].value;
       
        var temp = 0;
       
        if(AdminEmail == ""){
            $("#AdminEmailerror").html("Email id  is required.");
            temp++;
        }
	if(cpass == ""){
            $("#cpasserror").html(" Password is required.");
            temp++;
        }
	
		
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	</script>