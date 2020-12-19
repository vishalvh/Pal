
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
					<h3 class="blank1">Update Vat Data</h3>
						<div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" method="post" action="<?php echo base_url();?>vat/update/<?php echo $id;?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo $this->uri->segment('3');?>">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date</label>
									<div class="col-sm-8">
                                                                            <input type="text" class="form-control1" name="date" readonly="readonly" value="<?php echo date('d-m-Y', strtotime($r->date));?>">
											<div class="invalid-feedback" id="locationerror" style="color: red;"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Vat</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="vat_per" placeholder="Enter vat" name="vat_per" value="<?php echo $r->vat_per;?>">
										<?php echo form_error('address' ,'<div class="error" style="color:red;padding-bottom: 0px;padding-top: 0px;">','</div>');?>
										<div class="invalid-feedback" id="addresserror" style="color: red;"></div>
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

<script>
			
$(document).ready(function(){ 

	$("#location").blur(function(){
		 var loc = $("#location").val();
                            if(loc == ""){
         $("#locationerror").html("Location is required.");
                      }
                      else{
							     $("#locationerror").html('');
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
         var loc = document.forms["savingdata"]["location"].value;
         var add = document.forms["savingdata"]["address"].value;
         var mob = document.forms["savingdata"]["mobile"].value;
         var temp = 0;
       if(loc == ""){
            $("#locationerror").html("Location is required.");
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