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
	<link href="<?php echo base_url(); ?>assets1/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
<link href='<?php echo base_url(); ?>design/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
        <script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
	<script type='text/javascript'>
      
$(document).ready(function () {
       $("#start_date").datepicker({
           dateFormat: "dd-mm-yy",
		   	changeMonth: true,
          changeYear: true,
		   yearRange: "1918:n",
		  
       });
   });

        </script> 
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
					<form method="post" action="<?php echo base_url();?>admin/add">			
								<h3 class="blank1" style="margin-top: -20px;">Expense Report Info</h3>
	 								
								</form>

					<h3 class="blank1"></h3>
					<br>
					<?php if ($this->session->flashdata('success')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success'); ?>
							   </div>
							<?php } ?>
							<?php if ($this->session->flashdata('fail')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('fail'); ?>
							   </div>
							<?php } ?>
							<?php if ($this->session->flashdata('success_update')) { ?>
							   <div class="alert alert-success alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('success_update'); ?>
							   </div>
							<?php } ?>
							
							<?php if ($this->session->flashdata('check_fail')) { ?>
							   <div class="alert alert-danger alert-dismissable">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('check_fail'); ?>
							   </div>
							<?php } ?>
						
						<?php
							$name = $expense[0]->UserFName;
							
						?>
						<form class="form-horizontal" method="post" action="<?php echo base_url();?>expense/expense_info/<?php echo $id;?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
						 <div class="md tabls">
							<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
								<div class="col-md-4">
									<label class="control-label"><b>Date</b></label>
									<div class="">
                                        
										<input type="text" id="start_date"  readonly class="form-control start_date" name="date" placeholder="Date" value="<?php echo date('d-m-Y', strtotime($expense[0]->date));?>" />
										<div class="invalid-feedback" id="start_date_error" style="color: red;"></div>
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Type</b></label>
									<div class="">
                                        <select id="type" name="type" class="form-control">
										<?php foreach($type_list as $type){ ?>
										  <option value="<?php echo $type['id'] ?>" <?php if($expense[0]->expense_id == $type['id'] ) echo"selected"  ?>><?php echo $type['exps_name']; ?></option>
										<?php } ?>
										  </select>
										  <div class="invalid-feedback" id="start_date_error" style="color: red;"></div>
                                   	</div>
								</div>	
								<div class="col-md-4">
									<label class="control-label"><b>Amount</b></label>
									<div class="">
                                        <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" value="<?php echo $expense[0]->amount;?>" />
										
										 <div class="invalid-feedback" id="amounterror" style="color: red;"></div>
                                   	</div>
								</div>	
								<div class="col-md-4">
									<label class="control-label"><b>Reson</b></label>
									<div class="">
                                        <input type="text" class="form-control" name="reson" id="reson" placeholder="Reson" value="<?php echo $expense[0]->reson;?>" />
										<div class="invalid-feedback" id="resonerror" style="color: red;"></div>
                                   	</div>
								</div>	
								<div class="col-md-4" style="padding-top: 24px;">
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update</button>
									</div>
								</div>
								</div>
								
						   </div>
						</div>
						
				<!-- switches -->
			<div class="switches">
				</form>
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

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js')?>"></script>

<script>
			
$(document).ready(function(){ 

	$("#start_date").blur(function(){
		 var loc = $("#start_date").val();
                            if(loc == ""){
         $("#start_date_error").html("Start date is required.");
                      }
                      else{
							     $("#start_date_error").html('');
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
         var amount = document.forms["savingdata"]["amount"].value;
         var reson = document.forms["savingdata"]["reson"].value;
  
         var temp = 0;
       if(amount == ""){
            $("#amounterror").html("amount is required.");
            temp++;
        }
        if(reson == ""){
            $("#resonerror").html("reson is required.");
            temp++;
        }
        if(temp != 0){
        			 return false;     
        }
    }
	</script>