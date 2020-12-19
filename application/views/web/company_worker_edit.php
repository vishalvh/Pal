
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
					<h3 class="blank1">Edit Worker</h3>
						<div class="tab-content">

							<?php if ($this->session->flashdata('update_profile')) { ?>
							   <div class="alert alert-success alert-dismissable" style="max-width: 64%;margin-left: 18%;">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('update_profile'); ?>
							   </div>
							<?php } ?>

						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>company_worker/update/<?php echo $detail->id; ?>/<?php  echo $this->uri->segment('4'); ?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Code</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="code" placeholder="Name" name="code" value="<?php echo $detail->code; ?>">
										<?php echo form_error('code' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="codeerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="name" placeholder="Name" name="name" value="<?php echo $detail->name; ?>">
										<?php echo form_error('name' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="nameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Address</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="address" placeholder="Address" name="address" value="<?php echo $detail->address; ?>">
										<?php echo form_error('address' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="addresserror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Salary</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="salary" placeholder="Salary" name="salary" value="<?php echo $detail->salary; ?>">
										<?php echo form_error('salary' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="salaryerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Extra Salary</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="extra_salary" placeholder="Salary" name="extra_salary" value="<?php echo $detail->extra_salary; ?>">
										<?php echo form_error('extra_salary' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Mobile No</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="mobile" placeholder="Mobile Number" name="mobile" value="<?php echo $detail->mobile; ?>">
										<?php echo form_error('mobile' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>'); ?>
										<div class="invalid-feedback" id="mobileerror" style="color: red;"></div>										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Adhar Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="adharnumber" placeholder="Adhar Number" name="adharnumber" value="<?php echo $detail->adhar_no; ?>">
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
													<option <?php if($row->l_id==$detail->location_id){ echo "selected"; } ?> value="<?php echo $row->l_id?>"><?php echo $row->l_name?></option>
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
										<option value="1" <?php if('1'==$detail->shift){ echo "selected"; } ?> >Day</option>
										<option value="2" <?php if('2'==$detail->shift){ echo "selected"; } ?> >Night</option>
										<option value="3" <?php if('3'==$detail->shift){ echo "selected"; } ?> >24 hours</option>
									</select><div class="invalid-feedback" id="shifterror" style="color: red;"></div></div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Join Date</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="joindate" placeholder="DD-MM-YYYY" name="joindate" value="<?php if($detail->join_date != ""){ echo date('d-m-Y',strtotime($detail->join_date)); } ?>">
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
									<label for="selector1" class="col-sm-2 control-label"></label>
									<div class="col-sm-8">
										<img src="<?php echo base_url();?>uploads/<?php echo $detail->img; ?>" height="150px">
									</div>
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

<script type="text/javascript">
	$(document).ready(function(){ 

       $("#joindate").datepicker({
           dateFormat: "dd-mm-yy",
		   	changeMonth: true,
          changeYear: true,
		   yearRange: "2017:n",
		  maxDate:new Date(),
       });
   
	$("#name").blur(function(){
		 var name = $("#name").val();
                            if(name == ""){
         $("#nameerror").html("Name is required.");
                      }
                      else{
							     $("#nameerror").html('');
                            }
    }
					);
	$("#mobile").blur(function(){
		 var mobile = $("#mobile").val();
                            if(mobile == ""){
         $("#mobileerror").html("Mobile Number is required.");
                      }
                      else{
							     $("#mobileerror").html('');
                            }
    }
					);
	$("#email").blur(function(){
		 var email = $("#email").val();
                            if(email == ""){
         $("#emailerror").html("Email Id is required.");
                      }
                      else{
							     $("#emailerror").html('');
                            }
    }
					);
});
	
	function validate(){
         var name = document.forms["savingdata"]["name"].value;
         var mobile = document.forms["savingdata"]["mobile"].value;
         var email = document.forms["savingdata"]["email"].value;
       
        var code = document.forms["savingdata"]["code"].value; 
		var joindate = document.forms["savingdata"]["joindate"].value;
if(joindate == ""){
            $("#joindaterror").html("Join date is required.");
            temp++;
        }
        var temp = 0;
		if(code == ""){
            $("#codeerror").html("Code is required.");
            temp++;
        }
       if(name == ""){
            $("#nameerror").html("Name is required.");
            temp++;
        }if(mobile == ""){
            $("#mobileerror").html("Mobile Number is required.");
            temp++;
        }
        
	if(email == ""){
            $("#emailerror").html("Email Id is required.");
            temp++;
        }
	alert(temp++);
		 return false; 
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	
</script>