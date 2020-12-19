
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
								<h3 class="blank1" style="margin-top: -20px;">Density record report</h3>
	 								
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
						<form class="form-horizontal" method="post" action="<?php echo base_url();?>company_daily_density_report/update?date=<?php echo $this->input->get('date'); ?>&sdate=<?php echo $this->input->get('sdate'); ?>&edate=<?php echo $this->input->get('edate'); ?>&location=<?php echo $this->input->get('location'); ?>&type=<?php echo $this->input->get('type'); ?>&tank=<?php echo $this->input->get('tank'); ?>" name="savingdata" onsubmit="return validate()" enctype="multipart/form-data">
						 <?php $detail = $reports[0]; ?>
						 <div class="md tabls">
							<div class="bs-example4" data-example-id="contextual-table" style="display:  inline-block;width: 100%;">
								<div class="col-md-4">
									<label class="control-label"><b>Hydro Reading</b></label>
									<div class="">
										<input type="text" class="form-control" name="hydro_reading" placeholder="Hydro Reading" value="<?php echo $detail->hydro_reading; ?>" />
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Hydro Reading Temp</b></label>
									<div class="">
										<input type="text" class="form-control" name="hydro_reading_temp" placeholder="Hydro Reading Temp" value="<?php echo $detail->temp; ?>" />
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Hydro Reading Converted</b></label>
									<div class="">
										<input type="text" class="form-control" name="hydro_reading_converted" placeholder="Hydro Reading Converted" value="<?php echo $detail->density; ?>" />
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Challan No</b></label>
									<div class="">
										<input type="text" class="form-control" name="challan_no" placeholder="Challan No" value="<?php
					echo $detail->inventoryData->invoice_no; 
					?>" />
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Quantity</b></label>
									<div class="">
										<input type="text" class="form-control" name="quantity" placeholder="quantity" value="<?php if($type == 'p'){
						echo $detail->inventoryData->p_quantity; 
					}else{
						echo $detail->inventoryData->d_quantity;
					}?>" />
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Density Per Challan</b></label>
									<div class="">
										<input type="text" class="form-control" name="density_per_challan" placeholder="quantity" value="<?php if($type == 'p'){
						echo $detail->inventoryData->p_invoice_density; 
					}else{
						echo $detail->inventoryData->d_invoice_density;
					}?>" />
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Observed Density In Tank Truck</b></label>
									<div class="">
										<input type="text" class="form-control" name="observed_density_in_tank_truck" placeholder="Observed Density In Tank Truck" value="<?php if($type == 'p'){
						echo $detail->inventoryData->p_observer_density; 
					}else{
						echo $detail->inventoryData->d_observer_density;
					}?>" />
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Hydrometer Reading</b></label>
									<div class="">
										<input type="text" class="form-control" name="hydrometer_reading" placeholder="Hydrometer Reading" value="<?php if($type == 'p'){
						echo $detail->daily_density->p_decant_hydro_reading; 
					}else{
						echo $detail->daily_density->d_decant_hydro_reading;
					}?>" />
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Hydrometer Reading Temp</b></label>
									<div class="">
										<input type="text" class="form-control" name="hydrometer_reading_temp" placeholder="Hydrometer Reading Temp" value="<?php if($type == 'p'){
						echo $detail->daily_density->p_decant_temp; 
					}else{
						echo $detail->daily_density->d_decant_temp;
					}?>" />
                                   	</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"><b>Hydrometer Reading Converted</b></label>
									<div class="">
										<input type="text" class="form-control" name="hydrometer_reading_converted" placeholder="Hydrometer Reading Converted" value="<?php if($type == 'p'){
						echo $detail->daily_density->p_decant_density; 
					}else{
						echo $detail->daily_density->d_decant_density;
					}?>" />
                                   	</div>
								</div>
								<div class="col-md-4" style="padding-top: 24px;">
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-success btn" type="submit" name="submit">Update</button>
										<a href="#" onclick="window.history.back();">Back</a>
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
         var expensetype = document.forms["savingdata"]["expensetype"].value;
  
         var temp = 0;
       if(amount == ""){
            $("#amounterror").html("amount is required.");
            temp++;
        }
        if(reson == ""){
            $("#resonerror").html("reson is required.");
            temp++;
        }
		if(expensetype == ""){
            $("#expensetypeerror").html("Expense type is required.");
            temp++;
        }
        if(temp != 0){
        			 return false;     
        }
    }
	</script>