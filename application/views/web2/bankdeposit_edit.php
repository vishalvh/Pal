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
								<h3 class="blank1" style="margin-top: -20px;">Bank Deposit Edit</h3>
	 								
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
							$name = $bd[0]->UserFName;
						?>
						 <div class="md tabls">
						 <form class="form-horizontal" method="post" action="<?php echo base_url();?>bank_deposit/bankdeposit_edit/<?php echo $id;?>" name="savingdata" onsubmit="return validate()">
							<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
								<div class="col-md-4">
								<div class="col-md-4">
									<label class="control-label"><b>Date</b></label>
									</div>
									<div class="col-sm-8">
									<label class="control-label"><?php echo date('d-m-Y', strtotime($bd[0]->date));?></label>
										
										<?php echo form_error('date','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="dateerror" style="color: red;"></div>
									</div>
									
								</div>
								<div class="col-md-4">
								<div class="col-md-4">
									<label class="control-label"><b>Name</b></label>
									</div>
									<div class="col-sm-8">
									<label class="control-label"><?php echo ucfirst($name);?></label>
										
										<?php echo form_error('date','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="dateerror" style="color: red;"></div>
									</div>
									
								</div>
								<div class="col-md-4">
								<div class="col-md-4">
									<label class="control-label"><b>Location</b></label>
									</div>
									<div class="col-sm-8">
									<label class="control-label"><?php echo $bd[0]->l_name;?></label>
										
										<?php echo form_error('l_name','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="l_name_error" style="color: red;"></div>
									</div>
									
								</div>
										
								<div class="col-md-12" style="margin-top: 15px;">
								<div class="col-md-2">
									<label class="control-label"><b>Deposit Amount</b></label>
									</div>
								<div class="col-sm-4">
								<input  id="deposit_amount" type="text" class="form-control1 "  placeholder="Deposit Amount" name="deposit_amount" value="<?php echo $bd[0]->deposit_amount;?>">
										<?php echo form_error('date','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="deposit_amount_error" style="color: red;"></div>
                                      
                                   	</div>
									</div>
									<div class="col-md-12" style="margin-top: 15px;">
								<div class="col-md-2">
									<label class="control-label"><b>Withdraw Amount</b></label>
									</div>
								<div class="col-sm-4">
								<input  id="withdraw_amount" type="text" class="form-control1 "  placeholder="Withdraw Amount" name="withdraw_amount" value="<?php echo $bd[0]->withdraw_amount;?>">
								
										<?php echo form_error('withdraw_amount','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="withdraw_amount_error" style="color: red;"></div>
                                      
                                   	</div>
									</div>
									<div class="col-md-12" style="margin-top: 15px;">
								<div class="col-md-2">
									<label class="control-label"><b>Deposited By</b></label>
									</div>
								<div class="col-sm-4">
								<select name="deposited_by" id="deposited_by" class="form-control1 " > 
								<option value="n"<?php  if ($bd[0]->deposited_by == 'n') 
                                   		{
				echo "selected";
                                   		} ?> >Cash</option>
								<option value="c" <?php  if ($bd[0]->deposited_by == 'c') 
                                   		{
				echo "selected";
                                   		} ?> >Cheque</option>
								</select>
										<?php echo form_error('withdraw_amount','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="deposited_by_error" style="color: red;"></div>
                                      
                                   	</div>
									</div>
                                   	<div class="col-md-12" id="Cheque_Number" style="margin-top: 15px;">
								<div class="col-md-2" >
									<label class="control-label"><b>Cheque Number</b></label>
									</div>
								<div class="col-sm-4">
								<input  id="cheque" type="text" class="form-control1 "  placeholder="Cheque No" name="cheque_no" value="<?php echo $bd[0]->cheque_no;?>">
								
										<?php echo form_error('cheque_no','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="chequeerror" style="color: red;"></div>
                                      
                                   	</div>
									</div>
                                   <br>
								   <div>
								

								</div>
                            <div class="form-group" class="col-md-12" style="
    padding-top:  10px;
    padding-right: 15px;
" >
							<br>
									<div class="col-sm-8 col-sm-offset-2" style="
    padding-top:  10px;
    padding-right: 15px;
">
										<button style="
    padding-top:  10px;
    padding-right: 15px;
" class="btn-success btn" type="submit" name="submit">Update</button>
									</div>
								</div>
</div>
								
								</form>
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

<script src="<?php echo base_url('assets1/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets1/datatables/js/jquery.dataTables.min.js')?>"></script>
<script>
		
    $('#Cheque_Number').hide(); 
    $('#deposited_by').change(function(){
        if($('#deposited_by').val() == 'c') {
            $('#Cheque_Number').show(); 
        } else {
            $('#Cheque_Number').hide(); 
        } 
    });

$(document).ready(function(){ 

	if($('#deposited_by').val() == 'c') {
            $('#Cheque_Number').show(); 
        } else {
            $('#Cheque_Number').hide(); 
        } 
    


	$("#deposit_amount").blur(function(){
		 var deposit_amount = $("#deposit_amount").val();
                            if(name == ""){
         $("#deposit_amount_error").html("Deposit Amount is required.");
                      }
                      else{
							     $("#deposit_amount_error").html('');
                            }
    }
					);
	
	$("#withdraw_amount").blur(function(){
		 var withdraw_amount = $("#withdraw_amount").val();
                            if(withdraw_amount == ""){
         $("#withdraw_amount_error").html("Withdraw Amount is required.");
                      }
                      else{
							     $("#withdraw_amount_error").html('');
                            }
    }
					);
	
	$("#deposited_by").blur(function(){
		 var deposited_by = $("#deposited_by").val();
                            if(deposited_by == ""){
         $(deposited_by_error).html("Deposited by is required.");
                      }
                      else{
							     $("#deposited_by_error").html('');
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


});	
function validate(){
        var deposit_amount = document.forms["savingdata"]["deposit_amount"].value;
        var withdraw_amount = document.forms["savingdata"]["withdraw_amount"].value;
        var deposited_by = document.forms["savingdata"]["deposited_by"].value;
        var cheque = document.forms["savingdata"]["cheque"].value;
        var temp = 0;
       if(deposit_amount == ""){
           $("#deposit_amount_error").html("Deposit Amount is required.");
            temp++;
        }
        if(withdraw_amount == ""){
           $("#withdraw_amount_error").html("Withdraw Amount is required.");
            temp++;
        }
        if(deposited_by == ""){
        $(deposited_by_error).html("Deposited by is required.");
            temp++;
        }
		if(deposited_by == 'c'){
			 if(cheque == ""){
            $("#chequeerror").html("Cheque Number is required.");
            temp++;
        }
		}
       
      
        
        if(temp != 0){
        			 return false;     
        }
    }
	</script>
