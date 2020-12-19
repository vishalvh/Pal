
<html>
<head>
<title>Pal Oil Company Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>/assets/img/icon/18.png">
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
	
<!--//end-animate-->
<!----webfonts--->
<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<!---//webfonts---> 
 <!-- Meters graphs -->
<script src="<?php echo base_url();?>assets1/js/jquery-1.10.2.min.js"></script>
<!-- Placed js at the end of the document so the pages load faster -->
<style>
div#page-wrapper {
    padding: 4em 2em;
    background-image: url(<?php echo base_url(); ?>assets1/images/bac1k.png) !important;
    width: 100%;
    height: 100%;
    background-repeat: no-repeat;
    background-position-x: center;
    background-position-y: center;
}
.login-page section{
	width:100%
	height:100%;
}
.signin{
	background-image: url(<?php echo base_url(); ?>assets1/images/login-back.png) !important;
}
.login-page .sign-in-form-top{   
    background: none;
    width: 100px;
    margin: 0 auto;
    padding-top: 0;
    padding-bottom: 0;
    height: 100px;}
.login-page	.sign-in-form-top img{width: 100%;
    height: 100%;
    object-fit: contain;}
.login-page .log-input input.user,.login-page .log-input input.lock{
    background: transparent;
    padding: 10px 12px;
    color: #fff !important;
    border-color: #fff;
    border-width: 1px;margin:0 0 5px 0;
}
input#AdminEmail::placeholder {
    color: #fff;
}
input#password::placeholder {
    color: #fff;
}
.log-input-center {
    margin-bottom: 20px;
}
.sign-in-form input[type="submit"]{background: #2d2d31;
    width: 100%;}
.forgot_password{color:#fff;}
</style>
</head> 
   
 <body class="sign-in-up login-page">
    <section>
			<div id="page-wrapper" class="sign-in-wrapper">
				<div class="graphs">
					<div class="sign-in-form">
						
						<div class="signin">
							<div class="sign-in-form-top ">
							   <img src="<?php echo base_url(); ?>assets1/images/logo.png"/>
						    </div>
							<form method="post" action="<?php echo base_url();?>main/login_validation" onsubmit="return validate()" name="savingdata">
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
								<a class='pull-left forgot_password' href="<?php echo base_url(); ?>forgot_password">I forgot my password</a><br><br>
								
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