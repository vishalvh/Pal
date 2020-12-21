<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Easy Admin Panel an Admin Panel Category Flat Bootstrap Responsive Website Template | Home :: w3layouts</title>
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
					<h3 class="blank1">Add Customer</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>manage_customer/insert" name="savingdata" onsubmit="return validate()">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="usernameval" placeholder="Name" name="username" value="<?php echo set_value('username');?>">
										<?php echo form_error('username' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Address</label>
									<div class="col-sm-8">
										<textarea class="form-control1" id="address" placeholder="Enter Your Address" name="address"><?php echo set_value('address');?></textarea>
										
										<?php echo form_error('address' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="addresserror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Phone Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="phone" placeholder="Phone Number" name="phone" value="<?php echo set_value('phone');?>">
										<?php echo form_error('phone' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="phoneerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Cheque Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="cheque" placeholder="Cheque Number" name="cheque" value="<?php echo set_value('cheque');?>">
										<?php echo form_error('cheque' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="chequeerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Bank Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="bank" placeholder="Bank Name" name="bank" value="<?php echo set_value('bank');?>">
										<?php echo form_error('bank' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="bankerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">personal guarantor</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="personal_guarantor" placeholder="Personal Guarantor" name="personal_guarantor" value="<?php echo set_value('personal_guarantor');?>">
										<?php echo form_error('personal_guarantor' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="personal_guarantorerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Location</label>
									<div class="col-sm-8">
										<select name="location" id="location" class="form-control1">
										<option value="">Select Location</option>
										<?php 

											foreach ($r->result() as $row) {
												?>
													<option value="<?php echo $row->l_id?>"><?php echo $row->l_name?></option>
												<?php
											}
										?>
										
									</select><div class="invalid-feedback" id="locationerror" style="color: red;"></div></div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Add</button>
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
	
	$("#address").blur(function(){
		 var ad = $("#address").val();
                            if(ad == ""){
         $("#addresserror").html("Address is required.");
                      }
                      else{
							     $("#addresserror").html('');
                            }
    }
					);
	
	$("#phone").blur(function(){
		 var ph = $("#phone").val();
                            if(ph == ""){
         $("#phoneerror").html("Phone Number is required.");
                      }
                      else{
							     $("#phoneerror").html('');
                            }
    }
					);
	
	$("#cheque").blur(function(){
		 var chq = $("#cheque").val();
                            if(chq == ""){
         $("#chequeerror").html("Cheque Number is required.");
                      }
                      else{
							     $("#chequeerror").html('');
                            }
    }
					);
	
	$("#bank").blur(function(){
		 var bank = $("#bank").val();
                            if(bank == ""){
         $("#bankerror").html("Bank Name is required.");
                      }
                      else{
							     $("#bankerror").html('');
                            }
    }
					);
	
	$("#personal_guarantor").blur(function(){
		 var pg = $("#personal_guarantor").val();
                            if(pg == ""){
         $("#personal_guarantorerror").html("Personal Guarantor name is required.");
                      }
                      else{
							     $("#personal_guarantorerror").html('');
                            }
    }
					);

	$("#location").blur(function(){
		 var location = $("#location").val();
                            if(location == ""){
         $("#locationerror").html("Select Any Location.");
                      }
                      else{
							     $("#locationerror").html('');
                            }
    }
					);
	

});	
function validate(){
        var name = document.forms["savingdata"]["usernameval"].value;
        var add = document.forms["savingdata"]["address"].value;
        var phone = document.forms["savingdata"]["phone"].value;
        var cheque = document.forms["savingdata"]["cheque"].value;
        var bank = document.forms["savingdata"]["bank"].value;
        var personal_guarantor = document.forms["savingdata"]["personal_guarantor"].value;
        var location = document.forms["savingdata"]["location"].value;
   
        var temp = 0;
       if(name == ""){
            $("#usernameerror").html("Name is required.");
            temp++;
        }
        if(add == ""){
            $("#addresserror").html("Address is required.");
            temp++;
        }
        if(phone == ""){
            $("#phoneerror").html("Phone Number is required.");
            temp++;
        }
        if(cheque == ""){
            $("#chequeerror").html("Cheque Number is required.");
            temp++;
        }
        if(bank == ""){
            $("#bankerror").html("Bank Name is required.");
            temp++;
        }
        if(personal_guarantor == ""){
            $("#personal_guarantorerror").html("Personal Guarantor name is required.");
            temp++;
        }
        if(location == ""){
            $("#locationerror").html("Select Any Location.");
            temp++;
        }
        
        if(temp != 0){
        			 return false;     
        }
    }
	</script>