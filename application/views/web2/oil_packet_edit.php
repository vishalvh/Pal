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
					<h3 class="blank1">Edit Oil Packet Detail</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>Oil_packet/upd_packet/<?php echo $id;?>" name="savingdata" onsubmit="return validate()">
								<input type="hidden" name="id" value="<?php echo $pump[0]->id;?>">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="pump" placeholder="Enter Pump name" name="pump" value="<?php echo $pump[0]->name; ?>">
										<?php echo form_error('pump' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="pumperror" style="color: red;"></div>
									</div>
								</div>
									<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Type (ml,ltr)</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="packet_type" placeholder="Oil packet type" name="packet_type" value="<?php echo $pump[0]->packet_type; ?>">
										<?php echo form_error('packet_type' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="packet_typeerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Quantity</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="packet_qty" placeholder="Oil packet quantity" name="packet_qty" value="<?php echo $pump[0]->p_qty; ?>">
										<?php echo form_error('packet_qty' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="packet_qtyerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="packet_value" placeholder="Oil packet price" name="packet_value" value="<?php echo $pump[0]->packet_value; ?>">
										<?php echo form_error('packet_value' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="packet_valueerror" style="color: red;"></div>
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
															if($row->l_id == $pump[0]->location_id )
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
									<label for="selector1" class="col-sm-2 control-label">Select Packet Type</label>
									<div class="col-sm-8">
										<select name="sel_p_type" id="ptype" class="form-control1">
										<option value="">Select Packet Type</option>
										<option value="ltr" <?php if('ltr' == $pump[0]->p_type){ echo "selected"; 	}?>>Ltr</option>
										<option value="ml" <?php if('ml' == $pump[0]->p_type){ echo "selected"; 	}?>>Ml</option>
										<option value="kg" <?php if('kg' == $pump[0]->p_type){ echo "selected"; 	}?>>Kg</option>
									</select><div class="invalid-feedback" id="ptypeerror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">update</button>
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

	$("#pump").blur(function(){
		var pump = $("#pump").val();
		if(pump == ""){
			$("#pumperror").html("Name is required.");
		}else{
			$("#pumperror").html('');
		}
    }
	);

	$("#packet_type").blur(function(){
		var pumptype = $("#packet_type").val();
		if(pumptype == ""){
			$("#packet_typeerror").html("Oil type is required.");
		}else{
			$("#packet_typeerror").html('');
		}
    });

	$("#location").blur(function(){
		var loc = $("#location").val();
		if(loc == ""){
			$("#locationerror").html("Select location.");
		}else{
			$("#locationerror").html('');
		}
    });
	$("#packet_value").blur(function(){
		var loc = $("#packet_value").val();
		if(loc == ""){
			$("#packet_valueerror").html("Oil value is required.");
		}else{
			$("#packet_valueerror").html('');
		}
    });
	
});	
function validate(){
                 var pump = document.forms["savingdata"]["pump"].value;
         var pumptype = document.forms["savingdata"]["packet_type"].value;
         var location = document.forms["savingdata"]["location"].value;
         
		 var packet_value = document.forms["savingdata"]["packet_value"].value;
         var pumptype = document.forms["savingdata"]["packet_type"].value;
       var sel_p_type = document.forms["savingdata"]["sel_p_type"].value;
	    var packet_qty = document.forms["savingdata"]["packet_qty"].value;
        var temp = 0;
       if(packet_qty == ""){
            $("#packet_qtyeerror").html("Packet Quantity is required.");
            temp++;
        }
        
       if(sel_p_type == ""){
            $("#ptypeerror").html("Packet Type is required.");
            temp++;
        }
       if(pump == ""){
            $("#pumperror").html("Name is required.");
            temp++;
        }
        if(pumptype == ""){
            $("#packet_typeerror").html("Oil type is required.");
            temp++;
        }
		if(packet_value == ""){
            $("#packet_valueerror").html("Oil value is required.");
            temp++;
        }
        if(location == ""){
            $("#locationerror").html("Select Location.");
            temp++;
        }
		
		
        if(temp != 0){
        			 return false;     
        }
    }
	</script>