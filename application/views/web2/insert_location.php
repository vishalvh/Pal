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
					<h3 class="blank1">Add Location</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
						<?php if ($this->session->flashdata('fail')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('fail'); ?>
							   </div>
							<?php } ?>
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>admin_location/insert" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Add Location</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="addloc" placeholder="Name" name="location" value="<?php echo set_value('location');?>">
										<?php echo form_error('location' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="addlocerror" style="color: red;"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Add Address</label>
									<div class="col-sm-8">
										<textarea class="form-control1" id="address" name="address" placeholder="Add address" value=""><?php echo set_value('address');?></textarea>
										
										<?php echo form_error('address' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="addresserror" style="color: red;"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Add Phone Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="mobile" placeholder="Phone Number" name="mobile" value="<?php echo set_value('mobile');?>">
										<?php echo form_error('mobile' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="mobileerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Tank Type</label>
									<div class="col-sm-8">
										<select class="form-control1" name="tank_type" id="tank_type">
										<option value=""> Select Tank </option>
										<option value="15kl"> 15 KL </option>
										<option value="20kl"> 20 KL </option>
										<option value="25kl"> 25 KL </option>
										<option value="30kl"> 30 KL </option>
										<option value="50kl"> 50 KL </option>
										</select>
										<?php echo form_error('tank_type' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="tank_typeerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Dealer Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="dealar" placeholder="Dealra" name="dealar" value="<?php echo set_value('dealar');?>">
										<?php echo form_error('dealar' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="dealarerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">GST No</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="gst" placeholder="Gst No." name="gst" value="<?php echo set_value('gst');?>">
										<?php echo form_error('gst' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Tin No</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="tin" placeholder="Tin No." name="tin" value="<?php echo set_value('tin');?>">
										<?php echo form_error('tin' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Logo</label>
									<div class="col-sm-8">
										<input type="file" class="" id="logo" name="logo" accept="image/x-png,image/gif,image/jpeg">
										<?php echo form_error('logo' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="logoerror" style="color: red;"></div>
									</div>
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

	$("#addloc").blur(function(){
		 var loc = $("#addloc").val();
                            if(loc == ""){
         $("#addlocerror").html("Location is required.");
                      }
                      else{
							     $("#addlocerror").html('');
                            }
    }
					);

	$("#address").blur(function(){
		 var add = $("#address").val();
                            if(add == ""){
         $("#addresserror").html("Address is required.");
                      }
                      else{
							     $("#addresserror").html('');
                            }
    }
					);

	$("#mobile").blur(function(){
		 var mob = $("#mobile").val();
                            if(mob == ""){
         $("#mobileerror").html("Phone Number is required.");
                      }
                      else{
							     $("#mobileerror").html('');
                            }
    }
					);
	
});	
function validate(){
         var loc = document.forms["savingdata"]["addloc"].value;
         var add = document.forms["savingdata"]["address"].value;
         var mob = document.forms["savingdata"]["mobile"].value;
		 var dealar = document.forms["savingdata"]["dealar"].value;
		 var logo = document.forms["savingdata"]["logo"].value;
         var tank_type = document.forms["savingdata"]["tank_type"].value;
         var temp = 0;
       if(tank_type == ""){
            $("#tank_typeerror").html("Type is required.");
            temp++;
        }
       if(loc == ""){
            $("#addlocerror").html("Location is required.");
            temp++;
        }
		if(logo == ""){
            $("#logoerror").html("Logo is required.");
            temp++;
        }
		if(dealar == ""){
            $("#dealarerror").html("Dealer is required.");
            temp++;
        }
        if(add == ""){
            $("#addresserror").html("Address is required.");
            temp++;
        }
        if(mob == ""){
            $("#mobileerror").html("Phone Number is required.");
            temp++;
        }
		
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	</script>