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
					<h3 class="blank1">User Profile</h3>
						<div class="tab-content">

							<?php if ($this->session->flashdata('update_profile')) { ?>
							   <div class="alert alert-success alert-dismissable" style="max-width: 64%;margin-left: 18%;">
								   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								   <?php echo $this->session->flashdata('update_profile'); ?>
							   </div>
							<?php } ?>

						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>madetor/update_profile" name="savingdata" onsubmit="return validate()">
								<div class="form-group"> 
									<label for="focusedinput" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="name" placeholder="Name" name="username" value="<?php echo  $_SESSION['logged_company']['name'];?>">
										<?php echo form_error('username' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="nameerror" style="color: red;"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Mobile No</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="mobile" placeholder="Mobile Number" name="mobile" value="<?php echo  $_SESSION['logged_company']['mobile'];?>">
										<?php echo form_error('mobile' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>'); ?>
										<div class="invalid-feedback" id="mobileerror" style="color: red;"></div>										
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Email Address</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="email" placeholder="Email Address" name="email" value="<?php echo  $_SESSION['logged_company']['email'];?>">
										<?php echo form_error('email' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="emailerror" style="color: red;"></div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update Profile</button>
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
       
        var temp = 0;
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
	
		
	 	
        if(temp != 0){
        			 return false;     
        }
    }
	
</script>