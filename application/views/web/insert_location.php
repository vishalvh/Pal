
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
									<label for="focusedinput" class="col-sm-2 control-label">Bank Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="bankname" placeholder="Bank name" name="bankname" value="<?php echo set_value('bankname');?>">
										<?php echo form_error('bankname' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">A/C No.</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="acno" placeholder="Bank Account No." name="acno" value="<?php echo set_value('acno');?>">
										<?php echo form_error('acno' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">A/C Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="acname" placeholder="Bank account owner name" name="acname" value="<?php echo set_value('acname');?>">
										<?php echo form_error('acname' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Branch Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="branchname" placeholder="Branch Name" name="branchname" value="<?php echo set_value('branchname');?>">
										<?php echo form_error('branchname' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">IFSC Code.</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="ifsccode" placeholder="IFSC Code." name="ifsccode" value="<?php echo set_value('ifsccode');?>">
										<?php echo form_error('ifsccode' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Finance Charge</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="fcharge" placeholder="Finance Charge" name="fcharge" value="<?php echo set_value('fcharge');?>">
										<?php echo form_error('fcharge' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										
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
									<label for="focusedinput" class="col-sm-2 control-label">Extra Premium</label>
									<div class="col-sm-8">
										<input type ="checkbox" name="xtrapremium" id="xtrapremium" value = "Yes" onclick="checkXpValue()">
									</div>
								</div>
								<div class="form-group xpdiv" style="display:none">
									<label for="focusedinput" class="col-sm-2 control-label">Extra Premium Petrol</label>
									<div class="col-sm-8">
										<input type ="checkbox" name="xpp_type" value = "Yes">
									</div>
								</div>
								<div class="form-group xpdiv" style="display:none">
									<label for="focusedinput" class="col-sm-2 control-label">Extra Premium Diesel</label>
									<div class="col-sm-8">
										<input type ="checkbox" name="xpd_type" value = "Yes">
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
function checkXpValue(){
	if($("#xtrapremium").prop('checked') == true){
	   $(".xpdiv").show();
	}else{
		$(".xpdiv").hide();
	}
}
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