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
   
 <body class="sticky-header left-side-collapsed"  onload="initMap()">
    <section>	
    <!-- left side start-->
		<?php $this->load->view('web/left');?>
		<!-- left side end-->
    
		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<?php $this->load->view('web/header');?>
		<!-- //header-ends -->
			<div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Change Password </h3>
						<div class="tab-content">

							<?php if ($this->session->flashdata('update_pass')) { ?>
							   <div class="alert alert-success alert-dismissable" style="max-width: 64%;margin-left: 18%;">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('update_pass'); ?>
							   </div>
							<?php } ?>
							
							<?php if ($this->session->flashdata('upd_fail')) { ?>
							   <div class="alert alert-danger alert-dismissable" style="max-width: 64%;margin-left: 18%;">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('upd_fail'); ?>
							   </div>
							<?php } ?>

							<?php if ($this->session->flashdata('chk_pass')) { ?>
							   <div class="alert alert-danger alert-dismissable" style="max-width: 64%;margin-left: 18%;">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('chk_pass'); ?>
							   </div>
							<?php } ?>
							
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/change_password" name="savingdata" onsubmit="return validate()">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Old Password</label>
									<div class="col-sm-8">
										<input type="password" class="form-control1" id="op" placeholder="Old Password" name="old_pass" value="<?php echo set_value('old_pass');?>">
										<?php echo form_error('old_pass','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="ope" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">New Password</label>
									<div class="col-sm-8">
										<input type="password" class="form-control1" id="np" placeholder="New Password" name="new_pass" value="<?php echo set_value('new_pass');?>">
										<?php echo form_error('new_pass','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="npe" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Confirm Password</label>
									<div class="col-sm-8">
										<input type="password" class="form-control1" id="cp" placeholder="Confirm Password" name="con_pass" value="<?php echo set_value('con_pass');?>">
										<?php echo form_error('con_pass','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="cpe" style="color: red;"></div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Change Password</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					
					
  
						
				</div>
			<!-- switches -->
		<div class="switches">
			
		</div>
		<!-- //switches -->
						</div>
			<!--body wrapper start-->
			</div>
			 <!--body wrapper end-->
		</div>
        <!--footer section start-->
			<?php $this->load->view('web/footer');?>
        <!--footer section end-->

      <!-- main content end-->
   </section>
  
<script src="<?php echo base_url();?>assets1/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>assets1/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="<?php echo base_url();?>assets1/js/bootstrap.min.js"></script>
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){
		
		$("#op").blur(function(){
		 var op = $("#op").val();
                            if(op == ""){
         $("#ope").html("Old Password is required.");
                      }
                      else{
							     $("#ope").html('');
                            }
    }
					);
		
		$("#np").blur(function(){
		 var np = $("#np").val();
                            if(np == ""){
         $("#npe").html("New Password is required.");
                      }
                      else{
							     $("#npe").html('');
                            }
    }
					);
		
		$("#cp").blur(function(){
		 var cp = $("#cp").val();
                            if(cp == ""){
         $("#cpe").html("Confirm Password is required.");
                      }
                      else{
							     $("#cpe").html('');
                            }
    }
					);
	});

function validate(){
         var op = document.forms["savingdata"]["op"].value;
         var np = document.forms["savingdata"]["np"].value;
         var cp = document.forms["savingdata"]["cp"].value;
         
       
        var temp = 0;
       if(op == ""){
            $("#ope").html("Old Password is required.");
            temp++;
        }if(np == ""){
            $("#npe").html("New Password is required.");
            temp++;
        }
        if(cp == ""){
            $("#cpe").html("Confirm Password  is required.");
            temp++;
        }
	
		
	 	
        if(temp != 0){
        			 return false;     
        }
    }
</script>