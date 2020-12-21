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
					<h3 class="blank1">Update Data</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/user_update/<?php echo $id;?>" name="savingdata" onsubmit="return validate()">
								<input type="hidden" name="id" value="<?php echo $this->uri->segment('3');?>">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="usernameval" placeholder="Username" name="username" value="<?php echo $r[0]->UserFName;?>">
										<?php echo form_error('username','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Mobile No</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="mobileval" placeholder="Mobile Number" name="mobile" value="<?php echo $r[0]->UserMNumber;?>">
										<?php echo form_error('mobile' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>'); ?>
											<div class="invalid-feedback" id="mobileerror" style="color: red;"></div>										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Email Address</label>
									<div class="col-sm-8">
										<input type="email" class="form-control1" id="AdminEmail" placeholder="Email Address" name="email" value="<?php echo $r[0]->UserEmail?>">
										<?php echo form_error('email','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
										<div class="invalid-feedback" id="AdminEmailerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Password</label>
									<div class="col-sm-8">
										<input type="password" class="form-control1" id="password" placeholder="Password" name="password" value="<?php echo $r[0]->UserPassword?>">
										<?php echo form_error('password','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
										<div class="invalid-feedback" id="cpasserror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Location</label>
									<div class="col-sm-8">
										<select name="sel_loc" id="location" class="form-control1">
										<option value="">Select Location</option>
										<?php 
											// print_r($r1->result());
											foreach ($r1->result() as $row) {
												?>
													<option value="<?php echo $row->l_id?>" 
														<?php
															if($row->l_id == $r[0]->l_id )
																{ 
																	echo "selected"; 
																}
														?> > <?php echo $row->l_name?></option>
												<?php
											}
										?>
										
									</select><div class="invalid-feedback" id="locationerror" style="color: red;"></div></div>
								</div>

								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Shift</label>
									<div class="col-sm-8">
										<select name="shift" id="shift" class="form-control1">
										<option value="">Select Shift</option>
										
										<option value="1" <?php 
											if($shift[0]->shift == '1')
											{
												?>
													selected ="selected";
												<?php
											}
										?>>Day</option>
										<option value="2" <?php 
											if($shift[0]->shift == '2')
											{
												?>
													selected ="selected";
												<?php
											}
										?>>Night</option>
										<option value="3" <?php 
											if($shift[0]->shift == '3')
											{
												?>
													selected ="selected";
												<?php
											}
										?>>24 hours</option>
										
									</select><div class="invalid-feedback" id="shifterror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update</button>
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

<script>
			
$(document).ready(function(){ 

	$("#usernameval").blur(function(){
		 var name = $("#usernameval").val();
                            if(name == ""){
         $("#usernameerror").html("Name is required.");
                      }
                      else{
							     $("#usernameerror").html('');
                            }
    }
					);
	$("#mobileval").blur(function(){
		 var mobile = $("#mobileval").val();
                            if(mobile == ""){
         $("#mobileerror").html("Mobile Number is required.");
                      }
                      else{
							     $("#mobileerror").html('');
                            }
    }
					);
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
		 var password = $("#password").val();
		
                            if(password == ""){
         $("#cpasserror").html(" Password is required.");
                      }else{
										
                                              $("#cpasserror").html('');
                                         
					  }
    }
					);
	$("#location").blur(function(){
		 var location = $("#location").val();
		
                            if(location == ""){
         $("#locationerror").html("Select Any Location.");
                      }else{
										
                                              $("#locationerror").html('');
                                         
					  }
    }
					);

	$("#shift").blur(function(){
		 var shift = $("#shift").val();
		
                            if(shift == ""){
         $("#shifterror").html("Select Shift.");
                      }else{
										
                                              $("#shifterror").html('');
                                         
					  }
    }
					);
});	
function validate(){
         var name = document.forms["savingdata"]["usernameval"].value;
         var mobile = document.forms["savingdata"]["mobileval"].value;
         var AdminEmail = document.forms["savingdata"]["AdminEmail"].value;
         var cpass = document.forms["savingdata"]["password"].value;
       	 var location = document.forms["savingdata"]["location"].value;
       	 var shift = document.forms["savingdata"]["shift"].value;

        var temp = 0;
       if(name == ""){
            $("#usernameerror").html("Name is required.");
            temp++;
        }if(mobile == ""){
            $("#mobileerror").html("Mobile Number is required.");
            temp++;
        }
        if(AdminEmail == ""){
            $("#AdminEmailerror").html("Email id  is required.");
            temp++;
        }
	if(cpass == ""){
            $("#cpasserror").html(" Password is required.");
            temp++;
        }
        if(location == ""){
            $("#locationerror").html("Select Any location.");
            temp++;
        }
        if(shift == ""){
            $("#shifterror").html("Select Shift.");
            temp++;
        }
	
		
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	</script>