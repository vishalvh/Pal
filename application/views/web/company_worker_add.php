
    <!-- left side start-->
		<?php $this->load->view('web/left');?>
		<!-- left side end-->
    
		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<script src='<?php echo base_url(); ?>design/js/jquery-ui.min.js' type='text/javascript'></script>
			<?php $this->load->view('web/header');?>
		<!-- //header-ends -->
			<div id="page-wrapper">
				<div class="graphs">
					<h3 class="blank1">Add Worker</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>company_worker/insert" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Code</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="code" placeholder="Name" name="code" value="<?php echo set_value('code');?>">
										<?php echo form_error('code' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="codeerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="name" placeholder="Name" name="name" value="<?php echo set_value('name');?>">
										<?php echo form_error('name' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="nameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Address</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="address" placeholder="Address" name="address" value="<?php echo set_value('address');?>">
										<?php echo form_error('address' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="addresserror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Salary</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="salary" placeholder="Salary" name="salary" value="<?php echo set_value('salary');?>">
										<?php echo form_error('salary' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="salaryerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Extra Salary</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="extra_salary" placeholder="Salary" name="extra_salary" value="<?php echo set_value('extra_salary');?>">
										<?php echo form_error('extra_salary' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Mobile No</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="mobileval" placeholder="Mobile Number" name="mobile" value="<?php echo set_value('mobile');?>">
										<?php echo form_error('mobile' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>'); ?>
										<div class="invalid-feedback" id="mobileerror" style="color: red;"></div>										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Adhar Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="adharnumber" placeholder="Adhar Number" name="adharnumber" value="<?php echo set_value('adharnumber');?>">
										<?php echo form_error('adharnumber' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="adharnumbererror" style="color: red;"></div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Select Location</label>
									<div class="col-sm-8">
										<select name="sel_loc" id="location" class="form-control1">
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
									<label for="selector1" class="col-sm-2 control-label">Select Shift</label>
									<div class="col-sm-8">
										<select name="shift" id="shift" class="form-control1">
										<option value="">Select Shift</option>
										<option value="1">Day</option>
										<option value="2">Night</option>
										<option value="3">24 hours</option>
									</select><div class="invalid-feedback" id="shifterror" style="color: red;"></div></div>
								</div>
								
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Join Date</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="joindate" placeholder="DD-MM-YYYY" name="joindate" value="<?php echo set_value('joindate');?>">
										<?php echo form_error('joindate' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="joindateererror" style="color: red;"></div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="selector1" class="col-sm-2 control-label">Image</label>
									<div class="col-sm-8">
										<input type="file" class="" id="img" placeholder="Image" name="img" >
										<div class="invalid-feedback" id="imgerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Register</button>
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
$(document).ready(function () {
       $("#joindate").datepicker({
           dateFormat: "dd-mm-yy",
		   	changeMonth: true,
          changeYear: true,
		   yearRange: "2017:n",
		  maxDate:new Date(),
       });
   });
function validate(){
         var name = document.forms["savingdata"]["name"].value;
         var mobile = document.forms["savingdata"]["mobile"].value;
         var adharnumber = document.forms["savingdata"]["adharnumber"].value;
         var salary = document.forms["savingdata"]["salary"].value;
         var location = document.forms["savingdata"]["location"].value;
       	 var shift = document.forms["savingdata"]["shift"].value;
         var address = document.forms["savingdata"]["address"].value;  
		var code = document.forms["savingdata"]["code"].value;
var img = document.forms["savingdata"]["img"].value;		
var joindate = document.forms["savingdata"]["joindate"].value;		
        var temp = 0;
		if(code == ""){
            $("#codeerror").html("Code is required.");
            temp++;
        }
		if(joindate == ""){
            $("#joindaterror").html("Join date is required.");
            temp++;
        }
		if(address == ""){
            $("#addresserror").html("Address is required.");
            temp++;
        }
       if(name == ""){
            $("#nameerror").html("Name is required.");
            temp++;
        }if(mobile == ""){
            $("#mobileerror").html("Mobile Number is required.");
            temp++;
        }
        if(adharnumber == ""){
            $("#adharnumbererror").html("Adhar Number is required.");
            temp++;
        }
	if(salary == ""){
            $("#salaryerror").html("Salary is required.");
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