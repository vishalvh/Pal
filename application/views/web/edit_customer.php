	
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
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>manage_customer/customer_update/<?php echo $id;?>/<?php echo $this->uri->segment('4');?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo $this->uri->segment('3');?>">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="usernameval" placeholder="Username" name="username" value="<?php echo $r[0]->name;?>">
										<?php echo form_error('username','<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>' );?>
											<div class="invalid-feedback" id="usernameerror" style="color: red;"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Address</label>
									<div class="col-sm-8">
										<textarea class="form-control1" id="address" placeholder="Enter Your Address" name="address"><?php echo $r[0]->address;?></textarea>
										
										<?php echo form_error('address' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="addresserror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Phone Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="phone" placeholder="Phone Number" name="phone" value="<?php echo $r[0]->phone_no;?>">
										<?php echo form_error('phone' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="phoneerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Cheque Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="cheque" placeholder="Cheque Number" name="cheque" value="<?php echo $r[0]->cheque_no;?>">
										<?php echo form_error('cheque' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="chequeerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Bank Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="bank" placeholder="Bank Name" name="bank" value="<?php echo $r[0]->bank_name;?>">
										<?php echo form_error('bank' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="bankerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Cheque Copy</label>
									<div class="col-sm-8">
										<input type="file" class="" id="img" placeholder="Image" name="img" >
										<div class="invalid-feedback" id="imgerror" style="color: red;"></div>
										<?php if($r[0]->img != "" ){ ?>
										<br>
	<a href = "<?php echo base_url(); ?>/uploads/<?php echo $r[0]->img; ?>" target="_blank">Open</a>
<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Gst Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="gst_number" placeholder="Gst Number" name="gst_number" value="<?php echo $r[0]->gst_number;?>">
										<?php echo form_error('gst_number' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="gsterror" style="color: red;"></div>
										
									</div>
								</div>
								
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">GST Copy</label>
									<div class="col-sm-8">
										<input type="file" class="" id="gstimg" placeholder="Image" name="gstimg" >
										<div class="invalid-feedback" id="gstimgerror" style="color: red;"></div>
										<?php if($r[0]->gstimg != "" ){ ?>
										<a href = "<?php echo base_url(); ?>/uploads/<?php echo $r[0]->gstimg; ?>" target="_blank">Open</a>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Pan Card Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="pan_number" placeholder="Pan Card Number" name="pan_number" value="<?php echo $r[0]->pan_number;?>">
										<?php echo form_error('pan_number' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="panerror" style="color: red;"></div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Pan Card Copy</label>
									<div class="col-sm-8">
										<input type="file" class="" id="panimg" placeholder="Image" name="panimg" >
										<div class="invalid-feedback" id="panimgerror" style="color: red;"></div>
										<?php if($r[0]->panimg != "" ){ ?>
										<a href = "<?php echo base_url(); ?>/uploads/<?php echo $r[0]->panimg; ?>" target="_blank">Open</a>
										<?php } ?>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">personal guarantor</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="personal_guarantor" placeholder="Personal Guarantor" name="personal_guarantor" value="<?php echo $r[0]->personal_guarantor;?>">
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
										foreach ($r1 as $row) {
												?>
													<option value="<?php echo $row->l_id?>" 
														<?php
															if($row->l_id == $r[0]->location_id )
																{ 
																	echo "selected"; 
																}
														?> > <?php echo $row->l_name?></option>
												<?php
											}
										?>
										
									</select><div class="invalid-feedback" id="locationerror" style="color: red;"></div></div>
								</div>
								<?php //if($_GET['debug'] == '1'){ ?>
								<hr>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Contact Person 1 Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="" placeholder="Contact Person 1 Name" name="contactpersonname1" value="<?php if(isset($contactperson[0]->name)){ echo $contactperson[0]->name; }?>">
										<?php echo form_error('contactpersonname1' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Contact Person 1 Phone</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="" placeholder="Contact Person 1 Phone" name="contactpersonphone1" value="<?php if(isset($contactperson[0]->phone)){ echo $contactperson[0]->phone; }?>">
										<?php echo form_error('contactpersonphone1' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Contact Person 2 Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="" placeholder="Contact Person 2 Name" name="contactpersonname2" value="<?php if(isset($contactperson[1]->name)){ echo $contactperson[1]->name; }?>">
										<?php echo form_error('contactpersonname2' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Contact Person 2 Phone</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="" placeholder="Contact Person 2 Phone" name="contactpersonphone2" value="<?php if(isset($contactperson[1]->phone)){ echo $contactperson[1]->phone; }?>">
										<?php echo form_error('contactpersonphone2' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
									</div>
								</div>
								<?php //} ?>
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